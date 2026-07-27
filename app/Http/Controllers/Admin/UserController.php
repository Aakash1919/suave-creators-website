<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    use RespondsToAdminAjax;

    /**
     * Render the users index or return Yajra DataTables JSON for AJAX.
     */
    public function index(Request $request, UserDataTable $dataTable): View|JsonResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return $dataTable->ajax($request);
        }

        return view('admin.users.index', [
            'columns' => UserDataTable::columns(),
            'canManage' => $request->user()->hasPermission('users.manage'),
        ]);
    }

    /**
     * Show the form to create a user and assign roles.
     */
    public function create(): View
    {
        return view('admin.users.form', [
            'user' => new User,
            'roles' => Role::query()->orderBy('name')->get(),
            'selectedRoles' => [],
        ]);
    }

    /**
     * Create a user and sync their roles.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', Rule::exists('roles', 'name')],
        ]);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles($data['roles'] ?? []);

        return $this->adminSuccess(
            $request,
            'User',
            'created',
            'admin.users.edit',
            $user,
            ['user' => ['id' => $user->id]]
        );
    }

    /**
     * Show the form to edit a user and their roles.
     */
    public function edit(User $user): View
    {
        return view('admin.users.form', [
            'user' => $user->load('roles'),
            'roles' => Role::query()->orderBy('name')->get(),
            'selectedRoles' => $user->roles->pluck('name')->all(),
        ]);
    }

    /**
     * Update a user's profile fields, optional password, and roles.
     */
    public function update(Request $request, User $user): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', Password::defaults()],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', Rule::exists('roles', 'name')],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->syncRoles($data['roles'] ?? []);

        return $this->adminSuccess(
            $request,
            'User',
            'updated',
            'admin.users.edit',
            $user,
            ['user' => ['id' => $user->id]]
        );
    }
}
