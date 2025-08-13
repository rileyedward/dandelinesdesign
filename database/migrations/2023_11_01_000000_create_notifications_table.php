<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['primary', 'success', 'danger', 'warning', 'info'])->default('info');
            $table->string('title');
            $table->text('message');
            $table->string('action_url', 500)->nullable();
            $table->string('action_text', 100)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
