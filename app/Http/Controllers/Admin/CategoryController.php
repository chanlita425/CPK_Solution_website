<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_kh', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        // Add withCount to get accurate product counts
        $categories = $query->withCount('products')->orderBy('id', 'desc')->paginate(10);

        return view('admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255|unique:categories,name_en',
            'name_kh' => 'required|string|max:255|unique:categories,name_kh',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ], [
            'name_en.required' => 'Category name in English is required.',
            'name_en.unique' => 'A category with this English name already exists.',
            'name_kh.required' => 'Category name in Khmer is required.',
            'name_kh.unique' => 'A category with this Khmer name already exists.',
            'icon_image.image' => 'Please upload a valid image file.',
            'icon_image.max' => 'Image size must not exceed 2MB.',
        ]);

        $category = new Category();
        $category->name_en = $request->name_en;
        $category->name_kh = $request->name_kh;
        $category->is_active = $request->has('is_active');

        if ($request->hasFile('icon_image')) {
            $image = $request->file('icon_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('categories', $filename, 'public');
            $category->icon_image = $path;
        }

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('toast', ['message' => 'Category created successfully!', 'type' => 'success']);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255|unique:categories,name_en,' . $id,
            'name_kh' => 'required|string|max:255|unique:categories,name_kh,' . $id,
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'remove_icon' => 'nullable|string',
        ], [
            'name_en.required' => 'Category name in English is required.',
            'name_en.unique' => 'A category with this English name already exists.',
            'name_kh.required' => 'Category name in Khmer is required.',
            'name_kh.unique' => 'A category with this Khmer name already exists.',
            'icon_image.image' => 'Please upload a valid image file.',
            'icon_image.max' => 'Image size must not exceed 2MB.',
        ]);

        $category->name_en = $request->name_en;
        $category->name_kh = $request->name_kh;
        $category->is_active = $request->has('is_active');

        if ($request->hasFile('icon_image')) {
            if ($category->icon_image && Storage::disk('public')->exists($category->icon_image)) {
                Storage::disk('public')->delete($category->icon_image);
            }
            $image = $request->file('icon_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('categories', $filename, 'public');
            $category->icon_image = $path;
        }

        if ($request->has('remove_icon') && $request->remove_icon == '1') {
            if ($category->icon_image && Storage::disk('public')->exists($category->icon_image)) {
                Storage::disk('public')->delete($category->icon_image);
            }
            $category->icon_image = null;
        }

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Check if category has products
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category because it has associated products.'
            ], 400);
        }

        if ($category->icon_image && Storage::disk('public')->exists($category->icon_image)) {
            Storage::disk('public')->delete($category->icon_image);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully!'
        ]);
    }

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category status updated successfully!',
            'is_active' => $category->is_active
        ]);
    }
}
