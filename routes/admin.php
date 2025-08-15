<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\NewsletterTemplateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard.index');

        Route::controller(ContactMessageController::class)
            ->prefix('messages')
            ->name('messages.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::patch('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(BlogPostController::class)
            ->prefix('blog')
            ->name('blog.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::patch('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(QuoteRequestController::class)
            ->prefix('quotes')
            ->name('quotes.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::patch('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(TestimonialController::class)
            ->prefix('testimonials')
            ->name('testimonials.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::patch('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(LeadController::class)
            ->prefix('leads')
            ->name('leads.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::patch('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(CategoryController::class)
            ->prefix('categories')
            ->name('categories.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::patch('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(ProductController::class)
            ->prefix('products')
            ->name('products.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/import-stripe', 'importFromStripe')->name('import-stripe');
                Route::get('/{id}', 'show')->name('show');
                Route::patch('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(OrderController::class)
            ->prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
            });

        Route::controller(NotificationController::class)
            ->prefix('notifications')
            ->name('notifications.')
            ->group(function () {
                Route::get('/unread', 'getUnread')->name('unread');
                Route::patch('/{id}/read', 'markAsRead')->name('read');
                Route::patch('/read-all', 'markAllAsRead')->name('read-all');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(NewsletterSubscriberController::class)
            ->prefix('newsletter/subscribers')
            ->name('newsletter.subscribers.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::patch('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(NewsletterTemplateController::class)
            ->prefix('newsletter/templates')
            ->name('newsletter.templates.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::patch('/{id}', 'update')->name('update');
                Route::post('/{id}/send', 'send')->name('send');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        Route::controller(ImageController::class)
            ->prefix('images')
            ->name('images.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/list', 'list')->name('list');
                Route::post('/', 'store')->name('store');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
    });
