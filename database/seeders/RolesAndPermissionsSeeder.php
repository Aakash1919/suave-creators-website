<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Support\SiteAdmin;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed custom RBAC permissions, admin/editor roles, and assign admin to SiteAdmin.
     */
    public function run(): void
    {
        $permissions = [
            'blogs.view' => 'View blogs',
            'blogs.create' => 'Create blogs',
            'blogs.update' => 'Update blogs',
            'blogs.delete' => 'Delete blogs',
            'conversations.view' => 'View AI conversations',
            'contacts.view' => 'View contact requests',
            'users.view' => 'View users',
            'users.manage' => 'Manage users and roles',
            'profile.update' => 'Update own profile',
            'seo.audit' => 'Generate SEO audit reports',
        ];

        foreach ($permissions as $name => $label) {
            Permission::query()->updateOrCreate(
                ['name' => $name],
                ['label' => $label]
            );
        }

        $allPermissionIds = Permission::query()->pluck('id');

        $admin = Role::query()->updateOrCreate(
            ['name' => 'admin'],
            ['label' => 'Administrator']
        );
        $admin->permissions()->sync($allPermissionIds);

        $editor = Role::query()->updateOrCreate(
            ['name' => 'editor'],
            ['label' => 'Editor']
        );
        $editor->permissions()->sync(
            Permission::query()
                ->whereIn('name', [
                    'blogs.view',
                    'blogs.create',
                    'blogs.update',
                    'profile.update',
                    'conversations.view',
                    'contacts.view',
                ])
                ->pluck('id')
        );

        $user = SiteAdmin::ensure();
        $user->assignRole('admin');
    }
}
