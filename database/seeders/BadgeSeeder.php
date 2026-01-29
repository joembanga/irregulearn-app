<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $definitions = [
            // --- COLLECTION : PROGRESSION XP ---
            [
                'name' => 'First Blood',
                'icon' => 'zap',
                'color' => 'orange',
                'description' => 'Gagne tes premiers 100 XP',
                'requirement_type' => 'xp',
                'requirement_value' => 100,
            ],
            [
                'name' => 'Rising Star',
                'icon' => 'star',
                'color' => 'yellow',
                'description' => 'Accumule 500 XP',
                'requirement_type' => 'xp',
                'requirement_value' => 500,
            ],
            [
                'name' => 'XP Master',
                'icon' => 'trophy',
                'color' => 'slate',
                'description' => 'Atteins 1000 XP au total',
                'requirement_type' => 'xp',
                'requirement_value' => 1000,
            ],
            [
                'name' => 'XP Legend',
                'icon' => 'crown',
                'color' => 'indigo',
                'description' => 'Atteins 5000 XP au total',
                'requirement_type' => 'xp',
                'requirement_value' => 5000,
            ],

            // --- COLLECTION : SÉRIES (STREAKS) ---
            [
                'name' => 'Habitual',
                'icon' => 'flame',
                'color' => 'red',
                'description' => '7 jours de pratique consécutifs',
                'requirement_type' => 'streak',
                'requirement_value' => 7,
            ],
            [
                'name' => 'Dedicated',
                'icon' => 'rocket',
                'color' => 'blue',
                'description' => 'Streak de 30 jours !',
                'requirement_type' => 'streak',
                'requirement_value' => 30,
            ],
            [
                'name' => 'Unstoppable',
                'icon' => 'shield-check',
                'color' => 'purple',
                'description' => 'Streak de 100 jours !',
                'requirement_type' => 'streak',
                'requirement_value' => 100,
            ],

            // --- COLLECTION : PERFECTION ---
            [
                'name' => 'Perfectionist',
                'icon' => 'check-circle',
                'color' => 'emerald',
                'description' => 'Réussis 5 sessions sans aucune erreur',
                'requirement_type' => 'perfect_sessions',
                'requirement_value' => 5,
            ],
            [
                'name' => 'Sniper',
                'icon' => 'target',
                'color' => 'rose',
                'description' => 'Finir 3 sessions avec 100% de réussite',
                'requirement_type' => 'precision',
                'requirement_value' => 3,
            ],

            // --- COLLECTION : VITESSE ---
            [
                'name' => 'Speed Demon',
                'icon' => 'gauge',
                'color' => 'cyan',
                'description' => 'Réponds correctement en moins de 3 secondes',
                'requirement_type' => 'fast_answer',
                'requirement_value' => 1,
            ],
            [
                'name' => 'Lightning Bolt',
                'icon' => 'zap-off',
                'color' => 'yellow',
                'description' => 'Répondre à 10 questions en moins de 30s',
                'requirement_type' => 'speed_run',
                'requirement_value' => 10,
            ],

            // --- COLLECTION : SPÉCIAL ---
            [
                'name' => 'Nighthawk',
                'icon' => 'moon',
                'color' => 'slate',
                'description' => 'Faire une session entre minuit et 4h du matin',
                'requirement_type' => 'night_owl',
                'requirement_value' => 1,
            ],
            [
                'name' => 'Ambassador',
                'icon' => 'share-2',
                'color' => 'pink',
                'description' => 'Partager son score avec la communauté',
                'requirement_type' => 'social_share',
                'requirement_value' => 1,
            ],
            [
                'name' => 'Indestructible',
                'icon' => 'refresh-cw',
                'color' => 'amber',
                'description' => 'Récupérer un streak après l\'avoir perdu',
                'requirement_type' => 'streak_recovery',
                'requirement_value' => 1,
            ],
        ];

        foreach ($definitions as $def) {
            Badge::updateOrCreate(
                ['name' => $def['name']],
                [
                    'icon' => $def['icon'],
                    'description' => $def['description'],
                    'requirement_type' => $def['requirement_type'],
                    'requirement_value' => $def['requirement_value'],
                ]
            );
        }
    }
}
