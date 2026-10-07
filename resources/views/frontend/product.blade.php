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
              <span class="product-hero__title-accent">Free CRM for</span> <span class="product-hero__title-soft">Agencies &amp; Startups</span>
            </span>
            <span class="product-hero__title-line">
              <span class="product-hero__title-accent">Sales, Projects, HR &amp; Invoicing</span>
            </span>
            <span class="product-hero__title-line product-hero__title-soft">in One App</span>
          </h1>
        </div>

        <p class="product-hero__subtitle">
          Stop paying for five tools. Suave CRM gives small and mid-size teams a free sales pipeline, project management, timesheets, attendance, HR and invoicing, with an AI assistant built in. Sign up and start today, from anywhere in the world.
        </p>

        <div class="product-hero__actions">
          <a href="{{ $contactHref }}" class="product-btn product-btn--primary">
            Sign Up Free <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
          </a>
          <a href="{{ $demoHref }}" class="product-btn product-btn--secondary product-btn--ghost">
            Book a Demo <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
          </a>
        </div>

        <p class="text-center text-xs sm:text-sm text-slate-300 -mt-6 sm:-mt-8 mb-8 sm:mb-10">
          Free for small and mid-size companies &middot; No payment needed &middot; Works in any browser, worldwide
        </p>

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

    <section class="product-glance" id="at-a-glance" aria-labelledby="glance-heading">
      <div class="container product-glance__container">
        <div class="product-glance__header">
          <span class="product-glance__badge">At a Glance</span>
          <h2 id="glance-heading" class="product-glance__title">
            Suave CRM <span class="product-glance__title-accent">at a glance</span>
          </h2>
        </div>

        <table class="product-glance__table">
          <caption class="sr-only">Suave CRM key facts</caption>
          <tbody>
            @foreach ($glance as $row)
              <tr>
                <th scope="row">{{ $row['label'] }}</th>
                <td>{{ $row['value'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>

    <section class="product-how-it-works" id="how-it-works" aria-labelledby="how-it-works-heading">
      <div class="container product-how-it-works__container">
        <div class="product-how-it-works__header">
          <span class="product-how-it-works__badge">Free Sales CRM</span>
          <h2 id="how-it-works-heading" class="product-how-it-works__title">
            Free Sales CRM <span class="product-how-it-works__title-accent">with AI Lead Scoring</span>
          </h2>
          <p class="product-how-it-works__subtitle">
            Win more clients without a sales-ops team. Every lead lands in one place, AI tells you which ones to call first, and your pipeline updates itself as deals move.
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
        <span class="product-add-ons__badge">Included Free</span>
        <h2 id="add-ons-heading" class="product-add-ons__title">
          One Free CRM <span class="product-add-ons__title-accent">Instead of Five Subscriptions</span>
        </h2>
        <p class="product-add-ons__subtitle">
          Most growing teams pay separately for a CRM, a project tool, time tracking, an HR or attendance app and invoicing software, and many of those charge per user. When teams outgrow free plans, the bill climbs fast: HubSpot's Sales Hub Professional, for example, lists at USD 90 per seat per month billed annually, so 15 seats is USD 1,350 a month for the CRM alone. Suave CRM puts all five jobs in one app, free for small and mid-size companies.
        </p>
      </div>

      <div class="product-compare">
        <table class="product-compare__table">
          <caption class="sr-only">What growing teams usually pay for compared with Suave CRM</caption>
          <thead>
            <tr>
              <th scope="col">Job</th>
              <th scope="col">What teams usually pay for</th>
              <th scope="col">With Suave CRM</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($savings as $row)
              <tr>
                <th scope="row">{{ $row['job'] }}</th>
                <td>{{ $row['usual'] }}</td>
                <td>
                  <span class="product-compare__included">
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    Included free
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="product-add-ons__cta">
        <x-frontend.cta-button :href="$contactHref">
          Set up your workspace in minutes &mdash; Sign Up Free
        </x-frontend.cta-button>
      </div>
    </div>
  </section>

  @foreach ($featureSections as $section)
    @php($listTag = ($section['numbered'] ?? false) ? 'ol' : 'ul')
    <section
      @class(['product-module', 'product-module--tint' => $loop->even])
      id="{{ $section['id'] }}"
      aria-labelledby="{{ $section['id'] }}-heading"
    >
      <div class="container">
        <header class="product-module__header">
          <span class="product-module__badge">{{ $section['badge'] }}</span>
          <h2 id="{{ $section['id'] }}-heading" class="product-module__title">
            {{ $section['title'] }}
            <span class="product-module__title-accent">{{ $section['titleAccent'] }}</span>
          </h2>
          @if (filled($section['subtitle']))
            <p class="product-module__subtitle">{{ $section['subtitle'] }}</p>
          @endif
        </header>

        <{{ $listTag }} class="product-module__grid product-module__grid--{{ $section['columns'] }}">
          @foreach ($section['items'] as $item)
            <li class="product-module__card">
              <span class="product-module__icon" aria-hidden="true">
                @if ($section['numbered'] ?? false)
                  {{ $loop->iteration }}
                @else
                  <i class="fa-solid {{ $item['icon'] }}"></i>
                @endif
              </span>
              <h3>{{ $item['title'] }}</h3>
              <p>{{ $item['description'] }}</p>
            </li>
          @endforeach
        </{{ $listTag }}>

        @if (filled($section['note'] ?? null))
          <p class="product-module__note">{{ $section['note'] }}</p>
        @endif

        @if (filled($section['cta'] ?? null))
          <div class="product-module__cta">
            <x-frontend.cta-button :href="$contactHref">{{ $section['cta'] }}</x-frontend.cta-button>
            @if (filled($section['noteLink'] ?? null))
              <x-frontend.cta-button :href="$demoHref" variant="secondary-light">{{ $section['noteLink'] }}</x-frontend.cta-button>
            @endif
          </div>
        @endif
      </div>
    </section>
  @endforeach

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
            <span class="product-data-privacy__title-line product-data-privacy__title-line--soft">{{ $dataPrivacy['title'] }}</span>
          </h2>
          <p class="product-data-privacy__description">{{ $dataPrivacy['description'] }}</p>

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

  <x-frontend.testimonials-section
    id="testimonial"
    :items="$testimonials"
    heading-id="product-testimonials-title"
    eyebrow="Client feedback"
    title="What our clients say"
    subtitle="Read how teams use Suave CRM and work with Suave Creators."
  >
    <x-frontend.cta-button :href="route('case-studies')" variant="secondary-dark">See more client results</x-frontend.cta-button>
  </x-frontend.testimonials-section>

  <x-frontend.faq-section
    id="faq"
    heading-id="product-faq-heading"
    eyebrow="Have questions about our CRM?"
    title="Frequently Asked Questions: Free CRM, Pricing & Data Safety"
    description="Here are answers to the most common questions regarding Suave CRM features, free plans, and data security."
    :qa="$faqs"
    :media="'assets/media/diverse-team-data-meeting.webp'"
    media-alt="Business team collaborating on Suave CRM workflows"
    :show-cta="true"
    cta-label="Get Free Consultation"
    :cta-href="$contactHref"
    question-heading="h3"
    class="faq-section--align bg-cover bg-top bg-no-repeat"
    style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}')"
  />

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
          <div class="product-sales-cta__actions">
            <x-frontend.cta-button :href="$contactHref">{{ $salesCta['button'] }}</x-frontend.cta-button>
            <x-frontend.cta-button :href="$demoHref" variant="secondary-dark">Book a Demo</x-frontend.cta-button>
          </div>
          <p class="product-sales-cta__note">No payment needed &middot; Available worldwide</p>
          <div class="product-sales-cta__service-link">
            <span>Built by Suave Creators</span>
            <x-frontend.cta-button :href="route('service.show', 'custom-crm-development')" variant="secondary-dark">Custom CRM development experts</x-frontend.cta-button>
          </div>
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

@push('fixed-widgets')
<div class="product-sticky-cta" data-product-sticky-cta>
  <p class="product-sticky-cta__text">Free CRM for your team</p>
  <x-frontend.cta-button :href="$contactHref" variant="compact">Sign Up Free</x-frontend.cta-button>
</div>
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var bar = document.querySelector('[data-product-sticky-cta]');
    var hero = document.getElementById('hero');
    var finalCta = document.getElementById('sales-cta');
    if (!bar || !hero || !finalCta || !('IntersectionObserver' in window)) return;

    var heroVisible = true;
    var finalCtaVisible = false;

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.target === hero) heroVisible = entry.isIntersecting;
        if (entry.target === finalCta) finalCtaVisible = entry.isIntersecting;
      });
      var show = !heroVisible && !finalCtaVisible;
      bar.classList.toggle('is-visible', show);
      document.body.classList.toggle('has-product-sticky-cta', show);
    });

    observer.observe(hero);
    observer.observe(finalCta);
  });
</script>
@endpush

@endsection
