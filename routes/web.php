<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

// TODO: Remove the auth guard on web routes after production launch
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return inertia('home/home-index');
    })->name('home');

    Route::get('/about', AboutController::class)->name('about.index');

    Route::get('/services', function () {
        return inertia('services/services-index');
    })->name('services.index');

    Route::get('/contact', function () {
        return inertia('contact/contact-index');
    })->name('contact.index');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/store', [StoreController::class, 'index'])->name('store');

    Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
    Route::post('/quote', [QuoteRequestController::class, 'store'])->name('quote.store');
    Route::post('/newsletter', [NewsletterSubscriberController::class, 'store'])->name('newsletter.store');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
