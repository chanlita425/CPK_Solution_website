<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name_en' => 'Samsung', 'name_kh' => 'សាំសុង', 'is_active' => true],
            ['name_en' => 'Apple', 'name_kh' => 'អេបផល', 'is_active' => true],
            ['name_en' => 'LG', 'name_kh' => 'អិលជី', 'is_active' => true],
            ['name_en' => 'Sony', 'name_kh' => 'សូនី', 'is_active' => true],
            ['name_en' => 'Nike', 'name_kh' => 'ណៃគី', 'is_active' => true],
            ['name_en' => 'Adidas', 'name_kh' => 'អាឌីដាស', 'is_active' => true],
            ['name_en' => 'Dell', 'name_kh' => 'ដេល', 'is_active' => true],
            ['name_en' => 'HP', 'name_kh' => 'អេចភី', 'is_active' => true],
            ['name_en' => 'Canon', 'name_kh' => 'កាណុន', 'is_active' => true],
            ['name_en' => 'Panasonic', 'name_kh' => 'ប៉ាណាសូនិច', 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
