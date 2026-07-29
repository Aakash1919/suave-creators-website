<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Undo schema (and gallery RBAC rows) left on staging after
     * implement_gallery was reverted in code.
     */
    public function up(): void
    {
        Schema::dropIfExists('images');

        $blogThumbColumns = collect(['small_thumb_image', 'medium_thumb_image'])
            ->filter(fn (string $column): bool => Schema::hasColumn('blogs', $column))
            ->values()
            ->all();

        if ($blogThumbColumns !== []) {
            Schema::table('blogs', function (Blueprint $table) use ($blogThumbColumns) {
                $table->dropColumn($blogThumbColumns);
            });
        }

        $testimonialThumbColumns = collect(['small_thumb_avatar', 'medium_thumb_avatar'])
            ->filter(fn (string $column): bool => Schema::hasColumn('testimonials', $column))
            ->values()
            ->all();

        if ($testimonialThumbColumns !== []) {
            Schema::table('testimonials', function (Blueprint $table) use ($testimonialThumbColumns) {
                $table->dropColumn($testimonialThumbColumns);
            });
        }

        if (Schema::hasTable('permissions')) {
            $permissionIds = DB::table('permissions')
                ->whereIn('name', ['gallery.view', 'gallery.manage'])
                ->pluck('id');

            if ($permissionIds->isNotEmpty()) {
                if (Schema::hasTable('role_permission')) {
                    DB::table('role_permission')
                        ->whereIn('permission_id', $permissionIds)
                        ->delete();
                }

                DB::table('permissions')
                    ->whereIn('id', $permissionIds)
                    ->delete();
            }
        }

        // Remove batch rows for gallery migrations deleted with the code revert.
        DB::table('migrations')
            ->whereIn('migration', [
                '2026_07_29_000004_add_image_thumb_columns_to_blogs_and_testimonials',
                '2026_07_29_000005_create_images_table',
            ])
            ->delete();
    }

    public function down(): void
    {
        if (! Schema::hasColumn('blogs', 'small_thumb_image')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('small_thumb_image')->nullable()->after('featured_image');
            });
        }

        if (! Schema::hasColumn('blogs', 'medium_thumb_image')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('medium_thumb_image')->nullable()->after('small_thumb_image');
            });
        }

        if (! Schema::hasColumn('testimonials', 'small_thumb_avatar')) {
            Schema::table('testimonials', function (Blueprint $table) {
                $table->string('small_thumb_avatar')->nullable()->after('avatar');
            });
        }

        if (! Schema::hasColumn('testimonials', 'medium_thumb_avatar')) {
            Schema::table('testimonials', function (Blueprint $table) {
                $table->string('medium_thumb_avatar')->nullable()->after('small_thumb_avatar');
            });
        }

        if (! Schema::hasTable('images')) {
            Schema::create('images', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('path');
                $table->string('small_thumb_path')->nullable();
                $table->string('medium_thumb_path')->nullable();
                $table->string('alt_text')->nullable();
                $table->foreignId('created_by_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
                $table->timestamps();
            });
        }
    }
};
