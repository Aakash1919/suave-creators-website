<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('contact_requests')) {
            return;
        }

        if (! Schema::hasColumn('contact_requests', 'draft_token')) {
            Schema::table('contact_requests', function (Blueprint $table) {
                $table->uuid('draft_token')->nullable()->unique()->after('id');
            });
        }

        $nullable = [
            'name' => fn (Blueprint $table) => $table->string('name')->nullable()->change(),
            'email' => fn (Blueprint $table) => $table->string('email')->nullable()->change(),
            'phone' => fn (Blueprint $table) => $table->string('phone', 60)->nullable()->change(),
            'service' => fn (Blueprint $table) => $table->string('service', 80)->nullable()->change(),
            'message' => fn (Blueprint $table) => $table->text('message')->nullable()->change(),
        ];

        $required = array_keys(array_filter(
            $nullable,
            fn (callable $unused, string $column): bool => $this->columnIsRequired($column),
            ARRAY_FILTER_USE_BOTH
        ));

        if ($required === []) {
            return;
        }

        Schema::table('contact_requests', function (Blueprint $table) use ($nullable, $required) {
            foreach ($required as $column) {
                $nullable[$column]($table);
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('contact_requests')) {
            return;
        }

        if (! Schema::hasColumn('contact_requests', 'draft_token')) {
            return;
        }

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->dropUnique(['draft_token']);
            $table->dropColumn('draft_token');
        });
    }

    private function columnIsRequired(string $column): bool
    {
        if (! Schema::hasColumn('contact_requests', $column)) {
            return false;
        }

        $meta = collect(Schema::getColumns('contact_requests'))->firstWhere('name', $column);

        return $meta !== null && empty($meta['nullable']);
    }
};
