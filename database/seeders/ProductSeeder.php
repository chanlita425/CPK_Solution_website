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
            // Electronics
            ['category_id' => 1, 'brand_id' => 2, 'name_en' => 'iPhone 15 Pro Max', 'name_kh' => 'អាយហ្វូន 15 ប្រូ ម៉ាក់', 'SKU' => 'IP15PM-001', 'price' => 1299.99, 'quantity' => 50, 'specification_en' => '6.7-inch Super Retina XDR, A17 Pro chip, 256GB', 'specification_kh' => 'អេក្រង់ 6.7 អ៊ីញ, បន្ទះឈីប A17 Pro, 256GB', 'is_active' => true],
            ['category_id' => 1, 'brand_id' => 2, 'name_en' => 'iPhone 15 Pro', 'name_kh' => 'អាយហ្វូន 15 ប្រូ', 'SKU' => 'IP15P-001', 'price' => 1099.99, 'quantity' => 45, 'specification_en' => '6.1-inch Super Retina XDR, A17 Pro chip, 256GB', 'specification_kh' => 'អេក្រង់ 6.1 អ៊ីញ, បន្ទះឈីប A17 Pro, 256GB', 'is_active' => true],
            ['category_id' => 1, 'brand_id' => 2, 'name_en' => 'iPhone 15 Plus', 'name_kh' => 'អាយហ្វូន 15 ប្លាស', 'SKU' => 'IP15PL-001', 'price' => 899.99, 'quantity' => 60, 'specification_en' => '6.7-inch Super Retina XDR, A16 chip, 128GB', 'specification_kh' => 'អេក្រង់ 6.7 អ៊ីញ, បន្ទះឈីប A16, 128GB', 'is_active' => true],
            ['category_id' => 1, 'brand_id' => 1, 'name_en' => 'Samsung Galaxy S24 Ultra', 'name_kh' => 'សាំសុង ហ្គាឡាក់ស៊ី S24 អ៊ុលត្រា', 'SKU' => 'SGS24U-001', 'price' => 1199.99, 'quantity' => 35, 'specification_en' => '6.8-inch Dynamic AMOLED, Snapdragon 8 Gen 3, 256GB', 'specification_kh' => 'អេក្រង់ 6.8 អ៊ីញ, Snapdragon 8 Gen 3, 256GB', 'is_active' => true],
            ['category_id' => 1, 'brand_id' => 1, 'name_en' => 'Samsung Galaxy S24+', 'name_kh' => 'សាំសុង ហ្គាឡាក់ស៊ី S24+', 'SKU' => 'SGS24P-001', 'price' => 999.99, 'quantity' => 40, 'specification_en' => '6.7-inch Dynamic AMOLED, Snapdragon 8 Gen 3, 256GB', 'specification_kh' => 'អេក្រង់ 6.7 អ៊ីញ, Snapdragon 8 Gen 3, 256GB', 'is_active' => true],
            ['category_id' => 1, 'brand_id' => 1, 'name_en' => 'Samsung Galaxy S24', 'name_kh' => 'សាំសុង ហ្គាឡាក់ស៊ី S24', 'SKU' => 'SGS24-001', 'price' => 799.99, 'quantity' => 55, 'specification_en' => '6.2-inch Dynamic AMOLED, Snapdragon 8 Gen 3, 128GB', 'specification_kh' => 'អេក្រង់ 6.2 អ៊ីញ, Snapdragon 8 Gen 3, 128GB', 'is_active' => true],
            ['category_id' => 1, 'brand_id' => 3, 'name_en' => 'LG OLED TV 65-inch', 'name_kh' => 'ទូរទស្សន៍ LG OLED 65 អ៊ីញ', 'SKU' => 'LGOLED65-001', 'price' => 1999.99, 'quantity' => 20, 'specification_en' => '65-inch 4K OLED, Smart TV, AI Processor', 'specification_kh' => '65 អ៊ីញ 4K OLED, ទូរទស្សន៍ឆ្លាតវៃ', 'is_active' => true],
            ['category_id' => 1, 'brand_id' => 3, 'name_en' => 'LG OLED TV 55-inch', 'name_kh' => 'ទូរទស្សន៍ LG OLED 55 អ៊ីញ', 'SKU' => 'LGOLED55-001', 'price' => 1499.99, 'quantity' => 25, 'specification_en' => '55-inch 4K OLED, Smart TV, AI Processor', 'specification_kh' => '55 អ៊ីញ 4K OLED, ទូរទស្សន៍ឆ្លាតវៃ', 'is_active' => true],
            ['category_id' => 1, 'brand_id' => 7, 'name_en' => 'Dell XPS 15', 'name_kh' => 'ដេល XPS 15', 'SKU' => 'DELLXPS15-001', 'price' => 1899.99, 'quantity' => 15, 'specification_en' => '15.6-inch 4K OLED, Intel i9, 32GB RAM, 1TB SSD', 'specification_kh' => '15.6 អ៊ីញ 4K OLED, Intel i9, 32GB RAM, 1TB SSD', 'is_active' => true],
            ['category_id' => 1, 'brand_id' => 8, 'name_en' => 'HP Spectre x360', 'name_kh' => 'អេចភី ស្ប៉ិចទ័រ x360', 'SKU' => 'HPSPECTRE-001', 'price' => 1599.99, 'quantity' => 18, 'specification_en' => '13.5-inch OLED, Intel i7, 16GB RAM, 512GB SSD', 'specification_kh' => '13.5 អ៊ីញ OLED, Intel i7, 16GB RAM, 512GB SSD', 'is_active' => true],

            // Fashion
            ['category_id' => 2, 'brand_id' => 5, 'name_en' => 'Nike Air Max 2024', 'name_kh' => 'ណៃគី អ៊ែរ ម៉ាក់ 2024', 'SKU' => 'NKAM24-001', 'price' => 149.99, 'quantity' => 100, 'specification_en' => 'Breathable mesh upper, Air Max cushioning', 'specification_kh' => 'សំណាញ់ខ្យល់, Air Max cushioning', 'is_active' => true],
            ['category_id' => 2, 'brand_id' => 5, 'name_en' => 'Nike Air Force 1', 'name_kh' => 'ណៃគី អ៊ែរ ហ្វូស 1', 'SKU' => 'NKAF1-001', 'price' => 119.99, 'quantity' => 120, 'specification_en' => 'Classic leather upper, Nike Air cushioning', 'specification_kh' => 'ស្បែកបុរាណ, Nike Air cushioning', 'is_active' => true],
            ['category_id' => 2, 'brand_id' => 6, 'name_en' => 'Adidas Ultraboost', 'name_kh' => 'អាឌីដាស អ៊ុលត្រាប៊ូស', 'SKU' => 'ADUB-001', 'price' => 179.99, 'quantity' => 85, 'specification_en' => 'Primeknit upper, Boost cushioning', 'specification_kh' => 'Primeknit, Boost cushioning', 'is_active' => true],
            ['category_id' => 2, 'brand_id' => 6, 'name_en' => 'Adidas Superstar', 'name_kh' => 'អាឌីដាស ស៊ូពែស្តារ', 'SKU' => 'ADSS-001', 'price' => 89.99, 'quantity' => 150, 'specification_en' => 'Classic shell toe, Leather upper', 'specification_kh' => 'Shell toe បុរាណ, ស្បែក', 'is_active' => true],

            // Accessories
            ['category_id' => 3, 'brand_id' => 4, 'name_en' => 'Sony WH-1000XM5', 'name_kh' => 'សូនី WH-1000XM5', 'SKU' => 'SONYWH-001', 'price' => 399.99, 'quantity' => 60, 'specification_en' => 'Industry-leading noise cancellation, 30-hour battery', 'specification_kh' => 'កាត់សំលេងរំខាន, ថ្ម 30 ម៉ោង', 'is_active' => true],
            ['category_id' => 3, 'brand_id' => 4, 'name_en' => 'Sony WF-1000XM5', 'name_kh' => 'សូនី WF-1000XM5', 'SKU' => 'SONYWF-001', 'price' => 299.99, 'quantity' => 75, 'specification_en' => 'True wireless, noise cancellation, 24-hour battery', 'specification_kh' => 'ឥតខ្សែ, កាត់សំលេងរំខាន, ថ្ម 24 ម៉ោង', 'is_active' => true],

            // Sports
            ['category_id' => 4, 'brand_id' => 5, 'name_en' => 'Nike Dri-FIT T-Shirt', 'name_kh' => 'អាវយឺត Nike Dri-FIT', 'SKU' => 'NKDFT-001', 'price' => 34.99, 'quantity' => 200, 'specification_en' => 'Moisture-wicking fabric, Breathable', 'specification_kh' => 'ក្រណាត់ស្រូបយកញើស, ខ្យល់ចេញចូល', 'is_active' => true],
            ['category_id' => 4, 'brand_id' => 6, 'name_en' => 'Adidas Training T-Shirt', 'name_kh' => 'អាវយឺត Adidas Training', 'SKU' => 'ADTT-001', 'price' => 29.99, 'quantity' => 180, 'specification_en' => 'Climalite fabric, Regular fit', 'specification_kh' => 'ក្រណាត់ Climalite, សមល្មម', 'is_active' => true],

            // Gaming
            ['category_id' => 5, 'brand_id' => 4, 'name_en' => 'Sony PlayStation 5', 'name_kh' => 'សូនី ផ្លេស្តេសិន 5', 'SKU' => 'SONYPS5-001', 'price' => 499.99, 'quantity' => 25, 'specification_en' => 'Ultra-high speed SSD, Ray tracing, 4K gaming', 'specification_kh' => 'SSD ល្បឿនលឿន, Ray tracing, លេងហ្គេម 4K', 'is_active' => true],
            ['category_id' => 5, 'brand_id' => 4, 'name_en' => 'Sony PlayStation 5 Digital', 'name_kh' => 'សូនី ផ្លេស្តេសិន 5 ឌីជីថល', 'SKU' => 'SONYPS5D-001', 'price' => 399.99, 'quantity' => 30, 'specification_en' => 'Digital edition, Ultra-high speed SSD', 'specification_kh' => 'កំណែឌីជីថល, SSD ល្បឿនលឿន', 'is_active' => true],
            ['category_id' => 5, 'brand_id' => 4, 'name_en' => 'Sony PlayStation 5 Controller', 'name_kh' => 'ឧបករណ៍បញ្ជា PlayStation 5', 'SKU' => 'SONYPS5C-001', 'price' => 69.99, 'quantity' => 100, 'specification_en' => 'DualSense wireless controller, Haptic feedback', 'specification_kh' => 'ឧបករណ៍បញ្ជាឥតខ្សែ DualSense', 'is_active' => true],

            // More products to reach 50+ for pagination testing
            ['category_id' => 6, 'brand_id' => 4, 'name_en' => 'Sony A7 III Camera', 'name_kh' => 'កាមេរ៉ា Sony A7 III', 'SKU' => 'SONYA7III-001', 'price' => 1999.99, 'quantity' => 10, 'specification_en' => 'Full-frame mirrorless, 24.2MP, 4K video', 'specification_kh' => 'Full-frame mirrorless, 24.2MP, វីដេអូ 4K', 'is_active' => true],
            ['category_id' => 6, 'brand_id' => 9, 'name_en' => 'Canon EOS R6', 'name_kh' => 'កាមេរ៉ា Canon EOS R6', 'SKU' => 'CANONR6-001', 'price' => 2499.99, 'quantity' => 8, 'specification_en' => 'Full-frame mirrorless, 20MP, 4K video', 'specification_kh' => 'Full-frame mirrorless, 20MP, វីដេអូ 4K', 'is_active' => true],
            ['category_id' => 7, 'brand_id' => 10, 'name_en' => 'Panasonic Microwave', 'name_kh' => 'មីក្រូវ៉េវ Panasonic', 'SKU' => 'PANMIC-001', 'price' => 149.99, 'quantity' => 40, 'specification_en' => '1200W, Inverter technology, 1.2 cu ft', 'specification_kh' => '1200W, Inverter technology, 1.2 cu ft', 'is_active' => true],
            ['category_id' => 8, 'brand_id' => 1, 'name_en' => 'Samsung Refrigerator', 'name_kh' => 'ទូទឹកកក Samsung', 'SKU' => 'SAMREF-001', 'price' => 899.99, 'quantity' => 15, 'specification_en' => 'Family Hub, 28 cu ft, Smart features', 'specification_kh' => 'Family Hub, 28 cu ft, Smart features', 'is_active' => true],
            ['category_id' => 9, 'brand_id' => 3, 'name_en' => 'LG Washing Machine', 'name_kh' => 'ម៉ាស៊ីនបោកគក់ LG', 'SKU' => 'LGWASH-001', 'price' => 699.99, 'quantity' => 20, 'specification_en' => 'TurboWash, 4.5 cu ft, Smart features', 'specification_kh' => 'TurboWash, 4.5 cu ft, Smart features', 'is_active' => true],
            ['category_id' => 10, 'brand_id' => 7, 'name_en' => 'Dell Monitor 27-inch', 'name_kh' => 'ម៉ូនីទ័រ Dell 27 អ៊ីញ', 'SKU' => 'DELLMON-001', 'price' => 299.99, 'quantity' => 50, 'specification_en' => '4K UHD, IPS panel, USB-C', 'specification_kh' => '4K UHD, IPS panel, USB-C', 'is_active' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
