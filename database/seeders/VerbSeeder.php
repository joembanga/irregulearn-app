<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Verb;
use App\Models\Exercise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(database_path('seeders/verbs.csv'), 'r');
        fgetcsv($csvFile);

        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            $slug = Str::lower($data[0]);
            $infinitive = $data[0];
            $pastSimple = $data[1];
            $pastParticiple = $data[2];
            $level = $data[4];
            
            $verb = Verb::create([
                'slug' => $slug,
                'infinitive' => $infinitive,
                'past_simple' => $pastSimple,
                'past_participle' => $pastParticiple,
                'level' => $level,
            ]);
        }

        fclose($csvFile);
        $this->command->info('Verbes importés avec succès !');
    }
}