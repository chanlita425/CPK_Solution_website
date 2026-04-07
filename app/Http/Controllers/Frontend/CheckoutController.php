<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Process checkout and redirect to Telegram
     */
    public function process(Request $request)
    {
        // Validate cart is not empty
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate seller telegram exists
        $sellerTelegram = Setting::getSellerTelegram();
        if (empty($sellerTelegram)) {
            Log::error('Checkout failed: Seller Telegram not configured');
            return redirect()->route('cart.index')->with('error', 'Checkout is temporarily unavailable. Please try again later.');
        }

        // Process checkout with transaction
        DB::beginTransaction();

        try {
            // Calculate totals and validate products
            $subtotal = 0;
            $itemsData = [];

            foreach ($cart as $id => $details) {
                $product = Product::find($id);

                if (!$product || !$product->is_active) {
                    throw new \Exception("Product not available: ID {$id}");
                }

                if (!$product->hasStock($details['quantity'])) {
                    throw new \Exception("Insufficient stock for {$product->name_en}. Available: {$product->quantity}");
                }

                $lineTotal = $product->price * $details['quantity'];
                $subtotal += $lineTotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name_en, // Store English name as reference
                    'price' => $product->price,
                    'quantity' => $details['quantity'],
                    'line_total' => $lineTotal,
                ];
            }

            // Apply coupon if exists in session
            $couponData = session()->get('coupon');
            $discount = 0;
            $couponCode = null;

            if ($couponData) {
                $coupon = Coupon::where('code', $couponData['code'])->first();
                if ($coupon && $coupon->isValid() && $subtotal >= $coupon->min_order_amount) {
                    if ($coupon->type === 'percent') {
                        $discount = $subtotal * ($coupon->value / 100);
                    } else {
                        $discount = $coupon->value;
                    }
                    $discount = min($discount, $subtotal);
                    $couponCode = $coupon->code;
                } else {
                    // Invalid coupon, remove from session but continue checkout
                    session()->forget('coupon');
                }
            }

            $settings = Setting::getSettings();
            $shipping = $settings->shipping_fee;
            $taxableAmount = $subtotal - $discount;
            $tax = $taxableAmount * ($settings->tax_percent / 100);
            $total = $subtotal - $discount + $shipping + $tax;

            // Create order
            $order = Order::create([
                'order_code' => Order::generateOrderCode(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'coupon_code' => $couponCode,
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($itemsData as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['line_total'],
                ]);
            }

            DB::commit();

            // Clear cart and coupon from session
            session()->forget('cart');
            session()->forget('coupon');

            // Store order ID in session for success message
            session()->flash('order_success', [
                'order_code' => $order->order_code,
                'total' => $total,
            ]);

            // Redirect to Telegram with order details
            $telegramUrl = $order->getTelegramRedirectUrl();

            return redirect()->away($telegramUrl);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }
}
