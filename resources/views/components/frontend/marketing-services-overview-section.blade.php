@php
  $titleParts = $titleParts();
  $descriptionParts = $descriptionParts();
@endphp

<section
  @if ($sectionId !== '') id="{{ $sectionId }}" @endif
  {{ $attributes->merge(['class' => 'full-bleed marketing-services-overview']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner marketing-services-overview__inner">
    <header class="marketing-services-overview__header">
      <div class="marketing-services-overview__intro">
        @if ($eyebrow !== '')
          <p class="marketing-services-overview__eyebrow">
            <span class="marketing-services-overview__eyebrow-text">{{ $eyebrow }}</span>
          </p>
        @endif

        <h2 id="{{ $headingId }}" class="marketing-services-overview__title">
          {{ $titleParts['before'] }}@if ($titleParts['accent'] !== '')<span class="marketing-services-overview__title-accent">{{ $titleParts['accent'] }}</span>{{ $titleParts['after'] }}@endif
        </h2>
      </div>

      @if ($description !== '')
        <span class="marketing-services-overview__stroke" aria-hidden="true"></span>
        <p class="marketing-services-overview__desc">
          {{ $descriptionParts['before'] }}@if ($descriptionParts['highlight'] !== '')<strong class="marketing-services-overview__desc-brand">{{ $descriptionParts['highlight'] }}</strong>{{ $descriptionParts['after'] }}@endif
        </p>
      @endif
    </header>

    @if ($rows !== [])
      <div class="marketing-services-overview__cards">
        @foreach ($rows as $row)
          @php
            $anchor = trim((string) ($row['anchor'] ?? ''));
            $service = (string) ($row['service'] ?? '');
            $theme = trim((string) ($row['theme'] ?? 'blue'));
            $icon = trim((string) ($row['icon'] ?? ''));
            $rowCta = trim((string) ($row['ctaLabel'] ?? $ctaLabel));
          @endphp
          <article class="marketing-services-overview__card marketing-services-overview__card--{{ $theme }}">
            <span class="marketing-services-overview__card-icon" aria-hidden="true">
              @if ($icon === 'search')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.8"/>
                  <path d="M16.2 16.2 20 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
              @elseif ($icon === 'dollar')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="12" r="8.25" stroke="currentColor" stroke-width="1.8"/>
                  <path d="M12 7.25v9.5M14.6 9.1c-.55-.7-1.4-1.1-2.6-1.1-1.55 0-2.6.8-2.6 1.95 0 2.7 5.2 1.35 5.2 4.05 0 1.2-1.1 2.05-2.7 2.05-1.25 0-2.2-.45-2.8-1.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              @elseif ($icon === 'document')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8 3.75h5.25L17.5 8v12.25H8V3.75Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                  <path d="M13.25 3.75V8H17.5M10 12h4.5M10 15.5h4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              @elseif ($icon === 'share')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18" cy="5.5" r="2.25" stroke="currentColor" stroke-width="1.8"/>
                  <circle cx="6" cy="12" r="2.25" stroke="currentColor" stroke-width="1.8"/>
                  <circle cx="18" cy="18.5" r="2.25" stroke="currentColor" stroke-width="1.8"/>
                  <path d="M8.1 11.1 15.9 6.4M8.1 12.9l7.8 4.7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
              @else
                <span class="marketing-services-overview__card-icon-placeholder"></span>
              @endif
            </span>

            <h3 class="marketing-services-overview__card-title">{{ $service }}</h3>

            @if (($row['does'] ?? '') !== '')
              <p class="marketing-services-overview__card-does">{{ $row['does'] }}</p>
            @endif

            <dl class="marketing-services-overview__card-meta">
              <div class="marketing-services-overview__card-row">
                <dt>
                  <span class="marketing-services-overview__card-meta-icon marketing-services-overview__card-meta-icon--best-for" aria-hidden="true"></span>
                  Best for
                </dt>
                <dd>{{ $row['bestFor'] ?? '' }}</dd>
              </div>
              <div class="marketing-services-overview__card-row">
                <dt>
                  <span class="marketing-services-overview__card-meta-icon marketing-services-overview__card-meta-icon--measured" aria-hidden="true"></span>
                  Measured by
                </dt>
                <dd>{{ $row['measured'] ?? '' }}</dd>
              </div>
            </dl>

            @if ($anchor !== '' && $rowCta !== '')
              <a href="#{{ $anchor }}" class="marketing-services-overview__card-cta">
                {{ $rowCta }}
                <span class="marketing-services-overview__card-cta-arrow" aria-hidden="true">
                  <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 6h16M11 1l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            @endif
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>
