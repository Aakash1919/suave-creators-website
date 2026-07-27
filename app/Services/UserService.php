<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

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
     *
     * @throws ValidationException
     */
    public function create(Request $request): User
    {
        $data = $this->validated($request);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles($data['roles'] ?? []);

        return $user;
    }

    /**
     * Update a user and sync roles.
     *
     * @throws ValidationException
     */
    public function update(Request $request, User $user): User
    {
        $data = $this->validated($request, $user);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->syncRoles($data['roles'] ?? []);

        return $user->refresh();
    }

    /**
     * @return array{name: string, email: string, password?: string, roles?: list<string>}
     *
     * @throws ValidationException
     */
    public function validated(Request $request, ?User $user = null): array
    {
        $creating = $user === null;

        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password' => [$creating ? 'required' : 'nullable', Password::defaults()],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', Rule::exists('roles', 'name')],
        ]);
    }
}
