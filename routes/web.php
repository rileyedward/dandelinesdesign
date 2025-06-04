<?php

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

Route::get('/contact', function () {
    return Inertia::render('contact-page');
})->name('contact');
