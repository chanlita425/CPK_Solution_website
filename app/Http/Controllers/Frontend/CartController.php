<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    // public function index()
    // {
    //     $cart = session()->get('cart', []);
    //     $settings = Setting::getSettings();

    //     // Calculate cart totals
    //     $subtotal = 0;
    //     $items = [];

    //     foreach ($cart as $id => $details) {
    //         $product = Product::find($id);
    //         if ($product && $product->is_active) {
    //             $itemTotal = $product->price * $details['quantity'];
    //             $subtotal += $itemTotal;
    //             $items[] = [
    //                 'id' => $product->id,
    //                 'name' => $product->name, // Uses accessor for localization
    //                 'name_en' => $product->name_en,
    //                 'name_kh' => $product->name_kh,
    //                 'price' => $product->price,
    //                 'price_formatted' => number_format($product->price, 2),
    //                 'quantity' => $details['quantity'],
    //                 'line_total' => $itemTotal,
    //                 'line_total_formatted' => number_format($itemTotal, 2),
    //                 'image_url' => $product->main_image_url,
    //                 'max_quantity' => $product->quantity,
    //                 'sku' => $product->SKU,
    //             ];
    //         }
    //     }

    //     // Get coupon if applied
    //     $coupon = session()->get('coupon', null);
    //     $discount = 0;

    //     if ($coupon) {
    //         $couponModel = \App\Models\Coupon::where('code', $coupon['code'])->first();
    //         if ($couponModel && $couponModel->isValid() && $subtotal >= $couponModel->min_order_amount) {
    //             if ($couponModel->type === 'percent') {
    //                 $discount = $subtotal * ($couponModel->value / 100);
    //             } else {
    //                 $discount = $couponModel->value;
    //             }
    //             $discount = min($discount, $subtotal);
    //         } else {
    //             // Invalid coupon, remove from session
    //             session()->forget('coupon');
    //             $coupon = null;
    //         }
    //     }

    //     $shipping = $subtotal > 0 ? $settings->shipping_fee : 0;
    //     $tax = ($subtotal - $discount) * ($settings->tax_percent / 100);
    //     $total = $subtotal - $discount + $shipping + $tax;

    //     // Get similar products for cart page (4 items)
    //     $similarProducts = Product::active()
    //         ->with(['category', 'brand', 'images'])
    //         ->inRandomOrder()
    //         ->limit(4)
    //         ->get();

    //     return view('frontend.pages.addProduct', compact(
    //         'cartItems',
    //         'subtotal',
    //         'discount',
    //         'shipping',
    //         'tax',
    //         'total',
    //         'coupon',
    //         'similarProducts',
    //         'settings'
    //     ));
    // }





    public function index(Request $request)
    {
        $cart = session()->get('cart', []); 

        $settings = Setting::getSettings();
        $promoImage = $settings->promotion_banner_image;

        $categoryId = null;
        $brandId = null;


        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        $subtotal = 0;
        $cartItems = [];  

        foreach ($cart as $id => $details) {
            $product = Product::find($id);

            if ($product && $product->is_active) {
                $itemTotal = $product->price * $details['quantity'];
                $subtotal += $itemTotal;

                $cartItems[] = [ // ✅ FIXED
                    'id' => $product->id,
                    'name' => $product->name,
                    'name_en' => $product->name_en,
                    'name_kh' => $product->name_kh,
                    'price' => $product->price,
                    'price_formatted' => number_format($product->price, 2),
                    'qty' => $details['quantity'],  
                    'line_total' => $itemTotal,
                    'line_total_formatted' => number_format($itemTotal, 2),
                    'image' => $product->main_image_url,  
                    'slug' => $product->id,
                    'max_quantity' => $product->quantity,
                    'sku' => $product->SKU,
                ];
            }
        }


        $query = Product::active();

        $allProducts = $query->latest()->get();
        $totalItems = $allProducts->count();

        $perPage = ['xs' => 5, 'sm' => 10, 'lg' => 4];

        $pageXs = max(1, (int) $request->input('page_xs', 1));
        $pageSm = max(1, (int) $request->input('page_sm', 1));
        $pageLg = max(1, (int) $request->input('page_lg', 1));

        $productsXs = $allProducts->forPage($pageXs, $perPage['xs'])->values();
        $productsSm = $allProducts->forPage($pageSm, $perPage['sm'])->values();
        $productsLg = $allProducts->forPage($pageLg, $perPage['lg'])->values();

        $totalPagesXs = ceil($totalItems / $perPage['xs']);
        $totalPagesSm = ceil($totalItems / $perPage['sm']);
        $totalPagesLg = ceil($totalItems / $perPage['lg']);

        $pgUrl = url()->current();
        $promoPosition = 3;

        // COUPON
        $coupon = session()->get('coupon', null);
        $discount = 0;

        if ($coupon) {
            $couponModel = \App\Models\Coupon::where('code', $coupon['code'])->first();

            if ($couponModel && $couponModel->isValid() && $subtotal >= $couponModel->min_order_amount) {
                $discount = $couponModel->type === 'percent'
                    ? $subtotal * ($couponModel->value / 100)
                    : $couponModel->value;

                $discount = min($discount, $subtotal);
            } else {
                session()->forget('coupon');
                $coupon = null;
            }
        }

        $shipping = $subtotal > 0 ? $settings->shipping_fee : 0;
        $tax = ($subtotal - $discount) * ($settings->tax_percent / 100);
        $total = $subtotal - $discount + $shipping + $tax;

        $similarProducts = Product::active()
            ->with(['category', 'brand', 'images'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('frontend.pages.addProduct', compact(
            'cartItems', 
            'subtotal',
            'discount',
            'shipping',
            'tax',
            'total',
            'coupon',
            'similarProducts',
            'settings',
            'categories',
            'brands',
            'promoImage',
            'categoryId',
            'brandId',
            'productsXs',
            'productsSm',
            'productsLg',
            'pageXs',
            'pageSm',
            'pageLg',
            'totalPagesXs',
            'totalPagesSm',
            'totalPagesLg',
            'pgUrl',
            'promoPosition',
            'totalItems'
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
    // public function update(Request $request, $id)
    // {
    //     $cart = session()->get('cart', []);
    //     $product = Product::findOrFail($id);

    //     if (!isset($cart[$id])) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Item not found in cart.'
    //         ], 404);
    //     }

    //     $quantity = $request->input('quantity', 1);
    //     $removed = false;

    //     if ($quantity <= 0) {
    //         unset($cart[$id]);
    //         $removed = true;
    //         session()->put('cart', $cart);
    //     } else {
    //         if (!$product->hasStock($quantity)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Insufficient stock. Only ' . $product->quantity . ' available.'
    //             ], 400);
    //         }
    //         $cart[$id]['quantity'] = $quantity;
    //         session()->put('cart', $cart);
    //     }

    //     // Recalculate all totals
    //     $cart = session()->get('cart', []);
    //     $subtotal = $this->calculateSubtotal($cart);

    //     // Handle coupon validation
    //     $coupon = session()->get('coupon', null);
    //     $discount = 0;

    //     if ($coupon && !empty($cart)) {
    //         $couponModel = \App\Models\Coupon::where('code', $coupon['code'])->first();
    //         if ($couponModel && $couponModel->isValid() && $subtotal >= $couponModel->min_order_amount) {
    //             if ($couponModel->type === 'percent') {
    //                 $discount = $subtotal * ($couponModel->value / 100);
    //             } else {
    //                 $discount = $couponModel->value;
    //             }
    //             $discount = min($discount, $subtotal);
    //         } else {
    //             session()->forget('coupon');
    //             $coupon = null;
    //         }
    //     } elseif ($coupon && empty($cart)) {
    //         session()->forget('coupon');
    //         $coupon = null;
    //     }

    //     $settings = Setting::getSettings();
    //     $shipping = !empty($cart) ? $settings->shipping_fee : 0;
    //     $tax = ($subtotal - $discount) * ($settings->tax_percent / 100);
    //     $total = $subtotal - $discount + $shipping + $tax;
    //     $cartCount = array_sum(array_column($cart, 'quantity'));

    //     $itemLineTotal = $removed ? 0 : $product->price * $quantity;

    //     return response()->json([
    //         'success' => true,
    //         'message' => $removed ? 'Item removed from cart.' : 'Cart updated successfully!',
    //         'removed' => $removed,
    //         'cart_count' => $cartCount,
    //         'item_quantity' => $quantity,
    //         'item_line_total' => number_format($itemLineTotal, 2),
    //         'subtotal' => number_format($subtotal, 2),
    //         'discount' => number_format($discount, 2),
    //         'shipping' => number_format($shipping, 2),
    //         'tax' => number_format($tax, 2),
    //         'total' => number_format($total, 2),
    //     ]);
    // }

    /**
     * Remove item from cart
     */
    // public function remove($id)
    // {
    //     $cart = session()->get('cart', []);

    //     if (isset($cart[$id])) {
    //         unset($cart[$id]);
    //         session()->put('cart', $cart);

    //         // If cart becomes empty, remove coupon
    //         if (empty($cart)) {
    //             session()->forget('coupon');
    //         }
    //     }

    //     return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    // }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $product = Product::findOrFail($id);

        if (!isset($cart[$id])) {
            return response()->json(['success' => false, 'message' => 'Not found']);
        }

        $qty = max(1, (int) $request->quantity);

        if (!$product->hasStock($qty)) {
            return response()->json([
                'success' => false,
                'message' => 'Stock not available'
            ], 400);
        }

        $cart[$id]['quantity'] = $qty;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true
        ]);
    }


    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get cart count for AJAX
    //  */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }

    // /**
    //  * Calculate subtotal from cart
    //  */
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
