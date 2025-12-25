<?php

namespace Database\Seeders;

use App\Models\VerbTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

            $verb = DB::table('verbs')->where('infinitive', '=', $data[0])->value('id');
            $translatedForm = $data[3];

            VerbTranslation::create([
                'verb_id' => $verb,
                'lang' => 'fr',
                'translation' => $translatedForm,
            ]);
        }
        fclose($csvFile);
        $this->command->info('Traductions ajoutées !');
    }
}
