@extends('layouts.frontend')

@section('seo')
  <x-layouts.seo
    title="Suave Creators | Web & Software Development Solutions"
    description="We are a trusted Custom Software Development Company that specializes in CRM Development, Web Application, & Enterprise Software Solutions to help businesses grow."
    og-title="Suave Creators | Web & Software Development Solutions"
    og-description="Custom Software, CRM, Web Application & Enterprise Software Development Solutions."
    :canonical="url()->current()"
    :og-url="url()->current()"
  />
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
      <div class="hero-media-grid">
        <div
          class="hero-media-grid__tile col-start-1 row-span-2 row-start-1 overflow-hidden rounded-[22px] [clip-path:inset(0_round_22px)]">
          <img src="{{ asset('assets/hero/hero-motion-panel-1.gif') }}" alt="Custom software and web development work by Suave Creators" title="Custom software and web development work by Suave Creators" class="block h-full w-full max-w-none object-cover" decoding="async" loading="lazy">
        </div>
        <div
          class="hero-media-grid__tile col-start-2 row-start-1 overflow-hidden rounded-[22px] [clip-path:inset(0_round_22px)]">
          <img src="{{ asset('assets/hero/hero-motion-panel-2.gif') }}" alt="Animated software interface for a custom web application" title="Animated software interface for a custom web application" class="block h-full w-full max-w-none object-cover" decoding="async" loading="lazy">
        </div>
        <div
          class="hero-media-grid__tile col-start-2 row-start-2 overflow-hidden rounded-[22px] [clip-path:inset(0_round_22px)]">
          <img src="{{ asset('assets/hero/hero-motion-panel-3.gif') }}" alt="Modern web application dashboard built by Suave Creators" title="Modern web application dashboard built by Suave Creators" class="block h-full w-full max-w-none object-cover" decoding="async" loading="lazy">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Hero Section End -->

<!-- About Section Start -->
<section
  class="full-bleed bg-white bg-cover bg-top bg-no-repeat py-10 md:py-14 lg:py-20" style="background-image: url('{{ asset('assets/background/about-section-bg.png') }}');">
  <div class="section-inner site-container ">
    <div class="about-stats">
      @php
        $stats = [
          ['50+', 'Brands trust us for AI', 'Successfully completed more than 50+ projects.', 'assets/icons/brands-growth-rocket-icon.svg', '#4C24F4', '#F0EAFF', 'AI software growth icon for brands trusting Suave Creators'],
          ['10+', 'Years of Experience', 'Years of Combined Experience.', 'assets/icons/years-experience-icon.svg', '#1873E7', '#EAF5FC', 'Years of experience icon for Suave Creators development team'],
          ['$40M+', 'Funding Secured', 'Our creative work has helped clients secure more than $40M+ in funding.', 'assets/icons/funding-secured-icon.svg', '#0F968E', '#E8F8F6', 'Funding secured icon for startups built with Suave Creators'],
          ['15+', 'Expert Team', '15+ Passionate Developers and Management Teams.', 'assets/team/expert-team-icon.svg', '#FA6811 ', '#FFF0E7', 'Expert software development team icon at Suave Creators'],
        ];
      @endphp
      @foreach ($stats as $stat)
        <article class="about-stat"
          style="--stat-accent: {{ $stat[4] }}; --stat-tint: {{ $stat[5] }};">
          <span class="about-stat__icon">
            <img src="{{ asset($stat[3]) }}" alt="{{ $stat[6] }}" title="{{ $stat[6] }}"
              class="about-stat__icon-image" width="40" height="40" decoding="async" loading="lazy">
          </span>
          <div class="about-stat__content">
            <strong class="about-stat__value">{{ $stat[0] }}</strong>
            <h2 class="about-stat__label">{{ $stat[1] }}</h2>
            <p class="about-stat__description">{{ $stat[2] }}</p>
          </div>
        </article>
      @endforeach
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
    </div>
  </div>
</section>
<!-- About Section End -->

<!-- Offerings Showcase Section Start -->
<section
  class="full-bleed  overflow-hidden bg-[#F9FAFC] bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('assets/background/offerings-section-bg.png') }}');">
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

    @php
$offerings = [
      [
        'Product Strategy with Intelligence Inside',
        'Our team helps define your vision, validate your idea.',
        'assets/team/expert-portrait-1.png',
        'Product strategy experts planning intelligent software solutions',
      ],
      [
        'Design that Defines Your Brand',
        'We merge creative design, intuitive UX/UI, and brand storytelling.',
        'assets/team/expert-portrait-2.png',
        'UI UX designer planning a brand experience for digital products',
      ],
      [
        'Smart Development, Seamless Performance',
        'Our team crafts high-performance, scalable applications.',
        'assets/team/expert-portrait-3.png',
        'Software engineers building scalable web applications',
      ],
      [
        'Marketing that Fuels Growth',
        'We help your app grow, retain, and dominate its market space.',
        'assets/team/expert-portrait-4.png',
        'Digital marketing experts presenting app growth analytics',
      ],
      [
        'Continuous Support & Innovation',
        'We keep your product reliable, relevant, and ready to evolve with ongoing support and smart improvements.',
        'assets/team/expert-portrait-1.png',
        'Product support team planning continuous software innovation',
      ],
    ];
@endphp
    <div class="offeringsSwiper swiper mt-10 sm:mt-12 lg:mt-[54px]">
      <div class="swiper-wrapper">
        @foreach ($offerings as $offering)
          <div class="swiper-slide h-auto">
            <article class="offerings-card h-full">
              <div class="offerings-card__image">
                <img src="{{ asset(str($offering[2])->ltrim('/')) }}" alt="{{ $offering[3] }}" title="{{ $offering[3] }}"
                  loading="lazy" decoding="async">
              </div>
              <div class="pt-3">
                <h3>{{ $offering[0] }}</h3>
                <p>{{ $offering[1] }}</p>
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

    <span class="smart-together-cta__phone">
      <img src="{{ asset('assets/hero/mobile-app-phone-demo.gif') }}" alt="Mobile app demo for a custom CRM and software product" title="Mobile app demo for a custom CRM and software product" class="rounded-[10px]" decoding="async" loading="lazy">
    </span>
  </div>
</section>
<!-- Smart Together CTA Section End -->

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

    @php
$coreValues = [
      ['innovation', 'Innovation', 'We work with future trends and the latest technologies.', 'assets/portfolio/modern-office-yellow-accent-lounge.png', 'Modern workspace reflecting innovative software development culture'],
      ['quality', 'Quality', 'Delivering the best quality, ensuring our clients get nothing less than the best.', 'assets/portfolio/contemporary-living-room-kitchen.png', 'Contemporary interior design showcasing quality digital craftsmanship'],
      ['trust', 'Trust', 'We build trust by focusing on the exact client requirements.', 'assets/portfolio/warm-lounge-plants-artwork.png', 'Warm collaborative lounge built for trusted client partnerships'],
      ['customer', 'Customer Focus', 'We put our clients at the heart of everything we build.', 'assets/portfolio/office-glass-meeting-rooms.png', 'Glass meeting rooms for customer focused software consulting'],
    ];
@endphp
    <div class="core-values__grid">
      @foreach ($coreValues as $value)
        <article class="core-value-card">
          <div class="core-value-card__content">
            <svg class="core-value-card__icon" aria-hidden="true">
              <use href="#core-value-{{ $value[0] }}"></use>
            </svg>
            <h3>{{ $value[1] }}</h3>
            <p>{{ $value[2] }}</p>
          </div>
          <div class="core-value-card__image">
            <img src="{{ asset(str($value[3])->ltrim('/')) }}" alt="{{ $value[4] }}" title="{{ $value[4] }}" loading="lazy" decoding="async">
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
<!-- Core Values Section End -->

<!-- Digital Marketing Services Section Start -->
<section
  class="full-bleed digital-marketing-services bg-cover bg-top bg-no-repeat py-12 lg:py-[80px]" style="background-image: url('{{ asset('assets/background/digital-marketing-section-bg.png') }}');"
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

    @php
$digitalMarketingServices = [
      [
        'assets/icons/seo-icon.svg',
        'Search Engine Optimization',
        'Boost Your Organic Visibility',
        'With our expertise, we enhance the online visibility of your professional website.',
        'assets/media/seo-infographic-on-imac.png',
        'SEO analytics dashboard for search engine optimization services',
        'Search engine optimization SEO service icon',
      ],
      [
        'assets/icons/ppc-advertising-icon.svg',
        'Pay-Per-Click Advertising',
        'Instant Reach, Tangible Results',
        'Reach high-intent audiences quickly with focused campaigns that maximise conversions and measurable ROI.',
        'assets/media/ppc-campaign-planning.png',
        'PPC advertising campaign planning for higher conversions',
        'Pay per click advertising PPC service icon',
      ],
      [
        'assets/icons/social-media-marketing-icon.svg',
        'Social Media Marketing',
        'Engage & Grow Your Community',
        'Build meaningful connections with relevant content that inspires engagement, loyalty, and lasting growth.',
        'assets/media/social-media-marketing-mobile.png',
        'Social media marketing content strategy on a mobile device',
        'Social media marketing service icon',
      ],
      [
        'assets/icons/content-strategy-icon.svg',
        'Content Strategy & Planning',
        'Plan. Create. Convert.',
        'Turn ideas into purposeful content that strengthens your brand and guides customers to act.',
        'assets/media/content-strategy-team-planning.png',
        'Content strategy team planning digital marketing campaigns',
        'Content strategy and planning service icon',
      ],
      [
        'assets/icons/online-reputation-icon.svg',
        'Online Reputation Management',
        'Protect Trust. Build Credibility.',
        'Monitor brand conversations and strengthen the online reputation that shapes customer confidence.',
        'assets/media/seo-infographic-on-imac.png',
        'Online reputation management review of brand sentiment analytics',
        'Online reputation management service icon',
      ],
      [
        'assets/icons/answer-engine-optimization-icon.svg',
        'Answer Engine Optimization',
        'Be the Answer Customers Find',
        'Structure authoritative content so voice assistants and answer engines can surface your expertise.',
        'assets/media/ppc-campaign-planning.png',
        'Answer engine optimization content planning for AI search',
        'Answer engine optimization AEO service icon',
      ],
      [
        'assets/icons/generative-engine-optimization-icon.svg',
        'Generative Engine Optimization',
        'Stay Visible in AI Search',
        'Position your brand for discovery across generative platforms with trusted content and clear signals.',
        'assets/media/social-media-marketing-mobile.png',
        'Generative engine optimization for brand visibility in AI search',
        'Generative engine optimization GEO service icon',
      ],
    ];
@endphp

    <div class="digitalMarketingSwiper swiper">
      <div class="swiper-wrapper py-4">
        @foreach ($digitalMarketingServices as $index => $service)
          <div class="swiper-slide">
            <article class="digital-marketing-card">
              <div class="digital-marketing-card__topline">
                <img src="{{ asset(str($service[0])->ltrim('/')) }}" alt="{{ $service[6] }}" title="{{ $service[6] }}"
                  class="digital-marketing-card__icon" decoding="async" loading="lazy">
                <span class="digital-marketing-card__number"
                  aria-hidden="true">{{ str((string) ($index + 1))->padLeft(2, '0') }}</span>
              </div>
              <p class="digital-marketing-card__service-title">{{ $service[1] }}</p>
              <figure class="digital-marketing-card__image">
                <img src="{{ asset(str($service[4])->ltrim('/')) }}" alt="{{ $service[5] }}" title="{{ $service[5] }}" width="640"
                  height="420" loading="lazy" decoding="async">
              </figure>
              <div class="digital-marketing-card__content">
                <h3>{{ $service[2] }}</h3>
                <p>{{ $service[3] }}</p>
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
/>
<!-- Digital Services Marquee Section End -->

<!-- Portfolio Showcase Section Start -->
<section
  class="full-bleed portfolio-showcase bg-cover bg-top bg-no-repeat py-12 lg:py-[80px]" style="background-image: url('{{ asset('assets/background/portfolio-section-bg.png') }}');"
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

    @php
$portfolioShowcaseProjects = [
      ['assets/portfolio/timber-glass-creative-studio.png', 'Modern timber and glass creative studio for digital product teams'],
      ['assets/portfolio/bright-contemporary-residence.png', 'Bright contemporary space reflecting premium digital design quality'],
      ['assets/portfolio/warm-modern-lounge-interior.png', 'Warm modern lounge for collaborative software product workshops'],
      ['assets/portfolio/timber-glass-creative-studio.png', 'Creative studio exterior showcasing Suave Creators portfolio quality'],
    ];
@endphp
    <div class="swiper portfolioShowcaseSwiper">
      <div class="swiper-wrapper">
        @foreach ($portfolioShowcaseProjects as $project)
          <div class="swiper-slide">
            <article class="portfolio-showcase__card">
              <div class="portfolio-showcase__image">
                <img src="{{ asset(str($project[0])->ltrim('/')) }}" alt="{{ $project[1] }}" title="{{ $project[1] }}" loading="lazy" draggable="false" decoding="async">
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
        <a href="/services">Discuss your Vision</a>
      </p>
    </div>
  </div>
</section>
<!-- Portfolio Showcase Section End -->

<!-- Industries We Serve Section Start -->
<section
  class="full-bleed industries-served bg-cover bg-top bg-no-repeat py-12 lg:py-[80px]" style="background-image: url('{{ asset('assets/background/industries-section-bg.png') }}');"
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

    @php
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
@endphp

    <div class="industries-served__grid">
      @foreach ($industriesServed as $industry)
        <article class="industry-card">
          <i class="industry-card__icon {{ $industry[0] }}" aria-hidden="true"></i>
          <h3>{{ $industry[1] }}</h3>
          <p>{{ $industry[2] }}</p>

          <span class="industry-card__arrow" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 8L22 12L18 16"></path>
              <path d="M2 12H22"></path>
            </svg>
          </span>
        </article>
      @endforeach
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
      <div class="industries-support__illustration">
        <img src="{{ asset('assets/brand/chat-widget-icon.png') }}" alt="Contact Suave Creators chat support for software consulting" title="Contact Suave Creators chat support for software consulting" width="56" height="56" decoding="async" loading="lazy">
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
    <div class="consultation-card bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('assets/background/consultation-section-bg.png') }}');">
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
            <img src="{{ asset('assets/team/consultation-team-member-1.png') }}" alt="Suave Creators consultant ready for a software discovery call" title="Suave Creators consultant ready for a software discovery call" width="640" height="960" loading="lazy" decoding="async">
          </figure>
          <figure class="consultation-person consultation-person--orange">
            <img src="{{ asset('assets/team/consultation-team-member-2.png') }}" alt="Suave Creators developer available for project consultation" title="Suave Creators developer available for project consultation" width="640" height="960" loading="lazy" decoding="async">
          </figure>
        </div>
        <div class="consultation-people__column">
          <figure class="consultation-person consultation-person--yellow">
            <img src="{{ asset('assets/team/consultation-team-leader.png') }}" alt="Suave Creators team leader for web development consultation" title="Suave Creators team leader for web development consultation" width="640" height="960" loading="lazy" decoding="async">
          </figure>
          <figure class="consultation-person consultation-person--blue">
            <img src="{{ asset('assets/team/consultation-designer.png') }}" alt="Suave Creators UI UX designer for product consultation" title="Suave Creators UI UX designer for product consultation" width="640" height="960" loading="lazy" decoding="async">
          </figure>
        </div>
        <div class="consultation-people__column consultation-people__column--right">
          <figure class="consultation-person consultation-person--coral">
            <img src="{{ asset('assets/team/consultation-team-lead.png') }}" alt="Suave Creators project lead for CRM and software consulting" title="Suave Creators project lead for CRM and software consulting" width="640" height="959" loading="lazy" decoding="async">
          </figure>
          <figure class="consultation-person consultation-person--cyan">
            <img src="{{ asset('assets/team/consultation-team-collaborating.png') }}" alt="Suave Creators team collaborating on a client software project" title="Suave Creators team collaborating on a client software project" width="640" height="960"
              loading="lazy" decoding="async">
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

    @php
$partners = [
      ['assets/clients/verysoul-logo.png', 'VerySoul'],
      ['assets/clients/redsixity-logo.svg', 'RedSixity'],
      ['assets/clients/dajj-logistics-logo.png', 'DAJJ Logistics'],
      ['assets/clients/ematrics-logo.png', 'Ematrics'],
      ['assets/clients/bioassay-systems-logo.png', 'BioAssay Systems'],
    ];
@endphp
        <x-frontend.marquee-section
      type="image"
      direction="left"
      position="contained"
      :items="$partnerMarqueeItems"
      aria-label="Client logos"
      :speed="28"
    /></div>
</section>
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
  z-index: 1;
}

.digital-marketing-card:hover .digital-marketing-card__service-title {
  color: #2A4DFB;
}

.digital-marketing-card__number {
  color: #F7F8F8;
  font-size: 34px;
  font-weight: 800;
  letter-spacing: -0.075em;
  line-height: 1;
  pointer-events: none;
  position: absolute;
  right: 0;
  top: -8px;
  z-index: 0;
}

.digital-marketing-card__image {
  background: transparent;
  border-radius: 8px;
  margin-top: 10px;
  overflow: hidden;
}

.digital-marketing-card__image img {
  display: block;
  height: auto;
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
  .about-collage {
    --collage-gap: 8px;
    --col-left: 137px;
    --col-center: 130px;
    --col-right: 111px;
    max-width: 100%;
  }

  .about-values {
    flex-direction: column;
    display: none;
  }

  .offerings-card {
    padding: 10px !important;
    background-color: white;
    border-radius: 8px;
  }

  .about-collage__column--left {
    padding-top: 43px;
  }

  .about-collage__column--right {
    padding-top: 53px;
  }

  .about-collage__tile--team,
  .about-collage__tile--office-small {
    height: 65px;
    width: 86px;
  }

  .about-collage__tile--portrait-tall {
    height: 173px;
    width: 137px;
  }

  .about-collage__tile--leader {
    height: 101px;
    width: 130px;
  }

  .about-collage__tile--portrait-main {
    height: 202px;
    width: 130px;
  }

  .about-collage__tile--office-wide {
    height: 86px;
    width: 130px;
  }

  .about-collage__tile--portrait-right {
    height: 101px;
    width: 111px;
  }

  .about-collage__tile--meeting {
    height: 81px;
    width: 111px;
  }

  .about-collage__tile--meeting-sm {
    height: 68px;
    width: 89px;
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
    padding: 52px 0 48px;
  }

  .digital-marketing-services__intro h2 {
    font-size: 20px;
    line-height: 28px;
  }

  .digitalMarketingSwiper {
    margin-top: 32px;
  }

  .digital-marketing-card {
    min-height: 0;
    padding: 12px;
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
    margin-top: 28px;
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
    max-width: calc(100% - 64px);
  }

  .industries-support__copy p {
    font-size: clamp(0.9375rem, 3.5vw, 1.125rem);
  }

  .industries-support__illustration {
    margin: 0;
    position: absolute;
    right: 10px;
    top: 60px;
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
    font-size: 28px;
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
