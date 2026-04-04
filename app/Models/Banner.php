<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'image',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeHero($query)
    {
        return $query->where('type', 'hero')->where('is_active', true);
    }

    public function scopePromotion($query)
    {
        return $query->where('type', 'promotion')->where('is_active', true);
    }
}
