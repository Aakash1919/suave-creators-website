<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var array<string, string>
     */
    private array $permissions = [
        'blog-categories.view' => 'View blog categories',
        'blog-categories.create' => 'Create blog categories',
        'blog-categories.update' => 'Update blog categories',
    ];

    /**
     * Add blog-categories permissions and grant them to the admin role.
     */
    public function up(): void
    {
        if (! Schema::hasTable('permissions') || ! Schema::hasTable('roles') || ! Schema::hasTable('role_permission')) {
            return;
        }

        $now = now();

        foreach ($this->permissions as $name => $label) {
            $exists = DB::table('permissions')->where('name', $name)->exists();

            if ($exists) {
                continue;
            }

            DB::table('permissions')->insert([
                'name' => $name,
                'label' => $label,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $adminId = DB::table('roles')->where('name', 'admin')->value('id');

        if ($adminId === null) {
            return;
        }

        $permissionIds = DB::table('permissions')
            ->whereIn('name', array_keys($this->permissions))
            ->pluck('id');

        foreach ($permissionIds as $permissionId) {
            $attached = DB::table('role_permission')
                ->where('role_id', $adminId)
                ->where('permission_id', $permissionId)
                ->exists();

            if ($attached) {
                continue;
            }

            DB::table('role_permission')->insert([
                'role_id' => $adminId,
                'permission_id' => $permissionId,
            ]);
        }
    }

    /**
     * Remove the blog-categories permissions and their role assignments.
     */
    public function down(): void
    {
        if (! Schema::hasTable('permissions')) {
            return;
        }

        $permissionIds = DB::table('permissions')
            ->whereIn('name', array_keys($this->permissions))
            ->pluck('id');

        if ($permissionIds->isEmpty()) {
            return;
        }

        if (Schema::hasTable('role_permission')) {
            DB::table('role_permission')->whereIn('permission_id', $permissionIds)->delete();
        }

        DB::table('permissions')->whereIn('id', $permissionIds)->delete();
    }
};
