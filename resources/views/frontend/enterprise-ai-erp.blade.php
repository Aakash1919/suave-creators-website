@extends('layouts.frontend')

@section('content')

<section class="full-bleed enterprise-ai-erp-hero" aria-labelledby="enterprise-ai-erp-heading">
  <div class="section-inner enterprise-ai-erp-hero__inner">
    <div class="enterprise-ai-erp-hero__top">
      <div class="enterprise-ai-erp-hero__copy">
        <p class="enterprise-ai-erp-hero__eyebrow"><span class="enterprise-ai-erp-hero__eyebrow-text">{{ $eyebrow }}</span></p>
        <h1 id="enterprise-ai-erp-heading" class="page-hero-title enterprise-ai-erp-hero__title">
          <span class="enterprise-ai-erp-hero__title-lead">{{ $heroLead }}</span>
          <span class="enterprise-ai-erp-hero__title-line">{{ $heroMid }}</span>
          <span class="enterprise-ai-erp-hero__title-accent">{{ $heroAccent }}</span>
        </h1>
        <p class="enterprise-ai-erp-hero__desc">{{ $heroDescription }}</p>
        <div class="enterprise-ai-erp-hero__cta">
          <x-frontend.cta-button :href="$demoHref" :show-arrow="false">{{ $primaryCta }}</x-frontend.cta-button>
          <a href="{{ $demoHref }}" class="enterprise-ai-erp-hero__cta-secondary" target="_blank" rel="noopener noreferrer">
            {{ $secondaryCta }}
            <x-frontend.cta-arrow />
          </a>
        </div>
      </div>

      {{-- Replace this frame with an img: asset('assets/media/...') plus alt and title. --}}
      <div class="enterprise-ai-erp-hero__visual" role="img" aria-label="{{ $visualLabel }}"></div>
    </div>

    <section class="enterprise-ai-erp-metrics" aria-labelledby="enterprise-ai-erp-metrics-heading">
      <h2 id="enterprise-ai-erp-metrics-heading" class="enterprise-ai-erp-metrics__title">{{ $metricsTitle }}</h2>
      <div class="enterprise-ai-erp-metrics__grid">
        @foreach ($metrics as $metric)
          <article class="enterprise-ai-erp-metrics__card">
            <p class="enterprise-ai-erp-metrics__value">{{ $metric['value'] }}</p>
            <p class="enterprise-ai-erp-metrics__detail">{{ $metric['detail'] }}</p>
          </article>
        @endforeach
      </div>
    </section>
  </div>
</section>

<section
  class="full-bleed enterprise-ai-erp-definition"
  style="background-image: url('{{ asset('assets/background/enterprise-ai-erp-circuit-pattern.webp') }}');"
  aria-labelledby="enterprise-ai-erp-definition-heading">
  <div class="section-inner enterprise-ai-erp-definition__inner">
    <div class="enterprise-ai-erp-definition__copy">
      <p class="enterprise-ai-erp-definition__eyebrow">{{ $definitionEyebrow }}</p>
      <h2 id="enterprise-ai-erp-definition-heading" class="enterprise-ai-erp-definition__title">{{ $definitionTitle }}</h2>
    </div>
    <div class="enterprise-ai-erp-definition__aside">
      <p class="enterprise-ai-erp-definition__desc">{{ $definitionCopy }} <strong>{{ $definitionEmphasis }}</strong></p>
      <div class="enterprise-ai-erp-definition__cta">
        <x-frontend.cta-button :href="$demoHref">{{ $definitionCta }}</x-frontend.cta-button>
      </div>
    </div>
  </div>
</section>

<section class="full-bleed enterprise-ai-erp-allocation" aria-labelledby="enterprise-ai-erp-allocation-heading">
  <div class="section-inner enterprise-ai-erp-allocation__inner">
    <div class="enterprise-ai-erp-allocation__copy">
      <p class="enterprise-ai-erp-allocation__eyebrow">
        <span class="enterprise-ai-erp-allocation__eyebrow-mark" aria-hidden="true"></span>
        {{ $allocationEyebrow }}
      </p>
      <h2 id="enterprise-ai-erp-allocation-heading" class="enterprise-ai-erp-allocation__title">{{ $allocationTitle }}</h2>
      @foreach ($allocationParagraphs as $paragraph)
        <p class="enterprise-ai-erp-allocation__desc">
          {{ $paragraph['before'] }}@if (filled($paragraph['emphasis']))<strong>{{ $paragraph['emphasis'] }}</strong>@endif{{ $paragraph['after'] }}
        </p>
      @endforeach
      <div class="enterprise-ai-erp-allocation__cta">
        <x-frontend.cta-button :href="$demoHref">{{ $allocationCta }}</x-frontend.cta-button>
      </div>
    </div>

    <div class="enterprise-ai-erp-allocation__collage">
      @foreach ($allocationVisuals as $visual)
        <div class="enterprise-ai-erp-allocation__tile enterprise-ai-erp-allocation__tile--{{ $visual['slot'] }}">
          <img
            src="{{ asset($visual['src']) }}"
            alt="{{ $visual['label'] }}"
            title="{{ $visual['label'] }}"
            width="{{ $visual['slot'] === 'center' ? 480 : 640 }}"
            height="{{ $visual['slot'] === 'center' ? 480 : 420 }}">
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="full-bleed crm-builder-tco enterprise-ai-erp-tco" aria-labelledby="enterprise-ai-erp-tco-heading">
  <div class="section-inner crm-builder-tco__inner">
    <div class="crm-builder-tco__intro">
      <p class="crm-builder-tco__eyebrow">
        <span class="crm-builder-tco__eyebrow-bar" aria-hidden="true"></span>
        <span class="crm-builder-tco__eyebrow-text">{{ $tco['eyebrow'] }}</span>
      </p>
      <div class="crm-builder-tco__copy">
        <h2 id="enterprise-ai-erp-tco-heading" class="home-type-h2 crm-builder-tco__title">{{ $tco['title'] }}</h2>
        <p class="crm-builder-tco__desc">{{ $tco['description'] }}</p>
      </div>
    </div>

    <div class="crm-builder-tco__panel">
      <table class="crm-builder-tco__table">
        <thead>
          <tr>
            <th scope="col" class="crm-builder-tco__col--metric">
              <span class="crm-builder-tco__heading">
                <span class="crm-builder-tco__icon crm-builder-tco__icon--metric">
                  @if (filled($tco['metricIcon']))
                    <img
                      src="{{ asset($tco['metricIcon']) }}"
                      alt="{{ $tco['metricIconAlt'] }}"
                      title="{{ $tco['metricIconAlt'] }}"
                      width="24"
                      height="24"
                      decoding="async">
                  @else
                    <span class="enterprise-ai-erp-tco__icon-placeholder" role="img" aria-label="{{ $tco['metricIconAlt'] }}"></span>
                  @endif
                </span>
                <span class="crm-builder-tco__heading-text">{{ $tco['metricHeading'] }}</span>
              </span>
            </th>
            <th scope="col" class="crm-builder-tco__col--saas">
              <span class="crm-builder-tco__heading">
                <span class="crm-builder-tco__icon crm-builder-tco__icon--saas">
                  @if (filled($tco['saasIcon']))
                    <img
                      src="{{ asset($tco['saasIcon']) }}"
                      alt="{{ $tco['saasIconAlt'] }}"
                      title="{{ $tco['saasIconAlt'] }}"
                      width="32"
                      height="22"
                      decoding="async">
                  @else
                    <span class="enterprise-ai-erp-tco__icon-placeholder" role="img" aria-label="{{ $tco['saasIconAlt'] }}"></span>
                  @endif
                </span>
                <span class="crm-builder-tco__heading-copy">
                  <span class="crm-builder-tco__heading-text">{{ $tco['saasHeading'] }}</span>
                  @if (filled($tco['saasNote']))
                    <span class="crm-builder-tco__heading-note">{{ $tco['saasNote'] }}</span>
                  @endif
                </span>
              </span>
            </th>
            <th scope="col" class="crm-builder-tco__col--custom">
              <span class="crm-builder-tco__heading">
                <span class="crm-builder-tco__icon crm-builder-tco__icon--custom">
                  @if (filled($tco['customIcon']))
                    <img
                      src="{{ asset($tco['customIcon']) }}"
                      alt="{{ $tco['customIconAlt'] }}"
                      title="{{ $tco['customIconAlt'] }}"
                      width="28"
                      height="22"
                      decoding="async">
                  @else
                    <span class="enterprise-ai-erp-tco__icon-placeholder" role="img" aria-label="{{ $tco['customIconAlt'] }}"></span>
                  @endif
                </span>
                <span class="crm-builder-tco__heading-copy">
                  <span class="crm-builder-tco__heading-text">{{ $tco['customHeading'] }}</span>
                  @if (filled($tco['customNote']))
                    <span class="crm-builder-tco__heading-note">{{ $tco['customNote'] }}</span>
                  @endif
                </span>
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tco['rows'] as $row)
            <tr>
              <th scope="row">
                <span class="crm-builder-tco__metric">
                  <span class="crm-builder-tco__icon crm-builder-tco__icon--row" aria-hidden="true">
                    <img
                      src="{{ asset($tco['rowIcon']) }}"
                      alt="{{ $tco['rowIconAlt'] }}"
                      title="{{ $tco['rowIconAlt'] }}"
                      width="20"
                      height="20"
                      decoding="async">
                  </span>
                  <span class="crm-builder-tco__metric-label">{{ $row['metric'] }}</span>
                </span>
              </th>
              <td class="crm-builder-tco__col--saas">
                <strong class="crm-builder-tco__value crm-builder-tco__value--saas">{{ $row['saasValue'] }}</strong>
                <span class="crm-builder-tco__detail">{{ $row['saasDetail'] }}</span>
              </td>
              <td class="crm-builder-tco__col--custom">
                <strong class="crm-builder-tco__value crm-builder-tco__value--custom">{{ $row['customValue'] }}</strong>
                <span class="crm-builder-tco__detail">{{ $row['customDetail'] }}</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="full-bleed enterprise-ai-erp-modules" aria-labelledby="enterprise-ai-erp-modules-heading">
  <div class="section-inner enterprise-ai-erp-modules__inner">
    <div class="enterprise-ai-erp-modules__intro">
      <p class="enterprise-ai-erp-modules__eyebrow">
        <span class="enterprise-ai-erp-modules__eyebrow-mark" aria-hidden="true"></span>
        {{ $modules['eyebrow'] }}
      </p>
      <div class="enterprise-ai-erp-modules__copy">
        <h2 id="enterprise-ai-erp-modules-heading" class="enterprise-ai-erp-modules__title">{{ $modules['title'] }}</h2>
        <p class="enterprise-ai-erp-modules__desc">{{ $modules['description'] }}</p>
      </div>
    </div>

    <div class="enterpriseModulesSwiper swiper enterprise-ai-erp-modules__swiper" aria-label="{{ $modules['eyebrow'] }}">
      <div class="swiper-wrapper">
      @foreach ($modules['items'] as $item)
        <div class="swiper-slide">
        <article class="enterprise-ai-erp-modules__card">
          <div class="enterprise-ai-erp-modules__icon">
            @if (filled($item['icon']))
              <img
                src="{{ asset($item['icon']) }}"
                alt="{{ $item['iconAlt'] }}"
                title="{{ $item['iconAlt'] }}"
                width="28"
                height="28"
                decoding="async">
            @else
              <span class="enterprise-ai-erp-modules__icon-placeholder" role="img" aria-label="{{ $item['iconAlt'] }}"></span>
            @endif
          </div>
          <h3 class="enterprise-ai-erp-modules__card-title">{{ $item['title'] }}</h3>
          <ul class="enterprise-ai-erp-modules__tags">
            @foreach ($item['tags'] as $tag)
              <li>{{ $tag }}</li>
            @endforeach
          </ul>
          <p class="enterprise-ai-erp-modules__card-copy">{{ $item['copy'] }}</p>
        </article>
        </div>
      @endforeach
      </div>
    </div>

    <div class="enterprise-ai-erp-modules__nav">
      <button class="enterprise-ai-erp-modules__prev offerings-control" type="button" aria-label="Previous enterprise module">
        <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
      </button>
      <button class="enterprise-ai-erp-modules__next offerings-control" type="button" aria-label="Next enterprise module">
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  window.suaveWhenSwiperReady(function () {
    document.querySelectorAll('.enterpriseModulesSwiper:not(.swiper-initialized)').forEach(function (el) {
      var root = el.closest('.enterprise-ai-erp-modules');
      if (!root) return;

      new Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 18,
        speed: 550,
        rewind: true,
        allowTouchMove: true,
        simulateTouch: true,
        grabCursor: true,
        watchOverflow: true,
        keyboard: {
          enabled: true,
          onlyInViewport: true
        },
        navigation: {
          nextEl: root.querySelector('.enterprise-ai-erp-modules__next'),
          prevEl: root.querySelector('.enterprise-ai-erp-modules__prev')
        },
        a11y: {
          prevSlideMessage: 'Previous enterprise module',
          nextSlideMessage: 'Next enterprise module',
          containerMessage: 'Enterprise modules carousel'
        },
        breakpoints: {
          640: { slidesPerView: 2, spaceBetween: 18 },
          1024: { slidesPerView: 3, spaceBetween: 18 }
        }
      });
    });
  });
</script>
@endpush
