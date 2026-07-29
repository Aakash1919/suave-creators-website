<?php
$pageTitle = 'Web, Software & Digital Development Services | Suave Creators';
$pageDescription = 'Explore Suave Creators\' offshore web development, enterprise software, UI/UX design, custom CRM, e-commerce, and AI solutions built for global businesses.';
$useHeroBackground = true;
require __DIR__ . '/layout/start.php';

$h = static function ($v): string {
  return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
};

$ctaArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>';
$btnPrimary = 'u-btn-cta group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110';

$blogPosts = require __DIR__ . '/data/blogs/posts.php';
$latestPosts = array_slice($blogPosts, 0, 3);
?>

<!-- 1. Hero Section (MainService) Start -->
<section
  class="full-bleed relative flex items-center bg-[url('/images/topimage.webp')] bg-cover bg-center bg-no-repeat py-10 md:py-12 lg:py-16"
  aria-labelledby="services-hero-title">
  <div class="section-inner relative z-[1]">
    <div class="relative max-w-[720px] pl-6 sm:pl-8 md:max-w-[66%] lg:pl-10">
      <p
        class="absolute left-0 top-4 text-[12px] font-medium uppercase tracking-[2px] text-[#111827] underline [writing-mode:vertical-rl] rotate-180">
        Our Services
      </p>
      <h1 id="services-hero-title"
        class="mb-3 text-[32px] font-bold leading-[1.15] text-[#111827] min-[375px]:text-[38px] sm:mb-4 sm:text-[44px] lg:text-[50px]">
        Offshore Web, Software &amp;<br class="hidden sm:block">
        Digital Development Services<br class="hidden sm:block">
        for Global Businesses
      </h1>
      <p class="mb-0 mt-1 max-w-xl text-[14px] leading-6 text-[#4D4D4D]">
        Let&rsquo;s transform your business with custom software and digital development services. At Suave Creators,
        we build websites and trust by developing top-notch digital products. Our custom offshore development
        services are a merger of cost-effective and innovative design solutions that drive digital transformation.
        Our expert team focuses on reducing operational costs and enhancing mobile and cloud capabilities for
        businesses of all sizes.
      </p>
      <div class="mt-5 flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:gap-7">
        <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?>">
          Let&rsquo;s Discuss About Vision
          <?= $ctaArrow ?>
        </a>
        <a href="#core-services" class="inline-flex max-lg:min-h-[44px] items-end pb-0.5 border-b border-[#111827]/70 text-sm font-semibold text-[#111827]">
          Explore Our Services
        </a>
      </div>
    </div>
  </div>
</section>
<!-- 1. Hero Section End -->

<!-- 2. Digital Solution Agency Section Start -->
<section class="full-bleed digital-solution-section" aria-labelledby="digital-solution-title">
  <div class="section-inner">
    <div class="digital-solution-section__row">
      <div class="digital-solution-section__badge" aria-hidden="true">
        <img src="/images/circular-text.png" alt="" class="digital-solution-section__ring" width="120" height="120">
        <img src="/images/circularicon.png" alt="" class="digital-solution-section__icon" width="40" height="40">
      </div>
      <div class="digital-solution-section__content">
        <h2 id="digital-solution-title" class="digital-solution-section__title">
          <span class="digital-solution-section__title-top">Digital solution</span>
          <span class="digital-solution-section__title-agency">agency</span>
        </h2>
        <p class="digital-solution-section__copy">
          Let&rsquo;s transform your business with custom software and digital development services. At Suave
          Creators, we build websites and trust by developing top-notch digital products. Our custom offshore
          development services are a merger of cost-effective and innovative design solutions that drive digital
          transformation. Our expert team focuses on reducing operational costs and enhancing mobile and cloud
          capabilities for businesses of all sizes.
        </p>
      </div>
    </div>
  </div>
</section>
<!-- 2. Digital Solution Agency Section End -->

<!-- 3. Expertise Section Start -->
<section class="full-bleed bg-[url('/images/market-bg.png')] bg-cover bg-top bg-no-repeat py-16 lg:py-20" aria-labelledby="expertise-title">
  <div class="section-inner">
    <header class="mb-12 max-w-[960px] lg:mb-16">
      <p
        class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Expertise
      </p>
      <h2 id="expertise-title" class="mt-4 text-[clamp(1.75rem,4vw,2.75rem)] font-bold leading-tight text-[#171717]">
        We Build impactful solutions through web design and development.
      </h2>
    </header>

    <?php
    $expertiseItems = [
      ['/images/project-analysis.png', 'Project analysis', 'Research and strategy', '#4C24F4', '#F0EAFF'],
      ['/images/build-strategy.png', 'Build strategy', 'Wireframe and design', '#1873E7', '#EAF5FC'],
      ['/images/launch-live.png', 'Launch and live', 'Development and scale', '#0F968E', '#E8F8F6'],
      ['/images/maintenance-logo.png', 'Maintenance', 'Maintaining strong', '#FA6811', '#FFF0E7'],
    ];
    ?>
    <div class="about-stats">
      <?php foreach ($expertiseItems as $item): ?>
        <article class="about-stat"
          style="--stat-accent: <?= $h($item[3]) ?>; --stat-tint: <?= $h($item[4]) ?>;">
          <span class="about-stat__icon">
            <img src="<?= $h($item[0]) ?>" alt="<?= $h($item[1]) ?>" class="about-stat__icon-image" loading="lazy">
          </span>
          <div class="about-stat__content">
            <strong class="about-stat__value about-stat__value--title"><?= $h($item[1]) ?></strong>
            <p class="about-stat__description"><?= $h($item[2]) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 3. Expertise Section End -->

<!-- 4. Technologies & Partnerships Marquee Section Start -->
<?php
$techMarqueeSectionClass = 'full-bleed full-bleed--edge bg-white py-10 lg:py-14';
require __DIR__ . '/partials/tech-partnerships-marquee.php';
?>
<!-- 4. Technologies & Partnerships Marquee Section End -->

<!-- 5. Core Services Section Start -->
<section id="core-services" class="full-bleed web-services bg-[url('/images/dev-bg.png')] bg-cover bg-top bg-no-repeat py-16 lg:py-20"
  aria-labelledby="core-services-title">
  <div class="web-services__inner section-inner">
    <header class="web-services__header">
      <div class="mb-4 flex items-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span
          class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
          SUAVE CREATORS
        </span>
      </div>
      <div class="web-services__intro">
        <h2 id="core-services-title" class="mb-4 text-[24px] font-semibold leading-[100%] text-[#171717]">
          Our Core Services
        </h2>
        <p class="text-[14px] leading-[150%] text-[#4D4D4D]">
          A complete offshore development suite covering web, software, design, CRM, e-commerce and AI &mdash;
          everything you need under one roof.
        </p>
      </div>
    </header>

    <?php
    $servicesData = [
      ['/images/service-icon-1.svg', 'Web Development Services', 'Explore our top-notch web development services to get the best possible digital solution to enhance user interaction and scale seamlessly as your needs grow.', 'Explore Web Development', '/service/web-development-services', 'blue'],
      ['/images/service-icon-2.svg', 'Enterprise Software Solutions', 'We offer the best and industry-specific Enterprise Software Solutions for organisations to manage their work more conveniently. Get a secure and scalable solution with us.', 'Explore Enterprise Solutions', '/service/enterprise-software-solutions', 'orange'],
      ['/images/service-icon-3.svg', 'UI/UX Design Services', 'UI/UX Designs help you to stand out in the competition. We are experts in front-end design, optimising custom code to deliver the best UI/UX design services.', 'See UI/UX Services', '/services', 'cyan'],
      ['/images/service-icon-4.svg', 'Custom CRM Development', 'Suave Creators develops custom-tailored CRM Solutions, implementing application development software features and functionalities that drive businesses forward.', 'Learn More About CRM', '/service/custom-crm-development', 'mint'],
      ['/images/service-icon-5.svg', 'E-commerce Development', 'Choosing e-commerce development with us is the best option for you. Try our best development services and get a reliable solution for your digital business needs.', 'Explore E-commerce Services', '/service/e-commerce-development', 'rose'],
      ['/images/service-icon-6.svg', 'AI Solutions', 'With this fast technology world, everyone needs an AI solution. We embed an AI solution with all of our software solutions. AI helps businesses to make it more secure, advanced, and productive.', 'Explore AI Services', '/services', 'amber'],
    ];
    ?>

    <div class="web-services__grid">
      <?php foreach ($servicesData as $service): ?>
        <a href="<?= $h($service[4]) ?>" class="web-service-card block">
          <span class="web-service-card__icon web-service-card__icon--lg web-service-card__icon--<?= $h($service[5]) ?>">
            <img src="<?= $h($service[0]) ?>" alt="<?= $h($service[1]) ?>" width="28" height="28">
          </span>

          <div class="web-service-card__category">
            <h3 class="text-[14px] font-semibold leading-[130%] text-[#171717]">
              <?= $h($service[1]) ?>
            </h3>
          </div>

          <p class="mt-1 text-[14px] leading-[20px] text-[#4D4D4D]"><?= $h($service[2]) ?></p>

          <span class="mt-3 inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#2A4DFB]">
            <?= $h($service[3]) ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 24 24" fill="none"
              stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 8L22 12L18 16" />
              <path d="M2 12H22" />
            </svg>
          </span>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="web-services__footer">
      <a href="/contact-us/#contact-id">Discuss your Requirements</a>
    </div>
  </div>
</section>
<!-- 5. Core Services Section End -->

<!-- 6. Work With Us (Smart Together CTA) Section Start -->
<section class="full-bleed smart-together-cta py-6" aria-labelledby="services-cta-title">
  <div class="smart-together-cta__inner section-inner">
    <div class="smart-together-cta__eyebrow mb-4 flex items-center gap-2">
      <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
      <span
        class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Ready to Start Your Project?
      </span>
    </div>

    <div class="smart-together-cta__copy">
      <h2 id="services-cta-title">Are you Ready to Start Your Project?</h2>
      <p>As the best development company, we help you to develop your next digital product. Get Innovative and
        advanced solutions with us and see the quick growth.</p>
    </div>

    <div class="smart-together-cta__actions flex flex-row flex-nowrap items-center gap-2 sm:gap-3">
      <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?>">
        Let&rsquo;s Connect to Discuss
        <?= $ctaArrow ?>
      </a>
      <a href="/contact-us/#contact-id"
        class="inline-flex shrink-0 items-center border-b border-white/70 pb-px text-sm font-semibold text-white">
        Discuss your Vision
      </a>
    </div>

    <span class="smart-together-cta__phone" aria-hidden="true">
      <img src="/images/phone.gif" alt="" class="rounded-[10px]" />
    </span>
  </div>
</section>
<!-- 6. Work With Us Section End -->

<!-- 7. Offshore Services Section Start -->
<section class="full-bleed bg-[#F9FAFC] bg-[url('/images/background_offerings.png')] bg-cover bg-top bg-no-repeat py-16 lg:py-20"
  aria-labelledby="offshore-services-title">
  <div class="section-inner">
    <header class="mx-auto mb-12 max-w-[720px] text-center lg:mb-14">
      <p
        class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Offshore Services
      </p>
      <h2 id="offshore-services-title"
        class="mt-4 text-[clamp(1.75rem,4vw,2.75rem)] font-bold leading-tight text-[#171717]">
        Why Global Businesses Choose Our Offshore Services
      </h2>
      <p class="mx-auto mt-4 max-w-[620px] text-[14px] leading-6 text-[#4D4D4D]">
        Our Offshore services provide a flexible and scalable solution for your business needs. You can easily
        adjust your service requirements up or down as and when needed.
      </p>
    </header>

    <?php
    $offshoreSlides = [
      [
        '/images/developers-collaborating-code-review.webp',
        'End-to-End Development Expertise',
        'With all of our projects, we always provide end-to-end development services. By leveraging our global young talent and systematic resource allocation, we provide the best and competitive pricing that helps you to get expert solutions and optimise your development budget.',
        ['SEO', 'Mobile', 'First Performance'],
        'Offshore development team reviewing custom software code together',
      ],
      [
        '/images/seo-infographic-on-imac.webp',
        'SEO-Optimisation and Performance',
        'SEO optimization and high performance are the needs of every website and application nowadays. All of our solutions perform better and follow Search engine algorithms so that they easily gain good visibility on Google soon.',
        ['UI/UX', 'Research', 'Prototyping'],
        'SEO optimisation strategy on screen for high performance websites',
      ],
      [
        '/images/financial-dashboard-laptop-collaboration.webp',
        'Global and Scalable Security',
        'Our solutions are built to grow with your business. Whether you&rsquo;re a startup expanding into new markets or an enterprise business managing high volumes, we design platforms that scale without performance issues.',
        ['SEO', 'Mobile', 'First Performance'],
        'Secure scalable analytics dashboard monitored by an enterprise software team',
      ],
    ];
    ?>
    <div class="grid grid-cols-1 gap-5 md:grid-cols-3 lg:gap-6">
      <?php foreach ($offshoreSlides as $slide): ?>
        <article
          class="flex min-h-full flex-col gap-3 overflow-hidden rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          <figure class="aspect-[16/10] overflow-hidden">
            <img src="<?= $h($slide[0]) ?>" alt="<?= $h($slide[4]) ?>" class="h-full w-full object-cover" loading="lazy">
          </figure>
          <div class="flex flex-1 flex-col gap-3 p-[22px]">
            <h3 class="text-base font-bold leading-tight text-[#171717]"><?= $h($slide[1]) ?></h3>
            <p class="flex-1 text-sm leading-relaxed text-[#4D4D4D]"><?= $h($slide[2]) ?></p>
            <div class="flex flex-wrap gap-1.5">
              <?php foreach ($slide[3] as $tag): ?>
                <span
                  class="rounded-full bg-[#EEF1FF] px-2.5 py-0.5 text-[11px] font-semibold text-[#2A4DFB]"><?= $h($tag) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="mt-10 flex justify-center">
      <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?>">
        Request a Free Consultation
        <?= $ctaArrow ?>
      </a>
    </div>
  </div>
</section>
<!-- 7. Offshore Services Section End -->



<!-- 9. Tech Stack Section Start -->
<section class="full-bleed bg-white py-16 lg:py-20" aria-labelledby="tech-stack-title">
  <div class="section-inner">
    <header class="mx-auto mb-12 max-w-[720px] text-center lg:mb-16">
      <p
        class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Our Technology
      </p>
      <h2 id="tech-stack-title" class="mt-4 text-[clamp(1.75rem,4vw,2.75rem)] font-bold leading-tight text-[#171717]">
        The Technology Behind Our Solutions
      </h2>
    </header>

    <?php
    $techData = [
      ['/images/tech-icon-1.png', 'Shopify & WooCommerce', 'We suggest CRM according to the clients\' needs. We develop websites for Shopify and WooCommerce for your e-commerce websites.', '#7AB55C'],
      ['/images/tech-icon-2.png', 'React & Angular', 'We built websites on React & Angular to deliver high performance and a strong security system.', '#149ECA'],
      ['/images/tech-icon-3.png', 'Laravel & PHP', 'We specialize in building web applications using the PHP programming language and the Laravel framework.', '#FF2D20'],
      ['/images/tech-icon-4.png', 'Node.js', 'We use Node.js to build real-time apps, high-performance results, robust and mobile solutions, etc.', '#68A063'],
      ['/images/tech-icon-5.png', 'WordPress', 'A best and reliable easy-to-use CMS solution for all types of businesses with all SEO capabilities.', '#21759B'],
    ];
    ?>
    <div class="grid overflow-hidden border-l border-t border-[#ECECEC] grid-cols-1 sm:grid-cols-2 lg:grid-cols-5">
      <?php foreach ($techData as $tech): ?>
        <article class="technology-card group relative min-h-[210px] border-b border-r border-[#ECECEC] bg-white p-5"
          style="--technology-color: <?= $h($tech[3]) ?>">
          <span
            class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            style="background: radial-gradient(circle at 100% 100%, color-mix(in srgb, var(--technology-color) 12%, transparent), transparent 58%);"></span>
          <img src="<?= $h($tech[0]) ?>" alt="" class="relative h-10 w-10 object-contain" loading="lazy">
          <h3 class="relative mt-3 text-base font-bold text-[#171717]"><?= $tech[1] ?></h3>
          <p class="relative mt-2 pr-5 text-sm leading-[22px] text-[#4D4D4D]"><?= $tech[2] ?></p>
          <a href="/services"
            class="relative mt-3 inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#2A4DFB]">
            Get Started
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 24 24" fill="none"
              stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 8L22 12L18 16" />
              <path d="M2 12H22" />
            </svg>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 9. Tech Stack Section End -->

<!-- 10. Process Section Start -->
<section class="full-bleed industries-served bg-[url('/images/industry-bg.png')] bg-cover bg-top bg-no-repeat py-[80px]"
  aria-labelledby="services-process-title">
  <div class="industries-served__inner section-inner">
    <header class="core-values__header">
      <div class="flex items-start gap-2 mb-4">
        <span class="inline-block w-[2px] h-[16px] bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8] rounded-full"></span>
        <span class="text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block">
          Our Process
        </span>
      </div>
      <div class="core-values__heading">
        <h2 id="services-process-title">Our process guides you step by step towards achieving success</h2>
        <p>We follow a clear, collaborative process that takes your idea from research to a fully functional, high-performing product.</p>
      </div>
    </header>

    <?php
    $processes = [
      ['fa-solid fa-magnifying-glass-chart', 'Discovery Phase', 'Before starting anything, we do deep research and define the fundamental features of your future product.'],
      ['fa-solid fa-route', 'Strategy Development', 'We craft a transparent roadmap for success. Our professional crew defines the project planning, sets deadlines, and chooses the right technologies to bring your vision to life.'],
      ['fa-solid fa-code', 'Implementation', 'Our expert designers collaborate to transform strategy into a fully functional, high-performing product and deliver you the best possible solution.'],
    ];
    ?>
    <div class="industries-served__grid">
      <?php foreach ($processes as $process): ?>
        <article class="industry-card">
          <i class="industry-card__icon <?= $h($process[0]) ?>" aria-hidden="true"></i>
          <h3><?= $h($process[1]) ?></h3>
          <p><?= $h($process[2]) ?></p>

          <span class="industry-card__arrow" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg"
              width="18"
              height="18"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round">
              <path d="M18 8L22 12L18 16"></path>
              <path d="M2 12H22"></path>
            </svg>
          </span>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 10. Process Section End -->
<!-- 12. FAQ Section Start -->
<section class="full-bleed faq-section faq-section--align bg-[url('/images/web-bg.png')] bg-cover bg-top bg-no-repeat" aria-labelledby="services-faq-heading">
  <div class="faq-section__inner section-inner">
    <div class="faq-section__intro">
      <p class="faq-section__eyebrow flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">
          Have questions about our Web Services?
        </span>
      </p>
      <h2 id="services-faq-heading">Frequently Ask Question</h2>
      <p class="faq-section__description">Here are the most asked questions about our offshore web, software and
        digital development services.</p>
      <?php require __DIR__ . '/partials/faq-cta-button.php'; ?>
      <img class="faq-section__image" src="/images/faq-gif.gif" alt="Business team collaborating around a table"
        width="640" height="960" loading="lazy">
    </div>

    <?php
    $faqs = [
      [
        'Do you work with international clients?',
        'Yes, Suave Creators works with international clients, including the UK, USA, Canada, Australia, and all countries across the globe.',
      ],
      [
        'How do you ensure SEO-friendly development in your services?',
        'We have the best team of seo experts who sit with the developer and do a complete audit step-by-step, and it will cover all technical and on-page aspects.',
      ],
      [
        'What industries do you serve?',
        'We specialise in offering solutions for all types of industries, like healthcare, education, banking, e-commerce, and logistics. Each solution is tailored to the industry standards, compliance needs, and customer experience.',
      ],
      [
        'What is the typical project timeline?',
        'It totally depends on the project complexity. Sometimes it will take 3 months or sometimes more than 6 months to 1 year.',
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
            aria-controls="services-faq-answer-<?= $faqNumber ?>" id="services-faq-question-<?= $faqNumber ?>">
            <span><?= $h($faq[0]) ?></span>
            <i class="fa-solid fa-chevron-down faq-item__chevron" aria-hidden="true"></i>
          </button>
          <div class="faq-item__answer" id="services-faq-answer-<?= $faqNumber ?>" role="region"
            aria-labelledby="services-faq-question-<?= $faqNumber ?>"
            aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
            <div class="faq-item__answer-inner">
              <p><?= $h($faq[1]) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 12. FAQ Section End -->

<!-- 13. Consultation / Hero CTA Section Start -->
<section id="consultation" class="full-bleed consultation-section">
  <div class="section-inner">
    <div class="consultation-card bg-[url('/images/work-with-us-bg.webp')] bg-cover bg-center bg-no-repeat">
      <div class="consultation-copy">
        <span class="mb-2 inline-block text-sm font-semibold text-white/80">Ready to Start Your Project?</span>
        <h2>Are you Ready to Start Your Project?</h2>
        <p>
          As the best development company, we help you to develop your next digital product. Get Innovative and
          advanced solutions with us and see the quick growth.
        </p>
        <a href="/contact-us/#contact-id" class="consultation-cta">
          Let&rsquo;s Connect to Discuss
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
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
<!-- 13. Consultation / Hero CTA Section End -->

<!-- 14. Testimonials Section Start -->
<section class="full-bleed testimonial-section bg-[url('/images/testimonial-bg.png')] bg-cover bg-top bg-no-repeat relative overflow-hidden py-20 lg:py-24" aria-labelledby="services-testimonials-title">
  <div class="testimonial-layout section-inner relative z-10">
    <div class="testimonial-intro flex flex-col justify-between">
      <div>
        <div class="flex items-center gap-2">
          <span class="h-4 w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">
            Testimonial
          </span>
        </div>
        <h2 id="services-testimonials-title" class="mt-4 text-2xl font-semibold text-white">Words That Inspire Us</h2>
        <p class="mt-5 max-w-sm text-sm leading-[22px] text-[#B1B9DF]">
          Our clients' feedback reflects the trust, partnership, and measurable results we deliver—from ambitious
          startups to established organizations.
        </p>
      </div>
    </div>

    <?php
    $testimonials = [
      ['Working with this team was one of the best business decisions we made. They understood our vision and delivered a website that performs exceptionally well.', 'Saurabh Singh Shah', 'Founder, NorthRose Technologies', 'SS'],
      ['The communication was clear from the start, and every milestone arrived with thoughtful solutions. Our new platform is faster, easier to use, and ready to scale.', 'Ananya Mehta', 'Operations Director', 'AM'],
      ['They combined strong product thinking with excellent engineering. The result has improved our workflow and given our customers a much smoother experience.', 'Daniel Carter', 'Co-founder, Vertex Labs', 'DC'],
      ['From discovery to launch, the team felt like an extension of our own company. They challenged assumptions and kept the project focused on real business outcomes.', 'Priya Nair', 'Head of Digital', 'PN'],
    ];
    ?>
    <div class="services-testimonial-swiper testimonialSwiper swiper w-full">
      <div class="swiper-wrapper">
        <?php foreach ($testimonials as $index => $testimonial): ?>
          <div class="swiper-slide">
            <article class="testimonial-card flex h-full flex-col justify-between rounded-lg border border-white/10 p-6">
              <div>
                <span class="text-sm font-bold text-[#2A4DFB]">/<?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <div class="mt-2 tracking-[3px] text-[#FFC107] text-[20px]" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="mt-4 text-[13px] text-[#FAFBFA]"><?= $h($testimonial[0]) ?></p>
              </div>
              <div class="mt-6 flex items-center gap-4">
                <span class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-gradient-to-br from-[#2A4DFB] to-[#7A5FF8] text-sm font-bold text-white"><?= $h($testimonial[3]) ?></span>
                <div>
                  <h3 class="font-semibold text-white"><?= $h($testimonial[1]) ?></h3>
                  <p class="mt-1 text-[13px] text-[#B1B9DF]"><?= $h($testimonial[2]) ?></p>
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
<!-- 14. Testimonials Section End -->

<!-- 15. Collaboration Finale Section Start -->
<!-- <section class="full-bleed smart-together-cta py-6" aria-labelledby="services-collab-finale-title">
  <div class="smart-together-cta__inner section-inner"> -->
 <!-- <div class="smart-together-cta__copy">
      <h2 id="services-collab-finale-title">Let&rsquo;s Build Something Smart Together</h2>
      <p>Ready to transform your ideas into reality with Suave Creators?</p>
    </div>

    <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:gap-3">
      <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?>">
        Get Started
        <?= $ctaArrow ?>
      </a>
      <a href="/contact-us/#contact-id"
        class="inline-flex shrink-0 items-center border-b border-white/70 pb-px text-sm font-semibold text-white">
        Discuss your Vision
      </a>
    </div>    <div class="mb-4 flex items-center gap-2">
      <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
      <span
        class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Connect with us
      </span>
    </div>

    -->

    <!-- <span class="smart-together-cta__phone" aria-hidden="true">
      <img src="/images/phone.gif" alt="" class="rounded-[10px]" />
    </span>
  </div>
</section> -->
<!-- 15. Collaboration Finale Section End -->

<?php
$articlesInsightsItems = array_map(static function ($post) {
  return [
    'title' => $post['title'] ?? '',
    'excerpt' => $post['short_description'] ?? '',
    'image' => $post['image'] ?? '/images/blog-1.png',
    'alt' => $post['title'] ?? '',
    'date' => $post['published_label'] ?? '',
    'datetime' => $post['published_date'] ?? '',
    'author' => $post['author_name'] ?? 'Suave Creators',
    'url' => '/blog/' . ($post['slug'] ?? ''),
  ];
}, $latestPosts);
$articlesInsightsHeadingId = 'services-insights-title';
$articlesInsightsTitle = 'Explore Our Latest Insights';
$articlesInsightsSubtitle = 'Get in touch with industry trends with our updated blogs from technology and development experts.';
$articlesInsightsSectionClass = 'py-16 lg:py-18';
$articlesInsightsMoreHref = '/blogs';
$articlesInsightsMoreLabel = 'View More';
require __DIR__ . '/partials/articles-insights.php';
?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const faqMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

    if (typeof Swiper !== 'undefined' && document.querySelector('.services-testimonial-swiper')) {
      new Swiper('.services-testimonial-swiper', {
        direction: window.matchMedia('(min-width: 1024px)').matches ? 'vertical' : 'horizontal',
        slidesPerView: 1,
        spaceBetween: 16,
        loop: true,
        speed: 700,
        watchOverflow: true,
        autoplay: faqMotionQuery.matches
          ? false
          : { delay: 4500, disableOnInteraction: false, pauseOnMouseEnter: true },
        navigation: { nextEl: '.testimonial-next', prevEl: '.testimonial-prev' },
        pagination: {
          el: '.testimonial-pagination',
          clickable: true
        },
        keyboard: { enabled: true, onlyInViewport: true },
        breakpoints: { 1024: { slidesPerView: 2, spaceBetween: 24 } }
      });
    }

    const faqItems = document.querySelectorAll('.faq-list .faq-item');
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
.about-stat__value--title {
  font-size: 16px;
  letter-spacing: -0.02em;
  line-height: 1.2;
}

.digital-solution-section {
  background-color: #f7f8fc;
  padding: 40px 0;
}

.digital-solution-section__row {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 24px;
  position: relative;
}

.digital-solution-section__badge {
  align-items: center;
  display: none;
  flex-shrink: 0;
  height: 120px;
  justify-content: center;
  position: relative;
  width: 120px;
}

.digital-solution-section__ring {
  animation: digital-solution-spin 10s linear infinite;
  display: block;
  height: 120px;
  width: 120px;
}

.digital-solution-section__icon {
  height: 40px;
  left: 50%;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 40px;
}

.digital-solution-section__content {
  align-items: baseline;
  column-gap: 14px;
  display: grid;
  grid-template-columns: minmax(0, 1fr);
  grid-template-areas:
  "top"
  "agency"
  "copy";
  row-gap: 0;
  width: 100%;
}

.digital-solution-section__title {
  color: #0b1b3f;
  display: contents;
  margin: 0;
  text-transform: uppercase;
}

.digital-solution-section__title-top,
.digital-solution-section__title-agency {
  font-family: "PP Mori", "Roboto Flex", ui-sans-serif, system-ui, sans-serif;
  font-style: normal;
  font-weight: 800;
  letter-spacing: -0.02em;
  line-height: 0.95;
}

.digital-solution-section__title-top {
  font-size: clamp(2rem, 8vw, 3.5rem);
  grid-area: top;
}

.digital-solution-section__title-agency {
  font-size: clamp(2rem, 8vw, 3.5rem);
  grid-area: agency;
  white-space: nowrap;
}

.digital-solution-section__copy {
  align-self: center;
  color: #4d4d4d;
  font-size: 14px;
  grid-area: copy;
  line-height: 24px;
  margin: 16px 0 0;
  max-width: 560px;
  min-width: 0;
}

@keyframes digital-solution-spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

@media (min-width: 768px) {
  .digital-solution-section {
    padding: 120px 0 40px;
  }

  .digital-solution-section__row {
    gap: 28px;
    margin-inline: auto;
    max-width: 860px;
  }

  .digital-solution-section__content {
    grid-template-columns: minmax(0, 1fr);
    grid-template-areas:
    "top"
    "agency"
    "copy";
    justify-items: center;
    margin-inline: auto;
    row-gap: 0;
    text-align: center;
  }

  .digital-solution-section__title-top,
  .digital-solution-section__title-agency {
    font-size: clamp(2.75rem, 6vw, 4.5rem);
    text-align: center;
  }

  .digital-solution-section__copy {
    margin-top: 16px;
    max-width: 780px;
    text-align: center;
  }
}

@media (min-width: 1024px) {
  .digital-solution-section {
    padding: 160px 0 40px;
  }

  .digital-solution-section__row {
    gap: 32px;
    margin-inline: auto;
    max-width: 1040px;
    padding-left: 160px;
    position: relative;
  }

  .digital-solution-section__badge {
    bottom: auto;
    display: flex;
    height: 120px;
    left: 0;
    margin: 0;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 120px;
    z-index: 1;
  }

  .digital-solution-section__content {
    column-gap: 28px;
    grid-template-columns: auto minmax(0, 1fr);
    grid-template-areas:
    "top top"
    "agency copy";
    justify-content: start;
    justify-items: start;
    margin-inline: 0;
    text-align: left;
    width: 100%;
  }

  .digital-solution-section__title-top,
  .digital-solution-section__title-agency {
    font-size: clamp(3.5rem, 5vw, 5.5rem);
    text-align: left;
  }

  .digital-solution-section__copy {
    font-size: 14px;
    line-height: 24px;
    margin-top: 0;
    max-width: 520px;
    text-align: left;
  }
}

@media (prefers-reduced-motion: reduce) {
  .digital-solution-section__ring {
    animation: none;
  }
}

@media (min-width: 1280px) {
  .digital-solution-section__row {
    max-width: 1180px;
    padding-left: 180px;
  }

  .digital-solution-section__title-top,
  .digital-solution-section__title-agency {
    font-size: 5.75rem;
  }

  .digital-solution-section__copy {
    max-width: 560px;
  }
}
</style>

<?php require __DIR__ . '/layout/end.php'; ?>
