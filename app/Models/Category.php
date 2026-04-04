<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_kh', 'icon', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getProductCountAttribute()
    {
        return $this->products()->where('is_active', true)->count();
    }

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale == 'km') {
            return $this->name_kh;
        }
        return $this->name_en;
    }
}
