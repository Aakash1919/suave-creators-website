@php
    /** @var array<string, mixed> $seo */
    $og = (array) ($seo['og'] ?? []);
    $twitter = (array) ($seo['twitter'] ?? []);
    $hreflang = (array) ($seo['hreflang'] ?? []);
    $jsonLd = $seo['jsonLd'] ?? null;
@endphp
<title>{{ $seo['title'] ?? config('app.name', 'Suave Creators') }}</title>
<meta name="description" content="{{ $seo['description'] ?? '' }}">
@if (!empty($seo['robots']))
    <meta name="robots" content="{{ $seo['robots'] }}">
@endif
<link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
<meta property="og:title" content="{{ $og['title'] ?? ($seo['title'] ?? '') }}">
<meta property="og:description" content="{{ $og['description'] ?? ($seo['description'] ?? '') }}">
<meta property="og:type" content="{{ $og['type'] ?? 'website' }}">
<meta property="og:url" content="{{ $og['url'] ?? ($seo['canonical'] ?? url()->current()) }}">
@if (!empty($og['site_name']))
    <meta property="og:site_name" content="{{ $og['site_name'] }}">
@endif
@if (!empty($og['image']))
    <meta property="og:image" content="{{ $og['image'] }}">
    <meta property="og:image:width" content="{{ $og['image_width'] ?? 1200 }}">
    <meta property="og:image:height" content="{{ $og['image_height'] ?? 630 }}">
    <meta property="og:image:alt" content="{{ $og['image_alt'] ?? ($og['site_name'] ?? '') }}">
@endif
<meta name="twitter:card" content="{{ $twitter['card'] ?? 'summary_large_image' }}">
<meta name="twitter:title" content="{{ $twitter['title'] ?? ($seo['title'] ?? '') }}">
<meta name="twitter:description" content="{{ $twitter['description'] ?? ($seo['description'] ?? '') }}">
@if (!empty($twitter['image']))
    <meta name="twitter:image" content="{{ $twitter['image'] }}">
@endif
@foreach ($hreflang as $locale => $href)
    <link rel="alternate" href="{{ $href }}" hreflang="{{ $locale }}">
@endforeach
@if (!empty($jsonLd))
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
@endif
