<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('chat_leads')) {
            return;
        }

        if (! Schema::hasColumn('chat_leads', 'phone')) {
            Schema::table('chat_leads', function (Blueprint $table): void {
                $table->string('phone', 40)->nullable()->after('email');
            });
        }

        if ($this->columnIsRequired('email')) {
            Schema::table('chat_leads', function (Blueprint $table): void {
                $table->string('email')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('chat_leads')) {
            return;
        }

        if (Schema::hasColumn('chat_leads', 'phone')) {
            Schema::table('chat_leads', function (Blueprint $table): void {
                $table->dropColumn('phone');
            });
        }

        if (Schema::hasColumn('chat_leads', 'email') && ! $this->columnIsRequired('email')) {
            Schema::table('chat_leads', function (Blueprint $table): void {
                $table->string('email')->nullable(false)->change();
            });
        }
    }

    private function columnIsRequired(string $column): bool
    {
        if (! Schema::hasColumn('chat_leads', $column)) {
            return false;
        }

        $meta = collect(Schema::getColumns('chat_leads'))->firstWhere('name', $column);

        return $meta !== null && empty($meta['nullable']);
    }
};
