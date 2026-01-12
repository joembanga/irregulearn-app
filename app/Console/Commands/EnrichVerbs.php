<?php

namespace App\Console\Commands;

use App\Models\Verb;
use Illuminate\Console\Command;

class EnrichVerbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verbs:enrich';

    protected $description = 'Fetch definitions for verbs from external APIs';

    public function handle()
    {
        $verbs = Verb::whereNull('description')->get();
        $count = $verbs->count();
        $this->info("Found {$count} verbs to enrich.");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($verbs as $verb) {
            $details = $this->fetchWordDetails($verb->infinitive);

            if ($details) {
                $verb->update([
                    'source_url' => $details['source_url'],
                    'phonetic' => $details['phonetic'],
                    'details_origin' => $details['source_api'],
                    'description' => $details['verb_definitions'],
                ]);
            }

            $bar->advance();
            // Sleep slightly to respect API rate limits (though these APIs are generous)
            usleep(200000);
        }

        $bar->finish();
        $this->newLine();
        $this->info('Verbs enriched successfully!');
    }

    /**
     * Fetch word details from multiple APIs
     */
    private function fetchWordDetails($word)
    {
        // 1. Try DictionaryAPI.dev first
        return $this->tryDictionaryApiDev($word) ?? $this->tryFreeDictionaryApi($word);
    }

    private function tryDictionaryApiDev($word)
    {
        $url = 'https://api.dictionaryapi.dev/api/v2/entries/en/'.urlencode($word);
        $response = $this->executeCurl($url);

        if ($response) {
            $data = json_decode($response, true);
            if (isset($data[0])) {
                $result = $this->parseDictionaryApiDev($data[0]);
                if ($result['phonetic'] || $result['source_url'] || ! empty($result['verb_definitions'])) {
                    $result['source_api'] = 'https://dictionaryapi.dev/';

                    return $result;
                }
            }
        }

        return null;
    }

    private function tryFreeDictionaryApi($word)
    {
        $url = 'https://freedictionaryapi.com/api/v1/entries/en/'.urlencode($word);
        $response = $this->executeCurl($url);

        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['entries'])) {
                $result = $this->parseFreeDictionaryApi($data);
                if ($result['phonetic'] || $result['source_url'] || ! empty($result['verb_definitions'])) {
                    $result['source_api'] = 'https://freedictionaryapi.com/';

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
        return [
            'phonetic' => $this->extractPhoneticDictionaryApi($entry),
            'source_url' => $this->extractSourceUrlDictionaryApi($entry),
            'verb_definitions' => $this->extractVerbDefinitionsDictionaryApi($entry),
        ];
    }

    private function extractPhoneticDictionaryApi($entry)
    {
        if (isset($entry['phonetic'])) {
            return $entry['phonetic'];
        }

        if (isset($entry['phonetics'])) {
            foreach ($entry['phonetics'] as $p) {
                if (isset($p['text'])) {
                    return $p['text'];
                }
            }
        }

        return null;
    }

    private function extractSourceUrlDictionaryApi($entry)
    {
        return $entry['sourceUrls'][0] ?? null;
    }

    private function extractVerbDefinitionsDictionaryApi($entry)
    {
        $verbDefs = [];
        if (! isset($entry['meanings'])) {
            return $verbDefs;
        }

        foreach ($entry['meanings'] as $meaning) {
            if (
                isset($meaning['partOfSpeech']) &&
                $meaning['partOfSpeech'] === 'verb' &&
                isset($meaning['definitions'])
            ) {
                $count = count($meaning['definitions']);
                $definitions = $count <= 3 ? $meaning['definitions'] : array_slice($meaning['definitions'], 0, 3, true);

                foreach ($definitions as $defItem) {
                    if (isset($defItem['definition'])) {
                        $verbDefs[] = $defItem['definition'];
                    }
                }
                break;
            }
        }

        return $verbDefs;
    }

    /**
     * Logic to parse FreeDictionaryAPI.com JSON structure
     */
    private function parseFreeDictionaryApi($data)
    {
        return [
            'phonetic' => $this->extractPhoneticFreeDictionary($data),
            'source_url' => $data['source']['url'] ?? null,
            'verb_definitions' => $this->extractVerbDefinitionsFreeDictionary($data),
        ];
    }

    private function extractPhoneticFreeDictionary($data)
    {
        if (isset($data['entries'][0]['pronunciations'])) {
            foreach ($data['entries'][0]['pronunciations'] as $pronunciation) {
                if (isset($pronunciation['text'])) {
                    return $pronunciation['text'];
                }
            }
        }

        return null;
    }

    private function extractVerbDefinitionsFreeDictionary($data)
    {
        $verbDefs = [];
        if (! isset($data['entries'])) {
            return $verbDefs;
        }

        foreach ($data['entries'] as $entry) {
            if (isset($entry['partOfSpeech']) && $entry['partOfSpeech'] === 'verb' && isset($entry['senses'])) {
                $count = count($entry['senses']);
                $senses = $count <= 3 ? $entry['senses'] : array_slice($entry['senses'], 0, 3, true);

                foreach ($senses as $sense) {
                    if (isset($sense['definition'])) {
                        $verbDefs[] = $sense['definition'];
                    }
                }
                break;
            }
        }

        return $verbDefs;
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
