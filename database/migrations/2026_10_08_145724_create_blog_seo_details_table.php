<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blog_seo_details')) {
            return;
        }

        Schema::create('blog_seo_details', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('blog_id')->unique()->constrained('blogs')->cascadeOnDelete();
            $table->json('tags')->nullable();
            $table->json('keywords')->nullable();
            $table->json('about')->nullable();
            $table->json('mentions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_seo_details');
    }
};
