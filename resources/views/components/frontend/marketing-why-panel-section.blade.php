<section
  {{ $attributes->merge(['class' => 'full-bleed marketing-why-panel']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner marketing-why-panel__inner">
    <div class="marketing-why-panel__panel">
      <div class="marketing-why-panel__intro">
        <p class="marketing-why-panel__eyebrow">{{ $eyebrow }}</p>
        <h2 id="{{ $headingId }}" class="marketing-why-panel__title">{{ $title }}</h2>
        @if ($description !== '')
          <p class="marketing-why-panel__desc">{{ $description }}</p>
        @endif
        <x-frontend.cta-button
          :href="$ctaHref"
          :service="$primaryService"
          class="marketing-why-panel__cta">
          {{ $ctaLabel }}
        </x-frontend.cta-button>
      </div>

      @if ($items !== [])
        <ul class="marketing-why-panel__list">
          @foreach ($items as $item)
            @php
              $icon = (string) ($item['icon'] ?? '');
              $iconAlt = (string) ($item['iconAlt'] ?? (($item['title'] ?? 'Feature').' icon'));
            @endphp
            <li class="marketing-why-panel__item">
              <div class="marketing-why-panel__item-icon">
                @if (filled($icon))
                  <img
                    src="{{ asset($icon) }}"
                    alt="{{ $iconAlt }}"
                    title="{{ $iconAlt }}"
                    width="40"
                    height="40"
                    loading="lazy"
                    decoding="async">
                @else
                  <span
                    class="marketing-why-panel__icon-placeholder"
                    role="img"
                    aria-label="{{ $iconAlt }}"></span>
                @endif
              </div>
              <div class="marketing-why-panel__item-copy">
                <h3 class="marketing-why-panel__item-title">{{ $item['title'] }}</h3>
                @if (($item['description'] ?? '') !== '')
                  <p class="marketing-why-panel__item-body">
                    @if (! empty($item['descriptionHtml']))
                      {!! $item['description'] !!}
                    @else
                      {{ $item['description'] }}
                    @endif
                  </p>
                @endif
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</section>
