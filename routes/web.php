<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('home');
})->name('home');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
