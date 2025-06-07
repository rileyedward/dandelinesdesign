<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/store', [StoreController::class, 'index'])->name('store.index');

Route::controller(BlogController::class)
    ->prefix('/blog')
    ->name('blog.')
    ->group(function () {
        Route::get('/', 'index')->name('blog.index');
        Route::get('/{blog_post:slug}', 'show')->name('blog.show');
    });

Route::controller(ContactController::class)
    ->prefix('/contact')
    ->name('contact.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');

Route::controller(ProductController::class)
    ->prefix('/products')
    ->name('products.')
    ->group(function () {
        Route::post('/', 'store')->name('store');
    });

Route::controller(TestimonialController::class)
    ->prefix('/testimonials')
    ->name('testimonials.')
    ->group(function () {
        Route::post('/', 'store')->name('store');
    });

Route::controller(ConstructionController::class)
    ->prefix('/under-construction')
    ->name('under-construction.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/submit', 'store')->name('store');
    });

Route::post('/login', LoginController::class)->name('login');

require __DIR__.'/admin.php';
