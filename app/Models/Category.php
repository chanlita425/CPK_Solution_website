<?php
// app/Models/Category.php

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

    // Helper method to get name based on current locale
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'kh') {
            return $this->name_kh ?: $this->name_en;
        }
        return $this->name_en;
    }

    // Helper to get localized name for admin
    public function getLocalizedName($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $locale === 'kh' ? ($this->name_kh ?: $this->name_en) : $this->name_en;
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Accessor for icon URL
    public function getIconUrlAttribute()
    {
        if ($this->icon_image && Storage::disk('public')->exists($this->icon_image)) {
            return Storage::url($this->icon_image);
        }
        return null;
    }

    // Check if name exists (for validation)
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
