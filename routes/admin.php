<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->name('admin.')
    ->prefix('/admin')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        Route::controller(ContactController::class)
            ->prefix('contact')
            ->name('contact.')
            ->group(function () {
                Route::get('/', 'admin')->name('index');
                Route::delete('/{contactMessage}', 'destroy')->name('destroy');
            });

        Route::controller(QuoteController::class)
            ->prefix('quotes')
            ->name('quotes.')
            ->group(function () {
                Route::get('/', 'admin')->name('index');
                Route::delete('/{quote}', 'destroy')->name('destroy');
            });

        Route::controller(ProductController::class)
            ->prefix('products')
            ->name('products.')
            ->group(function () {
                Route::get('/', 'admin')->name('index');
                Route::post('/', 'store')->name('store');
                Route::patch('/{product}', 'update')->name('update');
                Route::delete('/{product}', 'destroy')->name('destroy');
            });

        Route::controller(BlogController::class)
            ->prefix('blog')
            ->name('blog.')
            ->group(function () {
                Route::get('/', 'admin')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/edit/{blogPost}', 'edit')->name('edit');
                Route::post('/', 'store')->name('store');
                Route::patch('/{blogPost}', 'update')->name('update');
                Route::delete('/{blogPost}', 'destroy')->name('destroy');
            });

        Route::controller(TestimonialController::class)
            ->prefix('testimonials')
            ->name('testimonials.')
            ->group(function () {
                Route::get('/', 'admin')->name('index');
                Route::post('/', 'store')->name('store');
                Route::patch('/{testimonial}', 'update')->name('update');
                Route::delete('/{testimonial}', 'destroy')->name('destroy');
            });
    });

Route::post('/login', LoginController::class)->name('login');
