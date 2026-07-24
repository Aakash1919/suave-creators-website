@extends('layouts.frontend')

@section('seo')
    <title>Suave Creators | Web & Software Development Solutions</title>
    <meta name="description" content="We are a trusted Custom Software Development Company that specializes in CRM Development, Web Application, & Enterprise Software Solutions to help businesses grow.">
    <meta property="og:title" content="Suave Creators | Web & Software Development Solutions">
    <meta property="og:description" content="Custom Software, CRM, Web Application & Enterprise Software Development Solutions.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')
<!-- Hero Section Start -->
<section
  class="relative z-10 w-full pb-12 pt-8 md:min-h-[440px] md:pb-16 md:pt-10 lg:min-h-[640px] lg:pb-20 lg:pt-[52px] site-container">
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
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
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
          <img src="/images/hero_gif1.gif" alt="" class="block h-full w-full max-w-none object-cover">
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

<!-- About Section Start -->
<section
  class="full-bleed bg-white bg-[url('/images/background_about.png')] bg-cover bg-top bg-no-repeat py-10 md:py-14 lg:py-20">
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

    <div class="mt-16 grid grid-cols-1 items-start gap-14 lg:mt-20 lg:grid-cols-[1.1fr_0.9fr]">
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
            class="inline-block bg-[linear-gradient(180deg,_#2F69FB_12%,_#C56BFF_100%)] bg-clip-text text-transparent">
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
        <div class=" mt-10 flex flex-wrap items-center gap-5">
          <a href="/about-us"
            class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-[13px] sm:text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 whitespace-nowrap">
            <span>Learn more About Us</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="transition-transform duration-300 group-hover:translate-x-1">
              <path d="M18 8L22 12L18 16"></path>
              <path d="M2 12H22"></path>
            </svg>
          </a>
          <a href="/product" class="border-b border-[#00003F] text-[13px] sm:text-sm font-semibold ">View Our Work</a>
        </div>
      </div>

      <div class="about-collage">
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
    </div>
  </div>
</section>
<!-- About Section End -->

<!-- Offerings Showcase Section Start -->
<section
  class="full-bleed  overflow-hidden bg-[#F9FAFC] bg-[url('/images/background_offerings.png')] bg-cover bg-top bg-no-repeat">
  <div class="section-inner relative z-10 py-12 sm:py-20 lg:py-[80px]">
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
        '/images/expert-1.png',
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

    <div class="smart-together-cta__actions flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:gap-3">
      <a href="/contact-us/#contact-id"
        class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110">
        Get Started
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="transition-transform duration-300 group-hover:translate-x-1">
          <path d="M18 8L22 12L18 16"></path>
          <path d="M2 12H22"></path>
        </svg>
      </a>
      <a href="/contact-us/#contact-id" class="inline-flex max-lg:min-h-[44px] items-end pb-0.5 border-b border-white/70 text-sm font-semibold text-white">
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
<x-frontend.three-card-section />
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
      ['innovation', 'Innovation', 'We work with future trends and the latest technologies.', '/images/portfolio-1.png', 'Modern timber-and-glass building exterior'],
      ['quality', 'Quality', 'Delivering the best quality, ensuring our clients get nothing less than the best.', '/images/portfolio-2.png', 'Bright contemporary living room and kitchen'],
      ['trust', 'Trust', 'We build trust by focusing on the exact client requirements.', '/images/portfolio-3.png', 'Warm modern lounge with plants and artwork'],
      ['customer', 'Customer Focus', 'We put our clients at the heart of everything we build.', '/images/portfolio-4.png', 'Contemporary office with glass meeting rooms'],
    ];
    ?>
    <div class="core-values__grid">
      <?php foreach ($coreValues as $value): ?>
        <article class="core-value-card">
          <div class="core-value-card__content">
            <svg class="core-value-card__icon" aria-hidden="true">
              <use href="#core-value-<?= htmlspecialchars($value[0]) ?>"></use>
            </svg>
            <h3><?= htmlspecialchars($value[1]) ?></h3>
            <p><?= htmlspecialchars($value[2]) ?></p>
          </div>
          <div class="core-value-card__image">
            <img src="<?= htmlspecialchars($value[3]) ?>" alt="<?= htmlspecialchars($value[4]) ?>" loading="lazy">
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
        '/images/market-1.png',
        'Digital marketing analytics displayed on a laptop screen',
      ],
      [
        '/images/market-icon-2.svg',
        'Pay-Per-Click Advertising',
        'Instant Reach, Tangible Results',
        'Reach high-intent audiences quickly with focused campaigns that maximise conversions and measurable ROI.',
        '/images/market-2.png',
        'Pay-per-click advertising campaign planning',
      ],
      [
        '/images/market-icon-3.svg',
        'Social Media Marketing',
        'Engage & Grow Your Community',
        'Build meaningful connections with relevant content that inspires engagement, loyalty, and lasting growth.',
        '/images/market-3.png',
        'Social media marketing content viewed on a mobile device',
      ],
      [
        '/images/market-icon-4.svg',
        'Content Strategy & Planning',
        'Plan. Create. Convert.',
        'Turn ideas into purposeful content that strengthens your brand and guides customers to act.',
        '/images/market-4.png',
        'Creative team planning a digital content strategy',
      ],
      [
        '/images/market-icon-5.svg',
        'Online Reputation Management',
        'Protect Trust. Build Credibility.',
        'Monitor brand conversations and strengthen the online reputation that shapes customer confidence.',
        '/images/market-1.png',
        'Marketing specialists reviewing online brand sentiment',
      ],
      [
        '/images/market-icon-6.svg',
        'Answer Engine Optimization',
        'Be the Answer Customers Find',
        'Structure authoritative content so voice assistants and answer engines can surface your expertise.',
        '/images/market-2.png',
        'Team shaping content for modern answer engines',
      ],
      [
        '/images/market-icon-7.svg',
        'Generative Engine Optimization',
        'Stay Visible in AI Search',
        'Position your brand for discovery across generative platforms with trusted content and clear signals.',
        '/images/market-3.png',
        'Digital team optimizing brand visibility for AI search',
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
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
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
<x-frontend.marquee-section
  type="text"
  direction="left"
  position="full"
  :items="$servicesMarqueeItems"
  aria-label="Web Development, Promotion Marketing, Advertising, and CRM Development"
  :speed="30"
/>
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
      ['/images/project-1.png', 'Modern timber-and-glass creative studio exterior'],
      ['/images/project-2.png', 'Bright contemporary residence interior'],
      ['/images/project-3.png', 'Warm modern lounge with plants and artwork'],
      ['/images/project-1.png', 'Contemporary office with glass meeting rooms'],
    ];
    ?>
    <div class="swiper portfolioShowcaseSwiper">
      <div class="swiper-wrapper">
        <?php foreach ($portfolioShowcaseProjects as $project): ?>
          <div class="swiper-slide">
            <article class="portfolio-showcase__card">
              <div class="portfolio-showcase__image">
                <img src="<?= htmlspecialchars($project[0]) ?>" alt="<?= htmlspecialchars($project[1]) ?>" loading="lazy" draggable="false">
              </div>
              <div class="portfolio-showcase__copy">
                <p
                  class="inline-block text-[12px] font-bold text-transparent bg-clip-text bg-[linear-gradient(90deg,_#2A4DFB_0%,_#7A5FF8_100%)] mb-2">
                  TEXT GOES HERE
                </p>
                <h3 class="text-[14px] font-semibold text-[#171717] max-w-[300px] leading-[18px] mb-2">Experience the
                  difference with our results-driven approach.</h3>
                <p class=" text-[14px] text-[#4D4D4D] max-w-[360px] ">A meta-registry unifying the world’s carbon-credit
                  registries
                  into one source of truth</p>
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
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 8L22 12L18 16"></path>
              <path d="M2 12H22"></path>
            </svg>
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
          Talk to an Expert <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
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
<x-frontend.four-card-section />
<!-- Technology Section End -->


<x-frontend.faq-section
  :qa="$faqs"
  :media="$faqMedia"
  :media-type="$faqMediaType"
  :media-alt="$faqMediaAlt"
  :cta-href="$faqCtaHref"
  :cta-label="$faqCtaLabel"
/>

<x-frontend.testimonials-section :items="$testimonials" />

<x-frontend.articles-insights-section
  :items="$articles"
  heading-id="articles-insights-title"
  more-href="/blogs"
  more-label="View More"
/>

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
          Book a Free Consultation <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
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
            <img src="/images/consult-4.png" alt="Suave Creators designer" width="640" height="960" loading="lazy">
          </figure>
        </div>
        <div class="consultation-people__column consultation-people__column--right">
          <figure class="consultation-person consultation-person--coral">
            <img src="/images/consult-5.png" alt="Suave Creators team lead" width="640" height="959" loading="lazy">
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
<section class="full-bleed partnership-section" aria-label="Client logos">
  <div class="partnership-inner section-inner text-center">
    <p
      class="offerings-eyebrow text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%] mb-6">
      Our Portfolio
    </p>

    <x-frontend.marquee-section
      type="image"
      direction="left"
      position="contained"
      :items="$partnerMarqueeItems"
      aria-label="Client logos"
      :speed="28"
    />
  </div>
</section>
<!-- Partnerships Section End -->
@push('scripts')
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

  });
</script>
@endpush

@push('custom-css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ filemtime(public_path('css/home.css')) }}">
@endpush
@endsection
