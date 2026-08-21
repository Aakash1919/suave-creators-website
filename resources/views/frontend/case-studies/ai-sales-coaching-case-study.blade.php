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
        <span aria-current="page">An AI Sales Coach That Practices, Whispers, and Scores</span>
      </nav>

      <p class="case-studies-hero__eyebrow pragati-narrow-regular">Sales Enablement</p>
      <h1 id="case-study-detail-heading" class="case-study-detail-hero__title">An AI Sales Coach That Practices, Whispers, and Scores</h1>
      <p class="case-study-detail-hero__lead">An AI sales coaching platform that helps fast-growing teams keep performance consistent as they hire — with voice practice, live call coaching, and clear scores so new reps ramp faster and managers don’t wait on recordings.</p>

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
          src="{{ asset('assets/case-studies/ai-sales-coaching/ai_sales_coach.webp') }}"
          alt="An AI Sales Coach That Practices, Whispers, and Scores"
          title="An AI Sales Coach That Practices, Whispers, and Scores"
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
            <p class="case-study-metrics__value">+55%</p>
            <h3 class="case-study-metrics__label">Faster path from hire to confident customer calls</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">+60%</p>
            <h3 class="case-study-metrics__label">Less manager time spent reviewing recordings for feedback</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">+50%</p>
            <h3 class="case-study-metrics__label">Improvement in call quality consistency as the team expands</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">+45%</p>
            <h3 class="case-study-metrics__label">Fewer opportunities lost waiting on delayed coaching</h3>
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
          <p>A fast-growing company was struggling to maintain consistent sales performance as its team expanded. New sales representatives required weeks of coaching before handling customer calls confidently, while sales managers had limited time to review recordings and provide feedback. As a result, coaching was delayed, call quality varied across the team, and valuable opportunities were lost before improvements could be made. The harder build was an AI agent that could play realistic buyers for practice, whisper short tips during live calls, and score messy conversations quickly enough for managers to coach without living in a recording queue.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2.2 2.2L16 9.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
          </div>
          <h3>Solution</h3>
          <p>We built an AI sales catalyst for growing teams: voice practice against six buyer personalities so new reps gain confidence before customer calls, live meeting assist for objections and next asks so coaching isn’t delayed, and post-call scores with clear next actions so managers can act without reviewing every recording. Teams connect Google or Microsoft calendars and use Stripe-backed AI-minute plans as the roster grows.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 16l5-5 3.5 3.5L20 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 7h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3>Outcome</h3>
          <p>New hires ramp toward confident customer calls without waiting weeks on scarce manager time. Coaching lands during and right after the conversation — not only when someone finds a recording. Call quality stays more consistent as the team expands, and fewer opportunities slip away before feedback can land.</p>
        </article>
    </div>
  </div>
</section>

<section id="section-1" class="full-bleed case-study-split case-study-split--right bg-white" aria-labelledby="section-1-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
          <p class="case-study-story__eyebrow">Practice</p>
          <h2 id="section-1-title">Confident customer calls — without weeks of waiting.</h2>
          <p>New reps start with a call type, difficulty, and buyer personality. The AI plays the prospect — with distinct objections and tone — so confidence builds in practice, not only after weeks of one-to-one coaching on live customers.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Pick cold call, discovery, objections, or follow-up</li>
              <li><span>2</span>Face six personalities that stay in character</li>
              <li><span>3</span>Build confidence before the first high-stakes customer call</li>
          </ol>
    </div>
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/ai-sales-coaching/ai_sales_right.webp') }}"
            alt="Confident customer calls — without weeks of waiting. product screenshot for Suave Creators software development"
            title="Confident customer calls — without weeks of waiting. product screenshot for Suave Creators software development"
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
          <p class="case-study-story__eyebrow">Live coach</p>
          <h2 id="section-2-title">Feedback that doesn’t wait on a recording queue.</h2>
          <p>During real meetings, short coaching tips surface for objections, pain points, and next questions. Afterward, pitch, engagement, and objection handling become scores and a next action — so managers coach with evidence instead of hunting through recordings.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Live suggestions while the prospect is still talking</li>
              <li><span>2</span>Clear scores when the call ends — not days later</li>
              <li><span>3</span>Team views that keep quality more consistent as you hire</li>
          </ol>
    </div>
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/ai-sales-coaching/ai_sales_left.webp') }}"
            alt="Feedback that doesn’t wait on a recording queue. product screenshot for Suave Creators software development"
            title="Feedback that doesn’t wait on a recording queue. product screenshot for Suave Creators software development"
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
