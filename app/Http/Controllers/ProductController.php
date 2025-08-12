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
        // TODO: Add page route...
        return inertia(null);
    }
}
