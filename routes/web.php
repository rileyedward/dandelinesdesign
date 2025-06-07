<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [AboutController::class, 'index'])->name('about.index');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

Route::get('/store', [StoreController::class, 'index'])->name('store.index');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog_post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/under-construction', [ConstructionController::class, 'index'])->name('under-construction.index');
Route::post('/under-construction', [ConstructionController::class, 'store'])->name('under-construction.store');

require __DIR__.'/admin.php';
