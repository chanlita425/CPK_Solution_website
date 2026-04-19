<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Real-time search endpoint (JSON)
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $request->get('q', '');
        $page = $request->get('page', 1);

        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'query' => $query,
                'products_html' => $this->getEmptyStateHtml('Enter at least 2 characters to search.'),
                'pagination_html' => '',
                'count' => 0,
                'total' => 0,
                'current_page' => 1,
                'has_pages' => false,
            ]);
        }

        $products = Product::active()
            ->with(['category', 'brand', 'images'])
            ->search($query)
            ->paginate(14);

        if ($products->isEmpty()) {
            return response()->json([
                'success' => true,
                'query' => $query,
                'products_html' => $this->getEmptyStateHtml('No products found matching "' . e($query) . '".'),
                'pagination_html' => '',
                'count' => 0,
                'total' => 0,
                'current_page' => 1,
                'has_pages' => false,
            ]);
        }

        // Render products HTML
        $productsHtml = view('frontend.components.product-grid', ['products' => $products])->render();
        $paginationHtml = $products->hasPages()
            ? view('frontend.components.pagination', ['paginator' => $products])->render()
            : '';

        return response()->json([
            'success' => true,
            'query' => $query,
            'products_html' => $productsHtml,
            'pagination_html' => $paginationHtml,
            'count' => $products->count(),
            'total' => $products->total(),
            'current_page' => $products->currentPage(),
            'has_pages' => $products->hasMorePages(),
        ]);
    }

    /**
     * Live search dropdown - returns limited results for autocomplete
     */
    public function liveSearch(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'results' => [],
                'has_results' => false,
            ]);
        }

        // Limit to 8 results for dropdown
        $products = Product::active()
            ->with(['category', 'brand', 'images'])
            ->search($query)
            ->limit(8)
            ->get();

        $results = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name_en' => $product->name_en,
                'name_kh' => $product->name_kh,
                'name' => $product->name,
                'SKU' => $product->SKU,
                'price' => $product->price,
                'price_formatted' => number_format($product->price, 2),
                'category_name' => $product->category?->name,
                'brand_name' => $product->brand?->name,
                'image_url' => $product->main_image_url,
                'url' => route('pages.viewProduct', $product->id),
            ];
        });

        return response()->json([
            'success' => true,
            'results' => $results,
            'has_results' => $results->count() > 0,
            'query' => $query,
        ]);
    }

    /**
     * Get empty state HTML
     */
    private function getEmptyStateHtml($message)
    {
        return '<div class="text-center py-12">
            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">' . e($message) . '</p>
        </div>';
    }
}
