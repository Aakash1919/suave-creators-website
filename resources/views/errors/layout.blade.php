<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
  <title>@yield('title', 'Error') — Suave Creators</title>
  <link rel="icon" href="{{ asset('assets/brand/favicon-32.png') }}?v=3" type="image/png" sizes="32x32">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ file_exists(public_path('css/admin.css')) ? filemtime(public_path('css/admin.css')) : 1 }}">
</head>
<body class="admin-body font-sans">
  <div class="admin-error-page">
    <div class="admin-error-page__inner">
      <div class="admin-error-page__art">
        @yield('art')
      </div>

      <h1 class="admin-error-page__title">Oops, something went wrong</h1>
      <p class="admin-error-page__copy">@yield('message')</p>

      <div class="admin-error-page__actions">
        @auth
          <a href="{{ route('admin.dashboard') }}" class="admin-btn admin-btn--primary">
            Back to Dashboard
          </a>
        @else
          <a href="{{ url('/') }}" class="admin-btn admin-btn--primary">
            Back to Home
          </a>
        @endauth
      </div>
    </div>
  </div>
</body>
</html>
