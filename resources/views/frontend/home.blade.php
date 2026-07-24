@extends('layouts.frontend')

@section('seo')
    <title>Home | {{ config('app.name', 'Suave Creators') }}</title>
    <meta name="description" content="Welcome to Suave Creators — crafting beautiful digital experiences.">
    <meta property="og:title" content="Home | {{ config('app.name', 'Suave Creators') }}">
    <meta property="og:description" content="Welcome to Suave Creators — crafting beautiful digital experiences.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@push('custom-css')
    <style>
        /* Page-specific styles go here */
    </style>
@endpush

@section('content')
    <section class="mx-auto flex max-w-7xl flex-col items-center px-4 py-24 text-center sm:px-6 lg:px-8">
        <h1 class="max-w-3xl text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
            Welcome to {{ config('app.name', 'Suave Creators') }}
        </h1>
        <p class="mt-6 max-w-2xl text-lg text-gray-600">
            Laravel {{ app()->version() }} with Tailwind CSS and Blade is up and running.
            This page uses the <code class="rounded bg-gray-100 px-1.5 py-0.5 text-sm">layouts.frontend</code>
            layout with header and footer includes.
        </p>
        <div class="mt-10 flex items-center gap-4">
            <a href="#" class="rounded-lg bg-gray-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-700">
                Get Started
            </a>
            <a href="https://laravel.com/docs" target="_blank" rel="noopener"
               class="rounded-lg border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                Documentation
            </a>
        </div>
    </section>
@endsection

@push('custom-js')
    <script>
        // Page-specific scripts go here
    </script>
@endpush
