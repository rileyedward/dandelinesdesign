<?php

namespace App\Http\Controllers;

use App\Contracts\ProductServiceInterface;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Stripe\Product as StripeProduct;
use Stripe\StripeClient;

class ProductController extends BaseController
{
    protected string $modelClass = Product::class;

    protected $serviceInterface = ProductServiceInterface::class;

    protected ?string $requestClass = ProductRequest::class;

    public function index(Request $request): Response
    {
        $products = Product::query()
            ->with(['category', 'prices' => function ($query) {
                $query->orderBy('is_current', 'desc')->orderBy('unit_amount');
            }])
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
                    $query->where('active', true)
                          ->orderBy('is_current', 'desc')
                          ->orderBy('unit_amount');
                },
                'lineItems.order',
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

    public function importFromStripe(Request $request): RedirectResponse
    {
        $limit = $request->input('limit', 50);
        $force = $request->boolean('force', false);

        try {
            $stripe = new StripeClient(config('cashier.secret'));

            $stripeProducts = $stripe->products->all([
                'limit' => $limit,
                'active' => true,
            ]);

            $importedCount = 0;
            $skippedCount = 0;

            foreach ($stripeProducts->data as $stripeProduct) {
                $existingProduct = Product::where('stripe_product_id', $stripeProduct->id)->first();

                if ($existingProduct && ! $force) {
                    $skippedCount++;

                    continue;
                }

                $product = $this->importProduct($stripeProduct);

                if ($product) {
                    $this->importPricesForProduct($stripe, $stripeProduct->id, $product);
                    $importedCount++;
                }
            }

            return back()->with('success', "Import completed: {$importedCount} products imported, {$skippedCount} skipped");

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: '.$e->getMessage());
        }
    }

    private function importProduct(StripeProduct $stripeProduct): ?Product
    {
        try {
            $defaultCategory = Category::query()->firstOrCreate(
                ['slug' => 'imported-from-stripe'],
                [
                    'name' => 'Imported from Stripe',
                    'description' => 'Products imported from Stripe catalog',
                    'is_active' => true,
                    'sort_order' => 0,
                ]
            );

            $productData = [
                'stripe_product_id' => $stripeProduct->id,
                'category_id' => $defaultCategory->id,
                'name' => $stripeProduct->name,
                'slug' => \Str::slug($stripeProduct->name),
                'description' => $stripeProduct->description ?? '',
                'image_url' => $stripeProduct->images[0] ?? null,
                'images' => ! empty($stripeProduct->images) ? $stripeProduct->images : null,
                'package_dimensions' => $stripeProduct->package_dimensions ?
                    "{$stripeProduct->package_dimensions->length}x{$stripeProduct->package_dimensions->width}x{$stripeProduct->package_dimensions->height}" : null,
                'weight' => $stripeProduct->package_dimensions->weight ?? null,
                'shippable' => $stripeProduct->shippable ?? true,
                'tax_code' => $stripeProduct->tax_code ?? null,
                'metadata' => $stripeProduct->metadata->toArray() ?? null,
                'unit_label' => $stripeProduct->unit_label ?? null,
                'is_active' => $stripeProduct->active ?? true,
                'is_featured' => false,
            ];

            return Product::query()->updateOrCreate(
                ['stripe_product_id' => $stripeProduct->id],
                $productData
            );

        } catch (\Exception $e) {
            return null;
        }
    }

    public function setCurrentPrice(Request $request, int $productId, int $priceId): RedirectResponse
    {
        try {
            Price::query()
                ->where('product_id', $productId)
                ->update(['is_current' => false]);

            Price::query()
                ->where('product_id', $productId)
                ->where('is_current', true)
                ->update(['is_current' => false]);

            $price = Price::query()
                ->where('id', $priceId)
                ->where('product_id', $productId)
                ->firstOrFail();

            $price->update(['is_current' => true]);

            return back()->with('success', 'Current price updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update current price.');
        }
    }

    private function importPricesForProduct(StripeClient $stripe, string $stripeProductId, Product $product): void
    {
        try {
            $stripePrices = $stripe->prices->all([
                'product' => $stripeProductId,
                'limit' => 100,
            ]);

            foreach ($stripePrices->data as $stripePrice) {
                $priceData = [
                    'stripe_price_id' => $stripePrice->id,
                    'product_id' => $product->id,
                    'active' => $stripePrice->active,
                    'currency' => strtoupper($stripePrice->currency),
                    'type' => $stripePrice->type,
                    'unit_amount' => $stripePrice->unit_amount / 100, // Convert from cents
                    'unit_amount_decimal' => $stripePrice->unit_amount_decimal,
                    'billing_scheme' => $stripePrice->billing_scheme,
                    'recurring' => $stripePrice->recurring ? $stripePrice->recurring->toArray() : null,
                    'usage_type' => $stripePrice->recurring->usage_type ?? null,
                    'tax_behavior' => $stripePrice->tax_behavior === 'inclusive',
                    'nickname' => $stripePrice->nickname,
                    'metadata' => $stripePrice->metadata->toArray() ?? null,
                    'stripe_created_at' => \Carbon\Carbon::createFromTimestamp($stripePrice->created),
                ];

                Price::query()->updateOrCreate(
                    ['stripe_price_id' => $stripePrice->id],
                    $priceData
                );
            }

        } catch (\Exception $e) {
            // Silently fail for individual price imports
        }
    }
}
