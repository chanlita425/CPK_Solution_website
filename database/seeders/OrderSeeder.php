<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('No products found. Please run ProductSeeder first.');
            return;
        }

        // Create 30 orders for pagination testing
        $statuses = ['pending', 'confirmed', 'cancelled'];

        for ($i = 1; $i <= 30; $i++) {
            $status = $statuses[array_rand($statuses)];
            $createdAt = Carbon::now()->subDays(rand(0, 30));
            $orderCode = 'ORD' . $createdAt->format('Ymd') . str_pad($i, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'order_code' => $orderCode,
                'subtotal' => 0,
                'discount' => rand(0, 1) ? rand(5, 30) : 0,
                'shipping' => 5.00,
                'tax' => 0,
                'total' => 0,
                'coupon_code' => rand(0, 1) ? ['WELCOME10', 'SAVE20', 'SUMMER25'][array_rand(['WELCOME10', 'SAVE20', 'SUMMER25'])] : null,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Add 1-4 items per order
            $randomProducts = $products->random(min(rand(1, 4), $products->count()));
            foreach ($randomProducts as $product) {
                $quantity = rand(1, 3);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name_en,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'line_total' => $product->price * $quantity,
                ]);
            }

            // Recalculate totals
            $subtotal = $order->items->sum('line_total');
            $discount = $order->discount;
            $shipping = 5.00;
            $tax = ($subtotal - $discount) * 0.10;
            $total = $subtotal - $discount + $shipping + $tax;

            $order->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]);
        }
    }
}
