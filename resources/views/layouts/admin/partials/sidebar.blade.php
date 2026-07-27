@php
  $user = $user ?? Auth::user();
  $initials = $initials ?? (
    collect(preg_split('/\s+/', trim((string) ($user?->name ?? '')) ?: 'SC'))
      ->filter()
      ->take(2)
      ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
      ->implode('') ?: 'SC'
  );
@endphp

<aside class="admin-sidebar" data-admin-sidebar>
  <div class="admin-sidebar__brand">
    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__brand-link" aria-label="Suave Creators Admin">
      <img src="{{ asset('assets/brand/logo.svg') }}" alt="Suave Creators" title="Suave Creators">
    </a>
  </div>

  <nav class="admin-sidebar__nav" aria-label="Admin">
    <p class="admin-nav-label">Main</p>
    <a href="{{ route('admin.dashboard') }}"
      class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
      title="Dashboard">
      <i class="fa-solid fa-gauge-high" aria-hidden="true"></i>
      <span>Dashboard</span>
    </a>

    <p class="admin-nav-label">Content</p>
    @if ($user->hasPermission('blogs.view'))
      <a href="{{ route('admin.blogs.index') }}"
        class="admin-nav-link {{ request()->routeIs('admin.blogs.*') ? 'is-active' : '' }}"
        title="Blogs">
        <i class="fa-solid fa-newspaper" aria-hidden="true"></i>
        <span>Blogs</span>
      </a>
    @endif
    @if ($user->hasPermission('conversations.view'))
      <a href="{{ route('admin.conversations.index') }}"
        class="admin-nav-link {{ request()->routeIs('admin.conversations.*') ? 'is-active' : '' }}"
        title="AI Conversations">
        <i class="fa-solid fa-comments" aria-hidden="true"></i>
        <span>AI Conversations</span>
      </a>
    @endif
    @if ($user->hasPermission('contacts.view'))
      <a href="{{ route('admin.contacts.index') }}"
        class="admin-nav-link {{ request()->routeIs('admin.contacts.*') ? 'is-active' : '' }}"
        title="Contact requests">
        <i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i>
        <span>Contacts</span>
      </a>
    @endif

    <p class="admin-nav-label">System</p>
    @if ($user->hasPermission('users.view'))
      <a href="{{ route('admin.users.index') }}"
        class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}"
        title="Users">
        <i class="fa-solid fa-users" aria-hidden="true"></i>
        <span>Users</span>
      </a>
    @endif
    <a href="{{ route('admin.profile.edit') }}"
      class="admin-nav-link {{ request()->routeIs('admin.profile.*') ? 'is-active' : '' }}"
      title="Profile">
      <i class="fa-solid fa-user-gear" aria-hidden="true"></i>
      <span>Profile</span>
    </a>
  </nav>

  <div class="admin-sidebar__footer">
    <div class="admin-user-chip" title="{{ $user->name }}">
      <div class="admin-user-chip__avatar" aria-hidden="true">{{ $initials }}</div>
      <div class="admin-user-chip__meta">
        <strong>{{ $user->name }}</strong>
        <span>{{ $user->email }}</span>
      </div>
    </div>
  </div>
</aside>
