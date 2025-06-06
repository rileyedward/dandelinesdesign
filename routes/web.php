<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/store', [StoreController::class, 'index'])->name('store.index');

Route::prefix('/blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{blog_post:slug}', [BlogController::class, 'show'])->name('blog.show');
});

Route::prefix('/contact')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store');
});

Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');

Route::prefix('/products')->name('products.')->group(function () {
    Route::post('/', [ProductController::class, 'store'])->name('store');
});

Route::get('/under-construction', fn () => view('construction'))->name('under-construction');
