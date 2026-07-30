<?php
$pageTitle = 'Industry Solutions | Suave Creators';
$pageDescription = 'Industry-specific web design, software, and AI solutions for finance, healthcare, education, retail, logistics, and more.';
$useHeroBackground = true;
require __DIR__ . '/layout/start.php';

$h = static function ($v): string {
  return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
};

$blogPosts = require __DIR__ . '/data/blogs/posts.php';
$latestPosts = array_slice($blogPosts, 0, 4);
?>

<!-- 1. Hero Section (IndustryBanner) Start -->
<section
  class="relative z-10 w-full overflow-x-clip pb-10 pt-6 sm:pb-12 sm:pt-8 md:pb-16 md:pt-10 lg:min-h-[640px] lg:pb-20 lg:pt-[52px] site-container">
  <div class="grid grid-cols-1 items-center gap-8 sm:gap-10 lg:grid-cols-2 lg:gap-12">
    <div class="relative z-0 order-2 flex max-w-xl min-w-0 flex-col text-left lg:order-1 lg:max-w-[560px]">
      <p
        class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[11px] font-bold uppercase tracking-wide text-transparent pragati-narrow-regular sm:text-sm">
        Finance • Healthcare • Retail • Education • Logistics
      </p>
      <h1
        class="mb-2 mt-1 flex flex-col text-[28px] font-semibold leading-[1.05] text-white min-[375px]:text-[34px] sm:mt-2 sm:text-5xl lg:text-[56px] lg:leading-[100%]">
        <span
          class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text font-extrabold text-transparent">
          Industry-Specific
        </span>
        <span>Web Design, Software</span>
        <span>&amp; AI Solutions</span>
      </h1>
      <p class="mb-2 mt-2 text-[13px] leading-6 text-[#B1B9DF] sm:text-sm">
        Industry solutions are the need of every business nowadays. Our focus industries include financial services,
        healthcare, logistics, retail, and education. We transform operations with solutions designed to enhance customer
        interactions and automate CRM with cost-effective development services.
      </p>
      <div class="mt-6 flex flex-col items-stretch gap-3 sm:mt-8 sm:flex-row sm:items-center sm:gap-7">
        <a href="/contact-us/#contact-id"
          class="u-btn-cta group inline-flex h-[34px] min-h-[34px] items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-[36px] sm:min-h-[36px] sm:justify-start sm:px-5 sm:py-0 sm:text-sm">
          <span class="sm:hidden">Start Your Solution</span>
          <span class="hidden sm:inline">Start Your Custom Industry Solution</span>
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
            <path d="M18 8L22 12L18 16" />
            <path d="M2 12H22" />
          </svg>
        </a>
        <a href="#industry-expertise"
          class="inline-flex items-center justify-center border-b border-white/70 text-[13px] font-semibold text-white sm:justify-start sm:text-sm">
          Explore industries
        </a>
      </div>
    </div>

    <div class="relative z-10 order-1 mx-auto flex w-full max-w-[360px] min-w-0 items-center justify-center sm:max-w-[420px] lg:order-2 lg:mx-0 lg:max-w-none lg:justify-end">
      <div class="industry-hero-visual" aria-hidden="true">
        <img src="/images/industry-left.webp" alt="" class="industry-hero-visual__half industry-hero-visual__half--left" width="320" height="520" loading="eager">
        <img src="/images/industry-right.webp" alt="" class="industry-hero-visual__half industry-hero-visual__half--right" width="320" height="520" loading="eager">
        <div class="industry-hero-visual__caption hidden sm:block">
          <p>Building</p>
          <p>Outstanding</p>
          <p>Design &amp;</p>
          <p>Development</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- 1. Hero Section End -->

<!-- 2. Portfolio Showcase Marquee Section Start -->
<?php
$portfolioHeroImages = [
  '/images/portfolioimg1.webp',
  '/images/portfolioimg2.webp',
  '/images/portfolioimg3.webp',
  '/images/portfolioimg4.webp',
  '/images/portfolioimg5.webp',
  '/images/portfolioimg6.webp',
];
?>
<section class="full-bleed full-bleed--edge portfolio-showcase portfolio-hero-showcase overflow-hidden bg-[linear-gradient(180deg,#F8FAFF_0%,#FFFFFF_100%)] !py-8 sm:!py-10 md:!py-14" aria-label="Our recent work">
  <div class="industry-portfolio-marquee" tabindex="0">
    <div class="industry-portfolio-marquee__track">
      <?php for ($group = 0; $group < 2; $group++): ?>
        <div class="industry-portfolio-marquee__group"<?= $group === 1 ? ' aria-hidden="true"' : '' ?>>
          <?php foreach ($portfolioHeroImages as $i => $shot): ?>
            <figure class="portfolio-showcase__image industry-portfolio-marquee__item">
              <img src="<?= $h($shot) ?>" alt="<?= $group === 0 ? 'Suave Creators project showcase ' . ($i + 1) : '' ?>" loading="lazy">
            </figure>
          <?php endforeach; ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>
  <div class="section-inner">
    <div class="mt-8 flex flex-wrap items-center justify-center gap-4 sm:mt-10 sm:gap-5">
      <a href="/contact-us/#contact-id"
        class="u-btn-cta group inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-[36px] sm:min-h-[36px] sm:px-5 sm:py-0 sm:text-sm">
        Start your Project
        <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
          <path d="M18 8L22 12L18 16" />
          <path d="M2 12H22" />
        </svg>
      </a>
      <a href="/contact-us/#contact-id" class="border-b border-[#00003F] text-[13px] font-semibold text-[#00003F] sm:text-sm">Book a Call</a>
    </div>
  </div>
</section>
<!-- 2. Portfolio Showcase Marquee Section End -->

<!-- 3. Intro CTA Section Start -->
<section class="full-bleed bg-[url('/images/core-bg.png')] bg-cover bg-top bg-no-repeat py-10 sm:py-14 lg:py-20" aria-labelledby="industry-intro-title">
  <div class="section-inner text-center">
    <div class="mx-auto flex max-w-[1000px] flex-col items-center px-1">
      <div class="mb-3 flex items-center justify-center gap-2 sm:mb-4">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span
          class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
          Let's get work together
        </span>
      </div>
      <h2 id="industry-intro-title"
        class="text-[22px] font-bold leading-tight text-[#171717] sm:text-[28px] lg:text-[clamp(1.75rem,4vw,2.75rem)]">
        Building Smart Designs with <span
          class="bg-[linear-gradient(180deg,_#2F69FB_12%,_#C56BFF_100%)] bg-clip-text text-transparent">Powerful Back-Ends</span>
      </h2>
      <p class="mx-auto mt-3 max-w-[580px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px]">
        We believe in delivering visually stunning and superior web experiences that boost brands and drive long-term
        performance.
      </p>
      <div class="mt-6 flex w-full flex-col items-center justify-center gap-4 sm:mt-8 sm:w-auto sm:flex-row sm:gap-5">
        <a href="tel:+918894900142"
          class="u-btn-cta group inline-flex h-[34px] min-h-[34px] w-full max-w-[320px] items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-[36px] sm:min-h-[36px] sm:w-auto sm:max-w-none sm:px-5 sm:py-0 sm:text-sm">
          <span class="sm:hidden">Discuss Your Project</span>
          <span class="hidden sm:inline">Discuss Your Project Requirements</span>
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
            <path d="M18 8L22 12L18 16" />
            <path d="M2 12H22" />
          </svg>
        </a>
        <a href="/contact-us/#contact-id" class="border-b border-[#00003F] text-[13px] font-semibold text-[#00003F] sm:text-sm">
          Schedule a discovery call
        </a>
      </div>
    </div>
  </div>
</section>
<!-- 3. Intro CTA Section End -->
 
<!-- 6. Work With Us (Smart Together CTA) Section Start -->
<section class="full-bleed smart-together-cta py-4 sm:py-6" aria-labelledby="industry-cta-title">
  <div class="smart-together-cta__inner section-inner">
    <div class="mb-3 flex items-center gap-2 sm:mb-4">
      <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
      <span
        class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold leading-[100%] text-transparent sm:text-[14px]">
        Ready to Start Your Project?
      </span>
    </div>

    <div class="smart-together-cta__copy">
      <h2 id="industry-cta-title">Kickstart Your Dream Project With Us</h2>
      <p>With our best industry solution development services, we take ownership of your solution and process, so you
        never feel alone on your journey. Let's collaborate with us for your next software solution.</p>
    </div>

    <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:gap-3">
      <a href="/contact-us/#contact-id"
        class="u-btn-cta group inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-[36px] sm:min-h-[36px] sm:px-5 sm:py-0 sm:text-sm">
        <span class="sm:hidden">Start Your Vision</span>
        <span class="hidden sm:inline">Turn Your Vision Into Reality</span>
        <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
          <path d="M18 8L22 12L18 16"></path>
          <path d="M2 12H22"></path>
        </svg>
      </a>
      <a href="/contact-us/#contact-id"
        class="inline-flex items-center border-b border-white/70 text-[13px] font-semibold text-white sm:text-sm">
        Discuss your Vision
      </a>
    </div>

    <span class="smart-together-cta__phone" aria-hidden="true">
      <img src="/images/phone.gif" alt="" class="rounded-[10px]" />
    </span>
  </div>
</section>
<!-- 6. Work With Us Section End -->

<!-- 5. AI Solutions Section Start -->
<section
  class="full-bleed overflow-hidden bg-[#F9FAFC] bg-[url('/images/blog-bg.png')] bg-cover bg-top bg-no-repeat"
  aria-labelledby="ai-solutions-title">
  <div class="section-inner relative z-10 py-10 sm:py-16 lg:py-[86px]">
    <div class="mx-auto max-w-[720px] text-center">
      <p
        class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Services
      </p>
      <h2 id="ai-solutions-title"
        class="mt-3 text-[20px] font-semibold leading-tight tracking-[-0.025em] text-[#171717] sm:mt-4 sm:text-[22px] lg:text-[24px]">
        Our Core Services — Smart Tech Solutions for the AI Revolution
      </h2>
      <p class="mx-auto mt-3 max-w-[605px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px] sm:leading-[24px]">
        As a top-tier company, we offer industry-specific software solutions with a proven track record of delivering the
        latest future trends and innovative solutions.
      </p>
    </div>

    <?php
    $aiSolutions = [
      [
        'IT & Software Solutions for Startups',
        'Suave Creators collaborate with IT startups worldwide, providing IT solutions & services to build, boost, and scale products across industries.',
        '/images/ai-service-1.webp',
        ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
        '/industries/it-software-solutions-for-startups',
      ],
      [
        'Healthcare Software Development',
        'Our Healthcare Software Development Services cover designing and developing software for better hospital management and improved efficiency.',
        '/images/ai-service-2.webp',
        ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
        '/industries/healthcare',
      ],
      [
        'Education & E-learning Platforms',
        'We create end-to-end custom e-learning platforms with digital resources and tools that make education systems easier to manage.',
        '/images/ai-service-3.webp',
        ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
        '/industries/education-elearning-platforms',
      ],
      [
        'Retail & E-commerce Solutions',
        'We offer end-to-end retail & e-commerce software solutions with expert knowledge across all stages of the business cycle.',
        '/images/ai-service-4.webp',
        ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
        '/industries/retail-ecommerce-solutions',
      ],
      [
        'Finance & Banking Software Development',
        'We provide software development for the financial and banking sector, focusing on custom web and mobile apps for startups and enterprises.',
        '/images/ai-service-5.webp',
        ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
        '/industries/finance-banking-software-development',
      ],
      [
        'Logistics & Supply Chain Apps',
        'We specialise in logistics and transportation management applications that enhance overall operational efficiency.',
        '/images/ai-service-6.webp',
        ['AI Web design', 'UX Research', 'AI Figma Design', 'AI Visual Design'],
        '/industries/logistics-supply-chain-apps',
      ],
    ];
    ?>

    <div class="industryCoreServicesSwiper swiper mt-10 sm:mt-12 lg:mt-[54px]">
      <div class="swiper-wrapper">
        <?php foreach ($aiSolutions as $service): ?>
          <div class="swiper-slide h-auto">
            <a href="<?= htmlspecialchars($service[4]) ?>" class="industry-service-card h-full !shadow-none">
              <h3><?= htmlspecialchars($service[0]) ?></h3>
              <p><?= htmlspecialchars($service[1]) ?></p>
              <div class="industry-service-card__tags">
                <?php foreach ($service[3] as $tag): ?>
                  <span><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
              </div>
              <figure class="industry-service-card__image">
                <img src="<?= htmlspecialchars($service[2]) ?>" alt="<?= htmlspecialchars($service[0]) ?>" width="640"
                  height="420" loading="lazy">
              </figure>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="mt-8 flex flex-col items-center gap-5 sm:mt-10 md:flex-row md:items-center md:justify-between">
      <div class="industry-core-services-controls hidden gap-2 md:flex">
        <button class="industry-core-services-prev offerings-control" type="button" aria-label="Previous service">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="industry-core-services-next offerings-control" type="button" aria-label="Next service">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="industry-core-services-pagination flex md:hidden" aria-label="Core services pagination"></div>
      <div class="flex w-full flex-col items-center gap-4 md:ml-auto md:w-auto md:flex-row md:justify-end md:gap-5">
        <a href="/contact-us/#contact-id"
          class="u-btn-cta group inline-flex h-[34px] min-h-[34px] w-full max-w-[320px] items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-[36px] sm:min-h-[36px] sm:w-auto sm:max-w-none sm:px-5 sm:py-0 sm:text-sm">
          <span class="sm:hidden">Talk to Experts</span>
          <span class="hidden sm:inline">Speak With Our Industry Tech Experts</span>
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
            <path d="M18 8L22 12L18 16" />
            <path d="M2 12H22" />
          </svg>
        </a>
        <a href="/services" class="border-b border-[#00003F] text-[13px] font-semibold text-[#00003F] sm:text-sm">
          Explore Our Industry Solutions
        </a>
      </div>
    </div>
  </div>
</section>
<!-- 5. AI Solutions Section End -->


<!-- 7. Industry Expertise Section Start -->
<?php
$expertiseIndustries = [
  [
    'Finance',
    'We Develop Smart Finance Solutions',
    'Get a smart AI solution with us; we develop smart Finance and Banking solutions for all smart or large organisations. We have the solution for you.',
    ['Fintech Design', 'App Development', 'Banking UX', 'Wealth Branding'],
    '/images/finance-banner.webp',
    'fa-solid fa-building-columns',
  ],
  [
    'Education',
    'Empowering Learning Through Digital Innovation',
    'We transform traditional education into AI tech and digital experience. From e-Learning to virtual classrooms, we create smart solutions for all educational institutions and organisations.',
    ['E-learning', 'Portal Design', 'Course Branding', 'LMS Integration'],
    '/images/education-banner.webp',
    'fa-solid fa-graduation-cap',
  ],
  [
    'Real Estate',
    'Building Digital Foundations for Real Estate Success',
    'Let\'s drive more sales and strong visibility with smart websites and property management software. Our software connects buyers with their dream home.',
    ['RE Branding', 'CRE Branding', 'RE Website Design', 'RE Fund Luxury Branding', 'RE Development', 'RE Agent Solutions'],
    '/images/insight-future-work.jpg',
    'fa-solid fa-house',
  ],
  [
    'Healthcare',
    'Transform hospital care with smart AI Solutions',
    'A smart solution is served for the hospital and healthcare institutions. With our software, you streamline operations, refine patient experience, and secure telehealth platforms.',
    ['Clinic Branding', 'Telemedicine', 'Healthcare UX', 'SEO for Doctors'],
    '/images/industry-healthcare.jpg',
    'fa-solid fa-heart-pulse',
  ],
  [
    'E-commerce',
    'Enjoy the best Shopping experience',
    'Our professional, skilled team provides custom eCommerce solutions that integrate seamlessly with existing systems and offer valuable data for optimisation.',
    ['UI/UX', 'Shopify', 'SEO', 'Performance Marketing'],
    '/images/e-commerece-banner.webp',
    'fa-solid fa-cart-shopping',
  ],
  [
    'Technology & Startups',
    'Reliable and Scalable solution for Technology',
    'We deliver scalable tech solutions to build smart, robust and future-ready custom smart solutions. We develop digital products for your business or organisation.',
    ['MVP Design', 'Brand Identity', 'Pitch Deck Design', 'Product Strategy'],
    '/images/it-banner.webp',
    'fa-solid fa-rocket',
  ],
];
$expertiseDefault = 0;
?>
<section id="industry-expertise"
  class="full-bleed expertise-showcase-section relative overflow-hidden bg-[#070B1F] py-10 sm:py-14 lg:py-24"
  aria-labelledby="industry-expertise-title">
  <div class="expertise-showcase-section__glow" aria-hidden="true"></div>
  <div class="section-inner relative z-[1]">
    <header class="mb-6 max-w-[720px] sm:mb-10 lg:mb-14">
      <div class="mb-3 flex items-center gap-2 sm:mb-4">
        <span class="inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]" aria-hidden="true"></span>
        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-none text-transparent">
          Our Industry Expertise
        </span>
      </div>
      <h2 id="industry-expertise-title"
        class="text-[22px] font-bold leading-tight tracking-[-0.03em] text-white sm:text-[32px] lg:text-[40px]">
        Crafting Digital Solutions that Drive Success
      </h2>
      <p class="mt-3 max-w-[560px] text-[13px] leading-6 text-[#B1B9DF] sm:mt-4 sm:text-[14px]">
        By adding values to your business we always give the best solution for all types of businesses.
      </p>
    </header>

    <div class="expertise-showcase" data-industry-expertise>
      <ul class="expertise-showcase__tabs" role="tablist" aria-label="Industry expertise">
        <?php foreach ($expertiseIndustries as $index => $industry): ?>
          <li role="presentation">
            <button type="button"
              class="expertise-showcase__tab<?= $index === $expertiseDefault ? ' is-active' : '' ?>"
              role="tab"
              id="expertise-tab-<?= $index + 1 ?>"
              aria-selected="<?= $index === $expertiseDefault ? 'true' : 'false' ?>"
              aria-controls="expertise-panel-<?= $index + 1 ?>"
              data-expertise-index="<?= $index ?>">
              <span class="expertise-showcase__tab-index" aria-hidden="true"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="expertise-showcase__tab-icon" aria-hidden="true">
                <i class="<?= htmlspecialchars($industry[5]) ?>"></i>
              </span>
              <span class="expertise-showcase__tab-label"><?= htmlspecialchars($industry[0]) ?></span>
            </button>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="expertise-showcase__stage">
        <?php foreach ($expertiseIndustries as $index => $industry): ?>
          <div class="expertise-showcase__panel<?= $index === $expertiseDefault ? ' is-active' : '' ?>"
            role="tabpanel"
            id="expertise-panel-<?= $index + 1 ?>"
            aria-labelledby="expertise-tab-<?= $index + 1 ?>"
            <?= $index === $expertiseDefault ? '' : 'hidden' ?>
            data-expertise-panel="<?= $index ?>">
            <figure class="expertise-showcase__media">
              <img
                src="<?= htmlspecialchars($industry[4]) ?>"
                alt="<?= htmlspecialchars($industry[0]) ?> industry expertise"
                width="960"
                height="640"
                loading="lazy"
                decoding="async">
              <span class="expertise-showcase__media-shade" aria-hidden="true"></span>
              <span class="expertise-showcase__media-badge">
                <i class="<?= htmlspecialchars($industry[5]) ?>" aria-hidden="true"></i>
                <?= htmlspecialchars($industry[0]) ?>
              </span>
            </figure>

            <div class="expertise-showcase__copy">
              <div class="expertise-showcase__tags">
                <?php foreach ($industry[3] as $tag): ?>
                  <span><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
              </div>
              <h3><?= htmlspecialchars($industry[1]) ?></h3>
              <p><?= htmlspecialchars($industry[2]) ?></p>
              <a href="/contact-us/#contact-id"
                class="u-btn-cta group mt-5 inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white transition hover:brightness-110 sm:mt-6 sm:h-[36px] sm:min-h-[36px] sm:px-5 sm:py-0 sm:text-sm">
                Get a Free Project Roadmap
                <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
                  <path d="M18 8L22 12L18 16" />
                  <path d="M2 12H22" />
                </svg>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<!-- 7. Industry Expertise Section End -->

<!-- 9. Why Suave Creators (Core Services) Section Start -->
<section class="full-bleed web-services bg-[url('/images/dev-bg.png')] bg-cover bg-top bg-no-repeat py-10 sm:py-14 lg:py-20"
  aria-labelledby="why-suave-title">
  <div class="web-services__inner section-inner">
    <header class="web-services__header">
      <div class="mb-3 flex items-center gap-2 sm:mb-4">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span
          class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
          SUAVE CREATORS
        </span>
      </div>
      <div class="web-services__intro">
        <h2 id="why-suave-title" class="mb-3 text-[20px] font-semibold leading-tight text-[#171717] sm:mb-4 sm:text-[22px] lg:text-[24px]">
          Why Suave Creators is Your Go-To for IT Web Design and Development
        </h2>
        <p class="text-[13px] leading-6 text-[#4D4D4D] sm:text-[14px]">
          Industry-focused software, design, and support built around your business goals.
        </p>
      </div>
    </header>

    <?php
    $whySuaveServices = [
      ['industry-goals.svg', '01 - Goals', 'Industry Goals', 'All businesses, whether small or large, have unique challenges; that\'s why we begin by working deep into your industry-specific objectives. Our mission is to build strong software solutions that reflect your individuality and growth ambitions.', 'blue'],
      ['industry-specific-solutions.svg', '02 - Solutions', 'Industry-Specific Solutions', 'We believe in delivering industry-specific solutions in today\'s fast-changing landscape. We work on global technology and groundbreaking innovations to provide future-ready blends for all types of industries.', 'orange'],
      ['industry-user-centric-design.svg', '03 - Design', 'User-Centric Design', 'Our software design ideology revolves around creating the best software that is visually appealing, intuitive, and easy to manage. You will enjoy a smooth workflow and a great user experience.', 'cyan'],
      ['evaluating-industry-software.svg', '04 - Build', 'Constructing Industry Softwares', 'With our professional team, we meticulously design and implement each part of your solution with unmatched precision. Our testing phase gives you a guarantee for a seamless, scalable and effective software system.', 'mint'],
      ['customer-support-ticketing.svg', '05 - Support', 'Customer Support & Ticketing', 'Our professional support team will track support tickets and help you to organize everything and be on time. With this, our team can provide reliable and professional support at all times.', 'rose'],
      ['industry-multi-channel-communication.svg', '06 - Connect', 'Multi-Channel Communication', 'Our team will give you support through your preferred channels, including social media, live chat support, or email. Giving communication options is one of the best options ever.', 'amber'],
    ];
    ?>

    <div class="web-services__grid industry-why-services">
      <?php foreach ($whySuaveServices as $service): ?>
        <article class="web-service-card web-service-card--<?= htmlspecialchars($service[4]) ?>">
          <span class="web-service-card__icon web-service-card__icon--<?= htmlspecialchars($service[4]) ?>">
            <img src="/images/<?= htmlspecialchars($service[0]) ?>" alt="<?= htmlspecialchars($service[2]) ?>" width="28"
              height="28">
          </span>

          <div class="web-service-card__category">
            <span class="text-[10px] font-semibold uppercase leading-[100%] text-[#4D4D4D]">
              <?= htmlspecialchars($service[1]) ?>
            </span>
            <div class="flex items-center justify-between">
              <h3 class="mt-2 text-[14px] font-semibold leading-[100%] text-[#171717]">
                <?= htmlspecialchars($service[2]) ?>
              </h3>
              <svg xmlns="https://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M18 8L22 12L18 16" />
                <path d="M2 12H22" />
              </svg>
            </div>
          </div>

          <p class="mt-1 text-[14px] text-[#4D4D4D]"><?= htmlspecialchars($service[3]) ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="web-services__footer">
      <a href="/services/">See All Services</a>
    </div>
  </div>
</section>
<!-- 9. Why Suave Creators Section End -->

<!-- 10. Process Section Start -->
<?php
$coreValuesEyebrow = 'Our Process';
$coreValuesTitle = 'Turning Vision into Reality';
$coreValuesDescription = 'We follow a collaborative and step by step process to built your ideas into digital product.';
$coreValuesTitleId = 'industry-process-title';
$coreValuesGridClass = 'core-values__grid--3';
$coreValuesItems = [
  ['icon' => 'discovery', 'title' => 'Discovery & Strategy', 'desc' => 'We understand your goals and challenges and then work on the discovery and strategy stage. By understanding your goals we make a clear product roadmap.', 'image' => '/images/portfolio-1.png', 'alt' => 'Discovery and strategy planning session'],
  ['icon' => 'design', 'title' => 'Design & Development', 'desc' => 'Our skilled team understands the roadmap and works on the design and development stage. We turn your ideas into robust functionalities.', 'image' => '/images/portfolio-2.png', 'alt' => 'Design and development workspace'],
  ['icon' => 'launch', 'title' => 'Launch & Growth', 'desc' => 'Once your product is live, we continue to optimize, scale, and enhance it. A long term growth is provided from our end.', 'image' => '/images/portfolio-3.png', 'alt' => 'Product launch and growth metrics'],
];
require __DIR__ . '/partials/core-values-section.php';
?>
<!-- 10. Process Section End -->



<!-- 12. FAQ Section Start -->
<section class="full-bleed faq-section faq-section--align faq-section--desktop-media" aria-labelledby="industry-faq-heading">
  <div class="faq-section__inner section-inner">
    <div class="faq-section__intro">
      <p class="faq-section__eyebrow flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">
          Have questions about our Industry Solutions?
        </span>
      </p>
      <h2 id="industry-faq-heading">Frequently Ask Question</h2>
      <p class="faq-section__description">Here are the most asked questions about industry software and digital solutions.</p>
      <a href="/contact-us/#contact-id"
        class="u-btn-cta group inline-flex h-[34px] min-h-[34px] w-fit max-w-full shrink-0 items-center gap-2 self-start rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-[36px] sm:min-h-[36px] sm:px-5 sm:py-0 sm:text-sm">
        Start your Project
        <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="transition-transform duration-300 group-hover:translate-x-1">
          <path d="M18 8L22 12L18 16"></path>
          <path d="M2 12H22"></path>
        </svg>
      </a>
      <img class="faq-section__image" src="/images/faq-gif.gif" alt="Business team collaborating around a table"
        width="640" height="960" loading="lazy">
    </div>

    <?php
    $faqs = [
      [
        'What is the key driver of the global software market?',
        'The software development industry\'s growth complicates the task of operating a business in changing winds. At the same time, however, a zest for serving the audience\'s needs in a new and better way is the key driver of new projects\' appearance.',
      ],
      [
        'How big is the software development industry these days?',
        'According to the latest updates, the global developer market shows a balanced increase from 26.5 million to 28.7 million specialists.',
      ],
      [
        'What is the biggest software market for the time being?',
        'Enterprise software is the one that owns the largest share of the overall software market projects. Translating this statement into numbers, in 2021, it made over $200bn in revenue, despite COVID-19 and economic fluctuations.',
      ],
      [
        'Why is the industry of software development so important worldwide?',
        'Software development is important globally because of its scalability. The new and upgraded software increases productivity and reduces labour costs at once.',
      ],
      [
        'Do you offer post-launch support and maintenance?',
        'Yes, of course, we always do post-launch support and maintenance as per the client\'s requirements.',
      ],
      [
        'Why should we choose Suave Creators for our digital projects?',
        'Suave Creators is a team of young talent who always work under timelines and deliver the best possible results.',
      ],
    ];
    ?>
    <div class="faq-list">
      <?php foreach ($faqs as $index => $faq): ?>
        <?php $faqNumber = $index + 1; ?>
        <div class="faq-item<?= $index === 0 ? ' is-open' : '' ?>">
          <button type="button" class="faq-item__summary" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>"
            aria-controls="industry-faq-answer-<?= $faqNumber ?>" id="industry-faq-question-<?= $faqNumber ?>">
            <span><?= htmlspecialchars($faq[0]) ?></span>
            <i class="fa-solid fa-chevron-down faq-item__chevron" aria-hidden="true"></i>
          </button>
          <div class="faq-item__answer" id="industry-faq-answer-<?= $faqNumber ?>" role="region"
            aria-labelledby="industry-faq-question-<?= $faqNumber ?>"
            aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
            <div class="faq-item__answer-inner">
              <p><?= htmlspecialchars($faq[1]) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 12. FAQ Section End -->

<!-- 13. Consultation CTA Section Start -->
<section id="consultation" class="full-bleed consultation-section">
  <div class="section-inner">
    <div class="consultation-card consultation-card--solo">
      <div class="consultation-copy">
        <h2>Get the Best Solution for your<br class="hidden sm:block"> Organisation with us</h2>
        <p>
          We are always happy to serve you the best and smart industry solution. With Suave Creators, we bring the latest
          technology and benefit from experts who are eager to share their knowledge.
        </p>
        <a href="/contact-us/#contact-id" class="consultation-cta">
          Get a Free Quote
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1">
            <path d="M18 8L22 12L18 16"></path>
            <path d="M2 12H22"></path>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>
<!-- 13. Consultation CTA Section End -->

<!-- 14. Testimonials Section Start -->
<?php require __DIR__ . '/partials/testimonials-section.php'; ?>
<!-- 14. Testimonials Section End -->

<!-- 15. Articles Insights Section Start -->
<section
  class="full-bleed articles-insights bg-[url('/images/blog-bg.png')] bg-cover bg-top bg-no-repeat relative overflow-hidden py-10 sm:py-12 lg:py-18"
  aria-labelledby="industry-insights-title">
  <div class="articles-insights__inner section-inner">
    <div class="articles-insights__content">
      <header class="portfolio-showcase__header">
        <p
          class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
          Blogs and Insights
        </p>
        <h2 id="industry-insights-title"
          class="mt-3 text-[20px] font-semibold leading-tight tracking-[-0.025em] text-[#171717] sm:mt-4 lg:text-[24px]">
          Latest Insights from Our Experts
        </h2>
        <p
          class="portfolio-showcase__intro mx-auto mt-2 max-w-[690px] text-[13px] leading-6 text-[#4D4D4D] sm:text-[14px] sm:leading-[24px]">
          We build digital experiences that help brands grow through design, development, branding, and marketing.
        </p>
      </header>

      <div class="articlesInsightsSwiper swiper">
        <div class="swiper-wrapper">
          <?php foreach ($latestPosts as $post): ?>
            <div class="swiper-slide">
              <article class="articles-card">
                <figure class="articles-card__image">
                  <img src="<?= $h($post['image']) ?>" alt="<?= $h($post['title']) ?>" width="1024" height="683" loading="lazy">
                </figure>
                <div class="articles-card__body">
                  <div class="articles-card__meta">
                    <span class="articles-card__byline">
                      <svg xmlns="https://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="8" r="5" />
                        <path d="M20 21a8 8 0 0 0-16 0" />
                      </svg>
                      <?= $h($post['author_name']) ?>
                    </span>
                    <time datetime="<?= $h($post['published_date']) ?>">
                      <svg xmlns="https://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 24 24" fill="none"
                        stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                      </svg>
                      <?= $h($post['published_label']) ?>
                    </time>
                  </div>
                  <h3><?= $h($post['title']) ?></h3>
                  <p><?= $h($post['short_description']) ?></p>
                  <a class="articles-card__link underline mt-2 text-sm font-semibold text-[#2A4DFB]"
                    href="/blog/<?= $h($post['slug']) ?>">Read More</a>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <footer class="articles-insights__footer">
        <div class="articles-insights__controls hidden gap-2 md:flex">
          <button class="articles-insights-prev articles-insights__control" type="button" aria-label="Previous article">
            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
          </button>
          <button class="articles-insights-next articles-insights__control" type="button" aria-label="Next article">
            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
          </button>
        </div>
        <div class="articles-insights-pagination flex md:hidden" aria-label="Articles pagination"></div>
        <a class="articles-insights__more" href="/blogs">View More</a>
      </footer>
    </div>
  </div>
</section>
<!-- 15. Articles Insights Section End -->

<style>
  .industry-portfolio-marquee {
    width: 100%;
    overflow: hidden;
  }

  .industry-portfolio-marquee:focus-visible {
    outline: 2px solid #2A4DFB;
    outline-offset: 4px;
  }

  .industry-portfolio-marquee__track {
    align-items: stretch;
    display: flex;
    width: max-content;
    will-change: transform;
    animation: industryPortfolioMarquee 40s linear infinite;
  }

  .industry-portfolio-marquee:hover .industry-portfolio-marquee__track,
  .industry-portfolio-marquee:focus .industry-portfolio-marquee__track,
  .industry-portfolio-marquee:focus-within .industry-portfolio-marquee__track {
    animation-play-state: paused;
  }

  .industry-portfolio-marquee__group {
    align-items: stretch;
    display: flex;
    flex-shrink: 0;
    gap: 16px;
    padding-inline: 8px;
  }

  .industry-portfolio-marquee__item {
    flex: 0 0 auto;
    width: min(72vw, 280px);
  }

  @media (min-width: 640px) {
    .industry-portfolio-marquee__group {
      gap: 18px;
    }

    .industry-portfolio-marquee__item {
      width: min(42vw, 300px);
    }
  }

  @media (min-width: 1024px) {
    .industry-portfolio-marquee__group {
      gap: 20px;
    }

    .industry-portfolio-marquee__item {
      width: 280px;
    }
  }

  @keyframes industryPortfolioMarquee {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
  }

  @media (prefers-reduced-motion: reduce) {
    .industry-portfolio-marquee__track {
      animation: none;
    }
  }

  .industryCoreServicesSwiper {
    overflow: hidden;
    width: 100%;
  }

  .industryCoreServicesSwiper .swiper-wrapper {
    align-items: stretch;
  }

  .industryCoreServicesSwiper .swiper-slide {
    height: auto;
  }

  .industryCoreServicesSwiper .industry-service-card {
    box-shadow: none !important;
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .industry-why-services .web-service-card__icon,
  .industry-why-services .web-service-card__icon--blue,
  .industry-why-services .web-service-card__icon--orange,
  .industry-why-services .web-service-card__icon--cyan,
  .industry-why-services .web-service-card__icon--mint,
  .industry-why-services .web-service-card__icon--rose,
  .industry-why-services .web-service-card__icon--amber {
    background: transparent !important;
    border: 0 !important;
    border-radius: 0;
    height: auto;
    margin-bottom: 12px;
    padding: 0;
    width: auto;
  }

  .industry-why-services .web-service-card__icon img {
    display: block;
    height: 38px;
    object-fit: contain;
    width: 38px;
  }

  /* Match first-card hover on every card in this grid */
  .industry-why-services .web-service-card,
  .industry-why-services .web-service-card:nth-child(n) {
    --web-service-accent: #315DE3;
  }

  .industry-why-services .web-service-card::before {
    background: #315DE3;
  }

  .industry-why-services .web-service-card::after {
    background: #E8EBFF;
    opacity: 0;
  }

  .industry-why-services .web-service-card:hover,
  .industry-why-services .web-service-card:focus-within {
    background: #E8EBFF;
  }

  .industry-why-services .web-service-card:hover::before,
  .industry-why-services .web-service-card:focus-within::before {
    width: 100%;
  }

  .industry-why-services .web-service-card:hover::after,
  .industry-why-services .web-service-card:focus-within::after {
    opacity: 1;
  }

  .expertise-showcase-section__glow {
    background:
      radial-gradient(ellipse 55% 45% at 12% 18%, rgba(42, 77, 251, 0.35), transparent 70%),
      radial-gradient(ellipse 45% 40% at 88% 78%, rgba(122, 95, 248, 0.22), transparent 72%);
    inset: 0;
    pointer-events: none;
    position: absolute;
  }

  .expertise-showcase {
    display: grid;
    gap: 20px;
  }

  .expertise-showcase__tabs {
    display: grid;
    gap: 8px;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .expertise-showcase__tab {
    align-items: center;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 14px;
    color: #B1B9DF;
    cursor: pointer;
    display: flex;
    gap: 10px;
    min-height: 56px;
    padding: 12px 14px;
    text-align: left;
    transition: background 0.25s ease, border-color 0.25s ease, color 0.25s ease, transform 0.25s ease;
    width: 100%;
  }

  .expertise-showcase__tab:hover {
    background: rgba(255, 255, 255, 0.08);
    color: #fff;
  }

  .expertise-showcase__tab:focus-visible {
    outline: 2px solid #5B8CFF;
    outline-offset: 2px;
  }

  .expertise-showcase__tab.is-active {
    background: linear-gradient(135deg, rgba(42, 77, 251, 0.28), rgba(122, 95, 248, 0.16));
    border-color: rgba(91, 140, 255, 0.55);
    box-shadow: 0 10px 28px rgba(42, 77, 251, 0.18);
    color: #fff;
    transform: translateY(-1px);
  }

  .expertise-showcase__tab-index {
    color: #6B7289;
    flex-shrink: 0;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.04em;
  }

  .expertise-showcase__tab.is-active .expertise-showcase__tab-index {
    color: #8EB6FF;
  }

  .expertise-showcase__tab-icon {
    align-items: center;
    background: rgba(255, 255, 255, 0.06);
    border-radius: 999px;
    color: #8EB6FF;
    display: inline-flex;
    flex-shrink: 0;
    font-size: 12px;
    height: 28px;
    justify-content: center;
    width: 28px;
  }

  .expertise-showcase__tab.is-active .expertise-showcase__tab-icon {
    background: rgba(42, 77, 251, 0.35);
    color: #fff;
  }

  .expertise-showcase__tab-label {
    font-size: 12px;
    font-weight: 600;
    line-height: 1.25;
    min-width: 0;
  }

  .expertise-showcase__stage {
    min-width: 0;
    position: relative;
  }

  .expertise-showcase__panel {
    display: grid;
    gap: 18px;
  }

  .expertise-showcase__panel[hidden] {
    display: none !important;
  }

  .expertise-showcase__panel.is-active {
    animation: expertisePanelIn 0.45s ease both;
  }

  .expertise-showcase__media {
    border-radius: 18px;
    margin: 0;
    overflow: hidden;
    position: relative;
  }

  .expertise-showcase__media img {
    aspect-ratio: 16 / 11;
    display: block;
    height: auto;
    object-fit: cover;
    transform: scale(1.02);
    transition: transform 0.7s ease;
    width: 100%;
  }

  .expertise-showcase__panel.is-active .expertise-showcase__media img {
    transform: scale(1);
  }

  .expertise-showcase__media-shade {
    background: linear-gradient(180deg, transparent 35%, rgba(7, 11, 31, 0.72) 100%);
    inset: 0;
    pointer-events: none;
    position: absolute;
  }

  .expertise-showcase__media-badge {
    align-items: center;
    backdrop-filter: blur(8px);
    background: rgba(7, 11, 31, 0.55);
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 999px;
    bottom: 14px;
    color: #fff;
    display: inline-flex;
    font-size: 12px;
    font-weight: 600;
    gap: 8px;
    left: 14px;
    padding: 8px 12px;
    position: absolute;
  }

  .expertise-showcase__copy h3 {
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    line-height: 1.25;
    margin: 0;
  }

  .expertise-showcase__copy p {
    color: #B1B9DF;
    font-size: 13px;
    line-height: 1.65;
    margin: 12px 0 0;
    max-width: 54ch;
  }

  .expertise-showcase__tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 14px;
  }

  .expertise-showcase__tags span {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 999px;
    color: #D7DCF5;
    font-size: 11px;
    font-weight: 500;
    padding: 6px 12px;
  }

  @keyframes expertisePanelIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @media (min-width: 768px) {
    .expertise-showcase__tabs {
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 10px;
    }

    .expertise-showcase__tab {
      min-height: 64px;
      padding: 14px 16px;
    }

    .expertise-showcase__tab-label {
      font-size: 13px;
    }

    .expertise-showcase__copy h3 {
      font-size: 24px;
    }

    .expertise-showcase__copy p {
      font-size: 14px;
    }

    .expertise-showcase__media img {
      aspect-ratio: 21 / 10;
    }
  }

  @media (min-width: 1024px) {
    .expertise-showcase {
      align-items: stretch;
      gap: 28px;
      grid-template-columns: minmax(250px, 0.9fr) minmax(0, 1.7fr);
    }

    .expertise-showcase__tabs {
      align-content: start;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .expertise-showcase__tab {
      border-radius: 16px;
      min-height: 68px;
    }

    .expertise-showcase__panel {
      gap: 22px;
      grid-template-columns: 1.15fr 0.85fr;
      min-height: 420px;
    }

    .expertise-showcase__media {
      height: 100%;
      min-height: 420px;
    }

    .expertise-showcase__media img {
      aspect-ratio: auto;
      height: 100%;
    }

    .expertise-showcase__copy {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding-block: 8px;
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .expertise-showcase__panel.is-active,
    .expertise-showcase__media img,
    .expertise-showcase__tab {
      animation: none;
      transition: none;
    }
  }

  /* Industry page: mobile + tablet polish */
  @media (max-width: 1023px) {
    .industry-hero-visual {
      width: min(100%, 340px);
      padding-top: 8%;
    }

    .industry-why-services {
      gap: 12px;
    }

    .industry-why-services .web-service-card {
      min-height: 0;
      padding: 18px 16px 20px;
    }

    .expertise-showcase__tab-label {
      font-size: 11px;
    }

    .expertise-showcase__media-badge {
      bottom: 10px;
      font-size: 11px;
      left: 10px;
      padding: 6px 10px;
    }
  }

  /* Industry CTA buttons: 34px mobile, 36px larger screens */
  main .u-btn-cta {
    box-sizing: border-box;
    height: 36px;
    min-height: 36px;
    padding-block: 0;
  }

  @media (max-width: 767px) {
    main .u-btn-cta {
      height: 34px;
      min-height: 34px;
    }

    .industry-hero-visual {
      width: min(100%, 280px);
    }

    .industry-portfolio-marquee__item {
      width: min(78vw, 240px);
    }

    .industry-service-card {
      padding: 16px;
    }

    .industry-service-card h3 {
      font-size: 15px;
    }

    .industry-service-card > p {
      font-size: 13px;
    }

    .industry-service-card__tags span {
      font-size: 11px;
      padding: 5px 10px;
    }

    .expertise-showcase__tabs {
      gap: 6px;
    }

    .expertise-showcase__tab {
      border-radius: 12px;
      gap: 8px;
      min-height: 52px;
      padding: 10px;
    }

    .expertise-showcase__tab-icon {
      display: none;
    }

    .expertise-showcase__tab-index {
      font-size: 10px;
    }

    .expertise-showcase__copy h3 {
      font-size: 18px;
    }

    .expertise-showcase__tags span {
      font-size: 10px;
      padding: 5px 10px;
    }

    .web-services__footer {
      justify-content: center;
      margin-top: 24px;
    }

    .faq-section {
      padding-block: 40px 48px;
    }
  }

  @media (min-width: 768px) and (max-width: 1023px) {
    .industry-why-services {
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }

    .expertise-showcase__panel {
      gap: 20px;
    }

    .expertise-showcase__media img {
      aspect-ratio: 16 / 9;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper !== 'undefined') {
      if (document.querySelector('.industryCoreServicesSwiper')) {
        new Swiper('.industryCoreServicesSwiper', {
          slidesPerView: 1,
          spaceBetween: 16,
          speed: 650,
          rewind: true,
          watchOverflow: true,
          keyboard: { enabled: true, onlyInViewport: true },
          a11y: {
            prevSlideMessage: 'Previous service',
            nextSlideMessage: 'Next service'
          },
          navigation: {
            nextEl: '.industry-core-services-next',
            prevEl: '.industry-core-services-prev'
          },
          pagination: {
            el: '.industry-core-services-pagination',
            clickable: true
          },
          breakpoints: {
            768: { slidesPerView: 2, spaceBetween: 18 },
            1024: { slidesPerView: 3, spaceBetween: 24 }
          }
        });
      }

      if (document.querySelector('.articlesInsightsSwiper')) {
        new Swiper('.articlesInsightsSwiper', {
          slidesPerView: 1,
          spaceBetween: 16,
          speed: 500,
          loop: false,
          watchOverflow: true,
          keyboard: { enabled: true, onlyInViewport: true },
          a11y: {
            prevSlideMessage: 'Previous article',
            nextSlideMessage: 'Next article'
          },
          navigation: {
            nextEl: '.articles-insights-next',
            prevEl: '.articles-insights-prev'
          },
          pagination: {
            el: '.articles-insights-pagination',
            clickable: true
          },
          breakpoints: {
            768: { slidesPerView: 2, spaceBetween: 20 },
            1024: { slidesPerView: 3, spaceBetween: 26 }
          }
        });
      }

      if (document.querySelector('.testimonialSwiper')) {
        new Swiper('.testimonialSwiper', {
          direction: window.matchMedia('(min-width: 1024px)').matches ? 'vertical' : 'horizontal',
          slidesPerView: 1,
          spaceBetween: 16,
          loop: true,
          speed: 700,
          autoplay: { delay: 4500, disableOnInteraction: false, pauseOnMouseEnter: true },
          navigation: { nextEl: '.testimonial-next', prevEl: '.testimonial-prev' },
          pagination: {
            el: '.testimonial-pagination',
            clickable: true
          },
          breakpoints: { 1024: { slidesPerView: 2, spaceBetween: 24 } }
        });
      }

    }

    const expertiseRoot = document.querySelector('[data-industry-expertise]');
    if (expertiseRoot) {
      const tabs = expertiseRoot.querySelectorAll('[data-expertise-index]');
      const panels = expertiseRoot.querySelectorAll('[data-expertise-panel]');
      const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
      let activeIndex = Array.from(tabs).findIndex(function (tab) {
        return tab.classList.contains('is-active');
      });
      if (activeIndex < 0) activeIndex = 0;
      let autoplayTimer = null;

      function activateExpertise(index) {
        if (!tabs.length) return;
        activeIndex = ((index % tabs.length) + tabs.length) % tabs.length;
        const nextIndex = String(activeIndex);

        tabs.forEach(function (item) {
          const isActive = item.getAttribute('data-expertise-index') === nextIndex;
          item.classList.toggle('is-active', isActive);
          item.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        panels.forEach(function (panel) {
          const isActive = panel.getAttribute('data-expertise-panel') === nextIndex;
          panel.classList.toggle('is-active', isActive);
          if (isActive) {
            panel.removeAttribute('hidden');
          } else {
            panel.setAttribute('hidden', '');
          }
        });
      }

      function stopExpertiseAutoplay() {
        if (autoplayTimer) {
          window.clearInterval(autoplayTimer);
          autoplayTimer = null;
        }
      }

      function startExpertiseAutoplay() {
        stopExpertiseAutoplay();
        if (reduceMotion.matches || tabs.length < 2) return;
        autoplayTimer = window.setInterval(function () {
          activateExpertise(activeIndex + 1);
        }, 10000);
      }

      tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
          activateExpertise(Number(tab.getAttribute('data-expertise-index')));
          startExpertiseAutoplay();
        });
      });

      expertiseRoot.addEventListener('mouseenter', stopExpertiseAutoplay);
      expertiseRoot.addEventListener('mouseleave', startExpertiseAutoplay);
      expertiseRoot.addEventListener('focusin', stopExpertiseAutoplay);
      expertiseRoot.addEventListener('focusout', function (event) {
        if (!expertiseRoot.contains(event.relatedTarget)) {
          startExpertiseAutoplay();
        }
      });

      if (typeof reduceMotion.addEventListener === 'function') {
        reduceMotion.addEventListener('change', function () {
          if (reduceMotion.matches) {
            stopExpertiseAutoplay();
          } else {
            startExpertiseAutoplay();
          }
        });
      }

      startExpertiseAutoplay();
    }

    const faqItems = document.querySelectorAll('.faq-list .faq-item');
    const faqMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    const faqAnimationTokens = new WeakMap();
    const faqTransitionHandlers = new WeakMap();

    function nextFaqAnimationToken(item) {
      const token = (faqAnimationTokens.get(item) || 0) + 1;
      faqAnimationTokens.set(item, token);
      return token;
    }

    function clearFaqTransitionHandler(answer) {
      const handler = faqTransitionHandlers.get(answer);
      if (handler) {
        answer.removeEventListener('transitionend', handler);
        faqTransitionHandlers.delete(answer);
      }
    }

    function setFaqAria(item, isOpen) {
      const button = item.querySelector('.faq-item__summary');
      const answer = item.querySelector('.faq-item__answer');
      button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      answer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    }

    function openFaq(item) {
      const answer = item.querySelector('.faq-item__answer');
      const token = nextFaqAnimationToken(item);
      clearFaqTransitionHandler(answer);
      item.classList.add('is-open');
      setFaqAria(item, true);

      if (faqMotionQuery.matches) {
        answer.style.height = 'auto';
        return;
      }

      const startHeight = answer.getBoundingClientRect().height;
      answer.style.height = startHeight + 'px';
      answer.offsetHeight;

      const onHeightEnd = function (event) {
        if (event.propertyName === 'height' && faqAnimationTokens.get(item) === token && item.classList.contains('is-open')) {
          answer.style.height = 'auto';
          clearFaqTransitionHandler(answer);
        }
      };

      faqTransitionHandlers.set(answer, onHeightEnd);
      answer.addEventListener('transitionend', onHeightEnd);

      requestAnimationFrame(function () {
        if (faqAnimationTokens.get(item) === token) {
          answer.style.height = answer.scrollHeight + 'px';
        }
      });
    }

    function closeFaq(item) {
      const answer = item.querySelector('.faq-item__answer');
      const token = nextFaqAnimationToken(item);
      clearFaqTransitionHandler(answer);

      if (faqMotionQuery.matches) {
        item.classList.remove('is-open');
        setFaqAria(item, false);
        answer.style.height = '0px';
        return;
      }

      const startHeight = answer.style.height === 'auto'
        ? answer.scrollHeight
        : answer.getBoundingClientRect().height;

      answer.style.height = startHeight + 'px';
      answer.offsetHeight;
      item.classList.remove('is-open');
      setFaqAria(item, false);

      const onHeightEnd = function (event) {
        if (event.propertyName === 'height' && faqAnimationTokens.get(item) === token && !item.classList.contains('is-open')) {
          answer.style.height = '0px';
          clearFaqTransitionHandler(answer);
        }
      };

      faqTransitionHandlers.set(answer, onHeightEnd);
      answer.addEventListener('transitionend', onHeightEnd);

      requestAnimationFrame(function () {
        if (faqAnimationTokens.get(item) === token) {
          answer.style.height = '0px';
        }
      });
    }

    faqItems.forEach(function (item) {
      const answer = item.querySelector('.faq-item__answer');
      const isOpen = item.classList.contains('is-open');
      answer.style.transition = 'none';
      answer.style.height = isOpen ? 'auto' : '0px';
      setFaqAria(item, isOpen);
    });

    if (faqItems.length) {
      faqItems[0].offsetHeight;
    }

    faqItems.forEach(function (item) {
      const button = item.querySelector('.faq-item__summary');
      const answer = item.querySelector('.faq-item__answer');
      answer.style.removeProperty('transition');

      button.addEventListener('click', function () {
        const shouldOpen = !item.classList.contains('is-open');
        faqItems.forEach(function (sibling) {
          if (sibling !== item && sibling.classList.contains('is-open')) {
            closeFaq(sibling);
          }
        });
        if (shouldOpen) {
          openFaq(item);
        } else {
          closeFaq(item);
        }
      });
    });
  });
</script>

<style>
.consultation-card--solo {
  justify-content: flex-start;
  background-image: url('/images/industry-future-bg.webp');
  background-size: cover;
  background-position: top;
  background-repeat: no-repeat;
}

.industry-hero-visual {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  width: min(100%, 420px);
  aspect-ratio: 1;
  padding-top: 12%;
}

.industry-hero-visual__half {
  display: block;
  width: 50%;
  height: auto;
  margin: 0;
  padding: 0;
  object-fit: contain;
  filter: drop-shadow(0 24px 40px rgba(0, 0, 63, 0.35));
}

.industry-hero-visual__half--left {
  animation: industry-orbit-float 3.2s ease-in-out infinite;
}

.industry-hero-visual__half--right {
  animation: industry-orbit-float-alt 3.2s ease-in-out infinite;
}

.industry-hero-visual__caption {
  position: absolute;
  right: 0;
  top: 4%;
  z-index: 2;
  color: rgba(255, 255, 255, 0.88);
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.08em;
  line-height: 1.35;
  text-transform: uppercase;
}

.industry-service-card {
  display: flex;
  flex-direction: column;
  gap: 12px;
  min-height: 100%;
  padding: 22px;
  border-radius: 22px;
  background: #fff;
  border: 1px solid rgba(42, 77, 251, 0.08);
  box-shadow: 0 18px 40px rgba(36, 36, 84, 0.06);
}

.industry-service-card h3 {
  font-size: 16px;
  font-weight: 700;
  line-height: 1.3;
  color: #171717;
}

.industry-service-card > p {
  font-size: 14px;
  line-height: 1.55;
  color: #4d4d4d;
  flex: 1;
}

.industry-service-card__tags {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.industry-service-card__tags span {
  display: inline-flex;
  align-items: center;
  padding: 6px 12px;
  border-radius: 999px;
  background: #f2f3f8;
  color: #4d4d4d;
  font-size: 12px;
  font-weight: 500;
}

.industry-service-card__image {
  margin: 4px 0 0;
  overflow: hidden;
  border-radius: 16px;
  aspect-ratio: 16 / 10;
}

.industry-service-card__image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.industry-expertise {
  display: grid;
  gap: 36px;
}

@media (min-width: 768px) {
  .industry-expertise {
    gap: 40px;
  }
}

@media (max-width: 1023px) {
  .consultation-card--solo {
    background-image: none;
    background-color: #eef1f8;
  }
}

@media (max-width: 767px) {
  .consultation-card--solo {
    background-image: none;
    background-color: #eef1f8;
  }

  .industry-hero-visual {
    margin-inline: auto;
  }

  .industry-hero-visual__caption {
    display: none;
  }
}

@media (prefers-reduced-motion: reduce) {
  .industry-hero-visual__half {
    animation: none;
  }
}

@keyframes industry-orbit-float {
  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-14px);
  }
}

@keyframes industry-orbit-float-alt {
  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(14px);
  }
}
</style>

<?php require __DIR__ . '/layout/end.php'; ?>
