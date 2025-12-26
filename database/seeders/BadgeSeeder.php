<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $definitions = [
            [
                'name' => 'The Explorer',
                'icon' => '🐣',
                'description' => 'Lorem ipsum dolor sit amet',
                'requirement_type' => 'category_complete',  // 'xp', 'category_complete', 'streak'
                'requirement_value' => 3
            ],
            [
                'name' => 'High Flyer',
                'icon' => '🐣',
                'description' => 'Lorem ipsum dolor sit amet',
                'requirement_type' => 'xp',  // 'xp', 'category_complete', 'streak'
                'requirement_value' => 1000
            ],
            [
                'name' => 'The Specialist',
                'icon' => '🐣',
                'description' => 'Lorem ipsum dolor sit amet',
                'requirement_type' => 'category_complete',  // 'xp', 'category_complete', 'streak'
                'requirement_value' => 4
            ],
            [
                'name' => 'Scholar',
                'icon' => '🐣',
                'description' => 'Lorem ipsum dolor sit amet',
                'requirement_type' => 'search',  // 'xp', 'category_complete', 'streak'
                'requirement_value' => 10
            ],
        ];

        foreach ($definitions as $def) {
            $category = Badge::updateOrCreate(
                [
                    'name' => $def['name'],
                    'icon' => $def['icon'],
                    'description' => $def['description'],
                    'requirement_type' => $def['requirement_type'],
                    'requirement_value' => $def['requirement_value']
                ]
            );
        }
    }
}
