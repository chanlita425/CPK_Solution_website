<?php
// app/Http/Controllers/Admin/CategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        // FIXED: Changed from 'admin.categories.index' to 'admin.pages.categories.index'
        return view('admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        // FIXED: Changed from 'admin.categories.create' to 'admin.pages.categories.create'
        return view('admin.pages.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            ->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        // FIXED: Changed from 'admin.categories.edit' to 'admin.pages.categories.edit'
        return view('admin.pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($id);
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
