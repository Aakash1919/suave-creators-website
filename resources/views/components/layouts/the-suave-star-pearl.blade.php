<span
    {{ $attributes
        ->class('the-suave-star-pearl')
        ->merge(array_filter([
            'data-the-suave-emblem' => true,
            'data-asset-base' => asset($assetBase),
            'role' => $decorative ? null : 'img',
            'aria-label' => $decorative ? null : $ariaLabel,
            'aria-hidden' => $decorative ? 'true' : null,
            'style' => $size ? '--the-suave-emblem-size: '.$size : null,
        ], fn ($value) => $value !== null))
    }}
>
    <span class="the-suave-star-pearl__stage" data-tsp-stage aria-hidden="true">
        <span class="the-suave-star-pearl__star" data-tsp-star-layer>
            <img
                data-tsp-star-image
                src="{{ asset($starSrc) }}"
                alt="{{ $starAlt }}"
                title="{{ $starAlt }}"
                width="{{ $width }}"
                height="{{ $height }}"
                draggable="false"
                decoding="async"
            >
        </span>
        <span class="the-suave-star-pearl__star-sweep" data-tsp-star-sweep></span>
        <span class="the-suave-star-pearl__glint the-suave-star-pearl__glint--1" data-tsp-glint="1"></span>
        <span class="the-suave-star-pearl__glint the-suave-star-pearl__glint--2" data-tsp-glint="2"></span>
        <span class="the-suave-star-pearl__glint the-suave-star-pearl__glint--3" data-tsp-glint="3"></span>
        <span class="the-suave-star-pearl__glint the-suave-star-pearl__glint--4" data-tsp-glint="4"></span>
        <span class="the-suave-star-pearl__glint the-suave-star-pearl__glint--5" data-tsp-glint="5"></span>
        <span class="the-suave-star-pearl__pearl" data-tsp-pearl-layer>
            <img
                data-tsp-pearl-image
                src="{{ asset($pearlSrc) }}"
                alt="{{ $pearlAlt }}"
                title="{{ $pearlAlt }}"
                width="{{ $width }}"
                height="{{ $height }}"
                draggable="false"
                decoding="async"
            >
            <span class="the-suave-star-pearl__pearl-highlight" data-tsp-pearl-highlight></span>
        </span>
    </span>
</span>

@once
@push('scripts')
<script defer src="{{ asset('js/the-suave-star-pearl.js') }}?v={{ filemtime(public_path('js/the-suave-star-pearl.js')) }}"></script>
@endpush
@endonce
