<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_en' => 'Smart Locks',
                'name_kh' => 'សោឆ្លាតវៃ',
                'icon' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name_en' => 'Smart Cameras',
                'name_kh' => 'កាមេរ៉ាឆ្លាតវៃ',
                'icon' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name_en' => 'Smart Lights',
                'name_kh' => 'ភ្លើងឆ្លាតវៃ',
                'icon' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name_en' => 'Smart Sensors',
                'name_kh' => 'ឧបករណ៍ចាប់សញ្ញា',
                'icon' => null,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name_en' => 'Smart Plugs',
                'name_kh' => 'ដោតឆ្លាតវៃ',
                'icon' => null,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
