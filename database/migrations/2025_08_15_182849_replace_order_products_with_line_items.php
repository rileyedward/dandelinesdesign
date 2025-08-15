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
        // Drop the order_products table if it exists
        Schema::dropIfExists('order_products');
        
        // Create the new line_items table
        Schema::create('line_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Product details at time of purchase
            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->text('product_description')->nullable();
            $table->string('product_image_url')->nullable();
            
            // Pricing details
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('currency', 3)->default('USD');
            
            // Stripe integration
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_product_id')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['order_id', 'product_id']);
            $table->index('stripe_price_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_items');
        
        // Recreate order_products table
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();
        });
    }
};
