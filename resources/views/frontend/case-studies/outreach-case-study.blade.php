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
        <span aria-current="page">The Suave App Outreach — From a Complex Process to a Clear B2B CRM Sales Workspace</span>
      </nav>

      <p class="case-studies-hero__eyebrow pragati-narrow-regular">B2B SaaS / Sales CRM</p>
      <h1 id="case-study-detail-heading" class="case-study-detail-hero__title">The Suave App Outreach — From a Complex Process to a Clear B2B CRM Sales Workspace</h1>
      <p class="case-study-detail-hero__lead">We redesigned the suave app’s fragmented B2B CRM outbound sales workflow into one prospecting workspace — map-based company discovery, AI sales briefings, cold email automation, and pipeline tracking — with about 65% fewer steps.</p>

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
          src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-before-after-hero.png') }}"
          alt="The Suave App Outreach — From a Complex Process to a Clear B2B CRM Sales Workspace"
          title="The Suave App Outreach — From a Complex Process to a Clear B2B CRM Sales Workspace"
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
            <p class="case-study-metrics__value">+65%</p>
            <h3 class="case-study-metrics__label">Fewer steps for routine B2B CRM outbound sales prospecting</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">+35%</p>
            <h3 class="case-study-metrics__label">Less effort to complete the same sales pipeline work</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">1</p>
            <h3 class="case-study-metrics__label">Connected CRM workspace from map discovery to cold email</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">3</p>
            <h3 class="case-study-metrics__label">Focused areas — Outreach, Targets, and Email automation</h3>
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
          <p>The original Outbound module in the suave app spread B2B CRM outbound sales work across several screens. Map-based company discovery, contact details, target lists, cold email, and pipeline history all lived in different places. Sales reps kept switching views and repeating steps — turning simple B2B sales prospecting into a slow, fragmented process.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2.2 2.2L16 9.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
          </div>
          <h3>Solution</h3>
          <p>We redesigned the suave app around one B2B CRM outbound sales workflow. Reps find companies on a map, review AI sales prospecting briefings, and move qualified prospects into the pipeline. Cold email automation and conversation history stay beside each company record, while Targets live in a focused area so daily outreach stays simple.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 16l5-5 3.5 3.5L20 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 7h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3>Outcome</h3>
          <p>Routine B2B CRM outbound sales now takes about 65% fewer steps. Teams move from map-based company discovery to a well-prepared cold email without losing context. The clearer experience in the suave app gives reps more time for customer relationships and shows how thoughtful CRM design turns fragmented prospecting into efficient B2B sales pipeline management.</p>
        </article>
    </div>
  </div>
</section>

<section id="section-1" class="full-bleed case-study-split case-study-split--right bg-white" aria-labelledby="section-1-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
          <p class="case-study-story__eyebrow">Map discovery</p>
          <h2 id="section-1-title">B2B map-based company discovery without jumping between CRM screens.</h2>
          <p>In the suave app, sales reps choose a location and business type, then browse nearby companies on the map. They review company details in the same view and add only relevant prospects to the B2B sales pipeline — without leaving the discovery workspace.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Search by location and business type for targeted B2B prospecting</li>
              <li><span>2</span>Review map results and company details before adding to the pipeline</li>
              <li><span>3</span>Stay in one CRM view from search to qualified target selection</li>
          </ol>
    </div>
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/suave-crm-outreach/outreach_right.webp') }}"
            alt="B2B map-based company discovery without jumping between CRM screens. product screenshot for Suave Creators software development"
            title="B2B map-based company discovery without jumping between CRM screens. product screenshot for Suave Creators software development"
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
          <p class="case-study-story__eyebrow">AI prospecting</p>
          <h2 id="section-2-title">AI sales prospecting briefings before your first cold email.</h2>
          <p>Each company record in the suave app includes an AI-generated website summary, sales highlights, and suggested questions. Reps prepare and send cold email from the same screen, follow the conversation thread, and practise calls without losing B2B CRM context.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Use AI sales prospecting research to brief reps before outreach</li>
              <li><span>2</span>Send cold email with company details and history in one CRM record</li>
              <li><span>3</span>Practise sales calls and review coaching feedback beside the pipeline</li>
          </ol>
    </div>
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/suave-crm-outreach/outreach_left.webp') }}"
            alt="AI sales prospecting briefings before your first cold email. product screenshot for Suave Creators software development"
            title="AI sales prospecting briefings before your first cold email. product screenshot for Suave Creators software development"
            width="960"
            height="720"
            loading="eager"
            decoding="async"
          >
        </figure>
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
