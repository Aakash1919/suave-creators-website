<!DOCTYPE html>
<html lang="{{ str(app()->getLocale())->replace('_', '-') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('seo')
        @yield('seo')
    @else
        <title>{{ config('app.name', 'Suave Creators') }}</title>
        <meta name="description" content="{{ config('app.name', 'Suave Creators') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ["PP Mori", "Roboto Flex", "ui-sans-serif", "system-ui", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    @stack('custom-css')
</head>
@php
    $bodyClass = $bodyClass ?? 'min-h-screen bg-white font-sans text-slate-900';
    $useHeroBackground = $useHeroBackground ?? true;
    $heroBackgroundImage = $heroBackgroundImage ?? 'assets/background/home-hero-cover-bg.png';
    $mainClass = $mainClass ?? 'site-main';
@endphp
<body class="{{ $bodyClass }}">
    <div class="relative w-full overflow-hidden {{ $useHeroBackground ? 'bg-[#00003f]' : 'bg-white' }}">
        @if ($useHeroBackground && $heroBackgroundImage)
            <div class="pointer-events-none absolute inset-0 z-0" aria-hidden="true">
                <img
                    src="{{ asset($heroBackgroundImage) }}"
                    alt="Suave Creators web and software development homepage hero background" title="Suave Creators web and software development homepage hero background"
                    class="absolute inset-0 h-full w-full object-none object-top"
                    width="1920"
                    height="1080"
                    decoding="async"
                    fetchpriority="high"
                >
                @if ($heroBackgroundImage === 'assets/background/home-hero-cover-bg.png' || $heroBackgroundImage === '/assets/background/home-hero-cover-bg.png')
                    <img
                        src="{{ asset('assets/hero/hero-pattern-left.svg') }}"
                        alt="Geometric pattern overlay on Suave Creators software development hero" title="Geometric pattern overlay on Suave Creators software development hero"
                        class="absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-soft-light"
                        width="1920"
                        height="1080"
                        decoding="async"
                    >
                @endif
            </div>
        @endif

        <div class="relative z-10">
            <x-layouts.topbar />
            <x-layouts.header />

            <main class="{{ $mainClass }}">
                @yield('content')
            </main>
        </div>
    </div>

    <x-layouts.footer />
    @stack('scripts')
</body>
</html>
