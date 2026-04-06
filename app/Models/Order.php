<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'subtotal',
        'discount',
        'shipping',
        'tax',
        'total',
        'coupon_code',
        'customer_name',
        'customer_phone',
        'customer_address',
        'note',
        'status',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function confirm()
    {
        foreach ($this->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->decreaseStock($item->quantity);
            }
        }

        $this->status = 'confirmed';
        return $this->save();
    }

    public function cancel()
    {
        $this->status = 'cancelled';
        return $this->save();
    }

    public static function generateOrderCode()
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $lastOrder = self::whereDate('created_at', today())->latest()->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_code, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $date . $newNumber;
    }
}
