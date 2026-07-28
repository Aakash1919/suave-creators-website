<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin') — Suave Creators</title>
  <link rel="icon" href="{{ asset('assets/brand/favicon-32.png') }}?v=3" type="image/png" sizes="32x32">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7539FF',
            surface: '#F7F8F9',
            ink: '#051321',
          },
          fontFamily: {
            sans: ['PP Mori', 'Roboto Flex', 'ui-sans-serif', 'system-ui', 'sans-serif'],
          },
        },
      },
    };
  </script>
  @include('layouts.admin.partials.vendor-styles')
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ file_exists(public_path('css/admin.css')) ? filemtime(public_path('css/admin.css')) : 1 }}">
  @include('layouts.admin.partials.toastr')
  @stack('styles')
</head>
<body class="admin-body font-sans">
  @auth
    @php
      $pageTitle = trim($__env->yieldContent('title')) ?: 'Admin';
      $user = Auth::user();
      $initials = collect(preg_split('/\s+/', trim((string) $user->name) ?: 'SC'))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('') ?: 'SC';
    @endphp

    <div class="admin-app" data-admin-app>
      <div class="admin-sidebar-backdrop" data-admin-backdrop aria-hidden="true"></div>

      @include('layouts.admin.partials.sidebar', ['user' => $user, 'initials' => $initials])

      <div class="admin-wrapper">
        @include('layouts.admin.partials.header', [
        'pageTitle' => $pageTitle,
        'user' => $user,
        'initials' => $initials,
      ])

        <main class="admin-content">
          @yield('content')
        </main>
      </div>
    </div>

    @include('layouts.admin.partials.confirm-dialog')
    @include('layouts.admin.partials.scripts')
    @include('layouts.admin.partials.assets')
  @else
    @include('layouts.admin.partials.assets')
    @yield('content')
  @endauth
  @stack('scripts')
</body>
</html>
