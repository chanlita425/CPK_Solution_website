<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_kh',
        'icon_image',
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

    public function getLocalizedName($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $locale === 'km' ? ($this->name_kh ?: $this->name_en) : $this->name_en;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // FIXED: Same pattern as Product's getMainImageUrlAttribute
    public function getIconUrlAttribute()
    {
        if ($this->icon_image && Storage::disk('public')->exists($this->icon_image)) {
            return Storage::url($this->icon_image);
        }
        return null;
    }

    // ADD THIS - Direct URL accessor (same as Product)
    public function getIconImageUrlAttribute()
    {
        if ($this->icon_image && Storage::disk('public')->exists($this->icon_image)) {
            return asset('storage/' . $this->icon_image);
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
