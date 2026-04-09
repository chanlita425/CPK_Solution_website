<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display homepage with product listing
     *
     * Supports filtering via query parameters:
     * - ?category={id}
     * - ?brand={id}
     */
    // public function index(Request $request)
    // {
    //     $settings = Setting::getSettings();

    //     $categories = Category::where('is_active', true)->get();
    //     $brands = Brand::where('is_active', true)->get();

    //     $products = $this->getFilteredProducts($request);

    //     // If AJAX request, return only the products grid
    //     if ($request->wantsJson()) {
    //         return response()->json([
    //             'success' => true,
    //             'products_html' => view('userUi.components.product-grid', ['products' => $products])->render(),
    //             'pagination_html' => $products->hasPages()
    //                 ? view('userUi.components.pagination', ['paginator' => $products])->render()
    //                 : '',
    //         ]);
    //     }

    //     return view('userUi.home', compact(
    //         'settings',
    //         'categories',
    //         'brands',
    //         'products'
    //     ));
    // }


public function index(Request $request)
{

    $settings = Setting::getSettings();
    $promoImage = $settings->promotion_banner_image; 
    
    // filter
    $categoryId = $request->input('category_id');
    $brandId = $request->input('brand_id');

    // Build query with relationships
    $query = Product::with('mainImage')->active();

    // category
    if ($categoryId) {
        $query->ofCategory($categoryId);
        $categoryName = Category::find($categoryId)?->name_en ?? 'Category';
    } else {
        $categoryName = 'Smart lock key';
    }

    // brand
     if ($brandId) {
        $query->ofBrand($brandId); // scopeOfBrand in Product model
        $brandName = Brand::find($brandId)?->name_en ?? null;
    } else {
        $brandName = null;
    }

    // Get all matching products
    $allProducts = $query->latest()->get();
    $totalItems = $allProducts->count();

    // Pagination per screen size
    $perPage = [
        'xs' => 5,
        'sm' => 10,
        'lg' => 14,
    ];

    $pageXs = max(1, (int) $request->input('page_xs', 1));
    $pageSm = max(1, (int) $request->input('page_sm', 1));
    $pageLg = max(1, (int) $request->input('page_lg', 1));

    // Slice products for each screen size (values() resets array keys)
    $productsXs = $allProducts->forPage($pageXs, $perPage['xs'])->values();
    $productsSm = $allProducts->forPage($pageSm, $perPage['sm'])->values();
    $productsLg = $allProducts->forPage($pageLg, $perPage['lg'])->values();

    // Total pages
    $totalPagesXs = ceil($totalItems / $perPage['xs']);
    $totalPagesSm = ceil($totalItems / $perPage['sm']);
    $totalPagesLg = ceil($totalItems / $perPage['lg']);

    // Pagination base URL
    $pgUrl = url()->current();

    // Promo card position for LG
    $promoPosition = 3;

    return view('frontend.pages.home', compact(
        'categoryName',
        'totalItems',
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
        'promoImage',
        'categoryId',
        'brandId'
    ));
}




    /**
     * Legacy filter endpoint - redirects to homepage with query params
     * Kept for backward compatibility with existing frontend code
     */
    public function filter(Request $request)
    {
        $params = [];

        if ($request->filled('category')) {
            $params['category'] = $request->category;
        }

        if ($request->filled('brand')) {
            $params['brand'] = $request->brand;
        }

        $redirectUrl = route('home');

        if (!empty($params)) {
            $redirectUrl .= '?' . http_build_query($params);
        }

        if ($request->wantsJson()) {
            $products = $this->getFilteredProducts($request);

            return response()->json([
                'success' => true,
                'products_html' => view('userUi.components.product-grid', ['products' => $products])->render(),
                'pagination_html' => $products->hasPages()
                    ? view('userUi.components.pagination', ['paginator' => $products])->render()
                    : '',
            ]);
        }

        return redirect($redirectUrl);
    }

    /**
     * Get filtered products based on request parameters
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function getFilteredProducts(Request $request)
    {
        $query = Product::active()
            ->with(['category', 'brand', 'images'])
            ->orderBy('id', 'desc');

        // Apply category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Apply brand filter
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        return $query->paginate(14);
    }
}
