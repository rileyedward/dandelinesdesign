<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->text('content');
            $table->enum('status', ['draft', 'sent'])->default('draft');
            $table->timestamp('sent_at')->nullable();
            $table->integer('recipients_count')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('scheduled_at');
            $table->index('sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_templates');
    }
};
