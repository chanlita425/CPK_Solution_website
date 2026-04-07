<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::active()
            ->with(['category', 'brand', 'images'])
            ->findOrFail($id);

        $settings = Setting::getSettings();

        // Get similar products (same category, exclude current, 8 per page)
        $similarProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->with(['category', 'brand', 'images'])
            ->paginate(8);

        return view('userUi.product-detail', compact(
            'product',
            'settings',
            'similarProducts'
        ));
    }
}
