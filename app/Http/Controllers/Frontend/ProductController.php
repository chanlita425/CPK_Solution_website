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

        $categoryId = $request->input('category_id');
        $brandId    = $request->input('brand_id');

        $mainImage  = $product->images->first();
        $thumbnails = $product->images->skip(1);

        $query = Product::active()
            ->where('id', '!=', $product->id);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        // No explicit filters → same category first (0), then others (1)
        if (!$brandId && !$categoryId) {
            $query->orderByRaw('
                CASE
                    WHEN category_id = ? THEN 0
                    ELSE 1
                END
            ', [$product->category_id]);
        }

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

        // Partial request — SPA navigation (no layout, just content)
        if ($request->header('X-Partial') === '1') {
            $html = view('frontend.pages.viewProduct_partial', [
                'product'       => $product,
                'productsXs'    => $productsXs,
                'productsSm'    => $productsSm,
                'productsLg'    => $productsLg,
                'pageXs'        => $pageXs,
                'pageSm'        => $pageSm,
                'pageLg'        => $pageLg,
                'totalPagesXs'  => $totalPagesXs,
                'totalPagesSm'  => $totalPagesSm,
                'totalPagesLg'  => $totalPagesLg,
                'categoryId'    => $categoryId,
                'brandId'       => $brandId,
                'isHome'        => false,
                'promoImage'    => $promoImage,
                'promoPosition' => $promoPosition,
            ])->render();

            return response()->json([
                'html'  => $html,
                'title' => $product->name,
            ]);
        }

        // AJAX filter request — return only the product grid HTML
        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.components.cards.cardResponsive', [
                    'productsXs'    => $productsXs,
                    'productsSm'    => $productsSm,
                    'productsLg'    => $productsLg,
                    'pageXs'        => $pageXs,
                    'pageSm'        => $pageSm,
                    'pageLg'        => $pageLg,
                    'totalPagesXs'  => $totalPagesXs,
                    'totalPagesSm'  => $totalPagesSm,
                    'totalPagesLg'  => $totalPagesLg,
                    'categoryId'    => $categoryId,
                    'brandId'       => $brandId,
                    'isHome'        => false,
                    'promoImage'    => $promoImage,
                    'promoPosition' => $promoPosition,
                ])->render(),
                'category_id' => $categoryId,
                'brand_id'    => $brandId,
            ]);
        }

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


