<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilePasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly ProfileService $profiles,
    ) {}

    /**
     * Show the signed-in user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the signed-in user's name and email.
     */
    public function update(ProfileUpdateRequest $request): JsonResponse|RedirectResponse
    {
        $this->profiles->update($request, $request->user());

        return $this->adminSuccess($request, 'Profile', 'updated');
    }

    /**
     * Change the signed-in user's password after verifying the current one.
     */
    public function updatePassword(ProfilePasswordUpdateRequest $request): JsonResponse|RedirectResponse
    {
        $this->profiles->updatePassword($request, $request->user());

        return $this->adminSuccess($request, 'Password', 'updated');
    }
}
