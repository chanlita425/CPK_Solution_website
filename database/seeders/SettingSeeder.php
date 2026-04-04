<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // System settings for website, phone numbers, and social media
        $settings = [
            // Website Settings
            [
                'key' => 'website_url',
                'value' => 'www.cpksolution.com',
                'type' => 'text',
                'group' => 'system',
                'is_public' => true
            ],
            [
                'key' => 'navbar_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'system',
                'is_public' => true
            ],

            // Contact Phone Numbers
            [
                'key' => 'phone_1',
                'value' => '012 345 678',
                'type' => 'text',
                'group' => 'system',
                'is_public' => true
            ],
            [
                'key' => 'phone_2',
                'value' => '010 234 567',
                'type' => 'text',
                'group' => 'system',
                'is_public' => true
            ],

            // Social Media Links
            [
                'key' => 'facebook_url',
                'value' => '',
                'type' => 'text',
                'group' => 'system',
                'is_public' => true
            ],
            [
                'key' => 'tiktok_url',
                'value' => '',
                'type' => 'text',
                'group' => 'system',
                'is_public' => true
            ],
            [
                'key' => 'instagram_url',
                'value' => '',
                'type' => 'text',
                'group' => 'system',
                'is_public' => true
            ],
            [
                'key' => 'telegram_url',
                'value' => '',
                'type' => 'text',
                'group' => 'system',
                'is_public' => true
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
