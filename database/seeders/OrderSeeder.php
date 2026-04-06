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
        // Get all products
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('No products found. Please run ProductSeeder first.');
            return;
        }

        // Create orders with different statuses using unique order codes
        $ordersData = [
            [
                'subtotal' => 1299.99,
                'discount' => 0,
                'shipping' => 5.00,
                'tax' => 129.99,
                'total' => 1434.98,
                'coupon_code' => null,
                'status' => 'pending',
                'created_at' => Carbon::now(),
            ],
            [
                'subtotal' => 1199.99,
                'discount' => 119.99,
                'shipping' => 5.00,
                'tax' => 108.00,
                'total' => 1193.00,
                'coupon_code' => 'WELCOME10',
                'status' => 'confirmed',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'subtotal' => 299.99,
                'discount' => 0,
                'shipping' => 5.00,
                'tax' => 30.00,
                'total' => 334.99,
                'coupon_code' => null,
                'status' => 'cancelled',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'subtotal' => 179.99,
                'discount' => 35.99,
                'shipping' => 5.00,
                'tax' => 14.40,
                'total' => 163.40,
                'coupon_code' => 'SAVE20',
                'status' => 'pending',
                'created_at' => Carbon::now()->subHours(5),
            ],
            [
                'subtotal' => 499.99,
                'discount' => 0,
                'shipping' => 5.00,
                'tax' => 50.00,
                'total' => 554.99,
                'coupon_code' => null,
                'status' => 'confirmed',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'subtotal' => 89.99,
                'discount' => 8.99,
                'shipping' => 5.00,
                'tax' => 8.10,
                'total' => 94.10,
                'coupon_code' => 'WEEKEND15',
                'status' => 'pending',
                'created_at' => Carbon::now()->subHours(2),
            ],
            [
                'subtotal' => 349.99,
                'discount' => 0,
                'shipping' => 5.00,
                'tax' => 35.00,
                'total' => 389.99,
                'coupon_code' => null,
                'status' => 'confirmed',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'subtotal' => 699.99,
                'discount' => 69.99,
                'shipping' => 5.00,
                'tax' => 63.00,
                'total' => 698.00,
                'coupon_code' => 'SUMMER25',
                'status' => 'cancelled',
                'created_at' => Carbon::now()->subDays(7),
            ],
        ];

        foreach ($ordersData as $index => $orderData) {
            // Generate unique order code with different timestamps
            $prefix = 'ORD';
            $date = Carbon::parse($orderData['created_at'])->format('Ymd');
            $sequence = str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            $orderCode = $prefix . $date . $sequence;

            $order = Order::create([
                'order_code' => $orderCode,
                'subtotal' => $orderData['subtotal'],
                'discount' => $orderData['discount'],
                'shipping' => $orderData['shipping'],
                'tax' => $orderData['tax'],
                'total' => $orderData['total'],
                'coupon_code' => $orderData['coupon_code'],
                'status' => $orderData['status'],
                'created_at' => $orderData['created_at'],
                'updated_at' => $orderData['created_at'],
            ]);

            // Add random order items (1-3 items per order)
            $randomProducts = $products->random(min(rand(1, 3), $products->count()));
            foreach ($randomProducts as $product) {
                $quantity = rand(1, 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name_en,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'line_total' => $product->price * $quantity,
                ]);
            }

            // Recalculate order totals based on actual items
            $newSubtotal = $order->items->sum('line_total');
            $newTax = $newSubtotal * 0.10;
            $newTotal = $newSubtotal + 5.00 + $newTax;

            $order->update([
                'subtotal' => $newSubtotal,
                'tax' => $newTax,
                'total' => $newTotal,
            ]);
        }
    }
}
