<?php
// app/Models/Setting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'popup_banner_image',
        'favicon',
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

    /**
     * Get settings (always returns a record)
     */
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

    // Helper methods
    public static function getShippingFee()
    {
        return self::getSettings()->shipping_fee;
    }

    public static function getTaxPercent()
    {
        return self::getSettings()->tax_percent;
    }

    public static function getSellerTelegram()
    {
        return self::getSettings()->seller_telegram;
    }

    // NEW: Get popup banner URL
    public function getPopupBannerUrlAttribute()
    {
        if ($this->popup_banner_image && Storage::disk('public')->exists($this->popup_banner_image)) {
            return Storage::url($this->popup_banner_image);
        }
        return null;
    }

    // NEW: Get favicon URL
    public function getFaviconUrlAttribute()
    {
        if ($this->favicon && Storage::disk('public')->exists($this->favicon)) {
            return Storage::url($this->favicon);
        }
        return null;
    }
}
