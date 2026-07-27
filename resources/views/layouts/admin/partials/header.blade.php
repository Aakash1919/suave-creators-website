@php
  $pageTitle = $pageTitle ?? (trim($__env->yieldContent('title')) ?: 'Admin');
  $user = $user ?? Auth::user();
  $user?->loadMissing('roles');
  $initials = $initials ?? (
    collect(preg_split('/\s+/', trim((string) ($user?->name ?? '')) ?: 'SC'))
      ->filter()
      ->take(2)
      ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
      ->implode('') ?: 'SC'
  );
  $roleLabel = $user?->roles?->first()?->label
    ?? ($user?->hasRole('admin') ? 'Administrator' : 'Team member');
@endphp

<header class="admin-header">
  <div class="admin-header__left">
    <button type="button" class="admin-menu-toggle" data-admin-menu aria-label="Toggle sidebar" title="Toggle sidebar">
      <i class="fa-solid fa-bars" aria-hidden="true"></i>
    </button>
    <div class="admin-breadcrumb">
      <span class="admin-breadcrumb__eyebrow">Home / Admin</span>
      <h1 class="admin-breadcrumb__title">{{ $pageTitle }}</h1>
    </div>
  </div>

  <div class="admin-header__actions">
    @hasSection('header-actions')
      @yield('header-actions')
    @endif

    <form class="admin-header-search" action="{{ route('admin.dashboard') }}" method="GET" role="search">
      <input type="search" name="q" placeholder="Search" aria-label="Search" autocomplete="off">
      <button type="submit" aria-label="Submit search">
        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
      </button>
    </form>

    <a href="{{ url('/') }}" target="_blank" rel="noopener" class="admin-header-icon" title="View site">
      <i class="fa-solid fa-globe" aria-hidden="true"></i>
    </a>

    <button type="button" class="admin-header-icon" title="Notifications" aria-label="Notifications">
      <i class="fa-regular fa-bell" aria-hidden="true"></i>
      <span class="admin-header-icon__dot" aria-hidden="true"></span>
    </button>

    <div class="admin-user-menu" data-admin-user-menu>
      <button type="button"
        class="admin-user-menu__trigger"
        data-admin-user-toggle
        aria-expanded="false"
        aria-haspopup="true"
        aria-controls="admin-user-dropdown">
        <span class="admin-user-menu__avatar" aria-hidden="true">{{ $initials }}</span>
        <span class="admin-user-menu__status" aria-hidden="true"></span>
      </button>

      <div id="admin-user-dropdown" class="admin-user-menu__dropdown" data-admin-user-dropdown hidden>
        <div class="admin-user-menu__profile">
          <span class="admin-user-menu__avatar admin-user-menu__avatar--lg" aria-hidden="true">{{ $initials }}</span>
          <div class="admin-user-menu__meta">
            <strong>{{ $user->name }}</strong>
            <span>{{ $roleLabel }}</span>
          </div>
        </div>

        <div class="admin-user-menu__list">
          <a href="{{ route('admin.profile.edit') }}" class="admin-user-menu__item">
            <i class="fa-regular fa-user" aria-hidden="true"></i>
            <span>Profile Settings</span>
          </a>
        </div>

        <div class="admin-user-menu__footer">
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="admin-user-menu__item admin-user-menu__item--danger">
              <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
              <span>Sign Out</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</header>
