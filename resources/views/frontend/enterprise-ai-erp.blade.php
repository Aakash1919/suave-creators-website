@extends('layouts.frontend')

@push('custom-css')
<link rel="preload" as="image" href="{{ asset($bannerBackgroundImage) }}" type="image/webp">
@endpush

@section('content')

<section
  class="full-bleed enterprise-ai-erp-hero"
  style="background-image: url('{{ asset($bannerBackgroundImage) }}');"
  aria-labelledby="enterprise-ai-erp-heading">
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
  </div>
</section>

<section
  class="full-bleed crm-builder-trust-band"
  id="trust"
  style="background-image: url('{{ asset($trustBackgroundImage) }}');"
  aria-label="{{ $trustTitle }}">
  <div class="section-inner">
    <div class="crm-builder-trust">
      <div class="crm-builder-trust__intro">
        <p class="crm-builder-trust__eyebrow">
          <span class="crm-builder-trust__eyebrow-bar" aria-hidden="true"></span>
          <span class="crm-builder-trust__eyebrow-text">{{ $trustEyebrow }}</span>
        </p>
        <div class="crm-builder-trust__copy">
          <h2 class="home-type-h2 crm-builder-trust__title">{{ $trustTitle }}</h2>
          <p class="crm-builder-trust__desc">{{ $trustDescription }}</p>
          <a href="{{ route('services') }}" class="crm-builder-trust__link">
            {{ $trustLinkText }}
            <x-frontend.cta-arrow />
          </a>
        </div>
      </div>

      <div class="crm-builder-trust__stats">
        @foreach ($trustStats as $stat)
          <article class="crm-builder-trust__stat">
            <strong class="crm-builder-trust__stat-value">{{ $stat['value'] }}</strong>
            <h3 class="crm-builder-trust__stat-label">{{ $stat['label'] }}</h3>
            <p class="crm-builder-trust__stat-detail">{{ $stat['detail'] }}</p>
          </article>
        @endforeach
      </div>
    </div>
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

<section class="full-bleed enterprise-ai-erp-verticals" aria-labelledby="enterprise-ai-erp-verticals-heading">
  <div class="section-inner enterprise-ai-erp-verticals__inner">
    <div class="enterprise-ai-erp-verticals__intro">
      <p class="enterprise-ai-erp-verticals__eyebrow">
        <span class="enterprise-ai-erp-verticals__eyebrow-mark" aria-hidden="true"></span>
        {{ $verticals['eyebrow'] }}
      </p>
      <div class="enterprise-ai-erp-verticals__copy">
        <h2 id="enterprise-ai-erp-verticals-heading" class="enterprise-ai-erp-verticals__title">{{ $verticals['title'] }}</h2>
        <p class="enterprise-ai-erp-verticals__desc">{{ $verticals['description'] }}</p>
      </div>
    </div>

    <div class="enterprise-ai-erp-verticals__grid">
      @foreach ($verticals['items'] as $item)
        <article class="enterprise-ai-erp-verticals__card">
          <div class="enterprise-ai-erp-verticals__media">
            @if (filled($item['image']))
              <img
                src="{{ asset($item['image']) }}"
                alt="{{ $item['imageAlt'] }}"
                title="{{ $item['imageAlt'] }}"
                width="640"
                height="400"
                loading="lazy"
                decoding="async">
            @else
              <span class="enterprise-ai-erp-verticals__image-placeholder" role="img" aria-label="{{ $item['imageAlt'] }}"></span>
            @endif
          </div>
          <div class="enterprise-ai-erp-verticals__logo">
            @if (filled($item['logo']))
              <img
                src="{{ asset($item['logo']) }}"
                alt="{{ $item['logoAlt'] }}"
                title="{{ $item['logoAlt'] }}"
                width="32"
                height="32"
                loading="lazy"
                decoding="async">
            @else
              <span class="enterprise-ai-erp-verticals__logo-placeholder" role="img" aria-label="{{ $item['logoAlt'] }}"></span>
            @endif
          </div>
          <h3 class="enterprise-ai-erp-verticals__card-title">{{ $item['title'] }}</h3>
          <p class="enterprise-ai-erp-verticals__kicker">{{ $verticals['challengeLabel'] }}</p>
          <p class="enterprise-ai-erp-verticals__text">{{ $item['challenge'] }}</p>
          <p class="enterprise-ai-erp-verticals__kicker1">{{ $verticals['architectureLabel'] }}</p>
          <p class="enterprise-ai-erp-verticals__text">{{ $item['architecture'] }}</p>
        </article>
      @endforeach
    </div>
  </div>
</section>

<section class="full-bleed enterprise-ai-erp-governance" aria-labelledby="enterprise-ai-erp-governance-heading">
  <div class="section-inner enterprise-ai-erp-governance__inner">
    <div class="enterprise-ai-erp-governance__copy">
      <p class="enterprise-ai-erp-governance__eyebrow">{{ $governance['eyebrow'] }}</p>
      <h2 id="enterprise-ai-erp-governance-heading" class="enterprise-ai-erp-governance__title">{{ $governance['title'] }}</h2>
      <p class="enterprise-ai-erp-governance__desc">{{ $governance['description'] }}</p>
    </div>
    <div class="enterprise-ai-erp-governance__list">
      @foreach ($governance['items'] as $item)
        <article class="enterprise-ai-erp-governance__card">
          <h3 class="enterprise-ai-erp-governance__card-title">{{ $item['title'] }}</h3>
          <p class="enterprise-ai-erp-governance__card-copy">{{ $item['copy'] }}</p>
        </article>
      @endforeach
    </div>
  </div>
</section>

<section class="full-bleed enterprise-ai-erp-stack" aria-labelledby="enterprise-ai-erp-stack-heading">
  <div class="section-inner enterprise-ai-erp-stack__inner">
    <p class="enterprise-ai-erp-stack__eyebrow">{{ $stack['eyebrow'] }}</p>
    <h2 id="enterprise-ai-erp-stack-heading" class="enterprise-ai-erp-stack__title">{{ $stack['title'] }}</h2>

    @foreach ($stack['groups'] as $group)
      <div class="enterprise-ai-erp-stack__row">
        <div class="enterprise-ai-erp-stack__intro">
          <h3 class="enterprise-ai-erp-stack__category">{{ $group['title'] }}</h3>
          <p class="enterprise-ai-erp-stack__subtitle">{{ $group['subtitle'] }}</p>
          <p class="enterprise-ai-erp-stack__desc">{{ $group['description'] }}</p>
        </div>
        <ul class="enterprise-ai-erp-stack__cards">
          @foreach ($group['items'] as $item)
            <li class="enterprise-ai-erp-stack__card">
              <div class="enterprise-ai-erp-stack__icon">
                @if (filled($item['icon']))
                  <img
                    src="{{ asset($item['icon']) }}"
                    alt="{{ $item['iconAlt'] }}"
                    title="{{ $item['iconAlt'] }}"
                    width="40"
                    height="40"
                    loading="lazy"
                    decoding="async">
                @else
                  <span class="enterprise-ai-erp-stack__icon-placeholder" role="img" aria-label="{{ $item['iconAlt'] }}"></span>
                @endif
              </div>
              <p class="enterprise-ai-erp-stack__name">{{ $item['name'] }}</p>
              <p class="enterprise-ai-erp-stack__copy">{{ $item['copy'] }}</p>
            </li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
</section>

<section class="full-bleed enterprise-ai-erp-delivery" aria-labelledby="enterprise-ai-erp-delivery-heading">
  <div class="section-inner enterprise-ai-erp-delivery__inner">
    <div class="enterprise-ai-erp-delivery__intro">
      <p class="enterprise-ai-erp-delivery__eyebrow">
        <span class="enterprise-ai-erp-delivery__eyebrow-mark" aria-hidden="true"></span>
        {{ $delivery['eyebrow'] }}
      </p>
      <div class="enterprise-ai-erp-delivery__copy">
        <h2 id="enterprise-ai-erp-delivery-heading" class="enterprise-ai-erp-delivery__title">{{ $delivery['title'] }}</h2>
        <p class="enterprise-ai-erp-delivery__desc">{{ $delivery['description'] }}</p>
      </div>
    </div>

    <div class="enterprise-ai-erp-delivery__grid">
      @foreach ($delivery['items'] as $item)
        <article class="enterprise-ai-erp-delivery__card">
          <div class="enterprise-ai-erp-delivery__media">
            @if (filled($item['image']))
              <img
                src="{{ asset($item['image']) }}"
                alt="{{ $item['imageAlt'] }}"
                title="{{ $item['imageAlt'] }}"
                width="640"
                height="400"
                loading="lazy"
                decoding="async">
            @else
              <span class="enterprise-ai-erp-delivery__image-placeholder" role="img" aria-label="{{ $item['imageAlt'] }}"></span>
            @endif
          </div>
          <div class="enterprise-ai-erp-delivery__logo">
            @if (filled($item['logo']))
              <img
                src="{{ asset($item['logo']) }}"
                alt="{{ $item['logoAlt'] }}"
                title="{{ $item['logoAlt'] }}"
                width="22"
                height="22"
                loading="lazy"
                decoding="async">
            @else
              <span class="enterprise-ai-erp-delivery__logo-placeholder" role="img" aria-label="{{ $item['logoAlt'] }}"></span>
            @endif
          </div>
          <h3 class="enterprise-ai-erp-delivery__card-title">{{ $item['title'] }}</h3>
          <p class="enterprise-ai-erp-delivery__text">{{ $item['copy'] }}</p>
        </article>
      @endforeach
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
          768: { slidesPerView: 2, spaceBetween: 18 },
          1200: { slidesPerView: 4, spaceBetween: 18 }
        }
      });
    });
  });
</script>
@endpush
