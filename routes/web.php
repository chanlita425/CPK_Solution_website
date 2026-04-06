<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Profile Settings
        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');

        // Categories
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // Brands
        Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('brands/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
        Route::post('brands/{id}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');

        // Products
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');

        // Orders
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{id}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
        Route::post('orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

        // Coupons
        Route::get('coupons', [CouponController::class, 'index'])->name('coupons.index');
        Route::get('coupons/create', [CouponController::class, 'create'])->name('coupons.create');
        Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store');
        Route::get('coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
        Route::put('coupons/{id}', [CouponController::class, 'update'])->name('coupons.update');
        Route::delete('coupons/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
        Route::post('coupons/{id}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
