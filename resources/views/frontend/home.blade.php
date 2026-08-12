@extends('layouts.frontend')

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
        <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer"
          class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-[13px] sm:text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 whitespace-nowrap">
          Start your Project
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1">
            <path d="M18 8L22 12L18 16" />
            <path d="M2 12H22" />
          </svg>
        </a>

        <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer"
          class="inline-flex items-center border-b border-white/70 text-[13px] sm:text-sm font-semibold text-white whitespace-nowrap">
          Schedule a discovery call
        </a>
      </div>
    </div>

    <div class="relative z-10 flex w-full min-w-0 items-center justify-center lg:justify-end">
      <div class="hero-media-grid" aria-hidden="true">
        <div
          class="hero-media-grid__tile col-start-1 row-span-2 row-start-1 overflow-hidden rounded-[22px] [clip-path:inset(0_round_22px)]">
          <img
            src="{{ asset('assets/hero/hero-team-brainstorm-overhead.webp') }}"
            srcset="{{ asset('assets/hero/hero-team-brainstorm-overhead-480.webp') }} 480w, {{ asset('assets/hero/hero-team-brainstorm-overhead.webp') }} 628w"
            sizes="(min-width: 1024px) 314px, (min-width: 768px) 262px, 47vw"
            alt="Team brainstorming software strategy documents with Suave Creators"
            title="Team brainstorming software strategy documents with Suave Creators"
            class="block h-full w-full max-w-none object-cover"
            width="628"
            height="1024"
            decoding="async"
            loading="lazy">
        </div>
        <div
          class="hero-media-grid__tile col-start-2 row-start-1 overflow-hidden rounded-[22px] [clip-path:inset(0_round_22px)]">
          <img
            src="{{ asset('assets/hero/hero-professionals-office-meeting.webp') }}"
            srcset="{{ asset('assets/hero/hero-professionals-office-meeting-480.webp') }} 480w, {{ asset('assets/hero/hero-professionals-office-meeting-640.webp') }} 640w, {{ asset('assets/hero/hero-professionals-office-meeting.webp') }} 688w"
            sizes="(min-width: 1024px) 344px, (min-width: 768px) 287px, 51vw"
            alt="Software professionals collaborating in a modern office meeting"
            title="Software professionals collaborating in a modern office meeting"
            class="block h-full w-full max-w-none object-cover"
            width="688"
            height="248"
            decoding="async"
            loading="lazy">
        </div>
        <div
          class="hero-media-grid__tile col-start-2 row-start-2 overflow-hidden rounded-[22px] [clip-path:inset(0_round_22px)]">
          <img
            src="{{ asset('assets/hero/hero-team-conference-collaboration.webp') }}"
            srcset="{{ asset('assets/hero/hero-team-conference-collaboration-480.webp') }} 480w, {{ asset('assets/hero/hero-team-conference-collaboration-640.webp') }} 640w, {{ asset('assets/hero/hero-team-conference-collaboration.webp') }} 688w"
            sizes="(min-width: 1024px) 344px, (min-width: 768px) 287px, 51vw"
            alt="Cross-functional team collaborating on custom software development"
            title="Cross-functional team collaborating on custom software development"
            class="block h-full w-full max-w-none object-cover"
            width="688"
            height="736"
            decoding="async"
            loading="lazy">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Hero Section End -->

<!-- About Section Start / Who We Are -->
<section
  class="who-we-are full-bleed bg-white bg-cover bg-top bg-no-repeat py-10 md:py-14 lg:py-20" style="--who-we-are-bg: url('{{ asset('assets/background/about-section-bg.png') }}'); background-image: var(--who-we-are-bg);">
  <div class="section-inner site-container ">
    <div class="about-stats" data-about-counters>
      @foreach ($stats as $stat)
        <article class="about-stat"
          style="--stat-accent: {{ $stat['accent'] }}; --stat-tint: {{ $stat['tint'] }};">
          <span class="about-stat__icon">
            <img src="{{ asset($stat['icon']) }}" alt="{{ $stat['alt'] }}" title="{{ $stat['alt'] }}"
              class="about-stat__icon-image" width="40" height="40" decoding="async" loading="lazy">
          </span>
          <div class="about-stat__content">
            <strong class="about-stat__value">
              <span data-counter-end="{{ (int) $stat['end'] }}">0</span>{{ $stat['suffix'] }}
            </strong>
            <h2 class="about-stat__label">{{ $stat['label'] }}</h2>
            <p class="about-stat__description">{{ $stat['description'] }}</p>
          </div>
        </article>
      @endforeach
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
              <img src="{{ asset('assets/team/teamwork-icon.svg') }}" alt="Teamwork icon for collaborative software development at Suave Creators" title="Teamwork icon for collaborative software development at Suave Creators" width="40" height="40" decoding="async" loading="lazy">
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
              <img src="{{ asset('assets/icons/client-focus-icon.svg') }}" alt="Client focused delivery icon for custom software projects" title="Client focused delivery icon for custom software projects" width="40" height="40" decoding="async" loading="lazy">
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
              <img src="{{ asset('assets/icons/future-ready-icon.svg') }}" alt="Future ready technology icon for scalable digital solutions" title="Future ready technology icon for scalable digital solutions" width="40" height="40" decoding="async" loading="lazy">
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
            <img src="{{ asset('assets/team/metallic-s-logo-office-wall.png') }}" alt="Suave Creators brand mark on a modern software office wall" title="Suave Creators brand mark on a modern software office wall" width="640" height="960"
              loading="lazy" decoding="async">
          </figure>
          <figure class="about-collage__tile about-collage__tile--portrait-tall">
            <img src="{{ asset('assets/team/professional-team-member-portrait.png') }}" alt="Suave Creators software developer in a professional portrait" title="Suave Creators software developer in a professional portrait" width="640" height="960"
              loading="lazy" decoding="async">
          </figure>
          <figure class="about-collage__tile about-collage__tile--office-small">
            <img src="{{ asset('assets/team/bright-creative-office-interior.png') }}" alt="Bright creative office for Suave Creators web development team" title="Bright creative office for Suave Creators web development team" width="640" height="427" loading="lazy" decoding="async">
          </figure>
        </div>

        <div class="about-collage__column about-collage__column--center">
          <figure class="about-collage__tile about-collage__tile--leader">
            <img src="{{ asset('assets/team/professional-man-navy-blazer-portrait.png') }}" alt="Suave Creators technology leader in a professional setting" title="Suave Creators technology leader in a professional setting" width="640" height="960"
              loading="lazy" decoding="async">
          </figure>
          <figure class="about-collage__tile about-collage__tile--portrait-main">
            <img src="{{ asset('assets/team/professional-woman-product-team-portrait.png') }}" alt="Suave Creators product team specialist in a studio portrait" title="Suave Creators product team specialist in a studio portrait" width="640" height="960"
              loading="lazy" decoding="async">
          </figure>
          <figure class="about-collage__tile about-collage__tile--office-wide">
            <img src="{{ asset('assets/team/team-working-modern-office.png') }}" alt="Suave Creators developers collaborating in a modern office" title="Suave Creators developers collaborating in a modern office" width="800" height="534" loading="lazy" decoding="async">
          </figure>
        </div>

        <div class="about-collage__column about-collage__column--right">
          <figure class="about-collage__tile about-collage__tile--portrait-right">
            <img src="{{ asset('assets/team/professional-designer-portrait.png') }}" alt="Suave Creators UI UX designer professional portrait" title="Suave Creators UI UX designer professional portrait" width="640" height="960" loading="lazy" decoding="async">
          </figure>
          <figure class="about-collage__tile about-collage__tile--portrait-right">
            <img src="{{ asset('assets/team/professional-team-lead-portrait.png') }}" alt="Suave Creators project team lead professional portrait" title="Suave Creators project team lead professional portrait" width="640" height="959" loading="lazy" decoding="async">
          </figure>
          <figure class="about-collage__tile about-collage__tile--meeting">
            <img src="{{ asset('assets/team/open-office-meeting-space.png') }}" alt="Open office meeting space for Suave Creators client workshops" title="Open office meeting space for Suave Creators client workshops" width="640" height="427" loading="lazy" decoding="async">
          </figure>
          <figure class="about-collage__tile about-collage__tile--meeting-sm">
            <img src="{{ asset('assets/team/open-office-collaboration-space.png') }}" alt="Collaboration space for Suave Creators agile software teams" title="Collaboration space for Suave Creators agile software teams" width="640" height="427" loading="lazy" decoding="async">
          </figure>
        </div>
      </div>

      <div class="mt-0 flex flex-wrap items-center gap-5">
        <a href="{{ route('about-us') }}"
          class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-[13px] sm:text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 whitespace-nowrap">
          <span>Learn more About Us</span>
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1">
            <path d="M18 8L22 12L18 16"></path>
            <path d="M2 12H22"></path>
          </svg>
        </a>
        <a href="" class="border-b border-[#00003F] text-[13px] sm:text-sm font-semibold ">View Our Work</a>
      </div>
    </div>
  </div>
</section>
<!-- About Section End -->

<!-- Offerings Showcase Section Start -->
<section
  class="offerings-showcase full-bleed overflow-hidden bg-[#F9FAFC] bg-repeat" style="background-image: url('{{ asset('assets/background/what-we-do-section-pattern-bg.png') }}');">
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

    <div class="offeringsSwiper swiper mt-10 sm:mt-12 lg:mt-[54px]">
      <div class="swiper-wrapper">
        @foreach ($offerings as $offering)
          <div class="swiper-slide h-auto">
            <article class="offerings-card h-full">
              <div class="offerings-card__image">
                <x-frontend.responsive-webp-image
                  :src="$offering['image']"
                  :alt="$offering['alt']"
                  sizes="(min-width: 1024px) 303px, (min-width: 768px) 280px, 85vw"
                  width="608"
                  height="578"
                  loading="lazy"
                  decoding="async" />
              </div>
              <div class="pt-3">
                <h3>{{ $offering['title'] }}</h3>
                <p>{{ $offering['description'] }}</p>
              </div>
            </article>
          </div>
        @endforeach
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
      <a class="offerings-expert-link" href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer">Talk to an Expert</a>
    </div>
  </div>
</section>
<!-- Offerings Showcase Section End -->

<x-frontend.connect-cta-section />

<!-- Web Development Services Section Start -->
<x-frontend.three-card-section />
<!-- Web Development Services Section End -->

<!-- Core Values Section Start -->
<section
  class=" full-bleed core-values bg-cover bg-top bg-no-repeat py-12 lg:py-20" style="background-image: url('{{ asset('assets/background/core-values-section-bg.png') }}');">
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

    <div class="core-values__grid">
      @foreach ($coreValues as $value)
        <article class="core-value-card">
          <div class="core-value-card__content">
            <svg class="core-value-card__icon" aria-hidden="true">
              <use href="#core-value-{{ $value['id'] }}"></use>
            </svg>
            <div class="core-value-card__text">
              <h3>{{ $value['title'] }}</h3>
              <p>{{ $value['description'] }}</p>
            </div>
          </div>
          <div class="core-value-card__image">
            <x-frontend.responsive-webp-image
              :src="$value['image']"
              :alt="$value['alt']"
              sizes="(min-width: 1024px) 366px, (min-width: 768px) 292px, 298px"
              loading="lazy"
              decoding="async" />
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
<!-- Core Values Section End -->

<!-- Digital Marketing Services Section Start -->
<section
  class="full-bleed digital-marketing-services bg-repeat py-12 lg:py-[80px]" style="background-image: url('{{ asset('assets/background/digital-marketing-section-pattern-bg.png') }}');"
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

    <div class="digitalMarketingSwiper swiper">
      <div class="swiper-wrapper py-4">
        @foreach ($digitalMarketingServices as $index => $service)
          <div class="swiper-slide">
            <article class="digital-marketing-card">
              <div class="digital-marketing-card__topline">
                <img src="{{ asset($service['icon']) }}" alt="{{ $service['iconAlt'] }}" title="{{ $service['iconAlt'] }}"
                  class="digital-marketing-card__icon" decoding="async" loading="lazy">
                <span class="digital-marketing-card__number"
                  aria-hidden="true">{{ str((string) ($index + 1))->padLeft(2, '0') }}</span>
              </div>
              <p class="digital-marketing-card__service-title">{{ $service['title'] }}</p>
              <figure class="digital-marketing-card__image">
                <img src="{{ asset($service['image']) }}" alt="{{ $service['alt'] }}" title="{{ $service['alt'] }}" width="640"
                  height="420" loading="lazy" decoding="async">
              </figure>
              <div class="digital-marketing-card__content">
                <h3>{{ $service['headline'] }}</h3>
                <p>{{ $service['description'] }}</p>
              </div>
              <span class="digital-marketing-card__arrow" aria-hidden="true">
                <img src="{{ asset('assets/media/soft-blue-right-arrow.png') }}"
                  alt="Soft blue right arrow for Suave Creators digital marketing services"
                  title="Soft blue right arrow for Suave Creators digital marketing services"
                  width="18" height="5" decoding="async" loading="lazy">
              </span>
            </article>
          </div>
        @endforeach
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
        <a href="{{ route('services') }}">See All Services</a>
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
/>
<!-- Digital Services Marquee Section End -->

<!-- Portfolio Showcase Section Start -->
<section
  class="full-bleed portfolio-showcase !hidden bg-repeat py-12 md:!grid lg:py-[80px]" style="background-image: url('{{ asset('assets/background/portfolio-section-pattern-bg.png') }}');"
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

    <div class="swiper portfolioShowcaseSwiper">
      <div class="swiper-wrapper">
        @foreach ($portfolioShowcaseProjects as $project)
          <div class="swiper-slide">
            <article class="portfolio-showcase__card">
              <div class="portfolio-showcase__image">
                <img src="{{ asset($project['image']) }}" alt="{{ $project['alt'] }}" title="{{ $project['alt'] }}" loading="lazy" draggable="false" decoding="async">
              </div>
              <div class="portfolio-showcase__copy">
                <p
                  class="inline-block text-[12px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent mb-2">
                  {{ $project['category'] }}
                </p>
                <h3 class="text-[14px] font-semibold text-[#171717] max-w-[300px] leading-[18px] mb-2">{{ $project['title'] }}</h3>
                <p class=" text-[14px] text-[#4D4D4D] max-w-[360px] ">{{ $project['description'] }}</p>
              </div>
            </article>
          </div>
        @endforeach
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
        <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer">Discuss your Vision</a>
      </p>
    </div>
  </div>
</section>
<!-- Portfolio Showcase Section End -->

<x-frontend.industries-section
  footer-label="Discuss your Project"
  :show-support-aside="true"
/>
<!-- Technology Section Start -->
<x-frontend.four-card-section class="!hidden md:!grid" background-image="assets/background/technology-section-bg.png" />
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
  more-href="{{ route('blogs') }}"
  more-label="View all blog articles"
/>

<x-frontend.consultation-section />

<!-- Partnerships Section Start -->
<x-frontend.partnerships-section :items="$partnerMarqueeItems" />
<!-- Partnerships Section End -->


@endsection
@push('custom-css')
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
  color: #949494;
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
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var counterRoot = document.querySelector('[data-about-counters]');

    if (counterRoot) {
      var counters = counterRoot.querySelectorAll('[data-counter-end]');
      var countersStarted = false;

      function animateCounters() {
        if (countersStarted) return;
        countersStarted = true;

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
        var counterObserver = new IntersectionObserver(function (entries) {
          if (entries.some(function (entry) { return entry.isIntersecting; })) {
            animateCounters();
            counterObserver.disconnect();
          }
        }, { threshold: 0.35 });
        counterObserver.observe(counterRoot);
      } else {
        animateCounters();
      }
    }

    if (typeof Swiper === 'undefined') return;

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
  });
</script>
@endpush
