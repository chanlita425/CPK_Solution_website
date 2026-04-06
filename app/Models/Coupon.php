<?php
// app/Models/Coupon.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if (!$this->isValid() || $subtotal < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === 'percent') {
            return $subtotal * ($this->value / 100);
        }

        return min($this->value, $subtotal);
    }
}
