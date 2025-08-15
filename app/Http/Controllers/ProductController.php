<?php

namespace App\Http\Controllers;

use App\Contracts\ProductServiceInterface;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Response;

class ProductController extends BaseController
{
    protected string $modelClass = Product::class;

    protected $serviceInterface = ProductServiceInterface::class;

    protected ?string $requestClass = ProductRequest::class;

    public function index(Request $request): Response
    {
        $products = Product::query()
            ->with('prices')
            ->get();

        return inertia('admin/products/products-index', [
            'products' => $products,
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        $product = Product::query()
            ->with([
                'category',
                'prices' => function ($query) {
                    $query->where('active', true)->orderBy('unit_amount');
                },
                'orderProducts.order',
            ])
            ->findOrFail($id);

        return inertia('admin/products/products-show', [
            'product' => $product,
        ]);
    }
}
