<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\RoleDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleStoreRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly RoleService $roles,
    ) {}

    /**
     * Render the roles index or return Yajra DataTables JSON for AJAX.
     */
    public function index(Request $request, RoleDataTable $dataTable): View|JsonResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return $dataTable->ajax($request);
        }

        return view('admin.roles.index', [
            'columns' => RoleDataTable::columns(),
            'canManage' => $request->user()->hasPermission('roles.manage'),
        ]);
    }

    /**
     * Show the form to create a role and assign permissions.
     */
    public function create(): View
    {
        return view('admin.roles.form', [
            'role' => $this->roles->newRole(),
            'permissionGroups' => $this->roles->permissionsGrouped(),
            'selectedPermissions' => [],
            'isProtected' => false,
        ]);
    }

    /**
     * Create a role and sync its permissions.
     */
    public function store(RoleStoreRequest $request): JsonResponse|RedirectResponse
    {
        $role = $this->roles->create($request);

        return $this->adminSuccess(
            $request,
            'Role',
            'created',
            'admin.roles.edit',
            $role,
            ['role' => ['id' => $role->id]]
        );
    }

    /**
     * Show the form to edit a role and its permissions.
     */
    public function edit(Role $role): View
    {
        $role->load('permissions');

        return view('admin.roles.form', [
            'role' => $role,
            'permissionGroups' => $this->roles->permissionsGrouped(),
            'selectedPermissions' => $role->permissions->pluck('name')->all(),
            'isProtected' => $this->roles->isProtected($role),
        ]);
    }

    /**
     * Update a role's details and permissions.
     */
    public function update(RoleUpdateRequest $request, Role $role): JsonResponse|RedirectResponse
    {
        $role = $this->roles->update($request, $role);

        return $this->adminSuccess(
            $request,
            'Role',
            'updated',
            'admin.roles.edit',
            $role,
            ['role' => ['id' => $role->id]]
        );
    }

    /**
     * Delete a role (protected admin role is rejected in the service).
     */
    public function destroy(Request $request, Role $role): JsonResponse|RedirectResponse
    {
        $this->roles->delete($role);

        return $this->adminSuccess($request, 'Role', 'deleted', 'admin.roles.index');
    }
}
