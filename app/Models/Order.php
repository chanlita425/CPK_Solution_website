<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    // Confirm order - NO stock changes
    public function confirm()
    {
        DB::transaction(function () {
            // NO stock checks or reductions
            $this->status = 'confirmed';
            $this->save();
        });

        return true;
    }

    // Cancel order
    public function cancel()
    {
        $this->status = 'cancelled';
        return $this->save();
    }

    // Generate unique order code
    public static function generateOrderCode()
    {
        $prefix = 'ORD';
        $date = date('Ymd');

        $lastOrder = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_code, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $date . $newNumber;
    }

    // Build Telegram message
    public function getTelegramMessage()
    {
        $itemsList = "";
        foreach ($this->items as $index => $item) {
            $itemsList .= ($index + 1) . ". {$item->product_name}\n";
            $itemsList .= "   Quantity: {$item->quantity} x \${$item->price} = \${$item->line_total}\n\n";
        }

        $message = "🛍️ *NEW ORDER #{$this->order_code}*\n\n";
        $message .= "*Order Details:*\n";
        $message .= $itemsList;
        $message .= "---\n";
        $message .= "📊 *Summary:*\n";
        $message .= "Subtotal: \${$this->subtotal}\n";

        if ($this->discount > 0) {
            $message .= "Discount: -\${$this->discount}\n";
        }

        $message .= "Shipping: \${$this->shipping}\n";
        $message .= "Tax: \${$this->tax}\n";
        $message .= "*Total: \${$this->total}*\n\n";
        $message .= "📅 Date: " . $this->created_at->format('M d, Y h:i A') . "\n";
        $message .= "🔗 Order ID: #{$this->id}";

        return $message;
    }

    // Get Telegram redirect URL with prefilled message
    public function getTelegramRedirectUrl()
    {
        $sellerTelegram = Setting::getSellerTelegram();

        // Remove @ if present and clean username
        $username = ltrim($sellerTelegram, '@');

        $message = urlencode($this->getTelegramMessage());

        return "https://t.me/{$username}?text={$message}";
    }
}
