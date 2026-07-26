<img
    {{ $attributes->merge(['class' => $imgClass]) }}
    src="{{ asset($resolvedSrc) }}"
    alt="{{ $alt }}" title="{{ $alt }}"
    width="180"
    height="48"
    decoding="async"
>
