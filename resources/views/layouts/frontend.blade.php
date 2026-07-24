<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO slot: title, meta description, og tags, canonical, etc. --}}
    @hasSection('seo')
        @yield('seo')
    @else
        <title>{{ config('app.name', 'Suave Creators') }}</title>
        <meta name="description" content="{{ config('app.name', 'Suave Creators') }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page-specific styles --}}
    @stack('custom-css')
</head>
<body class="min-h-screen flex flex-col bg-white text-gray-900 antialiased">

    @include('layouts.includes.header')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('layouts.includes.footer')

    {{-- Page-specific scripts --}}
    @stack('custom-js')
</body>
</html>
