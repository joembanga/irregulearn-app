<?php

function fetchWordDetails($word)
{
    // 1. Try DictionaryAPI.dev first
    $url1 = "https://api.dictionaryapi.dev/api/v2/entries/en/" . urlencode($word);
    $response1 = executeCurl($url1);

    if ($response1) {
        $data = json_decode($response1, true);

        if (isset($data[0])) {
            $result = parseDictionaryApiDev($data[0]);
            // If we found data, return it. Otherwise fall through to backup API.
            if ($result['phonetic'] || $result['source_url'] || !empty($result['verb_definitions'])) {
                $result['source_api'] = 'dictionaryapi.dev';
                return $result;
            }
        }
    }

    // 2. Try FreeDictionaryAPI as fallback
    $url2 = "https://freedictionaryapi.com/api/v1/entries/en/" . urlencode($word);
    $response2 = executeCurl($url2);

    if ($response2) {
        $data = json_decode($response2, true);

        if (isset($data['entries'])) { // Validating FreeDictionaryAPI structure
            $result = parseFreeDictionaryApi($data);
            if ($result['phonetic'] || $result['source_url'] || !empty($result['verb_definitions'])) {
                $result['source_api'] = 'freedictionaryapi.com';
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
                    foreach ($meaning['definitions'] as $defItem) {
                        if (isset($defItem['definition'])) {
                            $verbDefs[] = $defItem['definition'];
                        }
                    }
                }
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
                    foreach ($entry['senses'] as $sense) {
                        if (isset($sense['definition'])) {
                            $verbDefs[] = $sense['definition'];
                        }
                    }
                }
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

// --- Usage Example ---

$word = "eat"; // Try a word that is definitely a verb, like "run", to see more results
$result = fetchWordDetails($word);

if ($result) {
    echo "Source API: " . $result['source_api'] . "\n";
    echo "Phonetic: " . ($result['phonetic'] ?? 'N/A') . "\n";
    echo "Source URL: " . ($result['source_url'] ?? 'N/A') . "\n";

    echo "Verb Definitions:\n";
    if (empty($result['verb_definitions'])) {
        echo " - No verb definitions found.\n";
    } else {
        foreach ($result['verb_definitions'] as $def) {
            echo " - " . $def . "\n";
        }
    }
} else {
    echo "Could not find details for '$word'.";
}


function fetchAllExamples($word)
{
    // 1. Try DictionaryAPI.dev first
    $url1 = "https://api.dictionaryapi.dev/api/v2/entries/en/" . urlencode($word);
    $response1 = executeCurl($url1);

    if ($response1) {
        $data = json_decode($response1, true);

        // Check for valid response (array with at least one item)
        if (isset($data[0])) {
            $examples = parseDictionaryApiDevExamples($data[0]);
            
            // If we found examples, return them immediately
            if (!empty($examples)) {
                return [
                    'source_api' => 'dictionaryapi.dev',
                    'examples' => $examples
                ];
            }
        }
    }

    // 2. Try FreeDictionaryAPI as fallback
    $url2 = "https://freedictionaryapi.com/api/v1/entries/en/" . urlencode($word);
    $response2 = executeCurl($url2);

    if ($response2) {
        $data = json_decode($response2, true);

        if (isset($data['entries'])) {
            $examples = parseFreeDictionaryApiExamples($data);
            
            if (!empty($examples)) {
                return [
                    'source_api' => 'freedictionaryapi.com',
                    'examples' => $examples
                ];
            }
        }
    }

    return null;
}

/**
 * Logic to extract examples from DictionaryAPI.dev
 * Structure: meanings -> definitions -> example (string)
 */
function parseDictionaryApiDevExamples($entry)
{
    $example = null;

    if (isset($entry['meanings']) && is_array($entry['meanings'])) {
        foreach ($entry['meanings'] as $meaning) {
            if (isset($meaning['definitions']) && is_array($meaning['definitions'])) {
                foreach ($meaning['definitions'] as $def) {
                    // This API typically provides a single string in 'example'
                    if (isset($def['example']) && !empty($def['example'])) {
                        $example = $def['example'];
                    }
                }
            }
        }
    }

    return $example;
}

/**
 * Logic to extract examples from FreeDictionaryAPI.com
 * Structure: entries -> senses -> examples (array of strings)
 */
function parseFreeDictionaryApiExamples($data)
{
    $allExamples = [];

    if (isset($data['entries']) && is_array($data['entries'])) {
        foreach ($data['entries'] as $entry) {
            if (isset($entry['senses']) && is_array($entry['senses'])) {
                foreach ($entry['senses'] as $sense) {
                    // This API provides an array of strings in 'examples'
                    if (isset($sense['examples']) && is_array($sense['examples'])) {
                        foreach ($sense['examples'] as $ex) {
                            if (!empty($ex)) {
                                $allExamples[] = $ex;
                            }
                        }
                    }
                }
            }
        }
    }

    return $allExamples;
}

// --- Usage Example ---

// "Reindeer" usually doesn't have many examples in these APIs, 
// so let's try a common word like "run" or "make" to see the list populate.
$word = "run"; 
$result = fetchAllExamples($word);

if ($result) {
    echo "Examples for '$word' (via " . $result['source_api'] . "):\n";
    echo "---------------------------------------------------\n";
    foreach ($result['examples'] as $index => $example) {
        echo ($index + 1) . ". " . $example . "\n";
    }
} else {
    echo "No examples found for '$word'.";
}
