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
        <span aria-current="page">Teerrath — From Stuck to a Clear Sacred Path</span>
      </nav>

      <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-amber-300 bg-amber-50 px-3 py-1.5 text-sm font-semibold text-amber-800" role="status">
        Draft preview — only visible while logged in
      </p>
      <p class="case-studies-hero__eyebrow pragati-narrow-regular">Spiritual Wellness / Ecommerce</p>
      <h1 id="case-study-detail-heading" class="case-study-detail-hero__title">Teerrath — From Stuck to a Clear Sacred Path</h1>
      <p class="case-study-detail-hero__lead">A free Spiritual Energy Scan in under 2 minutes becomes AI-personalized Vedic insight across six life areas — then a clear Dev, Mantra, Yantra, or Daan path to buy, gift, or fulfill.</p>

      <div class="case-study-detail-hero__meta">
        <span><strong>Year</strong> 2026</span>
      </div>
      <div class="case-study-detail-hero__actions">
        <a href="#overview" class="case-study-detail-hero__btn case-study-detail-hero__btn--primary">
          See the story
          <x-frontend.cta-arrow />
        </a>
        <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer" class="case-study-detail-hero__btn case-study-detail-hero__btn--ghost">
          Start a similar project
        </a>
      </div>
    </div>

      <figure class="case-study-detail-hero__media">
        <img
          src="{{ asset('assets/case-studies/teerrath/spiritual-energy-scan-hero.png') }}"
          alt="Teerrath — From Stuck to a Clear Sacred Path"
          title="Teerrath — From Stuck to a Clear Sacred Path"
          width="960"
          height="720"
          loading="eager"
          decoding="async"
        >
      </figure>
  </div>
</section>

<section class="full-bleed case-study-metrics bg-white" aria-labelledby="key-metrics-heading">
  <div class="section-inner case-study-metrics__inner">
    <header class="case-study-metrics__header">
      <h2 id="key-metrics-heading" class="case-study-metrics__title">Key Performance Metrics</h2>
      <hr class="case-study-metrics__divider" aria-hidden="true">
    </header>
    <div class="case-study-metrics__row">
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">&lt;2m</p>
            <h3 class="case-study-metrics__label">Free Spiritual Energy Scan completion</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">6</p>
            <h3 class="case-study-metrics__label">Life areas with scored AI insight</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">4</p>
            <h3 class="case-study-metrics__label">Sacred sadhna paths (live catalog)</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">1</p>
            <h3 class="case-study-metrics__label">Prioritized “start here” practice</h3>
          </div>
    </div>
  </div>
</section>

<section id="overview" class="full-bleed case-study-overview bg-white" aria-labelledby="overview-heading">
  <div class="section-inner">
    <header class="case-study-block-header">
      <p class="case-study-story__eyebrow">Overview</p>
      <h2 id="overview-heading">The problem, the approach, the result</h2>
    </header>
    <div class="case-study-story__brief">
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="12" cy="16.5" r="1" fill="currentColor"/></svg>
          </div>
          <h3>Challenge</h3>
          <p>Seekers felt stuck, but nothing connected that feeling to a fast scan, personal life-area insight, and one clear practice — generic forecasts, catalog overwhelm, awkward gifting, and payments, messaging, and books living apart from the journey.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2.2 2.2L16 9.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
          </div>
          <h3>Solution</h3>
          <p>Teerrath starts with a free Spiritual Energy Scan, turns chart-backed Vedic data into AI-personalized insight across six life areas, and recommends a real Dev, Mantra, Yantra, or Daan practice — then checkout with Razorpay, gift over WhatsApp via Fast2SMS, sync invoices to Zoho Books, and earn Kamals in one premium experience.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 16l5-5 3.5 3.5L20 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 7h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3>Outcome</h3>
          <p>Seekers finish a calm first step in minutes, see a clear “start here” practice, and act without leaving the brand. Payments, messaging, and books stay connected as guidance and commerce grow together.</p>
        </article>
    </div>
  </div>
</section>

<section id="section-1" class="full-bleed case-study-split case-study-split--right bg-white" aria-labelledby="section-1-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
          <p class="case-study-story__eyebrow">Energy Scan</p>
          <h2 id="section-1-title">A free first step that takes minutes — not an evening of research.</h2>
          <p>Seekers begin with birth details and a clear CTA: Start Your Free Spiritual Energy Scan. The brand promises sacred, free, deeply personalized insight — and a path to remedies for prosperity, relationships, and life opportunities.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Low-friction entry anyone can finish quickly</li>
              <li><span>2</span>Positioned as under 2 minutes on the live experience</li>
              <li><span>3</span>Opens the door to four sacred sadhna paths</li>
          </ol>
    </div>
        <div class="case-study-visual case-study-visual--discovery" aria-hidden="true">
          <div class="case-study-visual__glow"></div>
          <div class="case-study-visual__map">
            <span class="case-study-visual__pin case-study-visual__pin--a"></span>
            <span class="case-study-visual__pin case-study-visual__pin--b"></span>
            <span class="case-study-visual__pin case-study-visual__pin--c"></span>
            <div class="case-study-visual__radar"></div>
          </div>
          <div class="case-study-visual__stack">
            <span>Place search</span>
            <span>Business types</span>
            <span>Map browse</span>
          </div>
        </div>
  </div>
</section>

<section id="section-2" class="full-bleed case-study-split case-study-split--left case-study-split--alt bg-white" aria-labelledby="section-2-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
          <p class="case-study-story__eyebrow">AI Guidance</p>
          <h2 id="section-2-title">Chart-backed data. Personal insight. Real catalog matches.</h2>
          <p>Teerrath gathers Vedic prediction inputs, then an AI guidance layer returns structured personalization: life-area hooks, what works and what doesn’t, current vs potential scores, and recommendations forced to match live Dev, Mantra, Yantra, and Daan offerings — plus one most-important practice to start.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Six life areas with scored guidance</li>
              <li><span>2</span>Recommendations from the live catalog only</li>
              <li><span>3</span>Calm, hopeful tone — alignment, not fear</li>
          </ol>
    </div>
        <div class="case-study-visual case-study-visual--preparation" aria-hidden="true">
          <div class="case-study-visual__glow"></div>
          <div class="case-study-visual__doc">
            <div class="case-study-visual__doc-bar"></div>
            <div class="case-study-visual__doc-lines">
              <i></i><i></i><i></i><i></i>
            </div>
            <div class="case-study-visual__chips">
              <span>Summary</span>
              <span>Highlights</span>
              <span>SPIN</span>
            </div>
          </div>
          <div class="case-study-visual__pulse">AI</div>
        </div>
  </div>
</section>

<section class="full-bleed case-study-footer-cta bg-white" aria-labelledby="case-cta-heading">
  <div class="section-inner">
    <div class="case-study-story__cta">
      <div>
        <h2 id="case-cta-heading">Want a similar rebuild?</h2>
        <p>Tell us about your workflow — we will help you turn it into a clear product experience.</p>
      </div>
      <div class="case-study-story__cta-actions">
        <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer" class="case-study-detail-hero__btn case-study-detail-hero__btn--primary">
          Talk to us
          <x-frontend.cta-arrow />
        </a>
        <a href="{{ route('case-studies') }}" class="case-study-detail__back">← All case studies</a>
      </div>
    </div>
  </div>
</section>
@endsection
