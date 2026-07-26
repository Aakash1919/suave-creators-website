<a
    href="{{ url($href) }}"
    {{ $attributes->merge(['class' => 'floating-chat']) }}
    aria-label="{{ $ariaLabel }}"
>
    <img
        src="{{ asset($icon) }}"
        alt="{{ $alt }}" title="{{ $alt }}"
        width="56"
        height="56"
        decoding="async"
        @if ($alt === '') aria-hidden="true" @endif
    >
</a>
