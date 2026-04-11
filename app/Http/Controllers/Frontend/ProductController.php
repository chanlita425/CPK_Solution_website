<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting; 
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request; 

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


    public function show($id, Request $request)
    {
        $product = Product::active()
            ->with(['category', 'brand', 'images'])
            ->findOrFail($id);

        $settings = Setting::getSettings();
        $promoImage = $settings->promotion_banner_image;

        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        $categoryId = null;
        $brandId = null;

        $mainImage = $product->images->first();
        $thumbnails = $product->images->skip(1);

        $query = Product::active();

        $allProducts = $query->latest()->get();
        $totalItems = $allProducts->count();

        $perPage = ['xs' => 5, 'sm' => 10, 'lg' => 8];

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

        return view('frontend.pages.viewProduct', compact(
            'product',
            'settings',
            'mainImage',
            'thumbnails',
            'categories',
            'promoImage',
            'brands',
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
        ))->with('isHome', false);
    }

}


