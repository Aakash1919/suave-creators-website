@php
    /** @var list<array{value: string, label: string, icon: string, color: string}> $normalized */
    $normalized = [];
    foreach ($options as $key => $option) {
        if (is_array($option)) {
            $normalized[] = [
                'value' => (string) ($option['value'] ?? ''),
                'label' => (string) ($option['label'] ?? ''),
                'icon' => (string) ($option['icon'] ?? $defaultIcon),
                'color' => (string) ($option['color'] ?? $defaultColor),
            ];
            continue;
        }

        $normalized[] = [
            'value' => is_int($key) ? (string) $option : (string) $key,
            'label' => (string) $option,
            'icon' => $defaultIcon,
            'color' => $defaultColor,
        ];
    }
@endphp

<div
    class="inquiry-select"
    data-inquiry-select
    data-inquiry-select-name="{{ $name }}"
    data-default-icon="{{ $defaultIcon }}"
    data-default-color="{{ $defaultColor }}"
    data-placeholder="{{ $placeholder }}"
>
    <input
        type="hidden"
        name="{{ $name }}"
        value=""
        data-inquiry-select-value
        @if ($required) required @endif
    >

    <button
        type="button"
        class="inquiry-select__trigger"
        data-inquiry-select-trigger
        aria-haspopup="listbox"
        aria-expanded="false"
        @if ($labelId) aria-labelledby="{{ $labelId }}" @endif
    >
        <span class="inquiry-select__value">
            <span class="inquiry-select__icon" data-inquiry-select-icon aria-hidden="true">
                <i class="{{ $defaultIcon }}" style="color: {{ $defaultColor }};"></i>
            </span>
            <span class="inquiry-select__label inquiry-select__label--placeholder" data-inquiry-select-label>{{ $placeholder }}</span>
        </span>
        <i class="fa-solid fa-chevron-down inquiry-select__chevron" data-inquiry-select-chevron aria-hidden="true"></i>
    </button>

    <div class="inquiry-select__menu" data-inquiry-select-menu role="listbox" hidden>
        @foreach ($normalized as $option)
            <div
                class="inquiry-select__option"
                data-inquiry-select-option
                data-value="{{ $option['value'] }}"
                data-label="{{ $option['label'] }}"
                data-icon="{{ $option['icon'] }}"
                data-color="{{ $option['color'] }}"
                role="option"
            >
                <span class="inquiry-select__option-icon" style="color: {{ $option['color'] }};" aria-hidden="true">
                    <i class="{{ $option['icon'] }}"></i>
                </span>
                <span class="inquiry-select__option-label">{{ $option['label'] }}</span>
            </div>
        @endforeach
    </div>
</div>
