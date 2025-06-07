<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');

Route::controller(BlogController::class)
    ->prefix('/blog')
    ->name('blog.')
    ->group(function () {
        Route::get('/', 'index')->name('blog.index');
        Route::get('/{blog_post:slug}', 'show')->name('blog.show');
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
