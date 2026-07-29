<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission('roles.manage') ?? false;
    }

    protected function prepareForValidation(): void
    {
        $role = $this->routeRole();

        if ($role !== null && app(RoleService::class)->isProtected($role)) {
            $this->merge(['name' => $role->name]);

            return;
        }

        if ($this->filled('name')) {
            $this->merge([
                'name' => Str::lower(trim((string) $this->input('name'))),
            ]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $role = $this->routeRole();
        $protected = $role !== null && app(RoleService::class)->isProtected($role);

        return [
            'name' => $protected
                ? ['nullable', 'string']
                : [
                    'required',
                    'string',
                    'max:80',
                    'regex:/^[a-z0-9]+(?:[._-][a-z0-9]+)*$/',
                    Rule::unique('roles', 'name')->ignore($role?->id),
                ],
            'label' => ['required', 'string', 'max:120'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::exists('permissions', 'name')],
        ];
    }

    private function routeRole(): ?Role
    {
        $role = $this->route('role');

        return $role instanceof Role ? $role : null;
    }
}
