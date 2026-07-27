<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfileService
{
    /**
     * Update the signed-in user's name and email.
     *
     * @throws ValidationException
     */
    public function update(Request $request, User $user): User
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);

        $user->update($data);

        return $user->refresh();
    }

    /**
     * Change password after verifying the current password.
     *
     * @throws ValidationException
     */
    public function updatePassword(Request $request, User $user): User
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return $user->refresh();
    }
}
