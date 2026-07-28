<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly UserService $users,
    ) {}

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
            'user' => $this->users->newUser(),
            'roles' => $this->users->roles(),
            'selectedRole' => null,
        ]);
    }

    /**
     * Create a user and sync their roles.
     */
    public function store(UserStoreRequest $request): JsonResponse|RedirectResponse
    {
        $user = $this->users->create($request);

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
        $user->load('roles');

        return view('admin.users.form', [
            'user' => $user,
            'roles' => $this->users->roles(),
            'selectedRole' => $user->roles->first()?->name,
        ]);
    }

    /**
     * Update a user's profile fields, optional password, and roles.
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse|RedirectResponse
    {
        $user = $this->users->update($request, $user);

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
