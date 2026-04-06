<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query();

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

        $brands = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.pages.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.pages.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255|unique:brands,name_en',
            'name_kh' => 'required|string|max:255|unique:brands,name_kh',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ], [
            'name_en.required' => 'Brand name in English is required.',
            'name_en.unique' => 'A brand with this English name already exists.',
            'name_kh.required' => 'Brand name in Khmer is required.',
            'name_kh.unique' => 'A brand with this Khmer name already exists.',
            'logo_image.image' => 'Please upload a valid image file.',
            'logo_image.max' => 'Image size must not exceed 2MB.',
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
        return view('admin.pages.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255|unique:brands,name_en,' . $id,
            'name_kh' => 'required|string|max:255|unique:brands,name_kh,' . $id,
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'remove_logo' => 'nullable|string',
        ], [
            'name_en.required' => 'Brand name in English is required.',
            'name_en.unique' => 'A brand with this English name already exists.',
            'name_kh.required' => 'Brand name in Khmer is required.',
            'name_kh.unique' => 'A brand with this Khmer name already exists.',
            'logo_image.image' => 'Please upload a valid image file.',
            'logo_image.max' => 'Image size must not exceed 2MB.',
        ]);

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

        // Check if brand has products
        if ($brand->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete brand because it has associated products.'
            ], 400);
        }

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
