@extends('layouts.admin')

@section('title', 'Login')

@section('content')
  <div class="admin-login-shell">
    <div class="admin-login-card">
      <div class="admin-login-card__brand">
        <img src="{{ asset('assets/brand/logo.png') }}" alt="Suave Creators" title="Suave Creators">
      </div>
      <h1>Sign in to Admin</h1>
      <p>Manage blogs, users, and SuaveAgent conversations.</p>

      @if ($errors->any())
        <div class="admin-alert admin-alert--danger" style="margin-top:1.25rem;margin-bottom:0">
          <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('admin.login.submit') }}" class="admin-login-form">
        @csrf
        <div>
          <label for="email" class="admin-label">Email</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
            class="admin-input" placeholder="you@company.com" autocomplete="username">
        </div>
        <div>
          <label for="password" class="admin-label">Password</label>
          <input id="password" type="password" name="password" required
            class="admin-input" placeholder="••••••••" autocomplete="current-password">
        </div>
        <label class="admin-check">
          <input type="checkbox" name="remember" value="1">
          Remember me on this device
        </label>
        <button type="submit" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>
          Sign in
        </button>
      </form>
    </div>
  </div>
@endsection
