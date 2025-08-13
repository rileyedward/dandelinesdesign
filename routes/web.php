<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('home/home-index');
})->name('home');

Route::get('/about', function () {
    return inertia('about/about-index');
});

Route::get('/services', function () {
    return inertia('services');
});

Route::get('/contact', function () {
    return inertia('contact/contact-index');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
