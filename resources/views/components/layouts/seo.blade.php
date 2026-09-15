@php
    /** @var array<string, mixed> $seo */
    $og = (array) ($seo['og'] ?? []);
    $twitter = (array) ($seo['twitter'] ?? []);
    $hreflang = (array) ($seo['hreflang'] ?? []);
    $jsonLd = $seo['jsonLd'] ?? null;
    $localeAlternate = array_values(array_filter(
        (array) ($og['locale_alternate'] ?? []),
        static fn (mixed $value): bool => is_string($value) && $value !== ''
    ));
@endphp
<title>{{ $seo['title'] ?? config('app.name', 'Suave Creators') }}</title>
<meta name="description" content="{{ $seo['description'] ?? '' }}">
@if (!empty($seo['keywords']))
    <meta name="keywords" content="{{ $seo['keywords'] }}">
@endif
@if (!empty($seo['author']))
    <meta name="author" content="{{ $seo['author'] }}">
@endif
@if (!empty($seo['robots']))
    <meta name="robots" content="{{ $seo['robots'] }}">
@endif
<link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
@foreach ($hreflang as $locale => $href)
    <link rel="alternate" href="{{ $href }}" hreflang="{{ $locale }}">
@endforeach
<meta property="og:type" content="{{ $og['type'] ?? 'website' }}">
@if (!empty($og['site_name']))
    <meta property="og:site_name" content="{{ $og['site_name'] }}">
@endif
<meta property="og:url" content="{{ $og['url'] ?? ($seo['canonical'] ?? url()->current()) }}">
<meta property="og:title" content="{{ $og['title'] ?? ($seo['title'] ?? '') }}">
<meta property="og:description" content="{{ $og['description'] ?? ($seo['description'] ?? '') }}">
@if (!empty($og['image']))
    <meta property="og:image" content="{{ $og['image'] }}">
    <meta property="og:image:secure_url" content="{{ $og['image_secure_url'] ?? $og['image'] }}">
    <meta property="og:image:type" content="{{ $og['image_type'] ?? 'image/png' }}">
    <meta property="og:image:width" content="{{ $og['image_width'] ?? 1200 }}">
    <meta property="og:image:height" content="{{ $og['image_height'] ?? 630 }}">
    <meta property="og:image:alt" content="{{ $og['image_alt'] ?? ($og['site_name'] ?? '') }}">
@endif
@if (!empty($og['locale']))
    <meta property="og:locale" content="{{ $og['locale'] }}">
@endif
@foreach ($localeAlternate as $locale)
    <meta property="og:locale:alternate" content="{{ $locale }}">
@endforeach
<meta name="twitter:card" content="{{ $twitter['card'] ?? 'summary_large_image' }}">
@if (!empty($twitter['site']))
    <meta name="twitter:site" content="{{ $twitter['site'] }}">
@endif
@if (!empty($twitter['creator']))
    <meta name="twitter:creator" content="{{ $twitter['creator'] }}">
@endif
<meta name="twitter:title" content="{{ $twitter['title'] ?? ($seo['title'] ?? '') }}">
<meta name="twitter:description" content="{{ $twitter['description'] ?? ($seo['description'] ?? '') }}">
@if (!empty($twitter['image']))
    <meta name="twitter:image" content="{{ $twitter['image'] }}">
@endif
@if (!empty($twitter['image_alt']))
    <meta name="twitter:image:alt" content="{{ $twitter['image_alt'] }}">
@endif
@if (!empty($jsonLd))
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
@endif
