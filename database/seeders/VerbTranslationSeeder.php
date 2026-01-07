<?php

namespace Database\Seeders;

use App\Models\Verb;
use App\Models\VerbTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VerbTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(database_path('seeders/verbs.csv'), 'r');
        fgetcsv($csvFile);

        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {

            $verb = Verb::where('infinitive', '=', $data[0])->pluck('id')->first();
            $translatedForm = $data[3];

            VerbTranslation::create([
                'verb_id' => $verb,
                'lang_code' => 'fr',
                'translation' => $translatedForm,
            ]);
        }
        fclose($csvFile);
        $this->command->info('Traductions ajoutées !');
    }
}
