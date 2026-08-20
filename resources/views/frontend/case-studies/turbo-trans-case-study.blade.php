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
        <span aria-current="page">Success Story : The Turbo Trans Corporation</span>
      </nav>

      <p class="case-studies-hero__eyebrow pragati-narrow-regular">Logistics &amp; Freight</p>
      <h1 id="case-study-detail-heading" class="case-study-detail-hero__title">Success Story : The Turbo Trans Corporation</h1>
      <p class="case-study-detail-hero__lead">See how a logistics leader transformed their sales operations with AI-powered CRM automation TurboTrans Corporation is a leading logistics and freight forwarding company specializing in air freight, ocean freight, land transportation, customs clearance, and end-to-end supply chain solutions.</p>

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

      <figure class="case-study-detail-hero__media case-study-detail-hero__media--client-logo">
        <img
          src="{{ asset('assets/case-studies/turbo-trans/turbo-trans-corporation-logo.png') }}"
          alt="Turbo Trans Corp TTC logo partner of Suave Creators logistics CRM"
          title="Turbo Trans Corp TTC logo partner of Suave Creators logistics CRM"
          width="248"
          height="108"
          loading="eager"
          decoding="async"
        >
      </figure>
  </div>
</section>


<section id="section-1" class="full-bleed case-study-split case-study-split--right case-study-split--stack-tight bg-white" aria-labelledby="section-1-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
          <h2 id="section-1-title">The Challenge</h2>
          <p>Before implementing The Suave Sales CRM, the sales team faced several operational challenges:</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Leads coming from multiple sources without a centralized system</li>
              <li><span>2</span>Delayed follow-ups causing missed opportunities</li>
              <li><span>3</span>Limited visibility into the sales pipeline</li>
              <li><span>4</span>Manual reporting and scattered customer information</li>
              <li><span>5</span>Difficulty tracking sales performance across the team</li>
          </ol>
    </div>
        <div class="case-study-visual case-study-visual--metrics" aria-label="Key performance metrics">
      <article class="product-case-study__metric product-case-study__metric--blue product-case-study__metric--has-chart product-case-study__metric--has-chart-strip">
        <div class="product-case-study__metric-icon">
          <img
            src="{{ asset('assets/product/leads.png') }}"
            alt="Qualified leads growth icon for Suave AI sales CRM case study metric"
            title="Qualified leads growth icon for Suave AI sales CRM case study metric"
            width="20"
            height="20"
            decoding="async"
            loading="lazy"
          >
        </div>
        <x-frontend.case-study-metric-value class="product-case-study__metric-value" tag="p" value="42%" />
        <p class="product-case-study__metric-label">More Qualified Leads</p>
        <p class="product-case-study__metric-caption">vs. Previous Quarter</p>
        <div
          class="product-case-study__metric-chart product-case-study__metric-chart--image product-case-study__metric-chart--strip"
          aria-hidden="true"
          style="background-image: url('{{ asset('assets/product/graph_vector1.png') }}')"
        ></div>
      </article>
      <article class="product-case-study__metric product-case-study__metric--purple product-case-study__metric--has-chart product-case-study__metric--has-chart-strip">
        <div class="product-case-study__metric-icon">
          <img
            src="{{ asset('assets/product/follow_ups.png') }}"
            alt="Faster response time icon for Suave AI CRM automation case study"
            title="Faster response time icon for Suave AI CRM automation case study"
            width="20"
            height="20"
            decoding="async"
            loading="lazy"
          >
        </div>
        <x-frontend.case-study-metric-value class="product-case-study__metric-value" tag="p" value="3.4x" />
        <p class="product-case-study__metric-label">Faster Response Time</p>
        <p class="product-case-study__metric-caption">Average Lead Response</p>
        <div
          class="product-case-study__metric-chart product-case-study__metric-chart--image product-case-study__metric-chart--strip"
          aria-hidden="true"
          style="background-image: url('{{ asset('assets/product/graph_vector2.png') }}')"
        ></div>
      </article>
        </div>
  </div>
</section>

<section id="section-2" class="full-bleed case-study-split case-study-split--right case-study-split--alt case-study-split--stack-tight bg-white" aria-labelledby="section-2-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
        
          <h2 id="section-2-title">The Solution</h2>
          <p>TurboTrans adopted The Suave Sales CRM to centralize its entire sales process. Key implementations included:</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>AI-powered lead qualification</li>
              <li><span>2</span>Automated follow-up reminders</li>
              <li><span>3</span>Visual sales pipeline</li>
              <li><span>4</span>Real-time sales dashboard</li>
              <li><span>5</span>Team collaboration</li>
              <li><span>6</span>Smart reporting &amp; analytics</li>
              <li><span>7</span>Customer activity timeline</li>
          </ol>
    </div>
        <div class="case-study-visual case-study-visual--metrics" aria-label="Key performance metrics">
      <article class="product-case-study__metric product-case-study__metric--teal product-case-study__metric--has-chart product-case-study__metric--has-chart-strip">
        <div class="product-case-study__metric-icon">
          <img
            src="{{ asset('assets/product/Manual_work.png') }}"
            alt="Pipeline visibility icon for Suave AI sales CRM deal tracking case study"
            title="Pipeline visibility icon for Suave AI sales CRM deal tracking case study"
            width="20"
            height="20"
            decoding="async"
            loading="lazy"
          >
        </div>
        <x-frontend.case-study-metric-value class="product-case-study__metric-value" tag="p" value="68%" />
        <p class="product-case-study__metric-label">Pipeline Visibility</p>
        <p class="product-case-study__metric-caption">Complete Deal Tracking</p>
        <div
          class="product-case-study__metric-chart product-case-study__metric-chart--image product-case-study__metric-chart--strip"
          aria-hidden="true"
          style="background-image: url('{{ asset('assets/product/graph_vector3.png') }}')"
        ></div>
      </article>
      <article class="product-case-study__metric product-case-study__metric--orange product-case-study__metric--has-chart product-case-study__metric--has-chart-strip">
        <div class="product-case-study__metric-icon">
          <img
            src="{{ asset('assets/product/case-study-metric-revenue-growth-icon.png') }}"
            alt="Revenue growth icon for Suave AI powered sales CRM success story"
            title="Revenue growth icon for Suave AI powered sales CRM success story"
            width="20"
            height="20"
            decoding="async"
            loading="lazy"
          >
        </div>
        <x-frontend.case-study-metric-value class="product-case-study__metric-value" tag="p" value="2.8x" />
        <p class="product-case-study__metric-label">Revenue Growth</p>
        <p class="product-case-study__metric-caption">Year-over-Year Increase</p>
        <div
          class="product-case-study__metric-chart product-case-study__metric-chart--image product-case-study__metric-chart--strip"
          aria-hidden="true"
          style="background-image: url('{{ asset('assets/product/graph_vector4.png') }}')"
        ></div>
      </article>
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
