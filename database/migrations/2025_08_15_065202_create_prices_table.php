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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_price_id')->unique();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Price details
            $table->boolean('active')->default(true);
            $table->string('currency', 3)->default('USD');
            $table->string('type')->default('one_time'); // one_time, recurring
            $table->decimal('unit_amount', 10, 2); // Amount in currency units
            $table->integer('unit_amount_decimal')->nullable(); // Amount in smallest currency unit (cents)
            
            // Billing details (for recurring prices)
            $table->string('billing_scheme')->nullable(); // per_unit, tiered
            $table->json('recurring')->nullable(); // interval, interval_count, etc.
            $table->integer('usage_type')->nullable(); // licensed, metered
            
            // Tax and display
            $table->boolean('tax_behavior')->nullable(); // inclusive, exclusive, unspecified
            $table->string('nickname')->nullable(); // Display name for the price
            
            // Stripe metadata
            $table->json('metadata')->nullable();
            $table->timestamp('stripe_created_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('stripe_price_id');
            $table->index('product_id');
            $table->index('active');
            $table->index(['product_id', 'active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
