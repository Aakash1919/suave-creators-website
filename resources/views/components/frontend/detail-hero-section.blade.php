<section
  {{ $attributes->merge(['class' => 'full-bleed service-banner relative z-1 pt-10 pb-0 md:pt-10 md:pb-2 lg:pt-[50px] lg:pb-2']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner">
    <div class="service-banner__panel service-banner__panel--has-bg" style="background-image: url('{{ $backgroundImage }}');">
      <div class="service-banner__grid">
        <div class="service-banner__copy">
          <p class="service-banner__eyebrow {{ $eyebrowClass }}">{{ $eyebrow }}</p>
          <h1 id="{{ $headingId }}" class="page-hero-title service-banner__title">
            @foreach ($titleLines as $i => $line)
              <span class="{{ $isAccentLine($i) ? 'service-banner__title-accent' : 'service-banner__title-lead' }}">{{ $line }}</span>
            @endforeach
          </h1>
          <p class="service-banner__desc">{{ $description }}</p>
          <div class="service-banner__cta">
            <x-frontend.inline-consultation-form
              theme="dark"
              align="start"
              placeholder="Enter your phone or email"
              :button-text="$primaryLabel"
              :secondary-href="$demoHref"
              :secondary-label="$secondaryLabel" />
          </div>
        </div>

        <div class="service-banner__side">
          <div class="{{ $framedSide ? 'service-banner__media' : 'contents' }}">
            <img
              src="{{ $sideImage }}"
              alt="{{ $sideImageAlt }}"
              title="{{ $sideImageAlt }}"
              width="560"
              height="560"
              class="service-banner__side-img"
              loading="eager"
              decoding="async">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
