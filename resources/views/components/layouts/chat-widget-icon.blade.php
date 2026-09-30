<img
    {{ $attributes->merge(['class' => 'chat-widget-icon']) }}
    src="{{ asset($resolvedSrc) }}?v={{ $version }}"
    alt="{{ $alt }}"
    title="{{ $alt }}"
    width="{{ $width }}"
    height="{{ $height }}"
    decoding="async"
>
