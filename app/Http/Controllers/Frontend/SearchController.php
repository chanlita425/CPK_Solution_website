<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
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
        $productsHtml = view('userUi.components.product-grid', ['products' => $products])->render();
        $paginationHtml = $products->hasPages()
            ? view('userUi.components.pagination', ['paginator' => $products])->render()
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
     * Live suggestions: brands + SKUs matching the query
     */
    public function suggestions(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 1) {
            return response()->json(['brands' => [], 'skus' => []]);
        }

        $brands = Brand::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('name_en', 'like', "%{$q}%")
                      ->orWhere('name_kh', 'like', "%{$q}%");
            })
            ->select('id', 'name_en', 'name_kh')
            ->limit(5)
            ->get()
            ->map(fn($b) => ['id' => $b->id, 'name' => $b->name_en ?? $b->name_kh]);

        $skus = Product::active()
            ->where('SKU', 'like', "%{$q}%")
            ->select('id', 'SKU', 'name_en')
            ->limit(5)
            ->get()
            ->map(fn($p) => ['id' => $p->id, 'sku' => $p->SKU, 'name' => $p->name_en]);

        $products = Product::active()
            ->where(function ($query) use ($q) {
                $query->where('name_en', 'like', "%{$q}%")
                      ->orWhere('name_kh', 'like', "%{$q}%");
            })
            ->select('id', 'name_en', 'name_kh')
            ->limit(6)
            ->get()
            ->map(fn($p) => ['id' => $p->id, 'name' => $p->name_en ?? $p->name_kh]);

        return response()->json(['brands' => $brands, 'skus' => $skus, 'products' => $products]);
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
