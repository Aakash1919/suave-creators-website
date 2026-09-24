<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('contact_requests') && ! Schema::hasColumn('contact_requests', 'deleted_at')) {
            Schema::table('contact_requests', function (Blueprint $table): void {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('contact_requests') && Schema::hasColumn('contact_requests', 'deleted_at')) {
            Schema::table('contact_requests', function (Blueprint $table): void {
                $table->dropSoftDeletes();
            });
        }
    }
};
