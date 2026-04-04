<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name_en' => 'August',
                'name_kh' => 'អូហ្គូស',
                'logo' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name_en' => 'Ring',
                'name_kh' => 'រីង',
                'logo' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name_en' => 'Nest',
                'name_kh' => 'ណេស',
                'logo' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name_en' => 'Philips Hue',
                'name_kh' => 'ហ្វីលីព ហ៊ូ',
                'logo' => null,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name_en' => 'Xiaomi',
                'name_kh' => 'សៀអូមី',
                'logo' => null,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
