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
        <span aria-current="page">CABVI — From Manual Product Matching to an Automated AI Workspace</span>
      </nav>

      <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-amber-300 bg-amber-50 px-3 py-1.5 text-sm font-semibold text-amber-800" role="status">
        Draft preview — only visible while logged in
      </p>
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

      <figure class="case-study-detail-hero__media">
        <img
          src="{{ asset('assets/case-studies/cabvi/cabvi-logo.png') }}"
          alt="CABVI — From Manual Product Matching to an Automated AI Workspace"
          title="CABVI — From Manual Product Matching to an Automated AI Workspace"
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
            <p class="case-study-metrics__value">~70%</p>
            <h3 class="case-study-metrics__label">Less time spent hunting look-alikes across supplier sites by hand</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~60%</p>
            <h3 class="case-study-metrics__label">Improvement in match qualification speed</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~75%</p>
            <h3 class="case-study-metrics__label">Less spreadsheet re-entry to keep match records</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~50%</p>
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
          <p class="case-study-story__eyebrow">Qualify &amp; record</p>
          <h2 id="section-2-title">AI helps qualify close calls — the record stays in one place.</h2>
          <p>Strong matches rise first so people are not hand-qualifying noise. When something looks close but unclear, AI can offer a second opinion. Reviewers compare side by side, keep notes and captures, and move the decision forward without rebuilding the story in a spreadsheet.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Rank look-alikes so strong matches rise first</li>
              <li><span>2</span>Use AI when a match is close but unclear</li>
              <li><span>3</span>Compare, keep proof, and hand off without a new sheet</li>
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
