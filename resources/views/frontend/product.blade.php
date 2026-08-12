@extends('layouts.frontend')

@push('custom-css')
<link rel="preload" as="image" href="{{ $heroBackground }}" type="image/webp">
<link rel="preload" as="image" href="{{ $heroBanner['src'] }}" type="image/gif">
@endpush

@section('content')

<div class="product-page">

  <div
    class="product-top-shell"
    style="background-image: url('{{ $heroBackground }}')"
  >
    <section class="product-hero product-hero--outreach" id="hero" aria-labelledby="product-hero-heading">
      <div class="container product-hero__container">
   <span class="product-hero__badge">
     <img src="{{ asset('assets/product/ai.png') }}" alt="AI powered sales CRM badge icon for Suave outreach platform" title="AI powered sales CRM badge icon for Suave outreach platform" class="product-hero__badge-icon">
     <span class="product-hero__badge-text">{{ $heroBadge }}</span>
   </span>

        <div class="product-hero__headline-wrap">
          <h1 id="product-hero-heading" class="product-hero__title">
            <span class="product-hero__title-line">
              <span class="product-hero__title-accent">AI-Powered Outreach</span>
            </span>
            <span class="product-hero__title-line">
              <span class="product-hero__title-accent">built</span><span class="product-hero__title-soft"> for growing</span>
            </span>
            <span class="product-hero__title-line product-hero__title-soft">teams</span>
          </h1>
        </div>

        <p class="product-hero__subtitle">
          Suave CRM helps you discover the right companies, brief them with Suave AI, and send cold
          email with S-Mail, so every first touch earns a reply. Optional work add-ons are ready when
          delivery work needs them. Thanks to AI, of course.
        </p>

        <div class="product-hero__actions">
          <a href="{{ $contactHref }}" class="product-btn product-btn--primary" target="_blank" rel="noopener noreferrer">
            Start Free Trial <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
          <a href="{{ $demoHref }}" class="product-btn product-btn--secondary product-btn--ghost" target="_blank" rel="noopener noreferrer">
            Book Your Demo <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
        </div>

        <hr class="product-hero__divider" aria-hidden="true">

        <div class="product-hero__chips">
          @foreach ($heroChips as $chip)
            <div class="product-hero__chip">
              <span class="product-hero__chip-icon">
                <img src="{{ $chip['icon'] }}" alt="{{ $chip['alt'] }}" title="{{ $chip['alt'] }}" loading="lazy" decoding="async">
              </span>
              <span class="product-hero__chip-label">{{ $chip['label'] }}</span>
            </div>
          @endforeach
        </div>

        <div class="product-hero__banner">
          <img
            src="{{ $heroBanner['backSrc'] }}"
            alt="{{ $heroBanner['backAlt'] }}"
            title="{{ $heroBanner['backAlt'] }}"
            class="product-hero__banner-back"
            width="1006"
            height="498"
            decoding="async"
            loading="lazy"
            aria-hidden="true"
          >
          <div class="product-hero__banner-stage">
            <img
              src="{{ $heroBanner['src'] }}"
              alt="{{ $heroBanner['alt'] }}"
              title="{{ $heroBanner['alt'] }}"
              class="product-hero__banner-gif"
              width="796"
              height="448"
              decoding="async"
              fetchpriority="high"
            >
            @foreach ($heroBannerTiles as $tile)
              <div class="product-hero__banner-tile product-hero__banner-tile--{{ $tile['position'] }}" aria-hidden="true">
                @switch($tile['type'])
                  @case('lead')
                    <img
                      src="{{ $tile['src'] }}"
                      alt="{{ $tile['alt'] }}"
                      title="{{ $tile['alt'] }}"
                      class="product-hero__banner-tile-image"
                      width="240"
                      height="138"
                      decoding="async"
                      loading="lazy"
                    >
                    @break
                  @case('follow-up')
                    <div class="product-hero__banner-tile-card product-hero__banner-tile-card--follow-up">
                      <div class="product-hero__banner-tile-head product-hero__banner-tile-head--follow-up">
                        <span class="product-hero__banner-tile-icon product-hero__banner-tile-icon--square">
                          <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        </span>
                        <span class="product-hero__banner-tile-title product-hero__banner-tile-title--follow-up">{{ $tile['title'] }}</span>
                      </div>
                      <p class="product-hero__banner-tile-copy">{{ $tile['description'] }}</p>
                    </div>
                    @break
                  @case('deal-won')
                    <img
                      src="{{ $tile['src'] }}"
                      alt="{{ $tile['alt'] }}"
                      title="{{ $tile['alt'] }}"
                      class="product-hero__banner-tile-image"
                      width="210"
                      height="230"
                      decoding="async"
                      loading="lazy"
                    >
                    @break
                  @case('companies')
                    <img
                      src="{{ $tile['src'] }}"
                      alt="{{ $tile['alt'] }}"
                      title="{{ $tile['alt'] }}"
                      class="product-hero__banner-tile-image"
                      width="340"
                      height="150"
                      decoding="async"
                      loading="lazy"
                    >
                    @break
                @endswitch
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>

    <section class="product-how-it-works" id="how-it-works" aria-labelledby="how-it-works-heading">
      <div class="container product-how-it-works__container">
        <div class="product-how-it-works__header">
          <span class="product-how-it-works__badge">How It Works</span>
          <h2 id="how-it-works-heading" class="product-how-it-works__title">
            Simple Steps, <span class="product-how-it-works__title-accent">Powerful Results</span>
          </h2>
          <p class="product-how-it-works__subtitle">
            From lead capture to deal closure, manage every stage with one intelligent AI-powered Sales CRM.
          </p>
        </div>

        <div class="product-how-it-works__grid">
          @foreach ($howItWorksSteps as $step)
            <article class="product-how-it-works__card">
              <div class="product-how-it-works__icon">
                <img src="{{ $step['icon'] }}" alt="{{ $step['alt'] }}" title="{{ $step['alt'] }}" loading="lazy" decoding="async">
              </div>
              <h3>{{ $step['title'] }}</h3>
              <p>{{ $step['description'] }}</p>
            </article>
          @endforeach
        </div>
      </div>
    </section>
  </div>

  <section class="product-add-ons" id="add-ons" aria-labelledby="add-ons-heading">
    <div class="container product-add-ons__container">
      <div class="product-add-ons__header">
        <span class="product-add-ons__badge">Add-Ons</span>
        <h2 id="add-ons-heading" class="product-add-ons__title">
          Work Management <span class="product-add-ons__title-accent">Add-Ons when you need them</span>
        </h2>
        <p class="product-add-ons__subtitle">
          Outreach + Suave AI + S-Mail stay at the center. Enable these modules only for the delivery
          work your team actually runs — no CRM bloat by default.
        </p>
      </div>

      <div class="product-add-ons__grid">
        @foreach ($addOns as $addon)
          <article class="product-add-ons__card">
            <div class="product-add-ons__icon">
              <img src="{{ $addon['icon'] }}" alt="{{ $addon['alt'] }}" title="{{ $addon['alt'] }}" loading="lazy" decoding="async">
            </div>
            <h3>{{ $addon['title'] }}</h3>
            <p>{{ $addon['description'] }}</p>
          </article>
        @endforeach
      </div>

      <div class="product-add-ons__cta">
        <a href="{{ $contactHref }}" class="product-add-ons__link" target="_blank" rel="noopener noreferrer">
          Ask which add-ons fit your team
          <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </section>

  <section class="product-business-works" id="business-works" aria-labelledby="business-works-heading">
    <div class="container product-business-works__container">
      <div class="product-business-works__header">
        <span class="product-business-works__badge">{{ $businessWorks['badge'] }}</span>
        <h2 id="business-works-heading" class="product-business-works__title">
          {{ $businessWorks['title'] }}
          <span class="product-business-works__title-accent">{{ $businessWorks['titleAccent'] }}</span>
        </h2>
        <p class="product-business-works__subtitle">{{ $businessWorks['subtitle'] }}</p>
      </div>

      <div class="product-business-works__grid">
        @foreach ($businessWorks['cards'] as $card)
          <article class="product-business-works__card">
            <div class="product-business-works__head">
              <div class="product-business-works__icon">
                <img src="{{ $card['icon'] }}" alt="{{ $card['alt'] }}" title="{{ $card['alt'] }}" loading="lazy" decoding="async">
              </div>
              <div class="product-business-works__body">
                <h3>{{ $card['title'] }}</h3>
                <p>{{ $card['description'] }}</p>
              </div>
            </div>

            @if ($card['footerType'] === 'integrations')
              <div class="product-business-works__integrations">
                @foreach ($card['integrations'] as $integration)
                  <span class="product-business-works__integration-item">
                    <img
                      src="{{ $integration['src'] }}"
                      alt="{{ $integration['alt'] }}"
                      title="{{ $integration['alt'] }}"
                      width="22"
                      height="22"
                      decoding="async"
                      loading="lazy"
                    >
                  </span>
                  @foreach ($integration['tags'] ?? [] as $tag)
                    <span class="product-business-works__tag">{{ $tag }}</span>
                  @endforeach
                @endforeach
              </div>
            @elseif ($card['footerType'] === 'tags')
              <div class="product-business-works__tags">
                @foreach ($card['tags'] as $tag)
                  <span class="product-business-works__tag">{{ $tag }}</span>
                @endforeach
              </div>
            @endif
          </article>
        @endforeach
      </div>

      <div class="product-business-works__cta">
        <a href="{{ $demoHref }}" class="product-btn product-business-works__btn" target="_blank" rel="noopener noreferrer">
          Book Your Demo <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </section>

  <section
    class="product-data-privacy"
    id="data-privacy"
    aria-labelledby="data-privacy-heading"
    style="background-image: url('{{ $dataPrivacy['background'] }}')"
  >
    <div class="container product-data-privacy__container">
      <div class="product-data-privacy__grid">
        <div class="product-data-privacy__content">
          <span class="product-data-privacy__badge">{{ $dataPrivacy['badge'] }}</span>
          <h2 id="data-privacy-heading" class="product-data-privacy__title">
            <span class="product-data-privacy__title-line product-data-privacy__title-line--soft">{{ $dataPrivacy['titleLine1'] }}</span>
            <span class="product-data-privacy__title-line product-data-privacy__title-line--bright">{{ $dataPrivacy['titleLine2'] }}</span>
          </h2>
          <p class="product-data-privacy__description">{{ $dataPrivacy['description'] }}</p>

          <ul class="product-data-privacy__list">
            @foreach ($dataPrivacy['bullets'] as $bullet)
              <li>
                <span class="product-data-privacy__check" aria-hidden="true">
                  <i class="fa-solid fa-check"></i>
                </span>
                <span>{{ $bullet }}</span>
              </li>
            @endforeach
          </ul>

          <div class="product-data-privacy__links">
            @foreach ($dataPrivacy['links'] as $link)
              <a
                href="{{ $link['href'] }}"
                class="product-data-privacy__link"
                @if ($link['external']) target="_blank" rel="noopener noreferrer" @endif
              >
                {{ $link['label'] }}
              </a>
            @endforeach
          </div>
        </div>

        <div class="product-data-privacy__visual">
          <img
            src="{{ $dataPrivacy['graphic']['src'] }}"
            alt="{{ $dataPrivacy['graphic']['alt'] }}"
            title="{{ $dataPrivacy['graphic']['alt'] }}"
            width="640"
            height="640"
            decoding="async"
            loading="lazy"
          >
        </div>
      </div>
    </div>
  </section>

  <section class="product-case-study" id="case-study" aria-labelledby="case-study-heading">
    <div class="container product-case-study__container">
      <header class="product-case-study__header">
        <span class="product-case-study__badge">{{ $caseStudy['badge'] }}</span>
        <h2 id="case-study-heading" class="product-case-study__title">
          {{ $caseStudy['titlePrefix'] }}
          <span class="product-case-study__title-accent">{{ $caseStudy['titleAccent'] }}</span>
        </h2>
        <p class="product-case-study__subtitle">{{ $caseStudy['subtitle'] }}</p>
      </header>

      <article class="product-case-study__card">
        <div class="product-case-study__body">
          <div class="product-case-study__story">
            <div class="product-case-study__brand">
              <img
                src="{{ $caseStudy['logo']['src'] }}"
                alt="{{ $caseStudy['logo']['alt'] }}"
                title="{{ $caseStudy['logo']['alt'] }}"
                width="120"
                height="40"
                decoding="async"
                loading="lazy"
              >
              <div class="product-case-study__tags">
                @foreach ($caseStudy['tags'] as $tag)
                  <span class="product-case-study__tag">
                    <i class="fa-solid {{ $tag['icon'] }}" aria-hidden="true"></i>
                    {{ $tag['label'] }}
                  </span>
                @endforeach
              </div>
            </div>

            <p class="product-case-study__intro">{{ $caseStudy['intro'] }}</p>

            <div class="product-case-study__block">
              <h3 class="product-case-study__block-title product-case-study__block-title--challenge">
                {{ $caseStudy['challenge']['title'] }}
              </h3>
              @if (! empty($caseStudy['challenge']['intro']))
                <p class="product-case-study__block-intro">{{ $caseStudy['challenge']['intro'] }}</p>
              @endif
              <ul class="product-case-study__list product-case-study__list--challenge">
                @foreach ($caseStudy['challenge']['items'] as $item)
                  <li>{{ $item }}</li>
                @endforeach
              </ul>
            </div>

            <div class="product-case-study__block">
              <h3 class="product-case-study__block-title product-case-study__block-title--solution">
                {{ $caseStudy['solution']['title'] }}
              </h3>
              <p class="product-case-study__block-intro">{{ $caseStudy['solution']['intro'] }}</p>
              @if (! empty($caseStudy['solution']['itemsIntro']))
                <p class="product-case-study__block-intro">{{ $caseStudy['solution']['itemsIntro'] }}</p>
              @endif
              <ul class="product-case-study__list product-case-study__list--solution">
                @foreach ($caseStudy['solution']['items'] as $item)
                  <li>{{ $item }}</li>
                @endforeach
              </ul>
            </div>
          </div>

          <div class="product-case-study__results">
            <div class="product-case-study__metrics">
              @foreach ($caseStudy['metrics'] as $metric)
                <article @class([
                  'product-case-study__metric',
                  'product-case-study__metric--' . $metric['tone'],
                  'product-case-study__metric--has-chart' => ! empty($metric['chart']),
                  'product-case-study__metric--has-chart-strip' => ! empty($metric['chart']) && ($metric['chartVariant'] ?? 'strip') === 'strip',
                  'product-case-study__metric--has-chart-full' => ! empty($metric['chart']) && ($metric['chartVariant'] ?? 'strip') === 'full',
                ])>
                  <div class="product-case-study__metric-icon">
                    <img
                      src="{{ $metric['icon'] }}"
                      alt="{{ $metric['alt'] }}"
                      title="{{ $metric['alt'] }}"
                      width="20"
                      height="20"
                      decoding="async"
                      loading="lazy"
                    >
                  </div>
                  <p class="product-case-study__metric-value">{{ $metric['value'] }}</p>
                  <p class="product-case-study__metric-label">{{ $metric['label'] }}</p>
                  <p class="product-case-study__metric-caption">{{ $metric['caption'] }}</p>
                  <div
                    @class([
                      'product-case-study__metric-chart',
                      'product-case-study__metric-chart--image' => ! empty($metric['chart']),
                      'product-case-study__metric-chart--strip' => ! empty($metric['chart']) && ($metric['chartVariant'] ?? 'strip') === 'strip',
                      'product-case-study__metric-chart--full' => ! empty($metric['chart']) && ($metric['chartVariant'] ?? 'strip') === 'full',
                    ])
                    aria-hidden="true"
                    @if (! empty($metric['chart']))
                      style="background-image: url('{{ $metric['chart'] }}')"
                    @endif
                  ></div>
                </article>
              @endforeach
            </div>

            <figure class="product-case-study__testimonial">
              <blockquote class="product-case-study__quote">
                <img
                  class="product-case-study__quote-mark"
                  src="{{ $caseStudy['quoteMark']['src'] }}"
                  alt="{{ $caseStudy['quoteMark']['alt'] }}"
                  title="{{ $caseStudy['quoteMark']['alt'] }}"
                  width="48"
                  height="48"
                  decoding="async"
                  loading="lazy"
                  aria-hidden="true"
                >
                <p class="product-case-study__quote-text">{{ $caseStudy['testimonial']['quote'] }}</p>
                <img
                  class="product-case-study__quote-avatar"
                  src="{{ $caseStudy['testimonial']['avatar']['src'] }}"
                  alt="{{ $caseStudy['testimonial']['avatar']['alt'] }}"
                  title="{{ $caseStudy['testimonial']['avatar']['alt'] }}"
                  width="48"
                  height="48"
                  decoding="async"
                  loading="lazy"
                >
                <footer class="product-case-study__quote-meta">
                  <strong>{{ $caseStudy['testimonial']['name'] }}</strong>
                  <span>
                    {{ $caseStudy['testimonial']['role'] }} |
                    <span class="product-case-study__quote-company">{{ $caseStudy['testimonial']['company'] }}</span>
                  </span>
                </footer>
              </blockquote>
            </figure>
          </div>
        </div>
      </article>

      <div class="product-case-study__cta">
        <div class="product-case-study__cta-copy">
          <h3>{{ $caseStudy['cta']['title'] }}</h3>
          <p>{{ $caseStudy['cta']['description'] }}</p>
        </div>
        <a href="{{ $demoHref }}" class="product-btn product-btn--primary product-case-study__cta-btn" target="_blank" rel="noopener noreferrer">
          {{ $caseStudy['cta']['button'] }}
          <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </section>

  <section
    class="product-sales-cta"
    id="sales-cta"
    aria-labelledby="sales-cta-heading"
    style="background-image: url('{{ $salesCta['background'] }}')"
  >
    <div class="container product-sales-cta__container">
      <div class="product-sales-cta__shell">
        <aside class="product-sales-cta__float product-sales-cta__float--deal" aria-hidden="true">
          <div class="product-sales-cta__deal-card">
            <div class="product-sales-cta__deal-head">
              <img
                src="{{ $salesCta['dealCard']['avatar']['src'] }}"
                alt="{{ $salesCta['dealCard']['avatar']['alt'] }}"
                title="{{ $salesCta['dealCard']['avatar']['alt'] }}"
                width="32"
                height="32"
                decoding="async"
                loading="lazy"
              >
              <span>{{ $salesCta['dealCard']['title'] }} 🎉</span>
            </div>
            <p class="product-sales-cta__deal-company">{{ $salesCta['dealCard']['company'] }}</p>
            <p class="product-sales-cta__deal-amount">{{ $salesCta['dealCard']['amount'] }}</p>
            <p class="product-sales-cta__deal-category">{{ $salesCta['dealCard']['category'] }}</p>
            <div class="product-sales-cta__deal-chart">
              <img
                src="{{ $salesCta['dealCard']['chart']['src'] }}"
                alt="{{ $salesCta['dealCard']['chart']['alt'] }}"
                title="{{ $salesCta['dealCard']['chart']['alt'] }}"
                width="224"
                height="125"
                decoding="async"
                loading="lazy"
              >
            </div>
          </div>
        </aside>

        <div class="product-sales-cta__content">
          <span class="product-sales-cta__badge">{{ $salesCta['badge'] }}</span>
          <h2 id="sales-cta-heading" class="product-sales-cta__title">
            <span class="product-sales-cta__title-lead">{{ $salesCta['titleLead'] }}</span><span class="product-sales-cta__title-build">{{ $salesCta['titleBuild'] }}</span>
            <span class="product-sales-cta__title-accent">{{ $salesCta['titleAccent'] }}</span>
          </h2>
          <p class="product-sales-cta__description">{{ $salesCta['description'] }}</p>
          <a href="{{ $demoHref }}" class="product-btn product-btn--primary product-sales-cta__btn" target="_blank" rel="noopener noreferrer">
            {{ $salesCta['button'] }}
            <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
          <p class="product-sales-cta__service-link">
            Built by Suave Creators &mdash; <a href="{{ route('service.show', 'custom-crm-development') }}">custom CRM development experts</a>
          </p>
        </div>

        <aside class="product-sales-cta__float product-sales-cta__float--insight" aria-hidden="true">
          <div class="product-sales-cta__insight-card">
            <div class="product-sales-cta__insight-head">
              <span class="product-sales-cta__insight-icon">
                <img
                  src="{{ $salesCta['insightCard']['icon']['src'] }}"
                  alt="{{ $salesCta['insightCard']['icon']['alt'] }}"
                  title="{{ $salesCta['insightCard']['icon']['alt'] }}"
                  width="20"
                  height="20"
                  decoding="async"
                  loading="lazy"
                >
              </span>
              <strong>{{ $salesCta['insightCard']['title'] }}</strong>
            </div>
            <p>{{ $salesCta['insightCard']['description'] }}</p>
          </div>
        </aside>
      </div>
    </div>
  </section>

</div>

@endsection
