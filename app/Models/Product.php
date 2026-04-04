<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'sku',
        'model_number',
        'price',
        'quantity',
        'title_en',
        'title_kh',
        'specification_en',
        'specification_kh',
        'images',
        'is_active',
        'is_featured'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getMainImageAttribute()
    {
        $images = $this->images;
        if ($images && is_array($images) && count($images) > 0) {
            return $images[0];
        }
        return null;
    }

    public function getGalleryImagesAttribute()
    {
        $images = $this->images;
        if ($images && is_array($images) && count($images) > 1) {
            return array_slice($images, 1, 4);
        }
        return [];
    }

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        if ($locale == 'km') {
            return $this->title_kh;
        }
        return $this->title_en;
    }

    public function getSpecificationAttribute()
    {
        $locale = app()->getLocale();
        if ($locale == 'km') {
            return $this->specification_kh;
        }
        return $this->specification_en;
    }
}
