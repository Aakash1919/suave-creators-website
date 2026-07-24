<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO slot: title, meta description, og tags, canonical, etc. --}}
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

    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    {{-- Shared layout styles for header, footer, and site chrome are in style.css --}}

    {{-- Page-specific styles --}}
    @stack('custom-css')
</head>
@php
    // Pages may override these via view data (e.g. from a controller).
    $bodyClass = $bodyClass ?? 'min-h-screen bg-white font-sans text-slate-900';
    $useHeroBackground = $useHeroBackground ?? true;
    $heroBackgroundImage = $heroBackgroundImage ?? '/images/cover_banner.png';
    $mainClass = $mainClass ?? 'site-main';
@endphp
<body class="{{ $bodyClass }}">
    <div class="relative w-full overflow-hidden {{ $useHeroBackground ? 'bg-[#00003f]' : 'bg-white' }}">
        @if ($useHeroBackground && $heroBackgroundImage)
            <div class="pointer-events-none absolute inset-0 z-0" aria-hidden="true">
                <img src="{{ $heroBackgroundImage }}" alt="" class="absolute inset-0 h-full w-full object-none object-top">
                @if ($heroBackgroundImage === '/images/cover_banner.png')
                    <img src="/images/hero_Pattern(left).svg" alt="" class="absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-soft-light">
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
</body>
</html>
