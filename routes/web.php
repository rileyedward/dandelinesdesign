<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('home');
})->name('home');

Route::get('/about', function () {
    return inertia('about');
});

Route::get('/services', function () {
    return inertia('services');
});

Route::get('/contact', function () {
    return inertia('contact/contact-index');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
