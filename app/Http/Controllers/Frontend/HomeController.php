<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\ProductService;

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

    // Filters
    $categoryId = $request->input('category_id');
    $brandId = $request->input('brand_id');
    $searchQuery = $request->input('search');

    // Build query
    $query = Product::with('mainImage')->active();

    // Apply category filter
    if ($categoryId) {
        $query->where('category_id', $categoryId);
        $categoryName = Category::find($categoryId)?->name ?? __('messages.categories');
    } else {
        $categoryName = __('messages.all_products');
    }

    // Apply brand filter
    if ($brandId) {
        $query->where('brand_id', $brandId);
        $brandName = Brand::find($brandId)?->name ?? __('messages.brands');
    } else {
        $brandName = __('messages.all_products');
    }

    // Detect if search matches a brand or SKU
    $searchBrandName = null;
    $searchSku = null;
    if ($searchQuery) {
        $isKhmerQuery = (bool) preg_match('/[\x{1780}-\x{17FF}]/u', $searchQuery);
        $nameCol      = $isKhmerQuery ? 'name_kh' : 'name_en';

        $matchedBrand = Brand::where($nameCol, 'like', "%{$searchQuery}%")->first();
        if ($matchedBrand) {
            $searchBrandName = $matchedBrand->name; // locale-aware
        }

        if (!$isKhmerQuery) {
            $matchedSku = Product::where('SKU', 'like', "%{$searchQuery}%")->first();
            if ($matchedSku) {
                $searchSku = $matchedSku->SKU;
            }
        }
    }

    // Apply search filter
    if ($searchQuery) {
        // Detect script: Khmer chars are U+1780–U+17FF
        $isKhmer = (bool) preg_match('/[\x{1780}-\x{17FF}]/u', $searchQuery);
        $nameCol = $isKhmer ? 'name_kh' : 'name_en';

        $query->where(function ($q) use ($searchQuery, $nameCol, $isKhmer) {
            // Match product name in the detected language
            $q->where($nameCol, 'like', "%{$searchQuery}%");

            // SKU is always Latin
            if (!$isKhmer) {
                $q->orWhere('SKU', 'like', "%{$searchQuery}%");
            }

            // Category name in detected language
            $q->orWhereHas('category', fn($q2) =>
                $q2->where($nameCol, 'like', "%{$searchQuery}%")
            );

            // Brand name in detected language
            $q->orWhereHas('brand', fn($q3) =>
                $q3->where($nameCol, 'like', "%{$searchQuery}%")
            );
        });
    }

    // Fetch products
    $allProducts = $query->latest()->get();
    $totalItems = $allProducts->count();

    // Pagination per screen size
    $perPage = ['xs' => 5, 'sm' => 10, 'lg' => 14];
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

    // Load all categories and brands
    $categories = Category::where('is_active', true)->get();
    $brands = Brand::where('is_active', true)->get();

    // AJAX filter request — return only the product grid HTML
    if ($request->ajax()) {
        $isHome = true;
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
                'isHome'        => $isHome,
                'promoImage'    => $promoImage,
                'promoPosition' => $promoPosition,
            ])->render(),
            'category_name'     => $categoryName,
            'total_items'       => $totalItems,
            'category_id'       => $categoryId,
            'brand_id'          => $brandId,
            'search_brand_name' => $searchBrandName,
            'search_sku'        => $searchSku,
        ]);
    }

    return view('frontend.pages.home', compact(
        'settings',
        'promoImage',
        'categories',
        'brands',
        'categoryId',
        'brandId',
        'categoryName',
        'brandName',
        'allProducts',
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
        'totalItems',
        'searchQuery',
        'searchBrandName',
        'searchSku'
    ))->with('isHome', true);
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
