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
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);

        $settings = Setting::getSettings();
        $promoImage = $settings->promotion_banner_image;

        $categoryId = $request->input('category_id');
        $brandId    = $request->input('brand_id');

        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $subtotal   = 0;
        $cartItems  = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);

            if ($product && $product->is_active) {
                $itemTotal = $product->price * $details['quantity'];
                $subtotal += $itemTotal;

                $cartItems[] = [
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
                    'sku' => $product->SKU,
                ];
            }
        }

        $query = Product::active();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

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

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;
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

        return redirect()->route('cart.index')->with('success', 'Product added to cart!')
                        ->withFragment('order_card');;
    }

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
        $cart[$id]['quantity'] = $qty;
        session()->put('cart', $cart);

        // Recalculate totals
        $settings = Setting::getSettings();
        $subtotal = 0;
        foreach ($cart as $pid => $details) {
            $p = Product::find($pid);
            if ($p && $p->is_active) {
                $subtotal += $p->price * $details['quantity'];
            }
        }

        $coupon = session()->get('coupon', null);
        $discount = 0;
        if ($coupon) {
            $couponModel = \App\Models\Coupon::where('code', $coupon['code'])->first();
            if ($couponModel && $couponModel->isValid() && $subtotal >= $couponModel->min_order_amount) {
                $discount = $couponModel->type === 'percent'
                    ? $subtotal * ($couponModel->value / 100)
                    : $couponModel->value;
                $discount = min($discount, $subtotal);
            }
        }

        $shipping = $subtotal > 0 ? $settings->shipping_fee : 0;
        $tax      = ($subtotal - $discount) * ($settings->tax_percent / 100);
        $total    = $subtotal - $discount + $shipping + $tax;

        return response()->json([
            'success'  => true,
            'subtotal' => number_format($subtotal, 2),
            'shipping' => number_format($shipping, 2),
            'tax'      => number_format($tax, 2),
            'total'    => number_format($total, 2),
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
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }

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
