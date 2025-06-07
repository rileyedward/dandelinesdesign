<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function admin(): Response
    {
        $products = Product::query()
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('admin/admin-products', [
            'products' => $products,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/admin-product-create');
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('admin/admin-product-edit', [
            'product' => $product,
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'_'.$image->getClientOriginalName();

            $path = $image->storeAs('images/products', $filename, 'public');

            $data['image_url'] = '/storage/'.$path;
        }

        Product::query()->create($data);

        return redirect()->back();
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image_url) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $image = $request->file('image');
            $filename = time().'_'.$image->getClientOriginalName();

            $path = $image->storeAs('images/products', $filename, 'public');

            $data['image_url'] = '/storage/'.$path;
        }

        $product->update($data);

        return redirect()->back();
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->back();
    }
}
