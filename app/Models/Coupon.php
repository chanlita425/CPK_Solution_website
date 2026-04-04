<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'minimum_order',
        'valid_from',
        'valid_until',
        'usage_limit',
        'used_count',
        'is_active'
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'minimum_order' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'used_count' => 'integer',
    ];

    public function isValid()
    {
        $now = now();
        return $this->is_active &&
            $now->between($this->valid_from, $this->valid_until) &&
            ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    public function calculateDiscount($subtotal)
    {
        if ($subtotal < $this->minimum_order) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            return $subtotal * ($this->discount_value / 100);
        }

        return min($this->discount_value, $subtotal);
    }
}
