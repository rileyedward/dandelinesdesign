<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function admin(): Response
    {
        // TODO: Add authorization policy...

        $products = Product::query()
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('admin/admin-products', [
            'products' => $products,
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        // TODO: Add authorization policy...

        Product::query()->create($request->validated());

        return redirect()->back();
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        // TODO: Add authorization policy...

        $product->update($request->validated());

        return redirect()->back();
    }


    public function destroy(Product $product): RedirectResponse
    {
        // TODO: Add authorization policy...

        $product->delete();

        return redirect()->back();
    }
}
