<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['auth'])
    ->name('admin.')
    ->prefix('/admin')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
    });
