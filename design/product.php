<?php
$pageTitle = 'Product Suave creators | Run your entire organization with AI AT THE CORE';
$pageDescription = 'Suave CRM unifies people, projects, finance, communication, and growth into one secure AI-powered platform.';
$useHeroBackground = true; // keeps white header text readable over dark strip
$bodyClass = 'min-h-screen bg-white font-sans text-slate-900 product-site product-layout';
$extraStylesheets = ['/css/product.css'];
$mainClass = 'site-main product-layout-main';
require __DIR__.'/layout/start.php';

$h = static function ($v): string {
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
};

$contactHref = '/contact-us/#contact-id';

$stats = [
    ['icon' => '/images/product/stat-icon-modules.svg', 'value' => '12+', 'label' => 'INTEGRATED MODULES'],
    ['icon' => '/images/product/stat-icon-workspace.svg', 'value' => '01', 'label' => 'UNIFIED WORKSPACE'],
    ['icon' => '/images/product/stat-icon-shield.svg', 'value' => '100%', 'label' => 'TENANT DATA ISOLATION'],
    ['icon' => '/images/product/stat-icon-clock.svg', 'value' => '24/7', 'label' => 'ALWAYS AVAILABLE'],
];

$features = [
    [
        'icon' => '/images/product/feature-icon-lightning.svg',
        'title' => 'Lightning Fast',
        'description' => 'Sub-100ms responses across all modules. Your team never waits.',
    ],
    [
        'icon' => '/images/product/feature-icon-shield.svg',
        'title' => 'Enterprise Security',
        'description' => 'Role-based access, audit logs, and SOC2-ready infrastructure.',
    ],
    [
        'icon' => '/images/product/feature-icon-ai.svg',
        'title' => 'AI-Powered',
        'description' => 'Built-in AI assistant for report generation, summarization, and smart suggestions.',
    ],
    [
        'icon' => '/images/product/feature-icon-team.svg',
        'title' => 'Team-First Design',
        'description' => 'Designed for how creative teams actually work — async, distributed, deadline-driven.',
    ],
];

$workspaceBullets = [
    'Real-time sync across all modules.',
    'One login for your entire team.',
    'Unified notifications & activity feed.',
    'Custom roles & permission levels.',
];

$modules = [
    [
        'id' => 'project',
        'name' => 'Project Module',
        'icon' => '/images/product/Icon%20(8).png',
        'badge' => 'End-to-end project visibility',
        'image' => '/images/product/module-feature.jpg',
        'description' => 'Manage projects from kickoff to delivery. Track clients, deadlines, milestones, and team assignments in one Kanban-powered workspace.',
        'highlights' => ['Client-linked projects', 'Milestone tracking', 'Kanban & List views', 'Role-based access'],
    ],
    [
        'id' => 'task',
        'name' => 'Task Module',
        'icon' => '/images/product/Icon.png',
        'badge' => 'Stay on top of every deliverable',
        'image' => '/images/product/module-feature.jpg',
        'description' => 'Break work into actionable tasks, assign owners, set priorities, and track progress across your entire organization.',
        'highlights' => ['Priority tagging', 'Due date reminders', 'Team assignments', 'Status tracking'],
    ],
    [
        'id' => 'attendance',
        'name' => 'Attendance Module',
        'icon' => '/images/product/Icon%20(7).png',
        'badge' => 'Clock-in made effortless',
        'image' => '/images/product/workspace.jpg',
        'description' => 'Track attendance, shifts, and working hours with real-time dashboards and automated reporting for HR teams.',
        'highlights' => ['Shift management', 'Leave balance', 'Working hours', 'Attendance reports'],
    ],
    [
        'id' => 'holiday',
        'name' => 'Holiday Module',
        'icon' => '/images/product/Icon%20(6).png',
        'badge' => 'Plan time off with clarity',
        'image' => '/images/product/workspace.jpg',
        'description' => 'Manage company holidays, team calendars, and leave policies in one centralized system everyone can trust.',
        'highlights' => ['Holiday calendar', 'Leave policies', 'Team availability', 'Auto-approvals'],
    ],
    [
        'id' => 'messenger',
        'name' => 'Messenger Module',
        'icon' => '/images/product/Icon%20(2).png',
        'badge' => 'Communicate without context-switching',
        'image' => '/images/product/module-feature.jpg',
        'description' => 'Built-in team messaging tied to projects and tasks — no more jumping between Slack and your project tools.',
        'highlights' => ['Project channels', 'Direct messages', 'File sharing', 'Mention alerts'],
    ],
    [
        'id' => 'ai-chat',
        'name' => 'AI Chat Module',
        'icon' => '/images/product/Icon%20(2).png',
        'badge' => 'Your intelligent assistant',
        'image' => '/images/product/module-feature.jpg',
        'description' => 'Ask questions, generate reports, summarize meetings, and get smart suggestions — all powered by AI built into every module.',
        'highlights' => ['Report generation', 'Smart summaries', 'Data insights', 'Natural language queries'],
    ],
    [
        'id' => 'comment',
        'name' => 'Comment Module',
        'icon' => '/images/product/Icon%20(3).png',
        'badge' => 'Feedback where work happens',
        'image' => '/images/product/workspace.jpg',
        'description' => 'Threaded comments on tasks, projects, and documents keep conversations contextual and searchable.',
        'highlights' => ['Threaded replies', '@mentions', 'Activity feed', 'Searchable history'],
    ],
    [
        'id' => 'attachment',
        'name' => 'Attachment Module',
        'icon' => '/images/product/Icon%20(4).png',
        'badge' => 'Files at your fingertips',
        'image' => '/images/product/module-feature.jpg',
        'description' => 'Upload, organize, and share files directly within projects and tasks with version control and access permissions.',
        'highlights' => ['Version control', 'Access permissions', 'Preview support', 'Cloud storage'],
    ],
    [
        'id' => 'daily-work',
        'name' => 'Daily Work Record',
        'icon' => '/images/product/Icon%20(5).png',
        'badge' => 'Track daily output',
        'image' => '/images/product/workspace.jpg',
        'description' => 'Log daily work activities, track time spent on tasks, and generate productivity reports for managers.',
        'highlights' => ['Daily logs', 'Time tracking', 'Productivity reports', 'Manager dashboards'],
    ],
    [
        'id' => 'invoice',
        'name' => 'Invoice Module',
        'icon' => '/images/product/Icon%20(1).png',
        'badge' => 'Bill clients with confidence',
        'image' => '/images/product/module-feature.jpg',
        'description' => 'Create, send, and track invoices linked to projects and timesheets. Get paid faster with automated reminders.',
        'highlights' => ['Project-linked billing', 'Payment tracking', 'Auto reminders', 'PDF export'],
    ],
];

$pricingPlans = [
    [
        'name' => 'Free',
        'description' => 'Perfect for small teams getting started',
        'custom' => false,
        'features' => [
            'Up to 10 users',
            'Project & Task Modules',
            'Attendance & Holiday',
            'Basic Messenger',
            '5 GB storage',
            'Email support',
        ],
        'cta' => 'Start 3 week trial',
        'featured' => false,
    ],
    [
        'name' => 'Enterprise',
        'description' => 'Custom setup for large organizations',
        'custom' => true,
        'features' => [
            'Unlimited users',
            'All 12 Modules',
            'Dedicated AI model',
            'SSO & SAML',
            'Unlimited storage',
            '24/7 dedicated support',
            'Custom integrations',
        ],
        'cta' => 'Contact Sales',
        'featured' => false,
    ],
];

$productivityFeatures = [
    [
        'icon' => '/images/product/Icon%20(3).png',
        'title' => 'Two-way synchronization',
        'description' => 'Integrate your task tracker with GitHub to sync changes instantly.',
    ],
    [
        'icon' => '/images/product/Icon%20(4).png',
        'title' => 'Private tasks',
        'description' => 'Integration and management of multiple data repositories effectively.',
    ],
    [
        'icon' => '/images/product/Icon%20(5).png',
        'title' => 'Multiple repositories',
        'description' => 'Organize multiple projects for more effective planning and collaboration.',
    ],
    [
        'icon' => '/images/product/feature-icon-milestone.svg',
        'title' => 'Milestone migration',
        'description' => 'Seamless migration of key project milestones between repositories.',
    ],
    [
        'icon' => '/images/product/Icon%20(7).png',
        'title' => 'Track progress',
        'description' => 'Keep track of GitHub contributions and changes within your workspace.',
    ],
    [
        'icon' => '/images/product/Icon%20(8).png',
        'title' => 'Advanced filtering',
        'description' => 'Precise project data search with advanced filtering capabilities.',
    ],
];

$principles = [
    [
        'icon' => '/images/product/Icon%20(3).png',
        'title' => 'People first',
        'description' => 'Every decision starts with the teams who use the product daily - clarity over clutter, always.',
    ],
    [
        'icon' => '/images/product/Icon%20(1).png',
        'title' => 'Secure by design',
        'description' => 'Each organization runs in an isolated workspace with encryption in transit and strict access controls.',
    ],
    [
        'icon' => '/images/product/Icon%20(7).png',
        'title' => 'Fast & reliable',
        'description' => 'A modern stack tuned for speed, so your team spends time on work — not on waiting.',
    ],
    [
        'icon' => '/images/product/Icon%20(2).png',
        'title' => 'Built to evolve',
        'description' => 'We ship continuously and design every module to grow with your organization.',
    ],
];

$partnerCards = [
    [
        'image' => '/images/product/analytics-dashboard-performance-metrics.jpg',
        'title' => 'The company you can trust',
        'description' => 'Suave Creator\'s is built for security, reliability, and transparency, meeting leading compliance standards.',
        'href' => '/about-us',
    ],
    [
        'image' => '/images/product/partner-support-card.jpg',
        'title' => 'Expert support, at every stage',
        'description' => 'Suave Creator\'s Success and Services teams give you direct access to the experts behind the product.',
        'href' => '/contact-us',
    ],
    [
        'image' => '/images/product/hero-shape.png',
        'title' => 'The AI Agent Blueprint',
        'description' => 'A practical guide to launching and scaling AI in customer service, built from real-world experience and best practices.',
        'href' => '/blogs',
    ],
];

$socialLinks = [
    ['icon' => 'fa-solid fa-link', 'href' => '/contact-us', 'label' => 'Contact', 'external' => false],
    ['icon' => 'fa-brands fa-facebook-f', 'href' => 'https://www.facebook.com/share/1Zt4fotyAa/', 'label' => 'Facebook', 'external' => true],
    ['icon' => 'fa-brands fa-instagram', 'href' => 'https://www.instagram.com/suavecreators/?igsh=MWRscWJoZXJrNG10cw%3D%3D#', 'label' => 'Instagram', 'external' => true],
    ['icon' => 'fa-brands fa-linkedin-in', 'href' => 'https://www.linkedin.com/company/suave-creators/', 'label' => 'LinkedIn', 'external' => true],
];

$firstModule = $modules[0];
?>

<div class="product-page">

  <!-- 0. Social Rail Start -->
  <aside class="product-social" aria-label="Social links">
    <?php foreach ($socialLinks as $link) { ?>
      <a
        href="<?= $h($link['href']) ?>"
        <?php if ($link['external']) { ?>target="_blank" rel="noopener noreferrer"<?php } ?>
        aria-label="<?= $h($link['label']) ?>"
      >
        <i class="<?= $h($link['icon']) ?>" aria-hidden="true"></i>
      </a>
    <?php } ?>
  </aside>
  <!-- 0. Social Rail End -->

  <!-- 1. Hero Start -->
  <section class="product-hero" id="hero">
    <div class="product-hero__illustration" aria-hidden="true">
      <img src="/images/product/hero-team-illustration.png" alt="">
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
          <a href="<?= $h($contactHref) ?>" class="product-btn product-demo-btn">
            Book a 3-week free demo <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
          <a href="#modules" class="product-btn product-btn--secondary">See It In Action</a>
        </div>
      </div>

      <div class="product-stats">
        <?php foreach ($stats as $stat) { ?>
          <div class="product-stat">
            <img src="<?= $h($stat['icon']) ?>" alt="" class="product-stat__icon">
            <div class="product-stat__value"><?= $h($stat['value']) ?></div>
            <div class="product-stat__label"><?= $h($stat['label']) ?></div>
          </div>
        <?php } ?>
      </div>

      <div class="product-hero__laptop">
        <img src="/images/product/hero-illustration.jpg" alt="Suave CRM dashboard preview">
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
        <?php foreach ($features as $feature) { ?>
          <div class="product-feature-card">
            <div class="product-feature-card__icon">
              <img src="<?= $h($feature['icon']) ?>" alt="">
            </div>
            <h3><?= $h($feature['title']) ?></h3>
            <p><?= $h($feature['description']) ?></p>
          </div>
        <?php } ?>
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
          <?php foreach ($workspaceBullets as $item) { ?>
            <li><?= $h($item) ?></li>
          <?php } ?>
        </ul>
      </div>
      <div class="product-workspace__image">
        <img src="/images/product/Image%20(1).jpg" alt="Team working in modern office">
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
          <?php foreach ($modules as $index => $mod) { ?>
            <button
              type="button"
              class="product-modules__tab<?= $index === 0 ? ' is-active' : '' ?>"
              data-module-id="<?= $h($mod['id']) ?>"
              data-name="<?= $h($mod['name']) ?>"
              data-icon="<?= $h($mod['icon']) ?>"
              data-badge="<?= $h($mod['badge']) ?>"
              data-image="<?= $h($mod['image']) ?>"
              data-description="<?= $h($mod['description']) ?>"
              data-highlights="<?= $h(json_encode($mod['highlights'], JSON_UNESCAPED_UNICODE)) ?>"
            >
              <span class="product-modules__tab-icon" aria-hidden="true">
                <img src="<?= $h($mod['icon']) ?>" alt="">
              </span>
              <span class="product-modules__tab-label"><?= $h($mod['name']) ?></span>
            </button>
          <?php } ?>
        </nav>

        <div class="product-modules__panel" id="product-modules-panel">
          <div class="product-modules__image-wrap">
            <img
              id="product-module-image"
              src="<?= $h($firstModule['image']) ?>"
              alt="<?= $h($firstModule['name']) ?>"
            >
            <div class="product-modules__badge" id="product-module-badge">
              <i class="fa-solid fa-play" aria-hidden="true"></i>
              <span id="product-module-badge-text"><?= $h($firstModule['badge']) ?></span>
            </div>
          </div>
          <div class="product-modules__info">
            <div class="product-modules__title-row">
              <div class="product-feature-card__icon">
                <img id="product-module-icon" src="<?= $h($firstModule['icon']) ?>" alt="">
              </div>
              <h3 id="product-module-title"><?= $h($firstModule['name']) ?></h3>
            </div>
            <p id="product-module-description"><?= $h($firstModule['description']) ?></p>
            <div class="product-modules__highlights" id="product-module-highlights">
              <?php foreach ($firstModule['highlights'] as $item) { ?>
                <div class="product-modules__highlight">
                  <span class="product-dot"></span>
                  <?= $h($item) ?>
                </div>
              <?php } ?>
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
        <?php foreach ($pricingPlans as $plan) { ?>
          <div class="product-pricing-card<?= ! empty($plan['featured']) ? ' is-featured' : '' ?>">
            <?php if (! empty($plan['featured'])) { ?>
              <div class="product-pricing-card__badge">Most Popular</div>
            <?php } ?>
            <h3><?= $h($plan['name']) ?></h3>
            <p class="product-pricing-card__desc"><?= $h($plan['description']) ?></p>
            <div class="product-pricing-card__price">
              <?php if (! empty($plan['custom'])) { ?>
                <span class="product-pricing-card__amount">Custom pricing</span>
              <?php } else { ?>
                <span class="product-pricing-card__amount">Free</span>
              <?php } ?>
            </div>
            <ul class="product-pricing-card__features">
              <?php foreach ($plan['features'] as $feature) { ?>
                <li>
                  <i class="fa-solid fa-check" aria-hidden="true"></i>
                  <?= $h($feature) ?>
                </li>
              <?php } ?>
            </ul>
            <a
              href="<?= $h($contactHref) ?>"
              class="product-btn <?= ! empty($plan['featured']) ? 'product-btn--gradient' : 'product-btn--outline' ?>"
            >
              <?= $h($plan['cta']) ?>
            </a>
          </div>
        <?php } ?>
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
          src="/images/product/7439febd7801d8c2544d0779e2f71779a0ebcb23.gif"
          alt="Team collaboration overview"
          class="product-productivity__shot product-productivity__shot--config"
        >
        <img
          src="/images/product/productivity-3.gif"
          alt="Dashboard overview"
          class="product-productivity__shot product-productivity__shot--dashboard"
        >
        <img
          src="/images/product/productivity-2.gif"
          alt="Attendance dashboard overview"
          class="product-productivity__shot product-productivity__shot--projects"
        >
        <img
          src="/images/product/ae57327cb88003a8cb87e2ac6ff87f652bcec9ce.gif"
          alt="Invoice document view"
          class="product-productivity__shot product-productivity__shot--invoice"
        >
      </div>

      <div class="product-dark-features">
        <?php foreach ($productivityFeatures as $feature) { ?>
          <div class="product-dark-feature">
            <div class="product-dark-feature__icon">
              <img src="<?= $h($feature['icon']) ?>" alt="">
            </div>
            <h3><?= $h($feature['title']) ?></h3>
            <p><?= $h($feature['description']) ?></p>
          </div>
        <?php } ?>
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
        <?php foreach ($principles as $item) { ?>
          <div class="product-principles__card">
            <div class="product-principles__icon">
              <img src="<?= $h($item['icon']) ?>" alt="">
            </div>
            <h3><?= $h($item['title']) ?></h3>
            <p><?= $h($item['description']) ?></p>
          </div>
        <?php } ?>
      </div>

      <div class="product-section__cta">
        <a href="<?= $h($contactHref) ?>" class="product-btn product-demo-btn">
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
        <?php foreach ($partnerCards as $card) { ?>
          <div class="product-partner-card">
            <img src="<?= $h($card['image']) ?>" alt="<?= $h($card['title']) ?>">
            <h3><?= $h($card['title']) ?></h3>
            <p><?= $h($card['description']) ?></p>
            <a href="<?= $h($card['href']) ?>" class="product-partner-card__link">Learn More</a>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <!-- 8. Partner Expertise End -->

  <!-- 9. Final CTA Start -->
  <section class="product-cta">
    <div class="container">
      <div class="product-cta__card">
        <div class="product-cta__decor product-cta__decor--left" aria-hidden="true">
          <img src="/images/product/cta-pulse.gif" alt="" class="product-cta__pulse">
        </div>
        <div class="product-cta__decor product-cta__decor--right" aria-hidden="true">
          <img src="/images/product/cta-pulse.gif" alt="" class="product-cta__pulse">
        </div>

        <div class="product-cta__content">
          <span class="product-cta__eyebrow">GET STARTED TODAY</span>
          <h2>Ready to streamline your team?</h2>
          <p>
            Start your 14-day free trial. No credit card required. All 12 modules included from day one.
          </p>
          <div class="product-cta__actions">
            <a href="<?= $h($contactHref) ?>" class="product-cta__btn product-cta__btn--primary">Start Free Trial</a>
            <a href="<?= $h($contactHref) ?>" class="product-cta__btn product-cta__btn--ghost">Talk to Sales</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- 9. Final CTA End -->

</div>

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
      panelImage.alt = name;
    }
    if (panelIcon) {
      panelIcon.src = icon;
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

<?php require __DIR__.'/layout/end.php'; ?>
