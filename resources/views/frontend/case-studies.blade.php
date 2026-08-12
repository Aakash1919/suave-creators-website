@extends('layouts.frontend')

@section('content')
  <section class="case-studies-hero site-container" aria-labelledby="case-studies-heading">
    <nav class="case-studies-hero__breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span aria-hidden="true">/</span>
      <span aria-current="page">Case Studies</span>
    </nav>
    <p class="case-studies-hero__eyebrow pragati-narrow-regular">Case Studies</p>
    <h1 id="case-studies-heading" class="case-studies-hero__title">
      Built in the open. <span class="case-studies-hero__title-accent">Proven in product.</span>
    </h1>
    <p class="case-studies-hero__lead">
      Stories from the software we design and ship — how we turn messy workflows into clear product experiences.
    </p>
  </section>

  @if (! empty($cases))
    <section class="full-bleed case-studies-grid" aria-labelledby="case-studies-grid-heading">
      <div class="section-inner">
        <h2 id="case-studies-grid-heading" class="sr-only">All case studies</h2>
        <div class="case-studies-grid__list">
          @foreach ($cases as $item)
            @php
              $itemHref = route('case-study.show', ['slug' => $item['slug']]);
              $tags = array_slice($item['technologies'] ?? [], 0, 5);
              $tagLine = implode(' | ', $tags);
              $subtitle = trim((string) ($item['listing_subtitle'] ?? '')) !== ''
                ? $item['listing_subtitle']
                : ($item['industry'] ?? '');
              $stats = array_slice($item['results'] ?? [], 0, 3);
            @endphp
            <article class="case-studies-grid__item">
              <a href="{{ $itemHref }}" class="case-studies-grid__media">
                @if (! empty($item['image']))
                  <img
                    src="{{ $item['image'] }}"
                    alt="{{ $item['title'] }}"
                    title="{{ $item['title'] }}"
                    width="960"
                    height="640"
                    loading="lazy"
                    decoding="async"
                  >
                @endif
                @if ($tagLine !== '')
                  <span class="case-studies-grid__tags">{{ $tagLine }}</span>
                @endif
              </a>
              <div class="case-studies-grid__copy">
                @if (! empty($item['client']))
                  <p class="case-studies-grid__client pragati-narrow-regular">{{ $item['client'] }}</p>
                @endif
                <h3 class="case-studies-grid__title">
                  <a href="{{ $itemHref }}">{{ $item['title'] }}</a>
                </h3>
                @if ($subtitle !== '')
                  <p class="case-studies-grid__subtitle">{{ $subtitle }}</p>
                @endif
                @if (! empty($item['short_description']))
                  <p class="case-studies-grid__desc">{{ $item['short_description'] }}</p>
                @endif
                <a class="case-studies-grid__cta" href="{{ $itemHref }}">
                  Read the full story
                  <svg xmlns="https://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
                </a>
              </div>
              @if ($stats)
                <div class="case-studies-grid__stats" aria-label="Key results">
                  @foreach ($stats as $stat)
                    <div class="case-studies-grid__stat">
                      <span class="case-studies-grid__stat-value">{{ $stat['value'] }}</span>
                      <span class="case-studies-grid__stat-label">{{ $stat['label'] }}</span>
                    </div>
                  @endforeach
                </div>
              @endif
            </article>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <x-frontend.consultation-section
    title='Have an Idea? Let''s Turn It<br class="hidden sm:block"> Into a Digital Product'
    description="Whatever stage your business is at, our team is ready to help you plan, design, and build the right solution."
    cta-label="Get a Free Quote"
    secondary-cta-label="Contact us Today"
  />
@endsection
