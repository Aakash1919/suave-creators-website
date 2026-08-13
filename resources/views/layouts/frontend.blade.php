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

    @php
        $googleAnalyticsId = config('seo.site.google_analytics_id');
        $googleTagManagerId = config('seo.site.google_tag_manager_id');
    @endphp
    @if ($googleAnalyticsId || $googleTagManagerId)
        {{-- Queue analytics commands early; gtag.js / gtm.js load after idle or first interaction. --}}
        <script>
            window.dataLayer = window.dataLayer || [];
            window.gtag = window.gtag || function () { window.dataLayer.push(arguments); };
            @if ($googleAnalyticsId)
            gtag('js', new Date());
            gtag('config', @json($googleAnalyticsId));
            @endif
        </script>
    @endif

    @if ($withSeo ?? true)
        <x-layouts.seo :seo="$seo ?? []" />
    @endif

    {{-- Warm CDN origins early; full CSS loads non-blocking (media=print → all). --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @php
        $styleCssHref = asset('css/style.css').'?v='.filemtime(public_path('css/style.css'));
        $deferredCssHref = asset('css/style-deferred.css').'?v='.filemtime(public_path('css/style-deferred.css'));
        $faSubsetHref = asset('css/fontawesome-subset.css').'?v='.filemtime(public_path('css/fontawesome-subset.css'));
        $loadDeferredCss = request()->routeIs(
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
        $bodyClass = $bodyClass ?? 'min-h-screen bg-white font-sans text-slate-900';
        $useHeroBackground = $useHeroBackground ?? true;
        $heroBackgroundImage = $heroBackgroundImage ?? 'assets/background/home-hero-cover-bg.png';
        $heroShellClass = $heroShellClass ?? ($useHeroBackground ? 'bg-[#00003f]' : 'bg-white');
        $mainClass = $mainClass ?? 'site-main';
        $usesHomeHeroPattern = $useHeroBackground && in_array($heroBackgroundImage, [
            'assets/background/home-hero-cover-bg.png',
            '/assets/background/home-hero-cover-bg.png',
        ], true);
    @endphp

    {{-- Critical first-paint / LCP shell only; full sheets deferred below. --}}
    <style>
        :root{--color-navy:#00003f}
        html{overflow-x:clip}
        body{margin:0;overflow-x:clip;background:#fff;color:#0f172a}
        .bg-\[\#00003f\]{background-color:var(--color-navy)}
        .relative{position:relative}
        .w-full{width:100%}
        .overflow-hidden{overflow:hidden}
        .z-10{position:relative;z-index:10}
        .site-hero-bg{background-color:var(--color-navy);height:min(100%,920px);inset-inline:0;overflow:hidden;pointer-events:none;position:absolute;top:0;z-index:0}
        .site-hero-bg__image{height:100%;left:50%;max-width:none;object-fit:cover;object-position:top center;position:absolute;top:0;transform:translateX(-50%);width:max(100%,1920px)}
        .site-hero-bg__pattern{height:100%;inset:0;mix-blend-mode:soft-light;object-fit:cover;object-position:top center;opacity:.2;position:absolute;width:100%}
    </style>

    @if ($useHeroBackground && $heroBackgroundImage)
        <link rel="preload" as="image" href="{{ asset($heroBackgroundImage) }}" @unless($usesHomeHeroPattern) fetchpriority="high" @endunless>
    @endif
    @if ($usesHomeHeroPattern)
        <link rel="preload" as="image" href="{{ asset('assets/hero/hero-pattern-left.svg') }}" fetchpriority="high">
    @endif

    {{-- Non-blocking stylesheets: fetch immediately, apply after load (not on critical path). --}}
    <link rel="stylesheet" href="{{ $styleCssHref }}" media="print" onload="this.media='all'">
    @php
        // Keep Vite HMR CSS blocking in `npm run dev`; defer the built stylesheet for audits/prod.
        $viteCssHot = file_exists(public_path('hot'));
        if (! $viteCssHot) {
            Illuminate\Support\Facades\Vite::useStyleTagAttributes([
                'media' => 'print',
                'onload' => "this.media='all'",
            ]);
        }
    @endphp
    @vite('resources/css/app.css')
    {{-- FA glyph classes only; webfonts inject via frontend-deferred.js after first paint. --}}
    <link rel="stylesheet" href="{{ $faSubsetHref }}" media="print" onload="this.media='all'">
    @if ($loadDeferredCss)
        <link rel="stylesheet" href="{{ $deferredCssHref }}" media="print" onload="this.media='all'">
    @endif
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Pragati+Narrow:wght@400;700&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ $styleCssHref }}">
        @unless ($viteCssHot)
            <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
        @endunless
        <link rel="stylesheet" href="{{ $faSubsetHref }}">
        <link rel="stylesheet" href="{{ asset('css/pp-mori.css') }}?v={{ filemtime(public_path('css/pp-mori.css')) }}">
        <link rel="stylesheet" href="{{ asset('css/fontawesome-extra.css') }}?v={{ filemtime(public_path('css/fontawesome-extra.css')) }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pragati+Narrow:wght@400;700&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        @if ($loadDeferredCss)
            <link rel="stylesheet" href="{{ $deferredCssHref }}">
        @endif
    </noscript>

    @stack('custom-css')
</head>
<body class="{{ $bodyClass }}">
    @if ($googleTagManagerId)
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
                    loading="eager"
                    decoding="async"
                    @unless($usesHomeHeroPattern) fetchpriority="high" @endunless
                >
                @if ($usesHomeHeroPattern)
                    <img
                        src="{{ asset('assets/hero/hero-pattern-left.svg') }}"
                        alt="Geometric pattern overlay on Suave Creators software development hero" title="Geometric pattern overlay on Suave Creators software development hero"
                        class="site-hero-bg__pattern"
                        width="1920"
                        height="1080"
                        loading="eager"
                        decoding="async"
                        fetchpriority="high"
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
    {{-- Defer GTM/gtag + fonts + Swiper; stub queues carousel inits until deferred.js runs. --}}
    @php
        $ppMoriCssHref = asset('css/pp-mori.css').'?v='.filemtime(public_path('css/pp-mori.css'));
        $faExtraCssHref = asset('css/fontawesome-extra.css').'?v='.filemtime(public_path('css/fontawesome-extra.css'));
        $deferredJsHref = asset('js/frontend-deferred.js').'?v='.filemtime(public_path('js/frontend-deferred.js'));
    @endphp
    <script>
        window.__suavePerf = {
            gaId: @json($googleAnalyticsId),
            gtmId: @json($googleTagManagerId),
            swiperJs: 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            swiperCss: 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            ppMoriCss: @json($ppMoriCssHref),
            faExtraCss: @json($faExtraCssHref)
        };
        window.__suaveSwiperQ = window.__suaveSwiperQ || [];
        window.suaveWhenSwiperReady = window.suaveWhenSwiperReady || function (fn) {
            if (typeof fn === 'function') {
                window.__suaveSwiperQ.push(fn);
            }
        };
    </script>
    <script defer src="{{ $deferredJsHref }}"></script>
    @stack('scripts')
</body>
</html>
