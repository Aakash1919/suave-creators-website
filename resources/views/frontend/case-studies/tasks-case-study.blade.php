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

      <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-amber-300 bg-amber-50 px-3 py-1.5 text-sm font-semibold text-amber-800" role="status">
        Draft preview — only visible while logged in
      </p>
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

      <figure class="case-study-detail-hero__media">
        <img
          src="{{ asset('assets/case-studies/suave-crm-tasks/tasks-list-view.png') }}"
          alt="The Suave App Tasks — From a Complex Process to a Clear B2B CRM Task Management Workspace"
          title="The Suave App Tasks — From a Complex Process to a Clear B2B CRM Task Management Workspace"
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
            <x-frontend.case-study-metric-value class="case-study-metrics__value" tag="p" value="~50%" />
            <h3 class="case-study-metrics__label">Less switching between separate Kanban and List views</h3>
          </div>
          <div class="case-study-metrics__box">
            <x-frontend.case-study-metric-value class="case-study-metrics__value" tag="p" value="~45%" />
            <h3 class="case-study-metrics__label">Faster answers to overdue and assigned task questions</h3>
          </div>
          <div class="case-study-metrics__box">
            <x-frontend.case-study-metric-value class="case-study-metrics__value" tag="p" value="1" />
            <h3 class="case-study-metrics__label">Connected B2B CRM task management workspace from search to drawer</h3>
          </div>
          <div class="case-study-metrics__box">
            <x-frontend.case-study-metric-value class="case-study-metrics__value" tag="p" value="4" />
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
          <p class="case-study-story__eyebrow">AI Assistant</p>
          <h2 id="section-2-title">Automated task assistant AI for delivery progress and workload.</h2>
          <p>An automated task assistant AI sits beside the workspace in the suave app. Teams ask what is overdue, show assigned tasks, or check workload and status totals — then create a new task by typing a title and confirming a suggested description.</p>
          <ol class="case-study-split__steps">
              <li><span>1</span>Ask “Show My Tasks” or check task analytics in plain language</li>
              <li><span>2</span>Review overdue items and workload before reassigning work</li>
              <li><span>3</span>Create tasks by typing — pick the project, approve the description, and land in the backlog</li>
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
