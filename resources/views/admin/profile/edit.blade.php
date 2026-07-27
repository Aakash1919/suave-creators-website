@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">Profile</h1>
      <p class="admin-page-desc">Update your account details and password.</p>
    </div>
  </div>

  <div class="grid gap-4 lg:grid-cols-2">
    <form method="POST" action="{{ route('admin.profile.update') }}" class="admin-card" data-ajax-form data-success-message="Profile has been updated successfully.">
      @csrf
      @method('PUT')
      <div class="admin-card__header">
        <div>
          <h2 class="admin-card__title">Account details</h2>
          <p>Name and email used for admin access.</p>
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
        <div class="admin-form-actions">
          <button type="submit" class="admin-btn admin-btn--primary">
            <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
            Save profile
          </button>
        </div>
      </div>
    </form>

    <form method="POST" action="{{ route('admin.profile.password') }}" class="admin-card" data-ajax-form data-success-message="Password has been updated successfully.">
      @csrf
      @method('PUT')
      <div class="admin-card__header">
        <div>
          <h2 class="admin-card__title">Change password</h2>
          <p>Use a strong password you don’t reuse elsewhere.</p>
        </div>
      </div>
      <div class="admin-card__body space-y-4">
        <div>
          <label class="admin-label">Current password</label>
          <input type="password" name="current_password" required class="admin-input" autocomplete="current-password">
        </div>
        <div>
          <label class="admin-label">New password</label>
          <input type="password" name="password" required class="admin-input" autocomplete="new-password">
        </div>
        <div>
          <label class="admin-label">Confirm password</label>
          <input type="password" name="password_confirmation" required class="admin-input" autocomplete="new-password">
        </div>
        <div class="admin-form-actions">
          <button type="submit" class="admin-btn admin-btn--primary">
            <i class="fa-solid fa-key" aria-hidden="true"></i>
            Update password
          </button>
        </div>
      </div>
    </form>
  </div>
@endsection
