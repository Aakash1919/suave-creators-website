<?php

namespace App\Services;

use App\Http\Requests\Admin\ProfilePasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    /**
     * Update the signed-in user's name and email.
     */
    public function update(ProfileUpdateRequest $request, User $user): User
    {
        $user->update($request->validated());

        return $user->refresh();
    }

    /**
     * Change password after verifying the current password.
     */
    public function updatePassword(ProfilePasswordUpdateRequest $request, User $user): User
    {
        $data = $request->validated();

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return $user->refresh();
    }
}
