<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('event_date');
            $table->string('event_type');
            $table->text('event_description');
            $table->integer('guest_count');
            $table->string('venue_name')->nullable();
            $table->string('venue_address')->nullable();
            $table->string('budget_range');
            $table->text('special_requests')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_messages');
    }
};
