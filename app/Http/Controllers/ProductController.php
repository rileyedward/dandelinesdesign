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
        return inertia('admin/products/products-index');
    }

    public function show(Request $request, int $id): Response
    {
        return inertia('admin/products/products-show');
    }
}
