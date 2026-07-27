<?php

namespace App\Models\Concerns;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

trait HasRoles
{
    /**
     * Roles assigned to this user via the user_role pivot.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * Whether the user has a role with the given name.
     */
    public function hasRole(string $role): bool
    {
        return $this->roles->contains(fn (Role $item): bool => $item->name === $role);
    }

    /**
     * Whether the user has at least one of the given role names.
     *
     * @param  list<string>  $roles
     */
    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Whether any assigned role grants the named permission.
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissionNames()->contains($permission);
    }

    /**
     * Unique permission names granted through the user's roles.
     *
     * @return Collection<int, string>
     */
    public function permissionNames(): Collection
    {
        $this->loadMissing('roles.permissions');

        return $this->roles
            ->flatMap(fn (Role $role) => $role->permissions->pluck('name'))
            ->unique()
            ->values();
    }

    /**
     * Attach a role by name or model without removing existing roles.
     */
    public function assignRole(string|Role $role): void
    {
        $roleModel = $role instanceof Role
            ? $role
            : Role::query()->where('name', $role)->firstOrFail();

        $this->roles()->syncWithoutDetaching([$roleModel->id]);
        $this->unsetRelation('roles');
    }

    /**
     * Replace the user's roles with the given list of names or models.
     *
     * @param  list<string|Role>  $roles
     */
    public function syncRoles(array $roles): void
    {
        $ids = collect($roles)->map(function (string|Role $role): int {
            if ($role instanceof Role) {
                return $role->id;
            }

            return (int) Role::query()->where('name', $role)->firstOrFail()->id;
        })->all();

        $this->roles()->sync($ids);
        $this->unsetRelation('roles');
    }
}
