@if (count($items) > 0)
{{-- Case Studies Spotlight (dark) --}}
<section
  {{ $attributes->merge(['class' => trim("full-bleed case-studies-spotlight {$sectionClass}")]) }}
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner case-studies-spotlight__inner">
    <header class="case-studies-spotlight__header">
      <p class="case-studies-spotlight__eyebrow pragati-narrow-regular">{{ $eyebrow }}</p>
      <h2 id="{{ $headingId }}" class="case-studies-spotlight__title">{{ $title }}</h2>
      <p class="case-studies-spotlight__subtitle">{{ $subtitle }}</p>
    </header>

    <div class="case-studies-spotlight__grid">
      @foreach ($items as $item)
        <article class="case-studies-spotlight__card">
          <a href="{{ $item['url'] }}" class="case-studies-spotlight__media">
            @if ($item['image'] !== '')
              <img
                src="{{ str_starts_with($item['image'], 'http') || str_starts_with($item['image'], '/') ? $item['image'] : asset($item['image']) }}"
                alt="{{ $item['title'] }}"
                title="{{ $item['title'] }}"
                width="720"
                height="480"
                loading="lazy"
                decoding="async"
              >
            @endif
          </a>
          <div class="case-studies-spotlight__copy">
            @if ($item['client'] !== '')
              <p class="case-studies-spotlight__client pragati-narrow-regular">{{ $item['client'] }}</p>
            @endif
            <h3 class="case-studies-spotlight__card-title">
              <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
            </h3>
            @if ($item['subtitle'] !== '')
              <p class="case-studies-spotlight__card-subtitle">{{ $item['subtitle'] }}</p>
            @endif
            @if ($item['description'] !== '')
              <p class="case-studies-spotlight__desc">{{ $item['description'] }}</p>
            @endif
            <a class="case-studies-spotlight__cta" href="{{ $item['url'] }}">
              Read the full story
              <svg xmlns="https://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
            </a>
          </div>
          @if (! empty($item['stats']))
            <div class="case-studies-spotlight__stats" aria-label="Key results">
              @foreach ($item['stats'] as $stat)
                <div class="case-studies-spotlight__stat">
                  <span class="case-studies-spotlight__stat-value">{{ $stat['value'] ?? '' }}</span>
                  <span class="case-studies-spotlight__stat-label">{{ $stat['label'] ?? '' }}</span>
                </div>
              @endforeach
            </div>
          @endif
        </article>
      @endforeach
    </div>

    <footer class="case-studies-spotlight__footer">
      <a class="case-studies-spotlight__more" href="{{ $moreHref }}">{{ $moreLabel }}</a>
    </footer>
  </div>
</section>
@endif
