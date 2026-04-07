<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('frontend.pages.home');
});

Route::get('/view', function () {
    return view('frontend.pages/viewProduct');
});


Route::get('/addProduct', function () {
    return view('frontend.pages/addProduct');
});

// Route::get('/', [HomeController::class, 'index']);



// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');