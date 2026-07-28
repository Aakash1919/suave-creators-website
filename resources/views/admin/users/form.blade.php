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
    data-ajax-form
    data-success-message="{{ $user->exists ? 'User has been updated successfully.' : 'User has been created successfully.' }}">
    @csrf
    @if ($user->exists)
      @method('PUT')
    @endif

    <div class="admin-card__header">
      <div>
        <h2 class="admin-card__title">User details</h2>
        <p>Name, email, password, and role.</p>
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
        <label class="admin-label" for="user-role">Role</label>
        <select id="user-role" name="role" class="admin-select">
          <option value="">Select a role</option>
          @foreach ($roles as $role)
            <option value="{{ $role->name }}" @selected(old('role', $selectedRole) === $role->name)>
              {{ $role->label }} ({{ $role->name }})
            </option>
          @endforeach
        </select>
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
