@extends('layouts.frontend')

@push('custom-css')
<meta name="application-name" content="Suave CRM">
<link rel="preload" as="image" href="{{ $heroBanner['src'] }}" type="image/gif" fetchpriority="high">
@endpush

@section('content')

<div class="product-page">

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

    <section class="product-hero product-hero--outreach" id="hero" aria-labelledby="product-hero-heading">
      <div class="container product-hero__container">
        <div class="product-hero__copy">
          <span class="product-hero__badge">
            <img src="{{ asset('assets/product/ai.png') }}" alt="Free Suave CRM badge icon for sales projects HR and invoicing" title="Free Suave CRM badge icon for sales projects HR and invoicing" class="product-hero__badge-icon">
            <span class="product-hero__badge-text">{{ $heroBadge }}</span>
          </span>

          <div class="product-hero__headline-wrap">
            @foreach ($heroFloatCards as $floatCard)
              <aside
                class="product-hero__float product-hero__float--{{ $floatCard['side'] }}"
                aria-hidden="true"
              >
                <p class="product-hero__float-label">{{ $floatCard['label'] }}</p>
                <p class="product-hero__float-value">{{ $floatCard['value'] }}</p>
                <p class="product-hero__float-meta">{{ $floatCard['meta'] }}</p>
                <p class="product-hero__float-change">{{ $floatCard['change'] }}</p>
              </aside>
            @endforeach

            <h1 id="product-hero-heading" class="product-hero__title product-hero__title--free-crm">
              <span class="product-hero__title-line">Free CRM for Agencies and</span>
              <span class="product-hero__title-line product-hero__title-accent">Startups: Sales, Projects, HR and</span>
              <span class="product-hero__title-line">
                <span class="product-hero__title-accent">Invoicing</span>
                <span class="product-hero__title-soft"> in One App</span>
              </span>
            </h1>
          </div>

          <p class="product-hero__subtitle">
            Stop paying for five tools.
            <strong>Suave CRM</strong> gives small and mid-size teams a free
            <strong>sales pipeline</strong>, project management, timesheets, attendance,
            <strong>HR</strong> and <strong>invoicing</strong>, with an
            <strong>AI assistant</strong> built in.
            <strong>Sign up</strong> and <strong>start today</strong>, from anywhere in the world.
          </p>

          <form class="product-signup product-signup--hero" action="{{ $signupUrl }}" method="get" data-product-signup>
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

          <ul class="product-hero__trust">
            @foreach ($heroTrustItems as $trustItem)
              <li class="product-hero__trust-item">
                <img
                  src="{{ asset('assets/icons/green-circle-check-icon.png') }}"
                  alt="Included benefit check mark for Suave CRM free plan"
                  title="Included benefit check mark for Suave CRM free plan"
                  class="product-hero__trust-icon"
                  width="18"
                  height="18"
                  loading="lazy"
                  decoding="async"
                >
                <span>{{ $trustItem }}</span>
              </li>
            @endforeach
          </ul>

          <p class="product-hero__demo-link">
            <a href="{{ $demoHref }}">{{ $heroDemoLinkLabel }}</a>
          </p>
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

        <p class="product-hero__proof">
          <q>{{ $heroProof['quote'] }}</q>
          <span class="product-hero__proof-author">
            <span class="product-hero__proof-avatar" aria-hidden="true">{{ $heroProof['initials'] }}</span>
            <span class="product-hero__proof-meta">
              <strong>{{ $heroProof['name'] }}</strong>
              <span>{{ $heroProof['role'] }}, {{ $heroProof['company'] }}</span>
            </span>
          </span>
        </p>
      </div>
    </section>

    <section class="product-glance" id="at-a-glance" aria-labelledby="glance-heading">
      <div class="container product-glance__container">
        <div class="product-glance__header">
          <span class="product-glance__badge">— At a Glance</span>
          <h2 id="glance-heading" class="product-glance__title">
            Suave CRM <span class="product-glance__title-accent">at a Glance</span>
          </h2>
          <p class="product-glance__subtitle">{{ $glanceSubtitle }}</p>
        </div>

        <ul class="product-glance__grid" role="list">
          @foreach ($glance as $row)
            <li class="product-glance__card">
              <span class="product-glance__icon product-glance__icon--{{ $row['tone'] }}" aria-hidden="true">
                <i class="fa-solid {{ $row['icon'] }}"></i>
              </span>
              <h3 class="product-glance__card-title">{{ $row['label'] }}</h3>
              <p class="product-glance__card-text">{{ $row['value'] }}</p>
            </li>
          @endforeach
        </ul>
      </div>
    </section>

  </div>

  <section class="product-add-ons" id="add-ons" aria-labelledby="add-ons-heading">
    <div class="container product-add-ons__container">
      <div class="product-add-ons__header">
        <div class="product-add-ons__eyebrow">
          <span class="product-add-ons__eyebrow-bar" aria-hidden="true"></span>
          <span class="product-add-ons__badge">{{ $savings['badge'] }}</span>
        </div>
        <h2 id="add-ons-heading" class="product-add-ons__title">
          {{ $savings['title'] }} <span class="product-add-ons__title-accent">{{ $savings['titleAccent'] }}</span>
        </h2>
        <p class="product-add-ons__subtitle">{!! $savings['subtitleHtml'] !!}</p>
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
            @foreach ($savings['rows'] as $row)
              <tr>
                <th scope="row">
                  <span class="product-compare__job">
                    <span class="product-compare__job-icon" aria-hidden="true">
                      <i class="fa-solid {{ $row['icon'] }}"></i>
                    </span>
                    <span class="product-compare__job-label">{{ $row['job'] }}</span>
                  </span>
                </th>
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
        <x-frontend.cta-button :href="$signupUrl">{{ $savings['ctaLabel'] }}</x-frontend.cta-button>
      </div>
    </div>
  </section>

  @foreach ($featureSections as $section)
    @php($listTag = ($section['numbered'] ?? false) ? 'ol' : 'ul')
    @php($visual = $section['visual'] ?? null)
    @php($layout = $section['layout'] ?? '')
    @php($isShowcase = $layout === 'showcase')
    @php($isCards = $layout === 'cards')
    @php($isAi = $layout === 'ai')
    @php($isAudience = $layout === 'audience')
    @php($isSteps = $layout === 'steps')
    @php($isDarkModule = ($section['theme'] ?? '') === 'dark')
    @php($cardCount = count($section['items'] ?? []))
    @php($help = $section['help'] ?? null)
    <section
      @class([
        'product-module',
        'product-module--tint' => $loop->even && ! $isDarkModule && ! $isAi && ! $isAudience,
        'product-module--showcase' => $isShowcase,
        'product-module--cards' => $isCards,
        'product-module--ai' => $isAi,
        'product-module--audience' => $isAudience,
        'product-module--steps' => $isSteps,
        'product-module--dark' => $isDarkModule,
        'product-module--cols-3' => $isCards && $cardCount === 3,
      ])
      id="{{ $section['id'] }}"
      aria-labelledby="{{ $section['id'] }}-heading"
      @if (filled($section['backgroundImage'] ?? null))
        style="background-image: url('{{ $section['backgroundImage'] }}')"
      @endif
    >
      <div class="container">
        @unless ($isSteps)
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
        @endunless

        @if ($isSteps)
          <div class="product-module__body product-module__body--steps">
            <div class="product-module__steps-intro">
              <span class="product-module__badge">{{ $section['badge'] }}</span>
              <h2 id="{{ $section['id'] }}-heading" class="product-module__title">
                {{ $section['title'] }}
                <span class="product-module__title-accent">{{ $section['titleAccent'] }}</span>
              </h2>
              @if (filled($section['subtitle']))
                <p class="product-module__subtitle">{{ $section['subtitle'] }}</p>
              @endif
              @if (filled($section['cta'] ?? null))
                <div class="product-module__cta product-module__cta--steps">
                  <x-frontend.cta-button :href="$signupUrl">{{ $section['cta'] }}</x-frontend.cta-button>
                </div>
              @endif
            </div>

            <div class="product-module__steps-panel">
              <ol class="product-module__steps-list">
                @foreach ($section['items'] as $item)
                  <li class="product-module__step">
                    <span class="product-module__step-num" aria-hidden="true">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="product-module__step-copy">
                      <h3>{{ $item['title'] }}</h3>
                      <p>{{ $item['description'] }}</p>
                    </div>
                    <span class="product-module__step-icon" aria-hidden="true">
                      <i class="fa-solid {{ $item['icon'] }}"></i>
                    </span>
                  </li>
                @endforeach
              </ol>

              @if (filled($help))
                <div class="product-module__help">
                  <span class="product-module__help-icon" aria-hidden="true">
                    <i class="fa-solid fa-message"></i>
                  </span>
                  <div class="product-module__help-copy">
                    <strong>{{ $help['title'] }}</strong>
                    <p>{{ $help['body'] }}</p>
                  </div>
                  <a class="product-module__help-link" href="{{ $demoHref }}">{{ $help['linkLabel'] }}</a>
                </div>
              @endif
            </div>
          </div>
        @elseif ($isAudience)
          <ul class="product-module__list product-module__list--audience">
            @foreach ($section['items'] as $item)
              @php($itemImage = $item['image'] ?? '')
              @php($itemImageAlt = $item['imageAlt'] ?? $item['title'])
              <li class="product-module__audience-card">
                <div class="product-module__audience-media">
                  @if (filled($itemImage))
                    <img
                      src="{{ asset($itemImage) }}"
                      alt="{{ $itemImageAlt }}"
                      title="{{ $itemImageAlt }}"
                      class="product-module__audience-image"
                      width="220"
                      height="180"
                      loading="lazy"
                      decoding="async"
                    >
                  @else
                    <div class="product-module__audience-image-placeholder" aria-hidden="true"></div>
                  @endif
                </div>
                <div class="product-module__audience-copy">
                  <h3>{{ $item['title'] }}</h3>
                  <p>{{ $item['description'] }}</p>
                  <a class="product-module__audience-link" href="{{ $signupUrl }}">
                    {{ $section['linkLabel'] ?? 'Explore solution →' }}
                  </a>
                </div>
              </li>
            @endforeach
          </ul>
        @elseif ($isAi)
          <div class="product-module__body product-module__body--ai">
            <div class="product-module__features">
              <ul class="product-module__list product-module__list--ai">
                @foreach ($section['items'] as $item)
                  <li class="product-module__ai-item">
                    <span class="product-module__icon product-module__icon--ai" aria-hidden="true">
                      <i class="fa-solid {{ $item['icon'] }}"></i>
                    </span>
                    <div class="product-module__card-copy">
                      <h3>{{ $item['title'] }}</h3>
                      <p>{{ $item['description'] }}</p>
                    </div>
                  </li>
                @endforeach
              </ul>

              @if (filled($section['cta'] ?? null))
                <div class="product-module__cta product-module__cta--ai">
                  <x-frontend.cta-button :href="$signupUrl">{{ $section['cta'] }}</x-frontend.cta-button>
                </div>
              @endif
            </div>

            @if (filled($visual) && ($visual['type'] ?? '') === 'ask-suave')
              <div class="product-module__visual" aria-hidden="true">
                <div class="product-ask-suave">
                  <div class="product-ask-suave__head">
                    <span class="product-ask-suave__avatar">
                      <i class="fa-solid fa-robot"></i>
                    </span>
                    <div class="product-ask-suave__prompt-wrap">
                      <p class="product-ask-suave__label">{{ $visual['label'] }}</p>
                      <p class="product-ask-suave__prompt">{{ $visual['prompt'] }}</p>
                    </div>
                  </div>

                  <div class="product-ask-suave__brief">
                    <p class="product-ask-suave__brief-label">
                      <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                      {{ $visual['briefLabel'] }}
                    </p>
                    <p class="product-ask-suave__brief-title">{{ $visual['briefTitle'] }}</p>
                    <ul class="product-ask-suave__priorities">
                      @foreach ($visual['priorities'] as $priority)
                        <li>{{ $priority }}</li>
                      @endforeach
                    </ul>
                  </div>

                  <div class="product-ask-suave__input">
                    <span>{{ $visual['inputPlaceholder'] }}</span>
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            @endif
          </div>
        @elseif ($isCards)
          <ul class="product-module__list product-module__list--cards">
            @foreach ($section['items'] as $item)
              <li @class(['product-module__card', 'product-module__card--stack', 'product-module__card--tone-'.($item['tone'] ?? 'blue')])>
                <span class="product-module__icon" aria-hidden="true">
                  <i class="fa-solid {{ $item['icon'] }}"></i>
                </span>
                <div class="product-module__card-copy">
                  <h3>{{ $item['title'] }}</h3>
                  <p>{{ $item['description'] }}</p>
                </div>
              </li>
            @endforeach
          </ul>
        @elseif ($isShowcase)
          <div class="product-module__body product-module__body--showcase">
            <ul class="product-module__list product-module__list--showcase">
              @foreach ($section['items'] as $item)
                @php($itemImage = $item['image'] ?? '')
                @php($itemImageAlt = $item['imageAlt'] ?? $item['title'])
                <li class="product-module__showcase-card">
                  <div class="product-module__showcase-media">
                    @if (filled($itemImage))
                      <img
                        src="{{ asset($itemImage) }}"
                        alt="{{ $itemImageAlt }}"
                        title="{{ $itemImageAlt }}"
                        class="product-module__showcase-image"
                        width="280"
                        height="168"
                        loading="lazy"
                        decoding="async"
                      >
                    @else
                      <div class="product-module__showcase-image-placeholder" aria-hidden="true"></div>
                    @endif
                    <span class="product-module__showcase-icon" aria-hidden="true">
                      <i class="fa-solid {{ $item['icon'] }}"></i>
                    </span>
                  </div>
                  <div class="product-module__showcase-copy">
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['description'] }}</p>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
        @else
          <div @class(['product-module__body', 'product-module__body--split' => filled($visual)])>
            <div class="product-module__features">
              <{{ $listTag }} class="product-module__list">
                @foreach ($section['items'] as $item)
                  <li class="product-module__card">
                    <span class="product-module__icon" aria-hidden="true">
                      @if ($section['numbered'] ?? false)
                        {{ $loop->iteration }}
                      @else
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                      @endif
                    </span>
                    <div class="product-module__card-copy">
                      <h3>{{ $item['title'] }}</h3>
                      <p>{{ $item['description'] }}</p>
                    </div>
                  </li>
                @endforeach
              </{{ $listTag }}>

              @if (filled($section['note'] ?? null))
                <p class="product-module__note">{{ $section['note'] }}</p>
              @endif

              @if (filled($section['cta'] ?? null) || filled($section['noteLink'] ?? null))
                <div class="product-module__cta">
                  @if (filled($section['cta'] ?? null))
                    <a class="product-module__cta-link" href="{{ $signupUrl }}">{{ $section['cta'] }}</a>
                  @endif
                  @if (filled($section['noteLink'] ?? null))
                    <a class="product-module__cta-link product-module__cta-link--secondary" href="{{ $demoHref }}">{{ $section['noteLink'] }}</a>
                  @endif
                </div>
              @endif
            </div>

            @if (filled($visual))
              <div class="product-module__visual" aria-hidden="true">
                @if (($visual['type'] ?? '') === 'pipeline')
                  <div class="product-module-pipeline">
                    <div class="product-module-pipeline__top">
                      <div>
                        <p class="product-module-pipeline__eyebrow">{{ $visual['eyebrow'] }}</p>
                        <p class="product-module-pipeline__title">{{ $visual['title'] }}</p>
                      </div>
                      <span class="product-module-pipeline__action">{{ $visual['action'] }}</span>
                    </div>

                    <div class="product-module-pipeline__metrics">
                      @foreach ($visual['metrics'] as $metric)
                        <div class="product-module-pipeline__metric">
                          <span class="product-module-pipeline__metric-icon">
                            <i class="fa-solid {{ $metric['icon'] }}"></i>
                          </span>
                          <div>
                            <span class="product-module-pipeline__metric-label">{{ $metric['label'] }}</span>
                            <strong class="product-module-pipeline__metric-value">{{ $metric['value'] }}</strong>
                          </div>
                        </div>
                      @endforeach
                    </div>

                    <div class="product-module-pipeline__stages">
                      @foreach ($visual['stages'] as $stage)
                        <div class="product-module-pipeline__stage">
                          <div class="product-module-pipeline__stage-head">
                            <span>{{ $stage['label'] }}</span>
                            <span class="product-module-pipeline__count">{{ str_pad((string) $stage['count'], 2, '0', STR_PAD_LEFT) }}</span>
                          </div>
                          @foreach ($stage['leads'] as $lead)
                            <div class="product-module-pipeline__lead">
                              <span class="product-module-pipeline__avatar">{{ $lead['initials'] }}</span>
                              <div class="product-module-pipeline__lead-copy">
                                <strong>{{ $lead['company'] }}</strong>
                                <span>{{ $lead['project'] }}</span>
                              </div>
                              <div class="product-module-pipeline__lead-meta">
                                <strong>{{ $lead['amount'] }}</strong>
                                <span class="product-module-pipeline__fit">↗ {{ $lead['fit'] }} fit</span>
                              </div>
                            </div>
                          @endforeach
                        </div>
                      @endforeach
                    </div>
                  </div>
                @else
                  <div class="product-module-panel">
                    <div class="product-module-panel__top">
                      <p class="product-module-panel__eyebrow">{{ $visual['eyebrow'] }}</p>
                      <p class="product-module-panel__title">{{ $visual['title'] }}</p>
                    </div>
                    <div class="product-module-panel__metrics">
                      @foreach ($visual['metrics'] as $metric)
                        <div class="product-module-panel__metric">
                          <span>{{ $metric['label'] }}</span>
                          <strong>{{ $metric['value'] }}</strong>
                        </div>
                      @endforeach
                    </div>
                    <ul class="product-module-panel__rows">
                      @foreach ($visual['rows'] as $row)
                        <li>{{ $row }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
              </div>
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
    eyebrow="Testimonial"
    title="What clients say about Suave CRM"
    subtitle=""
  >
    <x-frontend.cta-button :href="route('case-studies')" variant="secondary-dark">See more client results →</x-frontend.cta-button>
  </x-frontend.testimonials-section>

  <x-frontend.faq-section
    id="faq"
    heading-id="product-faq-heading"
    eyebrow=""
    title="FAQ"
    description=""
    :qa="$faqs"
    :media="null"
    :show-cta="false"
    question-heading="h3"
    class="faq-section--crm-builder"
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
          <form class="product-signup product-signup--on-dark" action="{{ $signupUrl }}" method="get" data-product-signup>
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
              {{ $salesCta['button'] }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
          </form>
          <p class="product-sales-cta__note">
            No payment needed &middot; Available worldwide
            &middot; <a href="{{ $demoHref }}">Prefer a walkthrough? Book a demo →</a>
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

@push('fixed-widgets')
<div class="product-sticky-cta" data-product-sticky-cta>
  <p class="product-sticky-cta__text">Free CRM for your team</p>
  <x-frontend.cta-button :href="$signupUrl" variant="compact">Sign Up Free</x-frontend.cta-button>
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
