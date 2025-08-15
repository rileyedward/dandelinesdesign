<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Response;

class StoreController extends Controller
{
    public function index(Request $request): Response
    {
        $products = Product::query()
            ->with(['category', 'prices'])
            ->where('is_active', true)
            ->inStock()
            ->whereDoesntHave('category', function ($query) {
                $query->where('slug', 'imported-from-stripe');
            })
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return inertia('store/store-index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
