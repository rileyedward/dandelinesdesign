<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class StoreController extends Controller
{
    public function index(): Response
    {
        $products = Product::query()
            ->where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('store/store-index', [
            'products' => $products,
        ]);
    }
}
