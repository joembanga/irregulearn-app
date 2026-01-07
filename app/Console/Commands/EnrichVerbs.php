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
    function fetchWordDetails($word)
    {
        // 1. Try DictionaryAPI.dev first
        $url1 = "https://api.dictionaryapi.dev/api/v2/entries/en/" . urlencode($word);
        $response1 = $this->executeCurl($url1);

        if ($response1) {
            $data = json_decode($response1, true);

            if (isset($data[0])) {
                $result = $this->parseDictionaryApiDev($data[0]);
                // If we found data, return it. Otherwise fall through to backup API.
                if ($result['phonetic'] || $result['source_url'] || !empty($result['verb_definitions'])) {
                    $result['source_api'] = 'https://dictionaryapi.dev/';
                    return $result;
                }
            }
        }

        // 2. Try FreeDictionaryAPI as fallback
        $url2 = "https://freedictionaryapi.com/api/v1/entries/en/" . urlencode($word);
        $response2 = $this->executeCurl($url2);

        if ($response2) {
            $data = json_decode($response2, true);

            if (isset($data['entries'])) { // Validating FreeDictionaryAPI structure
                $result = $this->parseFreeDictionaryApi($data);
                if ($result['phonetic'] || $result['source_url'] || !empty($result['verb_definitions'])) {
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
    function parseDictionaryApiDev($entry)
    {
        $phonetic = null;
        $sourceUrl = null;
        $verbDefs = [];

        // 1. Extract Phonetic
        if (isset($entry['phonetic'])) {
            $phonetic = $entry['phonetic'];
        } elseif (isset($entry['phonetics'])) {
            foreach ($entry['phonetics'] as $p) {
                if (isset($p['text'])) {
                    $phonetic = $p['text'];
                    break;
                }
            }
        }

        // 2. Extract Source URL
        if (isset($entry['sourceUrls'][0])) {
            $sourceUrl = $entry['sourceUrls'][0];
        }

        // 3. Extract Verb Definitions
        if (isset($entry['meanings'])) {
            foreach ($entry['meanings'] as $meaning) {
                if (isset($meaning['partOfSpeech']) && $meaning['partOfSpeech'] === 'verb') {
                    if (isset($meaning['definitions'])) {
                        if (count($meaning['definitions']) <= 3) {
                            foreach ($meaning['definitions'] as $defItem) {
                                if (isset($defItem['definition'])) {
                                    $verbDefs[] = $defItem['definition'];
                                }
                            }
                        } else {
                            $accepted = array_slice($meaning['definitions'], 0, 3, true);
                            foreach ($accepted as $defItem) {
                                if (isset($defItem['definition'])) {
                                    $verbDefs[] = $defItem['definition'];
                                }
                            }
                        }
                    }
                    break;
                }
            }
        }

        return [
            'phonetic' => $phonetic,
            'source_url' => $sourceUrl,
            'verb_definitions' => $verbDefs
        ];
    }

    /**
     * Logic to parse FreeDictionaryAPI.com JSON structure
     */
    function parseFreeDictionaryApi($data)
    {
        $phonetic = null;
        $sourceUrl = null;
        $verbDefs = [];

        // 1. Extract Phonetic (from the first entry)
        if (isset($data['entries'][0]['pronunciations'])) {
            foreach ($data['entries'][0]['pronunciations'] as $pronunciation) {
                if (isset($pronunciation['text'])) {
                    $phonetic = $pronunciation['text'];
                    break;
                }
            }
        }

        // 2. Extract Source URL
        if (isset($data['source']['url'])) {
            $sourceUrl = $data['source']['url'];
        }

        // 3. Extract Verb Definitions (iterate all entries to find verbs)
        if (isset($data['entries'])) {
            foreach ($data['entries'] as $entry) {
                if (isset($entry['partOfSpeech']) && $entry['partOfSpeech'] === 'verb') {
                    if (isset($entry['senses'])) {
                        if (count($entry['senses']) <= 3) {
                            foreach ($entry['senses'] as $sense) {
                                if (isset($sense['definition'])) {
                                    $verbDefs[] = $sense['definition'];
                                }
                            }
                        } else {
                            $accepted = array_slice($entry['senses'], 0, 3, true);
                            foreach ($accepted as $sense) {
                                if (isset($sense['definition'])) {
                                    $verbDefs[] = $sense['definition'];
                                }
                            }
                        }
                    }
                }
                break;
            }
        }

        return [
            'phonetic' => $phonetic,
            'source_url' => $sourceUrl,
            'verb_definitions' => $verbDefs
        ];
    }

    /**
     * Helper function to execute cURL requests
     */
    function executeCurl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        // User agent is polite to API providers
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (WordFetcher/1.0)');

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode === 200) {
            return $response;
        }

        return null;
    }
}
