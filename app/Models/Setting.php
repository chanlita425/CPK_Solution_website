<?php
// app/Models/Setting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_url',
        'company_phone_number_first',
        'company_phone_number_second',
        'company_logo',
        'about_company',
        'hero_banner_image',
        'promotion_banner_image',
        'facebook_link',
        'telegram_link',
        'tiktok_link',
        'instagram_link',
        'shipping_fee',
        'tax_percent',
        'seller_telegram',
    ];

    protected $casts = [
        'shipping_fee' => 'decimal:2',
        'tax_percent' => 'decimal:2',
    ];

    public static function getSettings()
    {
        $settings = self::first();
        if (!$settings) {
            $settings = self::create([
                'company_name' => 'CPK Solution',
                'shipping_fee' => 5.00,
                'tax_percent' => 10.00,
            ]);
        }
        return $settings;
    }
}
