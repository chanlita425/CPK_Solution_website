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
        $brandId = $request->input('brand_id');

        // Prepare thumbnails - ALWAYS show 4 boxes
        $thumbnails = $this->prepareThumbnails($product);

        // Get similar products
        $query = Product::active()
            ->where('id', '!=', $product->id)
            ->with(['category', 'brand', 'images']);

        // Apply category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        } else {
            // Default: show products from same category
            $query->where('category_id', $product->category_id);
        }

        // Apply brand filter
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Get all products for manual pagination
        $allProducts = $query->latest()->get();
        $totalItems = $allProducts->count();

        $perPage = ['xs' => 5, 'sm' => 10, 'lg' => 8];

        $pageXs = max(1, (int) $request->input('page_xs', 1));
        $pageSm = max(1, (int) $request->input('page_sm', 1));
        $pageLg = max(1, (int) $request->input('page_lg', 1));

        $productsXs = $allProducts->forPage($pageXs, $perPage['xs'])->values();
        $productsSm = $allProducts->forPage($pageSm, $perPage['sm'])->values();
        $productsLg = $allProducts->forPage($pageLg, $perPage['lg'])->values();

        $totalPagesXs = $totalItems > 0 ? ceil($totalItems / $perPage['xs']) : 1;
        $totalPagesSm = $totalItems > 0 ? ceil($totalItems / $perPage['sm']) : 1;
        $totalPagesLg = $totalItems > 0 ? ceil($totalItems / $perPage['lg']) : 1;

        $pgUrl = url()->current();
        $filterBaseUrl = route('home');
        $promoPosition = 3;

        // Check if AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            $isHome = false;

            $similarHtml = view('frontend.components.cards.cardResponsive', compact(
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
                'filterBaseUrl',
                'promoPosition',
                'totalItems',
                'categoryId',
                'brandId',
                'isHome'  // Make sure isHome is passed
            ))->render();

            return response()->json([
                'success' => true,
                'similar_html' => $similarHtml,
                'total_items' => $totalItems
            ]);
        }

        return view('frontend.pages.viewProduct', compact(
            'product',
            'settings',
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
            'filterBaseUrl',
            'promoPosition',
            'totalItems'
        ))->with('isHome', false);
    }

    /**
     * Prepare thumbnails array - ALWAYS returns 4 items
     */
    private function prepareThumbnails($product)
    {
        $images = $product->images;
        $thumbnails = [];

        foreach ($images as $image) {
            $thumbnails[] = [
                'image' => $image->image,
                'url' => asset('storage/' . $image->image),
                'is_main' => $image->is_main,
            ];
        }

        $needed = 4 - count($thumbnails);

        if ($needed > 0) {
            $fallbackUrl = !empty($thumbnails) ? $thumbnails[0]['url'] : null;

            for ($i = 0; $i < $needed; $i++) {
                $thumbnails[] = [
                    'image' => null,
                    'url' => $fallbackUrl,
                    'is_main' => false,
                    'is_placeholder' => true,
                ];
            }
        }

        return $thumbnails;
    }
}
