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
        <span aria-current="page">The Suave App Tasks — From a Complex Process to a Clear B2B CRM Task Management Workspace</span>
      </nav>

      <p class="case-studies-hero__eyebrow pragati-narrow-regular">B2B SaaS / Work Management</p>
      <h1 id="case-study-detail-heading" class="case-study-detail-hero__title">The Suave App Tasks — From a Complex Process to a Clear B2B CRM Task Management Workspace</h1>
      <p class="case-study-detail-hero__lead">We redesigned the suave app’s Tasks module into one B2B CRM task management workspace — Kanban and List view integration, inline create, a task drawer, and an automated task assistant AI — with about 50% less switching between views.</p>

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
        class="case-study-detail-hero__media tasks-hero"
        data-tasks-hero
        aria-label="The Suave App Tasks — from a complex process to a clear B2B CRM task management workspace with about 50% less switching"
      >
        <div class="tasks-hero__board">
          <header class="tasks-hero__header">
            <p class="tasks-hero__logo">Suave.App</p>
            <div class="tasks-hero__stats">
              <article class="tasks-hero__stat">
                <span class="tasks-hero__stat-icon tasks-hero__stat-icon--blue" aria-hidden="true"></span>
                <div>
                  <p class="tasks-hero__stat-label">Total Threats</p>
                  <p class="tasks-hero__stat-value">2,845</p>
                  <p class="tasks-hero__stat-trend tasks-hero__stat-trend--up">▲ 8.4% vs Q2 2025</p>
                </div>
              </article>
              <article class="tasks-hero__stat">
                <span class="tasks-hero__stat-icon tasks-hero__stat-icon--red" aria-hidden="true"></span>
                <div>
                  <p class="tasks-hero__stat-label">Critical Incidents</p>
                  <p class="tasks-hero__stat-value">142</p>
                  <p class="tasks-hero__stat-trend tasks-hero__stat-trend--down">▼ 12.1% vs Q2 2025</p>
                </div>
              </article>
              <article class="tasks-hero__stat">
                <span class="tasks-hero__stat-icon tasks-hero__stat-icon--green" aria-hidden="true"></span>
                <div>
                  <p class="tasks-hero__stat-label">Avg MTTR (Mins)</p>
                  <p class="tasks-hero__stat-value">18.4m</p>
                  <p class="tasks-hero__stat-trend tasks-hero__stat-trend--down">▼ 4.2m vs Q2 2025</p>
                </div>
              </article>
              <article class="tasks-hero__stat">
                <span class="tasks-hero__stat-icon tasks-hero__stat-icon--orange" aria-hidden="true"></span>
                <div>
                  <p class="tasks-hero__stat-label">Phishing Blocked</p>
                  <p class="tasks-hero__stat-value">98.6%</p>
                  <p class="tasks-hero__stat-trend tasks-hero__stat-trend--up">▲ 1.2% vs Q2 2025</p>
                </div>
              </article>
              <article class="tasks-hero__stat tasks-hero__stat--offset">
                <span class="tasks-hero__stat-icon tasks-hero__stat-icon--blue" aria-hidden="true"></span>
                <div>
                  <p class="tasks-hero__stat-label">Loss Prevented</p>
                  <p class="tasks-hero__stat-value">$6.4M</p>
                  <p class="tasks-hero__stat-trend tasks-hero__stat-trend--up">▲ 91.1% vs Q2 2025</p>
                </div>
              </article>
            </div>
            <p class="tasks-hero__title">The Suave App: B2B CRM Task Redesign</p>
          </header>

          <div class="tasks-hero__story">
            <div class="tasks-hero__col tasks-hero__col--before">
              <p class="tasks-hero__col-label">Before: Complex Process</p>
              <div class="tasks-hero__panel tasks-hero__panel--before">
                <span class="tasks-hero__dot tasks-hero__dot--before" aria-hidden="true"></span>
                <div class="tasks-hero__before-grid">
                  <span class="tasks-hero__before-item tasks-hero__before-item--1">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-hero-checklist-icon.webp') }}"
                      alt="Checklist icon for the previous Suave CRM task workflow"
                      title="Checklist icon for the previous Suave CRM task workflow"
                      width="48"
                      height="48"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                  <span class="tasks-hero__before-item tasks-hero__before-item--2">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-hero-grid-icon.webp') }}"
                      alt="Grid icon for fragmented Suave CRM task boards"
                      title="Grid icon for fragmented Suave CRM task boards"
                      width="48"
                      height="48"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                  <span class="tasks-hero__before-item tasks-hero__before-item--3">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-hero-calendar-icon.webp') }}"
                      alt="Calendar icon for disconnected Suave CRM scheduling"
                      title="Calendar icon for disconnected Suave CRM scheduling"
                      width="48"
                      height="48"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                  <span class="tasks-hero__before-item tasks-hero__before-item--4">
                    <img
                      src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-hero-spreadsheet-icon.webp') }}"
                      alt="Spreadsheet icon for scattered Suave CRM task tracking"
                      title="Spreadsheet icon for scattered Suave CRM task tracking"
                      width="48"
                      height="48"
                      loading="eager"
                      decoding="async"
                    >
                  </span>
                </div>
                <span class="tasks-hero__nub" aria-hidden="true">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M13 6l6 6-6 6"/>
                  </svg>
                </span>
              </div>
            </div>

            <span class="tasks-hero__arrow tasks-hero__arrow--left" aria-hidden="true">
              <svg viewBox="0 0 24 12" fill="none">
                <path d="M1 6h20M16 1.5 22 6l-6 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>

            <div class="tasks-hero__center">
              <div class="tasks-hero__center-float">
                <div class="tasks-hero__center-frame">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-hero-center.webp') }}"
                    alt="Suave CRM task workspace on a phone during the B2B task redesign"
                    title="Suave CRM task workspace on a phone during the B2B task redesign"
                    width="360"
                    height="420"
                    loading="eager"
                    decoding="async"
                  >
                </div>
              </div>
            </div>

            <span class="tasks-hero__arrow tasks-hero__arrow--right" aria-hidden="true">
              <svg viewBox="0 0 24 12" fill="none">
                <path d="M1 6h20M16 1.5 22 6l-6 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>

            <div class="tasks-hero__col tasks-hero__col--after">
              <p class="tasks-hero__col-label">After: Clear Workspace</p>
              <div class="tasks-hero__panel tasks-hero__panel--after">
                <span class="tasks-hero__dot tasks-hero__dot--after" aria-hidden="true"></span>
                <ol class="tasks-hero__tasks">
                  <li class="tasks-hero__task tasks-hero__task--1"><span>1.</span> Follow up</li>
                  <li class="tasks-hero__task tasks-hero__task--2"><span>2.</span> Proposal</li>
                  <li class="tasks-hero__task tasks-hero__task--3"><span>3.</span> Prepare Proposal</li>
                  <li class="tasks-hero__task tasks-hero__task--4"><span>4.</span> Requirement rev....</li>
                  <li class="tasks-hero__task tasks-hero__task--5"><span>5.</span> NDA signed</li>
                </ol>
              </div>
            </div>
          </div>

          <div class="tasks-hero__features">
            <svg class="tasks-hero__connectors" viewBox="0 0 400 52" preserveAspectRatio="none" aria-hidden="true">
              <path class="tasks-hero__connector-path tasks-hero__connector-path--left" pathLength="1" d="M200 2 L200 18 L40 18 L40 50"/>
              <path class="tasks-hero__connector-path tasks-hero__connector-path--mid-left" pathLength="1" d="M200 18 L145 18 L145 50"/>
              <path class="tasks-hero__connector-path tasks-hero__connector-path--mid-right" pathLength="1" d="M200 18 L255 18 L255 50"/>
              <path class="tasks-hero__connector-path tasks-hero__connector-path--right" pathLength="1" d="M200 2 L200 18 L360 18 L360 50"/>
              <path class="tasks-hero__connector-glow" pathLength="1" d="M40 18 H360"/>
            </svg>
            <p class="tasks-hero__features-label">Key features (Integrated)</p>
            <div class="tasks-hero__feature-row">
              <article class="tasks-hero__feature tasks-hero__feature--1">
                <span class="tasks-hero__feature-icon">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-hero-inline-create-icon.webp') }}"
                    alt="Inline create icon for Suave CRM task management"
                    title="Inline create icon for Suave CRM task management"
                    width="48"
                    height="48"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                <p class="tasks-hero__feature-title">+Inline Create</p>
                <p class="tasks-hero__feature-copy">Create tasks in context, instantly.</p>
              </article>
              <article class="tasks-hero__feature tasks-hero__feature--2">
                <span class="tasks-hero__feature-icon">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-hero-task-drawer-icon.webp') }}"
                    alt="Task drawer icon for Suave CRM collaboration details"
                    title="Task drawer icon for Suave CRM collaboration details"
                    width="48"
                    height="48"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                <p class="tasks-hero__feature-title">Task Drawer</p>
                <p class="tasks-hero__feature-copy">Details &amp; collaboration within reach.</p>
              </article>
              <article class="tasks-hero__feature tasks-hero__feature--3">
                <span class="tasks-hero__feature-icon">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-hero-ai-assistant-icon.webp') }}"
                    alt="AI task assistant icon for Suave CRM project management"
                    title="AI task assistant icon for Suave CRM project management"
                    width="48"
                    height="48"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                <p class="tasks-hero__feature-title">AI Task Assistant</p>
                <p class="tasks-hero__feature-copy">Prioritizes and optimizes, integrated.</p>
              </article>
              <article class="tasks-hero__feature tasks-hero__feature--4">
                <span class="tasks-hero__feature-icon">
                  <img
                    src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-hero-fewer-switches-icon.webp') }}"
                    alt="Fewer switches icon for streamlined Suave CRM task work"
                    title="Fewer switches icon for streamlined Suave CRM task work"
                    width="48"
                    height="48"
                    loading="eager"
                    decoding="async"
                  >
                </span>
                <p class="tasks-hero__feature-title">50% Fewer Switches</p>
                <p class="tasks-hero__feature-copy">Streamlined work, more focus.</p>
              </article>
            </div>
          </div>
        </div>
      </figure>
      <script>
        (function () {
          var el = document.querySelector('[data-tasks-hero]');
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
            <p class="case-study-metrics__value">~50%</p>
            <h3 class="case-study-metrics__label">Less switching between separate Kanban and List views</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">~45%</p>
            <h3 class="case-study-metrics__label">Faster answers to overdue and assigned task questions</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">1</p>
            <h3 class="case-study-metrics__label">Connected B2B CRM task management workspace from search to drawer</h3>
          </div>
          <div class="case-study-metrics__box">
            <p class="case-study-metrics__value">4</p>
            <h3 class="case-study-metrics__label">Focused drawer areas — Overview, Comments, Log Time, Attachments</h3>
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
          <p>The original Tasks module in the suave app spread B2B CRM task management work across separate list and board screens. Creating a task, changing status, logging time, and reading comments often meant opening full pages or jumping between views. Project switching relied on a dropdown instead of a searchable sidebar, and managers had to hunt filters to see overdue work or team workload.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2.2 2.2L16 9.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
          </div>
          <h3>Solution</h3>
          <p>We redesigned the suave app around one AI project management software workflow. Teams pick a project from a searchable sidebar, work the backlog with Kanban and List view integration, update priority and assignees inline, and open a side drawer for overview, comments, time logs, and attachments. Bulk create supports fast project kickoffs. An automated task assistant AI sits beside the workspace so teams can create tasks by typing, list assigned work, and check delivery analytics in plain language.</p>
        </article>
        <article>
          <div class="case-study-story__icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 16l5-5 3.5 3.5L20 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 7h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3>Outcome</h3>
          <p>Routine B2B CRM task management now takes about 50% less switching between separate views. Teams move from project search to daily progress — create, assign, track, and log time — without leaving one screen. The clearer experience in the suave app gives people more time to ship client work and shows how thoughtful product design turns a complicated delivery process into efficient AI project management software.</p>
        </article>
    </div>
  </div>
</section>

<section id="section-1" class="full-bleed case-study-split case-study-split--right bg-white" aria-labelledby="section-1-title">
  <div class="section-inner case-study-split__inner">
    <div class="case-study-split__copy">
          <p class="case-study-story__eyebrow">Kanban &amp; List</p>
          <h2 id="section-1-title">Kanban and List view integration without jumping between CRM screens.</h2>
          <p>In the suave app, teams search projects in a sidebar, then work that project’s backlog in List view or switch to Kanban to drag cards across project-specific stages. They create tasks inline, bulk-create for fast kickoffs, and open a drawer for details without losing their place in the B2B CRM task management workspace.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Search projects and stay inside one engagement at a time</li>
              <li><span>2</span>Switch Kanban and List views with the same filters and selected project</li>
              <li><span>3</span>Create tasks inline or in bulk without opening a separate page</li>
          </ol>
    </div>
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/suave-crm-tasks/the-suave-app-task-right.webp') }}"
            alt="Kanban and List view integration in the suave app CRM task workspace"
            title="Kanban and List view integration in the suave app CRM task workspace"
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
          <p class="case-study-story__eyebrow">AI Assistant</p>
          <h2 id="section-2-title">Automated task assistant AI for delivery progress and workload.</h2>
          <p>An automated task assistant AI sits beside the workspace in the suave app. Teams ask what is overdue, show assigned tasks, or check workload and status totals — then create a new task by typing a title and confirming a suggested description.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Ask “Show My Tasks” or check task analytics in plain language</li>
              <li><span>2</span>Review overdue items and workload before reassigning work</li>
              <li><span>3</span>Create tasks by typing — pick the project, approve the description, and land in the backlog</li>
          </ol>
    </div>
        <figure class="case-study-visual case-study-visual--photo">
          <img
            src="{{ asset('assets/case-studies/suave-crm-tasks/the-suave-app-task-banner-left.webp') }}"
            alt="Automated task assistant AI beside the suave app CRM workspace"
            title="Automated task assistant AI beside the suave app CRM workspace"
            width="960"
            height="720"
            loading="lazy"
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
    var root = document.querySelector('[data-tasks-hero]');
    if (!root) return;

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) return;

    var idleTimer = 0;

    function play() {
      if (idleTimer) clearTimeout(idleTimer);
      root.classList.remove('is-playing', 'is-idle');
      void root.offsetWidth;
      root.classList.add('is-playing');
      idleTimer = setTimeout(function () {
        root.classList.add('is-idle');
      }, 5000);
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
