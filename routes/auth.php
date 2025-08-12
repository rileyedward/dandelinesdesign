<?php

use App\Http\Controllers\Auth\AuthLoginController;
use App\Http\Controllers\Auth\AuthPasswordResetController;
use App\Http\Controllers\Auth\AuthRegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::controller(AuthRegisterController::class)
        ->prefix('register')
        ->name('register.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
        });

    Route::controller(AuthLoginController::class)
        ->prefix('login')
        ->name('login.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::delete('/', 'destroy')->name('destroy');
        });

    Route::patch('/password/reset', AuthPasswordResetController::class)->name('password.reset');
});
