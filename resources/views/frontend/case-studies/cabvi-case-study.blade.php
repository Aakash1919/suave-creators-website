@extends('layouts.frontend')

@section('content')
<section class="case-study-detail-hero site-container" aria-labelledby="case-study-detail-heading">
  <div class="case-study-detail-hero__grid">
    <div class="case-study-detail-hero__copy">

      <p class="case-studies-hero__eyebrow pragati-narrow-regular">Nonprofit / Procurement</p>
      <h1 id="case-study-detail-heading" class="case-study-detail-hero__title">CABVI — From Manual Product Matching to an Automated AI Workspace</h1>
      <p class="case-study-detail-hero__lead">CABVI replaces hand-checking supplier sites, manual match qualification, and spreadsheet record-keeping with automated catalog search, AI help on close calls, and one place to decide with proof.</p>

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

      <figure
        class="case-study-detail-hero__media cabvi-hero"
        data-cabvi-hero
        aria-label="CABVI automated product matching from supplier websites, spreadsheets, and manual checking into an AI workspace"
      >
        @php
          $cabviAsset = 'assets/case-studies/cabvi';
        @endphp
        <div class="cabvi-hero__scene">
          <svg class="cabvi-hero__connectors" viewBox="0 0 1540 1140" preserveAspectRatio="none" aria-hidden="true">
            <defs>
              <filter id="cabvi-hero-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="3.2" result="blur"/>
                <feMerge>
                  <feMergeNode in="blur"/>
                  <feMergeNode in="SourceGraphic"/>
                </feMerge>
              </filter>
            </defs>
            <path id="cabvi-flow-1" class="cabvi-hero__line cabvi-hero__line--src cabvi-hero__line--src-1" d="M250 250 H 320 V 430"/>
            <path id="cabvi-flow-2" class="cabvi-hero__line cabvi-hero__line--src cabvi-hero__line--src-2" d="M250 430 H 430"/>
            <path id="cabvi-flow-3" class="cabvi-hero__line cabvi-hero__line--src cabvi-hero__line--src-3" d="M250 610 H 320 V 430"/>
            <path id="cabvi-flow-ai" class="cabvi-hero__line cabvi-hero__line--ai" d="M860 430 H 980 V 275 H 1045"/>
            <path id="cabvi-flow-rec" class="cabvi-hero__line cabvi-hero__line--rec" d="M1100 350 V 455"/>
            <circle class="cabvi-hero__particle cabvi-hero__particle--1" r="5" cx="0" cy="0" fill="#7dd3fc" filter="url(#cabvi-hero-glow)">
              <animateMotion dur="2.1s" repeatCount="indefinite" begin="0s"><mpath href="#cabvi-flow-1"/></animateMotion>
            </circle>
            <circle class="cabvi-hero__particle cabvi-hero__particle--2" r="3.8" cx="0" cy="0" fill="#93c5fd" filter="url(#cabvi-hero-glow)">
              <animateMotion dur="2.1s" repeatCount="indefinite" begin="1.05s"><mpath href="#cabvi-flow-1"/></animateMotion>
            </circle>
            <circle class="cabvi-hero__particle cabvi-hero__particle--3" r="5" cx="0" cy="0" fill="#7dd3fc" filter="url(#cabvi-hero-glow)">
              <animateMotion dur="1.8s" repeatCount="indefinite" begin="0.2s"><mpath href="#cabvi-flow-2"/></animateMotion>
            </circle>
            <circle class="cabvi-hero__particle cabvi-hero__particle--4" r="3.6" cx="0" cy="0" fill="#93c5fd" filter="url(#cabvi-hero-glow)">
              <animateMotion dur="1.8s" repeatCount="indefinite" begin="1.1s"><mpath href="#cabvi-flow-2"/></animateMotion>
            </circle>
            <circle class="cabvi-hero__particle cabvi-hero__particle--5" r="5" cx="0" cy="0" fill="#7dd3fc" filter="url(#cabvi-hero-glow)">
              <animateMotion dur="2.2s" repeatCount="indefinite" begin="0.35s"><mpath href="#cabvi-flow-3"/></animateMotion>
            </circle>
            <circle class="cabvi-hero__particle cabvi-hero__particle--6" r="3.8" cx="0" cy="0" fill="#93c5fd" filter="url(#cabvi-hero-glow)">
              <animateMotion dur="2.2s" repeatCount="indefinite" begin="1.45s"><mpath href="#cabvi-flow-3"/></animateMotion>
            </circle>
            <circle class="cabvi-hero__particle cabvi-hero__particle--ai" r="4.4" cx="0" cy="0" fill="#60a5fa" filter="url(#cabvi-hero-glow)">
              <animateMotion dur="1.6s" repeatCount="indefinite" begin="0.8s"><mpath href="#cabvi-flow-ai"/></animateMotion>
            </circle>
          </svg>

          <article class="cabvi-hero__source cabvi-hero__source--1">
            <span class="cabvi-hero__source-icon">
              <img
                src="{{ asset($cabviAsset.'/cabvi-hero-supplier-icon.webp') }}"
                alt="Supplier websites icon for CABVI automated product matching"
                title="Supplier websites icon for CABVI automated product matching"
                width="48"
                height="48"
                loading="eager"
                decoding="async"
              >
            </span>
            <p class="cabvi-hero__source-label">Supplier<br>Websites</p>
          </article>
          <article class="cabvi-hero__source cabvi-hero__source--2">
            <span class="cabvi-hero__source-icon">
              <img
                src="{{ asset($cabviAsset.'/cabvi-hero-spreadsheet-icon.webp') }}"
                alt="Spreadsheets and records icon for CABVI product matching software"
                title="Spreadsheets and records icon for CABVI product matching software"
                width="48"
                height="48"
                loading="eager"
                decoding="async"
              >
            </span>
            <p class="cabvi-hero__source-label">Spreadsheets<br>&amp; Records</p>
          </article>
          <article class="cabvi-hero__source cabvi-hero__source--3">
            <span class="cabvi-hero__source-icon">
              <img
                src="{{ asset($cabviAsset.'/cabvi-hero-manual-checking-icon.webp') }}"
                alt="Manual checking icon for CABVI procurement review workflow"
                title="Manual checking icon for CABVI procurement review workflow"
                width="48"
                height="48"
                loading="eager"
                decoding="async"
              >
            </span>
            <p class="cabvi-hero__source-label">Manual<br>Checking</p>
          </article>

          <div class="cabvi-hero__dashboard">
            <header class="cabvi-hero__search">
              <span class="cabvi-hero__search-icon">
                <img
                  src="{{ asset($cabviAsset.'/cabvi-hero-search-field-icon.webp') }}"
                  alt="Search field icon for the CABVI product matching dashboard"
                  title="Search field icon for the CABVI product matching dashboard"
                  width="20"
                  height="20"
                  loading="eager"
                  decoding="async"
                >
              </span>
              <span class="cabvi-hero__search-line" aria-hidden="true"></span>
            </header>
            <div class="cabvi-hero__rows">
              <div class="cabvi-hero__row cabvi-hero__row--1">
                <span class="cabvi-hero__thumb">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-row-icon.png') }}" alt="Product row placeholder icon for CABVI catalog matching" title="Product row placeholder icon for CABVI catalog matching" width="24" height="24" loading="eager" decoding="async">
                </span>
                <span class="cabvi-hero__bars" aria-hidden="true"><i></i><i></i></span>
                <span class="cabvi-hero__tick">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-tick-icon.png') }}" alt="Match confirmed placeholder icon for CABVI product matching" title="Match confirmed placeholder icon for CABVI product matching" width="24" height="24" loading="eager" decoding="async">
                </span>
              </div>
              <div class="cabvi-hero__row cabvi-hero__row--2">
                <span class="cabvi-hero__thumb">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-row-icon.png') }}" alt="Product row placeholder icon for CABVI catalog matching" title="Product row placeholder icon for CABVI catalog matching" width="24" height="24" loading="eager" decoding="async">
                </span>
                <span class="cabvi-hero__bars" aria-hidden="true"><i></i><i></i></span>
                <span class="cabvi-hero__tick">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-tick-icon.png') }}" alt="Match confirmed placeholder icon for CABVI product matching" title="Match confirmed placeholder icon for CABVI product matching" width="24" height="24" loading="eager" decoding="async">
                </span>
              </div>
              <div class="cabvi-hero__row cabvi-hero__row--3 cabvi-hero__row--review">
                <span class="cabvi-hero__thumb">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-row-icon.png') }}" alt="Product row placeholder icon for CABVI catalog matching" title="Product row placeholder icon for CABVI catalog matching" width="24" height="24" loading="eager" decoding="async">
                </span>
                <span class="cabvi-hero__bars" aria-hidden="true"><i></i><i></i></span>
                <span class="cabvi-hero__query">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-query-icon.png') }}" alt="Close-call review placeholder icon for CABVI AI matching" title="Close-call review placeholder icon for CABVI AI matching" width="24" height="24" loading="eager" decoding="async">
                </span>
              </div>
              <div class="cabvi-hero__row cabvi-hero__row--4">
                <span class="cabvi-hero__thumb">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-row-icon.png') }}" alt="Product row placeholder icon for CABVI catalog matching" title="Product row placeholder icon for CABVI catalog matching" width="24" height="24" loading="eager" decoding="async">
                </span>
                <span class="cabvi-hero__bars" aria-hidden="true"><i></i><i></i></span>
                <span class="cabvi-hero__tick">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-tick-icon.png') }}" alt="Match confirmed placeholder icon for CABVI product matching" title="Match confirmed placeholder icon for CABVI product matching" width="24" height="24" loading="eager" decoding="async">
                </span>
              </div>
              <div class="cabvi-hero__row cabvi-hero__row--5">
                <span class="cabvi-hero__thumb">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-row-icon.png') }}" alt="Product row placeholder icon for CABVI catalog matching" title="Product row placeholder icon for CABVI catalog matching" width="24" height="24" loading="eager" decoding="async">
                </span>
                <span class="cabvi-hero__bars" aria-hidden="true"><i></i><i></i></span>
                <span class="cabvi-hero__tick">
                  <img src="{{ asset($cabviAsset.'/cabvi-hero-tick-icon.png') }}" alt="Match confirmed placeholder icon for CABVI product matching" title="Match confirmed placeholder icon for CABVI product matching" width="24" height="24" loading="eager" decoding="async">
                </span>
              </div>
            </div>
          </div>

          <div class="cabvi-hero__ai">
            {{-- <span class="cabvi-hero__ai-glow" aria-hidden="true"></span> --}}
            {{-- <span class="cabvi-hero__ai-scan" aria-hidden="true"></span> --}}
            <span class="cabvi-hero__ai-icon">
              <img
                src="{{ asset($cabviAsset.'/cabvi-hero-ai-icon.webp') }}"
                alt="AI processing icon for CABVI close-call product matching"
                title="AI processing icon for CABVI close-call product matching"
                width="120"
                height="120"
                loading="eager"
                decoding="async"
              >
            </span>
          </div>

          <article class="cabvi-hero__rec">
            <p class="cabvi-hero__rec-title">Recommendation</p>
            <span class="cabvi-hero__rec-lines" aria-hidden="true"><i></i><i></i></span>
            <p class="cabvi-hero__match">
              <span class="cabvi-hero__match-icon">
                <img src="{{ asset($cabviAsset.'/cabvi-hero-tick-icon.png') }}" alt="Match result placeholder icon for CABVI product recommendation" title="Match result placeholder icon for CABVI product recommendation" width="20" height="20" loading="eager" decoding="async">
              </span>
              Match
            </p>
          </article>

          <div class="cabvi-hero__features">
            <article class="cabvi-hero__feature cabvi-hero__feature--1">
              <span class="cabvi-hero__feature-icon">
                <img
                  src="{{ asset($cabviAsset.'/cabvi-hero-search-icon.png') }}"
                  alt="Automated search icon for CABVI catalog matching software"
                  title="Automated search icon for CABVI catalog matching software"
                  width="32"
                  height="32"
                  loading="eager"
                  decoding="async"
                >
              </span>
              <p class="cabvi-hero__feature-label">Automated search</p>
            </article>
            <article class="cabvi-hero__feature cabvi-hero__feature--2">
              <span class="cabvi-hero__feature-icon">
                <img
                  src="{{ asset($cabviAsset.'/cabvi-hero-robot-icon.png') }}"
                  alt="AI on close calls icon for CABVI product qualification"
                  title="AI on close calls icon for CABVI product qualification"
                  width="32"
                  height="32"
                  loading="eager"
                  decoding="async"
                >
              </span>
              <p class="cabvi-hero__feature-label">AI on Close Calls</p>
            </article>
            <article class="cabvi-hero__feature cabvi-hero__feature--3">
              <span class="cabvi-hero__feature-icon">
                <img
                  src="{{ asset($cabviAsset.'/cabvi-hero-shield-icon.png') }}"
                  alt="Proof and decision icon for CABVI procurement workspace"
                  title="Proof and decision icon for CABVI procurement workspace"
                  width="32"
                  height="32"
                  loading="eager"
                  decoding="async"
                >
              </span>
              <p class="cabvi-hero__feature-label">One Place to Decide with Proof</p>
            </article>
          </div>
        </div>
      </figure>
      <script>
        (function () {
          var el = document.querySelector('[data-cabvi-hero]');
          if (!el || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
          el.classList.add('is-armed');
        })();
      </script>
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
            <p class="case-study-metrics__value">+70%</p>
            <h3 class="case-study-metrics__label">Less time spent hunting look-alikes across supplier sites by hand</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">+60%</p>
            <h3 class="case-study-metrics__label">Improvement in match qualification speed</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">+75%</p>
            <h3 class="case-study-metrics__label">Less spreadsheet re-entry to keep match records</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">+50%</p>
            <h3 class="case-study-metrics__label">Less manpower burned on the find–qualify–record loop</h3>
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
          <p>CABVI’s matching work was almost entirely manual: staff checked look-alike products on other supplier sites one by one, judged by hand whether each item qualified, then typed the results into spreadsheets. That loop burned time and headcount — and still depended on who remembered which tab. Supplier sites also each work differently, so one-size-fits-all hunting kept missing products or pushing people straight back to copy-paste.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2.2 2.2L16 9.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
          </div>
          <h3>Solution</h3>
          <p>We built an automated matching workspace. Teams load their product list, choose supplier catalogs, and get ranked look-alikes without opening every site by hand. Strong matches rise for review. Close-but-unclear matches can get an AI second opinion. Reviewers compare side by side, keep notes and proof in one place, and hand off the decision — so the sheet is a starting list, not the forever home for every match. If automation misses a corner of a site, staff can still save the item from their browser into the same workspace.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 16l5-5 3.5 3.5L20 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 7h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3>Outcome</h3>
          <p>Find, qualify, and record stop being three manual jobs. People spend time judging real candidates — not hunting tabs or re-typing rows — and every decision can travel with notes and proof attached.</p>
        </article>
    </div>
  </div>
</section>

<section id="section-1" class="full-bleed case-study-split case-study-split--right bg-white" aria-labelledby="section-1-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
          <p class="case-study-story__eyebrow">Automate</p>
          <h2 id="section-1-title">Stop opening every supplier site by hand.</h2>
          <p>Some catalogs are simple lists. Others only show products once the live site is open. Some need a direct supplier connection. Big retail sites hide items across huge store maps. CABVI searches eight catalogs automatically — each the way it actually works — so the first pass no longer burns people hours.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Search eight supplier catalogs together automatically</li>
              <li><span>2</span>Read each catalog the way it actually works</li>
              <li><span>3</span>Try again another way when the first pass misses items</li>
          </ol>
    </div>
        {{-- <div class="case-study-visual case-study-visual--discovery" aria-hidden="true">
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
        </div> --}}
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/cabvi/cabvi_left.webp') }}"
            alt="Clear deposits, proven arrival, fair no-show payouts. product screenshot for Suave Creators software development"
            title="Clear deposits, proven arrival, fair no-show payouts. product screenshot for Suave Creators software development"
            width="960"
            height="720"
            loading="eager"
            decoding="async"
          >
        </figure>
  </div>
</section>

<section id="section-2" class="full-bleed case-study-split case-study-split--left case-study-split--alt bg-white" aria-labelledby="section-2-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
          <p class="case-study-story__eyebrow">Qualify &amp; record</p>
          <h2 id="section-2-title">AI helps qualify close calls — the record stays in one place.</h2>
          <p>Strong matches rise first so people are not hand-qualifying noise. When something looks close but unclear, AI can offer a second opinion. Reviewers compare side by side, keep notes and captures, and move the decision forward without rebuilding the story in a spreadsheet.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Rank look-alikes so strong matches rise first</li>
              <li><span>2</span>Use AI when a match is close but unclear</li>
              <li><span>3</span>Compare, keep proof, and hand off without a new sheet</li>
          </ol>
    </div>
        {{-- <div class="case-study-visual case-study-visual--preparation" aria-hidden="true">
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
        </div> --}}
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/cabvi/cabvi_right.webp') }}"
            alt="Confident customer calls — without weeks of waiting. product screenshot for Suave Creators software development"
            title="Confident customer calls — without weeks of waiting. product screenshot for Suave Creators software development"
            width="960"
            height="720"
            loading="eager"
            decoding="async"
          >
        </figure>
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

@push('scripts')
<script>
  (function () {
    var root = document.querySelector('[data-cabvi-hero]');
    if (!root) return;

    var svg = root.querySelector('.cabvi-hero__connectors');
    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var started = false;
    var resizeTimer = 0;

    function point(el, side) {
      var scene = root.querySelector('.cabvi-hero__scene');
      var sr = scene.getBoundingClientRect();
      var r = el.getBoundingClientRect();
      var x = r.left - sr.left;
      var y = r.top - sr.top + r.height / 2;
      if (side === 'right') x += r.width;
      if (side === 'center') x += r.width / 2;
      if (side === 'bottom') {
        x += r.width / 2;
        y = r.bottom - sr.top;
      }
      if (side === 'top') {
        x += r.width / 2;
        y = r.top - sr.top;
      }
      return { x: x, y: y };
    }

    function elbowHV(from, to) {
      if (Math.abs(from.y - to.y) < 0.75) {
        return 'M' + from.x.toFixed(1) + ' ' + from.y.toFixed(1) + ' H' + to.x.toFixed(1);
      }
      return 'M' + from.x.toFixed(1) + ' ' + from.y.toFixed(1)
        + ' H' + to.x.toFixed(1)
        + ' V' + to.y.toFixed(1);
    }

    function elbowHVH(from, to) {
      var span = to.x - from.x;
      if (span <= 10) {
        return elbowHV(from, to);
      }
      var midX = from.x + Math.min(span * 0.4, span - 12);
      if (Math.abs(from.y - to.y) < 0.75) {
        return 'M' + from.x.toFixed(1) + ' ' + from.y.toFixed(1) + ' H' + to.x.toFixed(1);
      }
      return 'M' + from.x.toFixed(1) + ' ' + from.y.toFixed(1)
        + ' H' + midX.toFixed(1)
        + ' V' + to.y.toFixed(1)
        + ' H' + to.x.toFixed(1);
    }

    function layoutConnectors() {
      var scene = root.querySelector('.cabvi-hero__scene');
      if (!scene || !svg) return;

      var sr = scene.getBoundingClientRect();
      var w = Math.max(1, Math.round(sr.width));
      var h = Math.max(1, Math.round(sr.height));
      svg.setAttribute('viewBox', '0 0 ' + w + ' ' + h);

      var dash = root.querySelector('.cabvi-hero__dashboard');
      var review = root.querySelector('.cabvi-hero__row--review');
      var ai = root.querySelector('.cabvi-hero__ai-icon');
      var rec = root.querySelector('.cabvi-hero__rec');
      var src1 = root.querySelector('.cabvi-hero__source--1 .cabvi-hero__source-icon');
      var src2 = root.querySelector('.cabvi-hero__source--2 .cabvi-hero__source-icon');
      var src3 = root.querySelector('.cabvi-hero__source--3 .cabvi-hero__source-icon');
      if (!dash || !review || !ai || !rec || !src1 || !src2 || !src3) return;

      var from1 = point(src1, 'right');
      var from2 = point(src2, 'right');
      var from3 = point(src3, 'right');
      var dashIn = point(dash, 'left');
      var busX = from2.x + Math.max(14, w * 0.03);
      var joinY = from2.y;

      svg.querySelector('#cabvi-flow-1').setAttribute('d', elbowHV(from1, { x: busX, y: joinY }));
      svg.querySelector('#cabvi-flow-2').setAttribute('d', elbowHV(from2, { x: dashIn.x, y: joinY }));
      svg.querySelector('#cabvi-flow-3').setAttribute('d', elbowHV(from3, { x: busX, y: joinY }));

      var fromReview = point(review, 'right');
      var aiIn = point(ai, 'left');
      svg.querySelector('#cabvi-flow-ai').setAttribute('d', elbowHVH(fromReview, aiIn));

      var fromAi = point(ai, 'bottom');
      var toRec = point(rec, 'top');
      toRec.x = fromAi.x;
      svg.querySelector('#cabvi-flow-rec').setAttribute(
        'd',
        'M' + fromAi.x.toFixed(1) + ' ' + fromAi.y.toFixed(1) + ' V' + toRec.y.toFixed(1)
      );
    }

    function pauseMotion() {
      if (svg && typeof svg.pauseAnimations === 'function') svg.pauseAnimations();
    }

    function play() {
      if (started) return;
      started = true;
      layoutConnectors();
      root.classList.add('is-armed', 'is-playing');
      if (svg && typeof svg.unpauseAnimations === 'function') svg.unpauseAnimations();
    }

    function onResize() {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(layoutConnectors, 80);
    }

    function boot() {
      layoutConnectors();
      pauseMotion();
      window.addEventListener('resize', onResize);

      if (reduced) return;

      root.classList.add('is-armed');

      if (!('IntersectionObserver' in window)) {
        play();
        return;
      }

      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          observer.unobserve(entry.target);
          play();
        });
      }, { threshold: 0.28 });

      observer.observe(root);
      window.setTimeout(function () {
        if (!started) play();
      }, 900);
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', boot);
    } else {
      boot();
    }
  })();
</script>
@endpush
