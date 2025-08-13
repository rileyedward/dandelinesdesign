<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->enum('service_type', ['floral_design', 'event_planning', 'both']);
            $table->date('event_date')->nullable();
            $table->string('event_location')->nullable();
            $table->integer('guest_count')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->text('description');
            $table->enum('status', ['pending', 'contacted', 'quoted', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
