<?php
/**
 * Shared industry detail page — full section sequence matching suaveCodebase.
 * Expects $industry array from data/industries/*.php
 */
if (empty($industry) || !is_array($industry)) {
  http_response_code(500);
  echo 'Industry content missing.';
  return;
}

$h = static function ($v): string {
  return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
};

$pageTitle = $industry['pageTitle'] ?? 'Industry Solutions | Suave Creators';
$pageDescription = $industry['pageDescription'] ?? '';
$useHeroBackground = true;
require __DIR__ . '/../layout/start.php';

$defaultProcessData = [
  'Planning & Consultation' => [
    ['icon' => '/images/agile-icon-1.svg', 'title' => 'Vision and Goals Discussion', 'desc' => 'Define digital transformation goals and align stakeholders on outcomes.'],
    ['icon' => '/images/agile-icon-2.svg', 'title' => 'Resource Allocation', 'desc' => 'Assign dedicated developers, analysts, and designers for secure delivery.'],
    ['icon' => '/images/agile-icon-3.svg', 'title' => 'Project Roadmap Creation', 'desc' => 'Outline timeline, integrations, and milestones from prototype to launch.'],
    ['icon' => '/images/agile-icon-4.svg', 'title' => 'Scope Definition', 'desc' => 'Define technical requirements, roles, and compliance frameworks.'],
  ],
  'Design' => [
    ['icon' => '/images/agile-icon-1.svg', 'title' => 'User Journey Mapping', 'desc' => 'Map journeys for every role to design intuitive interfaces.'],
    ['icon' => '/images/agile-icon-2.svg', 'title' => 'UI/UX Design', 'desc' => 'Create dashboards and mobile-first layouts tailored to the industry.'],
    ['icon' => '/images/agile-icon-3.svg', 'title' => 'Wireframes & Prototypes', 'desc' => 'Build wireframes focused on accessibility and key workflows.'],
    ['icon' => '/images/agile-icon-4.svg', 'title' => 'Design Finalisation', 'desc' => 'Finalise visuals, content flow, and interactive patterns.'],
  ],
  'Development' => [
    ['icon' => '/images/agile-icon-1.svg', 'title' => 'Secure Build', 'desc' => 'Translate goals into secure, scalable software modules.'],
    ['icon' => '/images/agile-icon-2.svg', 'title' => 'Engineering Team', 'desc' => 'Assign Laravel, React, and API specialists for robust systems.'],
    ['icon' => '/images/agile-icon-3.svg', 'title' => 'Sprint Delivery', 'desc' => 'Structured sprints for backend APIs, front-end, and integrations.'],
    ['icon' => '/images/agile-icon-4.svg', 'title' => 'Stack & Security', 'desc' => 'Define stack, third-party integrations, and security layers.'],
  ],
  'Testing' => [
    ['icon' => '/images/agile-icon-1.svg', 'title' => 'Test Objectives', 'desc' => 'Verify accuracy, privacy, and performance before go-live.'],
    ['icon' => '/images/agile-icon-2.svg', 'title' => 'QA Specialists', 'desc' => 'Domain QA for validation, workflow simulation, and load handling.'],
    ['icon' => '/images/agile-icon-3.svg', 'title' => 'Test Cycles', 'desc' => 'Unit, integration, UAT, and security audits across releases.'],
    ['icon' => '/images/agile-icon-4.svg', 'title' => 'Quality Benchmarks', 'desc' => 'Define coverage criteria and automated testing tools.'],
  ],
  'Deployment' => [
    ['icon' => '/images/agile-icon-1.svg', 'title' => 'Deployment Goals', 'desc' => 'Seamless integration with existing systems and cloud infra.'],
    ['icon' => '/images/agile-icon-2.svg', 'title' => 'DevOps Support', 'desc' => 'Server configs, API connections, and compliance checks.'],
    ['icon' => '/images/agile-icon-3.svg', 'title' => 'Migration Plan', 'desc' => 'Step-by-step migration, onboarding, and backup strategies.'],
    ['icon' => '/images/agile-icon-4.svg', 'title' => 'Go-Live Readiness', 'desc' => 'Environments, rollback procedures, and monitoring metrics.'],
  ],
  'Maintenance' => [
    ['icon' => '/images/agile-icon-1.svg', 'title' => 'Long-term Goals', 'desc' => 'Sustainability, uptime, and data integrity after launch.'],
    ['icon' => '/images/agile-icon-2.svg', 'title' => 'Support Team', 'desc' => 'Patches, performance optimisation, and major updates.'],
    ['icon' => '/images/agile-icon-3.svg', 'title' => 'Update Roadmap', 'desc' => 'Periodic updates aligned with new tech and regulations.'],
    ['icon' => '/images/agile-icon-4.svg', 'title' => 'SLA & Monitoring', 'desc' => 'Monitoring tools, reporting, and service-level commitments.'],
  ],
];
$processData = $industry['processData'] ?? $defaultProcessData;
$testimonials = $industry['testimonialsData'] ?? [
  ['quote' => 'They took the time to understand our complex business needs and turned them into an elegant digital solution.', 'name' => 'Steve', 'role' => 'Director, Red3Sixty', 'image' => '/images/testimonial-1.webp'],
  ['quote' => 'From strategy to execution, they nailed every part of our digital campaign. The results were far beyond our expectations!', 'name' => 'Jane Smith', 'role' => 'Marketing Head', 'image' => '/images/testimonial-1.webp'],
];
$sampleInsights = [
  ['Digital Strategy', 'Jun 24, 2026', '2026-06-24', 'How to Build a Digital Strategy That Creates Real Business Value', 'A practical framework for connecting customer needs and measurable growth.', '/images/blog-1.png', 'digital-strategy-that-creates-value'],
  ['Product Growth', 'Jun 12, 2026', '2026-06-12', 'Turning Product Data into Better Customer Experiences', 'Focused analytics that reveal friction and improve the user journey.', '/images/blog-2.png', 'product-data-customer-experiences'],
  ['Future of Work', 'May 29, 2026', '2026-05-29', 'Designing Digital Workflows Your Team Will Actually Use', 'Principles for connected tools that reduce busywork.', '/images/blog-3.png', 'digital-workflows-teams-use'],
];
?>

<!-- Hero Section Start -->
<section class="relative z-10 w-full overflow-x-clip pb-10 pt-6 sm:pb-12 sm:pt-8 md:pb-16 md:pt-10 lg:min-h-[600px] lg:pb-20 lg:pt-[52px] site-container">
  <div class="grid grid-cols-1 items-center gap-8 sm:gap-10 lg:grid-cols-2 lg:gap-12">
    <div class="relative z-0 order-2 flex max-w-xl min-w-0 flex-col text-left lg:order-1 lg:max-w-[560px]">
      <p class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[11px] font-bold uppercase tracking-wide text-transparent sm:text-sm"><?= $h($industry['eyebrow'] ?? 'Industry Solutions') ?></p>
      <h1 class="mb-2 mt-1 flex flex-col text-[28px] font-semibold leading-[1.05] text-white min-[375px]:text-[34px] sm:mt-2 sm:text-5xl lg:text-[52px] lg:leading-none">
        <?php foreach (($industry['heroTitle'] ?? []) as $i => $line): ?>
          <?php if ($i === 0): ?>
            <span class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text font-extrabold text-transparent"><?= $h($line) ?></span>
          <?php else: ?>
            <span><?= $h($line) ?></span>
          <?php endif; ?>
        <?php endforeach; ?>
      </h1>
      <p class="mb-2 mt-2 text-[13px] leading-6 text-[#B1B9DF] sm:text-sm"><?= $h($industry['heroDescription'] ?? '') ?></p>
      <div class="mt-6 flex flex-col items-start gap-3 sm:mt-8 sm:flex-row sm:items-center sm:gap-7">
        <a href="/contact-us/#contact-id" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] w-fit items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">
          Let's Connect to Discuss
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
        </a>
        <a href="/contact-us/#contact-id" class="inline-flex w-fit items-center border-b border-white/70 text-[13px] font-semibold text-white sm:text-sm">Book a Call</a>
      </div>
    </div>
    <div class="relative z-10 order-1 mx-auto flex w-full max-w-[360px] min-w-0 items-center justify-center sm:max-w-[420px] lg:order-2 lg:mx-0 lg:max-w-[480px] lg:justify-end">
      <?php if (!empty($industry['heroImage'])): ?>
        <img src="<?= $h($industry['heroImage']) ?>" alt="<?= $h($industry['pageTitle'] ?? '') ?>" width="560" height="560" class="block h-auto w-full rounded-[20px] object-cover shadow-[0_24px_60px_rgba(0,0,63,0.35)] sm:rounded-[28px]" loading="eager">
      <?php endif; ?>
    </div>
  </div>
</section>
<!-- Hero Section End -->

<!-- Intro + Stats Section Start -->
<section class="full-bleed bg-white bg-[url('/images/web-bg.png')] bg-cover bg-top bg-no-repeat py-10 sm:py-14 lg:py-20" aria-labelledby="industry-intro-heading">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-start gap-8 sm:gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:gap-14">
      <div class="min-w-0">
        <div class="mb-3 flex items-center gap-2 sm:mb-4">
          <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]"><?= $h($industry['introEyebrow'] ?? 'Professional Solutions') ?></span>
        </div>
        <h2 id="industry-intro-heading" class="text-[22px] font-bold leading-tight text-[#171717] sm:text-[clamp(1.75rem,4vw,2.75rem)]"><?= $h($industry['introTitle'] ?? '') ?></h2>
        <p class="mt-3 max-w-[560px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px]"><?= $h($industry['introDescription'] ?? '') ?></p>
        <div class="mt-6 sm:mt-8">
          <a href="/services" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">
            Explore Services
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
          </a>
        </div>
      </div>
      <div class="grid grid-cols-1 gap-3 min-[480px]:grid-cols-2 sm:gap-3.5">
        <?php
        $stats = [
          ['50+', 'Projects Delivered', 'Successfully completed more than 50+ projects.', '/images/stat-projects.svg', '#4C24F4', '#F0EAFF'],
          ['10+', 'Years Experience', 'Years of Combined Experience.', '/images/stat-experience.svg', '#1873E7', '#EAF5FC'],
          ['$40M+', 'Funding Secured', 'Helped clients secure more than $40M+ in funding.', '/images/stat-funding.svg', '#0F968E', '#E8F8F6'],
          ['15+', 'Expert Team', '15+ Passionate Developers and Management Teams.', '/images/stat-team.svg', '#FA6811', '#FFF0E7'],
        ];
        foreach ($stats as $stat): ?>
          <article class="flex min-w-0 items-start gap-3 rounded-[16px] border border-[rgb(31_38_68_/_3%)] bg-white p-3.5 shadow-[0_16px_36px_rgb(35_38_91_/_10%)] sm:gap-3.5 sm:rounded-[20px] sm:p-4">
            <span class="inline-flex h-[44px] w-[44px] shrink-0 items-center justify-center sm:h-[52px] sm:w-[52px]">
              <img src="<?= $h($stat[3]) ?>" alt="" width="52" height="52" class="h-[44px] w-[44px] object-contain sm:h-[52px] sm:w-[52px]">
            </span>
            <div class="min-w-0">
              <strong class="block text-[24px] font-semibold leading-none tracking-tight sm:text-[28px]" style="color: <?= $h($stat[4]) ?>;"><?= $h($stat[0]) ?></strong>
              <h3 class="mt-1 text-[12px] font-semibold leading-snug sm:text-[13px] sm:leading-none" style="color: <?= $h($stat[4]) ?>;"><?= $h($stat[1]) ?></h3>
              <p class="mt-1 text-[12px] font-medium leading-4 text-[#171717] sm:text-[13px]"><?= $h($stat[2]) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<!-- Intro + Stats Section End -->

<!-- Services Hub Section Start -->
<section class="full-bleed web-services industry-detail-services bg-[url('/images/dev-bg.png')] bg-cover bg-top bg-no-repeat py-10 sm:py-14 lg:py-20" aria-labelledby="industry-services-heading">
  <div class="web-services__inner section-inner">
    <header class="web-services__header">
      <div class="mb-3 flex items-center gap-2 sm:mb-4">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]"><?= $h($industry['servicesEyebrow'] ?? 'Services') ?></span>
      </div>
      <div class="web-services__intro">
        <h2 id="industry-services-heading" class="mb-3 text-[20px] font-semibold leading-tight text-[#171717] sm:mb-4 sm:text-[22px] lg:text-[24px]"><?= $h($industry['servicesTitle'] ?? '') ?></h2>
        <p class="text-[13px] leading-[150%] text-[#4D4D4D] sm:text-[14px]"><?= $h($industry['servicesDescription'] ?? '') ?></p>
      </div>
    </header>
    <div class="web-services__grid">
      <?php foreach (($industry['services'] ?? []) as $index => $service): ?>
        <article class="web-service-card">
          <span class="web-service-card__icon">
            <img src="<?= $h($service['icon'] ?? '') ?>" alt="" width="36" height="36">
          </span>
          <div class="web-service-card__category">
            <span class="text-[10px] font-semibold uppercase text-[#4D4D4D]"><?= $h(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . ' - Service') ?></span>
            <div class="flex items-start justify-between gap-2">
              <h3 class="mt-2 min-w-0 text-[14px] font-semibold leading-[130%] text-[#171717]"><?= $h($service['title'] ?? '') ?></h3>
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-2 shrink-0" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
            </div>
          </div>
          <p class="mt-1 text-[13px] leading-relaxed text-[#4D4D4D] sm:text-[14px]"><?= $h($service['desc'] ?? '') ?></p>
          <?php if (!empty($service['img'])): ?>
            <figure class="mt-3 aspect-video overflow-hidden rounded-[12px] sm:rounded-[14px]"><img src="<?= $h($service['img']) ?>" alt="<?= $h($service['title'] ?? '') ?>" width="640" height="360" class="h-full w-full object-cover" loading="lazy"></figure>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:mt-10 sm:flex-row sm:flex-wrap sm:gap-5">
      <a href="/contact-us/#contact-id" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] w-fit items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">Let's Connect to Discuss<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
      <a href="/contact-us/#contact-id" class="inline-flex w-fit border-b border-[#00003F] text-[13px] font-semibold text-[#00003F] sm:text-sm">Let's Build Your Digital Future Together</a>
    </div>
  </div>
</section>
<!-- Services Hub Section End -->

<!-- Work With Us CTA Section Start -->
<section class="full-bleed smart-together-cta py-5 sm:py-6" aria-labelledby="industry-cta-heading">
  <div class="smart-together-cta__inner section-inner">
    <div class="mb-3 flex items-center gap-2 sm:mb-4">
      <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
      <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]"><?= $h($industry['ctaEyebrow'] ?? 'Ready to Start Your Project?') ?></span>
    </div>
    <div class="smart-together-cta__copy min-w-0">
      <h2 id="industry-cta-heading" class="text-lg font-semibold leading-tight text-white sm:text-xl md:text-2xl md:leading-none"><?= $h($industry['ctaTitle'] ?? '') ?></h2>
      <p class="mt-2 text-[12px] font-semibold leading-normal text-[#B1B9DF] sm:text-sm"><?= $h($industry['ctaDescription'] ?? '') ?></p>
    </div>
    <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:gap-3">
      <a href="/contact-us/#contact-id" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] w-fit items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">Let's Connect to Discuss<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
      <a href="/contact-us/#contact-id" class="inline-flex w-fit items-center border-b border-white/70 text-[13px] font-semibold text-white sm:text-sm">Discuss your Vision</a>
    </div>
    <span class="smart-together-cta__phone" aria-hidden="true"><img src="/images/phone.gif" alt="" class="rounded-[10px]"></span>
  </div>
</section>
<!-- Work With Us CTA Section End -->

<!-- Specialized Services Section Start -->
<section class="full-bleed overflow-hidden bg-[#F9FAFC] bg-[url('/images/background_offerings.png')] bg-cover bg-top bg-no-repeat py-10 sm:py-14 lg:py-20" aria-labelledby="industry-specialized-heading">
  <div class="section-inner">
    <div class="mx-auto mb-8 max-w-[720px] text-center sm:mb-10 lg:mb-14">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]"><?= $h($industry['specializedEyebrow'] ?? 'Specialized Services') ?></p>
      <h2 id="industry-specialized-heading" class="mt-3 text-[20px] font-semibold leading-tight text-[#171717] sm:mt-4 sm:leading-[36px] lg:text-[24px]"><?= $h($industry['specializedTitle'] ?? '') ?></h2>
      <p class="mx-auto mt-3 max-w-[605px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px] sm:leading-[24px]"><?= $h($industry['specializedDescription'] ?? '') ?></p>
    </div>
    <div class="grid grid-cols-1 gap-4 sm:gap-5 md:grid-cols-2 lg:grid-cols-4 lg:gap-6">
      <?php foreach (($industry['specialized'] ?? []) as $item): ?>
        <article class="flex min-h-full flex-col gap-3 rounded-[18px] border border-[rgba(42,77,251,0.08)] bg-white p-4 shadow-[0_18px_40px_rgba(36,36,84,0.06)] sm:rounded-[22px] sm:p-[22px]">
          <?php if (!empty($item['icon'])): ?><span class="inline-flex h-[44px] w-[44px] items-center justify-center rounded-[12px] bg-[#EEF1FF] sm:h-[52px] sm:w-[52px] sm:rounded-[14px]"><img src="<?= $h($item['icon']) ?>" alt="" width="26" height="26" class="h-[22px] w-[22px] object-contain sm:h-[26px] sm:w-[26px]" loading="lazy"></span><?php endif; ?>
          <h3 class="text-[15px] font-bold leading-tight text-[#171717] sm:text-base"><?= $h($item['title'] ?? '') ?></h3>
          <p class="flex-1 text-[13px] leading-relaxed text-[#4D4D4D] sm:text-sm"><?= $h($item['desc'] ?? '') ?></p>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="mt-8 flex justify-center sm:mt-10"><a href="/services" class="border-b border-[#00003F] text-[13px] font-semibold text-[#00003F] sm:text-sm">Explore all Services</a></div>
  </div>
</section>
<!-- Specialized Services Section End -->

<!-- Why Choose Section Start -->
<section class="full-bleed industry-why-section relative overflow-hidden bg-[#F8FAFC] py-10 sm:py-14 lg:py-20" aria-labelledby="industry-why-heading">
  <div class="industry-why-section__bg" aria-hidden="true"></div>
  <div class="section-inner relative z-[1]">
    <header class="mx-auto mb-8 max-w-[720px] text-center sm:mb-10 lg:mb-14">
      <div class="mb-3 flex items-center justify-center gap-2 sm:mb-4">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]"><?= $h($industry['whyEyebrow'] ?? 'Why Us') ?></span>
      </div>
      <h2 id="industry-why-heading" class="text-[22px] font-bold leading-tight text-[#171717] sm:text-[clamp(1.75rem,4vw,2.5rem)]"><?= $h($industry['whyTitle'] ?? '') ?></h2>
      <p class="mx-auto mt-3 max-w-[560px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px]"><?= $h($industry['whyDescription'] ?? '') ?></p>
    </header>
    <div class="grid grid-cols-1 gap-4 sm:gap-5 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
      <?php foreach (($industry['whyCards'] ?? []) as $card): ?>
        <article class="flex min-h-full flex-col gap-3 rounded-[18px] border border-[rgba(42,77,251,0.08)] bg-white p-4 shadow-[0_18px_40px_rgba(36,36,84,0.06)] sm:rounded-[22px] sm:p-[22px]">
          <?php if (!empty($card['icon'])): ?><span class="inline-flex h-[44px] w-[44px] items-center justify-center rounded-[12px] bg-[#EEF1FF] sm:h-[52px] sm:w-[52px] sm:rounded-[14px]"><img src="<?= $h($card['icon']) ?>" alt="" width="26" height="26" class="h-[22px] w-[22px] object-contain sm:h-[26px] sm:w-[26px]" loading="lazy"></span><?php endif; ?>
          <h3 class="text-[15px] font-bold leading-tight text-[#171717] sm:text-base"><?= $h($card['title'] ?? '') ?></h3>
          <p class="flex-1 text-[13px] leading-relaxed text-[#4D4D4D] sm:text-sm"><?= $h($card['text'] ?? '') ?></p>
          <a href="/contact-us/#contact-id" class="mt-1 inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#2A4DFB] no-underline hover:underline">Get Started <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- Why Choose Section End -->

<!-- Agile Process Section Start -->
<section class="full-bleed bg-white py-10 sm:py-14 lg:py-20" aria-labelledby="agile-process-title" data-agile-process>
  <div class="section-inner">
    <header class="mx-auto mb-8 max-w-[720px] text-center sm:mb-10 lg:mb-12">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">Need it simpler and faster? We have a solution for you!</p>
      <h2 id="agile-process-title" class="mt-3 text-[22px] font-bold leading-tight text-[#171717] sm:mt-4 sm:text-[clamp(1.75rem,4vw,2.75rem)]"><?= $h($industry['agileTitle'] ?? 'Our Agile Development Process') ?></h2>
      <p class="mx-auto mt-3 max-w-[560px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px]"><?= $h($industry['agileSubtitle'] ?? 'Let’s connect with our experienced developers for expert guidance and tailored solutions.') ?></p>
    </header>
    <?php $agileTabs = array_keys($processData); ?>
    <div class="mb-8 flex flex-nowrap justify-start gap-2 overflow-x-auto pb-1 [-ms-overflow-style:none] [scrollbar-width:none] [-webkit-overflow-scrolling:touch] sm:mb-10 sm:gap-2.5 md:flex-wrap md:justify-center md:overflow-visible [&::-webkit-scrollbar]:hidden" role="tablist" aria-label="Agile process phases">
      <?php foreach ($agileTabs as $ti => $tab): ?>
        <button type="button" class="shrink-0 cursor-pointer rounded-full border border-[rgba(42,77,251,0.16)] bg-white px-3.5 py-2 text-[12px] font-semibold text-[#4D4D4D] transition hover:border-[rgba(42,77,251,0.4)] hover:text-[#171717] aria-selected:border-transparent aria-selected:bg-gradient-to-r aria-selected:from-[#2A4DFB] aria-selected:to-[#7A5FF8] aria-selected:text-white aria-selected:shadow-[0_10px_24px_rgba(42,77,251,0.28)] sm:px-5 sm:py-2.5 sm:text-[13px]" role="tab" aria-selected="<?= $ti === 0 ? 'true' : 'false' ?>" data-agile-tab="<?= $h($tab) ?>"><?= $h($tab) ?></button>
      <?php endforeach; ?>
    </div>
    <?php foreach ($agileTabs as $ti => $tab): ?>
      <div role="tabpanel" data-agile-panel="<?= $h($tab) ?>" <?= $ti === 0 ? '' : 'hidden' ?>>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4">
          <?php foreach ($processData[$tab] as $item): ?>
            <article class="flex min-h-full flex-col gap-3 rounded-[16px] border border-[rgba(42,77,251,0.08)] bg-white p-4 shadow-[0_18px_40px_rgba(36,36,84,0.06)] transition hover:-translate-y-1 hover:shadow-[0_22px_48px_rgba(36,36,84,0.1)] sm:rounded-[20px] sm:p-[22px]">
              <span class="inline-flex h-11 w-11 items-center justify-center rounded-[12px] bg-[#EEF1FF] sm:h-12 sm:w-12 sm:rounded-[14px]"><img src="<?= $h($item['icon'] ?? '/images/agile-icon-1.svg') ?>" alt="" width="24" height="24" class="h-5 w-5 object-contain sm:h-6 sm:w-6" loading="lazy"></span>
              <h3 class="text-[14px] font-bold text-[#171717] sm:text-[15px]"><?= $h($item['title'] ?? '') ?></h3>
              <p class="text-[12px] leading-relaxed text-[#4D4D4D] sm:text-[13px]"><?= $h($item['desc'] ?? '') ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:mt-10 sm:flex-row sm:gap-5">
      <a href="/contact-us/#contact-id" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">Let's Connect to Discuss<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
      <a href="/contact-us/#contact-id" class="inline-flex w-fit items-center border-b border-[#00003F] text-[13px] font-semibold text-[#00003F] sm:text-sm">Book a Call</a>
    </div>
  </div>
</section>
<!-- Agile Process Section End -->

<!-- Industries Delivered Section Start -->
<?php
$coreValuesEyebrow = $industry['processEyebrow'] ?? 'Our Process';
$coreValuesTitle = $industry['processTitle'] ?? '';
$coreValuesDescription = $industry['processDescription'] ?? '';
$coreValuesTitleId = 'industry-process-heading';
$iconCycle = ['innovation', 'quality', 'trust', 'customer'];
$processImages = [
  '/images/portfolio-1.png',
  '/images/portfolio-2.png',
  '/images/portfolio-3.png',
  '/images/portfolio-4.png',
  '/images/insight-digital-strategy.jpg',
  '/images/retail-image-5.webp',
];
$processAlts = [
  'Modern building exterior',
  'Contemporary living room',
  'Modern lounge with plants',
  'Contemporary office',
  'Startup team collaborating on digital strategy',
  'Logistics software on tablet in a warehouse',
];
$coreValuesItems = [];
foreach (($industry['processes'] ?? []) as $index => $process) {
  $imgIndex = $index % count($processImages);
  $coreValuesItems[] = [
    'icon' => $iconCycle[$index % count($iconCycle)],
    'title' => $process['title'] ?? '',
    'desc' => $process['desc'] ?? '',
    'image' => $process['image'] ?? $processImages[$imgIndex],
    'alt' => $process['alt'] ?? $processAlts[$imgIndex],
  ];
}
$coreValuesGridClass = $industry['processGridClass'] ?? 'core-values__grid--3';
require __DIR__ . '/core-values-section.php';
?>
<!-- Industries Delivered Section End -->

<!-- FAQ Section Start -->
<section class="full-bleed faq-section faq-section--align !py-10 sm:!py-14 lg:!py-[76px]" aria-labelledby="industry-faq-heading">
  <div class="faq-section__inner section-inner">
    <div class="faq-section__intro min-w-0">
      <p class="faq-section__eyebrow flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">Have questions about our Industry Solutions?</span>
      </p>
      <h2 id="industry-faq-heading" class="mt-3 text-[22px] font-bold leading-tight text-[#171717] sm:text-[clamp(1.75rem,4vw,2.5rem)]">Frequently Ask Question</h2>
      <p class="faq-section__description mt-3 text-[13px] leading-6 text-[#4D4D4D] sm:text-sm">Here are the most asked questions for this industry.</p>
      <a href="/contact-us/#contact-id" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">Start your Project<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
      <img class="faq-section__image" src="/images/faq-gif.gif" alt="" width="640" height="960" loading="lazy">
    </div>
    <div class="faq-list">
      <?php foreach (($industry['faqs'] ?? []) as $index => $faq): ?>
        <?php $n = $index + 1; ?>
        <div class="faq-item<?= $index === 0 ? ' is-open' : '' ?>">
          <button type="button" class="faq-item__summary" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="detail-faq-<?= $n ?>" id="detail-faq-q-<?= $n ?>">
            <span><?= $h($faq['question'] ?? '') ?></span>
            <i class="fa-solid fa-chevron-down faq-item__chevron" aria-hidden="true"></i>
          </button>
          <div class="faq-item__answer" id="detail-faq-<?= $n ?>" role="region" aria-labelledby="detail-faq-q-<?= $n ?>" aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
            <div class="faq-item__answer-inner"><p><?= $h($faq['answer'] ?? '') ?></p></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- FAQ Section End -->

<!-- Final Hero CTA Section Start -->
<?php
  $finalBg = $industry['finalBg'] ?? '/images/consultation-bg.png';
  $hideFinalBgBelowDesktop = ($industry['hideFinalBgBelowDesktop'] ?? false) === true;
  $consultationCardClass = 'consultation-card bg-cover bg-top bg-no-repeat';
  if ($hideFinalBgBelowDesktop) {
    $consultationCardClass .= ' consultation-card--hide-bg-below-desktop';
  } else {
    $consultationCardClass .= ' bg-[url(\'' . $finalBg . '\')]';
  }
?>
<section id="consultation" class="full-bleed consultation-section">
  <div class="section-inner">
    <div
      class="<?= $h($consultationCardClass) ?>"
      <?php if ($hideFinalBgBelowDesktop): ?>style="--consultation-bg: url('<?= $h($finalBg) ?>')"<?php endif; ?>
    >
      <div class="consultation-copy">
        <h2><?= $h($industry['finalTitle'] ?? "Let's Build Your Next Digital Solution with us!") ?></h2>
        <p><?= $h($industry['finalDescription'] ?? '') ?></p>
        <div class="flex flex-col items-start gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4">
          <a href="/contact-us/#contact-id" class="consultation-cta w-fit">Get a Free Quote <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
          <a href="/contact-us/#contact-id" class="consultation-secondary-link inline-flex w-fit items-center border-b border-white/70 text-[13px] font-semibold text-white sm:text-sm">Contact us Today</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Final Hero CTA Section End -->

<!-- Testimonials Section Start -->
<section class="full-bleed testimonial-section relative overflow-hidden bg-[url('/images/testimonial-bg.png')] bg-cover bg-top bg-no-repeat py-12 sm:py-16 lg:py-24" aria-labelledby="industry-testimonials-title">
  <div class="testimonial-layout section-inner relative z-10">
    <div class="testimonial-intro flex flex-col justify-between">
      <div>
        <div class="flex items-center gap-2">
          <span class="h-4 w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">Client Testimonials</span>
        </div>
        <h2 id="industry-testimonials-title" class="mt-3 text-xl font-semibold text-white sm:mt-4 sm:text-2xl">What Our Clients Say</h2>
      </div>
    </div>

    <div class="industry-testimonial-swiper testimonialSwiper swiper w-full">
      <div class="swiper-wrapper">
        <?php foreach ($testimonials as $index => $t): ?>
          <?php
            $name = (string) ($t['name'] ?? '');
            $parts = preg_split('/\s+/', trim($name)) ?: [];
            $initials = '';
            foreach (array_slice($parts, 0, 2) as $part) {
              if ($part !== '') {
                $initials .= strtoupper(substr($part, 0, 1));
              }
            }
            if ($initials === '') {
              $initials = 'SC';
            }
          ?>
          <div class="swiper-slide">
            <article class="testimonial-card flex h-full flex-col justify-between rounded-lg border border-white/10 p-4 sm:p-6">
              <div>
                <span class="text-sm font-bold text-[#2A4DFB]">/<?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <div class="mt-2 text-[18px] tracking-[3px] text-[#FFC107] sm:text-[20px]" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="mt-3 text-[13px] font-medium leading-6 text-[#FAFBFA] sm:mt-4 sm:text-sm"><?= $h($t['quote'] ?? '') ?></p>
              </div>
              <div class="mt-5 flex items-center gap-3 sm:mt-6 sm:gap-4">
                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-gradient-to-br from-[#2A4DFB] to-[#7A5FF8] text-sm font-bold text-white sm:h-14 sm:w-14"><?= $h($initials) ?></span>
                <div class="min-w-0">
                  <h3 class="font-semibold text-white"><?= $h($name) ?></h3>
                  <p class="mt-1 text-[12px] text-[#B1B9DF] sm:text-[13px]"><?= $h($t['role'] ?? '') ?></p>
                </div>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="testimonial-navigation">
      <button class="testimonial-prev" type="button" aria-label="Previous testimonial">
        <i class="fa-solid fa-chevron-left testimonial-prev__mobile" aria-hidden="true"></i>
        <i class="fa-solid fa-chevron-up testimonial-prev__desktop" aria-hidden="true"></i>
      </button>
      <div class="testimonial-pagination" aria-label="Testimonial pagination"></div>
      <button class="testimonial-next" type="button" aria-label="Next testimonial">
        <i class="fa-solid fa-chevron-right testimonial-next__mobile" aria-hidden="true"></i>
        <i class="fa-solid fa-chevron-down testimonial-next__desktop" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</section>
<!-- Testimonials Section End -->

<!-- Latest Insights Section Start -->
<section class="full-bleed articles-insights relative overflow-hidden bg-[url('/images/blog-bg.png')] bg-cover bg-top bg-no-repeat py-10 sm:py-14 lg:py-18" aria-labelledby="industry-insights-title">
  <div class="articles-insights__inner section-inner">
    <header class="portfolio-showcase__header">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">Blogs &amp; Insights</p>
      <h2 id="industry-insights-title" class="mt-3 text-[20px] font-semibold leading-tight text-[#171717] sm:mt-4 sm:leading-[36px] lg:text-[24px]">Explore Our Insights</h2>
      <p class="mx-auto mt-2 max-w-[690px] text-[13px] leading-6 text-[#4D4D4D] sm:text-[14px] sm:leading-[24px]">Get in touch with industry trends with our updated blogs from technology and development experts.</p>
    </header>
    <div class="mt-8 grid grid-cols-1 gap-5 sm:mt-10 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($sampleInsights as $article): ?>
        <article class="articles-card">
          <figure class="articles-card__image"><img src="<?= $h($article[5]) ?>" alt="<?= $h($article[3]) ?>" width="1024" height="683" loading="lazy"></figure>
          <div class="articles-card__body">
            <div class="articles-card__meta">
              <span class="articles-card__byline">Suave Creators</span>
              <time datetime="<?= $h($article[2]) ?>"><?= $h($article[1]) ?></time>
            </div>
            <h3><?= $h($article[3]) ?></h3>
            <p><?= $h($article[4]) ?></p>
            <a class="articles-card__link underline mt-2 text-sm font-semibold text-[#2A4DFB]" href="/blog/<?= $h($article[6]) ?>">Read More</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="mt-8 flex justify-center sm:mt-10">
      <a href="/blogs" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">View All Blogs<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
    </div>
  </div>
</section>
<!-- Latest Insights Section End -->

<style>
  /* Why Us: mobile-friendly background (avoid cover crop on tall stacked cards) */
  .industry-why-section__bg {
    background-color: #F8FAFC;
    background-image: url('/images/background_about.png');
    background-position: top center;
    background-repeat: no-repeat;
    background-size: 100% auto;
    inset: 0;
    pointer-events: none;
    position: absolute;
    z-index: 0;
  }

  @media (min-width: 768px) {
    .industry-why-section__bg {
      background-position: top center;
      background-size: cover;
    }
  }

  /* Industry detail services: no icon backgrounds, larger icons, shared blue hover */
  .industry-detail-services .web-service-card__icon,
  .industry-detail-services .web-service-card__icon--blue,
  .industry-detail-services .web-service-card__icon--orange,
  .industry-detail-services .web-service-card__icon--cyan,
  .industry-detail-services .web-service-card__icon--mint,
  .industry-detail-services .web-service-card__icon--rose,
  .industry-detail-services .web-service-card__icon--amber {
    background: transparent !important;
    border: 0 !important;
    border-radius: 0;
    height: auto;
    margin-bottom: 12px;
    padding: 0;
    width: auto;
  }

  .industry-detail-services .web-service-card__icon img {
    display: block;
    height: 36px;
    object-fit: contain;
    width: 36px;
  }

  .industry-detail-services .web-service-card,
  .industry-detail-services .web-service-card:nth-child(n) {
    --web-service-accent: #315DE3;
  }

  .industry-detail-services .web-service-card::before {
    background: #315DE3;
  }

  .industry-detail-services .web-service-card::after {
    background: #E8EBFF;
    opacity: 0;
  }

  .industry-detail-services .web-service-card:hover,
  .industry-detail-services .web-service-card:focus-within {
    background: #E8EBFF;
  }

  .industry-detail-services .web-service-card:hover::before,
  .industry-detail-services .web-service-card:focus-within::before {
    width: 100%;
  }

  .industry-detail-services .web-service-card:hover::after,
  .industry-detail-services .web-service-card:focus-within::after {
    opacity: 1;
  }

  /* Industry detail: mobile + tablet polish */
  @media (max-width: 1023px) {
    main {
      overflow-x: clip;
    }

    .industry-detail-services .web-service-card {
      min-height: 0;
      padding: 20px 18px 22px;
    }
  }

  @media (max-width: 767px) {
    main .u-btn-cta,
    main a.rounded-full.bg-gradient-to-r,
    main .consultation-cta {
      box-sizing: border-box;
      height: 34px !important;
      min-height: 34px !important;
      padding-block: 0 !important;
      width: fit-content !important;
      max-width: 100%;
    }

    /* Text links (no fill): size to label, not full row */
    main a.border-b,
    main .consultation-secondary-link {
      display: inline-flex;
      width: fit-content !important;
      max-width: 100%;
    }

    .industry-detail-services .web-service-card__icon img {
      height: 32px;
      width: 32px;
    }

    .industry-detail-services .web-service-card {
      padding: 18px 16px 20px;
    }
  }

  @media (min-width: 768px) {
    .industry-detail-services .web-service-card__icon img {
      height: 40px;
      width: 40px;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof Swiper !== 'undefined' && document.querySelector('.industry-testimonial-swiper')) {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    new Swiper('.industry-testimonial-swiper', {
      direction: window.matchMedia('(min-width: 1024px)').matches ? 'vertical' : 'horizontal',
      slidesPerView: 1,
      spaceBetween: 16,
      loop: true,
      speed: 700,
      watchOverflow: true,
      autoplay: reduceMotion ? false : { delay: 4500, disableOnInteraction: false, pauseOnMouseEnter: true },
      navigation: { nextEl: '.testimonial-next', prevEl: '.testimonial-prev' },
      pagination: {
        el: '.testimonial-pagination',
        clickable: true
      },
      breakpoints: { 1024: { slidesPerView: 2, spaceBetween: 24 } }
    });
  }

  var agileRoot = document.querySelector('[data-agile-process]');
  if (agileRoot) {
    var tabs = agileRoot.querySelectorAll('[data-agile-tab]');
    var panels = agileRoot.querySelectorAll('[data-agile-panel]');
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        var key = tab.getAttribute('data-agile-tab');
        tabs.forEach(function (t) {
          var on = t === tab;
          t.setAttribute('aria-selected', on ? 'true' : 'false');
        });
        panels.forEach(function (p) {
          var on = p.getAttribute('data-agile-panel') === key;
          if (on) p.removeAttribute('hidden'); else p.setAttribute('hidden', '');
        });
      });
    });
  }

  var faqItems = document.querySelectorAll('.faq-list .faq-item');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
  function setAria(item, open) {
    item.querySelector('.faq-item__summary').setAttribute('aria-expanded', open ? 'true' : 'false');
    item.querySelector('.faq-item__answer').setAttribute('aria-hidden', open ? 'false' : 'true');
  }
  function openFaq(item) {
    var a = item.querySelector('.faq-item__answer');
    item.classList.add('is-open'); setAria(item, true);
    if (reduce.matches) { a.style.height = 'auto'; return; }
    a.style.height = a.getBoundingClientRect().height + 'px'; a.offsetHeight;
    a.style.height = a.scrollHeight + 'px';
    a.addEventListener('transitionend', function once(e) {
      if (e.propertyName === 'height' && item.classList.contains('is-open')) { a.style.height = 'auto'; a.removeEventListener('transitionend', once); }
    });
  }
  function closeFaq(item) {
    var a = item.querySelector('.faq-item__answer');
    if (reduce.matches) { item.classList.remove('is-open'); setAria(item, false); a.style.height = '0px'; return; }
    a.style.height = (a.style.height === 'auto' ? a.scrollHeight : a.getBoundingClientRect().height) + 'px';
    a.offsetHeight; item.classList.remove('is-open'); setAria(item, false);
    requestAnimationFrame(function () { a.style.height = '0px'; });
  }
  faqItems.forEach(function (item) {
    var a = item.querySelector('.faq-item__answer');
    var open = item.classList.contains('is-open');
    a.style.transition = 'none'; a.style.height = open ? 'auto' : '0px'; setAria(item, open);
  });
  if (faqItems.length) faqItems[0].offsetHeight;
  faqItems.forEach(function (item) {
    var a = item.querySelector('.faq-item__answer');
    a.style.removeProperty('transition');
    item.querySelector('.faq-item__summary').addEventListener('click', function () {
      var should = !item.classList.contains('is-open');
      faqItems.forEach(function (s) { if (s !== item && s.classList.contains('is-open')) closeFaq(s); });
      if (should) openFaq(item); else closeFaq(item);
    });
  });
});
</script>

<style>
.agile-process-tabs {
  margin-bottom: 2.5rem;
  overflow: hidden;
  width: 100%;
}

.agile-process-tabs__list {
  align-items: center;
}

.agile-process-tabs__slide {
  height: auto;
  width: auto;
}

.agile-process-tabs__tab {
  white-space: nowrap;
}

.agile-process-tabs__pagination {
  align-items: center;
  display: flex;
  gap: 10px;
  justify-content: center;
  margin-top: 14px;
}

.agile-process-tabs__pagination .swiper-pagination-bullet {
  background: transparent;
  border: 1.5px solid #00003f;
  border-radius: 999px;
  height: 8px;
  margin: 0 !important;
  opacity: 1;
  transition: background-color 0.2s ease, border-color 0.2s ease;
  width: 8px;
}

.agile-process-tabs__pagination .swiper-pagination-bullet-active {
  background: #00003f;
  border-color: #00003f;
}

@media (min-width: 768px) {
  .agile-process-tabs {
    overflow: visible;
  }

  .agile-process-tabs__list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    transform: none !important;
  }

  .agile-process-tabs__slide {
    margin: 0 !important;
    width: auto !important;
  }

  .agile-process-tabs__pagination {
    display: none !important;
  }
}
</style>

<?php
require __DIR__ . '/../layout/end.php';
