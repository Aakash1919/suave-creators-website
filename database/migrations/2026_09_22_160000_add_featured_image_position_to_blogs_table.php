<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blogs') && ! Schema::hasColumn('blogs', 'featured_image_position')) {
            Schema::table('blogs', function (Blueprint $table): void {
                $table->string('featured_image_position', 32)
                    ->default('after_first_p')
                    ->after('featured_image');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('blogs') && Schema::hasColumn('blogs', 'featured_image_position')) {
            Schema::table('blogs', function (Blueprint $table): void {
                $table->dropColumn('featured_image_position');
            });
        }
    }
};
