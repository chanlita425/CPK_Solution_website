<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;

class ProductController extends Controller
{
    // public function show($id)
    // {
    //     $product = Product::active()
    //         ->with(['category', 'brand', 'images'])
    //         ->findOrFail($id);

    //     $settings = Setting::getSettings();

    //     // Get similar products (same category, exclude current, 8 per page)
    //     $similarProducts = Product::active()
    //         ->where('id', '!=', $product->id)
    //         ->where('category_id', $product->category_id)
    //         ->with(['category', 'brand', 'images'])
    //         ->paginate(8);

    //     return view('userUi.product-detail', compact(
    //         'product',
    //         'settings',
    //         'similarProducts'
    //     ));
    // }


    // public function show($id)
    // {
    //     $product = Product::active()
    //         ->with(['category', 'brand', 'images'])
    //         ->findOrFail($id);

    //     $settings = Setting::getSettings();

    //     // Priority: same category + brand
    //     $similarProducts = Product::active()
    //         ->where('id', '!=', $product->id)
    //         ->where('category_id', $product->category_id)
    //         ->where('brand_id', $product->brand_id)
    //         ->with(['category', 'brand', 'images'])
    //         ->take(8)
    //         ->get();

    //     // Fallback: same category
    //     if ($similarProducts->count() < 8) {
    //         $moreProducts = Product::active()
    //             ->where('id', '!=', $product->id)
    //             ->where('category_id', $product->category_id)
    //             ->whereNotIn('id', $similarProducts->pluck('id'))
    //             ->with(['category', 'brand', 'images'])
    //             ->take(8 - $similarProducts->count())
    //             ->get();

    //         $similarProducts = $similarProducts->merge($moreProducts);
    //     }

    //     return view('frontend.pages.viewProduct', compact(
    //         'product',
    //         'settings',
    //         'similarProducts'
    //     ));
    // }

public function show($id)
{
    $product = Product::active()
        ->with(['category', 'brand', 'images', 'mainImage'])
        ->findOrFail($id);

    $settings = Setting::getSettings();

    // Prepare product data array for Blade
    $productData = [
        'id' => $product->id,
        'name' => $product->name_en,
        'sku' => $product->SKU,
        'price' => $product->price,
        'image' => $product->mainImage?->image,
        'gallery' => $product->images->pluck('image')->toArray(),
        'brand' => $product->brand?->name_en ?? 'No Brand',
        'category' => $product->category?->name_en ?? 'No Category',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => '/'],
            ['label' => $product->category?->name_en ?? 'Category', 'url' => '/'],
        ],
        'specs' => $product->specifications ? explode(',', $product->specifications) : [],
    ];

    // Get similar products (priority: same category + brand)
    $similarProducts = Product::active()
        ->where('id', '!=', $product->id)
        ->where('category_id', $product->category_id)
        ->where('brand_id', $product->brand_id)
        ->with(['category', 'brand', 'images'])
        ->take(8)
        ->get();

    // Fallback: same category
    if ($similarProducts->count() < 8) {
        $moreProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->whereNotIn('id', $similarProducts->pluck('id'))
            ->with(['category', 'brand', 'images'])
            ->take(8 - $similarProducts->count())
            ->get();

        $similarProducts = $similarProducts->merge($moreProducts);
    }

    // Pass variables to Blade; no need for productsXs/Sm/Lg on product page
    return view('frontend.pages.viewProduct', [
        'product' => $productData,
        'settings' => $settings,
        'similarProducts' => $similarProducts,
    ]);
}
}
