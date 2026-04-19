<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_kh',
        'logo_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'km') {
            return $this->name_kh ?: $this->name_en;
        }
        return $this->name_en;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // FIXED: Same pattern as Product's getMainImageUrlAttribute
    public function getLogoUrlAttribute()
    {
        if ($this->logo_image && Storage::disk('public')->exists($this->logo_image)) {
            return Storage::url($this->logo_image);
        }
        return null;
    }

    // ADD THIS - Direct URL accessor (same as Product)
    public function getLogoImageUrlAttribute()
    {
        if ($this->logo_image && Storage::disk('public')->exists($this->logo_image)) {
            return asset('storage/' . $this->logo_image);
        }
        return null;
    }

    public static function isNameUnique($nameEn, $nameKh, $excludeId = null)
    {
        $query = self::query();

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->where(function ($q) use ($nameEn, $nameKh) {
            $q->where('name_en', $nameEn)
                ->orWhere('name_kh', $nameKh);
        })->exists();
    }
}
