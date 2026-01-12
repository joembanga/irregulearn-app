<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Verb;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Définition des catégories avec leurs critères (basés sur le verbe à l'infinitif)
        $definitions = [
            [
                'name' => 'Daily Life',
                'description' => 'Actions quotidiennes, corps et maison.',
                'order' => 1,
                'keywords' => ['be', 'eat', 'drink', 'sleep', 'wake', 'wear', 'wash', 'shave', 'sweep', 'sit', 'stand', 'feel', 'hear', 'see', 'smell', 'dwell', 'clothe', 'knit', 'sew', 'mow'],
            ],
            [
                'name' => 'Business & Exchange',
                'slug' => Str::slug('Business & Exchange'),
                'description' => 'Commerce, argent et communication.',
                'order' => 2,
                'keywords' => ['buy', 'sell', 'pay', 'cost', 'deal', 'spend', 'lend', 'give', 'get', 'bid', 'sublet', 'pay', 'withdraw', 'withhold', 'understand', 'mean', 'say', 'tell', 'write', 'read'],
            ],
            [
                'name' => 'Motion & Physical',
                'description' => 'Mouvements, déplacements et impacts.',
                'order' => 3,
                'keywords' => ['go', 'come', 'run', 'fly', 'drive', 'fall', 'hit', 'throw', 'catch', 'build', 'break', 'cut', 'strike', 'swing', 'shake', 'bend', 'bind', 'dig', 'dive', 'slide', 'spring'],
            ],
            [
                'name' => 'Mind & Power',
                'description' => 'Pensée, émotions et influence.',
                'order' => 4,
                'keywords' => ['know', 'think', 'forget', 'learn', 'dream', 'forgive', 'mistake', 'mislead', 'oversee', 'foresee', 'choose', 'strive', 'win', 'lose', 'fight', 'beat', 'keep', 'hold', 'let', 'may'],
            ],
            [
                'name' => 'Expert & Abstract',
                'description' => 'Verbes rares, littéraires ou complexes.',
                'order' => 5,
                'keywords' => ['abide', 'alit', 'arise', 'behold', 'forsake', 'slay', 'thrive', 'tread', 'weave', 'wind', 'withstand', 'wring', 'zinc', 'inlay', 'fling', 'cling', 'slink'],
            ],
        ];

        foreach ($definitions as $def) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($def['name'])],
                [
                    'name' => $def['name'],
                    'description' => $def['description'],
                    'order' => $def['order'],
                    'cout' => ($def['order'] - 1) * 5000, // Exemple: 0 XP, 10000 XP, 20000 XP...
                ]
            );

            // 2. Attribution des verbes selon les mots-clés
            $verbIds = Verb::where(function ($query) use ($def) {
                foreach ($def['keywords'] as $keyword) {
                    $query->orWhere('infinitive', 'like', '%'.$keyword.'%');
                }
            })->pluck('id');

            $category->verbs()->syncWithoutDetaching($verbIds);
        }

        // 3. Sécurité : Assigner les verbes orphelins à la catégorie "Motion" (la plus commune)
        $orphans = Verb::doesntHave('categories')->get();
        if ($orphans->count() > 0) {
            $defaultCat = Category::where('slug', 'motion-physical')->first();
            $defaultCat->verbs()->attach($orphans->pluck('id'));
        }
    }
}
