<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name_en',
        'name_kh',
        'SKU',
        'price',
        'specification_en',
        'specification_kh',
        'quantity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Localized name accessor
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'kh') {
            return $this->name_kh ?: $this->name_en;
        }
        return $this->name_en;
    }

    // Localized specification accessor
    public function getSpecificationAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'kh') {
            return $this->specification_kh ?: $this->specification_en;
        }
        return $this->specification_en;
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Get main product image
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    // Get main image URL (helper)
    public function getMainImageUrlAttribute()
    {
        $mainImage = $this->images()->where('is_main', true)->first();
        if ($mainImage && $mainImage->image && Storage::disk('public')->exists($mainImage->image)) {
            return Storage::url($mainImage->image);
        }

        $firstImage = $this->images()->first();
        if ($firstImage && $firstImage->image && Storage::disk('public')->exists($firstImage->image)) {
            return Storage::url($firstImage->image);
        }

        return null;
    }

    // Get all image URLs
    public function getImageUrlsAttribute()
    {
        return $this->images->map(function ($image) {
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                return Storage::url($image->image);
            }
            return null;
        })->filter()->values();
    }

    // Stock management
    public function hasStock($quantity = 1)
    {
        return $this->quantity >= $quantity;
    }

    public function decreaseStock($quantity)
    {
        $this->quantity -= $quantity;
        return $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->quantity += $quantity;
        return $this->save();
    }

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Search scope
    public function scopeSearch($query, $term)
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('SKU', 'like', "%{$term}%")
                ->orWhere('name_en', 'like', "%{$term}%")
                ->orWhere('name_kh', 'like', "%{$term}%")
                ->orWhereHas('category', function ($cat) use ($term) {
                    $cat->where('name_en', 'like', "%{$term}%")
                        ->orWhere('name_kh', 'like', "%{$term}%");
                })
                ->orWhereHas('brand', function ($brand) use ($term) {
                    $brand->where('name_en', 'like', "%{$term}%")
                        ->orWhere('name_kh', 'like', "%{$term}%");
                });
        });
    }

    // Filter by category
    public function scopeOfCategory($query, $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    // Filter by brand
    public function scopeOfBrand($query, $brandId)
    {
        if ($brandId) {
            return $query->where('brand_id', $brandId);
        }
        return $query;
    }

    // Get similar products (same category, exclude current)
    public function similarProducts($limit = 8)
    {
        return self::active()
            ->where('id', '!=', $this->id)
            ->where('category_id', $this->category_id)
            ->limit($limit)
            ->get();
    }
}
