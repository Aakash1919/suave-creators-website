@extends('layouts.frontend')

@push('custom-css')
<meta name="application-name" content="Suave CRM">
<link rel="preload" as="image" href="{{ $heroBanner['src'] }}" type="image/webp" fetchpriority="high">
@endpush

@section('content')

<div class="product-page product-page--free-crm">

  <div
    class="product-top-shell"
    style="background-image: url('{{ $heroBackground }}')"
  >
    <nav class="product-breadcrumb container" aria-label="Breadcrumb">
      <ol class="product-breadcrumb__list">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li aria-current="page">Suave CRM</li>
      </ol>
    </nav>

    <section class="product-hero product-hero--free-crm" id="hero" aria-labelledby="product-hero-heading">
      <div class="container product-hero__container">
        <span class="product-hero__badge">
          <img src="{{ asset('assets/product/ai.png') }}" alt="Free Suave CRM badge icon for sales projects HR and invoicing" title="Free Suave CRM badge icon for sales projects HR and invoicing" class="product-hero__badge-icon">
          <span class="product-hero__badge-text">{{ $heroEyebrow }}</span>
        </span>

        <h1 id="product-hero-heading" class="product-hero__title product-hero__title--free">
          {{ $heroTitle }}
        </h1>

        <p class="product-hero__subtitle">{{ $heroSubtitle }}</p>

        <form
          class="product-signup"
          action="{{ $signupUrl }}"
          method="get"
          data-product-signup
        >
          <label class="sr-only" for="product-hero-email">Work email</label>
          <input
            id="product-hero-email"
            class="product-signup__input"
            type="email"
            name="email"
            required
            autocomplete="email"
            placeholder="Work email"
          >
          <button type="submit" class="product-btn product-btn--primary product-signup__btn">
            Sign Up Free <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
          </button>
        </form>

        <p class="product-hero__trust">{{ $heroTrustLine }}</p>
        <p class="product-hero__demo-link">
          <a href="{{ $demoHref }}">{{ $heroDemoLinkLabel }}</a>
        </p>

        <p class="product-hero__proof">
          <q>{{ $heroProof['quote'] }}</q>
          <span>— {{ $heroProof['name'] }}, {{ $heroProof['role'] }}, {{ $heroProof['company'] }}</span>
        </p>

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
          <div class="product-hero__banner-stage product-hero__banner-stage--simple">
            <img
              src="{{ $heroBanner['src'] }}"
              alt="{{ $heroBanner['alt'] }}"
              title="{{ $heroBanner['alt'] }}"
              class="product-hero__banner-gif"
              width="996"
              height="560"
              decoding="async"
              fetchpriority="high"
            >
          </div>
        </div>
      </div>
    </section>
  </div>

  <section class="product-glance" id="glance" aria-labelledby="glance-heading">
    <div class="container product-glance__container">
      <h2 id="glance-heading" class="product-section-title">{{ $glance['title'] }}</h2>
      <dl class="product-glance__table">
        @foreach ($glance['rows'] as $row)
          <div class="product-glance__row">
            <dt>{{ $row['label'] }}</dt>
            <dd>{{ $row['value'] }}</dd>
          </div>
        @endforeach
      </dl>
    </div>
  </section>

  <section class="product-savings" id="what-you-save" aria-labelledby="savings-heading">
    <div class="container product-savings__container">
      <p class="product-section-eyebrow">{{ $savings['eyebrow'] }}</p>
      <h2 id="savings-heading" class="product-section-title">{{ $savings['title'] }}</h2>
      <p class="product-section-copy">{{ $savings['body'] }}</p>

      <div class="product-savings__table-wrap" role="region" aria-label="Subscription savings comparison" tabindex="0">
        <table class="product-savings__table">
          <thead>
            <tr>
              @foreach ($savings['headers'] as $header)
                <th scope="col">{{ $header }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach ($savings['rows'] as $row)
              <tr>
                <th scope="row">{{ $row['job'] }}</th>
                <td>{{ $row['usual'] }}</td>
                <td>{{ $row['withSuave'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="product-savings__cta">
        <a href="{{ $signupUrl }}" class="product-btn product-btn--primary">
          {{ $savings['button'] }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
        <p class="product-savings__microcopy">{{ $savings['microcopy'] }}</p>
      </div>
    </div>
  </section>

  @foreach ([$sales, $projects, $timeBilling, $teamHr] as $module)
    <section class="product-module" id="{{ $module['id'] }}" aria-labelledby="{{ $module['id'] }}-heading">
      <div class="container product-module__container">
        <p class="product-section-eyebrow">{{ $module['eyebrow'] }}</p>
        <h2 id="{{ $module['id'] }}-heading" class="product-section-title">{{ $module['title'] }}</h2>
        <p class="product-section-copy">{{ $module['intro'] }}</p>
        <ul class="product-module__list">
          @foreach ($module['items'] as $item)
            <li>
              <strong>{{ $item['title'] }}:</strong>
              <span>{{ $item['body'] }}</span>
            </li>
          @endforeach
        </ul>
        @if (! empty($module['linkLabel']))
          <p class="product-module__link">
            <a href="{{ $signupUrl }}">{{ $module['linkLabel'] }}</a>
          </p>
        @endif
      </div>
    </section>
  @endforeach

  <section class="product-ask-suave" id="{{ $askSuave['id'] }}" aria-labelledby="ask-suave-heading">
    <div class="container product-ask-suave__container">
      <p class="product-section-eyebrow">{{ $askSuave['eyebrow'] }}</p>
      <h2 id="ask-suave-heading" class="product-section-title">{{ $askSuave['title'] }}</h2>
      <ul class="product-module__list">
        @foreach ($askSuave['items'] as $item)
          <li>{{ $item }}</li>
        @endforeach
      </ul>
      <a href="{{ $signupUrl }}" class="product-btn product-btn--primary">
        {{ $askSuave['button'] }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
      </a>
    </div>
  </section>

  <section class="product-audiences" id="who-its-for" aria-labelledby="audiences-heading">
    <div class="container product-audiences__container">
      <p class="product-section-eyebrow">Who it's for</p>
      <h2 id="audiences-heading" class="product-section-title">{{ $audiences['title'] }}</h2>
      <div class="product-audiences__grid">
        @foreach ($audiences['items'] as $item)
          <article class="product-audiences__card">
            <h3>{{ $item['title'] }}</h3>
            <p>{{ $item['body'] }}</p>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <section class="product-getting-started" id="getting-started" aria-labelledby="getting-started-heading">
    <div class="container product-getting-started__container">
      <p class="product-section-eyebrow">Getting started</p>
      <h2 id="getting-started-heading" class="product-section-title">{{ $gettingStarted['title'] }}</h2>
      <ol class="product-getting-started__steps">
        @foreach ($gettingStarted['steps'] as $step)
          <li>{{ $step }}</li>
        @endforeach
      </ol>
      <p class="product-section-copy">
        {{ $gettingStarted['help'] }}
        <a href="{{ $demoHref }}">Book a demo</a>
      </p>
      <a href="{{ $signupUrl }}" class="product-btn product-btn--primary">
        {{ $gettingStarted['button'] }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
      </a>
    </div>
  </section>

  <section class="product-why-switch" id="why-switch" aria-labelledby="why-switch-heading">
    <div class="container product-why-switch__container">
      <p class="product-section-eyebrow">Why teams switch</p>
      <h2 id="why-switch-heading" class="product-section-title">{{ $whySwitch['title'] }}</h2>
      <div class="product-why-switch__grid">
        @foreach ($whySwitch['items'] as $item)
          <article class="product-why-switch__card">
            <h3>{{ $item['title'] }}</h3>
            <p>{{ $item['body'] }}</p>
          </article>
        @endforeach
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
          <h2 id="data-privacy-heading" class="product-data-privacy__title product-data-privacy__title--single">
            {{ $dataPrivacy['title'] }}
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

  <section class="product-testimonial" id="testimonial" aria-labelledby="testimonial-heading">
    <div class="container product-testimonial__container">
      <h2 id="testimonial-heading" class="sr-only">Client testimonial</h2>
      <blockquote class="product-testimonial__quote">
        <img
          class="product-testimonial__mark"
          src="{{ $testimonial['quoteMark']['src'] }}"
          alt="{{ $testimonial['quoteMark']['alt'] }}"
          title="{{ $testimonial['quoteMark']['alt'] }}"
          width="48"
          height="48"
          decoding="async"
          loading="lazy"
          aria-hidden="true"
        >
        <p>{{ $testimonial['quote'] }}</p>
        <footer>
          <img
            class="product-testimonial__avatar"
            src="{{ $testimonial['avatar']['src'] }}"
            alt="{{ $testimonial['avatar']['alt'] }}"
            title="{{ $testimonial['avatar']['alt'] }}"
            width="48"
            height="48"
            decoding="async"
            loading="lazy"
          >
          <cite>
            <strong>{{ $testimonial['name'] }}</strong>
            <span>{{ $testimonial['role'] }}, {{ $testimonial['company'] }}</span>
          </cite>
        </footer>
      </blockquote>
      <p class="product-testimonial__link">
        <a href="{{ $testimonial['resultsHref'] }}">{{ $testimonial['resultsLabel'] }}</a>
      </p>
    </div>
  </section>

  <div id="faq">
    <x-frontend.faq-section
      :qa="$faqs"
      eyebrow="FAQ"
      title="Frequently asked questions about Suave CRM"
      description=""
      :show-cta="false"
      :media="null"
      heading-id="faq-heading"
      class="faq-section--crm-builder bg-cover bg-top bg-no-repeat"
    />
  </div>

  <section class="product-final-cta" id="final-cta" aria-labelledby="final-cta-heading" data-product-final-cta>
    <div class="container product-final-cta__container">
      <h2 id="final-cta-heading" class="product-section-title product-section-title--light">{{ $finalCta['title'] }}</h2>
      <p class="product-section-copy product-section-copy--light">{{ $finalCta['body'] }}</p>

      <form
        class="product-signup product-signup--on-dark"
        action="{{ $signupUrl }}"
        method="get"
        data-product-signup
      >
        <label class="sr-only" for="product-final-email">Work email</label>
        <input
          id="product-final-email"
          class="product-signup__input"
          type="email"
          name="email"
          required
          autocomplete="email"
          placeholder="Work email"
        >
        <button type="submit" class="product-btn product-btn--primary product-signup__btn">
          Sign Up Free <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </button>
      </form>

      <p class="product-final-cta__trust">
        {{ $finalCta['trustLine'] }}
        · <a href="{{ $demoHref }}">{{ $finalCta['demoLinkLabel'] }}</a>
      </p>
    </div>
  </section>

  <div class="product-sticky-bar" data-product-sticky-bar hidden>
    <p class="product-sticky-bar__label">{{ $stickyBar['label'] }}</p>
    <a href="{{ $signupUrl }}" class="product-btn product-btn--primary product-sticky-bar__btn">
      {{ $stickyBar['button'] }}
    </a>
  </div>

</div>

@endsection

@push('scripts')
<script>
(function () {
  var sticky = document.querySelector('[data-product-sticky-bar]');
  var hero = document.getElementById('hero');
  var finalCta = document.querySelector('[data-product-final-cta]');
  if (!sticky || !hero || !finalCta || !window.matchMedia) return;

  var mobile = window.matchMedia('(max-width: 767px)');

  function update() {
    if (!mobile.matches) {
      sticky.hidden = true;
      return;
    }
    var heroBottom = hero.getBoundingClientRect().bottom;
    var finalTop = finalCta.getBoundingClientRect().top;
    var viewportH = window.innerHeight || document.documentElement.clientHeight;
    var pastHero = heroBottom < 0;
    var finalVisible = finalTop < viewportH;
    sticky.hidden = !(pastHero && !finalVisible);
  }

  window.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);
  mobile.addEventListener('change', update);
  update();
})();
</script>
@endpush
