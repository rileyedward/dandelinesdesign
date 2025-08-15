<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Console\Command;
use Laravel\Cashier\Cashier;
use Stripe\Product as StripeProduct;
use Stripe\Price as StripePrice;
use Stripe\StripeClient;

class ImportStripeProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:import-products
                            {--limit=50 : Maximum number of products to import}
                            {--force : Force import even if products already exist}
                            {--dry-run : Show what would be imported without actually importing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products and prices from Stripe into the local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Stripe product import...');
        
        $limit = $this->option('limit');
        $force = $this->option('force');
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No data will be imported');
        }
        
        try {
            $stripe = new StripeClient(config('cashier.secret'));
            
            // Get products from Stripe
            $stripeProducts = $stripe->products->all([
                'limit' => $limit,
                'active' => true,
            ]);
            
            $this->info("Found {$stripeProducts->count()} products in Stripe");
            
            $importedCount = 0;
            $skippedCount = 0;
            
            foreach ($stripeProducts->data as $stripeProduct) {
                $existingProduct = Product::where('stripe_product_id', $stripeProduct->id)->first();
                
                if ($existingProduct && !$force) {
                    $this->line("Skipping existing product: {$stripeProduct->name}");
                    $skippedCount++;
                    continue;
                }
                
                if ($dryRun) {
                    $this->line("[DRY RUN] Would import: {$stripeProduct->name}");
                    continue;
                }
                
                // Import or update product
                $product = $this->importProduct($stripeProduct);
                
                if ($product) {
                    // Import prices for this product
                    $this->importPricesForProduct($stripe, $stripeProduct->id, $product);
                    $importedCount++;
                    $this->info("Imported product: {$stripeProduct->name}");
                } else {
                    $this->error("Failed to import product: {$stripeProduct->name}");
                }
            }
            
            if (!$dryRun) {
                $this->info("Import completed: {$importedCount} imported, {$skippedCount} skipped");
            } else {
                $this->info("Dry run completed: {$stripeProducts->count()} products would be processed");
            }
            
        } catch (\Exception $e) {
            $this->error("Import failed: " . $e->getMessage());
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
    
    private function importProduct(StripeProduct $stripeProduct): ?Product
    {
        try {
            // Get or create default category
            $defaultCategory = Category::firstOrCreate(
                ['slug' => 'imported-from-stripe'],
                [
                    'name' => 'Imported from Stripe',
                    'description' => 'Products imported from Stripe catalog',
                    'is_active' => true,
                    'sort_order' => 0
                ]
            );
            
            $productData = [
                'stripe_product_id' => $stripeProduct->id,
                'category_id' => $defaultCategory->id,
                'name' => $stripeProduct->name,
                'slug' => \Str::slug($stripeProduct->name),
                'description' => $stripeProduct->description ?? '',
                'image_url' => $stripeProduct->images[0] ?? null,
                'images' => !empty($stripeProduct->images) ? $stripeProduct->images : null,
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
            
            return Product::updateOrCreate(
                ['stripe_product_id' => $stripeProduct->id],
                $productData
            );
            
        } catch (\Exception $e) {
            $this->error("Error importing product {$stripeProduct->name}: " . $e->getMessage());
            return null;
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
                
                Price::updateOrCreate(
                    ['stripe_price_id' => $stripePrice->id],
                    $priceData
                );
                
                $displayPrice = $stripePrice->nickname ?: ('$' . number_format($stripePrice->unit_amount / 100, 2));
                $this->line("  - Imported price: {$displayPrice}");
            }
            
        } catch (\Exception $e) {
            $this->error("Error importing prices for product {$product->name}: " . $e->getMessage());
        }
    }
}
