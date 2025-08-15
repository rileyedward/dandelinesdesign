<?php

namespace App\Http\Controllers;

use App\Contracts\ProductServiceInterface;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
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
            ->with(['category', 'prices'])
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return inertia('admin/products/products-index', [
            'products' => $products,
            'categories' => $categories,
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

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return inertia('admin/products/products-show', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $model = $this->service->getById($id);

        // TODO: Uncomment once authorization policy structure is setup...
        // $this->authorize('destroy', $model);

        $this->service->delete($model);

        return to_route('admin.products.index');
    }
}
