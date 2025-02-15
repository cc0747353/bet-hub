<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoriesData = [
            [
                'name' => 'soccer',
                'icon' => 'football',
                'status' => Category::ACTIVE
            ],

            [
                'name' => 'basketball',
                'icon' => 'basketball',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'tennis',
                'icon' => 'tennis',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'volleyball',
                'icon' => 'volleyball',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'baseball',
                'icon' => 'baseball',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'golf',
                'icon' => 'golf',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'rugby',
                'icon' => 'rugby',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'cricket',
                'icon' => 'cricket',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'hockey',
                'icon' => 'hockey',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'table tennis',
                'icon' => 'table-tennis',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'badminton',
                'icon' => 'badminton',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'handball',
                'icon' => 'handball',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'esports',
                'icon' => 'esports',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'boxing',
                'icon' => 'boxing',
                'status' => Category::ACTIVE
            ],

            [
                'name' => 'cycling',
                'icon' => 'cycling',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'darts',
                'icon' => 'darts',
                'status' => Category::ACTIVE
            ],

            [
                'name' => 'futsal',
                'icon' => 'futsal',
                'status' => Category::ACTIVE
            ],
            [
                'name' => 'beach volleyball',
                'icon' => 'beach-volleyball',
                'status' => Category::ACTIVE
            ],

            [
                'name' => 'ice hockey',
                'icon' => 'ice-hockey',
                'status' => Category::ACTIVE
            ],

            [
                'name' => 'netball',
                'icon' => 'netball',
                'status' => Category::ACTIVE
            ],

            [
                'name' => 'horse racing',
                'icon' => 'horse-racing',
                'status' => Category::ACTIVE
            ],


            [
                'name' => 'aviator',
                'icon' => 'aviator',
                'status' => Category::ACTIVE
            ],
        ];

        foreach ($categoriesData as $categoryData) {
            Category::create($categoryData);
        }
    }
}
