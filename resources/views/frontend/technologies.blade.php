@extends('layouts.frontend')

@section('content')

<section class="full-bleed technologies-hero" aria-labelledby="technologies-heading">
  <div class="section-inner technologies-hero__inner">
    <nav class="technologies-hero__breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span aria-hidden="true">›</span>
      <span aria-current="page">TECHNOLOGIES</span>
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
        <p class="technologies-hero__desc">{{ $heroDescription }}</p>
        <div class="technologies-hero__cta">
          <x-frontend.cta-button :href="$demoHref">{{ $primaryCta }}</x-frontend.cta-button>
          <button type="button" class="technologies-hero__hire group" data-inquiry-dialog-open="hire-developers">
            {{ $secondaryCta }}
            <x-frontend.cta-arrow />
          </button>
        </div>
        <ul class="technologies-hero__trust">
          @foreach ($trust as $item)
            <li class="technologies-hero__trust-item">
              <span class="technologies-hero__trust-icon" aria-hidden="true">
                @if ($item['key'] === 'ownership')
                  <svg viewBox="0 0 24 24" fill="none" width="22" height="22">
                    <path d="M12 3.5 5.5 6.2v5.1c0 3.7 2.6 6.6 6.5 8.2 3.9-1.6 6.5-4.5 6.5-8.2V6.2L12 3.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    <path d="m9.2 12 1.9 1.9 3.8-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                @elseif ($item['key'] === 'architect')
                  <svg viewBox="0 0 24 24" fill="none" width="22" height="22">
                    <circle cx="12" cy="8" r="2.6" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M6.8 18.2c.7-2.6 2.7-3.9 5.2-3.9s4.5 1.3 5.2 3.9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  </svg>
                @else
                  <svg viewBox="0 0 24 24" fill="none" width="22" height="22">
                    <circle cx="12" cy="12" r="7.2" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M12 8.2V12l2.6 1.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                @endif
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

      <div class="technologies-hero__visual" aria-label="Technology logos and application previews">
        <ul class="technologies-hero__logos">
          @foreach ($logos as $logo)
            <li class="technologies-hero__logo">
              <img
                src="{{ asset($logo['src']) }}"
                alt="{{ $logo['alt'] }}"
                title="{{ $logo['alt'] }}"
                width="40"
                height="40"
                decoding="async"
                @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif>
              <span>{{ $logo['label'] }}</span>
            </li>
          @endforeach
        </ul>

        <div class="technologies-hero__stage">
          <svg class="technologies-hero__connectors" viewBox="0 0 520 220" fill="none" aria-hidden="true">
            <path d="M78 8c0 70-18 78-8 128 8 38 18 52 42 68" stroke="#C5D0EA" stroke-width="1.5" stroke-dasharray="5 6" stroke-linecap="round"/>
            <path d="M442 8c0 64 16 74 8 124-8 40-22 54-48 70" stroke="#C5D0EA" stroke-width="1.5" stroke-dasharray="5 6" stroke-linecap="round"/>
          </svg>

          <div class="technologies-hero__devices">
            @foreach ($devices as $device)
              <div class="technologies-hero__device technologies-hero__device--{{ $device['slot'] }}" role="img" aria-label="{{ $device['label'] }}">
                @if (filled($device['image']))
                  <img
                    class="technologies-hero__device-image"
                    src="{{ asset($device['image']) }}"
                    alt="{{ $device['label'] }}"
                    title="{{ $device['label'] }}"
                    decoding="async"
                    loading="lazy">
                @else
                  <span class="technologies-hero__device-placeholder">Image placeholder</span>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="full-bleed technologies-stack" aria-labelledby="technologies-stack-heading">
  <div class="section-inner technologies-stack__inner">
    <div class="technologies-stack__intro">
      <p class="technologies-stack__eyebrow">{{ $stack['eyebrow'] }}</p>
      <div class="technologies-stack__intro-copy">
        <h2 id="technologies-stack-heading" class="technologies-stack__title">{{ $stack['title'] }}</h2>
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
                width="40"
                height="40"
                decoding="async"
                loading="lazy">
            @else
              <span class="technologies-stack__logo-placeholder" role="img" aria-label="{{ $item['logoAlt'] }}"></span>
            @endif
            <h3 class="technologies-stack__name">{{ $item['name'] }}</h3>
            <span class="technologies-stack__role">{{ $item['role'] }}</span>
          </div>
          <p class="technologies-stack__usage"><strong>Typical use:</strong> {{ $item['usage'] }}</p>
          <a class="technologies-stack__service" href="{{ route($item['serviceRoute'], $item['serviceParams']) }}">
            <span>Related Service:</span> {{ $item['serviceLabel'] }}
            <svg viewBox="0 0 16 16" width="16" height="16" aria-hidden="true">
              <path d="M3 8h9M9 4.5 12.5 8 9 11.5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        </li>
      @endforeach
    </ul>
  </div>
</section>

<section class="full-bleed technologies-backend" aria-labelledby="technologies-backend-heading">
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
        <article class="technologies-backend__card technologies-backend__card--{{ $column['key'] }}">
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
              <p>{{ $column['summary'] }}</p>
            </div>
          </div>

          <h4 class="technologies-backend__label">
            <svg class="technologies-backend__mark" viewBox="0 0 16 16" aria-hidden="true"><circle cx="8" cy="8" r="7" fill="#22c55e"/><path d="m4.8 8.1 2 2 4.4-4.6" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            What we build
          </h4>
          <ul class="technologies-backend__builds">
            @foreach ($column['builds'] as $build)
              <li>{{ $build }}</li>
            @endforeach
          </ul>

          <h4 class="technologies-backend__label">
            <svg class="technologies-backend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M2.5 13.5h11M3.5 13.5V7.2L8 4.2l4.5 3V13.5M6.4 13.5v-3h3.2v3" fill="none" stroke="#8eb6ff" stroke-width="1.3" stroke-linejoin="round"/></svg>
            Why businesses choose it
          </h4>
          <p class="technologies-backend__copy">{{ $column['why'] }}</p>

          <h4 class="technologies-backend__label">
            <svg class="technologies-backend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="m8 2.2 6 10.6H2L8 2.2Z" fill="none" stroke="#f5b942" stroke-width="1.3" stroke-linejoin="round"/><path d="M8 6.2v3.1" stroke="#f5b942" stroke-width="1.3" stroke-linecap="round"/><circle cx="8" cy="11" r="0.6" fill="#f5b942"/></svg>
            Consider a different fit when
          </h4>
          <p class="technologies-backend__copy">{{ $column['consider'] }}</p>

          <h4 class="technologies-backend__label">
            <svg class="technologies-backend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.2 9.2 4.6 10.8a2.2 2.2 0 0 1-3.1-3.1L3.1 6.1a2.2 2.2 0 0 1 3.1 0M9.8 6.8l1.6-1.6a2.2 2.2 0 0 1 3.1 3.1L13 9.9a2.2 2.2 0 0 1-3.1 0M6.4 9.6l3.2-3.2" fill="none" stroke="#7eb6ff" stroke-width="1.3" stroke-linecap="round"/></svg>
            Works with
          </h4>
          <p class="technologies-backend__copy">{{ $column['works'] }}</p>
        </article>
      @endforeach
    </div>

    <div class="technologies-backend__chooser">
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
                    width="22"
                    height="22"
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
        <article class="technologies-frontend__card technologies-frontend__card--{{ $column['key'] }}">
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

          <h4 class="technologies-frontend__label">
            <svg class="technologies-frontend__mark" viewBox="0 0 16 16" aria-hidden="true"><circle cx="8" cy="8" r="7" fill="#22c55e"/><path d="m4.8 8.1 2 2 4.4-4.6" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            What we build
          </h4>
          <ul class="technologies-frontend__builds">
            @foreach ($column['builds'] as $build)
              <li>{{ $build }}</li>
            @endforeach
          </ul>

          <h4 class="technologies-frontend__label">
            <svg class="technologies-frontend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 4.5h10v7.2H3V4.5Z" fill="none" stroke="#3b82f6" stroke-width="1.3"/><path d="M6 13.2h4M8 11.7V13.2" stroke="#3b82f6" stroke-width="1.3" stroke-linecap="round"/></svg>
            Why businesses choose it
          </h4>
          <p class="technologies-frontend__copy">{{ $column['why'] }}</p>

          <h4 class="technologies-frontend__label">
            <svg class="technologies-frontend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="m8 2.2 6 10.6H2L8 2.2Z" fill="none" stroke="#f5b942" stroke-width="1.3" stroke-linejoin="round"/><path d="M8 6.2v3.1" stroke="#f5b942" stroke-width="1.3" stroke-linecap="round"/><circle cx="8" cy="11" r="0.6" fill="#f5b942"/></svg>
            Consider a different fit when
          </h4>
          <p class="technologies-frontend__copy">{{ $column['consider'] }}</p>

          <h4 class="technologies-frontend__label">
            <svg class="technologies-frontend__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.2 9.2 4.6 10.8a2.2 2.2 0 0 1-3.1-3.1L3.1 6.1a2.2 2.2 0 0 1 3.1 0M9.8 6.8l1.6-1.6a2.2 2.2 0 0 1 3.1 3.1L13 9.9a2.2 2.2 0 0 1-3.1 0M6.4 9.6l3.2-3.2" fill="none" stroke="#3b82f6" stroke-width="1.3" stroke-linecap="round"/></svg>
            Works with
          </h4>
          <p class="technologies-frontend__copy">{{ $column['works'] }}</p>
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
              @foreach ($row['cells'] as $cell)
                <td>{{ $cell }}</td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="full-bleed technologies-mobile" aria-labelledby="technologies-mobile-heading">
  <div class="section-inner technologies-mobile__inner">
    <div class="technologies-mobile__intro">
      <p class="technologies-mobile__eyebrow">{{ $mobile['eyebrow'] }}</p>
      <h2 id="technologies-mobile-heading" class="technologies-mobile__title">
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
        <ul class="technologies-mobile__points">
          @foreach ($mobile['points'] as $point)
            <li>{{ $point }}</li>
          @endforeach
        </ul>
        <div class="technologies-mobile__why">
          <h3>{{ $mobile['whyTitle'] }}</h3>
          <p>{{ $mobile['why'] }}</p>
        </div>
      </div>

      <ul class="technologies-mobile__features">
        @foreach ($mobile['features'] as $feature)
          <li class="technologies-mobile__feature technologies-mobile__feature--{{ $feature['key'] }}">
            <span class="technologies-mobile__feature-icon" aria-hidden="true">
              @if ($feature['key'] === 'platforms')
                <svg viewBox="0 0 24 24"><rect x="7" y="3" width="10" height="18" rx="2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M11 18.5h2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
              @elseif ($feature['key'] === 'shared')
                <svg viewBox="0 0 24 24"><circle cx="7" cy="12" r="2.2" fill="none" stroke="currentColor" stroke-width="1.6"/><circle cx="17" cy="7" r="2.2" fill="none" stroke="currentColor" stroke-width="1.6"/><circle cx="17" cy="17" r="2.2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="m9 11 6-3M9 13l6 3" stroke="currentColor" stroke-width="1.6"/></svg>
              @elseif ($feature['key'] === 'native')
                <svg viewBox="0 0 24 24"><path d="m8 8-4 4 4 4M16 8l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
              @else
                <svg viewBox="0 0 24 24"><path d="M8 9H4.5A1.5 1.5 0 0 0 3 10.5v3A1.5 1.5 0 0 0 4.5 15H8l2 2.5V6.5L8 9Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 9.5a3.5 3.5 0 0 1 0 5M16.5 7.5a6.5 6.5 0 0 1 0 9" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
              @endif
            </span>
            <h3>{{ $feature['title'] }}</h3>
            <p>{{ $feature['text'] }}</p>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</section>

<section class="full-bleed technologies-cms" aria-labelledby="technologies-cms-heading">
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
        <p class="technologies-cms__desc">{{ $cms['description'] }}</p>
      </div>
    </div>

    <div class="technologies-cms__columns">
      @foreach ($cms['columns'] as $column)
        <article class="technologies-cms__card technologies-cms__card--{{ $column['key'] }}">
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

          <h4 class="technologies-cms__label">
            <svg class="technologies-cms__mark" viewBox="0 0 16 16" aria-hidden="true"><circle cx="8" cy="8" r="7" fill="#22c55e"/><path d="m4.8 8.1 2 2 4.4-4.6" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            What we build
          </h4>
          <ul class="technologies-cms__builds">
            @foreach ($column['builds'] as $build)
              <li>{{ $build }}</li>
            @endforeach
          </ul>

          <h4 class="technologies-cms__label">
            <svg class="technologies-cms__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 3.2h7.2l2.8 2.8V13H3V3.2Z" fill="none" stroke="#8eb6ff" stroke-width="1.3" stroke-linejoin="round"/><path d="M10 3.4V6h2.6" fill="none" stroke="#8eb6ff" stroke-width="1.3"/></svg>
            Why businesses choose it
          </h4>
          <p class="technologies-cms__copy">{{ $column['why'] }}</p>

          <h4 class="technologies-cms__label technologies-cms__label--alert">
            <svg class="technologies-cms__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="m8 2.2 6 10.6H2L8 2.2Z" fill="none" stroke="#f5b942" stroke-width="1.3" stroke-linejoin="round"/><path d="M8 6.2v3.1" stroke="#f5b942" stroke-width="1.3" stroke-linecap="round"/><circle cx="8" cy="11" r="0.6" fill="#f5b942"/></svg>
            Consider a different fit when
          </h4>
          <p class="technologies-cms__copy">{{ $column['consider'] }}</p>

          <h4 class="technologies-cms__label">
            <svg class="technologies-cms__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.2 9.2 4.6 10.8a2.2 2.2 0 0 1-3.1-3.1L3.1 6.1a2.2 2.2 0 0 1 3.1 0M9.8 6.8l1.6-1.6a2.2 2.2 0 0 1 3.1 3.1L13 9.9a2.2 2.2 0 0 1-3.1 0M6.4 9.6l3.2-3.2" fill="none" stroke="#7eb6ff" stroke-width="1.3" stroke-linecap="round"/></svg>
            Works with
          </h4>
          <p class="technologies-cms__copy">{{ $column['works'] }}</p>
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
        <p class="technologies-commerce__desc">{{ $commerce['description'] }}</p>
      </div>
    </div>

    <div class="technologies-commerce__columns">
      @foreach ($commerce['columns'] as $column)
        <article class="technologies-commerce__card technologies-commerce__card--{{ $column['key'] }}">
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

          <h4 class="technologies-commerce__label">
            <svg class="technologies-commerce__mark" viewBox="0 0 16 16" aria-hidden="true"><circle cx="8" cy="8" r="7" fill="#22c55e"/><path d="m4.8 8.1 2 2 4.4-4.6" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            What we build
          </h4>
          <ul class="technologies-commerce__builds">
            @foreach ($column['builds'] as $build)
              <li>{{ $build }}</li>
            @endforeach
          </ul>

          <h4 class="technologies-commerce__label">
            <svg class="technologies-commerce__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M3 4.5h10v7.2H3V4.5Z" fill="none" stroke="#3b82f6" stroke-width="1.3"/><path d="M6 13.2h4M8 11.7V13.2" stroke="#3b82f6" stroke-width="1.3" stroke-linecap="round"/></svg>
            Why businesses choose it
          </h4>
          <p class="technologies-commerce__copy">{{ $column['why'] }}</p>

          <h4 class="technologies-commerce__label">
            <svg class="technologies-commerce__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="m8 2.2 6 10.6H2L8 2.2Z" fill="none" stroke="#f5b942" stroke-width="1.3" stroke-linejoin="round"/><path d="M8 6.2v3.1" stroke="#f5b942" stroke-width="1.3" stroke-linecap="round"/><circle cx="8" cy="11" r="0.6" fill="#f5b942"/></svg>
            Consider a different fit when
          </h4>
          <p class="technologies-commerce__copy">{{ $column['consider'] }}</p>

          <h4 class="technologies-commerce__label">
            <svg class="technologies-commerce__mark" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.2 9.2 4.6 10.8a2.2 2.2 0 0 1-3.1-3.1L3.1 6.1a2.2 2.2 0 0 1 3.1 0M9.8 6.8l1.6-1.6a2.2 2.2 0 0 1 3.1 3.1L13 9.9a2.2 2.2 0 0 1-3.1 0M6.4 9.6l3.2-3.2" fill="none" stroke="#3b82f6" stroke-width="1.3" stroke-linecap="round"/></svg>
            Works with
          </h4>
          <p class="technologies-commerce__copy">{{ $column['works'] }}</p>
        </article>
      @endforeach
    </div>

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
              @foreach ($row['cells'] as $cell)
                <td>{{ $cell }}</td>
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
                <span class="technologies-combinations__need">
                  <span class="technologies-combinations__icon technologies-combinations__icon--{{ $row['icon'] }}" aria-hidden="true"></span>
                  <span>
                    <span class="technologies-combinations__need-title">{{ $row['title'] }}</span>
                    <span class="technologies-combinations__need-text">{{ $row['text'] }}</span>
                  </span>
                </span>
              </th>
              <td>
                <span class="technologies-combinations__pills">
                  @foreach ($row['pills'] as $pill)
                    @if (! $loop->first)
                      <span class="technologies-combinations__plus" aria-hidden="true">+</span>
                    @endif
                    <span class="technologies-combinations__pill technologies-combinations__pill--{{ $pill['key'] }}">
                      @if (filled($pill['logo']))
                        <img
                          class="technologies-combinations__logo"
                          src="{{ asset($pill['logo']) }}"
                          alt="{{ $pill['logoAlt'] }}"
                          title="{{ $pill['logoAlt'] }}"
                          width="16"
                          height="16"
                          decoding="async"
                          loading="lazy">
                      @else
                        <span class="technologies-combinations__logo-placeholder" role="img" aria-label="{{ $pill['logoAlt'] }}"></span>
                      @endif
                      {{ $pill['name'] }}
                    </span>
                  @endforeach
                </span>
              </td>
              <td>
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
        <ul>
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
                  width="28"
                  height="28"
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
        <p><strong>{{ $selection['resultLead'] }}</strong> {{ $selection['resultText'] }}</p>
      </article>
    </div>

    <ul class="technologies-selection__factors">
      @foreach ($selection['factors'] as $factor)
        <li class="technologies-selection__factor technologies-selection__factor--{{ $factor['tone'] }}">
          <span class="technologies-selection__number">{{ $factor['number'] }}</span>
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
          <span class="technologies-why__icon" aria-hidden="true">
            @switch($item['icon'])
              @case('ownership')
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M6.5 18.5c.8-2.6 2.8-4 5.5-4s4.7 1.4 5.5 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M16.2 10.2h3.2v2.4h-1.1V16h-2.1v-3.4h-1.1z" fill="currentColor"/></svg>
                @break
              @case('sprints')
                <svg viewBox="0 0 24 24"><rect x="4" y="5.5" width="16" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M4 9.5h16M8 4.5v3M16 4.5v3" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                @break
              @case('decisions')
                <svg viewBox="0 0 24 24"><path d="M7 4.5h7.5L19 9v10.5a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-14a1 1 0 0 1 1-1Z" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M14 4.8V9h4.2M8.5 13h7M8.5 16h5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                @break
              @default
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M12 4.5v2.2M12 17.3V19.5M4.5 12h2.2M17.3 12H19.5M6.7 6.7l1.6 1.6M15.7 15.7l1.6 1.6M17.3 6.7l-1.6 1.6M8.3 15.7l-1.6 1.6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            @endswitch
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

@endsection
