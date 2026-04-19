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
     */
    public function index(Request $request)
    {
        $settings = Setting::getSettings();
        $promoImage = $settings->promotion_banner_image;

        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        $categoryId = $request->input('category_id');
        $brandId = $request->input('brand_id');
        $searchQuery = $request->input('search');

        // Get filtered products with pagination
        $products = $this->getFilteredProductsQuery($request)->paginate(14);

        // For non-AJAX requests, also get category/brand names
        if (!$request->wantsJson()) {
            $categoryName = $categoryId ? (Category::find($categoryId)?->name_en ?? 'Category') : __('messages.all_products');
            $brandName = $brandId ? (Brand::find($brandId)?->name_en ?? 'Brand') : 'All Brands';
            return view('frontend.pages.home', compact(
                'settings',
                'promoImage',
                'categories',
                'brands',
                'categoryId',
                'brandId',
                'categoryName',
                'brandName',
                'products',
                'searchQuery'
            ))->with('isHome', true);
        }

        // AJAX request - return only products HTML and pagination HTML
        $productsHtml = '';
        if ($products->count() > 0) {
            $productsHtml = view('frontend.components.product-grid', [
                'products' => $products,
                'isHome' => true,
                'promoImage' => $promoImage,
                'categoryId' => $categoryId,
                'brandId' => $brandId,
            ])->render();
        }

        // Get pagination HTML - ONLY if there are more than 1 page
        $paginationHtml = '';
        if ($products->lastPage() > 1 && $products->count() > 0) {
            $paginationHtml = view('frontend.components.pagination', [
                'page' => $products->currentPage(),
                'total' => $products->lastPage(),
                'size' => 'lg',
                'ajax' => true,
            ])->render();
        }

        return response()->json([
            'success' => true,
            'products_html' => $productsHtml,
            'pagination_html' => $paginationHtml,
            'total' => $products->total(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
        ]);
    }

    /**
     * AJAX filter endpoint - returns filtered products
     */
    public function filter(Request $request)
    {
        $products = $this->getFilteredProductsQuery($request)->paginate(14);

        $categoryId = $request->input('category_id');
        $brandId = $request->input('brand_id');

        $settings = Setting::getSettings();
        $promoImage = $settings->promotion_banner_image;

        $productsHtml = '';
        if ($products->count() > 0) {
            $productsHtml = view('frontend.components.product-grid', [
                'products' => $products,
                'isHome' => true,
                'promoImage' => $promoImage,
                'categoryId' => $categoryId,
                'brandId' => $brandId,
            ])->render();
        }

        // Get pagination HTML - ONLY if there are more than 1 page
        $paginationHtml = '';
        if ($products->lastPage() > 1 && $products->count() > 0) {
            $paginationHtml = view('frontend.components.pagination', [
                'page' => $products->currentPage(),
                'total' => $products->lastPage(),
                'size' => 'lg',
                'ajax' => true,
            ])->render();
        }

        return response()->json([
            'success' => true,
            'products_html' => $productsHtml,
            'pagination_html' => $paginationHtml,
            'total' => $products->total(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'category_id' => $categoryId,
            'brand_id' => $brandId,
        ]);
    }

    /**
     * Get filtered products query (reusable)
     */
    private function getFilteredProductsQuery(Request $request)
    {
        $query = Product::active()
            ->with(['category', 'brand', 'images'])
            ->orderBy('id', 'desc');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_kh', 'like', "%{$search}%")
                    ->orWhere('SKU', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name_en', 'like', "%{$search}%")
                            ->orWhere('name_kh', 'like', "%{$search}%");
                    })
                    ->orWhereHas('brand', function ($q3) use ($search) {
                        $q3->where('name_en', 'like', "%{$search}%")
                            ->orWhere('name_kh', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }
}
