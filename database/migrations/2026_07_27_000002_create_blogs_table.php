<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_category_id')
                ->nullable()
                ->constrained('blog_categories')
                ->nullOnDelete();
            $table->foreignId('created_by_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->string('slug', 160)->unique();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('status', 20)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->json('toc')->nullable();
            $table->json('faqs')->nullable();
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('og_title', 95)->nullable();
            $table->string('og_description', 300)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
