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
        <span aria-current="page">Appointment Insurance That Makes Showing Up the Default</span>
      </nav>

      <p class="case-studies-hero__eyebrow pragati-narrow-regular">Appointment Scheduling / Fintech</p>
      <h1 id="case-study-detail-heading" class="case-study-detail-hero__title">Appointment Insurance That Makes Showing Up the Default</h1>
      <p class="case-study-detail-hero__lead">An appointment insurance platform that protects calendars with clear deposits, text invites, arrival check-in, and smart Stripe refunds — so unused deposit money comes back without wasting card fees, and no-shows pay the person who waited.</p>

      <div class="case-study-detail-hero__meta">
        <span><strong>Year</strong> 2025</span>
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
          src="{{ asset('assets/case-studies/shownoshow/show_no _show banner.webp') }}"
          alt="Appointment Insurance That Makes Showing Up the Default"
          title="Appointment Insurance That Makes Showing Up the Default"
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
            <p class="case-study-metrics__value">~$261</p>
            <h3 class="case-study-metrics__label">Card fees saved on a $10k example by returning unused money the smart way</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~90%</p>
            <h3 class="case-study-metrics__label">Less card-fee waste on unused deposit money that comes back</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~70%</p>
            <h3 class="case-study-metrics__label">Less manual chasing for confirmations, deposits, and “are you coming?”</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~65%</p>
            <h3 class="case-study-metrics__label">Improvement in recovering value from no-shows instead of treating them as pure loss</h3>
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
          <p>Missed appointments meant lost revenue — and refunding a full deposit later still burned card fees on money that came back. Organizers chased confirmations by hand, had no reliable way to prove who showed up, and settled payouts case by case. Settlement needed to return unused amounts the smart way, pause when arrival is contested, allow organizers to waive charges, and stay fair when nobody shows.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2.2 2.2L16 9.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
          </div>
          <h3>Solution</h3>
          <p>We built an appointment insurance platform: schedule with clear deposits, invite by text, check in at the place, and settle through Stripe so unused deposit money comes back without wasting card fees — then pay the person who showed when someone ghosts.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 16l5-5 3.5 3.5L20 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 7h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3>Outcome</h3>
          <p>Organizers protect calendars with clear commitment rules and far less manual chasing. Showing up returns unused deposit money without taxing the full amount; no-shows fund who waited instead of becoming pure loss. On a simple $10,000 example where $9,000 returns, card fees stay near ~$29 instead of ~$290 — about $261 saved versus charging everything then refunding.</p>
        </article>
    </div>
  </div>
</section>

<section id="section-1" class="full-bleed case-study-split case-study-split--right bg-white" aria-labelledby="section-1-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
          <p class="case-study-story__eyebrow">Smart refunds</p>
          <h2 id="section-1-title">Return unused deposit money — without wasting card fees.</h2>
          <p>The main money move isn’t “charge the whole deposit.” When only part was earned, Stripe returns the unused amount so card fees apply to what stayed charged. Simple example on a $10,000 deposit where $9,000 comes back (typical 2.9% + $0.30 fees): charge-everything-then-refund costs ~$290; keeping $1,000 charged costs ~$29 — about $261 saved.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Return unused deposit money instead of charging everything first</li>
              <li><span>2</span>$10,000 example: about $261 in card fees saved</li>
              <li><span>3</span>Show up → money returns · no-show → pay who waited</li>
          </ol>
    </div>
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/shownoshow/show_no-show right.webp') }}"
            alt="Return unused deposit money — without wasting card fees. product screenshot for Suave Creators software development"
            title="Return unused deposit money — without wasting card fees. product screenshot for Suave Creators software development"
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
          <p class="case-study-story__eyebrow">Commitment</p>
          <h2 id="section-2-title">Clear deposits, proven arrival, fair no-show payouts.</h2>
          <p>Organizers lock the commitment with a clear deposit and rules everyone can understand. Texts replace manual chasing. Check-in proves who made it. If someone no-shows, the pot goes to the party who kept the promise — instead of writing off the hour as bad luck.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Clear deposit rules for one-on-one and group meetings</li>
              <li><span>2</span>Text invites and reminders without hand-chasing every guest</li>
              <li><span>3</span>Check-in + fair payout when someone doesn’t show</li>
          </ol>
    </div>
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/shownoshow/show_no_show left.webp') }}"
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
