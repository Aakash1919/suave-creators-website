<?php
// If the PHP built-in server was started with index.php by mistake,
// delegate clean URLs to router.php so other pages do not render home.
if (PHP_SAPI === 'cli-server') {
  $requestPath = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');
  if ($requestPath !== '/' && $requestPath !== '/index.php') {
    return require __DIR__ . '/router.php';
  }
}

$useHeroBackground = true;
require __DIR__ . '/layout/start.php';
?>
<!-- Hero Section Start -->
<section
  class="relative z-10 w-full pb-12 pt-8 md:min-h-[440px] md:pb-16 md:pt-10 lg:min-h-[640px] lg:pb-20 lg:pt-[52px] site-container bg">
  <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-12">
    <div class="relative z-0 flex max-w-xl min-w-0 flex-col text-left lg:max-w-[520px]">
      <p
        class="inline-block mb-2 bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent text-sm font-bold uppercase tracking-wide pragati-narrow-regular">
        Software, Apps & AI • CRM • ERP • Since 2021
      </p>
      <h1
        class="mb-2 mt-2 flex flex-col text-[36px] font-semibold leading-none text-white min-[375px]:text-[42px] sm:text-5xl lg:text-[60px] leading-[100%]">
        <span>Web &amp; Software</span>
        <span>Development</span>
        <span
          class="bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text text-transparent font-extrabold inline-block">
          Solutions
        </span>
      </h1>
      <p class="mb-2 mt-2 text-[12px] leading-5 md:text-sm md:leading-6 text-[#B1B9DF]">
        We are a trusted Custom Software Development Company that specializes in CRM Development, Web Application, &
        Enterprise Software Solutions to help businesses grow.
      </p>
      <div class="mt-8 flex items-center gap-4 sm:gap-7">
        <a href="/contact-us/#contact-id"
          class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-[13px] sm:text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 whitespace-nowrap">
          Start your Project
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1">
            <path d="M18 8L22 12L18 16" />
            <path d="M2 12H22" />
          </svg>
        </a>

        <a href="/contact-us/#contact-id"
          class="inline-flex items-center border-b border-white/70 text-[13px] sm:text-sm font-semibold text-white whitespace-nowrap">
          Schedule a discovery call
        </a>
      </div>
    </div>

    <div class="relative z-10 flex w-full min-w-0 items-center justify-center lg:justify-end">
      <div class="hero-media-grid" aria-hidden="true">
        <div
          class="hero-media-grid__tile col-start-1 row-span-2 row-start-1 overflow-hidden rounded-[22px] [clip-path:inset(0_round_22px)]">
          <img src="/images/strategy-meeting-documents-overhead.png" alt="Team brainstorming software strategy documents with Suave Creators" title="Team brainstorming software strategy documents with Suave Creators" class="block h-full w-full max-w-none object-cover">
        </div>
        <div
          class="hero-media-grid__tile col-start-2 row-start-1 overflow-hidden rounded-[22px] [clip-path:inset(0_round_22px)]">
          <img src="/images/hero_gif2.gif" alt="" class="block h-full w-full max-w-none object-cover">
        </div>
        <div
          class="hero-media-grid__tile col-start-2 row-start-2 overflow-hidden rounded-[22px] [clip-path:inset(0_round_22px)]">
          <img src="/images/hero_gif3.gif" alt="" class="block h-full w-full max-w-none object-cover">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Hero Section End -->

<!-- About Section Start / Who We Are -->
<section
  class="who-we-are full-bleed bg-white bg-cover bg-top bg-no-repeat py-10 md:py-14 lg:py-20" style="--who-we-are-bg: url('/images/background_about.png'); background-image: var(--who-we-are-bg);">
  <div class="section-inner site-container ">
    <div class="about-stats">
      <?php
      $stats = [
        ['50+', 'Brands trust us for AI', 'Successfully completed more than 50+ projects.', '/images/rocket.svg', '#4C24F4', '#F0EAFF'],
        ['10+', 'Years of Experience', 'Years of Combined Experience.', '/images/experience.svg', '#1873E7', '#EAF5FC'],
        ['$40M+', 'Funding Secured', 'Our creative work has helped clients secure more than $40M+ in funding.', '/images/funding.svg', '#0F968E', '#E8F8F6'],
        ['15+', 'Expert Team', '15+ Passionate Developers and Management Teams.', '/images/team.svg', '#FA6811 ', '#FFF0E7'],
      ];
      foreach ($stats as $stat):
        ?>
        <article class="about-stat"
          style="--stat-accent: <?= htmlspecialchars($stat[4]) ?>; --stat-tint: <?= htmlspecialchars($stat[5]) ?>;">
          <span class="about-stat__icon">
            <img src="<?= htmlspecialchars($stat[3]) ?>" alt="<?= htmlspecialchars($stat[1]) ?>"
              class="about-stat__icon-image">
          </span>
          <div class="about-stat__content">
            <strong class="about-stat__value"><?= htmlspecialchars($stat[0]) ?></strong>
            <h2 class="about-stat__label"><?= htmlspecialchars($stat[1]) ?></h2>
            <p class="about-stat__description"><?= htmlspecialchars($stat[2]) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="who-we-are__intro mt-16 grid grid-cols-1 items-start gap-x-14 gap-y-8 lg:mt-20 lg:grid-cols-[1.1fr_0.9fr]">
      <div>
          <div class="flex items-center gap-2 mb-4">
            <span class="inline-block w-[2px] h-[16px] bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8] rounded-full"></span>

            <span
              class="text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">
              Have questions about our Web Services?
            </span>
          </div>
          <h2 class="mt-4 text-[clamp(2.2rem,5vw,3rem)] font-bold leading-[110%] text-[#171717] lg:text-[48px]">
            We Build Digital Experiences That
            <span
              class="inline-block bg-[linear-gradient(180deg,_#2F69FB_49.52%,_#D078FE_100%)] bg-clip-text text-transparent">
              Drive Growth
            </span>
          </h2>
          <p class="mt-5 text-[clamp(1.125rem,3vw,1.5rem)] font-semibold leading-[1.4] text-[#171717] max-w-[580px]">
            We develop user-friendly web and mobile applications that enhance your overall growth and user experience.
          </p>
          <p class="mt-4 hidden text-[14px] leading-[24px] text-[#4D4D4D] max-w-[520px] md:block">
            We are a group of young talent who believe in teamwork and, with our expertise, deliver the best industry
            solution according to the client's requirements. Being one of the most valued software development companies,
            we design a range of AI-integrated smart software for this faster developing world.
          </p>
        <div class="about-values mt-8">
          <div class="about-values__item">
            <span class="about-values__icon bg-[#E6DEFD] shadow-[0px_16px_50px_0px_#5C638029]">
              <img src="/images/teams.svg" alt="Teamwork Icon" />
            </span>

            <div class="flex min-w-0 flex-col gap-1">
              <strong class="text-sm font-semibold text-[#171717]">Teamwork First</strong>
              <p class="text-[13px] leading-[16px] font-medium text-[#4D4D4D]">
                We believe great things happen together.
              </p>
            </div>
          </div>

          <div class="about-values__item">
            <span class="about-values__icon bg-[#DFE4F8] shadow-[0px_16px_50px_0px_#5C638029]">
              <img src="/images/client.svg" alt="Client Focused Icon" />
            </span>

            <div class="flex min-w-0 flex-col gap-1">
              <strong class="text-sm font-semibold text-[#171717]">Client Focused</strong>
              <p class="text-[13px] leading-[16px] font-medium text-[#4D4D4D]">
                Your goals drive our solutions.
              </p>
            </div>
          </div>

          <div class="about-values__item">
            <span class="about-values__icon bg-[#EAF4E1] shadow-[0px_16px_50px_0px_#5C638029]">
              <img src="/images/future.svg" alt="Future Ready Icon" />
            </span>

            <div class="flex min-w-0 flex-col gap-1">
              <strong class="text-sm font-semibold text-[#171717]">Future Ready</strong>
              <p class="text-[13px] leading-[16px] font-medium text-[#4D4D4D]">
                We build smart solutions for tomorrow.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="about-collage lg:row-span-2">
        <div class="about-collage__column about-collage__column--left">
          <figure class="about-collage__tile about-collage__tile--team">
            <img src="/images/team-1.png" alt="Team members collaborating around a table" width="640" height="960"
              loading="lazy">
          </figure>
          <figure class="about-collage__tile about-collage__tile--portrait-tall">
            <img src="/images/team-4.png" alt="Professional team member portrait" width="640" height="960"
              loading="lazy">
          </figure>
          <figure class="about-collage__tile about-collage__tile--office-small">
            <img src="/images/team-8.png" alt="Bright creative office interior" width="640" height="427" loading="lazy">
          </figure>
        </div>

        <div class="about-collage__column about-collage__column--center">
          <figure class="about-collage__tile about-collage__tile--leader">
            <img src="/images/team-2.png" alt="Company leader in a professional setting" width="640" height="960"
              loading="lazy">
          </figure>
          <figure class="about-collage__tile about-collage__tile--portrait-main">
            <img src="/images/team-5.png" alt="Professional woman on the product team" width="640" height="960"
              loading="lazy">
          </figure>
          <figure class="about-collage__tile about-collage__tile--office-wide">
            <img src="/images/team-9.png" alt="Team working in a modern office" width="800" height="534" loading="lazy">
          </figure>
        </div>

        <div class="about-collage__column about-collage__column--right">
          <figure class="about-collage__tile about-collage__tile--portrait-right">
            <img src="/images/team-3.png" alt="Professional designer portrait" width="640" height="960" loading="lazy">
          </figure>
          <figure class="about-collage__tile about-collage__tile--portrait-right">
            <img src="/images/team-6.png" alt="Professional team lead portrait" width="640" height="959" loading="lazy">
          </figure>
          <figure class="about-collage__tile about-collage__tile--meeting">
            <img src="/images/team-7.png" alt="Open office meeting space" width="640" height="427" loading="lazy">
          </figure>
          <figure class="about-collage__tile about-collage__tile--meeting-sm">
            <img src="/images/team-10.png" alt="Open office meeting space" width="640" height="427" loading="lazy">
          </figure>
        </div>
      </div>

      <div class="mt-0 flex flex-wrap items-center gap-5">
        <a href="/about-us"
          class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-[13px] sm:text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 whitespace-nowrap">
          <span>Learn more About Us</span>
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1">
            <path d="M18 8L22 12L18 16"></path>
            <path d="M2 12H22"></path>
          </svg>
        </a>
        <a href="/product" class="border-b border-[#00003F] text-[13px] sm:text-sm font-semibold ">View Our Work</a>
      </div>
    </div>
  </div>
</section>
<!-- About Section End -->

<!-- Offerings Showcase Section Start -->
<section
  class="offerings-showcase full-bleed overflow-hidden bg-[#F9FAFC] bg-[url('/images/background_offerings.png')] bg-cover bg-top bg-no-repeat">
  <div class="section-inner relative z-10 pt-0 pb-12 sm:py-20 lg:py-[80px]">
    <div class="mx-auto max-w-[660px] text-center">
      <p
        class="offerings-eyebrow text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">
        What we Do
      </p>
      <h2
        class="mt-4 text-[20px] font-semibold leading-[28px] sm:leading-[32px] lg:leading-[36px] tracking-[-0.025em] text-[#171717] sm:text-[18px] lg:text-[24px]">
        We are creating App Startups, not just Apps. You are our Partner, not just a Client!
      </h2>
      <p class="mx-auto mt-4 max-w-[605px] text-[13px] leading-[18px] sm:leading-[24px] text-[#4D4D4D] sm:text-[14px]">
        Our clients mean everything to us. We combine Business Model Innovation, User Acquisition Strategy, and
        Monetisation Strategy to make the Best Software solution for you.
      </p>
    </div>

    <?php
    $offerings = [
      [
        'Product Strategy with Intelligence Inside',
        'Our team helps define your vision, validate your idea.',
        '/images/shape1.png',
        'Product strategy team collaborating around a presentation',
      ],
      [
        'Design that Defines Your Brand',
        'We merge creative design, intuitive UX/UI, and brand storytelling.',
        '/images/expert-2.png',
        'Designer planning a brand experience',
      ],
      [
        'Smart Development, Seamless Performance',
        'Our team crafts high-performance, scalable applications.',
        '/images/expert-3.png',
        'Development team building a scalable application',
      ],
      [
        'Marketing that Fuels Growth',
        'We help your app grow, retain, and dominate its market space.',
        '/images/expert-4.png',
        'Marketing team presenting growth analytics',
      ],
      [
        'Continuous Support & Innovation',
        'We keep your product reliable, relevant, and ready to evolve with ongoing support and smart improvements.',
        '/images/expert-1.png',
        'Product team collaborating on continuous improvements',
      ],
    ];
    ?>
    <div class="offeringsSwiper swiper mt-10 sm:mt-12 lg:mt-[54px]">
      <div class="swiper-wrapper">
        <?php foreach ($offerings as $offering): ?>
          <div class="swiper-slide h-auto">
            <article class="offerings-card h-full">
              <div class="offerings-card__image">
                <img src="<?= htmlspecialchars($offering[2]) ?>" alt="<?= htmlspecialchars($offering[3]) ?>"
                  loading="lazy">
              </div>
              <div class="pt-3">
                <h3><?= htmlspecialchars($offering[0]) ?></h3>
                <p><?= htmlspecialchars($offering[1]) ?></p>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="offerings-footer mt-8 flex items-center justify-between gap-6 lg:mt-10">
      <div class="offerings-controls hidden gap-2 md:flex">
        <button class="offerings-prev offerings-control" type="button" aria-label="Previous offering">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="offerings-next offerings-control" type="button" aria-label="Next offering">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="offerings-pagination flex md:hidden" aria-label="Offerings pagination"></div>
      <a class="offerings-expert-link" href="/contact-us/#contact-id">Talk to an Expert</a>
    </div>
  </div>
</section>
<!-- Offerings Showcase Section End -->

<!-- Smart Together CTA Section Start -->
<section class="full-bleed smart-together-cta py-6" aria-labelledby="smart-together-title">
  <div class="smart-together-cta__inner section-inner">
    <div class="smart-together-cta__eyebrow mb-4 flex items-center gap-2">
      <span class="inline-block w-[2px] h-[16px] bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8] rounded-full"></span>
      <span
        class="text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">
        Connect with us
      </span>
    </div>

    <div class="smart-together-cta__copy">
      <h2 id="smart-together-title">Let’s Build Something Smart Together</h2>
      <p>Ready to transform your ideas into reality with Suave Creators?</p>
    </div>

    <div class="smart-together-cta__actions flex flex-row flex-nowrap items-center gap-2 sm:gap-3">
      <a href="/contact-us/#contact-id"
        class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110">
        Get Started
        <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="transition-transform duration-300 group-hover:translate-x-1">
          <path d="M18 8L22 12L18 16"></path>
          <path d="M2 12H22"></path>
        </svg>
      </a>
      <a href="/contact-us/#contact-id" class="inline-flex shrink-0 items-center border-b border-white/70 pb-px text-sm font-semibold text-white">
        Discuss your Vision
      </a>
    </div>

    <span class="smart-together-cta__phone" aria-hidden="true">
      <img src="/images/phone.gif" alt="" class="rounded-[10px]" />
    </span>
  </div>
</section>
<!-- Smart Together CTA Section End -->

<!-- Web Development Services Section Start -->
<section class="full-bleed web-services bg-[url('/images/dev-bg.png')] bg-cover bg-top bg-no-repeat py-12 lg:py-20"
  aria-labelledby="web-services-title">
  <div class="web-services__inner section-inner">
    <header class="web-services__header">
      <div class="flex items-center gap-2 mb-4">
        <span class="inline-block w-[2px] h-[16px] bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8] rounded-full"></span>

        <span
          class="text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">
          Web Development Services
        </span>
      </div>
      <div class="web-services__intro">
        <h2 id="web-services-title" class="font-semibold text-[24px] text-[#171717] leading-[100%] mb-4">
          From Concept to Code, We Build Digital Excellence.
        </h2>
        <p class="text-[14px] text-[#4D4D4D] leading-[100%]">We build cost-effective and custom solutions which is
          tailored to your business needs.</p>
      </div>
    </header>

    <?php
    $webDevelopmentServices = [
      ['dev-icon-1.svg', '01 - Development', 'Web Development Services', 'Explore our top-notch web development services to get the best possible digital solution to enhance user interaction and scale seamlessly as your needs grow.', 'blue'],
      ['dev-icon-2.svg', '02 - Enterprise Software', 'Enterprise Software Solutions', 'We offer the best and industry-specific Enterprise Software Solutions for organisations to manage their work more conveniently. Get a secure and scalable solution with us.', 'orange'],
      ['dev-icon-3.svg', '03 - Design Service', 'UI/UX Design Services', 'UI/UX Designs help you to stand out in the competition. We are experts in front-end design, optimising custom code to deliver the best UI/UX design services.', 'cyan'],
      ['dev-icon-4.svg', '04 - Custom CRM', 'Custom CRM Development', 'Suave Creators develops custom-tailored CRM Solutions, implementing application development software features and functionalities that drive businesses forward.', 'mint'],
      ['dev-icon-5.svg', '05 - E-commerce Development', 'E-commerce Development', 'Choosing e-commerce development with us is the best option for you. Try our best development services and get a reliable solution for your digital business needs.', 'rose'],
      ['dev-icon-6.svg', '06 - AI Solutions', 'AI Solutions', 'With this fast technology world, everyone needs an AI solution. We embed an AI solution with all of our software solutions. AI helps businesses to make it more secure, advanced, and productive.', 'amber'],
    ];
    ?>

    <div class="web-services__grid">
      <?php foreach ($webDevelopmentServices as $service): ?>
        <article class="web-service-card">
          <span class="web-service-card__icon web-service-card__icon--<?= htmlspecialchars($service[4]) ?>">
            <img src="images/<?= htmlspecialchars($service[0]) ?>" alt="<?= htmlspecialchars($service[2]) ?>" width="16"
              height="16">
          </span>

          <div class="web-service-card__category">
            <span
              class="font-semibold text-[#4D4D4D] text-[10px] leading-[100%] uppercase"><?= htmlspecialchars($service[1]) ?></span>
            <div class="flex items-center justify-between">

              <h3 class="text-[#171717] text-[14px] leading-[100%] font-semibold mt-2">
                <?= htmlspecialchars($service[2]) ?>
              </h3>
              <img src="/images/soft-blue-right-arrow.png" alt="Soft blue right arrow for Suave Creators web development services" title="Soft blue right arrow for Suave Creators web development services" width="18" height="5" aria-hidden="true" decoding="async">
            </div>
          </div>

          <p class="text-[14px] text-[#4D4D4D] mt-1"><?= htmlspecialchars($service[3]) ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="web-services__footer">
      <a href="/services/">See All Services</a>
    </div>
  </div>
</section>
<!-- Web Development Services Section End -->

<!-- Core Values Section Start -->
<section
  class="  full-bleed core-values bg-[url('/images/background_core_values.png')] bg-cover bg-top bg-no-repeat py-12 lg:py-20">
  <svg class="core-values__symbols" aria-hidden="true">
    <symbol id="core-value-innovation" viewBox="0 0 24 24">
      <path d="M9 18h6M10 21h4M8.3 14.7a7 7 0 1 1 7.4 0c-.9.6-1.4 1.5-1.5 2.3H9.8c-.1-.8-.6-1.7-1.5-2.3Z" />
      <path d="M12 2V.5M4.9 4.9 3.8 3.8M19.1 4.9l1.1-1.1" />
    </symbol>
    <symbol id="core-value-quality" viewBox="0 0 24 24">
      <path d="m12 2 7 3v5c0 4.6-2.8 8.8-7 10.5C7.8 18.8 5 14.6 5 10V5l7-3Z" />
      <path d="m8.8 11.1 2 2 4.6-4.7" />
    </symbol>
    <symbol id="core-value-trust" viewBox="0 0 24 24">
      <circle cx="12" cy="8" r="4" />
      <path d="M8.5 12.5 7.8 21l4.2-2.3 4.2 2.3-.7-8.5" />
    </symbol>
    <symbol id="core-value-customer" viewBox="0 0 24 24">
      <circle cx="12" cy="7" r="4" />
      <path d="M4.5 21c.3-5 3-8 7.5-8s7.2 3 7.5 8" />
    </symbol>
  </svg>

  <div class="core-values__inner section-inner">
    <header class="core-values__header">
      <div class="flex items-start gap-2 mb-4">
        <span class="inline-block w-[2px] h-[16px] bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8] rounded-full"></span>
        <span
          class="text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block">
          Our Core Values
        </span>
      </div>
      <div class="core-values__heading">
        <h2>The Pillars Behind Our Excellence</h2>
        <p>We believe in offering seamless, effective, and custom-made solutions, which cater for your specific future
          goals</p>
      </div>
    </header>

    <?php
    $coreValues = [
      ['innovation', 'Innovation', 'We work with future trends and the latest technologies.', '/images/conference-table-analytics-whiteboard.webp', 'Innovation-focused software team reviewing analytics on a conference table'],
      ['quality', 'Quality', 'Delivering the best quality, ensuring our clients get nothing less than the best.', '/images/financial-dashboard-laptop-collaboration.webp', 'Quality-driven financial dashboard collaboration for software excellence'],
      ['trust', 'Trust', 'We build trust by focusing on the exact client requirements.', '/images/diverse-team-data-meeting.webp', 'Trusted diverse team aligning on client requirements with data insights'],
      ['customer', 'Customer Focus', 'We put our clients at the heart of everything we build.', '/images/summary-report-team-meeting.webp', 'Customer focused team reviewing a summary report in a client meeting'],
    ];
    ?>
    <div class="core-values__grid">
      <?php foreach ($coreValues as $value): ?>
        <article class="core-value-card">
          <div class="core-value-card__content">
            <svg class="core-value-card__icon" aria-hidden="true">
              <use href="#core-value-<?= htmlspecialchars($value[0]) ?>"></use>
            </svg>
            <div class="core-value-card__text">
              <h3><?= htmlspecialchars($value[1]) ?></h3>
              <p><?= htmlspecialchars($value[2]) ?></p>
            </div>
          </div>
          <div class="core-value-card__image">
            <img src="<?= htmlspecialchars($value[3]) ?>" alt="<?= htmlspecialchars($value[4]) ?>" title="<?= htmlspecialchars($value[4]) ?>" loading="lazy">
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- Core Values Section End -->

<!-- Digital Marketing Services Section Start -->
<section
  class="full-bleed digital-marketing-services bg-[url('/images/market-bg.png')] py-12 lg:py-[80px] bg-cover bg-top bg-no-repeat "
  aria-labelledby="digital-marketing-title">
  <div class="digital-marketing-services__inner section-inner">
    <header class="digital-marketing-services__header">
      <div class="flex items-center gap-2 mb-4">
        <span class="inline-block w-[2px] h-[16px] bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8] rounded-full"></span>
        <span
          class="text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block">
          Digital Marketing Services
        </span>
      </div>
      <div class="digital-marketing-services__intro">
        <h2 id="digital-marketing-title" class="font-semibold text-[24px] text-[#171717] leading-[100%] mb-4">Transform
          Online Engagement Into Real Business Results</h2>
        <p class="text-[14px] text-[#4D4D4D] leading-[100%]">By optimising your UX, leveraging SEO, writing quality
          content, and integrating AI, chatbots, etc, for
          unparalleled success.</p>
      </div>
    </header>

    <?php
    $digitalMarketingServices = [
      [
        '/images/market-icon-1.svg',
        'Search Engine Optimization',
        'Boost Your Organic Visibility',
        'With our expertise, we enhance the online visibility of your professional website.',
        '/images/seo-infographic-on-imac.webp',
        'SEO analytics dashboard for search engine optimization services',
      ],
      [
        '/images/market-icon-2.svg',
        'Pay-Per-Click Advertising',
        'Instant Reach, Tangible Results',
        'Reach high-intent audiences quickly with focused campaigns that maximise conversions and measurable ROI.',
        '/images/ppc-campaign-planning.webp',
        'PPC advertising campaign planning for higher conversions',
      ],
      [
        '/images/market-icon-3.svg',
        'Social Media Marketing',
        'Engage & Grow Your Community',
        'Build meaningful connections with relevant content that inspires engagement, loyalty, and lasting growth.',
        '/images/social-media-marketing-mobile.webp',
        'Social media marketing content strategy on a mobile device',
      ],
      [
        '/images/market-icon-4.svg',
        'Content Strategy & Planning',
        'Plan. Create. Convert.',
        'Turn ideas into purposeful content that strengthens your brand and guides customers to act.',
        '/images/content-strategy-team-planning.webp',
        'Content strategy team planning digital marketing campaigns',
      ],
      [
        '/images/market-icon-5.svg',
        'Online Reputation Management',
        'Protect Trust. Build Credibility.',
        'Monitor brand conversations and strengthen the online reputation that shapes customer confidence.',
        '/images/online-reputation-admin-dashboard.webp',
        'Online reputation management review of brand sentiment analytics',
      ],
      [
        '/images/market-icon-6.svg',
        'Answer Engine Optimization',
        'Be the Answer Customers Find',
        'Structure authoritative content so voice assistants and answer engines can surface your expertise.',
        '/images/answer-engine-inspiration-mindmap.webp',
        'Answer engine optimization content planning for AI search',
      ],
      [
        '/images/market-icon-7.svg',
        'Generative Engine Optimization',
        'Stay Visible in AI Search',
        'Position your brand for discovery across generative platforms with trusted content and clear signals.',
        '/images/generative-engine-dev-team-coding.webp',
        'Generative engine optimization for brand visibility in AI search',
      ],
    ];
    ?>

    <div class="digitalMarketingSwiper swiper">
      <div class="swiper-wrapper py-4">
        <?php foreach ($digitalMarketingServices as $index => $service): ?>
          <div class="swiper-slide">
            <article class="digital-marketing-card">
              <div class="digital-marketing-card__topline">
                <img src="<?= htmlspecialchars($service[0]) ?>" alt="<?= htmlspecialchars($service[1]) ?>"
                  class="digital-marketing-card__icon" aria-hidden="true">
                <span class="digital-marketing-card__number"
                  aria-hidden="true"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
              </div>
              <p class="digital-marketing-card__service-title"><?= htmlspecialchars($service[1]) ?></p>
              <figure class="digital-marketing-card__image">
                <img src="<?= htmlspecialchars($service[4]) ?>" alt="<?= htmlspecialchars($service[5]) ?>" width="640"
                  height="420" loading="lazy">
              </figure>
              <div class="digital-marketing-card__content">
                <h3><?= htmlspecialchars($service[2]) ?></h3>
                <p><?= htmlspecialchars($service[3]) ?></p>
              </div>
              <span class="digital-marketing-card__arrow" aria-hidden="true">
                <svg xmlns="https://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                  stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-move-right-icon lucide-move-right">
                  <path d="M18 8L22 12L18 16"></path>
                  <path d="M2 12H22"></path>
                </svg>
              </span>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="digital-marketing-services__footer">
      <div class="digital-marketing-services__controls hidden gap-2 md:flex">
        <button class="digital-marketing-prev digital-marketing-control" type="button"
          aria-label="Previous digital marketing service">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="digital-marketing-next digital-marketing-control" type="button"
          aria-label="Next digital marketing service">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="digital-marketing-pagination flex md:hidden" aria-label="Digital marketing pagination"></div>
      <p class="digital-marketing-services__more">
        <span class="digital-marketing-services__more-text">Need more services based on your demand?</span>
        <a href="/services">See All Services</a>
      </p>
    </div>
  </div>
</section>
<!-- Digital Marketing Services Section End -->

<!-- Digital Services Marquee Section Start -->
<?php
$digitalServicesMarqueeItems = [
  ['Web Development', 'outlined', 'filled'],
  ['Promotion Marketing', 'filled', 'outlined'],
  ['Advertising', 'outlined', 'filled'],
  ['CRM Development', 'filled', 'outlined'],
];
?>
<section class="full-bleed full-bleed--edge digital-services-marquee"
  aria-label="Web Development, Promotion Marketing, Advertising, and CRM Development" tabindex="0">
  <div class="digital-services-marquee__track">
    <?php for ($group = 0; $group < 2; $group++): ?>
      <div class="digital-services-marquee__group"<?= $group === 1 ? ' aria-hidden="true"' : '' ?>>
        <?php foreach (array_merge($digitalServicesMarqueeItems, $digitalServicesMarqueeItems) as $item): ?>
          <span class="digital-services-marquee__label digital-services-marquee__label--<?= htmlspecialchars($item[1]) ?>"><?= htmlspecialchars($item[0]) ?></span>
          <span class="digital-services-marquee__separator digital-services-marquee__separator--<?= htmlspecialchars($item[2]) ?>" aria-hidden="true"></span>
        <?php endforeach; ?>
      </div>
    <?php endfor; ?>
  </div>
</section>
<!-- Digital Services Marquee Section End -->

<!-- Portfolio Showcase Section Start -->
<section
  class="full-bleed portfolio-showcase bg-[url('/images/portfolio-bg.png')] bg-cover bg-top bg-no-repeat py-12 lg:py-[80px]"
  aria-labelledby="portfolio-showcase-title">
  <div class="portfolio-showcase__pattern" aria-hidden="true"></div>
  <div class="portfolio-showcase__container section-inner">
    <header class="portfolio-showcase__header">
      <p
        class="offerings-eyebrow text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">
        Our Portfolio
      </p>
      <h2 id="portfolio-showcase-title"
        class="mt-1 sm:mt-4 text-[20px] font-semibold leading-[28px] sm:leading-[36px] tracking-[-0.025em] text-[#171717] sm:text-[18px] lg:text-[24px]">
        Projects That Define Our Expertise</h2>
      <p
        class="portfolio-showcase__intro mx-auto mt-1 sm:mt-4 max-w-[605px] text-[13px] leading-[19px] sm:text-[14px] sm:leading-[24px] text-[#4D4D4D]">
        Check out our best portfolio, which defines our expertise and different
        industries.</p>
    </header>

    <?php
    $portfolioShowcaseProjects = [
      [
        'category' => 'CRM Development',
        'title' => 'Suave Outreach CRM Platform',
        'description' => 'An AI-assisted outreach CRM for discovering leads, enriching business context, and sending personalized emails.',
        'image' => '/images/suave-outreach-crm-laptop.webp',
        'alt' => 'Suave Creators outreach CRM platform on a laptop display',
      ],
      [
        'category' => 'Custom Software',
        'title' => 'Sales Automation Project Dashboard',
        'description' => 'A project workspace for tracking sales automation rollouts, task priorities, and team progress in one place.',
        'image' => '/images/sales-automation-project-dashboard.webp',
        'alt' => 'Sales automation project dashboard software by Suave Creators',
      ],
      [
        'category' => 'Web Development',
        'title' => 'MAVAN Growth Agency Website',
        'description' => 'A conversion-focused site for a growth agency that embeds elite talent to solve complex scaling problems.',
        'image' => '/images/mavan-growth-agency-website.webp',
        'alt' => 'MAVAN growth agency website built by Suave Creators',
      ],
      [
        'category' => 'Web Design',
        'title' => 'HubOps Software Company Website',
        'description' => 'A high-impact marketing site for a custom software company focused on SaaS, APIs, and industry solutions.',
        'image' => '/images/hubops-software-company-website.webp',
        'alt' => 'HubOps custom software company website by Suave Creators',
      ],
      [
        'category' => 'Web Design',
        'title' => 'Swastik Culture Hub Website',
        'description' => 'A digital hub for Indian history, art, and culture with curated libraries and original series.',
        'image' => '/images/swastik-culture-hub-website.webp',
        'alt' => 'Swastik culture hub website for history art and culture content',
      ],
      [
        'category' => 'AI Product',
        'title' => 'Ematrics AI Sales Website',
        'description' => 'A product site for an AI sales catalyst that trains reps, assists live calls, and delivers post-call analytics.',
        'image' => '/images/ematrics-ai-sales-website.webp',
        'alt' => 'Ematrics AI sales catalyst website built by Suave Creators',
      ],
    ];
    ?>
    <div class="swiper portfolioShowcaseSwiper">
      <div class="swiper-wrapper">
        <?php foreach ($portfolioShowcaseProjects as $project): ?>
          <div class="swiper-slide">
            <article class="portfolio-showcase__card">
              <div class="portfolio-showcase__image">
                <img src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['alt']) ?>" title="<?= htmlspecialchars($project['alt']) ?>" loading="lazy" draggable="false">
              </div>
              <div class="portfolio-showcase__copy">
                <p
                  class="inline-block text-[12px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent mb-2">
                  <?= htmlspecialchars($project['category']) ?>
                </p>
                <h3 class="text-[14px] font-semibold text-[#171717] max-w-[300px] leading-[18px] mb-2"><?= htmlspecialchars($project['title']) ?></h3>
                <p class=" text-[14px] text-[#4D4D4D] max-w-[360px] "><?= htmlspecialchars($project['description']) ?></p>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="portfolio-showcase__footer">
      <div class="portfolio-showcase__controls">
        <button class="portfolio-showcase-prev portfolio-showcase__control" type="button"
          aria-label="Previous portfolio project">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="portfolio-showcase-next portfolio-showcase__control" type="button"
          aria-label="Next portfolio project">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <p class="digital-marketing-services__more">
        <span>Discuss your project</span>
        <a href="/services">Discuss your Vision</a>
      </p>
    </div>
  </div>
</section>
<!-- Portfolio Showcase Section End -->

<!-- Industries We Serve Section Start -->
<section
  class="full-bleed industries-served bg-[url('/images/industry-bg.png')] bg-cover bg-top bg-no-repeat py-12 lg:py-[80px] "
  aria-labelledby="industries-served-title">
  <div class="industries-served__inner section-inner">
    <header class="core-values__header">
      <div class="flex items-start gap-2 mb-4">
        <span class="inline-block w-[2px] h-[16px] bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8] rounded-full"></span>
        <span
          class="text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block">
          Industries We Serve
        </span>
      </div>
      <div class="core-values__heading">
        <h2>Industries We Serve</h2>
        <p>Empowering multiple industries with tailored digital and smart solutions designed to drive growth,
          innovation, and long-lasting impact.</p>
      </div>
    </header>

    <?php
    $industriesServed = [
      [
        'fa-solid fa-heart-pulse',
        'Custom Healthcare Software Development Services',
        'By leveraging our deep industry expertise and top-level technologies, such as AI and chatbots, we develop innovative healthcare software solutions designed to improve care and efficiency.',
      ],
      [
        'fa-solid fa-gears',
        'IT Services for Startups with Innovative Technology',
        'Get tailored IT services and software development solutions that empower startups to innovate, grow, and compete in a fast-paced digital economy.',
      ],
      [
        'fa-solid fa-landmark',
        'We develop Smart Financial Software',
        'We help you create secure banking and financial solutions, from mobile banking experiences to comprehensive software for financial institutions.',
      ],
      [
        'fa-solid fa-cart-shopping',
        'Elevating E-Commerce With AI-Powered Solutions',
        'We develop next-generation, reliable, and feature-rich e-commerce solutions that empower businesses, delight customers, and improve sales performance.',
      ],
      [
        'fa-solid fa-truck-fast',
        'We develop Logistics & Supply Chain Apps',
        'We build logistics software that helps supply chains move faster with greater speed, reliability, visibility, and cost efficiency.',
      ],
      [
        'fa-solid fa-laptop-file',
        'E-Learning Software Development Services',
        'We deliver education and e-learning software for schools, colleges, training platforms, and online learning portals.',
      ],
    ];
    ?>

    <div class="industries-served__grid">
      <?php foreach ($industriesServed as $industry): ?>
        <article class="industry-card">
          <i class="industry-card__icon <?= htmlspecialchars($industry[0]) ?>" aria-hidden="true"></i>
          <h3><?= htmlspecialchars($industry[1]) ?></h3>
          <p><?= htmlspecialchars($industry[2]) ?></p>

          <span class="industry-card__arrow" aria-hidden="true">
            <img src="/images/soft-white-right-arrow.png" alt="Soft white right arrow for Suave Creators industry navigation" title="Soft white right arrow for Suave Creators industry navigation" width="18" height="5" aria-hidden="true" decoding="async">
          </span>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="industries-served__project">
      <a href="/contact-us/#contact-id" class="border-b border-white/70 text-sm font-semibold text-white">Discuss your
        Project</a>
    </div>

    <aside class="industries-support" aria-label="Online platform services support">
      <div class="industries-support__copy">
        <p>The Services and Supports You Need for Online Platforms in Suave Creators</p>
        <a href="/contact-us/#contact-id">
          Talk to an Expert <svg xmlns="https://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1">
            <path d="M18 8L22 12L18 16"></path>
            <path d="M2 12H22"></path>
          </svg>
        </a>
      </div>
      <div class="industries-support__illustration" aria-hidden="true">
        <img src="/images/chat.png" alt="">
      </div>
    </aside>
  </div>
</section>
<!-- Industries We Serve Section End -->
<!-- Technology Section Start -->
<section class="full-bleed bg-[url('/images/web-bg.png')] bg-cover bg-top bg-no-repeat py-12 lg:py-20">
  <div class="section-inner">
    <div class="grid gap-2 md:gap-6 lg:grid-cols-[200px_1fr] lg:gap-12">
      <div class="flex items-start gap-2 mb-4">
        <span class="inline-block w-[2px] h-[16px] bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8] rounded-full"></span>
        <span
          class="text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block">
          Industries We Serve
        </span>
      </div>
      <div class="max-w-[760px]">
        <h2 class="text-2xl font-semibold leading-tight text-[#171717]">The Technology Behind Our Solutions</h2>
        <p class="mt-2 sm:mt-5 text-sm leading-6 text-[#4D4D4D]">
          We use modern development frameworks to create smart software solutions that are fast, flexible, and designed
          for long-term growth. From AI to cloud computing, we integrate technologies that help businesses stay ahead of
          the curve.
        </p>
      </div>
    </div>

    <?php
    $technologies = [
      ['Laravel', 'Laravel is ideal for high-performing, data-driven, enterprise-level web solutions.', 'fa-laravel', '#FF2D20'],
      ['React', 'We create responsive user experiences for modern web and mobile applications.', 'fa-react', '#149ECA'],
      ['Angular', 'We build dynamic, modular architectures with strong performance and security.', 'fa-angular', '#DD0031'],
      ['Node.js', 'It powers real-time data processing and scalable server-side applications.', 'fa-node-js', '#68A063'],
      ['Vue.js', 'We create flexible user interfaces and fast single-page applications.', 'fa-vuejs', '#42B883'],
      ['WordPress', 'The popular CMS for websites, blogs, and e-commerce solutions.', 'fa-wordpress', '#21759B'],
      ['Shopify', 'Secure payments and inventory management for high-converting online stores.', 'fa-shopify', '#7AB55C'],
      ['Magento', 'Robust catalog management, multi-store setups, and personalized shopping.', 'fa-magento', '#F26322'],
    ];
    ?>
    <div
      class="mt-8 sm:mt-14 grid overflow-hidden border-l border-t border-[#ECECEC] grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
      <?php foreach ($technologies as $technology): ?>
        <article class="technology-card group relative min-h-[190px] border-b border-r border-[#ECECEC] bg-white p-5"
          style="--technology-color: <?= htmlspecialchars($technology[3]) ?>">
          <span
            class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            style="background: radial-gradient(circle at 100% 100%, color-mix(in srgb, var(--technology-color) 12%, transparent), transparent 58%);"></span>
          <i class="fa-brands <?= htmlspecialchars($technology[2]) ?> relative text-[30px]"
            style="color: <?= htmlspecialchars($technology[3]) ?>" aria-hidden="true"></i>
          <h3 class="relative mt-3 text-base font-bold text-[#171717]"><?= htmlspecialchars($technology[0]) ?></h3>
          <p class="relative mt-2 pr-5 text-sm leading-[22px] text-[#4D4D4D]"><?= htmlspecialchars($technology[1]) ?></p>
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2A4DFB"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-move-right-icon lucide-move-right absolute bottom-5 right-5 ">
            <path d="M18 8L22 12L18 16"></path>
            <path d="M2 12H22"></path>
          </svg>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="mt-8 flex justify-end">
      <a href="/contact-us/#contact-id" class="border-b border-[#2A4DFB] text-sm font-semibold text-[#2A4DFB]">Book
        a Consultation</a>
    </div>
  </div>
</section>
<!-- Technology Section End -->


<!-- FAQ Section Start -->
<section class="full-bleed faq-section" aria-labelledby="faq-heading">
  <div class="faq-section__inner section-inner">
    <div class="faq-section__intro">
      <p class="faq-section__eyebrow flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>

        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent font-bold text-[14px]">
          Have questions about our Web Services?
        </span>
      </p>
      <h2 id="faq-heading">Frequently Ask Question</h2>
      <p class="faq-section__description">Here are the most asked questions based on feedback from our users.</p>
      <?php require __DIR__ . '/partials/faq-cta-button.php'; ?>
      <img class="faq-section__image" src="/images/faq-gif.gif" alt="Business team collaborating around a table"
        width="640" height="960" loading="lazy">
    </div>

    <?php
    $faqs = [
      ['What services do you offer?', 'We offer the best web, software, CMS, CRM and custom development services in all the latest languages.'],
      ['How long does it take to build a website?', 'Most website projects take 6–12 weeks, depending on complexity, integrations, and how quickly content and feedback are provided.'],
      ['Do you provide ongoing support?', 'Yes. We offer maintenance, security updates, performance monitoring, and feature development after launch.'],
      ['Can you redesign my existing website?', 'Yes. We can modernize the design, improve the user experience, migrate content, and preserve important SEO value.'],
      ['Will my website be mobile-friendly?', 'Yes. Every website we build is responsive and tested across modern phones, tablets, and desktop browsers.'],
      ['Do you optimize websites for speed and SEO?', 'Yes. Technical SEO, semantic markup, image optimization, caching, and performance testing are part of our delivery process.'],
      ['How can digital marketing help my business?', 'A focused strategy can increase qualified traffic, improve conversions, and create measurable, repeatable customer acquisition.'],
    ];
    ?>
    <div class="faq-list">
      <?php foreach ($faqs as $index => $faq): ?>
        <?php $faqNumber = $index + 1; ?>
        <div class="faq-item<?= $index === 0 ? ' is-open' : '' ?>">
          <button type="button" class="faq-item__summary" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>"
            aria-controls="faq-answer-<?= $faqNumber ?>" id="faq-question-<?= $faqNumber ?>">
            <span><?= htmlspecialchars($faq[0]) ?></span>
            <i class="fa-solid fa-chevron-down faq-item__chevron" aria-hidden="true"></i>
          </button>
          <div class="faq-item__answer" id="faq-answer-<?= $faqNumber ?>" role="region"
            aria-labelledby="faq-question-<?= $faqNumber ?>" aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
            <div class="faq-item__answer-inner">
              <p><?= htmlspecialchars($faq[1]) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- FAQ Section End -->


<?php require __DIR__ . '/partials/testimonials-section.php'; ?>

<?php
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
$articlesInsightsHeadingId = 'articles-insights-title';
$articlesInsightsMoreHref = '/blogs';
$articlesInsightsMoreLabel = 'View More';
require __DIR__ . '/partials/articles-insights.php';
?>

<!-- Consultation CTA Section Start -->
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
        <div class="consultation-people__column">
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
<!-- Consultation CTA Section End -->

<!-- Partnerships Section Start -->
<section class="full-bleed partnership-section bg-repeat"
  style="background-image: url('/images/pattern_portfolio.png');"
  aria-label="Client partnerships">
  <div class="partnership-inner section-inner text-center">
    <p
      class="offerings-eyebrow mb-8 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
      Our Partnerships &amp; Growth Stack
    </p>

    <?php
    $partners = [
      ['/images/client-logo-4.png', 'VerySoul'],
      ['/images/client-logo-6.svg', 'RedSixity'],
      ['/images/client-logo-7.png', 'DAJJ Logistics'],
      ['/images/client-logo-8.png', 'Ematrics'],
      ['/images/client-logo-1.png', 'BioAssay Systems'],
    ];
    ?>
    <div class="partnership-marquee" tabindex="0">
      <div class="partnership-marquee__track">
        <?php for ($group = 0; $group < 2; $group++): ?>
          <div class="partnership-marquee__group"<?= $group === 1 ? ' aria-hidden="true"' : '' ?>>
            <?php foreach (array_merge($partners, $partners) as $partner): ?>
              <div class="partnership-tile">
                <img src="<?= htmlspecialchars($partner[0]) ?>"
                  alt="<?= htmlspecialchars($partner[1]) ?> logo partner of Suave Creators"
                  title="<?= htmlspecialchars($partner[1]) ?> logo partner of Suave Creators" width="120" height="48"
                  decoding="async"<?= $group === 0 ? ' loading="lazy"' : '' ?>>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>
<!-- Partnerships Section End -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper !== 'undefined') {
      new Swiper('.offeringsSwiper', {
        slidesPerView: 1,
        spaceBetween: 16,
        speed: 650,
        rewind: true,
        watchOverflow: true,
        navigation: { nextEl: '.offerings-next', prevEl: '.offerings-prev' },
        pagination: {
          el: '.offerings-pagination',
          clickable: true
        },
        breakpoints: {
          768: { slidesPerView: 2, spaceBetween: 18 },
          1024: { slidesPerView: 3, spaceBetween: 20 },
          1200: { slidesPerView: 4, spaceBetween: 20 }
        }
      });

      new Swiper('.digitalMarketingSwiper', {
        slidesPerView: 1,
        spaceBetween: 16,
        speed: 650,
        watchOverflow: true,
        navigation: {
          nextEl: '.digital-marketing-next',
          prevEl: '.digital-marketing-prev'
        },
        pagination: {
          el: '.digital-marketing-pagination',
          clickable: true
        },
        breakpoints: {
          768: { slidesPerView: 2, spaceBetween: 18 },
          1024: { slidesPerView: 3, spaceBetween: 18 },
          1200: { slidesPerView: 4, spaceBetween: 20 }
        }
      });

      new Swiper('.portfolioShowcaseSwiper', {
        slidesPerView: 1,
        spaceBetween: 16,
        speed: 650,
        allowTouchMove: true,
        simulateTouch: true,
        grabCursor: true,
        touchEventsTarget: 'container',
        touchStartPreventDefault: false,
        watchOverflow: true,
        navigation: {
          nextEl: '.portfolio-showcase-next',
          prevEl: '.portfolio-showcase-prev'
        },
        breakpoints: {
          768: { slidesPerView: 2, spaceBetween: 20 },
          1024: { slidesPerView: 3, spaceBetween: 24 }
        }
      });

      new Swiper('.testimonialSwiper', {
        direction: window.matchMedia('(min-width: 1024px)').matches ? 'vertical' : 'horizontal',
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        speed: 700,
        autoplay: { delay: 4500, disableOnInteraction: false, pauseOnMouseEnter: true },
        navigation: { nextEl: '.testimonial-next', prevEl: '.testimonial-prev' },
        pagination: {
          el: '.testimonial-pagination',
          clickable: true
        },
        breakpoints: {
          768: { spaceBetween: 16 },
          1024: { slidesPerView: 2, spaceBetween: 24 }
        }
      });

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
        if (
          event.propertyName === 'height' &&
          faqAnimationTokens.get(item) === token &&
          item.classList.contains('is-open')
        ) {
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
        if (
          event.propertyName === 'height' &&
          faqAnimationTokens.get(item) === token &&
          !item.classList.contains('is-open')
        ) {
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
.about-values {
  display: flex;
  flex-direction: column;
  gap: var(--space-5);
}

.about-values__item {
  align-items: center;
  display: flex;
  gap: var(--space-4);
  min-width: 0;
}

.about-values__icon {
  align-items: center;
  border-radius: 50%;
  display: grid;
  flex-shrink: 0;
  height: 58px;
  justify-items: center;
  place-items: center;
  width: 58px;
}

.hero-media-grid {
  aspect-ratio: 670 / 512;
  column-gap: calc(12 / 670 * 100%);
  display: grid;
  flex-shrink: 0;
  grid-template-columns: 314fr 344fr;
  grid-template-rows: 124fr 368fr;
  max-width: 670px;
  row-gap: calc(20 / 512 * 100%);
  width: 100%;
}

.hero-media-grid__tile {
  height: 100%;
  min-height: 0;
  min-width: 0;
  width: 100%;
}

.about-collage {
  --collage-gap: 12px;
  --col-left: 190px;
  --col-center: 180px;
  --col-right: 154px;
  align-items: start;
  display: grid;
  gap: var(--collage-gap);
  grid-template-columns: var(--col-left) var(--col-center) var(--col-right);
  justify-content: center;
  margin-inline: auto;
  max-width: 100%;
  width: max-content;
}

.about-collage__column {
  display: flex;
  flex-direction: column;
  gap: var(--collage-gap);
  min-width: 0;
}

.about-collage__column--left {
  padding-top: 60px;
  width: var(--col-left);
}

.about-collage__column--center {
  width: var(--col-center);
}

.about-collage__column--right {
  padding-top: 74px;
  width: var(--col-right);
}

.about-collage__tile {
  background: #e9ebf2;
  border-radius: 7.78px;
  box-shadow: 0 5px 14px rgb(24 31 63 / 8%);
  flex-shrink: 0;
  margin: 0;
  overflow: hidden;
}

.about-collage__tile img {
  display: block;
  height: 100%;
  object-fit: cover;
  width: 100%;
}

.about-collage__tile--team {
  align-self: flex-end;
  height: 90px;
  width: 120px;
}

.about-collage__tile--portrait-tall {
  height: 240px;
  width: 190px;
}

.about-collage__tile--office-small {
  align-self: flex-end;
  height: 90px;
  width: 120px;
}

.about-collage__tile--leader {
  height: 140px;
  width: 180px;
}

.about-collage__tile--portrait-main {
  height: 280px;
  width: 180px;
}

.about-collage__tile--office-wide {
  height: 120px;
  width: 180px;
}

.about-collage__tile--portrait-right {
  height: 140px;
  width: 154px;
}

.about-collage__tile--meeting {
  height: 112px;
  width: 154px;
}

.about-collage__tile--meeting-sm {
  height: 94px;
  width: 124px;
}

.about-collage__tile--portrait-tall img,
.about-collage__tile--portrait-main img {
  object-position: center top;
}

.offeringsSwiper {
  overflow: hidden;
}

.offerings-card__image {
  aspect-ratio: 1.3 / 1;
  background: #eef0f6;
  border-radius: 8px;
  overflow: hidden;
}

.offerings-card__image img {
  display: block;
  height: 100%;
  object-fit: cover;
  transition: transform 0.45s ease;
  width: 100%;
}

.offerings-card:hover .offerings-card__image img {
  transform: scale(1.025);
}

.offerings-card h3 {
  color: #171717;
  font-size: 14px;
  font-weight: 600;
  line-height: 100%;
}

.offerings-card p {
  color: #4d4d4d;
  font-size: 14px;
  line-height: 20px;
  margin-top: 4px;
  max-width: 97%;
  font-weight: 500;
}

.offerings-expert-link {
  font-size: 14px;
  font-weight: 600;
  text-decoration: underline;
  text-underline-offset: 3px;
  background: linear-gradient(90deg, #2A4DFB 57.12%, #0026E3 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  color: transparent;
}

.digital-marketing-services__header {
  align-items: start;
  display: grid;
  gap: 20px;
  grid-template-columns: minmax(190px, 0.36fr) minmax(0, 1fr);
}

.digitalMarketingSwiper {
  margin-top: 48px;
  overflow: hidden;
}

.digital-marketing-card {
  --digital-card-accent: #2a4dfb;
  background: #fff;
  border: none;
  border-radius: 11px;
  display: flex;
  flex-direction: column;
  height: 100%;
  min-height: 375px;
  overflow: hidden;
  padding: 16px;
  position: relative;
  transition: box-shadow 0.25s ease, transform 0.25s ease;
}

.digital-marketing-card:hover {
  box-shadow: 2px 5px 23px -2px #00003F24;
  transform: translateY(-2px);
}

.digital-marketing-card__topline {
  align-items: center;
  display: flex;
  justify-content: space-between;
  min-height: 30px;
  position: relative;
}

.digital-marketing-card__icon {
  color: var(--digital-card-accent);
  display: block;
  flex: 0 0 22px;
  font-size: 20px;
  height: 22px;
  object-fit: contain;
  position: relative;
  text-align: center;
  transition: filter 0.2s ease;
  width: 22px;
  z-index: 1;
}

.digital-marketing-card__service-title {
  color: #00003F;
  font-size: 16px;
  font-weight: 700;
  line-height: 1.25;
  margin-top: 5px;
  position: relative;
  transition: color 0.2s ease;
  z-index: 1;
}

.digital-marketing-card:hover .digital-marketing-card__service-title {
  color: #2A4DFB;
}

.digital-marketing-card:hover .digital-marketing-card__icon {
  filter: brightness(0) saturate(100%) invert(32%) sepia(90%) saturate(2500%) hue-rotate(222deg) brightness(98%) contrast(101%);
}

.digital-marketing-card__number {
  color: #F7F8F8;
  font-family: "Roboto Flex", "PP Mori", ui-sans-serif, system-ui, sans-serif;
  font-size: 34px;
  font-weight: 800;
  letter-spacing: -0.02em;
  line-height: 1;
  pointer-events: none;
  position: absolute;
  right: 0;
  text-align: right;
  top: -8px;
  z-index: 0;
}

.digital-marketing-card__image {
  aspect-ratio: 16 / 10;
  background: transparent;
  border-radius: 8px;
  margin-top: 10px;
  overflow: hidden;
}

.digital-marketing-card__image img {
  display: block;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
  width: 100%;
}

.digital-marketing-card:hover .digital-marketing-card__image img {
  transform: scale(1.025);
}

.digital-marketing-card__content {
  padding-top: 14px;
}

.digital-marketing-card__content h3 {
  color: #171717;
  font-size: 14px;
  font-weight: 600;
  line-height: 100%;
}

.digital-marketing-card__content p {
  color: #4D4D4D;
  font-size: 14px;
  line-height: 1.5;
  margin-top: 8px;
}

.digital-marketing-card__arrow {
  align-items: center;
  color: #2a4dfb;
  display: inline-flex;
  font-size: 12px;
  justify-content: center;
  margin-left: auto;
  margin-top: auto;
  padding-top: 10px;
}

.digital-marketing-services__footer {
  align-items: center;
  display: flex;
  justify-content: space-between;
  margin-top: 36px;
}

.digital-marketing-services__controls {
  display: flex;
  gap: 7px;
}

.digital-marketing-control {
  align-items: center;
  background: #030343;
  border: 0;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  display: inline-flex;
  font-size: 8px;
  height: 32px;
  justify-content: center;
  transition: background-color 0.2s ease, opacity 0.2s ease, transform 0.2s ease;
  width: 32px;
}

.digital-marketing-control:hover {
  background: #2a4dfb;
  transform: translateY(-1px);
}

.digital-marketing-control:focus-visible,
.digital-marketing-services__more a:focus-visible {
  outline: 2px solid #2a4dfb;
  outline-offset: 3px;
}

.digital-marketing-services__more span {
  color: #00003F;
  font-size: 14px;
  font-weight: 600;
  line-height: 1.5;
  text-decoration: underline;
}

.digital-marketing-services__more a {
  color: #2a4dfb;
  margin-left: 8px;
  text-decoration: underline;
  text-underline-offset: 3px;
  font-size: 14px;
  font-weight: 600;
}

.industries-support {
  align-items: center;
  background: linear-gradient(90deg, #2A4DFB 0%, #7A5FF8 100%);
  border: 1px solid rgb(255 255 255 / 12%);
  border-radius: 13px;
  box-shadow: 3px 6px 14px -2px #2A4DFB29;
  display: flex;
  justify-content: space-between;
  margin: 39px auto 0;
  max-width: 1180px;
  min-height: 135px;
  overflow: hidden;
  padding: 18px 24px;
  position: relative;
}

.industries-support::before {
  background: linear-gradient(115deg, transparent 44%, rgb(255 255 255 / 7%) 45%, transparent 46%);
  content: "";
  inset: 0;
  pointer-events: none;
  position: absolute;
}

.industries-support__copy {
  position: relative;
  z-index: 1;
}

.industries-support__copy p {
  color: #ffffff;
  font-size: 20px;
  font-weight: 500;
  line-height: 1.35;
}

.industries-support__copy a {
  align-items: center;
  background: #fff;
  border-radius: 999px;
  box-shadow: 3px 7px 22px -6px #2A4DFB24;
  color: #2A4DFB;
  display: inline-flex;
  font-size: 14px;
  font-weight: 700;
  gap: 7px;
  margin-top: 12px;
  min-height: 29px;
  padding: 7px 16px;
  transition: box-shadow 180ms ease, transform 180ms ease;
}

.industries-support__copy a i {
  color: #4258e9;
  font-size: 7px;
}

.industries-support__copy a:hover {
  box-shadow: 0 9px 22px rgb(27 25 107 / 30%);
  transform: translateY(-1px);
}

@media (min-width: 1024px) {
  .about-values {
    flex-direction: row;
    flex-wrap: nowrap;
    gap: 6px;
  }

  .about-values__item {
    flex: 1 1 0;
  }
}

@media (max-width: 1023px) {
  .digital-marketing-services {
    padding: 64px 0 58px;
  }

  .digital-marketing-services__header {
    gap: 5px;
    grid-template-columns: 1fr;
  }

  .digitalMarketingSwiper {
    margin-top: 38px;
  }
}

@media (max-width: 767px) {
  /* BG wraps full intro+collage+CTAs block so content stays inside */
  .who-we-are {
    background-image: none !important;
  }

  .who-we-are__intro {
    background-image: var(--who-we-are-bg);
    background-position: 65% 100%;
    background-repeat: no-repeat;
    background-size: 220% auto;
    box-sizing: border-box;
    margin-inline: calc(50% - 50vw);
    padding-block: 24px 32px;
    padding-inline: max(16px, calc(50vw - 186.5px));
    width: 100vw;
  }

  .who-we-are__intro > .mt-0 {
    margin-top: 0;
    position: relative;
    z-index: 1;
  }

  .site-main > .who-we-are.full-bleed > .section-inner,
  .who-we-are > .section-inner {
    box-sizing: border-box;
    grid-column: full;
    justify-self: center;
    margin-inline: auto;
    max-width: 373px;
    padding-inline: 0;
    width: 100%;
  }

  .who-we-are .about-collage {
    --collage-gap: 8px;
    --col-left: 129px;
    --col-center: 123px;
    --col-right: 105px;
    max-width: 100%;
    width: 100%;
  }

  .about-values {
    flex-direction: column;
    display: none;
  }

  .offerings-showcase {
    overflow: visible;
  }

  .offeringsSwiper.swiper {
    overflow: visible !important;
    padding: 8px 6px 20px;
    margin-inline: -6px;
  }

  .offerings-card {
    padding: 10px !important;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 14px rgba(17, 24, 39, 0.08), 0 12px 28px rgba(17, 24, 39, 0.12);
  }

  .about-collage__column--left {
    padding-top: 40px;
  }

  .about-collage__column--right {
    padding-top: 50px;
  }

  .about-collage__tile--team,
  .about-collage__tile--office-small {
    height: 61px;
    width: 81px;
  }

  .about-collage__tile--portrait-tall {
    height: 163px;
    width: 129px;
  }

  .about-collage__tile--leader {
    height: 95px;
    width: 123px;
  }

  .about-collage__tile--portrait-main {
    height: 190px;
    width: 123px;
  }

  .about-collage__tile--office-wide {
    height: 81px;
    width: 123px;
  }

  .about-collage__tile--portrait-right {
    height: 95px;
    width: 105px;
  }

  .about-collage__tile--meeting {
    height: 76px;
    width: 105px;
  }

  .about-collage__tile--meeting-sm {
    height: 64px;
    width: 84px;
  }

  .about-collage__tile {
    border-radius: 6px;
  }

  .offerings-controls,
  .digital-marketing-services__controls {
    display: none !important;
  }

  .offerings-footer,
  .digital-marketing-services__footer {
    align-items: center;
    flex-direction: row;
    gap: 1rem;
  }

  .digital-marketing-services__more-text {
    display: none !important;
  }

  .digital-marketing-services {
    padding: 52px 0 28px;
  }

  .digital-marketing-services__intro h2 {
    font-size: 20px;
    line-height: 28px;
  }

  .digitalMarketingSwiper {
    margin-top: 32px;
  }

  .digital-marketing-card {
    border: 1px solid #e6e9ef;
    border-radius: 11px;
    height: 312px;
    min-height: 312px;
    max-width: 100%;
    padding: 12px;
    width: 373px;
  }

  .digital-marketing-card__image {
    aspect-ratio: 16 / 10;
    margin-top: 8px;
  }

  .digital-marketing-card__image img {
    height: 100%;
  }

  .digital-marketing-card__content {
    padding-top: 10px;
  }

  .digital-marketing-card__service-title {
    font-size: 15px;
  }

  .digital-marketing-card__content h3 {
    font-size: 14px;
  }

  .digital-marketing-card__content p {
    font-size: 13px;
    line-height: 19px;
    margin-top: 6px;
  }

  .digital-marketing-card__arrow {
    padding-top: 6px;
  }

  .digital-marketing-services__footer {
    align-items: center;
    flex-direction: row;
    gap: 1rem;
    margin-top: 14px;
  }

  .digital-marketing-services__more a {
    margin-left: 0;
  }

  .industries-support {
    align-items: flex-start;
    min-height: 150px;
    padding: 22px 20px;
  }

  .industries-support__copy {
    max-width: calc(100% - 40px);
  }

  .industries-support__copy p {
    font-size: 16px;
    font-weight: 400;
    line-height: 22px;
    letter-spacing: 0;
  }

  .industries-support__illustration {
    margin: 0;
    position: absolute;
    right: 10px;
    top: 78px;
    transform: scale(0.72);
    transform-origin: top right;
  }

  .about-values__item {
    flex: none;
    width: 100%;
  }

  .about-values__icon {
    height: 48px;
    width: 48px;
  }

  .hero-media-grid {
    border-radius: 16px;
    max-width: 100%;
  }

  .digital-marketing-card__number {
    font-size: 34px;
    height: 24px;
    width: 38px;
  }
}

@media (prefers-reduced-motion: reduce) {
  .digital-marketing-card,
  .digital-marketing-card__image img {
    transition: none;
  }
}

@media (min-width: 768px) and (max-width: 1023px) {
  .about-values {
    flex-direction: row;
    flex-wrap: wrap;
    gap: var(--space-5);
  }

  .about-values__item {
    flex: 1 1 calc(50% - var(--space-3));
  }

  .about-collage {
    max-width: 100%;
  }

  .hero-media-grid {
    max-width: min(100%, 560px);
  }

  .digital-marketing-card {
    min-height: 0;
  }
}
</style>

<?php require __DIR__ . '/layout/end.php'; ?>