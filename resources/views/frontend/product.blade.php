@extends('layouts.frontend')

@section('content')


<div class="product-page">

  <!-- 0. Social Rail Start -->
  <aside class="product-social" aria-label="Social links">
    @foreach ($socialLinks as $link)
      <a
        href="{{ $link['href'] }}"
        @if ($link['external'])target="_blank" rel="noopener noreferrer"@endif
        aria-label="{{ $link['label'] }}"
      >
        <i class="{{ $link['icon'] }}" aria-hidden="true"></i>
      </a>
    @endforeach
  </aside>
  <!-- 0. Social Rail End -->

  <!-- 1. Hero Start -->
  <section class="product-hero" id="hero">
    <div class="product-hero__illustration" aria-hidden="true">
      <img src="{{ asset('assets/product/hero-team-illustration.png') }}" alt="Hero Team Illustration for Suave Creators software development" title="Hero Team Illustration for Suave Creators software development">
    </div>

    <div class="container product-hero__container">
      <div class="product-hero__content">
        <h1 class="product-hero__title">
          <span class="product-hero__title-line">Run your entire</span>
          <span class="product-hero__title-line">
            organization with
            <span class="product-hero__title-accent-inline">AI AT THE</span>
          </span>
          <span class="product-hero__title-line">
            <span class="product-hero__title-accent-inline">CORE</span>
          </span>
        </h1>

        <p class="product-hero__subtitle">
          <span class="product-hero__subtitle-line">
            Suave CRM unifies people, projects, finance, communication, and growth into one
            secure platform, with an
          </span>
          <span class="product-hero__subtitle-line">
            intelligent assistant built into every module, so your team moves faster, together.
          </span>
        </p>

        <div class="product-hero__actions">
          <a href="{{ $contactHref }}" class="product-btn product-demo-btn">
            Book a 3-week free demo <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
          <a href="#modules" class="product-btn product-btn--secondary">See It In Action</a>
        </div>
      </div>

      <div class="product-stats">
        @foreach ($stats as $stat)
          <div class="product-stat">
            <img src="{{ $stat['icon'] }}" alt="{{ $stat['alt'] }}" title="{{ $stat['alt'] }}" class="product-stat__icon">
            <div class="product-stat__value">{{ $stat['value'] }}</div>
            <div class="product-stat__label">{{ $stat['label'] }}</div>
          </div>
        @endforeach
      </div>

      <div class="product-hero__laptop">
        <img src="{{ asset('assets/product/hero-illustration.jpg') }}" alt="Suave CRM dashboard preview" title="Suave CRM dashboard preview">
      </div>
    </div>
  </section>
  <!-- 1. Hero End -->

  <!-- 2. Why Suave CRM Start -->
  <section class="product-section product-features-section" id="features">
    <div class="container">
      <div class="product-section__header">
        <div class="product-features-section__eyebrow">
          <span class="product-features-section__eyebrow-bar" aria-hidden="true"></span>
          <span class="product-eyebrow">Why Suave CRM</span>
        </div>
        <h2 class="product-section__title">Built different, by design</h2>
      </div>

      <div class="product-features product-features--why">
        @foreach ($features as $feature)
          <div class="product-feature-card">
            <div class="product-feature-card__icon">
              <img src="{{ $feature['icon'] }}" alt="{{ $feature['alt'] }}" title="{{ $feature['alt'] }}">
            </div>
            <h3>{{ $feature['title'] }}</h3>
            <p>{{ $feature['description'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- 2. Why Suave CRM End -->

  <!-- 3. Workspace Start -->
  <section class="product-workspace" id="workspace">
    <div class="container product-workspace__grid">
      <div class="product-workspace__content">
        <span class="product-eyebrow">All-In-One Workspace</span>
        <h2 class="product-section__title product-section__title--left product-workspace__title">
          Replace 8 tools with one unified platform
        </h2>
        <p class="product-workspace__desc">
          Stop juggling Trello, Slack, Google Sheets, FreshBooks, and four other apps.
          SuaveCRM brings everything into one place so your team has a single source of truth.
        </p>
        <ul class="product-bullets">
          @foreach ($workspaceBullets as $item)
            <li>{{ $item }}</li>
          @endforeach
        </ul>
      </div>
      <div class="product-workspace__image">
        <img src="{{ asset('assets/product/workspace-team-photo.jpg') }}" alt="Team collaborating in modern office for Suave CRM workspace" title="Team collaborating in modern office for Suave CRM workspace">
      </div>
    </div>
  </section>
  <!-- 3. Workspace End -->

  <!-- 4. Modules Start -->
  <section class="product-section product-section--gray" id="modules">
    <div class="container">
      <div class="product-section__header">
        <span class="product-eyebrow">12 Powerful Modules</span>
        <h2 class="product-section__title">
          Everything your team needs,
          <span class="product-gradient-text">nothing it doesn&apos;t</span>
        </h2>
        <p class="product-section__subtitle">
          Click any module to explore what it does and how it fits into your workflow.
        </p>
      </div>

      <div class="product-modules">
        <nav class="product-modules__sidebar" aria-label="Module navigation">
          @foreach ($modules as $index => $mod)
            <button
              type="button"
              class="product-modules__tab{{ $index === 0 ? ' is-active' : '' }}"
              data-module-id="{{ $mod['id'] }}"
              data-name="{{ $mod['name'] }}"
              data-icon="{{ $mod['icon'] }}"
              data-badge="{{ $mod['badge'] }}"
              data-image="{{ $mod['image'] }}"
              data-description="{{ $mod['description'] }}"
              data-highlights="{{ json_encode($mod['highlights'], JSON_UNESCAPED_UNICODE) }}"
            >
              <span class="product-modules__tab-icon" aria-hidden="true">
                <img src="{{ $mod['icon'] }}" alt="{{ $mod['alt'] }}" title="{{ $mod['alt'] }}">
              </span>
              <span class="product-modules__tab-label">{{ $mod['name'] }}</span>
            </button>
          @endforeach
        </nav>

        <div class="product-modules__panel" id="product-modules-panel">
          <div class="product-modules__image-wrap">
            <img
              id="product-module-image"
              src="{{ $firstModule['image'] }}"
              alt="{{ $firstModule['name'] }}" title="{{ $firstModule['name'] }}"
            >
            <div class="product-modules__badge" id="product-module-badge">
              <i class="fa-solid fa-play" aria-hidden="true"></i>
              <span id="product-module-badge-text">{{ $firstModule['badge'] }}</span>
            </div>
          </div>
          <div class="product-modules__info">
            <div class="product-modules__title-row">
              <div class="product-feature-card__icon">
                <img id="product-module-icon" src="{{ $firstModule['icon'] }}" alt="{{ $firstModule['alt'] }}" title="{{ $firstModule['alt'] }}">
              </div>
              <h3 id="product-module-title">{{ $firstModule['name'] }}</h3>
            </div>
            <p id="product-module-description">{{ $firstModule['description'] }}</p>
            <div class="product-modules__highlights" id="product-module-highlights">
              @foreach ($firstModule['highlights'] as $item)
                <div class="product-modules__highlight">
                  <span class="product-dot"></span>
                  {{ $item }}
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- 4. Modules End -->

  <!-- 5. Pricing Start -->
  <section class="product-section product-pricing-section" id="pricing">
    <div class="container">
      <div class="product-section__header product-pricing-section__header">
        <div class="product-pricing-section__eyebrow">
          <span class="product-pricing-section__eyebrow-bar" aria-hidden="true"></span>
          <span class="product-eyebrow">Pricing</span>
        </div>
        <h2 class="product-section__title">Simple, transparent pricing</h2>
      </div>

      <div class="product-pricing">
        @foreach ($pricingPlans as $plan)
          <div class="product-pricing-card{{ !empty($plan['featured']) ? ' is-featured' : '' }}">
            @if (!empty($plan['featured']))
              <div class="product-pricing-card__badge">Most Popular</div>
            @endif
            <h3>{{ $plan['name'] }}</h3>
            <p class="product-pricing-card__desc">{{ $plan['description'] }}</p>
            <div class="product-pricing-card__price">
              @if (!empty($plan['custom']))
                <span class="product-pricing-card__amount">Custom pricing</span>
              @else
                <span class="product-pricing-card__amount">Free</span>
              @endif
            </div>
            <ul class="product-pricing-card__features">
              @foreach ($plan['features'] as $feature)
                <li>
                  <i class="fa-solid fa-check" aria-hidden="true"></i>
                  {{ $feature }}
                </li>
              @endforeach
            </ul>
            <a
              href="{{ $contactHref }}"
              class="product-btn {{ !empty($plan['featured']) ? 'product-btn--gradient' : 'product-btn--outline' }}"
            >
              {{ $plan['cta'] }}
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- 5. Pricing End -->

  <!-- 6. Productivity Start -->
  <section class="product-productivity">
    <div class="container">
      <div class="product-productivity__header">
        <span class="product-eyebrow product-eyebrow--light">Productivity</span>
        <h2 class="product-section__title product-section__title--left product-section__title--light">
          Unmatched productivity
        </h2>
        <p class="product-productivity__desc">
          Suave Creators is a process, project, time, and knowledge management platform that provides amazing collaboration opportunities for developers and product teams alike.
        </p>
      </div>

      <div class="product-productivity__grid">
        <img
          src="{{ asset('assets/product/product-animation-7439febd.gif') }}"
          alt="Team collaboration overview for Suave CRM productivity" title="Team collaboration overview for Suave CRM productivity"
          class="product-productivity__shot product-productivity__shot--config"
        >
        <img
          src="{{ asset('assets/product/productivity-3.gif') }}"
          alt="Dashboard overview for Suave CRM productivity platform" title="Dashboard overview for Suave CRM productivity platform"
          class="product-productivity__shot product-productivity__shot--dashboard"
        >
        <img
          src="{{ asset('assets/product/productivity-2.gif') }}"
          alt="Attendance dashboard overview for Suave CRM" title="Attendance dashboard overview for Suave CRM"
          class="product-productivity__shot product-productivity__shot--projects"
        >
        <img
          src="{{ asset('assets/product/product-animation-ae57327c.gif') }}"
          alt="Invoice document view for Suave CRM billing module" title="Invoice document view for Suave CRM billing module"
          class="product-productivity__shot product-productivity__shot--invoice"
        >
      </div>

      <div class="product-dark-features">
        @foreach ($productivityFeatures as $feature)
          <div class="product-dark-feature">
            <div class="product-dark-feature__icon">
              <img src="{{ $feature['icon'] }}" alt="{{ $feature['alt'] }}" title="{{ $feature['alt'] }}">
            </div>
            <h3>{{ $feature['title'] }}</h3>
            <p>{{ $feature['description'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- 6. Productivity End -->

  <!-- 7. Principles Start -->
  <section class="product-section product-principles" id="principles">
    <div class="container">
      <div class="product-section__header">
        <span class="product-eyebrow">What We Value</span>
        <h2 class="product-section__title">Principles that guide us</h2>
      </div>

      <div class="product-principles__grid">
        @foreach ($principles as $item)
          <div class="product-principles__card">
            <div class="product-principles__icon">
              <img src="{{ $item['icon'] }}" alt="{{ $item['alt'] }}" title="{{ $item['alt'] }}">
            </div>
            <h3>{{ $item['title'] }}</h3>
            <p>{{ $item['description'] }}</p>
          </div>
        @endforeach
      </div>

      <div class="product-section__cta">
        <a href="{{ $contactHref }}" class="product-btn product-demo-btn">
          Book a 3-week free demo <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </section>
  <!-- 7. Principles End -->

  <!-- 8. Partner Expertise Start -->
  <section class="product-section product-section--gray">
    <div class="container">
      <div class="product-section__header">
        <span class="product-eyebrow">Learn How Teams Scale Globally</span>
        <h2 class="product-section__title">A true partner with deep domain expertise</h2>
        <p class="product-section__subtitle">
          We partner with you to set up and scale industry-leading customer experiences, with
          deep domain expertise, thought leadership, and education to give your team an edge
        </p>
      </div>

      <div class="product-partner-cards">
        @foreach ($partnerCards as $card)
          <div class="product-partner-card">
            <img src="{{ $card['image'] }}" alt="{{ $card['alt'] }}" title="{{ $card['alt'] }}">
            <h3>{{ $card['title'] }}</h3>
            <p>{{ $card['description'] }}</p>
            <a href="{{ $card['href'] }}" class="product-partner-card__link">Learn more<span class="sr-only"> about {{ $card['title'] }}</span></a>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- 8. Partner Expertise End -->

  <!-- 9. Final CTA Start -->
  <section class="product-cta">
    <div class="container">
      <div class="product-cta__card">
        <div class="product-cta__decor product-cta__decor--left" aria-hidden="true">
          <img src="{{ asset('assets/product/cta-pulse.gif') }}" alt="Decorative pulse animation for Suave CRM call to action" title="Decorative pulse animation for Suave CRM call to action" class="product-cta__pulse">
        </div>
        <div class="product-cta__decor product-cta__decor--right" aria-hidden="true">
          <img src="{{ asset('assets/product/cta-pulse.gif') }}" alt="Decorative pulse animation for Suave CRM call to action" title="Decorative pulse animation for Suave CRM call to action" class="product-cta__pulse">
        </div>

        <div class="product-cta__content">
          <span class="product-cta__eyebrow">GET STARTED TODAY</span>
          <h2>Ready to streamline your team?</h2>
          <p>
            Start your 14-day free trial. No credit card required. All 12 modules included from day one.
          </p>
          <div class="product-cta__actions">
            <a href="{{ $contactHref }}" class="product-cta__btn product-cta__btn--primary">Start Free Trial</a>
            <a href="{{ $contactHref }}" class="product-cta__btn product-cta__btn--ghost">Talk to Sales</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- 9. Final CTA End -->

</div>


@endsection
@push('scripts')
<script>
(function () {
  var tabs = document.querySelectorAll('.product-modules__tab');
  if (!tabs.length) return;

  var panelImage = document.getElementById('product-module-image');
  var panelIcon = document.getElementById('product-module-icon');
  var panelTitle = document.getElementById('product-module-title');
  var panelDescription = document.getElementById('product-module-description');
  var panelBadgeText = document.getElementById('product-module-badge-text');
  var panelHighlights = document.getElementById('product-module-highlights');

  function activateTab(tab) {
    tabs.forEach(function (t) {
      t.classList.remove('is-active');
    });
    tab.classList.add('is-active');

    var name = tab.getAttribute('data-name') || '';
    var icon = tab.getAttribute('data-icon') || '';
    var badge = tab.getAttribute('data-badge') || '';
    var image = tab.getAttribute('data-image') || '';
    var description = tab.getAttribute('data-description') || '';
    var highlightsRaw = tab.getAttribute('data-highlights') || '[]';
    var highlights = [];

    try {
      highlights = JSON.parse(highlightsRaw);
    } catch (e) {
      highlights = [];
    }

    if (panelImage) {
      panelImage.src = image;
      panelImage.alt = name + ' screenshot for Suave CRM software platform';
      panelImage.title = name + ' screenshot for Suave CRM software platform';
    }
    if (panelIcon) {
      panelIcon.src = icon;
      panelIcon.alt = name + ' module icon for Suave CRM software platform';
      panelIcon.title = name + ' module icon for Suave CRM software platform';
    }
    if (panelTitle) {
      panelTitle.textContent = name;
    }
    if (panelDescription) {
      panelDescription.textContent = description;
    }
    if (panelBadgeText) {
      panelBadgeText.textContent = badge;
    }
    if (panelHighlights) {
      panelHighlights.innerHTML = '';
      highlights.forEach(function (item) {
        var row = document.createElement('div');
        row.className = 'product-modules__highlight';
        var dot = document.createElement('span');
        dot.className = 'product-dot';
        row.appendChild(dot);
        row.appendChild(document.createTextNode(item));
        panelHighlights.appendChild(row);
      });
    }
  }

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      activateTab(tab);
    });
  });
})();
</script>
@endpush
