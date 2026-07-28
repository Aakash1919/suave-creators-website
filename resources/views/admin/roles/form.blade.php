@extends('layouts.admin')

@section('title', $role->exists ? 'Edit role' : 'New role')

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">{{ $role->exists ? 'Edit role' : 'New role' }}</h1>
      <p class="admin-page-desc">Define the role key, display label, and which permissions it grants.</p>
    </div>
    <div class="admin-page-head__actions">
      <a href="{{ route('admin.roles.index') }}" class="admin-btn admin-btn--secondary">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
        Back
      </a>
      @if ($role->exists && ! $isProtected)
        <button type="button"
          class="admin-btn admin-btn--danger"
          data-admin-delete
          data-url="{{ route('admin.roles.destroy', $role) }}"
          data-reload-table=""
          data-confirm="Delete role “{{ $role->label }}”? Users with only this role will lose its permissions."
          data-confirm-title="Delete role?"
          data-confirm-label="Delete"
          data-success-message="Role has been deleted successfully.">
          <i class="fa-solid fa-trash" aria-hidden="true"></i>
          Delete
        </button>
      @endif
    </div>
  </div>

  <form method="POST"
    action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}"
    class="admin-card"
    data-ajax-form
    data-success-message="{{ $role->exists ? 'Role has been updated successfully.' : 'Role has been created successfully.' }}">
    @csrf
    @if ($role->exists)
      @method('PUT')
    @endif

    <div class="admin-card__header">
      <div>
        <h2 class="admin-card__title">Role details</h2>
        <p>Key, label, and permission checklist.</p>
      </div>
    </div>

    <div class="admin-card__body space-y-4">
      <div class="admin-form-grid admin-form-grid--2">
        <div>
          <label class="admin-label" for="role-name">Key</label>
          <input type="text"
            id="role-name"
            name="name"
            value="{{ old('name', $role->name) }}"
            @required(! $isProtected)
            @disabled($isProtected)
            pattern="[a-z0-9]+(?:[._-][a-z0-9]+)*"
            maxlength="80"
            class="admin-input"
            placeholder="e.g. content_manager"
            autocomplete="off">
          @if ($isProtected)
            <input type="hidden" name="name" value="{{ $role->name }}">
            <p class="mt-1 text-xs text-[var(--admin-muted)]">The Administrator key cannot be changed.</p>
          @else
            <p class="mt-1 text-xs text-[var(--admin-muted)]">Lowercase letters, numbers, dots, hyphens, or underscores.</p>
          @endif
        </div>
        <div>
          <label class="admin-label" for="role-label">Label</label>
          <input type="text"
            id="role-label"
            name="label"
            value="{{ old('label', $role->label) }}"
            required
            maxlength="120"
            class="admin-input"
            placeholder="e.g. Content manager">
        </div>
      </div>

      <div>
        <p class="admin-label">Permissions</p>
        @if ($permissionGroups->isEmpty())
          <p class="text-sm text-[var(--admin-muted)]">No permissions are seeded yet. Run RolesAndPermissionsSeeder.</p>
        @else
          <div class="space-y-3">
            @foreach ($permissionGroups as $group => $permissions)
              <div class="rounded-[0.55rem] border border-[var(--admin-border-strong)] p-3">
                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-[var(--admin-muted)]">{{ $group }}</p>
                <div class="space-y-2">
                  @foreach ($permissions as $permission)
                    <label class="admin-check">
                      <input type="checkbox"
                        name="permissions[]"
                        value="{{ $permission->name }}"
                        @checked(in_array($permission->name, old('permissions', $selectedPermissions), true))>
                      <span>
                        <strong class="text-[var(--admin-text)]">{{ $permission->label }}</strong>
                        <span class="text-[var(--admin-muted)]">({{ $permission->name }})</span>
                      </span>
                    </label>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
          Save role
        </button>
      </div>
    </div>
  </form>
@endsection
