@extends('layouts.admin')

@section('title', $user->exists ? 'Edit user' : 'New user')

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">{{ $user->exists ? 'Edit user' : 'New user' }}</h1>
      <p class="admin-page-desc">Account credentials and role access for the admin panel.</p>
    </div>
    <div class="admin-page-head__actions">
      <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--secondary">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
        Back
      </a>
    </div>
  </div>

  <form method="POST"
    action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}"
    class="admin-card"
    style="max-width:40rem"
    data-ajax-form
    data-success-message="{{ $user->exists ? 'User has been updated successfully.' : 'User has been created successfully.' }}">
    @csrf
    @if ($user->exists)
      @method('PUT')
    @endif

    <div class="admin-card__header">
      <div>
        <h2 class="admin-card__title">User details</h2>
        <p>Name, email, password, and roles.</p>
      </div>
    </div>

    <div class="admin-card__body space-y-4">
      <div>
        <label class="admin-label">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="admin-input">
      </div>
      <div>
        <label class="admin-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="admin-input">
      </div>
      <div>
        <label class="admin-label">Password {{ $user->exists ? '(leave blank to keep)' : '' }}</label>
        <input type="password" name="password" @required(! $user->exists) class="admin-input" autocomplete="new-password">
      </div>
      <div>
        <p class="admin-label">Roles</p>
        <div class="space-y-2 rounded-[0.55rem] border border-[var(--admin-border-strong)] p-3">
          @foreach ($roles as $role)
            <label class="admin-check">
              <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                @checked(in_array($role->name, old('roles', $selectedRoles), true))>
              <span>
                <strong class="text-[var(--admin-text)]">{{ $role->label }}</strong>
                <span class="text-[var(--admin-muted)]">({{ $role->name }})</span>
              </span>
            </label>
          @endforeach
        </div>
      </div>
      <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
          Save user
        </button>
      </div>
    </div>
  </form>
@endsection
