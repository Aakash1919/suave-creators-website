<?php

namespace App\DataTables\Admin;

use App\Models\Role;
use App\Services\RoleService;
use App\Support\Admin\DataTableActions;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RoleDataTable
{
    /**
     * Build the server-side roles DataTable JSON response.
     */
    public function ajax(Request $request): mixed
    {
        /** @var EloquentBuilder<Role> $query */
        $query = Role::query()
            ->select('roles.*')
            ->withCount(['permissions', 'users']);

        return DataTables::eloquent($query)
            ->editColumn('label', function (Role $role): string {
                return '<div class="admin-table__title">'.e($role->label).'</div>'
                    .'<div class="text-xs text-[var(--admin-muted)]">'.e($role->name).'</div>';
            })
            ->editColumn('permissions_count', function (Role $role): string {
                return '<span class="admin-badge admin-badge--info">'.(int) $role->permissions_count.'</span>';
            })
            ->editColumn('users_count', function (Role $role): string {
                return '<span class="admin-badge admin-badge--muted">'.(int) $role->users_count.'</span>';
            })
            ->addColumn('actions', function (Role $role): string {
                if (! Auth::user()?->hasPermission('roles.manage')) {
                    return '—';
                }

                $items = [
                    [
                        'label' => 'Edit',
                        'url' => route('admin.roles.edit', $role),
                    ],
                ];

                if ($role->name !== RoleService::PROTECTED_ROLE) {
                    $items[] = [
                        'label' => 'Delete',
                        'url' => route('admin.roles.destroy', $role),
                        'delete' => true,
                        'confirm' => 'Delete role “'.$role->label.'”? Users with only this role will lose its permissions.',
                        'confirmTitle' => 'Delete role?',
                        'confirmLabel' => 'Delete',
                    ];
                }

                return DataTableActions::menu($items);
            })
            ->orderColumn('permissions_count', 'permissions_count $1')
            ->orderColumn('users_count', 'users_count $1')
            ->orderColumn('actions', false)
            ->filterColumn('label', function (EloquentBuilder $query, string $keyword): void {
                $query->where(function (EloquentBuilder $inner) use ($keyword): void {
                    $inner->where('roles.label', 'like', "%{$keyword}%")
                        ->orWhere('roles.name', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['label', 'permissions_count', 'users_count', 'actions'])
            ->toJson();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function columns(): array
    {
        return [
            ['data' => 'label', 'name' => 'label', 'title' => 'Role'],
            ['data' => 'permissions_count', 'name' => 'permissions_count', 'title' => 'Permissions', 'searchable' => false],
            ['data' => 'users_count', 'name' => 'users_count', 'title' => 'Users', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'className' => 'admin-table__actions'],
        ];
    }
}
