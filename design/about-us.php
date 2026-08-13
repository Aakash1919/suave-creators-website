<?php
$pageTitle = 'About Suave Creators | Leading IT Company with Web Design & Development';
$pageDescription = 'Suave Creators is a leading IT company offering budget-friendly web design, development, and digital solutions for startups, SMBs, and enterprise businesses.';
$useHeroBackground = true;
require __DIR__ . '/layout/start.php';

$h = static function ($v): string {
  return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
};

$ctaArrow = '<svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>';
$btnPrimary = 'u-btn-cta group inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm';

$smartModules = [
  ['Holidays', 'fa-solid fa-calendar-days'],
  ['Projects', 'fa-solid fa-file-circle-plus'],
  ['Logistics', 'fa-solid fa-cube'],
  ['AI Chat', 'fa-solid fa-comment-dots'],
  ['Tasks', 'fa-solid fa-list-check'],
  ['Outreach', 'fa-solid fa-chart-column'],
];

$coreValues = [
  ['Our Vision', 'We aim to enable businesses to stand higher from the rest of the world. To build a responsive and user oriented quality web designing & web development is our foremost capability to assist in the growth of any business.', '/images/core-icon-1.svg'],
  ['Our Mission', 'Our ultimate goal is to provide solutions to our esteemed clients beyond their requirements. We wish to ensure knowledge driven services where they can easily solve the relevant business concerns as per their client\'s requirement.', '/images/core-icon-2.svg'],
  ['Our Approach', 'We have a team of mindful & crazy people who love to explore customer-centric solutions for designing & developing websites. We aim to know what the client wants & add value to it with some useful & extra efforts to deliver a high quality service to them.', '/images/core-icon-3.svg'],
];

$aboutShoreSlides = [
  [
    '/images/answer-engine-inspiration-mindmap.webp',
    'Innovative & Engaging Process',
    'We believe in bringing engagement through the creative efforts at our workplace. Our strategies are uniquely delivered to the clients, which keeps them at bay to converge businesses into better opportunities.',
    ['SEO', 'Mobile', 'First Performance'],
  ],
  [
    '/images/conference-table-analytics-whiteboard.webp',
    'Research driven results',
    'Suave creators always focus on research before proceeding with any project. This helps us in preparing our comprehensive strategy, which results in the brand\'s success with relentless growth.',
    ['SEO', 'Mobile', 'First Performance'],
  ],
  [
    '/images/generative-engine-dev-team-coding.webp',
    'Optimal Delivery',
    'We don\'t just deliver the services, but ensure that our clients are happy with what we are delivering to them. Our approach and strategies mark the excellence in our efforts to provide them with better deliverables.',
    ['SEO', 'Mobile', 'First Performance'],
  ],
];

$growthFeatures = [
  [
    'Data-Driven Approach',
    'Our data-driven approach utilizes analytics and insights to optimize strategies, enhance user experiences, and drive growth by making informed decisions based on real-time data and trends.',
    '/images/financial-dashboard-laptop-collaboration.webp',
  ],
  [
    'Competitive Pricing',
    'We offer competitive pricing without compromising quality, ensuring cost-effective solutions tailored to your needs. Get premium digital services that maximize value while staying within your budget.',
    '/images/competitive-pricing-strategy-cash.webp',
  ],
  [
    'Ethical Business Practices',
    'We prioritize ethical business practices, ensuring transparency, integrity, and fairness in all our dealings. Our commitment to honesty fosters trust, long-term partnerships, and sustainable business growth.',
    '/images/diverse-team-data-meeting.webp',
  ],
];

$aboutPageStats = [
  [
    'end' => 12,
    'suffix' => '+',
    'label' => 'Combined Experience',
    'description' => 'Years of hands-on delivery across web, product, and enterprise software.',
  ],
  [
    'end' => 50,
    'suffix' => '+',
    'label' => 'Projects Done',
    'description' => 'Successfully completed more than 50+ digital products and platforms.',
  ],
  [
    'end' => 500,
    'suffix' => '+',
    'label' => 'Happy Clients',
    'description' => 'Trusted partnerships built on transparency, quality, and long-term support.',
  ],
  [
    'end' => 15,
    'suffix' => '+',
    'label' => 'Expert Team',
    'description' => '15+ passionate developers and management specialists ready to build with you.',
  ],
];

$articlesInsightsItems = [
  [
    'title' => 'How to Build a Digital Strategy That Creates Real Business Value',
    'excerpt' => 'A practical framework for connecting customer needs, technology decisions, and measurable growth.',
    'image' => '/images/blog-1.png',
    'alt' => 'Team collaborating on a digital strategy with colorful notes',
    'date' => 'Jun 24, 2026',
    'datetime' => '2026-06-24',
    'author' => 'Suave Creators',
    'url' => '/blogs',
  ],
  [
    'title' => 'Turning Product Data into Better Customer Experiences',
    'excerpt' => 'Learn how focused analytics can reveal friction, guide priorities, and improve every step of the user journey.',
    'image' => '/images/blog-2.png',
    'alt' => 'Designer mapping a digital product experience',
    'date' => 'Jun 12, 2026',
    'datetime' => '2026-06-12',
    'author' => 'Suave Creators',
    'url' => '/blogs',
  ],
  [
    'title' => 'Designing Digital Workflows Your Team Will Actually Use',
    'excerpt' => 'Simple principles for creating connected tools that reduce busywork and make collaboration easier.',
    'image' => '/images/blog-3.png',
    'alt' => 'Laptop displaying software development code',
    'date' => 'May 29, 2026',
    'datetime' => '2026-05-29',
    'author' => 'Suave Creators',
    'url' => '/blogs',
  ],
];

$partners = [
  ['/images/client-logo-4.png', 'VerySoul'],
  ['/images/client-logo-6.svg', 'RedSixity'],
  ['/images/client-logo-7.png', 'DAJJ Logistics'],
  ['/images/client-logo-8.png', 'Ematrics'],
  ['/images/client-logo-1.png', 'BioAssay Systems'],
];
?>

<!-- 1. About Banner Section Start -->
<section class="full-bleed bg-cover bg-center bg-no-repeat py-10 sm:py-14 lg:py-20"
  style="background-image: url('/images/about-banner-bg.png');" aria-labelledby="about-banner-title">
  <div class="section-inner flex flex-col">
    <div class="order-2 mx-auto mt-6 max-w-[900px] text-center sm:order-1 sm:mt-0">
      <h1 id="about-banner-title"
        class="text-[28px] font-semibold leading-[1.15] tracking-[-0.03em] text-[#171717] min-[375px]:text-[32px] sm:text-[40px] md:text-[44px] lg:text-[48px]">
        Leading IT Company with
        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent font-extrabold">
          Web Design &amp; Development
        </span>
      </h1>

      <p class="mx-auto mt-4 max-w-[780px] text-[13px] leading-5 text-[#171717] sm:mt-5 sm:text-[14px] sm:leading-6 lg:text-[16px]">
        <span class="font-bold"> Suave Creators is a leading and smart IT company offering budget-friendly and robust
          digital solutions.</span><span class="font-semibold"> With our expertise, we help clients deliver exceptional
          technology solutions for world-class businesses in every business industry, from dynamic startups and SMBs to
          Fortune 500 companies.</span>
      </p>

      <a href="/contact-us/#contact-id"
        class="group mt-8 inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-[3px_7px_22px_-6px_#2A4DFB24] transition hover:brightness-110 whitespace-nowrap sm:mt-10 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">
        Let's Discuss
        <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
          <path d="M18 8L22 12L18 16"></path>
          <path d="M2 12H22"></path>
        </svg>
      </a>
    </div>

    <div class="order-1 mx-auto w-full overflow-hidden rounded-xl border-[6px] border-white sm:order-2 sm:mt-8 sm:rounded-2xl sm:border-[10px]">
      <img src="/assets/team/about-us-team-portrait-banner.webp" alt="Suave Creators IT company team portraits for web design and development" title="Suave Creators IT company team portraits for web design and development"
        class="block h-auto w-full rounded-lg object-cover sm:rounded-[12px]" loading="eager">
    </div>
  </div>
</section>
<!-- 1. About Banner Section End -->

<!-- 2. About / Stats Section Start -->
<section class="full-bleed bg-white py-10 sm:py-12 md:py-16 lg:py-20" aria-labelledby="about-stats-title">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-start gap-8 md:gap-10 lg:grid-cols-2 lg:gap-14 xl:gap-16">

      <div class="min-w-0">
        <div class="flex items-center gap-2">
          <span class="inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
            aria-hidden="true"></span>
          <p
            class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
            About Us
          </p>
        </div>

        <h2 id="about-stats-title"
          class="mt-4 max-w-[480px] text-[20px] font-bold leading-tight tracking-[-0.02em] text-[#171717] lg:text-[24px]">
          At Suave Creators, we craft powerful and innovative digital solutions.
        </h2>

        <p class="mt-4 max-w-[520px] text-[13px] leading-6 text-[#4D4D4D] lg:text-[14px]">
          From web development and UI/UX design to custom CRM and eCommerce
          platforms—engineered for scalability, performance, SEO success,
          and long-term business growth.
        </p>

        <div class="mt-6 flex flex-wrap items-center gap-4 sm:mt-8 sm:gap-5">
          <a href="/contact-us/#contact-id"
            class="inline-flex min-h-11 items-center underline text-sm font-semibold bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] bg-clip-text text-transparent transition hover:opacity-80">
            Need more services based on your demand?
          </a>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-3 min-[480px]:grid-cols-2 sm:gap-4 lg:max-w-[560px] lg:justify-self-end"
        data-about-counters>
        <?php foreach ($aboutPageStats as $stat): ?>
          <article
            class="flex min-h-[128px] flex-col justify-between rounded-[16px] border-2 border-white bg-[#F8FAFB] p-4 shadow-[0_10px_28px_rgba(35,38,91,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_36px_rgba(35,38,91,0.10)] sm:min-h-[156px] sm:p-5 md:p-6">
            <div class="min-w-0">
              <p class="m-0 text-[28px] font-semibold font-mori italic leading-none tracking-[-0.04em] text-[#00003F] sm:text-[32px] lg:text-[36px]">
                <span data-counter-end="<?= (int) $stat['end'] ?>">0</span><?= $h($stat['suffix']) ?>
              </p>
              <h3 class="mt-2 text-[13px] font-semibold leading-snug text-[#2A4DFB] sm:text-[14px]">
                <?= $h($stat['label']) ?>
              </h3>
            </div>
            <p class="mt-3 text-[13px] leading-5 text-[#4D4D4D] sm:mt-4 sm:text-[14px]">
              <?= $h($stat['description']) ?>
            </p>
          </article>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</section>
<!-- 2. About / Stats Section End -->

<!-- 3. Why Suave Creators Section Start -->
<section class="full-bleed bg-white py-10 sm:py-14 md:py-16 lg:py-20" aria-labelledby="about-why-title">
  <div class="section-inner">
    <header class="mb-8 grid grid-cols-1 items-start gap-4 sm:mb-10 lg:mb-14 lg:grid-cols-[190px_minmax(0,1fr)] lg:gap-8">
      <div class="flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
          aria-hidden="true"></span>
        <p
          class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
          Suave Creators
        </p>
      </div>
      <div class="min-w-0">
        <h2 id="about-why-title" class="text-[20px] font-bold leading-tight text-[#171717] lg:text-[24px]">
          Why Suave Creators
        </h2>
        <p class="mt-3 max-w-[720px] text-[13px] leading-6 text-[#4D4D4D] lg:text-[14px]">
          We are one of the reputed website development companies where we focus on giving cent percent to the
          client&rsquo;s requirement.
        </p>
      </div>
    </header>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:gap-7 lg:grid-cols-3 lg:gap-8">
      <?php foreach ($aboutShoreSlides as $slide): ?>
        <article class="flex min-w-0 flex-col">
          <figure class="overflow-hidden rounded-[14px]">
            <img src="<?= $h($slide[0]) ?>" alt="<?= $h($slide[1]) ?>" class="aspect-[4/3] h-auto w-full object-cover"
              width="640" height="480" loading="lazy">
          </figure>

          <div class="mt-4 flex flex-wrap gap-2">
            <?php foreach ($slide[3] as $tag): ?>
              <span
                class="inline-flex items-center rounded-full bg-[#EEF1FF] px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-[#2A4DFB] sm:text-[12px]">
                <?= $h($tag) ?>
              </span>
            <?php endforeach; ?>
          </div>

          <h3 class="mt-4 text-[18px] font-semibold leading-snug text-[#171717] lg:text-[20px]">
            <?= $h($slide[1]) ?>
          </h3>
          <p class="mt-3 text-[13px] leading-6 text-[#4D4D4D] lg:text-[14px]">
            <?= $h($slide[2]) ?>
          </p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 3. Why Suave Creators Section End -->

<!-- 4. Smart Modules Section Start -->
<section class="full-bleed about-modules-section py-12 md:py-14 lg:py-16" aria-labelledby="about-modules-title">
  <div class="section-inner">
    <header class="mx-auto mb-8 max-w-[720px] text-center md:mb-10">
      <h2 id="about-modules-title" class="text-[14px] font-semibold leading-snug text-[#5B6CFF]">
        &ldquo;17+ Smart Modules. One Unified Workspace.&rdquo;
      </h2>
      <span class="mx-auto mt-1 block h-[2px] w-[28px] rounded-full bg-[#5B6CFF]" aria-hidden="true"></span>
    </header>

    <div class="grid grid-cols-2 gap-3 min-[480px]:grid-cols-3 sm:gap-4 lg:grid-cols-6 lg:gap-5">
      <?php foreach ($smartModules as $module): ?>
        <article class="about-module-card">
          <span class="about-module-card__icon" aria-hidden="true">
            <i class="<?= $h($module[1]) ?>"></i>
          </span>
          <span class="about-module-card__label"><?= $h($module[0]) ?></span>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 4. Smart Modules Section End -->

<!-- 5. Core Values Section Start -->
<section class="full-bleed bg-[url('/images/core-bg.png')] bg-cover bg-top bg-no-repeat py-12 sm:py-16 lg:py-24"
  aria-labelledby="core-values-title">
  <div class="section-inner">
    <header class="mb-8 grid grid-cols-1 items-start gap-4 sm:mb-10 lg:mb-14 lg:grid-cols-[190px_minmax(0,1fr)] lg:gap-8">
      <div class="flex items-center gap-2">
        <span class="mt-0.5 inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
          aria-hidden="true"></span>
        <p
          class="text-[14px] font-bold leading-[100%] bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent">
          Values</p>
      </div>
      <div class="min-w-0">
        <h2 id="core-values-title" class="text-[20px] font-bold leading-tight text-[#171717] lg:text-[24px]">Our Core
          Values</h2>
        <p class="mt-4 max-w-[760px] text-[13px] leading-5 text-[#4D4D4D] sm:leading-6 lg:text-[14px] lg:leading-6">
          Driven by innovation, integrity, and excellence, we focus on delivering meaningful digital solutions that
          empower businesses, inspire creativity, and build lasting partnerships.
        </p>
      </div>
    </header>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 md:gap-0">
      <?php foreach ($coreValues as $index => $value): ?>
        <article
          class="about-value-card about-value-card--<?= $h((string) ($index + 1)) ?> group relative overflow-hidden rounded-2xl border border-[#ECECEC] bg-white px-5 py-7 sm:px-7 sm:py-9 md:rounded-none <?= $index === 0 ? 'md:rounded-l-2xl' : '' ?> <?= $index === 2 ? 'md:rounded-r-2xl' : '' ?> <?= $index < 2 ? 'md:border-r' : '' ?>"
          style="--about-value-accent: <?= $index === 0 ? '#FF0047' : ($index === 1 ? '#289AF6' : '#00EA9D') ?>">
          <span
            class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            style="background: radial-gradient(circle at 100% 100%, color-mix(in srgb, var(--about-value-accent) 12%, transparent), transparent 58%);"
            aria-hidden="true"></span>
          <span class="about-value-card__icon relative inline-flex">
            <img src="<?= $h($value[2]) ?>" alt="" width="48" height="48" loading="lazy">
          </span>
          <h3 class="about-value-card__title relative"><?= $h($value[0]) ?></h3>
          <p class="about-value-card__text relative"><?= $h($value[1]) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 5. Core Values Section End -->

<!-- 6. Work With Us CTA Section Start -->
<section class="full-bleed overflow-hidden bg-white py-10 sm:py-14 lg:py-20" aria-labelledby="about-work-title">
  <div
    class="section-inner rounded-2xl bg-[url('/images/background_core_values.png')] bg-cover bg-center bg-no-repeat p-5 sm:p-8 lg:p-12">
    <div class="grid items-center gap-6 sm:gap-8 lg:grid-cols-2 lg:gap-12">
      <div class="order-2 w-full lg:order-1">
        <img src="/images/right-transform.png" alt="Work With Us" class="ml-auto h-auto w-full max-w-[520px] object-cover lg:max-w-none" loading="lazy">
      </div>
      <div class="order-1 max-w-[640px] text-left lg:order-2">
        <h2 id="about-work-title" class="text-[20px] font-semibold leading-tight text-white lg:text-[24px]">
          Ready to transform your business?
        </h2>
        <p class="mt-4 text-[13px] font-normal leading-6 text-[#B1B9DF] sm:text-[14px]">
          Let’s transform your idea into a high-performing digital solution. Our team is ready to collaborate, innovate, and deliver results that matter.
        </p>
        <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?> mt-6 sm:mt-8">
          Let&rsquo;s Connect to Discuss
          <?= $ctaArrow ?>
        </a>
      </div>
    </div>
  </div>
</section>
<!-- 6. Work With Us CTA Section End -->

<!-- 7. Technologies Marquee Section Start -->
<?php
$techMarqueeSectionClass = 'full-bleed full-bleed--edge bg-[white] pt-6 pb-10 lg:pt-10 lg:pb-14';
require __DIR__ . '/partials/tech-partnerships-marquee.php';
?>
<!-- 7. Technologies Marquee Section End -->

<!-- 8. Why Choose Us Section Start -->
<section
  class="full-bleed bg-[#050A24] bg-[url('/images/background_core_values.png')] bg-cover bg-center bg-no-repeat py-10 sm:py-14 md:py-16 lg:py-20"
  aria-labelledby="digital-growth-title">
  <div class="section-inner">
    <header class="mb-8 grid grid-cols-1 items-start gap-4 sm:mb-10 lg:mb-12 lg:grid-cols-[190px_minmax(0,1fr)] lg:gap-8">
      <div class="flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
          aria-hidden="true"></span>
        <p
          class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
          Why Choose Us
        </p>
      </div>
      <div class="min-w-0">
        <h2 id="digital-growth-title" class="text-[20px] font-bold leading-tight text-white lg:text-[24px]">
          Expertise for your <span class="font-extrabold">digital growth journey</span>
        </h2>
        <p class="mt-3 max-w-[760px] text-[13px] leading-6 text-[#B1B9DF] lg:text-[14px]">
          By empowering your digital growth journey with expert solutions in custom web development, UX/UI design,
          AI solutions, and brand identity. We pursue innovative, scalable, and user-centric experiences to promote
          your brand, engage your audience, and drive success in the digital landscape.
        </p>
      </div>
    </header>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 md:gap-6 lg:grid-cols-3 lg:gap-7">
      <?php foreach ($growthFeatures as $feature): ?>
        <article
          class="overflow-hidden rounded-[16px] border border-white/10 bg-[#0B1235]/80 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-[2px]">
          <figure class="overflow-hidden">
            <img src="<?= $h($feature[2]) ?>" alt="<?= $h($feature[0]) ?>"
              class="aspect-[16/10] h-auto w-full object-cover" width="640" height="400" loading="lazy">
          </figure>
          <div class="p-5 sm:p-6">
            <h3 class="text-[18px] font-semibold leading-snug text-white lg:text-[20px]"><?= $h($feature[0]) ?></h3>
            <p class="mt-3 text-[13px] leading-6 text-[#B1B9DF] lg:text-[14px]"><?= $h($feature[1]) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="mt-10 flex flex-wrap items-center justify-start gap-2 sm:justify-end sm:gap-3">
      <span class="text-[13px] font-medium text-white/90 lg:text-[14px]">Let&rsquo;s Connect to Discuss</span>
      <a href="/contact-us/#contact-id"
        class="text-[13px] font-semibold text-[#8B95FF] underline underline-offset-4 transition hover:text-white lg:text-[14px]">
        Book a Call
      </a>
    </div>
  </div>
</section>
<!-- 8. Why Choose Us Section End -->

<?php
$articlesInsightsHeadingId = 'about-insights-title';
$articlesInsightsSectionClass = 'py-10 sm:py-12 lg:py-18';
$articlesInsightsMoreHref = '/blogs';
$articlesInsightsMoreLabel = 'View More';
require __DIR__ . '/partials/articles-insights.php';
?>

<!-- 10. Consultation CTA Section Start -->
<section id="consultation" class="full-bleed consultation-section">
  <div class="section-inner">
    <div class="consultation-card bg-[url('/images/consultation-bg.png')] bg-cover bg-top bg-no-repeat">
      <div class="consultation-copy">
        <h2>Let's Build Your Next Digital<br class="hidden sm:block"> Solution with us!</h2>
        <p>
          Book a consultation for your next digital project. Suave Creators delivers quality work, stays ahead of
          trends, and is here to help.
        </p>
        <a href="/contact-us/#contact-id" class="consultation-cta">
          Book a Free Consultation <svg xmlns="https://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1">
            <path d="M18 8L22 12L18 16"></path>
            <path d="M2 12H22"></path>
          </svg>
        </a>
      </div>

      <div class="consultation-people">
        <div class="consultation-people__column consultation-people__column--left">
          <figure class="consultation-person consultation-person--pink">
            <img src="/images/consult-1.png" alt="Suave Creators team member" width="640" height="960" loading="lazy">
          </figure>
          <figure class="consultation-person consultation-person--orange">
            <img src="/images/consult-2.png" alt="Suave Creators team member" width="640" height="960" loading="lazy">
          </figure>
        </div>
        <div class="consultation-people__column consultation-people__column--center">
          <figure class="consultation-person consultation-person--yellow">
            <img src="/images/consult-3.png" alt="Suave Creators team leader" width="640" height="960" loading="lazy">
          </figure>
          <figure class="consultation-person consultation-person--blue">
            <img src="/images/consult-5.png" alt="Suave Creators team lead" width="640" height="959" loading="lazy">
          </figure>
        </div>
        <div class="consultation-people__column consultation-people__column--right">
          <figure class="consultation-person consultation-person--coral">
            <img src="/images/consult-4.png" alt="Suave Creators designer" width="640" height="960" loading="lazy">
          </figure>
          <figure class="consultation-person consultation-person--cyan">
            <img src="/images/consult-6.png" alt="Suave Creators team collaborating" width="640" height="960"
              loading="lazy">
          </figure>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- 10. Consultation CTA Section End -->

<!-- 11. Partnerships Section Start -->
<section class="full-bleed partnership-section bg-repeat"
  style="background-image: url('/images/pattern_portfolio.png');"
  aria-label="Client partnerships">
  <div class="partnership-inner section-inner text-center">
    <p
      class="offerings-eyebrow mb-8 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
      Our Partnerships &amp; Growth Stack
    </p>

    <div class="partnership-marquee" tabindex="0">
      <div class="partnership-marquee__track">
        <?php for ($group = 0; $group < 2; $group++): ?>
          <div class="partnership-marquee__group"<?= $group === 1 ? ' aria-hidden="true"' : '' ?>>
            <?php foreach (array_merge($partners, $partners) as $partner): ?>
              <div class="partnership-tile">
                <img src="<?= $h($partner[0]) ?>"
                  alt="<?= $h($partner[1]) ?> logo partner of Suave Creators"
                  title="<?= $h($partner[1]) ?> logo partner of Suave Creators" width="120" height="48"
                  decoding="async"<?= $group === 0 ? ' loading="lazy"' : '' ?>>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>
<!-- 11. Partnerships Section End -->

<style>
.about-value-card {
  --about-value-accent: #ff0047;
}

.about-value-card--1 {
  --about-value-accent: #ff0047;
}

.about-value-card--2 {
  --about-value-accent: #289af6;
}

.about-value-card--3 {
  --about-value-accent: #00ea9d;
}

.about-value-card::before {
  background: var(--about-value-accent);
  content: "";
  height: 2px;
  left: 0;
  position: absolute;
  top: 0;
  transition: width 0.35s ease;
  width: 0;
  z-index: 1;
}

.about-value-card:hover::before {
  width: 100%;
}

.about-value-card__icon img {
  display: block;
  height: 40px;
  object-fit: contain;
  width: 40px;
}

.about-value-card__title {
  color: #171717;
  font-size: 1.125rem;
  font-weight: 600;
  line-height: 1.3;
  margin: 1rem 1rem 0.75rem 0;
}

.about-value-card__text {
  color: #4d4d4d;
  font-size: 13px;
  line-height: 1.5;
  margin: 0;
}

@media (min-width: 640px) {
  .about-value-card__icon img {
    height: 48px;
    width: 48px;
  }

  .about-value-card__title {
    font-size: 1.25rem;
    margin-bottom: 1.25rem;
  }

  .about-value-card__text {
    font-size: 14px;
    line-height: 1.5;
  }
}

@media (prefers-reduced-motion: reduce) {
  .about-value-card::before {
    transition: none;
  }
}


  .about-modules-section {
    background-color: #F7F8FF;
    background-image: url('/images/smart-bg.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  .about-module-card {
    align-items: center;
    background: #fff;
    border: 1px solid #F6F8FF;
    border-radius: 14px;
    box-shadow: 3px 6px 14px -5px #00003F0D;
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: center;
    min-height: 100px;
    padding: 16px 12px 14px;
    width: 100%;
  }

  .about-module-card__icon {
    background: linear-gradient(180deg, #2A4DFB 0%, #7A5FF8 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    display: inline-flex;
    font-size: 24px;
    line-height: 1;
  }

  .about-module-card__label {
    color: #171717;
    font-size: 13px;
    font-weight: 500;
    line-height: 1.2;
    text-align: center;
  }

  @media (min-width: 768px) {
    .about-module-card {
      gap: 12px;
      min-height: 94px;
      padding: 22px 16px 18px;
    }

    .about-module-card__icon {
      font-size: 22px;
    }

    .about-module-card__label {
      font-size: 14px;
    }
  }

  /* About page only: mobile CTA height */
  @media (max-width: 767px) {
    main .u-btn-cta,
    main a.rounded-full.bg-gradient-to-r,
    main .consultation-cta {
      box-sizing: border-box;
      height: 34px !important;
      min-height: 34px !important;
      padding-block: 0 !important;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    var root = document.querySelector('[data-about-counters]');
    if (!root) return;

    var counters = root.querySelectorAll('[data-counter-end]');
    var started = false;

    function animateCounters() {
      if (started) return;
      started = true;

      counters.forEach(function (el) {
        var end = parseInt(el.getAttribute('data-counter-end'), 10) || 0;
        if (reduceMotion) {
          el.textContent = String(end);
          return;
        }

        var duration = 1500;
        var startTime = null;

        function step(timestamp) {
          if (!startTime) startTime = timestamp;
          var progress = Math.min((timestamp - startTime) / duration, 1);
          el.textContent = String(Math.ceil(progress * end));
          if (progress < 1) requestAnimationFrame(step);
        }

        requestAnimationFrame(step);
      });
    }

    if ('IntersectionObserver' in window) {
      var observer = new IntersectionObserver(function (entries) {
        if (entries.some(function (entry) { return entry.isIntersecting; })) {
          animateCounters();
          observer.disconnect();
        }
      }, { threshold: 0.35 });
      observer.observe(root);
    } else {
      animateCounters();
    }
  });
</script>

<?php
require __DIR__ . '/layout/end.php';
?>