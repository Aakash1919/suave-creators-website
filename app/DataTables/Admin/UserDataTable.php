<?php

namespace App\DataTables\Admin;

use App\Models\User;
use App\Support\Admin\DataTableActions;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserDataTable
{
    /**
     * Build the server-side users DataTable JSON response.
     */
    public function ajax(Request $request): mixed
    {
        /** @var EloquentBuilder<User> $query */
        $query = User::query()
            ->with('roles')
            ->select('users.*');

        return DataTables::eloquent($query)
            ->editColumn('name', function (User $user): string {
                return '<div class="admin-table__person">'
                    .'<span class="admin-table__avatar" aria-hidden="true">'.e(self::initials($user->name)).'</span>'
                    .'<div class="admin-table__title">'.e($user->name).'</div>'
                    .'</div>';
            })
            ->addColumn('roles_list', function (User $user): string {
                if ($user->roles->isEmpty()) {
                    return '<span class="admin-badge admin-badge--muted">None</span>';
                }

                return $user->roles
                    ->map(fn ($role): string => '<span class="admin-badge admin-badge--info">'.e($role->label).'</span>')
                    ->implode(' ');
            })
            ->addColumn('actions', function (User $user): string {
                if (! Auth::user()?->hasPermission('users.manage')) {
                    return '—';
                }

                return DataTableActions::menu([
                    [
                        'label' => 'Edit',
                        'url' => route('admin.users.edit', $user),
                    ],
                ]);
            })
            ->orderColumn('roles_list', false)
            ->orderColumn('actions', false)
            ->rawColumns(['name', 'roles_list', 'actions'])
            ->toJson();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function columns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'roles_list', 'name' => 'roles_list', 'title' => 'Roles', 'orderable' => false, 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'className' => 'admin-table__actions'],
        ];
    }

    private static function initials(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name) ?: 'SC') ?: ['SC'];

        return collect($parts)
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr((string) $part, 0, 1)))
            ->implode('') ?: 'SC';
    }
}
