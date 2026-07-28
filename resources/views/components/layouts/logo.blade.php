<img
    {{ $attributes->merge(['class' => $imgClass]) }}
    src="{{ asset($resolvedSrc) }}"
    alt="{{ $alt }}" title="{{ $alt }}"
    width="220"
    height="99"
    decoding="async"
>
