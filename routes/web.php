<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\QuoteRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('home/home-index');
})->name('home');

Route::get('/about', AboutController::class)->name('about');

Route::get('/services', function () {
    return inertia('services/services-index');
});

Route::get('/contact', function () {
    return inertia('contact/contact-index');
});

Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
Route::post('/quote', [QuoteRequestController::class, 'store'])->name('quote.store');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
