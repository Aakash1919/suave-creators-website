<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('blogs', 'small_thumb_image')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('small_thumb_image')->nullable()->after('featured_image');
            });
        }

        if (! Schema::hasColumn('blogs', 'medium_thumb_image')) {
            Schema::table('blogs', function (Blueprint $table) {
                $after = Schema::hasColumn('blogs', 'small_thumb_image')
                    ? 'small_thumb_image'
                    : 'featured_image';
                $table->string('medium_thumb_image')->nullable()->after($after);
            });
        }
    }

    public function down(): void
    {
        $columns = collect(['small_thumb_image', 'medium_thumb_image'])
            ->filter(fn (string $column): bool => Schema::hasColumn('blogs', $column))
            ->values()
            ->all();

        if ($columns === []) {
            return;
        }

        Schema::table('blogs', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};
