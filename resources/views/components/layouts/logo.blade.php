<img
    {{ $attributes->merge(['class' => $imgClass]) }}
    src="{{ asset($resolvedSrc) }}"
    @if ($useResponsiveLogo)
        srcset="{{ asset('assets/brand/logo-white-220.webp') }} 220w, {{ asset('assets/brand/logo-white.webp') }} 440w"
        sizes="{{ $sizes }}"
    @endif
    alt="{{ $alt }}" title="{{ $alt }}"
    width="220"
    height="99"
    decoding="async"
>
