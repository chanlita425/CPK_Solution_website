<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Language Switcher
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'km'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('lang.switch');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest routes - no authentication needed
    Route::middleware('guest.admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Authenticated routes - require admin authentication
    Route::middleware('admin')->group(function () {
        // Auth
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Category CRUD
        Route::resource('categories', CategoryController::class);

        // Brand CRUD
        Route::resource('brands', BrandController::class);

        // Product CRUD with additional routes
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{product}', [ProductController::class, 'show'])->name('show');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');

            // Additional product routes
            Route::delete('bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete');
            Route::patch('{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('toggle-status');
            Route::patch('{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::get('export/csv', [ProductController::class, 'export'])->name('export');
        });

        // Banner CRUD
        Route::resource('banners', BannerController::class);

        // Coupon CRUD
        Route::resource('coupons', CouponController::class);

        // Settings Routes
        Route::prefix('settings')->name('settings.')->group(function () {
            // Profile Settings
            Route::get('profile', [SettingController::class, 'profile'])->name('profile');
            Route::put('profile', [SettingController::class, 'updateProfile'])->name('profile.update');

            // System Settings
            Route::get('system', [SettingController::class, 'system'])->name('system');
            Route::put('system', [SettingController::class, 'updateSystem'])->name('system.update');

            // Email Settings
            Route::get('email', [SettingController::class, 'email'])->name('email');
            Route::put('email', [SettingController::class, 'updateEmail'])->name('email.update');

            // Social Settings
            Route::get('social', [SettingController::class, 'social'])->name('social');
            Route::put('social', [SettingController::class, 'updateSocial'])->name('social.update');
        });

        // Settings Routes
        Route::prefix('settings')->name('settings.')->group(function () {
            // Profile Settings
            Route::get('profile', [SettingController::class, 'profile'])->name('profile');
            Route::put('profile', [SettingController::class, 'updateProfile'])->name('profile.update');

            // System Settings
            Route::get('system', [SettingController::class, 'system'])->name('system');
            Route::put('system', [SettingController::class, 'updateSystem'])->name('system.update');
        });
    });
});

// Home route - redirect to admin login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Fallback route for 404 errors
Route::fallback(function () {
    return redirect()->route('admin.login');
});
