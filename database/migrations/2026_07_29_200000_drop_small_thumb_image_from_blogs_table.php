<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('blogs', 'small_thumb_image')) {
            return;
        }

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('small_thumb_image');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('blogs', 'small_thumb_image')) {
            return;
        }

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('small_thumb_image')->nullable()->after('featured_image');
        });
    }
};
