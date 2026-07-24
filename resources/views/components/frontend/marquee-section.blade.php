@php
    $rootClass = $type === 'image' ? 'partnership-marquee' : 'digital-services-marquee';
    $trackClass = $type === 'image' ? 'partnership-marquee__track' : 'digital-services-marquee__track';
    $groupClass = $type === 'image' ? 'partnership-marquee__group' : 'digital-services-marquee__group';
    $loopItems = [];

    for ($i = 0; $i < max(1, $repeat); $i++) {
        $loopItems = array_merge($loopItems, $items);
    }
@endphp

@if (count($items) > 0)
    @if ($position === 'full')
        <section
            {{ $attributes->merge(['class' => "full-bleed full-bleed--edge site-marquee site-marquee--{$type} {$rootClass}"]) }}
            @if (filled($ariaLabel)) aria-label="{{ $ariaLabel }}" @endif
            tabindex="0">
            <div
                class="{{ $trackClass }} site-marquee__track site-marquee__track--{{ $direction }}"
                style="animation-duration: {{ $speed }}s;">
                @for ($group = 0; $group < 2; $group++)
                    <div class="{{ $groupClass }}" @if ($group === 1) aria-hidden="true" @endif>
                        @foreach ($loopItems as $item)
                            @if ($type === 'image')
                                <div class="partnership-tile">
                                    <img
                                        src="{{ $item['src'] }}"
                                        alt="{{ $group === 0 && filled($item['alt']) ? $item['alt'].' logo' : '' }}"
                                        @if ($group === 0) loading="lazy" @endif>
                                </div>
                            @else
                                <span class="digital-services-marquee__label digital-services-marquee__label--{{ $item['style'] }}">{{ $item['label'] }}</span>
                                <span class="digital-services-marquee__separator digital-services-marquee__separator--{{ $item['separator'] }}" aria-hidden="true"></span>
                            @endif
                        @endforeach
                    </div>
                @endfor
            </div>
        </section>
    @else
        <div
            {{ $attributes->merge(['class' => "site-marquee site-marquee--{$type} {$rootClass}"]) }}
            @if (filled($ariaLabel)) aria-label="{{ $ariaLabel }}" @endif
            tabindex="0">
            <div
                class="{{ $trackClass }} site-marquee__track site-marquee__track--{{ $direction }}"
                style="animation-duration: {{ $speed }}s;">
                @for ($group = 0; $group < 2; $group++)
                    <div class="{{ $groupClass }}" @if ($group === 1) aria-hidden="true" @endif>
                        @foreach ($loopItems as $item)
                            @if ($type === 'image')
                                <div class="partnership-tile">
                                    <img
                                        src="{{ $item['src'] }}"
                                        alt="{{ $group === 0 && filled($item['alt']) ? $item['alt'].' logo' : '' }}"
                                        @if ($group === 0) loading="lazy" @endif>
                                </div>
                            @else
                                <span class="digital-services-marquee__label digital-services-marquee__label--{{ $item['style'] }}">{{ $item['label'] }}</span>
                                <span class="digital-services-marquee__separator digital-services-marquee__separator--{{ $item['separator'] }}" aria-hidden="true"></span>
                            @endif
                        @endforeach
                    </div>
                @endfor
            </div>
        </div>
    @endif
@endif
