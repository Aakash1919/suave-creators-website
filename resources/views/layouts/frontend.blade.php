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
        // Keep Vite HMR CSS blocking in `npm run dev`; defer the built stylesheet for audits/prod.
        $viteCssHot = file_exists(public_path('hot'));
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
            'case-studies',
            'case-study.show',
            '*-case-study',
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

    {{-- Critical first-paint / CLS shell; full sheets stay non-blocking below. --}}
    <style>
        :root{--color-navy:#00003f;--site-container-width:1280px;--site-gutter:20px;--site-font:"Roboto Flex",ui-sans-serif,system-ui,sans-serif}
        @font-face{font-family:"Font Awesome 6 Free";font-style:normal;font-weight:900;font-display:optional;src:url("{{ asset('fonts/fontawesome/fa-solid-900.woff2') }}") format("woff2")}
        html{overflow-x:clip}
        body{margin:0;overflow-x:clip;background:#fff;color:#0f172a;font-family:var(--site-font)}
        .bg-\[\#00003f\]{background-color:var(--color-navy)}
        .relative{position:relative}
        .w-full{width:100%}
        .overflow-hidden{overflow:hidden}
        .z-10{position:relative;z-index:10}
        .z-20{position:relative;z-index:20}
        .flex{display:flex}
        .inline-flex{display:inline-flex}
        .inline-block{display:inline-block}
        .grid{display:grid}
        .hidden{display:none}
        .items-center{align-items:center}
        .justify-between{justify-content:space-between}
        .justify-center{justify-content:center}
        .justify-end{justify-content:flex-end}
        .justify-self-end{justify-self:end}
        .shrink-0,.flex-shrink-0{flex-shrink:0}
        .min-w-0{min-width:0}
        .flex-col{flex-direction:column}
        .gap-1\.5{gap:.375rem}
        .gap-2{gap:.5rem}
        .gap-3{gap:.75rem}
        .gap-4{gap:1rem}
        .gap-10{gap:2.5rem}
        .m-0{margin:0}
        .mb-2{margin-bottom:.5rem}
        .mt-2{margin-top:.5rem}
        .mt-8{margin-top:2rem}
        .py-1{padding-block:.25rem}
        .text-left{text-align:left}
        .whitespace-nowrap{white-space:nowrap}
        .fa,.fa-solid,.fas{display:inline-block;flex-shrink:0;height:1em;line-height:1;text-align:center;width:1em}
        .site-container{box-sizing:border-box;margin-inline:auto;max-width:calc(var(--site-container-width) + (var(--site-gutter) * 2));padding-inline:var(--site-gutter);width:100%}
        .site-main{display:grid;grid-template-columns:[full-start] minmax(var(--site-gutter),1fr) [content-start] minmax(0,var(--site-container-width)) [content-end] minmax(var(--site-gutter),1fr) [full-end];min-width:0}
        .site-main>*{grid-column:content;min-width:0}
        .site-main .site-container{max-width:var(--site-container-width);padding-inline:0}
        .site-topbar{background:#010062;box-sizing:border-box;min-height:2rem}
        .site-topbar>.site-container{align-items:center;display:grid;gap:.375rem;grid-template-columns:1fr auto 1fr}
        .site-topbar img{height:.75rem;width:.75rem}
        .site-topbar__dismiss{align-items:center;display:inline-flex;height:1.75rem;justify-content:center;min-height:28px;min-width:28px;width:1.75rem}
        .site-topbar__chevron{display:block;height:10px;width:10px}
        .site-header{box-sizing:border-box;min-height:3.75rem;padding-block:.75rem;position:-webkit-sticky;position:sticky;top:0;width:100%;z-index:11000}
        .site-header>.site-container{align-items:center;display:flex;gap:.75rem;justify-content:space-between}
        .site-header__logo img{aspect-ratio:220/99;display:block;height:2.25rem;object-fit:contain;width:auto}
        .site-header__logo-emblem[data-the-suave-emblem],.site-header__logo-emblem{aspect-ratio:1/1;display:block;flex-shrink:0;height:3rem;line-height:0;overflow:hidden;position:relative;width:3rem}
        .site-header__logo-emblem img{height:100%;left:50%;max-width:none;object-fit:contain;position:absolute;top:50%;transform:translate(-50%,-50%);width:100%}
        .site-header__menu-btn{align-items:center;display:inline-flex;height:2.75rem;justify-content:center;width:2.75rem}
        .site-header__cta{display:none}
        .mobile-nav[hidden]{display:none!important}
        .floating-chat{bottom:24px;height:64px;position:fixed;right:24px;width:64px;z-index:9999}
        .site-hero-bg{background-color:var(--color-navy);height:min(100%,920px);inset-inline:0;overflow:hidden;pointer-events:none;position:absolute;top:0;z-index:0}
        .site-hero-bg__image{height:100%;left:50%;max-width:none;object-fit:cover;object-position:top center;position:absolute;top:0;transform:translateX(-50%);width:max(100%,1920px)}
        .site-hero-bg__pattern{height:100%;inset:0;mix-blend-mode:soft-light;object-fit:cover;object-position:top center;opacity:.2;position:absolute;width:100%}
        /* Reserve hero shell so deferred Tailwind/style.css cannot shove site-main. */
        .site-main>.site-container.relative{box-sizing:border-box;min-height:36rem;padding-bottom:3rem;padding-top:2rem}
        .site-main>.single-blog-top{min-height:0;padding-bottom:.75rem;padding-top:.25rem}
        .site-main>.site-container.relative>.grid{align-items:center;display:grid;gap:2.5rem;grid-template-columns:minmax(0,1fr)}
        .site-main>.site-container.relative>.grid>div:first-child{max-width:36rem;min-height:17rem}
        .pragati-narrow-regular{font-family:"Pragati Narrow",ui-sans-serif,system-ui,sans-serif}
        .site-main>.site-container.relative h1{color:#fff;display:flex;flex-direction:column;font-size:36px;font-weight:600;line-height:1;margin:.5rem 0}
        .site-main>.single-blog-top h1{display:block;font-size:clamp(1.75rem,4vw,2.75rem);line-height:1.2;margin:.625rem 0 0}
        .site-main>.site-container.relative h1+p{color:#b1b9df;font-size:12px;line-height:1.25rem;margin:.5rem 0}
        .hero-media-grid{aspect-ratio:670/512;column-gap:calc(12 / 670 * 100%);display:grid;flex-shrink:0;grid-template-columns:314fr 344fr;grid-template-rows:124fr 368fr;max-width:670px;row-gap:calc(20 / 512 * 100%);width:100%}
        .hero-media-grid__tile{border-radius:22px;height:100%;min-height:0;min-width:0;overflow:hidden;width:100%}
        .hero-media-grid__tile:nth-child(1){grid-column:1;grid-row:1 / span 2}
        .hero-media-grid__tile:nth-child(2){grid-column:2;grid-row:1}
        .hero-media-grid__tile:nth-child(3){grid-column:2;grid-row:2}
        .hero-media-grid__tile img{display:block;height:100%;max-width:none;object-fit:cover;width:100%}
        .about-stat__icon{display:inline-flex;flex-shrink:0;height:40px;width:40px}
        .about-stat__icon-image{aspect-ratio:1/1;display:block;height:40px;width:40px}
        .about-stat__value [data-counter-end]{display:inline-block;font-variant-numeric:tabular-nums}
        
        /* Preloader hides the unstyled shell while the non-blocking sheets are still fetching. */
        .site-preloader {
            align-items: center;
            background: #00003f url('{{ asset('assets/background/loader_bg.webp') }}') center / cover no-repeat;
            display: flex;
            inset: 0;
            justify-content: center;
            position: fixed;
            z-index: 2147483000;
        }

        .site-preloader__spinner {
            background: url('{{ asset('assets/background/loading_gif.gif') }}') center / contain no-repeat;
            box-sizing: border-box;
            display: block;
            height: 44px;
            width: 44px;
            inline-size: 44px;
            block-size: 44px;
            opacity: 1;
        }

        html.is-css-ready .site-preloader {
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease, visibility 0s linear .3s;
            visibility: hidden;
        }
        @media (min-width:375px){
            .site-main>.site-container.relative h1{font-size:42px}
        }
        @media (min-width:640px){
            .site-topbar{min-height:2.25rem}
            .site-topbar img{height:.875rem;width:.875rem}
            .site-topbar__chevron{height:12px;width:12px}
            .site-header__logo img{height:2.5rem}
            .site-main>.site-container.relative{min-height:38rem}
            .site-main>.single-blog-top{min-height:0}
            .site-main>.site-container.relative h1{font-size:3rem}
            .site-main>.single-blog-top h1{font-size:clamp(1.75rem,4vw,2.75rem)}
            .sm\:gap-2{gap:.5rem}
            .sm\:gap-4{gap:1rem}
            .sm\:gap-7{gap:1.75rem}
            .sm\:py-1\.5{padding-block:.375rem}
        }
        @media (min-width:768px){
            .site-header__cta{display:inline-flex;align-items:center}
            .site-main>.site-container.relative{min-height:440px;padding-bottom:4rem;padding-top:2.5rem}
            .site-main>.single-blog-top{min-height:0;padding-bottom:1rem;padding-top:.5rem}
            .site-main>.site-container.relative>.grid>div:first-child{min-height:18rem}
            .site-main>.site-container.relative h1+p{font-size:.875rem;line-height:1.5rem}
        }
        @media (min-width:1024px){
            .site-main>.site-container.relative{min-height:640px;padding-bottom:5rem;padding-top:52px}
            .site-main>.single-blog-top{min-height:0;padding-bottom:1.5rem;padding-top:.75rem}
            .site-main>.site-container.relative>.grid{gap:3rem;grid-template-columns:repeat(2,minmax(0,1fr))}
            .site-main>.site-container.relative>.grid>div:first-child{max-width:520px;min-height:22rem}
            .site-main>.site-container.relative h1{font-size:60px}
            .site-main>.single-blog-top h1{font-size:clamp(1.75rem,4vw,2.75rem)}
            .lg\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}
            .lg\:justify-end{justify-content:flex-end}
            .lg\:max-w-\[520px\]{max-width:520px}
        }
        @media (min-width:1280px){
            .xl\:flex{display:flex}
            .site-header__menu-btn{display:none}
        }
    </style>

    <link rel="preload" as="image" href="{{ asset('assets/background/loader_bg.webp') }}" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset('assets/background/loading_gif.gif') }}" fetchpriority="high">
    <link rel="preload" as="font" href="{{ asset('fonts/fontawesome/fa-solid-900.woff2') }}" type="font/woff2" crossorigin>

    @if ($useHeroBackground && $heroBackgroundImage)
        <link rel="preload" as="image" href="{{ asset($heroBackgroundImage) }}" @unless($usesHomeHeroPattern) fetchpriority="high" @endunless>
    @endif
    @if ($usesHomeHeroPattern)
        <link rel="preload" as="image" href="{{ asset('assets/hero/hero-pattern-left.svg') }}">
        {{-- Home LCP collage tile — discoverable early; must not be lazy-loaded. --}}
        <link
            rel="preload"
            as="image"
            href="{{ asset('assets/hero/hero-team-brainstorm-overhead-480.webp') }}"
            imagesrcset="{{ asset('assets/hero/hero-team-brainstorm-overhead-320.webp') }} 320w, {{ asset('assets/hero/hero-team-brainstorm-overhead-480.webp') }} 480w, {{ asset('assets/hero/hero-team-brainstorm-overhead.webp') }} 628w"
            imagesizes="(min-width: 1024px) 314px, (min-width: 768px) 262px, 47vw"
            fetchpriority="high"
        >
    @endif

    {{-- media="print" sheets download at low priority; preload keeps the design CSS on a high-priority fetch. --}}
    {{-- @vite already emits its own preload for the built stylesheet. --}}
    <link rel="preload" as="style" href="{{ $styleCssHref }}">
    @if ($loadDeferredCss)
        <link rel="preload" as="style" href="{{ $deferredCssHref }}">
    @endif

    {{-- Non-blocking stylesheets: fetch immediately, apply after load (not on critical path). --}}
    {{-- data-suave-css marks the sheets the preloader waits for before revealing the page. --}}
    <link rel="stylesheet" href="{{ $styleCssHref }}" media="print" onload="this.media='all'" data-suave-css>
    @php
        if (! $viteCssHot) {
            Illuminate\Support\Facades\Vite::useStyleTagAttributes([
                'media' => 'print',
                'onload' => "this.media='all'",
                'data-suave-css' => true,
            ]);
        }
    @endphp
    @vite('resources/css/app.css')
    {{-- FA glyph classes only; webfonts inject via frontend-deferred.js after first paint. --}}
    <link rel="stylesheet" href="{{ $faSubsetHref }}" media="print" onload="this.media='all'">
    @if ($loadDeferredCss)
        <link rel="stylesheet" href="{{ $deferredCssHref }}" media="print" onload="this.media='all'" data-suave-css>
    @endif
    {{-- display=optional avoids late font swaps that inflate CLS; cached visits still get the face. --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pragati+Narrow:wght@400;700&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=optional" media="print" onload="this.media='all'">
    <noscript>
        {{-- Without JS these sheets are render-blocking, so there is nothing for the preloader to wait on. --}}
        <style>.site-preloader{display:none}</style>
        <link rel="stylesheet" href="{{ $styleCssHref }}">
        @unless ($viteCssHot)
            <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
        @endunless
        <link rel="stylesheet" href="{{ $faSubsetHref }}">
        <link rel="stylesheet" href="{{ asset('css/pp-mori.css') }}?v={{ filemtime(public_path('css/pp-mori.css')) }}">
        <link rel="stylesheet" href="{{ asset('css/fontawesome-extra.css') }}?v={{ filemtime(public_path('css/fontawesome-extra.css')) }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pragati+Narrow:wght@400;700&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=optional">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        @if ($loadDeferredCss)
            <link rel="stylesheet" href="{{ $deferredCssHref }}">
        @endif
    </noscript>

    @stack('custom-css')
</head>
<body class="{{ $bodyClass }}">
    <x-layouts.site-preloader />
    @if ($googleTagManagerId)
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{ $googleTagManagerId }}" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
    <div class="relative w-full {{ $heroShellClass }}">
        @if ($useHeroBackground && $heroBackgroundImage)
            <div class="site-hero-bg" aria-hidden="true">
                <img
                    src="{{ asset($heroBackgroundImage) }}"
                    alt="Suave Creators web and software development homepage hero background" title="Suave Creators web and software development homepage hero background"
                    class="site-hero-bg__image"
                    width="1920"
                    height="700"
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
                        height="700"
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
    {{-- Body-level so position:fixed is not captured by footer overflow-x:clip / content-visibility. --}}
    <x-layouts.suave-agent />
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
