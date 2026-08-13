<!DOCTYPE html>
<html lang="{{ str(app()->getLocale())->replace('_', '-') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/brand/favicon-32.png') }}?v=3" type="image/png" sizes="32x32">
    <link rel="icon" href="{{ asset('assets/brand/favicon-16.png') }}?v=3" type="image/png" sizes="16x16">
    <link rel="icon" href="{{ asset('assets/brand/favicon-192.png') }}?v=3" type="image/png" sizes="192x192">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('assets/brand/favicon-192.png') }}?v=3" sizes="192x192">

    @if ($googleSiteVerification = config('seo.site.google_site_verification'))
        <meta name="google-site-verification" content="{{ $googleSiteVerification }}">
    @endif

    @if ($googleAnalyticsId = config('seo.site.google_analytics_id'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', @json($googleAnalyticsId));
        </script>
    @endif

    @if ($googleTagManagerId = config('seo.site.google_tag_manager_id'))
        <!-- Google Tag Manager -->
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer',@json($googleTagManagerId));
        </script>
        <!-- End Google Tag Manager -->
    @endif

    @if ($withSeo ?? true)
        <x-layouts.seo :seo="$seo ?? []" />
    @endif

    {{-- Warm CDN origins early; Tailwind via Vite build + site CSS on the critical path. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    {{-- Core site CSS (shared layout + homepage sections). --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">

    @php
        $deferredCssHref = asset('css/style-deferred.css').'?v='.filemtime(public_path('css/style-deferred.css'));
        $loadDeferredCssSync = request()->routeIs(
            'about-us',
            'product',
            'blogs',
            'blogs.category',
            'blog.show',
            'contact-us',
            'privacy-policy',
            'terms-and-conditions',
            'services',
            'service.show',
            'industries',
            'industry.show',
        );
    @endphp

    @if ($loadDeferredCssSync)
        <link rel="stylesheet" href="{{ $deferredCssHref }}">
    @else
        {{-- Page-specific CSS deferred on the homepage to reduce unused CSS bytes. --}}
        <link rel="preload" as="style" href="{{ $deferredCssHref }}" onload="this.onload=null;this.rel='stylesheet'">
    @endif

@vite('resources/css/app.css')

    {{-- Non-critical CSS: preload so it does not block first paint / LCP. --}}
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Pragati+Narrow:wght@400;700&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    {{-- Font Awesome: core + used weights only (skip all.min.css icon catalog). --}}
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/regular.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pragati+Narrow:wght@400;700&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/regular.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        @unless ($loadDeferredCssSync)
            <link rel="stylesheet" href="{{ $deferredCssHref }}">
        @endunless
    </noscript>

    @stack('custom-css')
</head>
@php
    $bodyClass = $bodyClass ?? 'min-h-screen bg-white font-sans text-slate-900';
    $useHeroBackground = $useHeroBackground ?? true;
    $heroBackgroundImage = $heroBackgroundImage ?? 'assets/background/home-hero-cover-bg.png';
    $heroShellClass = $heroShellClass ?? ($useHeroBackground ? 'bg-[#00003f]' : 'bg-white');
    $mainClass = $mainClass ?? 'site-main';
@endphp
<body class="{{ $bodyClass }}">
    @if ($googleTagManagerId = config('seo.site.google_tag_manager_id'))
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{ $googleTagManagerId }}" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
    <div class="relative w-full overflow-hidden {{ $heroShellClass }}">
        @if ($useHeroBackground && $heroBackgroundImage)
            <div class="site-hero-bg" aria-hidden="true">
                <img
                    src="{{ asset($heroBackgroundImage) }}"
                    alt="Suave Creators web and software development homepage hero background" title="Suave Creators web and software development homepage hero background"
                    class="site-hero-bg__image"
                    width="1920"
                    height="1080"
                    decoding="async"
                    fetchpriority="high"
                >
                @if ($heroBackgroundImage === 'assets/background/home-hero-cover-bg.png' || $heroBackgroundImage === '/assets/background/home-hero-cover-bg.png')
                    <img
                        src="{{ asset('assets/hero/hero-pattern-left.svg') }}"
                        alt="Geometric pattern overlay on Suave Creators software development hero" title="Geometric pattern overlay on Suave Creators software development hero"
                        class="site-hero-bg__pattern"
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
    <x-layouts.analytics-events />
    {{-- Swiper is below-fold on marketing pages; defer so it is not render-blocking. Inits wait on DOMContentLoaded. --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    @stack('scripts')
</body>
</html>
