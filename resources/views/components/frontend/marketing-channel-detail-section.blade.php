@php
  $introParts = $introParts();
@endphp

<section
  {{ $attributes->merge(['class' => 'full-bleed marketing-channel-detail']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner marketing-channel-detail__inner">
    <aside class="marketing-channel-detail__rail" aria-hidden="true">
      <span class="marketing-channel-detail__rail-index">{{ $index }}</span>
      <span class="marketing-channel-detail__rail-icon marketing-channel-detail__rail-icon--{{ $icon }}">
        @if ($icon === 'search')
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.8"/>
            <path d="M16.2 16.2 20 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        @else
          <span class="marketing-channel-detail__rail-icon-placeholder"></span>
        @endif
      </span>
    </aside>

    <div class="marketing-channel-detail__content">
      <p class="marketing-channel-detail__step">{{ $indexLabel() }}</p>

      <h2 id="{{ $headingId }}" class="marketing-channel-detail__title">{{ $title }}</h2>

      <p class="marketing-channel-detail__intro">
        {{ $introParts['before'] }}@if ($introParts['highlight'] !== '')<strong class="marketing-channel-detail__intro-accent">{{ $introParts['highlight'] }}</strong>{{ $introParts['after'] }}@endif
      </p>

      <h3 class="marketing-channel-detail__covers-heading">{{ $coversHeading }}</h3>

      <ul class="marketing-channel-detail__covers">
        @foreach ($covers as $item)
          <li class="marketing-channel-detail__cover">
            <span class="marketing-channel-detail__cover-check" aria-hidden="true">
              <i class="fa-solid fa-check"></i>
            </span>
            <p class="marketing-channel-detail__cover-text">
              <strong>{{ $item['title'] }}.</strong>
              {{ $item['description'] }}
            </p>
          </li>
        @endforeach
      </ul>

      @if ($calloutLabel !== '' || $calloutBody !== '')
        <aside class="marketing-channel-detail__callout">
          @if ($calloutLabel !== '')
            <p class="marketing-channel-detail__callout-label">{{ $calloutLabel }}</p>
          @endif
          @if ($calloutBody !== '')
            <p class="marketing-channel-detail__callout-body">{{ $calloutBody }}</p>
          @endif
        </aside>
      @endif

      @if ($relatedLinks !== [])
        <p class="marketing-channel-detail__related">
          <span class="marketing-channel-detail__related-label">Related:</span>
          @foreach ($relatedLinks as $i => $link)
            @if ($i > 0)
              <span class="marketing-channel-detail__related-sep" aria-hidden="true">·</span>
            @endif
            <a href="{{ $link['href'] }}" class="marketing-channel-detail__related-link">{{ $link['label'] }}</a>
          @endforeach
        </p>
      @endif
    </div>
  </div>
</section>
