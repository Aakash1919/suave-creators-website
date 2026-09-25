@extends('layouts.frontend')

@push('custom-css')
<link rel="preload" as="image" href="{{ asset($bannerBackgroundImage) }}" type="image/webp">
@endpush

@section('content')

<section
  class="full-bleed crm-builder-hero"
  style="background-image: url('{{ asset($bannerBackgroundImage) }}');"
  aria-labelledby="crm-builder-hero-heading">
  <div class="section-inner crm-builder-hero__inner">
    <div class="crm-builder-hero__top">
      <div class="crm-builder-hero__copy">
        <p class="crm-builder-hero__eyebrow"><span class="crm-builder-hero__eyebrow-text">{{ $eyebrow }}</span></p>
        <h1 id="crm-builder-hero-heading" class="page-hero-title crm-builder-hero__title">
          <span class="crm-builder-hero__title-lead">{{ $heroLead }}</span>
          <span class="crm-builder-hero__title-line">
            {{ $heroMid }}
            <span class="crm-builder-hero__title-accent">{{ $heroAccent }}</span>
          </span>
          <span class="crm-builder-hero__title-accent1">{{ $heroPurple }}</span>
        </h1>
        <p class="crm-builder-hero__desc">{{ $heroDescription }}</p>
        <div class="crm-builder-hero__cta">
          <x-frontend.cta-button :href="$demoHref">{{ $primaryCta }}</x-frontend.cta-button>
        </div>
      </div>

      <div class="crm-builder-hero__visual">
        <div class="crm-builder-dash" aria-label="{{ $dashboard['title'] }}">
          <div class="crm-builder-dash__chrome" aria-hidden="true">
            <span class="crm-builder-dash__dot crm-builder-dash__dot--red"></span>
            <span class="crm-builder-dash__dot crm-builder-dash__dot--yellow"></span>
            <span class="crm-builder-dash__dot crm-builder-dash__dot--green"></span>
            <p class="crm-builder-dash__title">{{ $dashboard['title'] }}</p>
          </div>

          <ul class="crm-builder-dash__stages">
            @foreach ($dashboard['stages'] as $stage)
              <li class="crm-builder-dash__stage">
                <span class="crm-builder-dash__stage-label">{{ $stage['label'] }}</span>
                <span class="crm-builder-dash__bar crm-builder-dash__bar--{{ $stage['tone'] }}" style="--bar-width: {{ $stage['width'] }};"></span>
                <span class="crm-builder-dash__stage-count">{{ $stage['count'] }}</span>
                <span class="crm-builder-dash__stage-value">{{ $stage['value'] }}</span>
              </li>
            @endforeach
          </ul>

          <div class="crm-builder-dash__metrics">
            @foreach ($dashboard['metrics'] as $metric)
              <div class="crm-builder-dash__metric">
                <span class="crm-builder-dash__metric-label">{{ $metric['label'] }}</span>
                @if ($metric['value'] !== '')
                  <strong class="crm-builder-dash__metric-value">{{ $metric['value'] }}</strong>
                @endif
              </div>
            @endforeach
          </div>
        </div>

        <aside class="crm-builder-score" aria-label="{{ $dashboard['scoreLabel'] }}">
          {{-- <span class="crm-builder-hero__icon-placeholder" aria-hidden="true"></span> --}}
          <p class="crm-builder-score__label">{{ $dashboard['scoreLabel'] }}</p>
          <p class="crm-builder-score__value">
            <strong>{{ $dashboard['score'] }}</strong><span>{{ $dashboard['scoreMax'] }}</span>
          </p>
        </aside>
      </div>
    </div>

    <article class="crm-builder-hero__definition">
      <div class="crm-builder-hero__definition-head">
        {{-- <span class="crm-builder-hero__icon-placeholder" aria-hidden="true"></span> --}}
        <h2 class="crm-builder-hero__definition-title">{{ $definitionEyebrow }}</h2>
      </div>
      <p class="crm-builder-hero__definition-copy">{{ $definitionCopy }}</p>
    </article>
  </div>
</section>

<section
  class="full-bleed crm-builder-trust-band"
  id="roi"
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
        @foreach ($stats as $stat)
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

<section class="full-bleed crm-builder-tco" aria-labelledby="crm-builder-tco-heading">
  <div class="section-inner crm-builder-tco__inner">
    <div class="crm-builder-tco__intro">
      <p class="crm-builder-tco__eyebrow">
        <span class="crm-builder-tco__eyebrow-bar" aria-hidden="true"></span>
        <span class="crm-builder-tco__eyebrow-text">{{ $tco['eyebrow'] }}</span>
      </p>
      <div class="crm-builder-tco__copy">
        <h2 id="crm-builder-tco-heading" class="home-type-h2 crm-builder-tco__title">
          {{ $tco['title'] }}
          <span class="crm-builder-tco__title-accent">{{ $tco['titleAccent'] }}</span>
        </h2>
        <p class="crm-builder-tco__desc">{{ $tco['description'] }}</p>
      </div>
    </div>

    <div class="crm-builder-tco__panel">
      <div class="crm-builder-tco__mobile-head">
        <span class="crm-builder-tco__icon crm-builder-tco__icon--metric">
          <img
            src="{{ asset($tco['metricIcon']) }}"
            alt="{{ $tco['metricIconAlt'] }}"
            title="{{ $tco['metricIconAlt'] }}"
            width="24"
            height="24"
            decoding="async">
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
                  <img
                    src="{{ asset($tco['metricIcon']) }}"
                    alt="{{ $tco['metricIconAlt'] }}"
                    title="{{ $tco['metricIconAlt'] }}"
                    width="24"
                    height="24"
                    decoding="async">
                </span>
                <span class="crm-builder-tco__heading-text">{{ $tco['metricHeading'] }}</span>
              </span>
            </th>
            <th scope="col" class="crm-builder-tco__col--saas">
              <span class="crm-builder-tco__heading">
                <span class="crm-builder-tco__icon crm-builder-tco__icon--saas">
                  <img
                    src="{{ asset($tco['saasIcon']) }}"
                    alt="{{ $tco['saasIconAlt'] }}"
                    title="{{ $tco['saasIconAlt'] }}"
                    width="32"
                    height="22"
                    decoding="async">
                </span>
                <span class="crm-builder-tco__heading-copy">
                  <span class="crm-builder-tco__heading-text">{{ $tco['saasHeading'] }}</span>
                  <span class="crm-builder-tco__heading-note">{{ $tco['saasNote'] }}</span>
                </span>
              </span>
            </th>
            <th scope="col" class="crm-builder-tco__col--custom">
              <span class="crm-builder-tco__heading">
                <span class="crm-builder-tco__icon crm-builder-tco__icon--custom">
                  <img
                    src="{{ asset($tco['customIcon']) }}"
                    alt="{{ $tco['customIconAlt'] }}"
                    title="{{ $tco['customIconAlt'] }}"
                    width="28"
                    height="22"
                    decoding="async">
                </span>
                <span class="crm-builder-tco__heading-copy">
                  <span class="crm-builder-tco__heading-text">{{ $tco['customHeading'] }}</span>
                  <span class="crm-builder-tco__heading-note">{{ $tco['customNote'] }}</span>
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
                  <img
                    src="{{ asset($tco['saasIcon']) }}"
                    alt="{{ $tco['saasIconAlt'] }}"
                    title="{{ $tco['saasIconAlt'] }}"
                    width="16"
                    height="16"
                    decoding="async">
                  <span class="crm-builder-tco__mobile-label-copy">
                    <span class="crm-builder-tco__mobile-label-text">{{ $tco['saasHeading'] }}</span>
                    <span class="crm-builder-tco__mobile-label-note">{{ $tco['saasNote'] }}</span>
                  </span>
                </span>
                <strong class="crm-builder-tco__value crm-builder-tco__value--saas">{{ $row['saasValue'] }}</strong>
                <span class="crm-builder-tco__detail">{{ $row['saasDetail'] }}</span>
              </td>
              <td class="crm-builder-tco__col--custom">
                <span class="crm-builder-tco__mobile-label">
                  <img
                    src="{{ asset($tco['customIcon']) }}"
                    alt="{{ $tco['customIconAlt'] }}"
                    title="{{ $tco['customIconAlt'] }}"
                    width="16"
                    height="16"
                    decoding="async">
                  <span class="crm-builder-tco__mobile-label-copy">
                    <span class="crm-builder-tco__mobile-label-text">{{ $tco['customHeading'] }}</span>
                    <span class="crm-builder-tco__mobile-label-note">{{ $tco['customNote'] }}</span>
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

<section class="full-bleed crm-builder-modules" aria-labelledby="crm-builder-modules-heading">
  <div class="section-inner crm-builder-modules__inner">
    <div class="crm-builder-modules__intro">
      <p class="crm-builder-modules__eyebrow">
        <span class="crm-builder-modules__eyebrow-bar" aria-hidden="true"></span>
        <span class="crm-builder-modules__eyebrow-text">{{ $modules['eyebrow'] }}</span>
      </p>
      <div class="crm-builder-modules__copy">
        <h2 id="crm-builder-modules-heading" class="home-type-h2 crm-builder-modules__title font-['PP_Mori'] font-semibold text-[24px] leading-[100%] tracking-[-1%] text-[#171717]">{{ $modules['title'] }}</h2>
        <p class="crm-builder-modules__desc">{{ $modules['description'] }}</p>
      </div>
    </div>

    <div class="crmModulesSwiper swiper crm-builder-modules__swiper" aria-label="{{ $modules['eyebrow'] }}">
      <div class="swiper-wrapper">
        @foreach ($modules['items'] as $module)
          <div class="swiper-slide">
            <article class="crm-builder-modules__card">
              <div class="crm-builder-modules__media">
                @if (filled($module['image']))
                  <img
                    class="crm-builder-modules__shot"
                    src="{{ asset($module['image']) }}"
                    alt="{{ $module['imageAlt'] }}"
                    title="{{ $module['imageAlt'] }}"
                    width="400"
                    height="180"
                    loading="lazy"
                    decoding="async">
                @else
                  <span class="crm-builder-modules__media-placeholder" aria-hidden="true"></span>
                @endif
                <span class="crm-builder-modules__badge">
                  @if (filled($module['icon']))
                    <img
                      src="{{ asset($module['icon']) }}"
                      alt="{{ $module['iconAlt'] }}"
                      title="{{ $module['iconAlt'] }}"
                      width="24"
                      height="24"
                      loading="lazy"
                      decoding="async">
                  @else
                    <span class="crm-builder-modules__icon-placeholder" aria-hidden="true"></span>
                  @endif
                </span>
              </div>
              <div class="crm-builder-modules__body">
                <h3 class="crm-builder-modules__card-title">{{ $module['title'] }}</h3>
                <p class="crm-builder-modules__card-copy">{{ $module['copy'] }}</p>
                <ul class="crm-builder-modules__tags">
                  @foreach ($module['tags'] as $tag)
                    <li>{{ $tag }}</li>
                  @endforeach
                </ul>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    </div>

    <div class="crm-builder-modules__footer">
      <div class="crm-builder-modules__nav">
        <button class="crm-builder-modules__prev offerings-control" type="button" aria-label="Previous technical capability">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="crm-builder-modules__next offerings-control" type="button" aria-label="Next technical capability">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <x-frontend.cta-button :href="$demoHref">{{ $modules['cta'] }}</x-frontend.cta-button>
    </div>
  </div>
</section>

<section
  class="full-bleed crm-builder-verticals"
  style="background-image: url('{{ asset($verticals['backgroundImage']) }}');"
  aria-labelledby="crm-builder-verticals-heading">
  <div class="section-inner crm-builder-verticals__inner">
    <div class="crm-builder-verticals__intro">
      <p class="crm-builder-verticals__eyebrow">
        <span class="crm-builder-verticals__eyebrow-bar" aria-hidden="true"></span>
        <span class="crm-builder-verticals__eyebrow-text">{{ $verticals['eyebrow'] }}</span>
      </p>
      <div class="crm-builder-verticals__copy">
        <h2 id="crm-builder-verticals-heading" class="home-type-h2 crm-builder-verticals__title">{{ $verticals['title'] }}</h2>
        <p class="crm-builder-verticals__desc">
          <span class="crm-builder-verticals__desc-line">{{ $verticals['description'] }}</span>
          <span class="crm-builder-verticals__desc-line">{{ $verticals['descriptionLine'] }}</span>
        </p>
      </div>
    </div>

    <div class="crm-builder-verticals__layout">
      <div class="crmVerticalsSwiper swiper crm-builder-verticals__swiper" aria-label="{{ $verticals['eyebrow'] }}">
        <div class="swiper-wrapper">
          @foreach ($verticals['items'] as $vertical)
            <div class="swiper-slide">
              <article class="crm-builder-verticals__panel">
                <span class="crm-builder-verticals__badge">
                  @if (filled($vertical['icon']))
                    <img
                      src="{{ asset($vertical['icon']) }}"
                      alt="{{ $vertical['iconAlt'] }}"
                      title="{{ $vertical['iconAlt'] }}"
                      width="28"
                      height="28"
                      loading="lazy"
                      decoding="async">
                  @else
                    <span class="crm-builder-verticals__icon-placeholder" aria-hidden="true"></span>
                  @endif
                </span>
                <h3 class="crm-builder-verticals__panel-title">{{ $vertical['title'] }}</h3>
                <div class="crm-builder-verticals__block">
                  <p class="crm-builder-verticals__kicker crm-builder-verticals__kicker--challenge">{{ $verticals['challengeLabel'] }}</p>
                  <p class="crm-builder-verticals__text">{{ $vertical['challenge'] }}</p>
                </div>
                <div class="crm-builder-verticals__block">
                  <p class="crm-builder-verticals__kicker crm-builder-verticals__kicker--architecture">{{ $verticals['architectureLabel'] }}</p>
                  <p class="crm-builder-verticals__text">
                    {{ $vertical['architecture'] }}
                    @if (filled($vertical['proofRoute'] ?? null) && filled($vertical['proofLabel'] ?? null))
                      {{ $vertical['proofPrefix'] ?? 'See' }}
                      <a href="{{ route($vertical['proofRoute']) }}" class="crm-builder-verticals__proof-link">{{ $vertical['proofLabel'] }}</a>.
                    @endif
                  </p>
                </div>
              </article>
            </div>
          @endforeach
        </div>
      </div>
      <div class="crm-builder-verticals__nav">
        <button class="crm-builder-verticals__prev offerings-control" type="button" aria-label="Previous industry">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="crm-builder-verticals__next offerings-control" type="button" aria-label="Next industry">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div
        class="crm-builder-verticals__list"
        role="tablist"
        aria-label="{{ $verticals['eyebrow'] }}"
        style="--crm-vertical-count: {{ count($verticals['items']) }}">
        @foreach ($verticals['items'] as $vertical)
          <div class="crm-builder-verticals__item">
            <button
              type="button"
              class="crm-builder-verticals__trigger{{ $loop->first ? ' is-active' : '' }}"
              id="crm-vertical-tab-{{ $vertical['id'] }}"
              role="tab"
              aria-selected="{{ $loop->first ? 'true' : 'false' }}"
              aria-controls="crm-vertical-panel-{{ $vertical['id'] }}"
              data-vertical="{{ $vertical['id'] }}">
              <span class="crm-builder-verticals__number">{{ $vertical['number'] }}</span>
              <span class="crm-builder-verticals__label">{{ $vertical['title'] }}</span>
            </button>
            <article
              class="crm-builder-verticals__panel{{ $loop->first ? ' is-active' : '' }}"
              id="crm-vertical-panel-{{ $vertical['id'] }}"
              role="tabpanel"
              aria-labelledby="crm-vertical-tab-{{ $vertical['id'] }}"
              @unless ($loop->first) hidden @endunless>
              <span class="crm-builder-verticals__badge">
                @if (filled($vertical['icon']))
                  <img
                    src="{{ asset($vertical['icon']) }}"
                    alt="{{ $vertical['iconAlt'] }}"
                    title="{{ $vertical['iconAlt'] }}"
                    width="28"
                    height="28"
                    loading="lazy"
                    decoding="async">
                @else
                  <span class="crm-builder-verticals__icon-placeholder" aria-hidden="true"></span>
                @endif
              </span>
              <h3 class="crm-builder-verticals__panel-title">{{ $vertical['title'] }}</h3>
              <div class="crm-builder-verticals__block">
                <p class="crm-builder-verticals__kicker crm-builder-verticals__kicker--challenge">{{ $verticals['challengeLabel'] }}</p>
                <p class="crm-builder-verticals__text">{{ $vertical['challenge'] }}</p>
              </div>
              <div class="crm-builder-verticals__block">
                <p class="crm-builder-verticals__kicker crm-builder-verticals__kicker--architecture">{{ $verticals['architectureLabel'] }}</p>
                <p class="crm-builder-verticals__text">
                  {{ $vertical['architecture'] }}
                  @if (filled($vertical['proofRoute'] ?? null) && filled($vertical['proofLabel'] ?? null))
                    {{ $vertical['proofPrefix'] ?? 'See' }}
                    <a href="{{ route($vertical['proofRoute']) }}" class="crm-builder-verticals__proof-link">{{ $vertical['proofLabel'] }}</a>.
                  @endif
                </p>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<section class="full-bleed full-bleed--edge crm-builder-stack" aria-labelledby="crm-builder-stack-heading">
  <div class="section-inner crm-builder-stack__inner">
    <div class="crm-builder-stack__intro">
      <p class="crm-builder-stack__eyebrow">
        <span class="crm-builder-stack__eyebrow-bar" aria-hidden="true"></span>
        <span class="crm-builder-stack__eyebrow-text">{{ $stack['eyebrow'] }}</span>
      </p>
      <div class="crm-builder-stack__copy">
        <h2 id="crm-builder-stack-heading" class="home-type-h2 crm-builder-stack__title">{{ $stack['title'] }}</h2>
      </div>
    </div>

    <div class="crm-builder-stack__grid">
      @foreach ($stack['items'] as $group)
        <article class="crm-builder-stack__card">
          <div class="crm-builder-stack__media">
            @if (filled($group['image']))
              <img
                class="crm-builder-stack__shot"
                src="{{ asset($group['image']) }}"
                alt="{{ $group['imageAlt'] }}"
                title="{{ $group['imageAlt'] }}"
                width="280"
                height="160"
                loading="lazy"
                decoding="async">
            @else
              <span class="crm-builder-stack__media-placeholder" aria-hidden="true"></span>
            @endif
          </div>
          <h3 class="crm-builder-stack__card-title">{{ $group['title'] }}</h3>
          <ul class="crm-builder-stack__list">
            @foreach ($group['items'] as $item)
              <li>{{ $item }}</li>
            @endforeach
          </ul>
        </article>
      @endforeach
    </div>
  </div>

  @if (count($stackMarquee) > 0)
    <div
      class="crm-builder-stack-marquee"
      aria-label="Technologies used in custom CRM software development"
      tabindex="0">
      <div class="crm-builder-stack-marquee__track">
        @for ($g = 0; $g < 4; $g++)
          <div class="crm-builder-stack-marquee__group" @if ($g > 0) aria-hidden="true" @endif>
            @foreach ($stackMarquee as $tech)
              <span class="crm-builder-stack-marquee__pill">
                <img
                  src="{{ asset($tech['src']) }}"
                  alt="{{ $tech['alt'] }}"
                  title="{{ $tech['alt'] }}"
                  width="18"
                  height="18"
                  loading="lazy"
                  decoding="async">
                <span>{{ $tech['label'] }}</span>
              </span>
            @endforeach
          </div>
        @endfor
      </div>
    </div>
  @endif
</section>

<section class="full-bleed crm-builder-pillars" aria-labelledby="crm-builder-pillars-heading">
  <div class="section-inner crm-builder-pillars__inner">
    <div class="crm-builder-pillars__intro">
      <p class="crm-builder-pillars__eyebrow">
        <span class="crm-builder-pillars__eyebrow-bar" aria-hidden="true"></span>
        <span class="crm-builder-pillars__eyebrow-text">{{ $valuePillars['eyebrow'] }}</span>
      </p>
      <h2 id="crm-builder-pillars-heading" class="home-type-h2 crm-builder-pillars__title">{{ $valuePillars['title'] }}</h2>
    </div>

    <div class="crm-builder-pillars__grid">
      @foreach ($valuePillars['items'] as $pillar)
        <article class="crm-builder-pillars__card">
          <span class="crm-builder-pillars__icon">
            @if (filled($pillar['icon']))
              <img
                src="{{ asset($pillar['icon']) }}"
                alt="{{ $pillar['iconAlt'] }}"
                title="{{ $pillar['iconAlt'] }}"
                width="28"
                height="28"
                loading="lazy"
                decoding="async">
            @else
              <span class="crm-builder-pillars__icon-placeholder" aria-hidden="true"></span>
            @endif
          </span>
          <h3 class="crm-builder-pillars__card-title">{{ $pillar['title'] }}</h3>
          <p class="crm-builder-pillars__card-copy">{{ $pillar['copy'] }}</p>
        </article>
      @endforeach
    </div>

    <div class="crm-builder-pillars__cta">
      <x-frontend.cta-button :href="$demoHref">{{ $valuePillars['cta'] }}</x-frontend.cta-button>
    </div>
  </div>
</section>

<section
  class="full-bleed crm-builder-stands-out"
  style="background-image: url('{{ asset($standsOut['backgroundImage']) }}');"
  aria-labelledby="crm-builder-stands-out-heading">
  <div class="section-inner crm-builder-stands-out__inner">
    <div class="crm-builder-stands-out__intro">
      <p class="crm-builder-stands-out__eyebrow">
        <span class="crm-builder-stands-out__eyebrow-bar" aria-hidden="true"></span>
        <span class="crm-builder-stands-out__eyebrow-text">{{ $standsOut['eyebrow'] }}</span>
      </p>
      <h2 id="crm-builder-stands-out-heading" class="home-type-h2 crm-builder-stands-out__title">{{ $standsOut['title'] }}</h2>
    </div>

    <div class="crm-builder-stands-out__grid">
      @foreach ($standsOut['items'] as $item)
        <article class="crm-builder-stands-out__card">
          <div class="crm-builder-stands-out__media">
            @if (filled($item['image']))
              <img
                class="crm-builder-stands-out__shot"
                src="{{ asset($item['image']) }}"
                alt="{{ $item['imageAlt'] }}"
                title="{{ $item['imageAlt'] }}"
                width="784"
                height="392"
                loading="lazy"
                decoding="async">
            @else
              <span class="crm-builder-stands-out__media-placeholder" aria-hidden="true"></span>
            @endif
          </div>
          <div class="crm-builder-stands-out__body">
            <p class="crm-builder-stands-out__number">{{ $item['number'] }}</p>
            <h3 class="crm-builder-stands-out__card-title">{{ $item['title'] }}</h3>
            <p class="crm-builder-stands-out__card-copy">{{ $item['copy'] }}</p>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>

<section
  class="full-bleed crm-builder-execution"
  style="background-image: url('{{ asset($execution['backgroundImage']) }}');"
  aria-labelledby="crm-builder-execution-heading">
  <div class="section-inner crm-builder-execution__inner">
    <div class="crm-builder-execution__intro">
      <p class="crm-builder-execution__eyebrow">
        <span class="crm-builder-execution__eyebrow-bar" aria-hidden="true"></span>
        <span class="crm-builder-execution__eyebrow-text">{{ $execution['eyebrow'] }}</span>
      </p>
      <h2 id="crm-builder-execution-heading" class="home-type-h2 crm-builder-execution__title">{{ $execution['title'] }}</h2>
    </div>

    <ol class="crm-builder-execution__steps">
      @foreach ($execution['items'] as $step)
        <li class="crm-builder-execution__step crm-builder-execution__step--{{ $step['tone'] }}">
          <span class="crm-builder-execution__number">{{ $step['number'] }}</span>
          <article class="crm-builder-execution__card">
            <span class="crm-builder-execution__icon">
              @if (filled($step['icon']))
                <img
                  src="{{ asset($step['icon']) }}"
                  alt="{{ $step['iconAlt'] }}"
                  title="{{ $step['iconAlt'] }}"
                  width="28"
                  height="28"
                  loading="lazy"
                  decoding="async">
              @else
                <span class="crm-builder-execution__icon-placeholder" aria-hidden="true"></span>
              @endif
            </span>
            <div class="crm-builder-execution__content">
              <h3 class="crm-builder-execution__step-title">{{ $step['title'] }}</h3>
              <p class="crm-builder-execution__step-copy">{{ $step['copy'] }}</p>
              <p class="crm-builder-execution__deliverable">
                <span class="crm-builder-execution__check" aria-hidden="true">
                  <svg viewBox="0 0 16 16" width="16" height="16" focusable="false">
                    <circle cx="8" cy="8" r="8" fill="currentColor"></circle>
                    <path d="M4.6 8.2 6.8 10.4 11.4 5.7" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </span>
                <span class="crm-builder-execution__deliverable-text">
                  <strong>{{ $execution['deliverableLabel'] }}</strong>
                  {{ $step['deliverable'] }}
                </span>
              </p>
            </div>
          </article>
        </li>
      @endforeach
    </ol>
  </div>
</section>

<section
  class="full-bleed crm-builder-results"
  style="background-image: url('{{ asset($results['backgroundImage']) }}');"
  aria-labelledby="crm-builder-results-heading">
  <div class="section-inner crm-builder-results__inner">
    <div class="crm-builder-results__intro">
      <p class="crm-builder-results__eyebrow">
        <span class="crm-builder-results__eyebrow-bar" aria-hidden="true"></span>
        <span class="crm-builder-results__eyebrow-text">{{ $results['eyebrow'] }}</span>
      </p>
      <h2 id="crm-builder-results-heading" class="home-type-h2 crm-builder-results__title">{{ $results['title'] }}</h2>
    </div>

    <div class="crm-builder-results__layout">
      <div class="crm-builder-results__copy">
        <h3 class="crm-builder-results__story-title">{{ $results['storyTitle'] }}</h3>
        <p class="crm-builder-results__story-copy">{{ $results['storyCopy'] }}</p>
        <div class="crm-builder-results__cta">
          <x-frontend.cta-button :href="route($results['ctaRoute'])">{{ $results['cta'] }}</x-frontend.cta-button>
        </div>
      </div>

      <div class="crm-builder-results__panel">
        @foreach ($results['items'] as $metric)
          <article class="crm-builder-results__metric">
            <span class="crm-builder-results__icon">
              @if (filled($metric['icon']))
                <img
                  src="{{ asset($metric['icon']) }}"
                  alt="{{ $metric['iconAlt'] }}"
                  title="{{ $metric['iconAlt'] }}"
                  width="52"
                  height="56"
                  loading="lazy"
                  decoding="async">
              @else
                <span class="crm-builder-results__icon-placeholder" aria-hidden="true"></span>
              @endif
            </span>
            <p class="crm-builder-results__value">{{ $metric['value'] }}</p>
            <p class="crm-builder-results__label">{{ $metric['label'] }}</p>
          </article>
        @endforeach
      </div>
    </div>
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
  heading-id="crm-builder-faq-heading"
  question-heading="h3"
  class="faq-section--crm-builder bg-cover bg-top bg-no-repeat"
  style="background-image: url('{{ asset($faq['backgroundImage']) }}')"
/>

<x-frontend.articles-insights-section
  :items="$articles"
  heading-id="crm-builder-insights-title"
  eyebrow="Blogs and Insights"
  title="Explore Technical Insights on Custom Software Architecture"
  subtitle=""
  section-class="section-pad-m py-6 lg:py-18"
  more-href="{{ route('blogs') }}"
  more-label="View all blog articles"
/>

<x-frontend.consultation-section
  :eyebrow="$consultation['eyebrow']"
  :title="$consultation['title']"
  :description="$consultation['description']"
  :cta-label="$consultation['ctaLabel']"
  :secondary-cta-label="$consultation['secondaryCtaLabel']"
  :secondary-cta-href="$demoHref"
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
    var panel = document.querySelector('.crm-builder-tco__panel');
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
    document.querySelectorAll('.crmVerticalsSwiper:not(.swiper-initialized)').forEach(function (el) {
      var root = el.closest('.crm-builder-verticals');
      if (!root) return;

      var mobileQuery = window.matchMedia('(max-width: 767px)');
      var verticalsSwiper = null;

      function mountVerticalsSwiper() {
        if (!mobileQuery.matches) {
          if (verticalsSwiper) {
            verticalsSwiper.destroy(true, true);
            verticalsSwiper = null;
          }
          return;
        }

        if (verticalsSwiper || el.classList.contains('swiper-initialized')) return;

        verticalsSwiper = new Swiper(el, {
          slidesPerView: 1,
          spaceBetween: 16,
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
            nextEl: root.querySelector('.crm-builder-verticals__next'),
            prevEl: root.querySelector('.crm-builder-verticals__prev')
          },
          a11y: {
            prevSlideMessage: 'Previous industry',
            nextSlideMessage: 'Next industry',
            containerMessage: 'Industries carousel'
          }
        });
      }

      mountVerticalsSwiper();
      mobileQuery.addEventListener('change', mountVerticalsSwiper);
    });

    document.querySelectorAll('.crmModulesSwiper:not(.swiper-initialized)').forEach(function (el) {
      var root = el.closest('.crm-builder-modules');
      if (!root) return;

      new Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 20,
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
          nextEl: root.querySelector('.crm-builder-modules__next'),
          prevEl: root.querySelector('.crm-builder-modules__prev')
        },
        a11y: {
          prevSlideMessage: 'Previous technical capability',
          nextSlideMessage: 'Next technical capability',
          containerMessage: 'Technical capabilities carousel'
        },
        breakpoints: {
          640: { slidesPerView: 2, spaceBetween: 20 },
          1024: { slidesPerView: 3, spaceBetween: 24 }
        }
      });
    });
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var root = document.querySelector('.crm-builder-verticals');
    if (!root) return;

    var triggers = root.querySelectorAll('.crm-builder-verticals__trigger');
    var panels = root.querySelectorAll('.crm-builder-verticals__panel');
    if (!triggers.length || !panels.length) return;

    function activate(id) {
      triggers.forEach(function (trigger) {
        var isActive = trigger.getAttribute('data-vertical') === id;
        trigger.classList.toggle('is-active', isActive);
        trigger.setAttribute('aria-selected', isActive ? 'true' : 'false');
        trigger.setAttribute('tabindex', isActive ? '0' : '-1');
      });

      panels.forEach(function (panel) {
        var isActive = panel.id === 'crm-vertical-panel-' + id;
        panel.classList.toggle('is-active', isActive);
        panel.hidden = !isActive;
      });
    }

    triggers.forEach(function (trigger, index) {
      trigger.setAttribute('tabindex', index === 0 ? '0' : '-1');
      trigger.addEventListener('click', function () {
        activate(trigger.getAttribute('data-vertical'));
      });
      trigger.addEventListener('keydown', function (event) {
        var next = null;
        if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
          next = triggers[index + 1] || triggers[0];
        } else if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
          next = triggers[index - 1] || triggers[triggers.length - 1];
        } else if (event.key === 'Home') {
          next = triggers[0];
        } else if (event.key === 'End') {
          next = triggers[triggers.length - 1];
        }
        if (!next) return;
        event.preventDefault();
        next.focus();
        activate(next.getAttribute('data-vertical'));
      });
    });
  });
</script>
@endpush
