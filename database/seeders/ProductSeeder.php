<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'brand_id' => 2,
                'name_en' => 'iPhone 15 Pro Max',
                'name_kh' => 'អាយហ្វូន 15 ប្រូ ម៉ាក់',
                'SKU' => 'IP15PM-001',
                'price' => 1299.99,
                'quantity' => 50,
                'specification_en' => '6.7-inch Super Retina XDR display, A17 Pro chip, 256GB storage, 48MP camera',
                'specification_kh' => 'អេក្រង់ 6.7 អ៊ីញ Super Retina XDR, បន្ទះឈីប A17 Pro, ស្តុក 256GB, កាមេរ៉ា 48MP',
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'brand_id' => 1,
                'name_en' => 'Samsung Galaxy S24 Ultra',
                'name_kh' => 'សាំសុង ហ្គាឡាក់ស៊ី S24 អ៊ុលត្រា',
                'SKU' => 'SGS24U-001',
                'price' => 1199.99,
                'quantity' => 35,
                'specification_en' => '6.8-inch Dynamic AMOLED, Snapdragon 8 Gen 3, 256GB storage, 200MP camera',
                'specification_kh' => 'អេក្រង់ 6.8 អ៊ីញ Dynamic AMOLED, Snapdragon 8 Gen 3, ស្តុក 256GB, កាមេរ៉ា 200MP',
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'brand_id' => 3,
                'name_en' => 'LG OLED TV 65-inch',
                'name_kh' => 'ទូរទស្សន៍ LG OLED 65 អ៊ីញ',
                'SKU' => 'LGOLED65-001',
                'price' => 1999.99,
                'quantity' => 20,
                'specification_en' => '65-inch 4K OLED, Smart TV, AI Processor, Dolby Vision',
                'specification_kh' => '65 អ៊ីញ 4K OLED, ទូរទស្សន៍ឆ្លាតវៃ, AI Processor, Dolby Vision',
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'brand_id' => 5,
                'name_en' => 'Nike Air Max 2024',
                'name_kh' => 'ណៃគី អ៊ែរ ម៉ាក់ 2024',
                'SKU' => 'NKAM24-001',
                'price' => 149.99,
                'quantity' => 100,
                'specification_en' => 'Breathable mesh upper, Air Max cushioning, Durable rubber outsole',
                'specification_kh' => 'សំណាញ់ខ្យល់ចេញចូល, Air Max cushioning, បាតកៅស៊ូប្រើប្រាស់បានយូរ',
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'brand_id' => 6,
                'name_en' => 'Adidas Ultraboost',
                'name_kh' => 'អាឌីដាស អ៊ុលត្រាប៊ូស',
                'SKU' => 'ADUB-001',
                'price' => 179.99,
                'quantity' => 85,
                'specification_en' => 'Primeknit upper, Boost cushioning, Stretchweb outsole',
                'specification_kh' => 'សំណាញ់ Primeknit, Boost cushioning, Stretchweb outsole',
                'is_active' => true,
            ],
            [
                'category_id' => 3,
                'brand_id' => 4,
                'name_en' => 'Sony Noise Cancelling Headphones',
                'name_kh' => 'កាស Sony កាត់សំលេងរំខាន',
                'SKU' => 'SONYNC-001',
                'price' => 299.99,
                'quantity' => 60,
                'specification_en' => 'Industry-leading noise cancellation, 30-hour battery life, LDAC support',
                'specification_kh' => 'កាត់សំលេងរំខានកម្រិតខ្ពស់, ថ្ម 30 ម៉ោង, គាំទ្រ LDAC',
                'is_active' => true,
            ],
            [
                'category_id' => 4,
                'brand_id' => 5,
                'name_en' => 'Nike Dri-FIT T-Shirt',
                'name_kh' => 'អាវយឺត Nike Dri-FIT',
                'SKU' => 'NKDFT-001',
                'price' => 34.99,
                'quantity' => 200,
                'specification_en' => 'Moisture-wicking fabric, Breathable, Regular fit',
                'specification_kh' => 'ក្រណាត់ស្រូបយកញើស, ខ្យល់ចេញចូលបានល្អ, សមល្មម',
                'is_active' => true,
            ],
            [
                'category_id' => 5,
                'brand_id' => 4,
                'name_en' => 'Sony PlayStation 5',
                'name_kh' => 'សូនី ផ្លេស្តេសិន 5',
                'SKU' => 'SONYPS5-001',
                'price' => 499.99,
                'quantity' => 25,
                'specification_en' => 'Ultra-high speed SSD, Ray tracing, 4K gaming',
                'specification_kh' => 'SSD ល្បឿនលឿន, Ray tracing, លេងហ្គេម 4K',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
