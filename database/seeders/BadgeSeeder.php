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
            // XP-based badges
            [
                'name' => 'Beginner',
                'icon' => '🌱',
                'description' => 'Gagne tes premiers 100 XP',
                'requirement_type' => 'xp',
                'requirement_value' => 100
            ],
            [
                'name' => 'Rising Star',
                'icon' => '⭐',
                'description' => 'Accumule 500 XP',
                'requirement_type' => 'xp',
                'requirement_value' => 500
            ],
            [
                'name' => 'XP Master',
                'icon' => '🏆',
                'description' => 'Atteins 1000 XP au total',
                'requirement_type' => 'xp',
                'requirement_value' => 1000
            ],
            [
                'name' => 'XP Legend',
                'icon' => '👑',
                'description' => 'Atteins 5000 XP au total',
                'requirement_type' => 'xp',
                'requirement_value' => 5000
            ],

            // Streak-based badges
            [
                'name' => 'First Steps',
                'icon' => '🚶',
                'description' => 'Maintiens un streak de 3 jours',
                'requirement_type' => 'streak',
                'requirement_value' => 3
            ],
            [
                'name' => 'On Fire',
                'icon' => '🔥',
                'description' => 'Garde un streak de 7 jours',
                'requirement_type' => 'streak',
                'requirement_value' => 7
            ],
            [
                'name' => 'Dedicated',
                'icon' => '💪',
                'description' => 'Streak de 30 jours !',
                'requirement_type' => 'streak',
                'requirement_value' => 30
            ],
            [
                'name' => 'Unstoppable',
                'icon' => '🚀',
                'description' => 'Streak de 100 jours !',
                'requirement_type' => 'streak',
                'requirement_value' => 100
            ],

            // Category completion badges
            [
                'name' => 'Explorer',
                'icon' => '🗺️',
                'description' => 'Complète ta première catégorie',
                'requirement_type' => 'category_complete',
                'requirement_value' => 1
            ],
            [
                'name' => 'Scholar',
                'icon' => '📚',
                'description' => 'Complète 3 catégories',
                'requirement_type' => 'category_complete',
                'requirement_value' => 3
            ],
            [
                'name' => 'Master',
                'icon' => '🎓',
                'description' => 'Complète 5 catégories',
                'requirement_type' => 'category_complete',
                'requirement_value' => 5
            ],

            // Search-based badges
            [
                'name' => 'Curious Mind',
                'icon' => '🔍',
                'description' => 'Recherche 10 verbes',
                'requirement_type' => 'search',
                'requirement_value' => 10
            ],
            [
                'name' => 'Researcher',
                'icon' => '🧐',
                'description' => 'Recherche 50 verbes',
                'requirement_type' => 'search',
                'requirement_value' => 50
            ],
        ];

        foreach ($definitions as $def) {
            Badge::updateOrCreate(
                ['name' => $def['name']],
                [
                    'icon' => $def['icon'],
                    'description' => $def['description'],
                    'requirement_type' => $def['requirement_type'],
                    'requirement_value' => $def['requirement_value']
                ]
            );
        }
    }
}
