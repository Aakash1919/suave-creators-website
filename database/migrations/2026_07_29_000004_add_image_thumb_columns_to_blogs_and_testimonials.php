<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('small_thumb_image')->nullable()->after('featured_image');
            $table->string('medium_thumb_image')->nullable()->after('small_thumb_image');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('small_thumb_avatar')->nullable()->after('avatar');
            $table->string('medium_thumb_avatar')->nullable()->after('small_thumb_avatar');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['small_thumb_image', 'medium_thumb_image']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['small_thumb_avatar', 'medium_thumb_avatar']);
        });
    }
};
