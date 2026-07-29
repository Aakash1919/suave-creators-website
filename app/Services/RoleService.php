<?php

namespace App\Services;

use App\Http\Requests\Admin\RoleStoreRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class RoleService
{
    public const PROTECTED_ROLE = 'admin';

    /**
     * Empty role model for the create form.
     */
    public function newRole(): Role
    {
        return new Role;
    }

    /**
     * All permissions ordered for the role form checkboxes.
     *
     * @return Collection<int, Permission>
     */
    public function permissions(): Collection
    {
        return Permission::query()->orderBy('name')->get();
    }

    /**
     * Permissions grouped by the prefix before the first dot (e.g. blogs, users).
     *
     * @return Collection<string, Collection<int, Permission>>
     */
    public function permissionsGrouped(): Collection
    {
        return $this->permissions()->groupBy(function (Permission $permission): string {
            $dot = strpos($permission->name, '.');

            return $dot === false ? $permission->name : substr($permission->name, 0, $dot);
        });
    }

    /**
     * Create a role and sync permissions.
     */
    public function create(RoleStoreRequest $request): Role
    {
        $data = $request->validated();

        $role = Role::query()->create([
            'name' => $data['name'],
            'label' => $data['label'],
        ]);

        $role->permissions()->sync($this->permissionIds($data['permissions'] ?? []));

        return $role->load('permissions');
    }

    /**
     * Update a role's label (and name when not protected) and sync permissions.
     */
    public function update(RoleUpdateRequest $request, Role $role): Role
    {
        $data = $request->validated();

        if (! $this->isProtected($role)) {
            $role->name = $data['name'];
        }

        $role->label = $data['label'];
        $role->save();
        $role->permissions()->sync($this->permissionIds($data['permissions'] ?? []));

        return $role->refresh()->load('permissions');
    }

    /**
     * Delete a role unless it is the protected admin role.
     *
     * @throws ValidationException
     */
    public function delete(Role $role): void
    {
        if ($this->isProtected($role)) {
            throw ValidationException::withMessages([
                'role' => 'The Administrator role cannot be deleted.',
            ]);
        }

        $role->delete();
    }

    /**
     * Whether the role is system-protected (name locked, not deletable).
     */
    public function isProtected(Role $role): bool
    {
        return $role->exists && $role->name === self::PROTECTED_ROLE;
    }

    /**
     * @param  list<string>  $names
     * @return list<int>
     */
    private function permissionIds(array $names): array
    {
        if ($names === []) {
            return [];
        }

        return Permission::query()
            ->whereIn('name', $names)
            ->pluck('id')
            ->all();
    }
}
