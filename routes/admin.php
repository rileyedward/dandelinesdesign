<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->name('admin.')
    ->prefix('/admin')
    ->group(function () {
        //
    });
