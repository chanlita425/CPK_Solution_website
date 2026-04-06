<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_kh', 'like', "%{$search}%")
                    ->orWhere('SKU', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        $products = $query->orderBy('id', 'desc')->paginate(10);

        // Get categories and brands for filters
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        return view('admin.pages.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        // FIXED: Changed from 'admin.products.create' to 'admin.pages.products.create'
        return view('admin.pages.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'SKU' => 'required|string|unique:products',
            'price' => 'required|numeric|min:0',
            'specification_en' => 'nullable|string',
            'specification_kh' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'images' => 'nullable|array|max:4',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name_en' => $request->name_en,
            'name_kh' => $request->name_kh,
            'SKU' => $request->SKU,
            'price' => $request->price,
            'specification_en' => $request->specification_en,
            'specification_kh' => $request->specification_kh,
            'quantity' => $request->quantity,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products', $filename, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_main' => $index === 0,
                ]);
            }
        }
        return redirect()->route('admin.products.index')
            ->with('toast', ['message' => 'Product created successfully!', 'type' => 'success']);
    }

    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        // FIXED: Changed from 'admin.products.edit' to 'admin.pages.products.edit'
        return view('admin.pages.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'SKU' => 'required|string|unique:products,SKU,' . $id,
            'price' => 'required|numeric|min:0',
            'specification_en' => 'nullable|string',
            'specification_kh' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'images' => 'nullable|array|max:4',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'deleted_images' => 'nullable|string',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name_en' => $request->name_en,
            'name_kh' => $request->name_kh,
            'SKU' => $request->SKU,
            'price' => $request->price,
            'specification_en' => $request->specification_en,
            'specification_kh' => $request->specification_kh,
            'quantity' => $request->quantity,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->has('deleted_images') && !empty($request->deleted_images)) {
            $deletedIds = explode(',', $request->deleted_images);
            foreach ($deletedIds as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image) {
                    if (Storage::disk('public')->exists($image->image)) {
                        Storage::disk('public')->delete($image->image);
                    }
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            $existingCount = $product->images()->count();
            $maxNew = 4 - $existingCount;

            foreach (array_slice($request->file('images'), 0, $maxNew) as $index => $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products', $filename, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_main' => $product->images()->count() === 0,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully!'
        ]);
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully!',
            'is_active' => $product->is_active
        ]);
    }
}
