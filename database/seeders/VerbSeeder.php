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

            // --- GÉNÉRATION AUTOMATIQUE DES EXERCICES ---

            // Exercice 1 : Trouver le Past Simple (Saisie clavier)
            $ex1 = Exercise::create([
                'type' => 'input',
                'question' => "What is the Past Simple of : $infinitive ?",
                'correct_answer' => $pastSimple,
                'points' => 10,
            ]);
            // On lie l'exercice au verbe
            $verb->exercises()->attach($ex1->id);

            // Exercice 2 : Trouver le Participe Passé (Saisie clavier)
            $ex2 = Exercise::create([
                'type' => 'input',
                'question' => "What is the Past Participle of : $infinitive ?",
                'correct_answer' => $pastParticiple,
                'points' => 15, // Un peu plus dur
            ]);
            $verb->exercises()->attach($ex2->id);

            // // Exercice 3 : Traduction Inverse (QCM - Simplifié pour le seed)
            // // Note: Pour un vrai QCM, il faudrait générer des fausses réponses aléatoires.
            // // Pour l'instant, on fait un input simple pour la traduction.
            // $ex3 = Exercise::create([
            //     'type' => 'input',
            //     'question' => "What is the English translation of '$translation' (Infinitive) ?",
            //     'correct_answer' => $infinitive,
            //     'points' => 5,
            // ]);
            // $verb->exercises()->attach($ex3->id);
        }

        fclose($csvFile);
        $this->command->info('Verbes et Exercices importés avec succès !');
    }
}