<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('blogs', 'medium_thumb_image')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('medium_thumb_image')->nullable()->after('featured_image');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('blogs', 'medium_thumb_image')) {
            return;
        }

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('medium_thumb_image');
        });
    }
};
