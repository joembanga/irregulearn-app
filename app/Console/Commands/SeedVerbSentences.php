<?php

namespace App\Console\Commands;

use App\Models\Verb;
use App\Models\VerbSentence;
use Illuminate\Console\Command;

class SeedVerbSentences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verbs:seed-verb-sentences';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $verbs = Verb::all();
        $count = $verbs->count();
        $this->info("Found {$count} verbs to enrich.");
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        foreach ($verbs as $verb) {
            $forms = ['infinitive', 'past_simple', 'past_participle'];
            foreach ($forms as $form) {
                $allForms = explode('/', $verb->{$form});
                foreach ($allForms as $oneForm) {
                    $example = $this->fetchWordDetails($oneForm);
                    if ($example) {
                        VerbSentence::create([
                            'verb_id' => $verb->id,
                            'sentence' => $example['example'],
                            'missing_word' => $oneForm,
                            'form' => $form,
                        ]);
                    }
                }
            }
            $bar->advance();
            // Sleep slightly to respect API rate limits (though these APIs are generous)
            usleep(200000);
        }

        $bar->finish();
        $this->newLine();
        $this->info('Examples added successfully!');
    }

    /**
     * Fetch word details from multiple APIs
     */
    private function fetchWordDetails($word)
    {
        // 1. Try DictionaryAPI.dev first
        $url1 = 'https://api.dictionaryapi.dev/api/v2/entries/en/'.urlencode($word);
        $response1 = $this->executeCurl($url1);

        if ($response1) {
            $data = json_decode($response1, true);
            if (isset($data[0])) {
                $result = $this->parseDictionaryApiDev($data[0]);
                if ($result['example']) {
                    return $result;
                }
            }
        }

        // 2. Try FreeDictionaryAPI as fallback
        $url2 = 'https://freedictionaryapi.com/api/v1/entries/en/'.urlencode($word);
        $response2 = $this->executeCurl($url2);

        if ($response2) {
            $data = json_decode($response2, true);
            if (isset($data['entries'])) {
                $result = $this->parseFreeDictionaryApi($data);
                if ($result['example']) {
                    return $result;
                }
            }
        }

        return null;
    }

    /**
     * Logic to parse DictionaryAPI.dev JSON structure
     */
    private function parseDictionaryApiDev($entry)
    {
        $example = null;

        if (! isset($entry['meanings']) || ! is_array($entry['meanings'])) {
            return ['example' => $example];
        }

        foreach ($entry['meanings'] as $meaning) {
            if (
                isset($meaning['partOfSpeech']) &&
                $meaning['partOfSpeech'] === 'verb' &&
                isset($meaning['definitions'])
            ) {
                foreach ($meaning['definitions'] as $def) {
                    if (isset($def['example']) && ! empty($def['example'])) {
                        if (str_contains(strtolower($def['example']), strtolower($entry['word']))) {
                            $example = $def['example'];
                            break 2;
                        }
                    }
                }
            }
        }

        return ['example' => $example];
    }

    /**
     * Logic to parse FreeDictionaryAPI.com JSON structure
     */
    private function parseFreeDictionaryApi($data)
    {
        $example = null;

        if (! isset($data['entries']) || ! is_array($data['entries'])) {
            return ['example' => $example];
        }

        foreach ($data['entries'] as $entry) {
            if (isset($entry['partOfSpeech']) && $entry['partOfSpeech'] === 'verb' && isset($entry['senses'])) {
                foreach ($entry['senses'] as $sense) {
                    if (isset($sense['examples']) && is_array($sense['examples'])) {
                        foreach ($sense['examples'] as $ex) {
                            if (str_contains(strtolower($ex), strtolower($data['word']))) {
                                $example = $ex;
                                break 3;
                            }
                        }
                    }
                }
            }
        }

        return ['example' => $example];
    }

    /**
     * Helper function to execute cURL requests
     */
    private function executeCurl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (WordFetcher/1.0)');

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $httpCode === 200 ? $response : null;
    }
}
