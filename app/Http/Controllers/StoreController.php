<?php

namespace App\Http\Controllers;

class StoreController extends Controller
{
    public function index()
    {
        return inertia('store/store-index');
    }
}
