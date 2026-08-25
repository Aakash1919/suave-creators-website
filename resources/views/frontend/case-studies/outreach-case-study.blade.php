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

      <figure
        class="case-study-detail-hero__media outreach-hero"
        data-outreach-hero
        aria-label="The Suave App Outreach — from a fragmented manual process to a unified B2B CRM sales workspace with about 65% fewer steps"
      >
        <div class="outreach-hero__board">
          <div class="outreach-hero__top">
            <article class="outreach-hero__card outreach-hero__card--before">
              <span class="outreach-hero__badge">Before</span>
              <p class="outreach-hero__headline">Fragmented. Manual. Too many steps.</p>
              <div class="outreach-hero__before-flow">
                <span class="outreach-hero__node outreach-hero__node--1">
                  <span class="outreach-hero__node-disc">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-email-icon.webp') }}"
                      alt="Email outreach icon for Suave CRM sales workflow"
                      title="Email outreach icon for Suave CRM sales workflow"
                      width="24"
                      height="24"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                </span>
                <span class="outreach-hero__before-line outreach-hero__before-line--h-top" aria-hidden="true"></span>
                <span class="outreach-hero__node outreach-hero__node--2">
                  <span class="outreach-hero__node-disc">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-phone-icon.webp') }}"
                      alt="Phone call icon for Suave CRM outbound sales"
                      title="Phone call icon for Suave CRM outbound sales"
                      width="24"
                      height="24"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                </span>
                <span class="outreach-hero__before-line outreach-hero__before-line--v-mid" aria-hidden="true"></span>
                <span class="outreach-hero__node outreach-hero__node--3">
                  <span class="outreach-hero__node-disc">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-table-icon.webp') }}"
                      alt="Spreadsheet table icon for Suave CRM prospecting steps"
                      title="Spreadsheet table icon for Suave CRM prospecting steps"
                      width="24"
                      height="24"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                </span>
                <span class="outreach-hero__before-line outreach-hero__before-line--v-bot" aria-hidden="true"></span>
                <span class="outreach-hero__node outreach-hero__node--4">
                  <span class="outreach-hero__node-disc">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-clipboard-icon.webp') }}"
                      alt="Document checklist icon for Suave CRM outbound sales"
                      title="Document checklist icon for Suave CRM outbound sales"
                      width="24"
                      height="24"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                </span>
                <span class="outreach-hero__before-line outreach-hero__before-line--h-bot" aria-hidden="true"></span>
                <span class="outreach-hero__node outreach-hero__node--5">
                  <span class="outreach-hero__node-disc">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-document-icon.webp') }}"
                      alt="Clipboard task icon for Suave CRM sales workflow"
                      title="Clipboard task icon for Suave CRM sales workflow"
                      width="24"
                      height="24"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                </span>
              </div>
            </article>

            <div class="outreach-hero__transition" aria-hidden="true">
              <span class="outreach-hero__transition-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14M13 6l6 6-6 6"/>
                </svg>
              </span>
            </div>

            <article class="outreach-hero__card outreach-hero__card--after">
              <span class="outreach-hero__badge outreach-hero__badge--after">After</span>
              <p class="outreach-hero__headline">Unified. Intelligent. Effortless Outreach.</p>

              <div class="outreach-hero__after-flow">
                <div class="outreach-hero__step outreach-hero__step--1">
                  <span class="outreach-hero__step-icon">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-map-discovery-icon.webp') }}"
                      alt="Map discovery icon for Suave CRM company search"
                      title="Map discovery icon for Suave CRM company search"
                      width="24"
                      height="24"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                  <span class="outreach-hero__step-label">Map Discovery</span>
                </div>
                <span class="outreach-hero__chevron outreach-hero__chevron--1" aria-hidden="true">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-outreach/Arrow.webp') }}"
                    alt="Next step arrow for Suave CRM outreach workflow"
                    title="Next step arrow for Suave CRM outreach workflow"
                    width="8"
                    height="10"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                <div class="outreach-hero__step outreach-hero__step--2">
                  <span class="outreach-hero__step-icon">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-unified-leads-icon.webp') }}"
                      alt="Unified leads icon for Suave CRM sales pipeline"
                      title="Unified leads icon for Suave CRM sales pipeline"
                      width="24"
                      height="24"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                  <span class="outreach-hero__step-label">Unified Leads</span>
                </div>
                <span class="outreach-hero__chevron outreach-hero__chevron--2" aria-hidden="true">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-outreach/Arrow.webp') }}"
                    alt="Next step arrow for Suave CRM outreach workflow"
                    title="Next step arrow for Suave CRM outreach workflow"
                    width="8"
                    height="10"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                <div class="outreach-hero__step outreach-hero__step--3">
                  <span class="outreach-hero__step-icon">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-ai-briefings-icon.webp') }}"
                      alt="AI briefings icon for Suave CRM sales prospecting"
                      title="AI briefings icon for Suave CRM sales prospecting"
                      width="24"
                      height="24"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                  <span class="outreach-hero__step-label">AI Briefings</span>
                </div>
                <span class="outreach-hero__chevron outreach-hero__chevron--3" aria-hidden="true">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-outreach/Arrow.webp') }}"
                    alt="Next step arrow for Suave CRM outreach workflow"
                    title="Next step arrow for Suave CRM outreach workflow"
                    width="8"
                    height="10"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                <div class="outreach-hero__step outreach-hero__step--4">
                  <span class="outreach-hero__step-icon">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-take-action-icon.webp') }}"
                      alt="Take action icon for Suave CRM outreach workflow"
                      title="Take action icon for Suave CRM outreach workflow"
                      width="24"
                      height="24"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                  <span class="outreach-hero__step-label">Take Action</span>
                </div>
              </div>

              <div class="outreach-hero__metric">
                <span class="outreach-hero__metric-icon">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-fewer-steps-icon.png') }}"
                    alt="Trend icon for fewer Suave CRM prospecting steps"
                    title="Trend icon for fewer Suave CRM prospecting steps"
                    width="24"
                    height="24"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                <p class="outreach-hero__metric-text">~<span data-outreach-count>65</span>% fewer steps</p>
              </div>

              <div class="outreach-hero__graph">
                <svg class="outreach-hero__graph-svg" viewBox="0 0 280 88" preserveAspectRatio="none" fill="none" aria-hidden="true">
                  <defs>
                    <linearGradient id="outreachHeroGraphFill" gradientUnits="userSpaceOnUse" x1="158.5" y1="0.4" x2="121.5" y2="88">
                      <stop offset="4.92%" stop-color="rgb(0, 38, 227)" stop-opacity="0.2"/>
                      <stop offset="97.57%" stop-color="rgb(0, 38, 227)" stop-opacity="0"/>
                    </linearGradient>
                  </defs>
                  <g class="outreach-hero__graph-area">
                    <path class="outreach-hero__graph-fill" d="M4.00 80.00 C5.24 80.00 8.96 82.75 11.44 80.00 C13.93 77.25 16.41 66.71 18.89 63.52 C21.37 60.33 23.85 61.58 26.33 60.87 C28.82 60.16 31.30 63.14 33.78 59.24 C36.26 55.34 38.74 41.81 41.22 37.47 C43.71 33.13 46.19 28.38 48.67 33.20 C51.15 38.01 53.63 58.77 56.11 66.37 C58.59 73.96 61.08 80.47 63.56 78.78 C66.04 77.08 68.52 61.89 71.00 56.19 C73.48 50.49 75.97 48.22 78.45 44.59 C80.93 40.96 83.41 36.62 85.89 34.42 C88.37 32.21 90.86 29.84 93.34 31.37 C95.82 32.89 98.30 39.34 100.78 43.58 C103.26 47.81 105.75 53.31 108.23 56.80 C110.71 60.30 113.19 64.91 115.67 64.53 C118.15 64.16 120.63 59.69 123.12 54.56 C125.60 49.44 128.08 37.67 130.56 33.81 C133.04 29.94 135.52 31.20 138.01 31.37 C140.49 31.54 142.97 35.47 145.45 34.83 C147.93 34.18 150.41 30.72 152.90 27.50 C155.38 24.28 157.86 18.41 160.34 15.49 C162.82 12.58 165.30 10.41 167.78 10.00 C170.27 9.59 172.75 10.68 175.23 13.05 C177.71 15.43 180.19 19.97 182.67 24.24 C185.16 28.52 187.64 35.20 190.12 38.69 C192.60 42.19 195.08 43.27 197.56 45.20 C200.05 47.14 202.53 46.22 205.01 50.29 C207.49 54.36 209.97 66.71 212.45 69.62 C214.94 72.54 217.42 71.79 219.90 67.79 C222.38 63.79 224.86 49.75 227.34 45.61 C229.82 41.47 232.31 42.59 234.79 42.97 C237.27 43.34 239.75 46.66 242.23 47.85 C244.71 49.04 247.20 50.80 249.68 50.09 C252.16 49.38 254.64 46.05 257.12 43.58 C259.60 41.10 262.09 37.50 264.57 35.23 C267.05 32.96 270.11 30.89 272.01 29.94 C273.92 28.99 275.34 29.60 276.00 29.53 L276.00 88 L4.00 88 Z" fill="url(#outreachHeroGraphFill)"/>
                  </g>
                  <path class="outreach-hero__graph-line" d="M4.00 80.00 C5.24 80.00 8.96 82.75 11.44 80.00 C13.93 77.25 16.41 66.71 18.89 63.52 C21.37 60.33 23.85 61.58 26.33 60.87 C28.82 60.16 31.30 63.14 33.78 59.24 C36.26 55.34 38.74 41.81 41.22 37.47 C43.71 33.13 46.19 28.38 48.67 33.20 C51.15 38.01 53.63 58.77 56.11 66.37 C58.59 73.96 61.08 80.47 63.56 78.78 C66.04 77.08 68.52 61.89 71.00 56.19 C73.48 50.49 75.97 48.22 78.45 44.59 C80.93 40.96 83.41 36.62 85.89 34.42 C88.37 32.21 90.86 29.84 93.34 31.37 C95.82 32.89 98.30 39.34 100.78 43.58 C103.26 47.81 105.75 53.31 108.23 56.80 C110.71 60.30 113.19 64.91 115.67 64.53 C118.15 64.16 120.63 59.69 123.12 54.56 C125.60 49.44 128.08 37.67 130.56 33.81 C133.04 29.94 135.52 31.20 138.01 31.37 C140.49 31.54 142.97 35.47 145.45 34.83 C147.93 34.18 150.41 30.72 152.90 27.50 C155.38 24.28 157.86 18.41 160.34 15.49 C162.82 12.58 165.30 10.41 167.78 10.00 C170.27 9.59 172.75 10.68 175.23 13.05 C177.71 15.43 180.19 19.97 182.67 24.24 C185.16 28.52 187.64 35.20 190.12 38.69 C192.60 42.19 195.08 43.27 197.56 45.20 C200.05 47.14 202.53 46.22 205.01 50.29 C207.49 54.36 209.97 66.71 212.45 69.62 C214.94 72.54 217.42 71.79 219.90 67.79 C222.38 63.79 224.86 49.75 227.34 45.61 C229.82 41.47 232.31 42.59 234.79 42.97 C237.27 43.34 239.75 46.66 242.23 47.85 C244.71 49.04 247.20 50.80 249.68 50.09 C252.16 49.38 254.64 46.05 257.12 43.58 C259.60 41.10 262.09 37.50 264.57 35.23 C267.05 32.96 270.11 30.89 272.01 29.94 C273.92 28.99 275.34 29.60 276.00 29.53" pathLength="1" stroke="#2563eb" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                  <line class="outreach-hero__peak-guide" x1="167.78" y1="10" x2="167.78" y2="88" stroke="#93c5fd" stroke-width="1.2" stroke-dasharray="3 4"/>
                </svg>
                <span class="outreach-hero__peak" aria-hidden="true"></span>
              </div>
            </article>
          </div>

          <article class="outreach-hero__card outreach-hero__card--actions">
            <p class="outreach-hero__actions-title">Next Actions</p>
            <div class="outreach-hero__actions">
              <span class="outreach-hero__action">
                <span class="outreach-hero__action-icon outreach-hero__action-icon--email">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-send-email-icon.png') }}"
                    alt="Send email action icon for Suave CRM outreach"
                    title="Send email action icon for Suave CRM outreach"
                    width="24"
                    height="24"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                Send Email
              </span>
              <span class="outreach-hero__action">
                <span class="outreach-hero__action-icon outreach-hero__action-icon--call">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-call-icon.png') }}"
                    alt="Call action icon for Suave CRM sales workspace"
                    title="Call action icon for Suave CRM sales workspace"
                    width="24"
                    height="24"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                Call
              </span>
              <span class="outreach-hero__action">
                <span class="outreach-hero__action-icon outreach-hero__action-icon--task">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-create-task-icon.png') }}"
                    alt="Create task action icon for Suave CRM workspace"
                    title="Create task action icon for Suave CRM workspace"
                    width="24"
                    height="24"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                Create Task
              </span>
              <span class="outreach-hero__action">
                <span class="outreach-hero__action-icon outreach-hero__action-icon--sequence">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-outreach/outreach-add-sequence-icon.png') }}"
                    alt="Add to sequence icon for Suave CRM email automation"
                    title="Add to sequence icon for Suave CRM email automation"
                    width="24"
                    height="24"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                Add to Sequence
              </span>
            </div>
          </article>
        </div>
      </figure>
      <script>
        (function () {
          var el = document.querySelector('[data-outreach-hero]');
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
            <p class="case-study-metrics__value">~65%</p>
            <h3 class="case-study-metrics__label">Fewer steps for routine B2B CRM outbound sales prospecting</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~35%</p>
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

@push('scripts')
<script>
  (function () {
    var root = document.querySelector('[data-outreach-hero]');
    if (!root) return;

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) return;

    var countEl = root.querySelector('[data-outreach-count]');
    var graphPath = root.querySelector('.outreach-hero__graph-line');
    var countFrame = 0;
    var timers = [];
    var dashFrames = [];

    function later(fn, delay) {
      timers.push(setTimeout(fn, delay));
    }

    function animateDash(path, duration, delay) {
      if (!path) return;
      path.style.strokeDasharray = '1';
      path.style.strokeDashoffset = '1';
      later(function () {
        var start = null;
        function step(ts) {
          if (!start) start = ts;
          var progress = Math.min((ts - start) / duration, 1);
          var eased = 1 - Math.pow(1 - progress, 3);
          path.style.strokeDashoffset = String(1 - eased);
          path.setAttribute('stroke-dashoffset', String(1 - eased));
          if (progress < 1) dashFrames.push(requestAnimationFrame(step));
        }
        dashFrames.push(requestAnimationFrame(step));
      }, delay);
    }

    function countUp() {
      if (!countEl) return;
      if (countFrame) cancelAnimationFrame(countFrame);
      var end = 65;
      var duration = 700;
      var start = null;
      countEl.textContent = '0';

      function step(ts) {
        if (!start) start = ts;
        var progress = Math.min((ts - start) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        countEl.textContent = String(Math.round(end * eased));
        if (progress < 1) countFrame = requestAnimationFrame(step);
      }

      countFrame = requestAnimationFrame(step);
    }

    function play() {
      timers.forEach(clearTimeout);
      timers = [];
      dashFrames.forEach(function (id) { cancelAnimationFrame(id); });
      dashFrames = [];
      if (countFrame) cancelAnimationFrame(countFrame);
      root.classList.remove('is-playing');
      if (countEl) countEl.textContent = '0';
      if (graphPath) {
        graphPath.style.strokeDashoffset = '1';
        graphPath.setAttribute('stroke-dashoffset', '1');
      }
      void root.offsetWidth;
      root.classList.add('is-playing');
      animateDash(graphPath, 1350, 4550);
      later(countUp, 4150);
    }

    function boot() {
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
      }, { threshold: 0.35 });

      observer.observe(root);
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', boot);
    } else {
      boot();
    }
  })();
</script>
@endpush
