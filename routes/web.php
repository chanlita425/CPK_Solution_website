<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;

// Frontend Controllers
// use App\Http\Controllers\Frontend\HomeController;
// use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CouponController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\LocaleController;

/*
|--------------------------------------------------------------------------
| Frontend Routes (Public)
|--------------------------------------------------------------------------
*/
 
// Home & Product
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('pages.viewProduct');

// Real-time search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Locale switching
Route::post('/locale/switch', [LocaleController::class, 'switch'])->name('locale.switch');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Coupon Routes
Route::prefix('coupon')->name('coupon.')->group(function () {
    Route::post('/apply', [CouponController::class, 'apply'])->name('apply');
    Route::delete('/remove', [CouponController::class, 'remove'])->name('remove');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
});

// Filter products via AJAX (legacy support)
Route::get('/filter', [HomeController::class, 'filter'])->name('filter.products');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

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
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::post('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // Brands
        Route::resource('brands', BrandController::class)->except(['show']);
        Route::post('brands/{id}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');

        // Products
        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::post('products/{id}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');

        // Orders
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{id}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
        Route::post('orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

        // Coupons
        Route::resource('coupons', AdminCouponController::class)->except(['show']);
        Route::post('coupons/{id}/toggle-status', [AdminCouponController::class, 'toggleStatus'])->name('coupons.toggle-status');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    }); });




    // // FRONTEND 
    // Route::get('/', function () {
    //     return view('frontend.pages.home');
    // })->name('home');

    

    Route::get('/viewProduct', function () {
        return view('frontend.pages/viewProduct');
    });

    Route::get('/addProduct', function () {
        return view('frontend.pages/addProduct');
    });
