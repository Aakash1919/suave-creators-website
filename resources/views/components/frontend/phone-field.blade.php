@php
    $labelId = $id.'-label';
@endphp

<div
    class="suave-phone-field"
    data-phone-field
    data-geo-country-url="{{ $geoCountryUrl }}"
    @if ($initialCountry !== '') data-initial-country="{{ $initialCountry }}" @endif
>
    @if ($showLabel)
        <span class="contact-form-panel__label-text" id="{{ $labelId }}">{{ $label }}</span>
    @endif

    <input
        id="{{ $id }}"
        type="tel"
        inputmode="numeric"
        autocomplete="{{ $autocomplete }}"
        placeholder="{{ $placeholder }}"
        value="{{ $value }}"
        data-phone-field-input
        @if ($showLabel) aria-labelledby="{{ $labelId }}" @endif
    >

    <input type="hidden" name="{{ $name }}" value="{{ $value }}" data-phone-field-value autocomplete="off">

    <span class="contact-form-panel__field-error" data-error-for="{{ $name }}" hidden></span>
</div>

@once
    @push('custom-css')
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/intl-tel-input@29.5.2/dist/css/intlTelInput.min.css">
    @endpush
    @push('scripts')
        <script defer
            src="https://cdn.jsdelivr.net/npm/intl-tel-input@29.5.2/dist/js/intlTelInputWithUtils.min.js"></script>
        <script defer
            src="{{ asset('js/phone-field.js') }}?v={{ file_exists(public_path('js/phone-field.js')) ? filemtime(public_path('js/phone-field.js')) : 1 }}"></script>
    @endpush
@endonce
