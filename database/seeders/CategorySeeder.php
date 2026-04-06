<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name_en' => 'Electronics', 'name_kh' => 'អេឡិចត្រូនិច', 'is_active' => true],
            ['name_en' => 'Fashion', 'name_kh' => 'ម៉ូត', 'is_active' => true],
            ['name_en' => 'Home & Living', 'name_kh' => 'ផ្ទះ និង ជីវភាពរស់នៅ', 'is_active' => true],
            ['name_en' => 'Sports', 'name_kh' => 'កីឡា', 'is_active' => true],
            ['name_en' => 'Books', 'name_kh' => 'សៀវភៅ', 'is_active' => true],
            ['name_en' => 'Toys', 'name_kh' => 'ប្រដាប់ក្មេងលេង', 'is_active' => true],
            ['name_en' => 'Beauty', 'name_kh' => 'សម្រស់', 'is_active' => true],
            ['name_en' => 'Automotive', 'name_kh' => 'យានយន្ត', 'is_active' => true],
            ['name_en' => 'Groceries', 'name_kh' => 'គ្រឿងទេស', 'is_active' => true],
            ['name_en' => 'Furniture', 'name_kh' => 'គ្រឿងសង្ហារិម', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
