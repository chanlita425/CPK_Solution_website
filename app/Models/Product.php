<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'kh') {
            return $this->name_kh ?: $this->name_en;
        }
        return $this->name_en;
    }

    public function getSpecificationAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'kh') {
            return $this->specification_kh ?: $this->specification_en;
        }
        return $this->specification_en;
    }

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
}
