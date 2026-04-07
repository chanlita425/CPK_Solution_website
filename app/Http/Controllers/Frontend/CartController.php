<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $settings = Setting::getSettings();

        // Calculate cart totals
        $subtotal = 0;
        $items = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product && $product->is_active) {
                $itemTotal = $product->price * $details['quantity'];
                $subtotal += $itemTotal;
                $items[] = [
                    'id' => $product->id,
                    'name' => $product->name, // Uses accessor for localization
                    'name_en' => $product->name_en,
                    'name_kh' => $product->name_kh,
                    'price' => $product->price,
                    'price_formatted' => number_format($product->price, 2),
                    'quantity' => $details['quantity'],
                    'line_total' => $itemTotal,
                    'line_total_formatted' => number_format($itemTotal, 2),
                    'image_url' => $product->main_image_url,
                    'max_quantity' => $product->quantity,
                    'sku' => $product->SKU,
                ];
            }
        }

        // Get coupon if applied
        $coupon = session()->get('coupon', null);
        $discount = 0;

        if ($coupon) {
            $couponModel = \App\Models\Coupon::where('code', $coupon['code'])->first();
            if ($couponModel && $couponModel->isValid() && $subtotal >= $couponModel->min_order_amount) {
                if ($couponModel->type === 'percent') {
                    $discount = $subtotal * ($couponModel->value / 100);
                } else {
                    $discount = $couponModel->value;
                }
                $discount = min($discount, $subtotal);
            } else {
                // Invalid coupon, remove from session
                session()->forget('coupon');
                $coupon = null;
            }
        }

        $shipping = $subtotal > 0 ? $settings->shipping_fee : 0;
        $tax = ($subtotal - $discount) * ($settings->tax_percent / 100);
        $total = $subtotal - $discount + $shipping + $tax;

        // Get similar products for cart page (4 items)
        $similarProducts = Product::active()
            ->with(['category', 'brand', 'images'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('userUi.cart', compact(
            'items',
            'subtotal',
            'discount',
            'shipping',
            'tax',
            'total',
            'coupon',
            'similarProducts',
            'settings'
        ));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request, $id)
    {
        $product = Product::active()->findOrFail($id);
        $quantity = $request->input('quantity', 1);

        // Check stock availability
        if (!$product->hasStock($quantity)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available. Only ' . $product->quantity . ' left.'
                ], 400);
            }
            return back()->with('error', 'Insufficient stock available.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;
            if (!$product->hasStock($newQuantity)) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot add more. Maximum stock available: ' . $product->quantity
                    ], 400);
                }
                return back()->with('error', 'Cannot add more. Maximum stock available: ' . $product->quantity);
            }
            $cart[$id]['quantity'] = $newQuantity;
        } else {
            $cart[$id] = [
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $product = Product::findOrFail($id);

        if (!isset($cart[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart.'
            ], 404);
        }

        $quantity = $request->input('quantity', 1);
        $removed = false;

        if ($quantity <= 0) {
            unset($cart[$id]);
            $removed = true;
            session()->put('cart', $cart);
        } else {
            if (!$product->hasStock($quantity)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $product->quantity . ' available.'
                ], 400);
            }
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        // Recalculate all totals
        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);

        // Handle coupon validation
        $coupon = session()->get('coupon', null);
        $discount = 0;

        if ($coupon && !empty($cart)) {
            $couponModel = \App\Models\Coupon::where('code', $coupon['code'])->first();
            if ($couponModel && $couponModel->isValid() && $subtotal >= $couponModel->min_order_amount) {
                if ($couponModel->type === 'percent') {
                    $discount = $subtotal * ($couponModel->value / 100);
                } else {
                    $discount = $couponModel->value;
                }
                $discount = min($discount, $subtotal);
            } else {
                session()->forget('coupon');
                $coupon = null;
            }
        } elseif ($coupon && empty($cart)) {
            session()->forget('coupon');
            $coupon = null;
        }

        $settings = Setting::getSettings();
        $shipping = !empty($cart) ? $settings->shipping_fee : 0;
        $tax = ($subtotal - $discount) * ($settings->tax_percent / 100);
        $total = $subtotal - $discount + $shipping + $tax;
        $cartCount = array_sum(array_column($cart, 'quantity'));

        $itemLineTotal = $removed ? 0 : $product->price * $quantity;

        return response()->json([
            'success' => true,
            'message' => $removed ? 'Item removed from cart.' : 'Cart updated successfully!',
            'removed' => $removed,
            'cart_count' => $cartCount,
            'item_quantity' => $quantity,
            'item_line_total' => number_format($itemLineTotal, 2),
            'subtotal' => number_format($subtotal, 2),
            'discount' => number_format($discount, 2),
            'shipping' => number_format($shipping, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($total, 2),
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            // If cart becomes empty, remove coupon
            if (empty($cart)) {
                session()->forget('coupon');
            }
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');
        session()->forget('coupon');

        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }

    /**
     * Get cart count for AJAX
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
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
}
