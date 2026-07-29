<?php

namespace App\Services;

use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Roles for the admin user form select.
     *
     * @return Collection<int, Role>
     */
    public function roles(): Collection
    {
        return Role::query()->orderBy('name')->get();
    }

    /**
     * Empty user model for the create form.
     */
    public function newUser(): User
    {
        return new User;
    }

    /**
     * Create a user and sync roles.
     */
    public function create(UserStoreRequest $request): User
    {
        $data = $request->validated();

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles($this->roleNames($data['role'] ?? null));

        return $user;
    }

    /**
     * Update a user and sync roles.
     */
    public function update(UserUpdateRequest $request, User $user): User
    {
        $data = $request->validated();

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->syncRoles($this->roleNames($data['role'] ?? null));

        return $user->refresh();
    }

    /**
     * @return list<string>
     */
    private function roleNames(?string $role): array
    {
        return filled($role) ? [(string) $role] : [];
    }
}
