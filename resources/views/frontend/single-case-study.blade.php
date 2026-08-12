@php
  $sections = $case['sections'] ?? [];
  $contactHref = route('contact-us') . '#contact-id';
@endphp

@extends('layouts.frontend')

@section('content')
  <section class="case-study-detail-hero site-container" aria-labelledby="case-study-detail-heading">
    <div class="case-study-detail-hero__grid">
      <div class="case-study-detail-hero__copy">
        <nav class="case-studies-hero__breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Home</a>
          <span aria-hidden="true">/</span>
          <a href="{{ route('case-studies') }}">Case Studies</a>
          <span aria-hidden="true">/</span>
          <span aria-current="page">{{ $case['client'] ?? $case['title'] }}</span>
        </nav>

        @if (! empty($isDraft) || ! empty($case['is_draft']))
          <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-amber-300 bg-amber-50 px-3 py-1.5 text-sm font-semibold text-amber-800" role="status">
            Draft preview — only visible while logged in
          </p>
        @endif

        <p class="case-studies-hero__eyebrow pragati-narrow-regular">{{ $case['industry'] }}</p>
        <h1 id="case-study-detail-heading" class="case-study-detail-hero__title">{{ $case['title'] }}</h1>
        <p class="case-study-detail-hero__lead">{{ $case['short_description'] }}</p>

        <div class="case-study-detail-hero__meta">
          @if (! empty($case['client']))
            <span><strong>Client</strong> {{ $case['client'] }}</span>
          @endif
          @if (! empty($case['year']))
            <span><strong>Year</strong> {{ $case['year'] }}</span>
          @endif
        </div>

        <div class="case-study-detail-hero__actions">
          <a href="#overview" class="case-study-detail-hero__btn case-study-detail-hero__btn--primary">
            See the story
            <x-frontend.cta-arrow />
          </a>
          <a href="{{ $contactHref }}" class="case-study-detail-hero__btn case-study-detail-hero__btn--ghost">
            Start a similar project
          </a>
        </div>
      </div>

      @if (! empty($case['image']))
        <figure class="case-study-detail-hero__media">
          <img
            src="{{ $case['image'] }}"
            alt="{{ $case['title'] }}"
            title="{{ $case['title'] }}"
            width="960"
            height="720"
            loading="eager"
            decoding="async"
          >
        </figure>
      @endif
    </div>
  </section>

  @if (! empty($case['results']))
    <section class="full-bleed case-study-metrics bg-white" aria-labelledby="key-metrics-heading">
      <div class="section-inner case-study-metrics__inner">
        <header class="case-study-metrics__header">
          <h2 id="key-metrics-heading" class="case-study-metrics__title">Key Performance Metrics</h2>
          <hr class="case-study-metrics__divider" aria-hidden="true">
        </header>
        <div class="case-study-metrics__row">
          @foreach ($case['results'] as $result)
            <div class="case-study-metrics__box">
              <p class="case-study-metrics__value">{{ $result['value'] }}</p>
              <h3 class="case-study-metrics__label">{{ $result['label'] }}</h3>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <section id="overview" class="full-bleed case-study-overview bg-white" aria-labelledby="overview-heading">
    <div class="section-inner">
      <header class="case-study-block-header">
        <p class="case-study-story__eyebrow">Overview</p>
        <h2 id="overview-heading">The problem, the approach, the result</h2>
      </header>
      <div class="case-study-story__brief">
        @if (! empty($case['challenge']))
          <article>
            <div class="case-study-story__icon">
              <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="12" cy="16.5" r="1" fill="currentColor"/></svg>
            </div>
            <h3>Challenge</h3>
            <p>{{ $case['challenge'] }}</p>
          </article>
        @endif
        @if (! empty($case['solution']))
          <article>
            <div class="case-study-story__icon">
              <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2.2 2.2L16 9.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
            </div>
            <h3>Solution</h3>
            <p>{{ $case['solution'] }}</p>
          </article>
        @endif
        @if (! empty($case['outcome']))
          <article>
            <div class="case-study-story__icon">
              <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 16l5-5 3.5 3.5L20 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 7h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <h3>Outcome</h3>
            <p>{{ $case['outcome'] }}</p>
          </article>
        @endif
      </div>
    </div>
  </section>

  @foreach (array_slice($sections, 0, 2) as $index => $section)
    @php
      $hasCopy = trim((string) ($section['title'] ?? '')) !== ''
        || trim((string) ($section['body'] ?? '')) !== ''
        || trim((string) ($section['eyebrow'] ?? '')) !== ''
        || ! empty($section['points']);
      $hasImage = ! empty($section['image']);
    @endphp
    @continue(! $hasCopy && ! $hasImage)
    @php
      $type = $section['type'] ?? 'split';
      $side = ($section['image_side'] ?? (($index % 2 === 0) ? 'right' : 'left')) === 'left' ? 'left' : 'right';
      $sectionId = 'section-' . ($index + 1);
      $visual = \App\Support\Frontend\CaseStudySupport::visualForSection($section, $index);
      $altClass = ($index % 2 === 1) ? ' case-study-split--alt' : '';
      $visualAlt = trim((string) ($section['title'] ?? '')) !== ''
        ? $section['title'].' product screenshot for Suave Creators software development'
        : $case['title'].' product screenshot for Suave Creators software development';
    @endphp

    @if ($type === 'split' || $type === 'shot')
      <section id="{{ $sectionId }}" class="full-bleed case-study-split case-study-split--{{ $side }}{{ $altClass }} bg-white" aria-labelledby="{{ $sectionId }}-title">
        <div class="section-inner case-study-split__inner">
          <div class="case-study-split__copy">
            @if (! empty($section['eyebrow']))
              <p class="case-study-story__eyebrow">{{ $section['eyebrow'] }}</p>
            @endif
            <h2 id="{{ $sectionId }}-title">{{ $section['title'] ?? '' }}</h2>
            @if (! empty($section['body']))
              <p>{{ $section['body'] }}</p>
            @endif
            @if (! empty($section['points']))
              <ol class="case-study-split__steps">
                @foreach ($section['points'] as $pointIndex => $point)
                  <li><span>{{ $pointIndex + 1 }}</span>{{ $point }}</li>
                @endforeach
              </ol>
            @endif
          </div>
          @include('frontend.partials.case-study-visual', [
            'visual' => $visual,
            'section' => $section,
            'imageAlt' => $visualAlt,
          ])
        </div>
      </section>
    @endif
  @endforeach

  <section class="full-bleed case-study-footer-cta bg-white" aria-labelledby="case-cta-heading">
    <div class="section-inner">
      <div class="case-study-story__cta">
        <div>
          <h2 id="case-cta-heading">Want a similar rebuild?</h2>
          <p>Tell us about your workflow — we will help you turn it into a clear product experience.</p>
        </div>
        <div class="case-study-story__cta-actions">
          <a href="{{ $contactHref }}" class="case-study-detail-hero__btn case-study-detail-hero__btn--primary">
            Talk to us
            <x-frontend.cta-arrow />
          </a>
          <a href="{{ route('case-studies') }}" class="case-study-detail__back">← All case studies</a>
        </div>
      </div>
    </div>
  </section>
@endsection
