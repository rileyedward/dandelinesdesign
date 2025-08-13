<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;

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

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
