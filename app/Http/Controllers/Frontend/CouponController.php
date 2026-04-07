<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Apply coupon to cart
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
        ]);

        // Get cart from session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty. Cannot apply coupon.',
            ], 400);
        }

        // Calculate current subtotal
        $subtotal = $this->calculateSubtotal($cart);

        // Find coupon
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code.',
            ], 400);
        }

        // Check if coupon is valid
        if (!$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has expired or is not active.',
            ], 400);
        }

        // Check minimum order amount
        if ($subtotal < $coupon->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order amount of $" . number_format($coupon->min_order_amount, 2) . " required for this coupon.",
            ], 400);
        }

        // Calculate discount
        $discount = $this->calculateDiscount($coupon, $subtotal);

        // Store coupon in session
        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount_amount' => $discount,
        ]);

        // Get settings for shipping and tax
        $settings = Setting::getSettings();
        $shipping = $settings->shipping_fee;
        $taxableAmount = $subtotal - $discount;
        $tax = $taxableAmount * ($settings->tax_percent / 100);
        $total = $subtotal - $discount + $shipping + $tax;

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'coupon_code' => $coupon->code,
            'subtotal' => number_format($subtotal, 2),
            'discount' => number_format($discount, 2),
            'shipping' => number_format($shipping, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($total, 2),
        ]);
    }

    /**
     * Remove applied coupon
     */
    public function remove(Request $request)
    {
        // Remove coupon from session
        session()->forget('coupon');

        // Get cart from session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => true,
                'message' => 'Coupon removed.',
                'coupon_code' => null,
                'subtotal' => '0.00',
                'discount' => '0.00',
                'shipping' => '0.00',
                'tax' => '0.00',
                'total' => '0.00',
            ]);
        }

        // Calculate subtotal
        $subtotal = $this->calculateSubtotal($cart);

        // Get settings for shipping and tax
        $settings = Setting::getSettings();
        $shipping = $settings->shipping_fee;
        $tax = $subtotal * ($settings->tax_percent / 100);
        $total = $subtotal + $shipping + $tax;

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
            'coupon_code' => null,
            'subtotal' => number_format($subtotal, 2),
            'discount' => '0.00',
            'shipping' => number_format($shipping, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($total, 2),
        ]);
    }

    /**
     * Calculate subtotal from cart
     */
    private function calculateSubtotal($cart)
    {
        $subtotal = 0;
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product && $product->is_active) {
                $subtotal += $product->price * $details['quantity'];
            }
        }
        return $subtotal;
    }

    /**
     * Calculate discount amount
     */
    private function calculateDiscount($coupon, $subtotal)
    {
        if ($coupon->type === 'percent') {
            $discount = $subtotal * ($coupon->value / 100);
            return min($discount, $subtotal);
        } else {
            // Fixed amount
            return min($coupon->value, $subtotal);
        }
    }
}
