@php
  $introParts = $introParts();
@endphp

<section
  @if ($sectionId !== '') id="{{ $sectionId }}" @endif
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
        @elseif ($icon === 'dollar')
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="12" cy="12" r="8.25" stroke="currentColor" stroke-width="1.8"/>
            <path d="M12 7.25v9.5M14.6 9.1c-.55-.7-1.4-1.1-2.6-1.1-1.55 0-2.6.8-2.6 1.95 0 2.7 5.2 1.35 5.2 4.05 0 1.2-1.1 2.05-2.7 2.05-1.25 0-2.2-.45-2.8-1.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        @elseif ($icon === 'blog')
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="12" cy="12" r="8.25" stroke="currentColor" stroke-width="1.8"/>
            <path d="M10.2 8.4h2.15c1.85 0 3.05 1.05 3.05 2.7 0 1.65-1.2 2.7-3.05 2.7H11.4V15.6H10.2V8.4Zm1.2 1.15v3.5h1c1.15 0 1.85-.6 1.85-1.75S13.55 9.55 12.4 9.55H11.4Z" fill="currentColor"/>
          </svg>
        @elseif ($icon === 'share')
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="18" cy="5.5" r="2.25" stroke="currentColor" stroke-width="1.8"/>
            <circle cx="6" cy="12" r="2.25" stroke="currentColor" stroke-width="1.8"/>
            <circle cx="18" cy="18.5" r="2.25" stroke="currentColor" stroke-width="1.8"/>
            <path d="M8.1 11.1 15.9 6.4M8.1 12.9l7.8 4.7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        @else
          <span class="marketing-channel-detail__rail-icon-placeholder"></span>
        @endif
      </span>
      <span class="marketing-channel-detail__rail-stroke" aria-hidden="true"></span>
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

      @if ($bridge !== '')
        <p class="marketing-channel-detail__bridge">{{ $bridge }}</p>
      @endif

      @if ($calloutLabel !== '' || $calloutBody !== '')
        <aside class="marketing-channel-detail__callout">
          @if ($calloutLabel !== '')
            <h3 class="marketing-channel-detail__callout-label">{{ $calloutLabel }}</h3>
          @endif
          @if ($calloutBody !== '')
            <p class="marketing-channel-detail__callout-body">{{ $calloutBody }}</p>
          @endif
        </aside>
      @endif
    </div>
  </div>

  <span class="marketing-channel-detail__stroke" aria-hidden="true"></span>
</section>
