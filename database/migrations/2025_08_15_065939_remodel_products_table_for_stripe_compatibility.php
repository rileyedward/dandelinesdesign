<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add Stripe-specific fields
            $table->string('stripe_product_id')->unique()->nullable()->after('id');
            $table->text('description')->change(); // Ensure it can handle longer descriptions
            $table->json('images')->nullable()->after('image_url'); // Multiple images
            $table->string('package_dimensions')->nullable()->after('images'); // Shipping info
            $table->decimal('weight', 8, 2)->nullable()->after('package_dimensions'); // Weight in ounces
            $table->boolean('shippable')->default(true)->after('weight');
            $table->string('tax_code')->nullable()->after('shippable'); // Stripe tax code
            $table->json('metadata')->nullable()->after('tax_code'); // Custom metadata
            $table->string('unit_label')->nullable()->after('metadata'); // Unit of measurement

            // Remove the price field since it will be in the prices table
            $table->dropColumn('price');

            // Remove stock_quantity as it's not needed for Stripe catalog
            $table->dropColumn('stock_quantity');

            // Update indexes
            $table->index('stripe_product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add back the price and stock_quantity fields
            $table->decimal('price', 8, 2)->after('description');
            $table->integer('stock_quantity')->default(0)->after('is_featured');

            // Remove Stripe-specific fields
            $table->dropIndex(['stripe_product_id']);
            $table->dropColumn([
                'stripe_product_id',
                'images',
                'package_dimensions',
                'weight',
                'shippable',
                'tax_code',
                'metadata',
                'unit_label',
            ]);
        });
    }
};
