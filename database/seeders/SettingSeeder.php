<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'CPK Solution',
                'company_url' => 'https://cpksolution.com',
                'company_phone_number_first' => '+855 12 345 678',
                'company_phone_number_second' => '+855 98 765 432',
                'about_company' => 'CPK Solution is a leading e-commerce platform in Cambodia, providing quality products at affordable prices.',
                'facebook_link' => 'https://facebook.com/cpksolution',
                'telegram_link' => 'https://t.me/cpksolution',
                'tiktok_link' => 'https://tiktok.com/@cpksolution',
                'instagram_link' => 'https://instagram.com/cpksolution',
                'shipping_fee' => 5.00,
                'tax_percent' => 10.00,
                'seller_telegram' => '@cpkseller_bot',
            ]
        );
    }
}
