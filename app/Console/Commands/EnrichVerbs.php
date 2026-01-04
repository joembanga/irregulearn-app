<?php

namespace App\Console\Commands;

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
        $verbs = \App\Models\Verb::whereNull('description')->get();
        $count = $verbs->count();
        $this->info("Found {$count} verbs to enrich.");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($verbs as $verb) {
            $definition = $this->fetchDefinition($verb->infinitive);

            if ($definition) {
                $verb->update(['description' => $definition]);
            }

            $bar->advance();
            // Sleep slightly to respect API rate limits (though these APIs are generous)
            usleep(200000);
        }

        $bar->finish();
        $this->newLine();
        $this->info('Verbs enriched successfully!');
    }

    private function fetchDefinition($word)
    {
        // Try DictionaryAPI.dev first
        try {
            $response = @file_get_contents("https://api.dictionaryapi.dev/api/v2/entries/en/{$word}");
            if ($response) {
                $data = json_decode($response, true);
                foreach ($data[0]['meanings'] as $meaning) {
                    if ($meaning['partOfSpeech'] === 'verb') {
                        return $meaning['definitions'][0]['definition'] ?? null;
                    }
                }
            }
        } catch (\Exception $e) {
            // Ignore and try next API
        }

        // Try FreeDictionaryAPI as fallback
        try {
            $response = @file_get_contents("https://freedictionaryapi.com/api/v1/entries/en/{$word}");
            if ($response) {
                $data = json_decode($response, true);
                // Structure checks for FreeDictionaryAPI (assuming similar or adjustment needed)
                foreach ($data[0]['meanings'] as $meaning) {
                    if ($meaning['partOfSpeech'] === 'verb') {
                        return $meaning['definitions'][0]['definition'] ?? null;
                    }
                }
            }
        } catch (\Exception $e) {
            // Ignore
        }

        return null;
    }
}
