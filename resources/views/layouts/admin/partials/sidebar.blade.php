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
      <img src="{{ asset('assets/brand/logo.png') }}" alt="Suave Creators" title="Suave Creators">
    </a>
  </div>

  <nav class="admin-sidebar__nav" aria-label="Admin">
    <p class="admin-nav-label">Main menu</p>
    <a href="{{ route('admin.dashboard') }}"
      class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
      title="Dashboard">
      <i class="fa-solid fa-gauge-high" aria-hidden="true"></i>
      <span>Dashboard</span>
    </a>

    @if ($user->hasPermission('blogs.view') || $user->hasPermission('blog-categories.view'))
      <p class="admin-nav-label">Blog</p>
      @if ($user->hasPermission('blog-categories.view'))
        <a href="{{ route('admin.blog-categories.index') }}"
          class="admin-nav-link {{ request()->routeIs('admin.blog-categories.*') ? 'is-active' : '' }}"
          title="Categories">
          <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
          <span>Categories</span>
        </a>
      @endif
      @if ($user->hasPermission('blogs.view'))
        <a href="{{ route('admin.blogs.index') }}"
          class="admin-nav-link {{ request()->routeIs('admin.blogs.*') ? 'is-active' : '' }}"
          title="Posts">
          <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
          <span>Posts</span>
        </a>
      @endif
    @endif
    @if ($user->hasPermission('conversations.view') || $user->hasPermission('contacts.view'))
      <p class="admin-nav-label">Inbox</p>
      @if ($user->hasPermission('conversations.view'))
        <a href="{{ route('admin.conversations.index') }}"
          class="admin-nav-link {{ request()->routeIs('admin.conversations.*') ? 'is-active' : '' }}"
          title="AI conversations">
          <i class="fa-solid fa-comments" aria-hidden="true"></i>
          <span>AI</span>
        </a>
      @endif
      @if ($user->hasPermission('contacts.view'))
        <a href="{{ route('admin.contacts.index') }}"
          class="admin-nav-link {{ request()->routeIs('admin.contacts.*') ? 'is-active' : '' }}"
          title="Contact requests">
          <i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i>
          <span>Contact requests</span>
        </a>
      @endif
    @endif
    @if ($user->hasPermission('testimonials.view'))
      <p class="admin-nav-label">General</p>
      <a href="{{ route('admin.testimonials.index') }}"
        class="admin-nav-link {{ request()->routeIs('admin.testimonials.*') ? 'is-active' : '' }}"
        title="Testimonials">
        <i class="fa-solid fa-quote-left" aria-hidden="true"></i>
        <span>Testimonials</span>
      </a>
    @endif

    @if ($user->hasPermission('users.view') || $user->hasPermission('roles.view'))
    <p class="admin-nav-label">System</p>
    @if ($user->hasPermission('users.view'))
      <a href="{{ route('admin.users.index') }}"
        class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}"
        title="Users">
        <i class="fa-solid fa-users" aria-hidden="true"></i>
        <span>Users</span>
      </a>
    @endif
    @if ($user->hasPermission('roles.view'))
      <a href="{{ route('admin.roles.index') }}"
        class="admin-nav-link {{ request()->routeIs('admin.roles.*') ? 'is-active' : '' }}"
        title="Roles">
        <i class="fa-solid fa-user-shield" aria-hidden="true"></i>
        <span>Roles</span>
      </a>
    @endif
    @endif
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
