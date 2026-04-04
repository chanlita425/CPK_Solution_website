<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Banner;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        $totalProducts = Product::count();
        $activeCoupons = Coupon::where('is_active', true)->count();
        $totalBanners = Banner::count();

        return view('admin.pages.dashboard.index', compact(
            'totalCategories',
            'totalBrands',
            'totalProducts',
            'activeCoupons',
            'totalBanners'
        ));
    }
}
