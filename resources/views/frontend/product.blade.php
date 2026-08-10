@extends('layouts.frontend')

@section('content')

<div class="product-page">

  <div
    class="product-top-shell"
    style="background-image: url('{{ $heroBackground }}')"
  >
    <section class="product-hero product-hero--outreach" id="hero">
      <div class="container product-hero__container">
        <span class="product-hero__badge">{{ $heroBadge }}</span>

        <div class="product-hero__headline-wrap">
          @foreach ($heroFloatingStats as $stat)
            <div class="product-hero__float-card product-hero__float-card--{{ $stat['position'] }}">
              <img
                src="{{ $stat['src'] }}"
                alt="{{ $stat['alt'] }}"
                title="{{ $stat['alt'] }}"
                width="220"
                height="120"
                decoding="async"
              >
            </div>
          @endforeach

          <h1 class="product-hero__title">
            <span class="product-hero__title-line">
              <span class="product-hero__title-accent">AI-Powered Outreach</span>
            </span>
            <span class="product-hero__title-line">
              <span class="product-hero__title-accent">built</span> for growing
            </span>
            <span class="product-hero__title-line">teams</span>
          </h1>
        </div>

        <p class="product-hero__subtitle">
          Suave CRM helps you discover the right companies, brief them with Suave AI, and send cold
          email with S-Mail, so every first touch earns a reply. Optional work add-ons are ready when
          delivery work needs them. Thanks to AI, of course.
        </p>

        <div class="product-hero__actions">
          <a href="{{ $contactHref }}" class="product-btn product-btn--primary">
            Start Free Trial <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
          <a href="{{ $contactHref }}" class="product-btn product-btn--secondary product-btn--ghost">
            Book Your Demo <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
        </div>

        <div class="product-hero__chips">
          @foreach ($heroChips as $chip)
            <div class="product-hero__chip">
              <span class="product-hero__chip-icon">
                <img src="{{ $chip['icon'] }}" alt="{{ $chip['alt'] }}" title="{{ $chip['alt'] }}">
              </span>
              <span class="product-hero__chip-label">{{ $chip['label'] }}</span>
            </div>
          @endforeach
        </div>

        <div class="product-hero__banner">
          <img
            src="{{ $heroBanner['src'] }}"
            alt="{{ $heroBanner['alt'] }}"
            title="{{ $heroBanner['alt'] }}"
            width="1200"
            height="675"
            decoding="async"
          >
        </div>
      </div>
    </section>

    <section class="product-how-it-works" id="how-it-works">
      <div class="container product-how-it-works__container">
        <div class="product-how-it-works__header">
          <span class="product-how-it-works__badge">How It Works</span>
          <h2 class="product-how-it-works__title">
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
                <img src="{{ $step['icon'] }}" alt="{{ $step['alt'] }}" title="{{ $step['alt'] }}">
              </div>
              <h3>{{ $step['title'] }}</h3>
              <p>{{ $step['description'] }}</p>
            </article>
          @endforeach
        </div>
      </div>
    </section>
  </div>

  <section class="product-add-ons" id="add-ons">
    <div class="container product-add-ons__container">
      <div class="product-add-ons__header">
        <span class="product-add-ons__badge">Add-Ons</span>
        <h2 class="product-add-ons__title">
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
              <img src="{{ $addon['icon'] }}" alt="{{ $addon['alt'] }}" title="{{ $addon['alt'] }}">
            </div>
            <h3>{{ $addon['title'] }}</h3>
            <p>{{ $addon['description'] }}</p>
          </article>
        @endforeach
      </div>

      <div class="product-add-ons__cta">
        <a href="{{ $contactHref }}" class="product-add-ons__link">
          Ask which add-ons fit your team
          <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </section>

  <section class="product-business-works" id="business-works">
    <div class="container product-business-works__container">
      <div class="product-business-works__header">
        <span class="product-business-works__badge">{{ $businessWorks['badge'] }}</span>
        <h2 class="product-business-works__title">
          {{ $businessWorks['title'] }}
          <span class="product-business-works__title-accent">{{ $businessWorks['titleAccent'] }}</span>
        </h2>
        <p class="product-business-works__subtitle">{{ $businessWorks['subtitle'] }}</p>
      </div>

      <div class="product-business-works__grid">
        @foreach ($businessWorks['cards'] as $card)
          <article class="product-business-works__card">
            <div class="product-business-works__icon">
              <img src="{{ $card['icon'] }}" alt="{{ $card['alt'] }}" title="{{ $card['alt'] }}">
            </div>
            <h3>{{ $card['title'] }}</h3>
            <p>{{ $card['description'] }}</p>

            @if ($card['footerType'] === 'integrations')
              <div class="product-business-works__integrations">
                @foreach ($card['integrations'] as $integration)
                  <img
                    src="{{ $integration['src'] }}"
                    alt="{{ $integration['alt'] }}"
                    title="{{ $integration['alt'] }}"
                    width="24"
                    height="24"
                    decoding="async"
                  >
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
        <a href="{{ $contactHref }}" class="product-btn product-business-works__btn">
          Book Your Demo <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </section>

  <section
    class="product-data-privacy"
    id="data-privacy"
    style="background-image: url('{{ $dataPrivacy['background'] }}')"
  >
    <div class="container product-data-privacy__container">
      <div class="product-data-privacy__grid">
        <div class="product-data-privacy__content">
          <span class="product-data-privacy__badge">{{ $dataPrivacy['badge'] }}</span>
          <h2 class="product-data-privacy__title">
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
          >
        </div>
      </div>
    </div>
  </section>

  <section class="product-case-study" id="case-study">
    <div class="container product-case-study__container">
      <header class="product-case-study__header">
        <span class="product-case-study__badge">{{ $caseStudy['badge'] }}</span>
        <h2 class="product-case-study__title">
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
              <ul class="product-case-study__list">
                @foreach ($caseStudy['challenge']['items'] as $item)
                  <li>{{ $item }}</li>
                @endforeach
              </ul>
            </div>

            <div class="product-case-study__block">
              <h3 class="product-case-study__block-title product-case-study__block-title--solution">
                {{ $caseStudy['solution']['title'] }}
              </h3>
              <p class="product-case-study__solution-intro">{{ $caseStudy['solution']['intro'] }}</p>
              <ul class="product-case-study__list">
                @foreach ($caseStudy['solution']['items'] as $item)
                  <li>{{ $item }}</li>
                @endforeach
              </ul>
            </div>
          </div>

          <div class="product-case-study__results">
            <div class="product-case-study__metrics">
              @foreach ($caseStudy['metrics'] as $metric)
                <article class="product-case-study__metric product-case-study__metric--{{ $metric['tone'] }}">
                  <div class="product-case-study__metric-icon">
                    <img
                      src="{{ $metric['icon'] }}"
                      alt="{{ $metric['alt'] }}"
                      title="{{ $metric['alt'] }}"
                      width="20"
                      height="20"
                      decoding="async"
                    >
                  </div>
                  <p class="product-case-study__metric-value">{{ $metric['value'] }}</p>
                  <p class="product-case-study__metric-label">{{ $metric['label'] }}</p>
                  <p class="product-case-study__metric-caption">{{ $metric['caption'] }}</p>
                  <div class="product-case-study__metric-chart" aria-hidden="true"></div>
                </article>
              @endforeach
            </div>

            <blockquote class="product-case-study__quote">
              <span class="product-case-study__quote-mark" aria-hidden="true">&ldquo;</span>
              <p>{{ $caseStudy['testimonial']['quote'] }}</p>
              <footer class="product-case-study__quote-author">
                <img
                  src="{{ $caseStudy['testimonial']['avatar']['src'] }}"
                  alt="{{ $caseStudy['testimonial']['avatar']['alt'] }}"
                  title="{{ $caseStudy['testimonial']['avatar']['alt'] }}"
                  width="48"
                  height="48"
                  decoding="async"
                >
                <span class="product-case-study__quote-meta">
                  <strong>{{ $caseStudy['testimonial']['name'] }}</strong>
                  <span>
                    {{ $caseStudy['testimonial']['role'] }} |
                    <span class="product-case-study__quote-company">{{ $caseStudy['testimonial']['company'] }}</span>
                  </span>
                </span>
              </footer>
            </blockquote>
          </div>
        </div>

        <div class="product-case-study__cta">
          <div class="product-case-study__cta-copy">
            <h3>{{ $caseStudy['cta']['title'] }}</h3>
            <p>{{ $caseStudy['cta']['description'] }}</p>
          </div>
          <a href="{{ $contactHref }}" class="product-btn product-btn--primary product-case-study__cta-btn">
            {{ $caseStudy['cta']['button'] }}
            <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
        </div>
      </article>
    </div>
  </section>

  <section class="product-sales-cta" id="sales-cta">
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
              >
              <span>{{ $salesCta['dealCard']['title'] }} 🎉</span>
            </div>
            <p class="product-sales-cta__deal-company">{{ $salesCta['dealCard']['company'] }}</p>
            <p class="product-sales-cta__deal-amount">{{ $salesCta['dealCard']['amount'] }}</p>
            <p class="product-sales-cta__deal-category">{{ $salesCta['dealCard']['category'] }}</p>
            <div class="product-sales-cta__deal-chart"></div>
          </div>
        </aside>

        <div class="product-sales-cta__content">
          <span class="product-sales-cta__badge">{{ $salesCta['badge'] }}</span>
          <h2 class="product-sales-cta__title">
            {{ $salesCta['titlePrefix'] }}
            <span class="product-sales-cta__title-accent">{{ $salesCta['titleAccent'] }}</span>
          </h2>
          <p class="product-sales-cta__description">{{ $salesCta['description'] }}</p>
          <a href="{{ $contactHref }}" class="product-btn product-btn--primary product-sales-cta__btn">
            {{ $salesCta['button'] }}
            <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
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

  <section class="product-pricing-offer" id="pricing">
    <div class="container product-pricing-offer__container">
      <header class="product-pricing-offer__header">
        <span class="product-pricing-offer__badge">{{ $pricing['badge'] }}</span>
        <h2 class="product-pricing-offer__title">
          {{ $pricing['titlePrefix'] }}
          <span class="product-pricing-offer__title-accent">{{ $pricing['titleAccent'] }}</span>
        </h2>
        <p class="product-pricing-offer__subtitle">{{ $pricing['subtitle'] }}</p>
      </header>

      <div class="product-pricing-offer__grid">
        @foreach ($pricing['plans'] as $plan)
          <article @class([
            'product-pricing-offer__plan',
            'product-pricing-offer__plan--featured' => $plan['featured'],
          ])>
            @if ($plan['featured'])
              <span class="product-pricing-offer__plan-badge">Most Popular</span>
            @endif

            <div class="product-pricing-offer__plan-icon product-pricing-offer__plan-icon--{{ $plan['tone'] }}">
              <img
                src="{{ $plan['icon'] }}"
                alt="{{ $plan['alt'] }}"
                title="{{ $plan['alt'] }}"
                width="24"
                height="24"
                decoding="async"
              >
            </div>

            <h3 class="product-pricing-offer__plan-name">{{ $plan['name'] }}</h3>
            <p class="product-pricing-offer__plan-tagline">{{ $plan['tagline'] }}</p>

            <div class="product-pricing-offer__plan-price">
              <span class="product-pricing-offer__plan-amount">{{ $plan['price'] }}</span>
              @if ($plan['period'])
                <span class="product-pricing-offer__plan-period">{{ $plan['period'] }}</span>
              @endif
            </div>

            <p class="product-pricing-offer__plan-audience">{{ $plan['audience'] }}</p>

            <div class="product-pricing-offer__plan-features">
              <p class="product-pricing-offer__plan-features-title">Features:</p>
              <ul>
                @foreach ($plan['features'] as $feature)
                  <li>
                    <span class="product-pricing-offer__plan-check" aria-hidden="true">
                      <i class="fa-solid fa-check"></i>
                    </span>
                    <span>{{ $feature }}</span>
                  </li>
                @endforeach
              </ul>
            </div>

            <a
              href="{{ $contactHref }}"
              @class([
                'product-btn product-pricing-offer__plan-btn',
                'product-btn--gradient' => $plan['featured'],
                'product-pricing-offer__plan-btn--outline' => ! $plan['featured'],
              ])
            >
              {{ $plan['cta'] }}
              <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
            </a>
          </article>
        @endforeach
      </div>
    </div>
  </section>

</div>

@endsection
