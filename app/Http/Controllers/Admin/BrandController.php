<?php
// app/Http/Controllers/Admin/BrandController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(10);
        // FIXED: Changed from 'admin.brands.index' to 'admin.pages.brands.index'
        return view('admin.pages.brands.index', compact('brands'));
    }

    public function create()
    {
        // FIXED: Changed from 'admin.brands.create' to 'admin.pages.brands.create'
        return view('admin.pages.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = new Brand();
        $brand->name_en = $request->name_en;
        $brand->name_kh = $request->name_kh;
        $brand->is_active = $request->has('is_active');

        if ($request->hasFile('logo_image')) {
            $image = $request->file('logo_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('brands', $filename, 'public');
            $brand->logo_image = $path;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        // FIXED: Changed from 'admin.brands.edit' to 'admin.pages.brands.edit'
        return view('admin.pages.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name_en = $request->name_en;
        $brand->name_kh = $request->name_kh;
        $brand->is_active = $request->has('is_active');

        if ($request->hasFile('logo_image')) {
            if ($brand->logo_image && Storage::disk('public')->exists($brand->logo_image)) {
                Storage::disk('public')->delete($brand->logo_image);
            }

            $image = $request->file('logo_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('brands', $filename, 'public');
            $brand->logo_image = $path;
        }

        if ($request->has('remove_logo') && $request->remove_logo == '1') {
            if ($brand->logo_image && Storage::disk('public')->exists($brand->logo_image)) {
                Storage::disk('public')->delete($brand->logo_image);
            }
            $brand->logo_image = null;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully!');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->logo_image && Storage::disk('public')->exists($brand->logo_image)) {
            Storage::disk('public')->delete($brand->logo_image);
        }

        $brand->delete();

        return response()->json([
            'success' => true,
            'message' => 'Brand deleted successfully!'
        ]);
    }

    public function toggleStatus($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->is_active = !$brand->is_active;
        $brand->save();

        return response()->json([
            'success' => true,
            'message' => 'Brand status updated successfully!',
            'is_active' => $brand->is_active
        ]);
    }
}
