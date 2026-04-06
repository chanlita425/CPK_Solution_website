<?php
// app/Models/Brand.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        if ($locale === 'kh') {
            return $this->name_kh ?: $this->name_en;
        }
        return $this->name_en;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
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
