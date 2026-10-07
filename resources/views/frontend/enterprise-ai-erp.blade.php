@extends('layouts.frontend')

@section('theme-color', '#0F172A')

@push('custom-css')
<link rel="preload" as="image" href="{{ asset($bannerBackgroundImage) }}" type="image/webp">
@if (filled($heroVisualImage))
<link rel="preload" as="image" href="{{ asset($heroVisualImage) }}" type="image/webp">
@endif
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
            <img
              class="enterprise-ai-erp-hero__cta-arrow"
              src="{{ asset('assets/media/soft-white-right-arrow.png') }}"
              alt="White right arrow for the Let's Connect enterprise AI ERP button"
              title="White right arrow for the Let's Connect enterprise AI ERP button"
              width="112"
              height="40"
              decoding="async">
          </a>
        </div>
      </div>

      <div class="enterprise-ai-erp-hero__visual">
        <ul class="enterprise-ai-erp-hero__features">
          @foreach ($heroFeatures as $feature)
            <li class="enterprise-ai-erp-hero__feature enterprise-ai-erp-hero__feature--{{ $feature['slot'] }}">
              <span class="enterprise-ai-erp-hero__icon">
                @if (filled($feature['icon']))
                  <img
                    src="{{ asset($feature['icon']) }}"
                    alt="{{ $feature['iconAlt'] }}"
                    title="{{ $feature['iconAlt'] }}"
                    width="42"
                    height="42"
                    decoding="async">
                @else
                  <span class="enterprise-ai-erp-hero__icon-placeholder" role="img" aria-label="{{ $feature['iconAlt'] }}"></span>
                @endif
              </span>
              <span class="enterprise-ai-erp-hero__feature-label">{{ $feature['label'] }}</span>
            </li>
          @endforeach
        </ul>
        <div class="enterprise-ai-erp-hero__media">
          @if (filled($heroVisualImage))
            <img
              src="{{ asset($heroVisualImage) }}"
              alt="{{ $visualLabel }}"
              title="{{ $visualLabel }}"
              width="1024"
              height="797"
              fetchpriority="high">
          @else
            <span class="enterprise-ai-erp-hero__image-placeholder" role="img" aria-label="{{ $visualLabel }}"></span>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<section
  class="full-bleed crm-builder-trust-band enterprise-ai-erp-trust"
  id="trust"
  style="background-image: url('{{ asset($trustBackgroundImage) }}');"
  aria-labelledby="enterprise-ai-erp-trust-heading">
  <div class="section-inner">
    <div class="crm-builder-trust">
      <h2 id="enterprise-ai-erp-trust-heading" class="home-type-h2 crm-builder-trust__title enterprise-ai-erp-trust__title">{{ $trustTitle }}</h2>

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
      <div class="crm-builder-tco__mobile-head">
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
        <div class="crm-builder-tco__mobile-head-copy">
          <p class="crm-builder-tco__mobile-head-title">{{ $tco['metricHeading'] }}</p>
        </div>
      </div>
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
                  <svg class="crm-builder-tco__chevron" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                    <path d="M5 7.5 10 12.5 15 7.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </span>
              </th>
              <td class="crm-builder-tco__col--saas">
                <span class="crm-builder-tco__mobile-label">
                  @if (filled($tco['saasIcon']))
                    <img
                      src="{{ asset($tco['saasIcon']) }}"
                      alt="{{ $tco['saasIconAlt'] }}"
                      title="{{ $tco['saasIconAlt'] }}"
                      width="16"
                      height="16"
                      decoding="async">
                  @else
                    <span class="enterprise-ai-erp-tco__icon-placeholder" role="img" aria-label="{{ $tco['saasIconAlt'] }}"></span>
                  @endif
                  <span class="crm-builder-tco__mobile-label-copy">
                    <span class="crm-builder-tco__mobile-label-text">{{ $tco['saasHeading'] }}</span>
                    @if (filled($tco['saasNote']))
                      <span class="crm-builder-tco__mobile-label-note">{{ $tco['saasNote'] }}</span>
                    @endif
                  </span>
                </span>
                <strong class="crm-builder-tco__value crm-builder-tco__value--saas">{{ $row['saasValue'] }}</strong>
                <span class="crm-builder-tco__detail">{{ $row['saasDetail'] }}</span>
              </td>
              <td class="crm-builder-tco__col--custom">
                <span class="crm-builder-tco__mobile-label">
                  @if (filled($tco['customIcon']))
                    <img
                      src="{{ asset($tco['customIcon']) }}"
                      alt="{{ $tco['customIconAlt'] }}"
                      title="{{ $tco['customIconAlt'] }}"
                      width="16"
                      height="16"
                      decoding="async">
                  @else
                    <span class="enterprise-ai-erp-tco__icon-placeholder" role="img" aria-label="{{ $tco['customIconAlt'] }}"></span>
                  @endif
                  <span class="crm-builder-tco__mobile-label-copy">
                    <span class="crm-builder-tco__mobile-label-text">{{ $tco['customHeading'] }}</span>
                    @if (filled($tco['customNote']))
                      <span class="crm-builder-tco__mobile-label-note">{{ $tco['customNote'] }}</span>
                    @endif
                  </span>
                </span>
                <strong class="crm-builder-tco__value crm-builder-tco__value--custom">{{ $row['customValue'] }}</strong>
                <span class="crm-builder-tco__detail">{{ $row['customDetail'] }}</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <button type="button" class="crm-builder-tco__more" aria-expanded="false">
        Read more
        <svg xmlns="http://www.w3.org/2000/svg" class="crm-builder-tco__more-icon" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
          <path d="M5 7.5 10 12.5 15 7.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
      </button>
    </div>
  </div>
</section>

<section
  class="full-bleed enterprise-ai-erp-modules"
  style="background-image: url('{{ asset($modules['backgroundImage']) }}');"
  aria-labelledby="enterprise-ai-erp-modules-heading">
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
              <p class="enterprise-ai-erp-modules__card-copy">
                @if (filled($item['linkLabel'] ?? null) && filled($item['linkRoute'] ?? null) && str_contains($item['copy'], $item['linkLabel']))
                  {!! str_replace(e($item['linkLabel']), '<a href="'.e(route($item['linkRoute'])).'">'.e($item['linkLabel']).'</a>', e($item['copy'])) !!}
                @else
                  {{ $item['copy'] }}
                @endif
              </p>
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

    <div class="enterprise-ai-erp-verticals__stage">
      <div class="enterpriseVerticalsSwiper swiper enterprise-ai-erp-verticals__swiper" aria-label="{{ $verticals['eyebrow'] }}">
        <div class="swiper-wrapper">
          @foreach ($verticals['items'] as $item)
            <div class="swiper-slide">
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
                <p class="enterprise-ai-erp-verticals__text">
                  @if (filled($item['linkLabel'] ?? null) && filled($item['linkRoute'] ?? null) && str_contains($item['architecture'], $item['linkLabel']))
                    {!! str_replace(e($item['linkLabel']), '<a href="'.e(route($item['linkRoute'])).'">'.e($item['linkLabel']).'</a>', e($item['architecture'])) !!}
                  @else
                    {{ $item['architecture'] }}
                  @endif
                </p>
              </article>
            </div>
          @endforeach
        </div>
      </div>

      <div class="enterprise-ai-erp-verticals__nav">
        <button class="enterprise-ai-erp-verticals__control enterprise-ai-erp-verticals__prev" type="button" aria-label="Previous industry">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="enterprise-ai-erp-verticals__control enterprise-ai-erp-verticals__next" type="button" aria-label="Next industry">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
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

<section
  class="full-bleed enterprise-ai-erp-stack"
  style="background-image: url('{{ asset($stack['backgroundImage']) }}');"
  aria-labelledby="enterprise-ai-erp-stack-heading">
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
          @foreach (collect($group['items'])->chunk(2) as $pair)
            <li class="enterprise-ai-erp-stack__pair">
            @foreach ($pair as $item)
            <div class="enterprise-ai-erp-stack__card">
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
            </div>
            @endforeach
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

<section class="full-bleed enterprise-ai-erp-lifecycle" aria-labelledby="enterprise-ai-erp-lifecycle-heading">
  <div class="section-inner enterprise-ai-erp-lifecycle__inner">
    <p class="enterprise-ai-erp-lifecycle__eyebrow">{{ $lifecycle['eyebrow'] }}</p>
    <h2 id="enterprise-ai-erp-lifecycle-heading" class="enterprise-ai-erp-lifecycle__title">{{ $lifecycle['title'] }}</h2>

    <ol class="enterprise-ai-erp-lifecycle__list">
      @foreach ($lifecycle['items'] as $item)
        <li class="enterprise-ai-erp-lifecycle__item">
          <div class="enterprise-ai-erp-lifecycle__rail" aria-hidden="true">
            <span class="enterprise-ai-erp-lifecycle__step">{{ $item['step'] }}</span>
          </div>
          <article class="enterprise-ai-erp-lifecycle__card">
            <div class="enterprise-ai-erp-lifecycle__panel">
              <div class="enterprise-ai-erp-lifecycle__main">
                <div class="enterprise-ai-erp-lifecycle__icon">
                  @if (filled($item['icon']))
                    <img
                      src="{{ asset($item['icon']) }}"
                      alt="{{ $item['iconAlt'] }}"
                      title="{{ $item['iconAlt'] }}"
                      width="28"
                      height="28"
                      loading="lazy"
                      decoding="async">
                  @else
                    <span class="enterprise-ai-erp-lifecycle__icon-placeholder" role="img" aria-label="{{ $item['iconAlt'] }}"></span>
                  @endif
                </div>
                <div class="enterprise-ai-erp-lifecycle__copy">
                  <h3 class="enterprise-ai-erp-lifecycle__card-title">{{ $item['title'] }}</h3>
                  <p class="enterprise-ai-erp-lifecycle__text">{{ $item['copy'] }}</p>
                </div>
              </div>
              <div class="enterprise-ai-erp-lifecycle__deliverable">
                <p class="enterprise-ai-erp-lifecycle__deliverable-label">Deliverable</p>
                <p class="enterprise-ai-erp-lifecycle__deliverable-text">{{ $item['deliverable'] }}</p>
              </div>
            </div>
          </article>
        </li>
      @endforeach
    </ol>
  </div>
</section>

<x-frontend.faq-section
  id="faq"
  :qa="$faq['items']"
  :media="null"
  :show-cta="false"
  :eyebrow="$faq['eyebrow']"
  :title="$faq['title']"
  :description="$faq['description']"
  heading-id="enterprise-ai-erp-faq-heading"
  question-heading="h3"
  class="faq-section--crm-builder bg-cover bg-top bg-no-repeat"
  style="background-image: url('{{ asset($faq['backgroundImage']) }}')"
/>

<section class="full-bleed enterprise-ai-erp-evidence" aria-labelledby="enterprise-ai-erp-evidence-heading">
  <div class="section-inner enterprise-ai-erp-evidence__inner">
    <p class="enterprise-ai-erp-evidence__eyebrow">{{ $evidence['eyebrow'] }}</p>
    <h2 id="enterprise-ai-erp-evidence-heading" class="enterprise-ai-erp-evidence__title">{{ $evidence['title'] }}</h2>

    <div class="enterprise-ai-erp-evidence__stage">
      <div class="enterpriseEvidenceSwiper swiper enterprise-ai-erp-evidence__swiper" aria-label="{{ $evidence['eyebrow'] }}">
        <div class="swiper-wrapper">
          @foreach ($evidence['items'] as $item)
            <div class="swiper-slide">
              <article class="enterprise-ai-erp-evidence__card">
                <div class="enterprise-ai-erp-evidence__icon">
                  @if (filled($item['icon']))
                    <img
                      src="{{ asset($item['icon']) }}"
                      alt="{{ $item['iconAlt'] }}"
                      title="{{ $item['iconAlt'] }}"
                      width="24"
                      height="24"
                      loading="lazy"
                      decoding="async">
                  @else
                    <span class="enterprise-ai-erp-evidence__icon-placeholder" role="img" aria-label="{{ $item['iconAlt'] }}"></span>
                  @endif
                </div>
                <h3 class="enterprise-ai-erp-evidence__card-title">{{ $item['title'] }}</h3>
                <p class="enterprise-ai-erp-evidence__value">{{ $item['value'] }}</p>
                <p class="enterprise-ai-erp-evidence__label">{{ $item['label'] }}</p>
                <p class="enterprise-ai-erp-evidence__copy">{{ $item['copy'] }}</p>
              </article>
            </div>
          @endforeach
        </div>
      </div>

      <div class="enterprise-ai-erp-evidence__nav">
        <button class="enterprise-ai-erp-evidence__control enterprise-ai-erp-evidence__prev" type="button" aria-label="Previous software system">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="enterprise-ai-erp-evidence__control enterprise-ai-erp-evidence__next" type="button" aria-label="Next software system">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
    </div>
  </div>
</section>

<x-frontend.consultation-section
  :eyebrow="$consultation['eyebrow']"
  :title="$consultation['title']"
  :description="$consultation['description']"
  :cta-label="$consultation['ctaLabel']"
  :secondary-cta-label="$consultation['secondaryCtaLabel']"
  :secondary-cta-href="route('custom-crm-builder')"
  :card-position="$consultation['cardPosition']"
  :people="$consultation['people']"
  :allow-html-title="false"
/>

<section
  class="full-bleed partnership-section crm-builder-partners bg-repeat"
  style="background-image: url('{{ asset('assets/background/portfolio-section-pattern-bg.png') }}');"
  aria-label="Our Partnerships and Growth Stack">
  <div class="partnership-inner section-inner text-center">
    <p class="crm-builder-partners__heading">
      <span>Our Partnerships &amp; Growth Stack</span>
    </p>
    <ul class="partnership-grid">
      @foreach ($partnerLogos as $partner)
        <li class="partnership-tile">
          <img
            src="{{ asset($partner['src']) }}"
            alt="{{ $partner['alt'] }}"
            title="{{ $partner['alt'] }}"
            width="160"
            height="42"
            loading="lazy"
            decoding="async">
        </li>
      @endforeach
    </ul>
  </div>
</section>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var panel = document.querySelector('.enterprise-ai-erp-tco .crm-builder-tco__panel');
    var button = panel ? panel.querySelector('.crm-builder-tco__more') : null;
    if (!panel || !button) return;

    button.addEventListener('click', function () {
      panel.classList.add('is-expanded');
      button.setAttribute('aria-expanded', 'true');
    });
  });
</script>
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

    document.querySelectorAll('.enterpriseVerticalsSwiper:not(.swiper-initialized)').forEach(function (el) {
      var root = el.closest('.enterprise-ai-erp-verticals');
      if (!root) return;

      new Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 0,
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
          nextEl: root.querySelector('.enterprise-ai-erp-verticals__next'),
          prevEl: root.querySelector('.enterprise-ai-erp-verticals__prev')
        },
        a11y: {
          prevSlideMessage: 'Previous industry',
          nextSlideMessage: 'Next industry',
          containerMessage: 'Vertical industry specialization carousel'
        },
        breakpoints: {
          768: { slidesPerView: 2, spaceBetween: 0 },
          1200: { slidesPerView: 3, spaceBetween: 0 }
        }
      });
    });

    document.querySelectorAll('.enterpriseEvidenceSwiper:not(.swiper-initialized)').forEach(function (el) {
      var root = el.closest('.enterprise-ai-erp-evidence');
      if (!root) return;

      new Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 550,
        rewind: true,
        allowTouchMove: true,
        simulateTouch: true,
        grabCursor: true,
        watchOverflow: false,
        keyboard: {
          enabled: true,
          onlyInViewport: true
        },
        navigation: {
          nextEl: root.querySelector('.enterprise-ai-erp-evidence__next'),
          prevEl: root.querySelector('.enterprise-ai-erp-evidence__prev')
        },
        a11y: {
          prevSlideMessage: 'Previous software system',
          nextSlideMessage: 'Next software system',
          containerMessage: 'Evidence-based software systems carousel'
        },
        breakpoints: {
          768: { slidesPerView: 2, spaceBetween: 0 },
          1200: { slidesPerView: 3, spaceBetween: 0 }
        }
      });
    });
  });
</script>
@endpush
