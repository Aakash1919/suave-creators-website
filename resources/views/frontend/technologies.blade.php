@extends('layouts.frontend')

@push('custom-css')
<link rel="preload" as="image" href="{{ asset($bannerBackgroundImage) }}?v={{ filemtime(public_path($bannerBackgroundImage)) }}" type="image/webp">
@if (filled($heroVisualImage))
<link rel="preload" as="image" href="{{ asset($heroVisualImage) }}" type="image/webp">
@endif
@endpush

@section('content')

<section
  class="full-bleed technologies-hero"
  style="background-image: url('{{ asset($bannerBackgroundImage) }}?v={{ filemtime(public_path($bannerBackgroundImage)) }}');"
  aria-labelledby="technologies-heading">
  <div class="section-inner technologies-hero__inner">
    <nav class="technologies-hero__breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span aria-hidden="true">›</span>
      <span aria-current="page">Technologies</span>
    </nav>

    <div class="technologies-hero__layout">
      <div class="technologies-hero__copy">
        <p class="technologies-hero__eyebrow">{{ $eyebrow }}</p>
        <h1 id="technologies-heading" class="page-hero-title technologies-hero__title">
          <span class="technologies-hero__title-lead">{{ $heroLead }}</span>
          <span class="technologies-hero__title-line">{{ $heroMid }} <span class="technologies-hero__title-blue">{{ $heroBlue }}</span></span>
          <span class="technologies-hero__title-blue">{{ $heroBlueLine }}</span>
          <span class="technologies-hero__title-purple">{{ $heroPurple }}</span>
        </h1>
        <p class="technologies-hero__desc">{{ $heroDescriptionBefore }}@foreach ($heroDescriptionNames as $item)<strong>{{ $item['name'] }}</strong>{{ $item['separator'] }}@endforeach{{ $heroDescriptionAfter }}</p>
        <div class="technologies-hero__cta">
          <x-frontend.cta-button href="#contact-modal">{{ $primaryCta }}</x-frontend.cta-button>
          <button type="button" class="technologies-hero__hire group" data-inquiry-dialog-open="hire-developers">
            {{ $secondaryCta }}
            <x-frontend.cta-arrow />
          </button>
        </div>
        <ul class="technologies-hero__trust">
          @foreach ($trust as $item)
            <li class="technologies-hero__trust-item">
              <span class="technologies-hero__trust-icon" aria-hidden="true">
                <img
                  src="{{ asset($item['icon']) }}"
                  alt="{{ $item['iconAlt'] }}"
                  title="{{ $item['iconAlt'] }}"
                  width="99"
                  height="104"
                  decoding="async">
              </span>
              <span class="technologies-hero__trust-label">
                @foreach ($item['lines'] as $line)
                  {{ $line }}@if (! $loop->last)<br>@endif
                @endforeach
              </span>
            </li>
          @endforeach
        </ul>
      </div>

      <div class="technologies-hero__visual">
        @if (filled($heroVisualImage))
          <img
            class="technologies-hero__image"
            src="{{ asset($heroVisualImage) }}"
            alt="{{ $heroVisualLabel }}"
            title="{{ $heroVisualLabel }}"
            width="1024"
            height="706"
            decoding="async"
            fetchpriority="high">
        @else
          <span class="technologies-hero__image-placeholder" role="img" aria-label="{{ $heroVisualLabel }}"></span>
        @endif
      </div>
    </div>
  </div>
</section>

<section class="full-bleed technologies-stack" aria-labelledby="technologies-stack-heading">
  <div class="section-inner technologies-stack__inner">
    <div class="technologies-stack__intro">
      <p class="technologies-stack__eyebrow">{{ $stack['eyebrow'] }}</p>
      <div class="technologies-stack__intro-copy">
        <h2 id="technologies-stack-heading" class="technologies-stack__title"><span class="technologies-stack__title-our">{{ $stack['titleOur'] }}</span> <span class="technologies-stack__title-accent">{{ $stack['titleAccent'] }}</span></h2>
        <p class="technologies-stack__desc">{{ $stack['description'] }}</p>
      </div>
    </div>

    <ul class="technologies-stack__grid">
      @foreach ($stack['items'] as $item)
        <li class="technologies-stack__card technologies-stack__card--{{ $item['tone'] }}">
          <div class="technologies-stack__card-head">
            @if (filled($item['logo']))
              <img
                class="technologies-stack__logo"
                src="{{ asset($item['logo']) }}"
                alt="{{ $item['logoAlt'] }}"
                title="{{ $item['logoAlt'] }}"
                width="36"
                height="36"
                decoding="async"
                loading="lazy">
            @else
              <span class="technologies-stack__logo-placeholder" role="img" aria-label="{{ $item['logoAlt'] }}"></span>
            @endif
            <div class="technologies-stack__title-row">
              <h3 class="technologies-stack__name"><a href="#{{ $item['anchor'] }}">{{ $item['name'] }}</a></h3>
              <span class="technologies-stack__role">{{ $item['role'] }}</span>
            </div>
            <p class="technologies-stack__usage"><strong>Typical use:</strong> {{ $item['usage'] }}</p>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
</section>

<section
  class="full-bleed technologies-backend"
  @if (filled($backend['backgroundImage']))
    style="background-image: url('{{ asset($backend['backgroundImage']) }}?v={{ filemtime(public_path($backend['backgroundImage'])) }}');"
  @endif
  aria-labelledby="technologies-backend-heading">
  <div class="section-inner technologies-backend__inner">
    <div class="technologies-backend__intro">
      <p class="technologies-backend__eyebrow">{{ $backend['eyebrow'] }}</p>
      <div class="technologies-backend__intro-copy">
        <h2 id="technologies-backend-heading" class="technologies-backend__title">
          {{ $backend['titleLead'] }}
          <span class="technologies-backend__title-laravel">{{ $backend['titleLaravel'] }}</span>
          {{ $backend['titleJoin'] }}
          <span class="technologies-backend__title-node">{{ $backend['titleNode'] }}</span>
        </h2>
        <p class="technologies-backend__desc">{{ $backend['description'] }}</p>
      </div>
    </div>

    <div class="technologies-backend__columns">
      @foreach ($backend['columns'] as $column)
        <article id="{{ $column['id'] }}" class="technologies-backend__card technologies-backend__card--{{ $column['key'] }}">
          <div class="technologies-backend__summary">
            @if (filled($column['logo']))
              <img
                class="technologies-backend__logo"
                src="{{ asset($column['logo']) }}"
                alt="{{ $column['logoAlt'] }}"
                title="{{ $column['logoAlt'] }}"
                width="36"
                height="36"
                decoding="async"
                loading="lazy">
            @else
              <span class="technologies-backend__logo-placeholder" role="img" aria-label="{{ $column['logoAlt'] }}"></span>
            @endif
            <div>
              <h3 class="technologies-backend__name">{{ $column['name'] }}</h3>
              <p @class(['technologies-backend__summary-copy' => in_array($column['key'], ['laravel', 'node'], true)])>{{ $column['summary'] }}</p>
            </div>
          </div>

          <div class="technologies-backend__body">
            @if ($column['builds'] !== [])
              <h4 class="technologies-backend__label">What we build</h4>
              <ul class="technologies-backend__builds">
                @foreach ($column['builds'] as $build)
                  <li>{{ $build }}</li>
                @endforeach
              </ul>
            @endif

            @if (filled($column['why']))
              <h4 class="technologies-backend__label">
                <svg class="technologies-backend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M2.5 13.5h11M3.5 13.5V7.2L8 4.2l4.5 3V13.5M6.4 13.5v-3h3.2v3" fill="none" stroke="#8eb6ff" stroke-width="1.3" stroke-linejoin="round"/></svg>
                Why businesses choose it
              </h4>
              <p class="technologies-backend__copy">{{ $column['why'] }}</p>
            @endif

            @if (filled($column['consider']))
              <h4 class="technologies-backend__label">
                <svg class="technologies-backend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="m8 2.2 6 10.6H2L8 2.2Z" fill="none" stroke="#f5b942" stroke-width="1.3" stroke-linejoin="round"/><path d="M8 6.2v3.1" stroke="#f5b942" stroke-width="1.3" stroke-linecap="round"/><circle cx="8" cy="11" r="0.6" fill="#f5b942"/></svg>
                {{ $column['considerLabel'] }}
              </h4>
              <p class="technologies-backend__copy">{{ $column['consider'] }}</p>
            @endif

            @if (filled($column['works']))
              <h4 class="technologies-backend__label">
                <svg class="technologies-backend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.2 9.2 4.6 10.8a2.2 2.2 0 0 1-3.1-3.1L3.1 6.1a2.2 2.2 0 0 1 3.1 0M9.8 6.8l1.6-1.6a2.2 2.2 0 0 1 3.1 3.1L13 9.9a2.2 2.2 0 0 1-3.1 0M6.4 9.6l3.2-3.2" fill="none" stroke="#7eb6ff" stroke-width="1.3" stroke-linecap="round"/></svg>
                {{ $column['worksLabel'] }}
              </h4>
              <p class="technologies-backend__copy">{{ $column['works'] }}</p>
            @endif
          </div>

          <button
            type="button"
            class="technologies-backend__more"
            aria-expanded="false"
            data-technologies-backend-more>
            Read more
          </button>
        </article>
      @endforeach
    </div>

    <div class="technologies-backend__chooser">
      <h3 class="technologies-backend__chooser-title">{{ $backend['chooser']['title'] }}</h3>
      <div class="technologies-backend__chooser-head">
        <p>{{ $backend['chooser']['situationHeading'] }}</p>
        <p>{{ $backend['chooser']['choiceHeading'] }}</p>
      </div>
      @foreach ($backend['chooser']['rows'] as $row)
        <div class="technologies-backend__chooser-row">
          <p class="technologies-backend__situation">
            @if ($row['icon'] === 'database')
              <svg class="technologies-backend__situation-icon" viewBox="0 0 16 16" aria-hidden="true"><ellipse cx="8" cy="4" rx="4.5" ry="1.8" fill="none" stroke="currentColor" stroke-width="1.3"/><path d="M3.5 4v8c0 1 2 1.8 4.5 1.8s4.5-.8 4.5-1.8V4M3.5 8c0 1 2 1.8 4.5 1.8s4.5-.8 4.5-1.8" fill="none" stroke="currentColor" stroke-width="1.3"/></svg>
            @elseif ($row['icon'] === 'live')
              <svg class="technologies-backend__situation-icon" viewBox="0 0 16 16" aria-hidden="true"><path d="M3.2 6.2a4.8 4.8 0 0 1 9.6 0M5 8.2a2.6 2.6 0 0 1 6 0" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><circle cx="8" cy="11.2" r="1" fill="currentColor"/></svg>
            @else
              <svg class="technologies-backend__situation-icon" viewBox="0 0 16 16" aria-hidden="true"><path d="M9.2 3.2 12.8 6.8 6.2 13.4H2.6V9.8L9.2 3.2Z" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/></svg>
            @endif
            {{ $row['situation'] }}
          </p>
          <div class="technologies-backend__picks">
            @foreach ($row['picks'] as $pick)
              @if (! $loop->first)
                <span class="technologies-backend__plus" aria-hidden="true">+</span>
              @endif
              <span class="technologies-backend__pick">
                @if (filled($pick['logo']))
                  <img
                    class="technologies-backend__pick-logo"
                    src="{{ asset($pick['logo']) }}"
                    alt="{{ $pick['logoAlt'] }}"
                    title="{{ $pick['logoAlt'] }}"
                    width="18"
                    height="18"
                    decoding="async"
                    loading="lazy">
                @else
                  <span class="technologies-backend__pick-placeholder technologies-backend__pick-placeholder--{{ $pick['key'] }}" role="img" aria-label="{{ $pick['logoAlt'] }}"></span>
                @endif
                {{ $pick['name'] }}
              </span>
            @endforeach
            @if (filled($row['note']))
              <span class="technologies-backend__note">{{ $row['note'] }}</span>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="full-bleed technologies-frontend" aria-labelledby="technologies-frontend-heading">
  <div class="section-inner technologies-frontend__inner">
    <div class="technologies-frontend__intro">
      <p class="technologies-frontend__eyebrow">{{ $frontend['eyebrow'] }}</p>
      <div class="technologies-frontend__intro-copy">
        <h2 id="technologies-frontend-heading" class="technologies-frontend__title">
          {{ $frontend['titleLead'] }}
          <span class="technologies-frontend__title-react">{{ $frontend['titleReact'] }}</span>
          <span class="technologies-frontend__title-angular">{{ $frontend['titleAngular'] }}</span>
          {{ $frontend['titleJoin'] }}
          <span class="technologies-frontend__title-vue">{{ $frontend['titleVue'] }}</span>
        </h2>
        <p class="technologies-frontend__desc">{{ $frontend['description'] }}</p>
      </div>
    </div>

    <div class="technologies-frontend__columns">
      @foreach ($frontend['columns'] as $column)
        <article id="{{ $column['id'] }}" class="technologies-frontend__card technologies-frontend__card--{{ $column['key'] }}">
          <div class="technologies-frontend__summary">
            @if (filled($column['logo']))
              <img
                class="technologies-frontend__logo"
                src="{{ asset($column['logo']) }}"
                alt="{{ $column['logoAlt'] }}"
                title="{{ $column['logoAlt'] }}"
                width="36"
                height="36"
                decoding="async"
                loading="lazy">
            @else
              <span class="technologies-frontend__logo-placeholder" role="img" aria-label="{{ $column['logoAlt'] }}"></span>
            @endif
            <div>
              <h3 class="technologies-frontend__name">{{ $column['name'] }}</h3>
              <p>{{ $column['summary'] }}</p>
            </div>
          </div>

          <div class="technologies-frontend__body">
          @if ($column['builds'] !== [])
            <h4 class="technologies-frontend__label">What we build</h4>
            <ul class="technologies-frontend__builds" style="--technologies-build-mark: url('{{ asset('assets/icons/green-circle-check-icon.png') }}?v={{ filemtime(public_path('assets/icons/green-circle-check-icon.png')) }}')">
              @foreach ($column['builds'] as $build)
                <li>{{ $build }}</li>
              @endforeach
            </ul>
          @endif

          @if (filled($column['why']))
            <h4 class="technologies-frontend__label">
              <svg class="technologies-frontend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 4.5h10v7.2H3V4.5Z" fill="none" stroke="#3b82f6" stroke-width="1.3"/><path d="M6 13.2h4M8 11.7V13.2" stroke="#3b82f6" stroke-width="1.3" stroke-linecap="round"/></svg>
              Why businesses choose it
            </h4>
            <p class="technologies-frontend__copy">{{ $column['why'] }}</p>
          @endif

          @if (filled($column['consider']))
            <h4 class="technologies-frontend__label">
              <svg class="technologies-frontend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="m8 2.2 6 10.6H2L8 2.2Z" fill="none" stroke="#f5b942" stroke-width="1.3" stroke-linejoin="round"/><path d="M8 6.2v3.1" stroke="#f5b942" stroke-width="1.3" stroke-linecap="round"/><circle cx="8" cy="11" r="0.6" fill="#f5b942"/></svg>
              {{ $column['considerLabel'] }}
            </h4>
            <p class="technologies-frontend__copy">{{ $column['consider'] }}</p>
          @endif

          @if (filled($column['works']))
            <h4 class="technologies-frontend__label">
              <svg class="technologies-frontend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.2 9.2 4.6 10.8a2.2 2.2 0 0 1-3.1-3.1L3.1 6.1a2.2 2.2 0 0 1 3.1 0M9.8 6.8l1.6-1.6a2.2 2.2 0 0 1 3.1 3.1L13 9.9a2.2 2.2 0 0 1-3.1 0M6.4 9.6l3.2-3.2" fill="none" stroke="#3b82f6" stroke-width="1.3" stroke-linecap="round"/></svg>
              {{ $column['worksLabel'] }}
            </h4>
            <p class="technologies-frontend__copy">{{ $column['works'] }}</p>
          @endif
          </div>
        </article>
      @endforeach
    </div>

    <div class="technologies-frontend__table-wrap">
      <table class="technologies-frontend__table">
        <thead>
          <tr>
            <th scope="col"><span class="technologies-frontend__corner">Comparison</span></th>
            @foreach ($frontend['compare']['headers'] as $header)
              <th scope="col">{{ $header }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($frontend['compare']['rows'] as $row)
            <tr>
              <th scope="row">{{ $row['label'] }}</th>
              @foreach ($row['cells'] as $index => $cell)
                <td>
                  <span class="technologies-table-label">{{ $frontend['compare']['headers'][$index] }}</span>
                  {{ $cell }}
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

<section
  class="full-bleed technologies-mobile"
  @if (filled($mobile['backgroundImage']))
    style="background-image: url('{{ asset($mobile['backgroundImage']) }}?v={{ filemtime(public_path($mobile['backgroundImage'])) }}');"
  @endif
  aria-labelledby="react-native">
  <div class="section-inner technologies-mobile__inner">
    <div class="technologies-mobile__intro">
      <p class="technologies-mobile__eyebrow">{{ $mobile['eyebrow'] }}</p>
      <h2 id="react-native" class="technologies-mobile__title">
        {{ $mobile['titleLead'] }}
        <span>{{ $mobile['titleAccent'] }}</span>
      </h2>
    </div>

    <div class="technologies-mobile__layout">
      <div class="technologies-mobile__copy">
        <div class="technologies-mobile__brand">
          @if (filled($mobile['logo']))
            <img
              class="technologies-mobile__logo"
              src="{{ asset($mobile['logo']) }}"
              alt="{{ $mobile['logoAlt'] }}"
              title="{{ $mobile['logoAlt'] }}"
              width="40"
              height="40"
              decoding="async"
              loading="lazy">
          @else
            <span class="technologies-mobile__logo-placeholder" role="img" aria-label="{{ $mobile['logoAlt'] }}"></span>
          @endif
          <div>
            <h3 class="technologies-mobile__name">{{ $mobile['name'] }}</h3>
            <p>{{ $mobile['summary'] }}</p>
          </div>
        </div>
        <p class="technologies-mobile__practice">{{ $mobile['practice'] }}</p>
        <ul class="technologies-mobile__points" style="--technologies-build-mark: url('{{ asset('assets/icons/green-circle-check-icon.png') }}?v={{ filemtime(public_path('assets/icons/green-circle-check-icon.png')) }}')">
          @foreach ($mobile['points'] as $point)
            <li>{{ $point }}</li>
          @endforeach
        </ul>
      </div>

      <ul class="technologies-mobile__features">
        @foreach ($mobile['features'] as $feature)
          <li class="technologies-mobile__feature technologies-mobile__feature--{{ $feature['key'] }}">
            <span class="technologies-mobile__feature-icon">
              @if (filled($feature['icon']))
                <img
                  src="{{ asset($feature['icon']) }}"
                  alt="{{ $feature['iconAlt'] }}"
                  title="{{ $feature['iconAlt'] }}"
                  width="40"
                  height="40"
                  decoding="async"
                  loading="lazy">
              @else
                <span class="technologies-mobile__feature-icon-placeholder" role="img" aria-label="{{ $feature['iconAlt'] }}"></span>
              @endif
            </span>
            <h3>{{ $feature['title'] }}</h3>
            <p>{{ $feature['text'] }}</p>
          </li>
        @endforeach
      </ul>

      <div class="technologies-mobile__why-row">
        <div class="technologies-mobile__why">
          <h3>{{ $mobile['whyTitle'] }}</h3>
          <p>{{ $mobile['why'] }}</p>
        </div>
        @if (filled($mobile['consider']))
          <div class="technologies-mobile__why">
            <h3>Consider a different fit when</h3>
            <p>{{ $mobile['consider'] }}</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

<section
  class="full-bleed technologies-cms"
  @if (filled($cms['backgroundImage']))
    style="background-image: url('{{ asset($cms['backgroundImage']) }}?v={{ filemtime(public_path($cms['backgroundImage'])) }}');"
  @endif
  aria-labelledby="technologies-cms-heading">
  <div class="section-inner technologies-cms__inner">
    <div class="technologies-cms__intro">
      <p class="technologies-cms__eyebrow">{{ $cms['eyebrow'] }}</p>
      <div class="technologies-cms__intro-copy">
        <h2 id="technologies-cms-heading" class="technologies-cms__title">
          {{ $cms['titleLead'] }}
          <span class="technologies-cms__title-wordpress">{{ $cms['titleWordPress'] }}</span>
          {{ $cms['titleJoin'] }}
          <span class="technologies-cms__title-headless">{{ $cms['titleHeadless'] }}</span>
        </h2>
        @if (filled($cms['description']))
          <p class="technologies-cms__desc">{{ $cms['description'] }}</p>
        @endif
      </div>
    </div>

    <div class="technologies-cms__columns">
      @foreach ($cms['columns'] as $column)
        <article id="{{ $column['id'] }}" class="technologies-cms__card technologies-cms__card--{{ $column['key'] }}">
          <div class="technologies-cms__summary">
            @if (filled($column['logo']))
              <img
                class="technologies-cms__logo"
                src="{{ asset($column['logo']) }}"
                alt="{{ $column['logoAlt'] }}"
                title="{{ $column['logoAlt'] }}"
                width="36"
                height="36"
                decoding="async"
                loading="lazy">
            @else
              <span class="technologies-cms__logo-placeholder" role="img" aria-label="{{ $column['logoAlt'] }}"></span>
            @endif
            <div>
              <h3 class="technologies-cms__name">{{ $column['name'] }}</h3>
              <p>{{ $column['summary'] }}</p>
            </div>
          </div>

          @if ($column['builds'] !== [])
            <h4 class="technologies-cms__label">What we build</h4>
            <ul class="technologies-cms__builds">
              @foreach ($column['builds'] as $build)
                <li>{{ $build }}</li>
              @endforeach
            </ul>
          @endif

          @if (filled($column['why']))
            <h4 class="technologies-cms__label">
              <svg class="technologies-cms__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 3.2h7.2l2.8 2.8V13H3V3.2Z" fill="none" stroke="#8eb6ff" stroke-width="1.3" stroke-linejoin="round"/><path d="M10 3.4V6h2.6" fill="none" stroke="#8eb6ff" stroke-width="1.3"/></svg>
              Why businesses choose it
            </h4>
            <p class="technologies-cms__copy">{{ $column['why'] }}</p>
          @endif

          @if (filled($column['consider']))
            <h4 class="technologies-cms__label technologies-cms__label--alert">
              <svg class="technologies-cms__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="m8 2.2 6 10.6H2L8 2.2Z" fill="none" stroke="#f5b942" stroke-width="1.3" stroke-linejoin="round"/><path d="M8 6.2v3.1" stroke="#f5b942" stroke-width="1.3" stroke-linecap="round"/><circle cx="8" cy="11" r="0.6" fill="#f5b942"/></svg>
              {{ $column['considerLabel'] }}
            </h4>
            <p class="technologies-cms__copy">{{ $column['consider'] }}</p>
          @endif

          @if (filled($column['works']))
            <h4 class="technologies-cms__label">
              <svg class="technologies-cms__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.2 9.2 4.6 10.8a2.2 2.2 0 0 1-3.1-3.1L3.1 6.1a2.2 2.2 0 0 1 3.1 0M9.8 6.8l1.6-1.6a2.2 2.2 0 0 1 3.1 3.1L13 9.9a2.2 2.2 0 0 1-3.1 0M6.4 9.6l3.2-3.2" fill="none" stroke="#7eb6ff" stroke-width="1.3" stroke-linecap="round"/></svg>
              {{ $column['worksLabel'] }}
            </h4>
            <p class="technologies-cms__copy">{{ $column['works'] }}</p>
          @endif
        </article>
      @endforeach
    </div>
  </div>
</section>

<section class="full-bleed technologies-commerce" aria-labelledby="technologies-commerce-heading">
  <div class="section-inner technologies-commerce__inner">
    <div class="technologies-commerce__intro">
      <p class="technologies-commerce__eyebrow">{{ $commerce['eyebrow'] }}</p>
      <div class="technologies-commerce__intro-copy">
        <h2 id="technologies-commerce-heading" class="technologies-commerce__title">
          {{ $commerce['titleLead'] }}
          <span class="technologies-commerce__title-shopify">{{ $commerce['titleShopify'] }}</span>
          {{ $commerce['titleJoin'] }}
          <span class="technologies-commerce__title-magento">{{ $commerce['titleMagento'] }}</span>
        </h2>
        @if (filled($commerce['description']))
          <p class="technologies-commerce__desc">{{ $commerce['description'] }}</p>
        @endif
      </div>
    </div>

    <div class="technologies-commerce__columns">
      @foreach ($commerce['columns'] as $column)
        <article id="{{ $column['id'] }}" class="technologies-commerce__card technologies-commerce__card--{{ $column['key'] }}">
          <div class="technologies-commerce__summary">
            @if (filled($column['logo']))
              <img
                class="technologies-commerce__logo"
                src="{{ asset($column['logo']) }}"
                alt="{{ $column['logoAlt'] }}"
                title="{{ $column['logoAlt'] }}"
                width="36"
                height="36"
                decoding="async"
                loading="lazy">
            @else
              <span class="technologies-commerce__logo-placeholder" role="img" aria-label="{{ $column['logoAlt'] }}"></span>
            @endif
            <div>
              <h3 class="technologies-commerce__name">{{ $column['name'] }}</h3>
              <p>{{ $column['summary'] }}</p>
            </div>
          </div>

          <div class="technologies-commerce__body">
          @if ($column['builds'] !== [])
            <h4 class="technologies-commerce__label">What we build</h4>
            <ul class="technologies-commerce__builds" style="--technologies-build-mark: url('{{ asset('assets/icons/green-circle-check-icon.png') }}?v={{ filemtime(public_path('assets/icons/green-circle-check-icon.png')) }}')">
              @foreach ($column['builds'] as $build)
                <li>{{ $build }}</li>
              @endforeach
            </ul>
          @endif

          @if (filled($column['why']))
            <h4 class="technologies-commerce__label">
              <svg class="technologies-commerce__mark technologies-commerce__mark--why" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 4.5h10v7.2H3V4.5Z" fill="none" stroke="#fff" stroke-width="1.3"/><path d="M6 13.2h4M8 11.7V13.2" stroke="#fff" stroke-width="1.3" stroke-linecap="round"/></svg>
              Why businesses choose it
            </h4>
            <p class="technologies-commerce__copy">{{ $column['why'] }}</p>
          @endif

          @if (filled($column['consider']))
            <h4 class="technologies-commerce__label">
              <svg class="technologies-commerce__mark technologies-commerce__mark--consider" viewBox="0 0 16 16" aria-hidden="true"><path d="m8 2.2 6 10.6H2L8 2.2Z" fill="none" stroke="#fff" stroke-width="1.3" stroke-linejoin="round"/><path d="M8 6.2v3.1" stroke="#fff" stroke-width="1.3" stroke-linecap="round"/><circle cx="8" cy="11" r="0.6" fill="#fff"/></svg>
              {{ $column['considerLabel'] }}
            </h4>
            <p class="technologies-commerce__copy">{{ $column['consider'] }}</p>
          @endif

          @if (filled($column['works']))
            <h4 class="technologies-commerce__label">
              <svg class="technologies-commerce__mark technologies-commerce__mark--works" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.2 9.2 4.6 10.8a2.2 2.2 0 0 1-3.1-3.1L3.1 6.1a2.2 2.2 0 0 1 3.1 0M9.8 6.8l1.6-1.6a2.2 2.2 0 0 1 3.1 3.1L13 9.9a2.2 2.2 0 0 1-3.1 0M6.4 9.6l3.2-3.2" fill="none" stroke="#fff" stroke-width="1.3" stroke-linecap="round"/></svg>
              {{ $column['worksLabel'] }}
            </h4>
            <p class="technologies-commerce__copy">{{ $column['works'] }}</p>
          @endif
          </div>
        </article>
      @endforeach
    </div>

    <h3 class="technologies-compare-caption">{{ $commerce['compareTitle'] }}</h3>
    <div class="technologies-commerce__table-wrap">
      <table class="technologies-commerce__table">
        <thead>
          <tr>
            <th scope="col"><span class="technologies-commerce__corner">Comparison</span></th>
            @foreach ($commerce['compare']['headers'] as $header)
              <th scope="col">{{ $header }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($commerce['compare']['rows'] as $row)
            <tr>
              <th scope="row">{{ $row['label'] }}</th>
              @foreach ($row['cells'] as $index => $cell)
                <td>
                  <span class="technologies-table-label">{{ $commerce['compare']['headers'][$index] }}</span>
                  {{ $cell }}
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="full-bleed technologies-combinations" aria-labelledby="technologies-combinations-heading">
  <div class="section-inner technologies-combinations__inner">
    <div class="technologies-combinations__intro">
      <p class="technologies-combinations__eyebrow">{{ $combinations['eyebrow'] }}</p>
      <div class="technologies-combinations__intro-copy">
        <h2 id="technologies-combinations-heading" class="technologies-combinations__title">{{ $combinations['title'] }}</h2>
        <p class="technologies-combinations__desc">{{ $combinations['description'] }}</p>
      </div>
    </div>

    <div class="technologies-combinations__table-wrap">
      <table class="technologies-combinations__table">
        <thead>
          <tr>
            <th scope="col">Business need</th>
            <th scope="col">Typical stack</th>
            <th scope="col">Related page</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($combinations['rows'] as $row)
            <tr>
              <th scope="row">
                <span class="technologies-table-label">Business need</span>
                <span class="technologies-combinations__need">
                  <span class="technologies-combinations__icon technologies-combinations__icon--{{ $row['icon'] }}" aria-hidden="true">
                    @switch($row['icon'])
                      @case('portal')
                        <svg viewBox="0 0 24 24" width="18" height="18"><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="1.7"/><path d="M12 3.5v2.2M12 18.3v2.2M3.5 12h2.2M18.3 12h2.2M6.1 6.1l1.6 1.6M16.3 16.3l1.6 1.6M17.9 6.1l-1.6 1.6M7.7 16.3l-1.6 1.6" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                        @break
                      @case('live')
                        <svg viewBox="0 0 24 24" width="18" height="18"><circle cx="12" cy="8" r="3.2" fill="none" stroke="currentColor" stroke-width="1.7"/><path d="M5.5 19.2c1.2-3 3.5-4.5 6.5-4.5s5.3 1.5 6.5 4.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                        @break
                      @case('marketing')
                        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M4 10v4h3l8 4V6L7 10H4Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M15 9.5a3.5 3.5 0 0 1 0 5M8 14.2v2.3a2 2 0 0 0 2 1.8h.4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                        @break
                      @case('content')
                        <svg viewBox="0 0 24 24" width="18" height="18"><rect x="4" y="4" width="7" height="7" rx="1.4" fill="none" stroke="currentColor" stroke-width="1.7"/><rect x="13" y="4" width="7" height="7" rx="1.4" fill="none" stroke="currentColor" stroke-width="1.7"/><rect x="4" y="13" width="7" height="7" rx="1.4" fill="none" stroke="currentColor" stroke-width="1.7"/><rect x="13" y="13" width="7" height="7" rx="1.4" fill="none" stroke="currentColor" stroke-width="1.7"/></svg>
                        @break
                      @case('store')
                        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M6.5 8h11l-.8 11.2a1.5 1.5 0 0 1-1.5 1.3H8.8a1.5 1.5 0 0 1-1.5-1.3L6.5 8Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 8V6.8A3 3 0 0 1 12 3.8 3 3 0 0 1 15 6.8V8" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                        @break
                      @case('catalog')
                        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M4 10.5 12 4l8 6.5M6.5 10v9h11v-9M10 19v-5h4v5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @break
                      @case('ai')
                        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 3.5 13.4 8.6 18.5 10 13.4 11.4 12 16.5 10.6 11.4 5.5 10 10.6 8.6 12 3.5Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M18 15.5 18.6 17.4 20.5 18 18.6 18.6 18 20.5 17.4 18.6 15.5 18 17.4 17.4 18 15.5Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
                        @break
                      @default
                        <svg viewBox="0 0 24 24" width="18" height="18"><ellipse cx="12" cy="6.5" rx="6.5" ry="2.6" fill="none" stroke="currentColor" stroke-width="1.7"/><path d="M5.5 6.5v5c0 1.5 2.9 2.6 6.5 2.6s6.5-1.1 6.5-2.6v-5M5.5 11.5v5c0 1.5 2.9 2.6 6.5 2.6s6.5-1.1 6.5-2.6v-5" fill="none" stroke="currentColor" stroke-width="1.7"/></svg>
                    @endswitch
                  </span>
                  <span class="technologies-combinations__need-copy">
                    <span class="technologies-combinations__need-title">{{ $row['title'] }}</span>
                    <span class="technologies-combinations__need-text">{{ $row['description'] }}</span>
                  </span>
                </span>
              </th>
              <td>
                <span class="technologies-table-label">Typical stack</span>
                <span class="technologies-combinations__pills">
                  @foreach ($row['pills'] as $pill)
                    @if ($pill['join'] !== '')
                      <span class="technologies-combinations__plus">{{ $pill['join'] }}</span>
                    @endif
                    <span class="technologies-combinations__pill technologies-combinations__pill--{{ $pill['key'] }}">
                      @if ($pill['logo'] !== '')
                        <img
                          class="technologies-combinations__logo"
                          src="{{ asset($pill['logo']) }}"
                          alt="{{ $pill['logoAlt'] }}"
                          title="{{ $pill['logoAlt'] }}"
                          width="16"
                          height="16"
                          decoding="async"
                        >
                      @else
                        <span class="technologies-combinations__logo-placeholder" role="img" aria-label="{{ $pill['logoAlt'] }}"></span>
                      @endif
                      {{ $pill['label'] }}
                    </span>
                  @endforeach
                </span>
              </td>
              <td>
                <span class="technologies-table-label">Related page</span>
                <a class="technologies-combinations__link" href="{{ route($row['serviceRoute'], $row['serviceParams']) }}">
                  {{ $row['serviceLabel'] }}
                  <svg viewBox="0 0 16 16" width="14" height="14" aria-hidden="true"><path d="M3 8h9M9 4.5 12.5 8 9 11.5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="full-bleed technologies-selection" aria-labelledby="technologies-selection-heading">
  <div class="section-inner technologies-selection__inner">
    <div class="technologies-selection__intro">
      <p class="technologies-selection__eyebrow">{{ $selection['eyebrow'] }}</p>
      <div class="technologies-selection__intro-copy">
        <h2 id="technologies-selection-heading" class="technologies-selection__title">
          {{ $selection['titleLead'] }}
          <span>{{ $selection['titleAccent'] }}</span>
        </h2>
        <p class="technologies-selection__desc">{{ $selection['description'] }}</p>
      </div>
    </div>

    <div class="technologies-selection__flow">
      <article class="technologies-selection__panel">
        <h3>{{ $selection['discoveryTitle'] }}</h3>
        <ul class="technologies-selection__checks" style="--technologies-build-mark: url('{{ asset('assets/icons/green-circle-check-icon.png') }}?v={{ filemtime(public_path('assets/icons/green-circle-check-icon.png')) }}')">
          @foreach ($selection['discovery'] as $item)
            <li>{{ $item }}</li>
          @endforeach
        </ul>
      </article>

      <span class="technologies-selection__arrow" aria-hidden="true"></span>

      <article class="technologies-selection__panel technologies-selection__panel--stack">
        <h3>{{ $selection['stackTitle'] }}</h3>
        <ul class="technologies-selection__marks">
          @foreach ($selection['stack'] as $mark)
            <li>
              @if (filled($mark['logo']))
                <img
                  src="{{ asset($mark['logo']) }}"
                  alt="{{ $mark['logoAlt'] }}"
                  title="{{ $mark['logoAlt'] }}"
                  width="22"
                  height="22"
                  decoding="async"
                  loading="lazy">
              @else
                <span class="technologies-selection__logo-placeholder" role="img" aria-label="{{ $mark['logoAlt'] }}"></span>
              @endif
            </li>
          @endforeach
        </ul>
      </article>

      <span class="technologies-selection__arrow" aria-hidden="true"></span>

      <article class="technologies-selection__result">
        <span class="technologies-selection__result-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#2a4dfb"/><path d="m7.5 12.2 3 3 6-6.4" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <p>
          <strong>{{ $selection['resultLead'] }}</strong>
          <span>{{ $selection['resultText'] }}</span>
        </p>
        <span class="technologies-selection__result-lines" aria-hidden="true">
          <span></span>
          <span></span>
          <span></span>
        </span>
      </article>
    </div>

    <ul class="technologies-selection__factors">
      @foreach ($selection['factors'] as $factor)
        <li class="technologies-selection__factor technologies-selection__factor--{{ $factor['tone'] }}">
          <div class="technologies-selection__factor-head">
            <span class="technologies-selection__number">{{ $factor['number'] }}</span>
            <span class="technologies-selection__factor-icon" aria-hidden="true">
              @switch($factor['icon'])
                @case('database')
                  <svg viewBox="0 0 24 24" fill="none"><ellipse cx="12" cy="6" rx="7" ry="3" stroke="currentColor" stroke-width="1.7"/><path d="M5 6v4.5c0 1.66 3.13 3 7 3s7-1.34 7-3V6M5 10.5V15c0 1.66 3.13 3 7 3s7-1.34 7-3v-4.5" stroke="currentColor" stroke-width="1.7"/></svg>
                  @break
                @case('bolt')
                  <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="m13.2 6.8-5 6.2h3.3l-0.7 4.2 5-6.2h-3.3z" fill="currentColor"/></svg>
                  @break
                @case('pencil')
                  <svg viewBox="0 0 24 24" fill="none"><path d="m15.2 5.4 3.4 3.4-9.8 9.8H5.4v-3.4z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m13.8 6.8 3.4 3.4" stroke="currentColor" stroke-width="1.7"/></svg>
                  @break
                @case('puzzle')
                  <svg viewBox="0 0 24 24" fill="none"><path d="M9.5 4.5h3.2a1.8 1.8 0 0 1 1.8 1.8v1.1a1.5 1.5 0 1 0 3 0v-.5h1.2A1.8 1.8 0 0 1 20.5 8.7v3.2a1.8 1.8 0 0 1-1.8 1.8h-1.1a1.5 1.5 0 1 0 0 3h.5v1.2a1.8 1.8 0 0 1-1.8 1.8h-3.2a1.8 1.8 0 0 1-1.8-1.8v-1.1a1.5 1.5 0 1 0-3 0v.5H5.3A1.8 1.8 0 0 1 3.5 15.3v-3.2A1.8 1.8 0 0 1 5.3 10.3h1.1a1.5 1.5 0 1 0 0-3h-.5V5.8A1.3 1.3 0 0 1 7.2 4.5h2.3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                  @break
                @case('users')
                  <svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8.2" r="2.4" stroke="currentColor" stroke-width="1.7"/><circle cx="16.2" cy="9" r="2" stroke="currentColor" stroke-width="1.7"/><path d="M4.5 17.5c.7-2.4 2.4-3.6 4.5-3.6s3.8 1.2 4.5 3.6M13.8 14.2c1.3-.4 2.7-.2 3.9.8.9.8 1.4 1.8 1.6 2.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                  @break
                @case('coins')
                  <svg viewBox="0 0 24 24" fill="none"><ellipse cx="12" cy="16.2" rx="6.2" ry="2.4" stroke="currentColor" stroke-width="1.7"/><path d="M5.8 16.2V18c0 1.3 2.8 2.4 6.2 2.4s6.2-1.1 6.2-2.4v-1.8" stroke="currentColor" stroke-width="1.7"/><ellipse cx="12" cy="8.4" rx="5.4" ry="2.2" stroke="currentColor" stroke-width="1.7"/><path d="M6.6 8.4v2.8c0 1.2 2.4 2.2 5.4 2.2s5.4-1 5.4-2.2V8.4M12 6.8v3.2M10.4 8.1h3.2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                  @break
              @endswitch
            </span>
          </div>
          <h3>{{ $factor['title'] }}</h3>
          <p>{{ $factor['text'] }}</p>
        </li>
      @endforeach
    </ul>
  </div>
</section>

<section class="full-bleed technologies-why" aria-labelledby="technologies-why-heading">
  <div class="section-inner technologies-why__inner">
    <p class="technologies-why__eyebrow">{{ $why['eyebrow'] }}</p>
    <h2 id="technologies-why-heading" class="technologies-why__title">{{ $why['title'] }}</h2>
    <ul class="technologies-why__grid">
      @foreach ($why['items'] as $item)
        <li class="technologies-why__card">
          <span class="technologies-why__icon">
            @if (filled($item['icon']))
              <img
                src="{{ asset($item['icon']) }}"
                alt="{{ $item['iconAlt'] }}"
                title="{{ $item['iconAlt'] }}"
                width="40"
                height="40"
                decoding="async"
                loading="lazy">
            @else
              <span class="technologies-why__icon-placeholder" role="img" aria-label="{{ $item['iconAlt'] }}"></span>
            @endif
          </span>
          <h3>{{ $item['title'] }}</h3>
          <p>{{ $item['text'] }}</p>
        </li>
      @endforeach
    </ul>
    <div class="technologies-why__actions">
      <x-frontend.cta-button :href="route($why['primaryRoute'])">{{ $why['primaryCta'] }}</x-frontend.cta-button>
      <x-frontend.cta-button variant="secondary-dark" :href="route($why['secondaryRoute'])">{{ $why['secondaryCta'] }}</x-frontend.cta-button>
    </div>
  </div>
</section>

<x-frontend.faq-section
  id="technology-faq"
  :qa="$faq['items']"
  :media="null"
  :show-cta="false"
  :eyebrow="$faq['eyebrow']"
  :title="$faq['title']"
  :description="$faq['description']"
  heading-id="technologies-faq-heading"
  question-heading="h3"
  class="faq-section--crm-builder bg-cover bg-top bg-no-repeat"
  style="background-image: url('{{ asset($faq['backgroundImage']) }}')"
/>

<x-frontend.consultation-section
  :eyebrow="$consultation['eyebrow']"
  :title="$consultation['title']"
  :description="$consultation['description']"
  :cta-label="$consultation['ctaLabel']"
  :secondary-cta-label="$consultation['secondaryCtaLabel']"
  secondary-inquiry-dialog="hire-developers"
  :card-position="$consultation['cardPosition']"
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

<x-frontend.modal.hire-developers-modal />

@once
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var columns = document.querySelector('.technologies-backend__columns');
        var summaries = columns
          ? Array.prototype.slice.call(columns.querySelectorAll('.technologies-backend__summary'))
          : [];

        function equalizeBackendSummaries() {
          if (summaries.length < 2 || window.matchMedia('(max-width: 999px)').matches) {
            summaries.forEach(function (summary) {
              summary.style.minHeight = '';
            });
            return;
          }

          summaries.forEach(function (summary) {
            summary.style.minHeight = '';
          });

          var tallest = summaries.reduce(function (max, summary) {
            return Math.max(max, summary.offsetHeight);
          }, 0);

          summaries.forEach(function (summary) {
            summary.style.minHeight = tallest + 'px';
          });
        }

        equalizeBackendSummaries();
        window.addEventListener('resize', equalizeBackendSummaries);

        document.querySelectorAll('[data-technologies-backend-more]').forEach(function (button) {
          button.addEventListener('click', function () {
            var card = button.closest('.technologies-backend__card');
            if (!card) {
              return;
            }

            var open = card.classList.toggle('is-expanded');
            button.setAttribute('aria-expanded', open ? 'true' : 'false');
            button.textContent = open ? 'Read less' : 'Read more';
          });
        });
      });
    </script>
  @endpush
@endonce

@endsection
