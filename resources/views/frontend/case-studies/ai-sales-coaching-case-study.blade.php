@extends('layouts.frontend')

@section('content')
<section class="case-study-detail-hero site-container" aria-labelledby="case-study-detail-heading">
  <div class="case-study-detail-hero__grid">
    <div class="case-study-detail-hero__copy">
      {{-- <nav class="case-studies-hero__breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('case-studies') }}">Case Studies</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">An AI Sales Coach That Practices, Whispers, and Scores</span>
      </nav> --}}

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

      <figure
        class="case-study-detail-hero__media coach-hero"
        data-coach-hero
        aria-label="AI sales coaching dashboard with live call coaching, practice roleplay, and performance scores"
      >
        @php
          $coachAsset = 'assets/case-studies/ai-sales-coaching';
          $coachWave = [8, 8, 9, 10, 12, 16, 22, 30, 42, 56, 70, 48, 86, 62, 38, 78, 54, 92, 44, 68, 82, 36, 74, 58, 90, 46, 64, 80, 40, 72, 52, 34, 26, 18, 14, 11, 10, 9, 8, 8];
        @endphp
        <div class="coach-hero__board">
          <aside class="coach-hero__nav" aria-hidden="true">
            <span class="coach-hero__logo">
              <img
                src="{{ asset($coachAsset.'/Shape.png') }}"
                alt="AI sales coaching platform logo for the coach dashboard"
                title="AI sales coaching platform logo for the coach dashboard"
                width="24"
                height="24"
                loading="eager"
                decoding="async"
              >
            </span>
            <span class="coach-hero__nav-btn is-active">
              <img src="{{ asset($coachAsset.'/coach-hero-nav-home-icon.webp') }}" alt="Home navigation icon for AI sales coaching dashboard" title="Home navigation icon for AI sales coaching dashboard" width="18" height="18" loading="eager" decoding="async">
            </span>
            <span class="coach-hero__nav-btn">
              <img src="{{ asset($coachAsset.'/coach-hero-nav-chart-icon.webp') }}" alt="Analytics chart icon for AI sales coaching scores" title="Analytics chart icon for AI sales coaching scores" width="18" height="18" loading="eager" decoding="async">
            </span>
            <span class="coach-hero__nav-btn">
              <img src="{{ asset($coachAsset.'/coach-hero-nav-users-icon.webp') }}" alt="Team members icon for AI sales coaching platform" title="Team members icon for AI sales coaching platform" width="18" height="18" loading="eager" decoding="async">
            </span>
            <span class="coach-hero__nav-btn">
              <img src="{{ asset($coachAsset.'/coach-hero-nav-message-icon.webp') }}" alt="Coaching messages icon for live sales call assist" title="Coaching messages icon for live sales call assist" width="18" height="18" loading="eager" decoding="async">
            </span>
            <span class="coach-hero__nav-btn">
              <img src="{{ asset($coachAsset.'/coach-hero-nav-trend-icon.webp') }}" alt="Performance trend icon for AI sales coaching software" title="Performance trend icon for AI sales coaching software" width="18" height="18" loading="eager" decoding="async">
            </span>
            <span class="coach-hero__nav-btn">
              <img src="{{ asset($coachAsset.'/coach-hero-nav-settings-icon.webp') }}" alt="Settings icon for AI sales coaching workspace" title="Settings icon for AI sales coaching workspace" width="18" height="18" loading="eager" decoding="async">
            </span>
          </aside>

          <div class="coach-hero__main">
            <p class="coach-hero__title">Coach Dashboard</p>

            <div class="coach-hero__layout">
              <div class="coach-hero__center">
                <article class="coach-hero__card coach-hero__card--1 coach-hero__live">
                  <header class="coach-hero__card-head">
                    <h3 class="coach-hero__card-title">Live Call Coaching</h3>
                    <span class="coach-hero__live-pill"><span class="coach-hero__live-dot" aria-hidden="true"></span> LIVE</span>
                  </header>
                  <div class="coach-hero__live-body">
                    <span class="coach-hero__mic">
                      <img src="{{ asset($coachAsset.'/coach-hero-mic-icon.webp') }}" alt="Microphone icon for live AI sales call coaching" title="Microphone icon for live AI sales call coaching" width="22" height="22" loading="eager" decoding="async">
                    </span>
                    <div class="coach-hero__wave" aria-hidden="true">
                      @foreach ($coachWave as $i => $height)
                        <span class="coach-hero__bar" style="--h: {{ $height }}; --d: {{ 0.04 * ($i % 9) }}s; --dur: {{ 0.62 + ($i % 6) * 0.11 }}s;"></span>
                      @endforeach
                    </div>
                  </div>
                  <p class="coach-hero__tip">Try asking an open-ended question to uncover more customer needs.</p>
                </article>

                <div class="coach-hero__center-bottom">
                  <article class="coach-hero__card coach-hero__card--3 coach-hero__roleplay">
                    <span class="coach-hero__roleplay-icon">
                      <img src="{{ asset($coachAsset.'/coach-hero-roleplay-icon.png') }}" alt="Practice roleplay icon for AI sales coaching software" title="Practice roleplay icon for AI sales coaching software" width="28" height="28" loading="eager" decoding="async">
                    </span>
                    <p class="coach-hero__roleplay-title">Discovery Call - SaaS Demo</p>
                    <p class="coach-hero__roleplay-copy">Objective: Qualify need &amp; uncover pain</p>
                    <span class="coach-hero__practice-btn">Start Practice</span>
                  </article>

                  <article class="coach-hero__card coach-hero__card--4 coach-hero__recent">
                    <header class="coach-hero__card-head">
                      <h3 class="coach-hero__card-title">Recent Scores</h3>
                    </header>
                    <ul class="coach-hero__scores">
                      <li class="coach-hero__score-row coach-hero__score-row--1"><span>Sarah J.</span><strong class="coach-hero__score-val coach-hero__score-val--teal" data-coach-count="92" data-coach-count-fast>92</strong></li>
                      <li class="coach-hero__score-row coach-hero__score-row--2"><span>Mike R.</span><strong class="coach-hero__score-val coach-hero__score-val--yellow" data-coach-count="78" data-coach-count-fast>78</strong></li>
                      <li class="coach-hero__score-row coach-hero__score-row--3"><span>James L.</span><strong class="coach-hero__score-val coach-hero__score-val--orange" data-coach-count="71" data-coach-count-fast>71</strong></li>
                      <li class="coach-hero__score-row coach-hero__score-row--4"><span>Sarah J.</span><strong class="coach-hero__score-val coach-hero__score-val--teal" data-coach-count="92" data-coach-count-fast>92</strong></li>
                    </ul>
                    <span class="coach-hero__view-all">View All</span>
                  </article>
                </div>
              </div>

              <div class="coach-hero__aside">
                <article class="coach-hero__card coach-hero__card--2 coach-hero__avg">
                  <header class="coach-hero__card-head">
                    <h3 class="coach-hero__card-title">Team Average Score</h3>
                    <span class="coach-hero__growth">↗ 12%</span>
                  </header>
                  <p class="coach-hero__avg-value"><span data-coach-count="84">84</span> <span class="coach-hero__avg-denom">/ 100</span></p>
                </article>

                <article class="coach-hero__card coach-hero__card--5 coach-hero__overview">
                  <h3 class="coach-hero__card-title">Performance Overview</h3>
                  <div class="coach-hero__donut-wrap">
                    <svg class="coach-hero__donut" viewBox="0 0 120 120" aria-hidden="true">
                      <defs>
                        <linearGradient id="coachHeroDonutGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                          <stop offset="0%" stop-color="#7c5cfc"/>
                          <stop offset="100%" stop-color="#22d3ee"/>
                        </linearGradient>
                      </defs>
                      <circle class="coach-hero__donut-track" cx="60" cy="60" r="46" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="10"/>
                      <circle class="coach-hero__donut-ring" cx="60" cy="60" r="46" fill="none" stroke="url(#coachHeroDonutGrad)" stroke-width="10" stroke-linecap="round" pathLength="100" transform="rotate(-90 60 60)"/>
                    </svg>
                    <p class="coach-hero__donut-label"><span data-coach-count="84">84</span> <span>/ 100</span></p>
                  </div>
                  <ul class="coach-hero__metrics">
                    <li class="coach-hero__metric coach-hero__metric--1"><span class="coach-hero__metric-dot coach-hero__metric-dot--purple"></span><span>Talk/Listen Ratio</span><strong>72%</strong></li>
                    <li class="coach-hero__metric coach-hero__metric--2"><span class="coach-hero__metric-dot coach-hero__metric-dot--blue"></span><span>Objection Handling</span><strong>88%</strong></li>
                    <li class="coach-hero__metric coach-hero__metric--3"><span class="coach-hero__metric-dot coach-hero__metric-dot--sky"></span><span>Product Knowledge</span><strong>85%</strong></li>
                    <li class="coach-hero__metric coach-hero__metric--4"><span class="coach-hero__metric-dot coach-hero__metric-dot--cyan"></span><span>Closing Effectiveness</span><strong>79%</strong></li>
                  </ul>
                </article>

                <article class="coach-hero__card coach-hero__card--6 coach-hero__skills">
                  <h3 class="coach-hero__card-title">Top Skills to Improve</h3>
                  <ul class="coach-hero__skill-list">
                    <li>
                      <img src="{{ asset($coachAsset.'/coach-hero-skill-objections-icon.png') }}" alt="Handling objections skill icon for AI sales coaching" title="Handling objections skill icon for AI sales coaching" width="16" height="16" loading="eager" decoding="async">
                      Handling Objections
                    </li>
                    <li>
                      <img src="{{ asset($coachAsset.'/coach-hero-skill-qualifying-icon.png') }}" alt="Qualifying needs skill icon for AI sales coaching" title="Qualifying needs skill icon for AI sales coaching" width="16" height="16" loading="eager" decoding="async">
                      Qualifying Needs
                    </li>
                    <li>
                      <img src="{{ asset($coachAsset.'/coach-hero-skill-closing-icon.png') }}" alt="Closing effectiveness skill icon for AI sales coaching" title="Closing effectiveness skill icon for AI sales coaching" width="16" height="16" loading="eager" decoding="async">
                      Closing Effectiveness
                    </li>
                  </ul>
                </article>
              </div>
            </div>
          </div>
        </div>

        <div class="coach-hero__journey" aria-hidden="true">
          <div class="coach-hero__journey-step coach-hero__journey-step--1">
            <img src="{{ asset($coachAsset.'/coach-hero-journey-practice-icon.png') }}" alt="Practice step icon for AI sales coaching workflow" title="Practice step icon for AI sales coaching workflow" width="40" height="40" loading="eager" decoding="async">
            <span>Practice</span>
          </div>
          <span class="coach-hero__chevron">
            <svg viewBox="0 0 8 12" fill="none" aria-hidden="true"><path d="M2 1.5 6.5 6 2 10.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
          <div class="coach-hero__journey-step coach-hero__journey-step--2">
            <img src="{{ asset($coachAsset.'/coach-hero-journey-guidance-icon.png') }}" alt="Real-time guidance icon for AI sales call coaching" title="Real-time guidance icon for AI sales call coaching" width="40" height="40" loading="eager" decoding="async">
            <span>Get Real-Time Guidance</span>
          </div>
          <span class="coach-hero__chevron">
            <svg viewBox="0 0 8 12" fill="none" aria-hidden="true"><path d="M2 1.5 6.5 6 2 10.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
          <div class="coach-hero__journey-step coach-hero__journey-step--3">
            <img src="{{ asset($coachAsset.'/coach-hero-journey-improve-icon.png') }}" alt="Improve step icon for AI sales coaching workflow" title="Improve step icon for AI sales coaching workflow" width="40" height="40" loading="eager" decoding="async">
            <span>Improve</span>
          </div>
          <span class="coach-hero__chevron">
            <svg viewBox="0 0 8 12" fill="none" aria-hidden="true"><path d="M2 1.5 6.5 6 2 10.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
          <div class="coach-hero__journey-step coach-hero__journey-step--4">
            <img src="{{ asset($coachAsset.'/coach-hero-journey-deals-icon.png') }}" alt="Win more deals icon for AI sales coaching results" title="Win more deals icon for AI sales coaching results" width="40" height="40" loading="eager" decoding="async">
            <span>Win More Deals</span>
          </div>
        </div>
      </figure>
      <script>
        (function () {
          var el = document.querySelector('[data-coach-hero]');
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
            <p class="case-study-metrics__value">~55%</p>
            <h3 class="case-study-metrics__label">Faster path from hire to confident customer calls</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~60%</p>
            <h3 class="case-study-metrics__label">Less manager time spent reviewing recordings for feedback</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~50%</p>
            <h3 class="case-study-metrics__label">Improvement in call quality consistency as the team expands</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~45%</p>
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

@push('scripts')
<script>
  (function () {
    var root = document.querySelector('[data-coach-hero]');
    if (!root) return;

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) return;

    var counts = root.querySelectorAll('[data-coach-count]');
    var countFrames = [];
    var timers = [];
    var started = false;

    function later(fn, delay) {
      timers.push(window.setTimeout(fn, delay));
    }

    function countUp(el, duration) {
      var end = parseInt(el.getAttribute('data-coach-count'), 10) || 0;
      var start = null;
      el.textContent = '0';

      function step(ts) {
        if (!start) start = ts;
        var progress = Math.min((ts - start) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = String(Math.round(end * eased));
        if (progress < 1) countFrames.push(requestAnimationFrame(step));
      }

      countFrames.push(requestAnimationFrame(step));
    }

    function play() {
      if (started) return;
      started = true;

      countFrames.forEach(function (id) { cancelAnimationFrame(id); });
      countFrames = [];
      timers.forEach(clearTimeout);
      timers = [];

      root.classList.remove('is-playing', 'is-idle');
      void root.offsetWidth;
      root.classList.add('is-playing');

      counts.forEach(function (el) {
        var fast = el.hasAttribute('data-coach-count-fast');
        later(function () { countUp(el, fast ? 420 : 700); }, fast ? 420 : 280);
      });

      later(function () {
        root.classList.add('is-idle');
      }, 2800);
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
      }, { threshold: 0.2 });

      observer.observe(root);
      later(function () {
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
