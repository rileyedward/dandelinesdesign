<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('landing-page');
})->name('home');

Route::get('/about', function () {
    return Inertia::render('about-page');
})->name('about');

Route::get('/services', function () {
    return Inertia::render('services/services-page');
})->name('services');

Route::get('/store', function () {
    return Inertia::render('store-page');
})->name('store');

Route::get('/blog', function () {
    return Inertia::render('blog-page');
})->name('blog');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
