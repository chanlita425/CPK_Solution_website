<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_kh', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('model_number', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Filter by brand
        if ($request->has('brand') && !empty($request->brand)) {
            $query->where('brand_id', $request->brand);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        // For filter dropdowns
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $brands = Brand::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.pages.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $brands = Brand::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.pages.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'sku' => 'required|string|unique:products,sku|max:100',
            'model_number' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'title_en' => 'required|string|max:255',
            'title_kh' => 'required|string|max:255',
            'specification_en' => 'nullable|string',
            'specification_kh' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Handle images
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }
        $data['images'] = json_encode($images);

        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'brand']);
        return view('admin.pages.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $brands = Brand::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.pages.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'model_number' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'title_en' => 'required|string|max:255',
            'title_kh' => 'required|string|max:255',
            'specification_en' => 'nullable|string',
            'specification_kh' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Handle existing images
        $existingImages = json_decode($product->images, true) ?? [];
        $images = $existingImages;

        // Remove deleted images
        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $deletedImage) {
                if (($key = array_search($deletedImage, $images)) !== false) {
                    Storage::disk('public')->delete($deletedImage);
                    unset($images[$key]);
                }
            }
            $images = array_values($images);
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $data['images'] = json_encode($images);
        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete all images
        $images = json_decode($product->images, true) ?? [];
        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
        ]);

        $ids = explode(',', $request->ids);
        $products = Product::whereIn('id', $ids)->get();
        $deletedCount = 0;

        foreach ($products as $product) {
            // Delete images
            $images = json_decode($product->images, true) ?? [];
            foreach ($images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
            $product->delete();
            $deletedCount++;
        }

        return redirect()->route('admin.products.index')
            ->with('success', $deletedCount . ' products deleted successfully.');
    }

    /**
     * Toggle product status (active/inactive).
     */
    public function toggleStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Product {$status} successfully.");
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Product $product)
    {
        $product->is_featured = !$product->is_featured;
        $product->save();

        $status = $product->is_featured ? 'featured' : 'unfeatured';
        return redirect()->back()->with('success', "Product marked as {$status}.");
    }

    /**
     * Export products to CSV.
     */
    public function export()
    {
        $products = Product::with(['category', 'brand'])->get();

        $filename = "products_export_" . date('Y-m-d_His') . ".csv";
        $handle = fopen('php://temp', 'w+');

        // Add CSV headers
        fputcsv($handle, [
            'ID',
            'SKU',
            'Model Number',
            'Title (EN)',
            'Title (KH)',
            'Category',
            'Brand',
            'Price',
            'Quantity',
            'Status',
            'Featured',
            'Created At'
        ]);

        // Add data rows
        foreach ($products as $product) {
            fputcsv($handle, [
                $product->id,
                $product->sku,
                $product->model_number,
                $product->title_en,
                $product->title_kh,
                $product->category->name_en ?? 'N/A',
                $product->brand->name_en ?? 'N/A',
                $product->price,
                $product->quantity,
                $product->is_active ? 'Active' : 'Inactive',
                $product->is_featured ? 'Yes' : 'No',
                $product->created_at
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
