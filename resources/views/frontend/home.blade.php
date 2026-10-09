@extends('layouts.frontend')

@section('content')
<!-- Hero Section Start -->
<section
  class="home-hero relative z-10 w-full pb-12 pt-8 md:min-h-[440px] md:pb-16 md:pt-10 lg:min-h-[640px] lg:pb-20 lg:pt-[52px] site-container">
  <div class="grid grid-cols-1 items-center gap-10 md:grid-cols-2 md:gap-8 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,0.7fr)] lg:gap-12">
    <div class="relative z-0 flex max-w-2xl min-w-0 flex-col text-left lg:max-w-[800px]">
      <p
        class="inline-block mb-2 bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent text-sm font-bold uppercase tracking-wide pragati-narrow-regular">
        Custom Software · CRM &amp; ERP · Dedicated Developers

      </p>
      <h1
        class="mb-2 mt-2 min-w-0 text-[36px] font-semibold leading-[1.1] text-white min-[375px]:text-[42px] sm:text-5xl lg:text-[56px]">
        Custom Software Development Company
        <span
          class="bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text text-transparent font-extrabold block">
          for Growing US Teams
        </span>
      </h1>
      <p class="mb-2 mt-2 text-[12px] leading-5 md:text-sm md:leading-6 text-[#B1B9DF]">
        Suave Creators is a custom software development company that builds CRM, ERP and web applications around how your team actually sells and operates. Replace stacked per-seat SaaS subscriptions with one platform you own outright, built by senior engineers in 2-week sprints.
      </p>
      <div class="mt-8">
        <x-frontend.inline-consultation-form
          theme="dark"
          placeholder="Your work email"
          button-text="Get a Scoped Estimate"
          primary-service="custom-software"
          secondary-href="#contact-modal"
          secondary-label="Hire Developers"
          secondary-service="hire-developers"
          :secondary-as-button="true"
          show-field />
        <p class="home-hero__reply mt-5 -ml-2 text-left text-[11px] leading-4 text-[#B1B9DF] sm:text-xs sm:leading-5">
          A solution architect replies within 1 business day with next steps and a call slot.
        </p>
        <p class="home-hero__trust-line mt-2 text-[11px] leading-4 text-[#F9F6EE] sm:text-xs sm:leading-5">
          100% code and IP ownership · NDA before the first call · Fixed-scope discovery · US contracts
        </p>
        <a class="mt-3 inline-flex items-center gap-1.5 text-[13px] font-semibold text-white no-underline hover:text-white/80" href="{{ route('case-studies') }}">See our case studies →</a>
      </div>
    </div>

    <div class="relative z-10 flex w-full min-w-0 items-center justify-start md:justify-end">
      <x-frontend.hero-case-studies-visual />
    </div>
  </div>
</section>
<!-- Hero Section End -->

<!-- About Section Start / Who We Are -->
<section
  class="who-we-are full-bleed bg-white bg-cover bg-top bg-no-repeat py-10 md:py-14 lg:py-20" style="--who-we-are-bg: url('{{ asset('assets/background/about-section-bg.png') }}'); background-image: var(--who-we-are-bg);">
  <div class="section-inner site-container ">
    <h2 class="sr-only">Results from recent builds</h2>
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
              <span data-counter-end="{{ (int) $stat['end'] }}" style="min-width: {{ strlen((string) $stat['end']) }}ch">0</span>{{ $stat['suffix'] }}
            </strong>
            <p class="about-stat__label">{{ $stat['label'] }}</p>
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
              About Suave Creators
            </span>
          </div>
          <h2 class="mt-4 text-[clamp(2.2rem,5vw,3rem)] font-bold leading-[110%] text-[#171717] lg:text-[48px]">
            What does
            <span class="inline-block bg-[linear-gradient(180deg,_#2F69FB_49.52%,_#D078FE_100%)] bg-clip-text text-transparent">Suave Creators do?</span>
          </h2>
          <p class="mt-5 text-[clamp(1rem,2vw,1.125rem)] font-semibold leading-[1.4] text-[#171717] max-w-[580px]">
            Suave Creators designs and builds custom CRM systems, ERP platforms and web applications for US companies with 20–500 employees. We replace off-the-shelf tools like Salesforce, HubSpot or NetSuite when per-seat costs, rigid workflows or disconnected data start slowing growth. You own all source code, data and IP from day one.
          </p>
          <h3 class="mt-4 text-[18px] font-semibold leading-[1.3] text-[#171717]">Custom software that replaces per-seat SaaS</h3>
          <p class="mt-4 text-[14px] leading-5 text-[#4D4D4D] max-w-[520px]">
            Most growing teams pay for five to ten tools that don't talk to each other. We consolidate them into one system built on your data model, with the integrations, automations and AI features your team uses every day. Founded in 2021, we're a US-registered company with our engineering center in Palampur, India.
          </p>
        <div class="about-values mt-8">
          <div class="about-values__item">
            <span class="about-values__icon bg-[#E6DEFD] shadow-[0px_16px_50px_0px_#5C638029]">
              <img src="{{ asset('assets/team/teamwork-icon.svg') }}" alt="Teamwork icon for collaborative software development at Suave Creators" title="Teamwork icon for collaborative software development at Suave Creators" width="40" height="40" decoding="async" loading="lazy">
            </span>

            <div class="flex min-w-0 flex-col gap-1">
              <p class="text-sm font-semibold text-[#171717]">Built on your data model</p>
              <p class="text-[13px] leading-[18px] font-medium text-[#4D4D4D]">One system instead of five disconnected tools.</p>
            </div>
          </div>

          <div class="about-values__item">
            <span class="about-values__icon bg-[#DFE4F8] shadow-[0px_16px_50px_0px_#5C638029]">
              <img src="{{ asset('assets/icons/client-focus-icon.svg') }}" alt="Client focused delivery icon for custom software projects" title="Client focused delivery icon for custom software projects" width="40" height="40" decoding="async" loading="lazy">
            </span>

            <div class="flex min-w-0 flex-col gap-1">
              <p class="text-sm font-semibold text-[#171717]">Measured by business results</p>
              <p class="text-[13px] leading-[18px] font-medium text-[#4D4D4D]">
                Every sprint tracked against time saved, conversion and cost.
              </p>
            </div>
          </div>

          <div class="about-values__item">
            <span class="about-values__icon bg-[#EAF4E1] shadow-[0px_16px_50px_0px_#5C638029]">
              <img src="{{ asset('assets/icons/future-ready-icon.svg') }}" alt="Future ready technology icon for scalable digital solutions" title="Future ready technology icon for scalable digital solutions" width="40" height="40" decoding="async" loading="lazy">
            </span>

            <div class="flex min-w-0 flex-col gap-1">
              <p class="text-sm font-semibold text-[#171717]">AI where it pays off</p>
              <p class="text-[13px] leading-[18px] font-medium text-[#4D4D4D]">
                Lead scoring, document processing and AI agents inside your workflows.
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
            <img src="{{ asset('assets/team/professional-woman-product-team-portrait.webp') }}" alt="Suave Creators product team specialist in a studio portrait" title="Suave Creators product team specialist in a studio portrait" width="640" height="960"
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

      <div class="mt-0 flex flex-col items-start gap-3 md:flex-row md:flex-wrap md:items-center md:gap-5">
        <x-frontend.cta-button :href="route('about-us')" class="max-w-full">
          About our team
        </x-frontend.cta-button>
        <x-frontend.cta-button :href="route('case-studies')" variant="secondary">
          Explore client case studies
        </x-frontend.cta-button>
      </div>
    </div>
  </div>
</section>
<!-- About Section End -->

<!-- Offerings Showcase Section Start -->
<section
  class="offerings-showcase full-bleed overflow-hidden bg-[#F9FAFC] bg-repeat" style="background-image: url('{{ asset('assets/background/what-we-do-section-pattern-bg.png') }}');">
  <div class="section-inner relative z-10 pb-6 sm:py-20 lg:py-[80px]">
    <div class="mx-auto max-w-[660px] text-center">
      <p
        class="offerings-eyebrow text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">
        How we work
      </p>
      <h2
        class="home-type-h2 mt-4 text-[20px] font-semibold leading-[28px] sm:leading-[32px] lg:leading-[36px] tracking-[-0.025em] text-[#171717] sm:text-[18px] lg:text-[24px]">
        How we build: a 5-step process with fixed checkpoints
      </h2>
      <p class="mx-auto mt-4 max-w-[605px] text-[13px] leading-[18px] sm:leading-5 text-[#4D4D4D] sm:text-[14px]">
        Every project follows the same five checkpoints, so you know the scope, cost and next deliverable at every stage.
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

    <div class="offerings-footer mt-8 flex flex-col items-start gap-4 md:flex-row md:items-center md:justify-between md:gap-6 lg:mt-10">
      <div class="offerings-controls hidden gap-2 md:flex">
        <button class="offerings-prev offerings-control" type="button" aria-label="Previous offering">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="offerings-next offerings-control" type="button" aria-label="Next offering">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <nav class="offerings-pagination flex md:hidden" aria-label="Offerings pagination"></nav>
      <x-frontend.cta-button href="#contact-modal" variant="secondary-blue" service="custom-software">
        Get a Scoped Estimate
      </x-frontend.cta-button>
    </div>
  </div>
</section>
<!-- Offerings Showcase Section End -->

<x-frontend.connect-cta-section
  eyebrow=""
  title="Have a project in mind, or need senior developers now?"
  description="Get a fixed scope and cost range within 48 hours, or interview vetted developers this week."
  note="No commitment · NDA on request · Reply within 1 business day."
  primary-label="Get a Scoped Estimate"
  primary-service="custom-software"
  secondary-label="Hire Developers"
  :secondary-modal="true"
  secondary-service="hire-developers"
  title-tag="p"
/>

<!-- Web Development Services Section Start -->
<x-frontend.three-card-section class="web-services--home" />
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
          Our principles
        </span>
      </div>
      <div class="core-values__heading">
        <h2 class="home-type-h2">Why teams choose Suave Creators</h2>
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
              sizes="(min-width: 1024px) 366px, (min-width: 768px) 292px, 90vw"
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
          Hire developers
        </span>
      </div>
      <div class="digital-marketing-services__intro">
        <h2 id="digital-marketing-title" class="home-type-h2 font-semibold text-[24px] text-[#171717] leading-[100%] mb-4">Hire dedicated software developers and web development experts
        </h2>
        <p class="text-[14px] text-[#4D4D4D] leading-5">You can hire senior software developers from Suave Creators as a dedicated team, as engineers who join your existing team, or as a fixed-price project team. Every developer is a full-time Suave Creators employee, overlaps with US business hours, and signs your NDA before starting. You interview them first and keep full ownership of all code.
        </p>
      </div>
    </header>

    <h3 class="home-subhead">Senior developers by skill</h3>

    <div class="digitalMarketingSwiper swiper">
      <div class="swiper-wrapper py-4">
        @foreach ($digitalMarketingServices as $index => $service)
          <div class="swiper-slide">
            <a href="#contact-modal" class="digital-marketing-card" data-open-contact-modal data-service="hire-developers">
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
                <p class="digital-marketing-card__headline">{{ $service['headline'] }}</p>
                <p>{{ $service['description'] }}</p>
              </div>
              <span class="digital-marketing-card__arrow" aria-hidden="true">
                <img src="{{ asset('assets/media/soft-blue-right-arrow.png') }}"
                  alt="Soft blue right arrow for hiring Suave Creators developers"
                  title="Soft blue right arrow for hiring Suave Creators developers"
                  width="18" height="5" decoding="async" loading="lazy">
              </span>
            </a>
          </div>
        @endforeach
      </div>
    </div>

    <div class="digital-marketing-services__footer">
      <div class="digital-marketing-services__controls hidden w-full justify-between md:flex">
        <button class="digital-marketing-prev digital-marketing-control" type="button"
          aria-label="Previous developer skill">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <button class="digital-marketing-next digital-marketing-control" type="button"
          aria-label="Next developer skill">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <nav class="digital-marketing-pagination flex md:hidden" aria-label="Developer skills pagination"></nav>
    </div>

    <h3 class="home-subhead">Three ways to work with us</h3>
    <div class="home-engage" data-engage-counters>
      <article class="home-engage__card">
        <p class="home-engage__model">Dedicated team</p>
        <p class="home-engage__price"><span data-counter-end="2000" data-counter-prefix="$" aria-label="$2,000" style="min-width: 6ch">$2,000</span> <span>per developer/month</span></p>
        <p class="home-engage__meta"><strong>Best for</strong> Ongoing product development</p>
        <p class="home-engage__meta"><strong>Commitment</strong> Monthly, 3-month minimum</p>
      </article>
      <article class="home-engage__card">
        <p class="home-engage__model">Staff augmentation</p>
        <p class="home-engage__price"><span data-counter-end="25" data-counter-prefix="$" aria-label="$25" style="min-width: 3ch">$25</span> <span>per hour</span></p>
        <p class="home-engage__meta"><strong>Best for</strong> Filling a skill gap in your team</p>
        <p class="home-engage__meta"><strong>Commitment</strong> Monthly, 1-month minimum</p>
      </article>
      <article class="home-engage__card">
        <p class="home-engage__model">Fixed-price project</p>
        <p class="home-engage__price"><span data-counter-end="15000" data-counter-prefix="$" aria-label="$15,000" style="min-width: 7ch">$15,000</span> <span>per project</span></p>
        <p class="home-engage__meta"><strong>Best for</strong> A clearly scoped build</p>
        <p class="home-engage__meta"><strong>Commitment</strong> Per project</p>
      </article>
    </div>

    <h3 class="home-subhead">Start in 5–10 business days</h3>
    <ol class="home-start">
      <li>
        <span class="home-start__index" aria-hidden="true">1</span>
        <p><strong>Share your requirements.</strong> Skills, seniority, time zone and team size.</p>
      </li>
      <li>
        <span class="home-start__index" aria-hidden="true">2</span>
        <p><strong>Interview a shortlist.</strong> We send 2–3 matched developer profiles within 48 hours.</p>
      </li>
      <li>
        <span class="home-start__index" aria-hidden="true">3</span>
        <p><strong>Start with low risk.</strong> If a developer isn't the right fit, we replace them at no cost.</p>
      </li>
      <li>
        <span class="home-start__index" aria-hidden="true">4</span>
        <p><strong>Ship in sprints.</strong> Your developers join your tools, standups and 2-week sprint cycle.</p>
      </li>
    </ol>
    <div class="mt-6 flex w-full flex-col items-end gap-3 sm:flex-row sm:items-center sm:justify-end">
      <x-frontend.cta-button href="#contact-modal" service="hire-developers">Hire Developers</x-frontend.cta-button>
      <a class="group inline-flex items-center gap-1.5 text-sm font-semibold text-[#2A4DFB] no-underline" href="{{ route('contact-us') }}#contact-id">Talk to a Solution Architect<x-frontend.cta-arrow /></a>
    </div>
  </div>
</section>
<!-- Digital Marketing Services Section End -->

<!-- Digital Services Marquee Section Start -->
<x-frontend.marquee-section
  type="text"
  direction="left"
  position="full"
  :speed="60"
  :items="$servicesMarqueeItems"
  aria-label="Custom software development services"
/>
<!-- Digital Services Marquee Section End -->

<!-- Portfolio Showcase Section Start -->
<section
  class="full-bleed portfolio-showcase bg-repeat py-6 md:py-12 lg:py-[80px]" style="background-image: url('{{ asset('assets/background/portfolio-section-pattern-bg.png') }}');"
  aria-labelledby="portfolio-showcase-title">
  <div class="portfolio-showcase__pattern" aria-hidden="true"></div>
  <div class="portfolio-showcase__container section-inner">
    <header class="portfolio-showcase__header">
      <p
        class="offerings-eyebrow text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">
        Our work

      </p>
      <h2 id="portfolio-showcase-title"
        class="home-type-h2 mt-1 sm:mt-4 text-[20px] font-semibold leading-[28px] sm:leading-[36px] tracking-[-0.025em] text-[#171717] sm:text-[18px] lg:text-[24px]">
        Case studies: custom software in production
      </h2>
      <p
        class="portfolio-showcase__intro mx-auto mt-1 sm:mt-4 max-w-[605px] text-[13px] leading-[18px] sm:text-[14px] sm:leading-5 text-[#4D4D4D]">
        Real platforms, real numbers. Each project below is live and used daily by the client's team.</p>
    </header>

    <div class="swiper portfolioShowcaseSwiper">
      <div class="swiper-wrapper">
        @foreach ($portfolioShowcaseProjects as $project)
          <div class="swiper-slide">
            <article class="portfolio-showcase__card">
              <a href="{{ $project['url'] }}" class="portfolio-showcase__link" @if (!empty($project['external'])) target="_blank" rel="noopener noreferrer" @endif>
                <div class="portfolio-showcase__image">
                  <img src="{{ asset($project['image']) }}" alt="{{ $project['alt'] }}" title="{{ $project['alt'] }}" loading="lazy" draggable="false" decoding="async">
                </div>
                <div class="portfolio-showcase__copy">
                  <p
                    class="inline-block text-[12px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent mb-2">
                    {{ $project['category'] }}
                  </p>
                  <h3 class="text-[14px] font-semibold text-[#171717] max-w-[300px] leading-[18px] mb-2">{{ $project['title'] }}</h3>
                  <p class=" text-[14px] leading-5 text-[#4D4D4D] max-w-[360px] ">{{ $project['description'] }}</p>
                  @if (! empty($project['link']))
                    <span class="mt-3 inline-flex items-center gap-1 text-[13px] font-semibold text-[#2A4DFB]">{{ $project['link'] }} →</span>
                  @endif
                </div>
              </a>
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
    </div>
    <div class="home-results-cta">
      <div class="home-results-cta__copy">
        <p class="home-results-cta__title">Want results like these for your team?</p>
        <p>Tell us what's slowing your team down. In a 30-minute call, a solution architect will outline how a similar build would work for you, with a timeline and cost range.</p>
      </div>
      <div class="home-results-cta__actions">
        <x-frontend.cta-button href="#contact-modal" service="custom-software">Get a Scoped Estimate</x-frontend.cta-button>
        <x-frontend.cta-button :href="route('case-studies')" variant="secondary-light">See all case studies</x-frontend.cta-button>
      </div>
    </div>
  </div>
</section>
<!-- Portfolio Showcase Section End -->

<x-frontend.industries-section
  eyebrow="Sector expertise"
  title="Industries we build for"
  description="We build secure, compliant software for industries with specific workflows and regulations."
  card-title-tag="p"
  :show-support-aside="true"
  support-text="Not sure where to start? Get a scoped estimate for your industry."
  support-href="#contact-modal"
  support-label="Get a Scoped Estimate"
  support-service="custom-software"
  :cards="[
    ['icon' => 'fa-solid fa-heart-pulse', 'title' => 'Healthcare software development', 'text' => 'HIPAA-ready patient portals, telehealth integrations and appointment automation.', 'href' => route('industry.show', ['slug' => 'healthcare-software-development'])],
    ['icon' => 'fa-solid fa-gears', 'title' => 'Software for startups and SaaS', 'text' => 'MVPs, scalable cloud back ends and multi-tenant platforms.', 'href' => route('industry.show', ['slug' => 'it-software-solutions-for-startups'])],
    ['icon' => 'fa-solid fa-landmark', 'title' => 'Finance and banking software', 'text' => 'Billing ledgers, payment integrations and compliance audit tools.', 'href' => route('industry.show', ['slug' => 'finance-banking-software-development'])],
    ['icon' => 'fa-solid fa-cart-shopping', 'title' => 'Retail and e-commerce solutions', 'text' => 'Inventory management, pricing engines and headless commerce.', 'href' => route('industry.show', ['slug' => 'retail-ecommerce-solutions'])],
    ['icon' => 'fa-solid fa-truck-fast', 'title' => 'Logistics and supply chain software', 'text' => 'Fleet tracking, carrier dispatch and warehouse sync.', 'href' => route('industry.show', ['slug' => 'logistics-supply-chain-apps'])],
    ['icon' => 'fa-solid fa-laptop-file', 'title' => 'Education and e-learning platforms', 'text' => 'LMS platforms, testing portals and certification management.', 'href' => route('industry.show', ['slug' => 'education-elearning-platforms'])],
  ]"
/>

<section id="saas-comparison" class="home-compare full-bleed bg-repeat py-12 lg:py-20" style="background-image: url('{{ asset('assets/background/what-we-do-section-pattern-bg.png') }}');" aria-labelledby="saas-comparison-title">
  <div class="section-inner">
    <div class="home-compare__intro">
      <p class="offerings-eyebrow text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">Custom vs SaaS</p>
      <h2 id="saas-comparison-title" class="home-type-h2 mt-4 text-[20px] font-semibold leading-[28px] text-[#171717] sm:text-[18px] lg:text-[24px]">Custom software vs SaaS subscriptions: when does building pay off?</h2>
      <p>Custom software usually pays off by year two or three for teams with 25+ users or workflows that SaaS tools can't handle. SaaS tools charge per seat every year and add paid tiers for automation and AI. Custom software is a one-time build plus predictable hosting and support. The table below uses CRM as the example.</p>
    </div>
    <div class="home-compare__scroll">
      <table class="home-compare__table">
        <thead>
          <tr>
            <th></th>
            <th>Custom CRM (Suave Creators)</th>
            <th>Salesforce / HubSpot</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Pricing model</th>
            <td>One-time build + fixed monthly support</td>
            <td>Per user, per month, rising by tier</td>
          </tr>
          <tr>
            <th scope="row">Cost as the team grows</th>
            <td>Nearly flat</td>
            <td>Grows with every new seat</td>
          </tr>
          <tr>
            <th scope="row">Code and data ownership</th>
            <td>100% yours</td>
            <td>Vendor-hosted, licence-based</td>
          </tr>
          <tr>
            <th scope="row">Workflow fit</th>
            <td>Built to your process</td>
            <td>You adapt to the platform</td>
          </tr>
          <tr>
            <th scope="row">AI features</th>
            <td>Built in, using your own models or APIs</td>
            <td>Usually paid add-ons</td>
          </tr>
          <tr>
            <th scope="row">Time to launch</th>
            <td>8–16 weeks for most builds</td>
            <td>Days to set up, months to customise</td>
          </tr>
          <tr>
            <th scope="row">Best for</th>
            <td>Teams with unique workflows or 25+ seats</td>
            <td>Small teams with standard sales processes</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section id="pricing" class="home-pricing full-bleed bg-cover bg-top bg-no-repeat py-12 lg:py-20" style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}');" aria-labelledby="pricing-title">
  <div class="section-inner">
    <div class="home-pricing__intro">
      <p class="offerings-eyebrow text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">Pricing</p>
      <h2 id="pricing-title" class="home-type-h2 mt-4 text-[20px] font-semibold leading-[28px] text-[#171717] sm:text-[18px] lg:text-[24px]">How much does custom software development cost?</h2>
      <p>Custom software development at Suave Creators typically costs $15,000–$50,000 for an MVP or single-workflow tool and $50,000–$150,000 for a multi-team platform, with enterprise systems above that. Dedicated developers start at $2,000 per developer per month. Every fixed-price project starts with a paid discovery phase that sets the final scope and price.</p>
    </div>
    <div class="home-pricing__grid">
      <article class="home-pricing__card">
        <h3>Fixed-price projects</h3>
        <p class="home-pricing__price">from $15,000 · 6–16 weeks</p>
        <p>For clearly defined builds: MVPs, internal tools, customer portals and integrations.</p>
      </article>
      <article class="home-pricing__card">
        <h3>Dedicated development team</h3>
        <p class="home-pricing__price">from $2,000 per developer/month</p>
        <p>For ongoing product work; scale the team up or down each month.</p>
      </article>
      <article class="home-pricing__card">
        <h3>Support and maintenance retainers</h3>
        <p class="home-pricing__price">from $500/month</p>
        <p>Monitoring, security patches, bug fixes and small features under a written SLA.</p>
      </article>
    </div>
    <div class="home-pricing__note">
      <p class="home-pricing__note-copy">
        <a href="{{ route('service.show', ['slug' => 'custom-crm-development']) }}">Looking for CRM pricing specifically? See custom CRM development costs →</a>
      </p>
      <div class="home-pricing__actions">
        <x-frontend.cta-button href="#contact-modal" service="custom-software">Get a Scoped Estimate</x-frontend.cta-button>
        <x-frontend.cta-button href="#contact-modal" variant="secondary-light" service="hire-developers">Hire Developers</x-frontend.cta-button>
      </div>
    </div>
  </div>
</section>

<!-- Technology Section Start -->
<x-frontend.four-card-section background-image="assets/background/technology-section-bg.png" />
<!-- Technology Section End -->


<x-frontend.faq-section
  class="home-faq"
  :qa="$faqs"
  :media="$faqMedia"
  :media-type="$faqMediaType"
  :media-alt="$faqMediaAlt"
  :cta-href="$faqCtaHref"
  :cta-label="$faqCtaLabel"
  eyebrow="FAQ"
  title="Frequently asked questions about hiring a software development company"
  description=""
/>


<x-frontend.testimonials-section
  eyebrow="Client feedback"
  title="What our clients say"
  :items="$testimonials"
/>

<x-frontend.articles-insights-section
  eyebrow="From the engineering blog"
  title=""
  subtitle=""
  :show-title="false"
  heading-id="articles-insights-title"
  more-href="{{ route('blogs') }}"
  more-label="All engineering articles"
/>

@php
  $homeOffice = \App\Support\Frontend\ContactSupport::offices()[0] ?? [];
@endphp
<section id="home-final" class="home-final full-bleed bg-cover bg-top bg-no-repeat" aria-labelledby="home-final-title" style="background-image: url('{{ asset('assets/background/blog-section-bg.webp') }}');">
  <div class="section-inner site-container">
    <div class="home-final__panel">
      <div class="home-final__intro">
        <p class="home-final__eyebrow">Let's build together</p>
        <h2 id="home-final-title" class="home-final__title">Ready to Build or Scale <span>Your Product?</span></h2>
        <p>Tell us what you're building, what you need, or the skills you're looking for. Our team will review your requirements and get back to you with the right next steps.</p>
      </div>
      <div class="home-final__cards">
        <article class="home-final__offer home-final__offer--estimate">
          <div class="home-final__icon" aria-hidden="true">
            <img src="{{ asset('assets/product/document.png') }}" alt="Project estimate document icon for custom software quotes at Suave Creators" title="Project estimate document icon for custom software quotes at Suave Creators" width="31" height="28" decoding="async" loading="lazy">
          </div>
          <h3>Get a Project Estimate</h3>
          <p>For a new product, CRM, ERP, portal or software application.</p>
          <ul>
            <li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="M5.8 10.2 8.5 12.9 14.2 7.2" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>Share your vision and requirements</li>
            <li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="M5.8 10.2 8.5 12.9 14.2 7.2" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>Get initial scope, timeline and estimated cost</li>
            <li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="M5.8 10.2 8.5 12.9 14.2 7.2" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>No obligation, just expert guidance</li>
          </ul>
          <button type="button" class="home-final__cta" data-inquiry-dialog-open="project-estimate-dialog" aria-haspopup="dialog" aria-controls="project-estimate-dialog">
            Get an Estimate
            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M11 5.5 15.5 10 11 14.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </article>
        <article class="home-final__offer home-final__offer--hire">
          <div class="home-final__icon" aria-hidden="true">
            <img src="{{ asset('assets/team/teamwork-icon.svg') }}" alt="Teamwork icon for hiring dedicated software developers at Suave Creators" title="Teamwork icon for hiring dedicated software developers at Suave Creators" width="25" height="20" decoding="async" loading="lazy">
          </div>
          <h3>Hire Developers</h3>
          <p>Need additional capacity or specific expertise?</p>
          <ul>
            <li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="M5.8 10.2 8.5 12.9 14.2 7.2" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>Tell us your technical requirements</li>
            <li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="M5.8 10.2 8.5 12.9 14.2 7.2" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>Get suitable developer options</li>
            <li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="M5.8 10.2 8.5 12.9 14.2 7.2" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>Flexible engagement models</li>
          </ul>
          <button type="button" class="home-final__cta" data-inquiry-dialog-open="hire-developers-dialog" aria-haspopup="dialog" aria-controls="hire-developers-dialog">
            Hire Developers
            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M11 5.5 15.5 10 11 14.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </article>
      </div>
      <div class="home-final__direct">
        <span class="home-final__headset" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="18" height="18"><path d="M4.8 12.2a7.2 7.2 0 0 1 14.4 0" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M4.8 12.2v3.2a1.6 1.6 0 0 0 1.6 1.6h1.2v-6.2H6.4a1.6 1.6 0 0 0-1.6 1.4zM19.2 12.2v3.2a1.6 1.6 0 0 1-1.6 1.6h-1.2v-6.2h1.2a1.6 1.6 0 0 1 1.6 1.4z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M12 20.2h2.2a2 2 0 0 0 2-2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
        </span>
        <p>
          <strong>Prefer to talk directly?</strong>
          <a href="mailto:{{ $homeOffice['email'] ?? 'info@suavecreators.com' }}">{{ $homeOffice['email'] ?? 'info@suavecreators.com' }}</a>
          <span aria-hidden="true">·</span>
          <a href="{{ $homeOffice['phone_href'] ?? 'tel:+13074359605' }}">{{ $homeOffice['phone'] ?? '+1 (307) 435-9605' }}</a>
          <span aria-hidden="true">·</span>
          <a href="{{ route('contact-us') }}#contact-id">Contact Us <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M11 5.5 15.5 10 11 14.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
        </p>
      </div>
      <ul class="home-final__trust">
        <li>
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.4 5.2 6.2v5.3c0 4.2 2.8 7.2 6.8 8.9 4-1.7 6.8-4.7 6.8-8.9V6.2L12 3.4z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
          NDA available on request
        </li>
        <li>
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8.2 8.2 4 12l4.2 3.8M15.8 8.2 20 12l-4.2 3.8M13.2 5.5l-2.4 13" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          100% code ownership
        </li>
        <li>
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="7.2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M12 8.4V12l2.4 1.6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Reply within 1 business day
        </li>
      </ul>
    </div>
  </div>
</section>

{{-- Body-level inquiry dialogs (estimate + hire). --}}
<x-frontend.modal.project-estimate-modal />
<x-frontend.modal.hire-developers-modal />

<!-- Partnerships Section Start -->
<x-frontend.partnerships-section eyebrow="Trusted by teams at" :items="$partnerMarqueeItems" />
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
  line-height: 1.25rem;
  margin-top: 4px;
  max-width: 97%;
  font-weight: 500;
}

.offerings-expert-link {
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
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

a.digital-marketing-card {
  color: inherit;
  text-decoration: none;
}

.home-subhead {
  background: linear-gradient(to right, #2A4DFB, #7A5FF8);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  color: transparent;
  display: block;
  font-size: 18px;
  font-weight: 700;
  letter-spacing: -0.02em;
  line-height: 1.3;
  margin-top: 36px;
  margin-inline: auto;
  text-align: center;
  width: fit-content;
}

.home-engage,
.home-pricing__grid {
  display: grid;
  gap: 16px;
  grid-template-columns: 1fr;
  margin-top: 16px;
}

.home-engage__card,
.home-pricing__card {
  background: #fff;
  border: 1px solid #ececec;
  border-radius: 12px;
  box-shadow: 3px 6px 14px 0 #00003f0f;
  padding: 20px;
}

.home-engage__model,
.home-pricing__card h3 {
  color: #171717;
  font-size: 16px;
  font-weight: 700;
  line-height: 1.3;
}

.home-engage__price,
.home-pricing__price {
  color: #2a4dfb;
  font-size: 22px;
  font-weight: 700;
  letter-spacing: -0.03em;
  line-height: 1.2;
  margin-top: 8px;
}

.home-engage__price [data-counter-end] {
  background-image: linear-gradient(#2f69fb 49.52%, #d078fe 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  color: transparent;
  display: inline-block;
  font-variant-numeric: tabular-nums;
}

.home-engage__price span:last-child {
  -webkit-text-fill-color: #4d4d4d;
  color: #4d4d4d;
  display: block;
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 0;
  margin-top: 2px;
}

.home-engage__meta,
.home-pricing__card p:last-child,
.home-compare__intro > p:not(.offerings-eyebrow),
.home-pricing__intro > p:not(.offerings-eyebrow) {
  color: #4d4d4d;
  font-size: 14px;
  line-height: 1.45;
  margin-top: 10px;
}

.home-engage__meta strong {
  color: #171717;
  font-weight: 600;
}

.home-start {
  background: #19182f;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  gap: 0;
  list-style: none;
  margin-top: 16px;
  overflow: hidden;
  padding: 0;
}

.home-start li {
  align-items: flex-start;
  background: transparent;
  border: 0;
  border-radius: 0;
  box-sizing: border-box;
  display: flex;
  flex: 1 1 auto;
  flex-direction: column;
  min-width: 0;
  padding: 24px 22px;
  position: relative;
}

.home-start li + li::before {
  background: rgba(255, 255, 255, 0.12);
  content: "";
  height: 1px;
  left: 22px;
  position: absolute;
  right: 22px;
  top: 0;
}

.home-start p {
  align-self: stretch;
  color: rgba(255, 255, 255, 0.72);
  font-size: 14px;
  line-height: 1.45;
  margin: 10px 0 0;
}

.home-start strong {
  color: #fff;
  font-weight: 600;
}

.home-start__index {
  align-items: center;
  background: linear-gradient(180deg, #2a4dfb 0%, #7a5ff8 100%);
  border-radius: 50%;
  color: #fff;
  display: inline-flex;
  flex: 0 0 auto;
  font-size: 14px;
  font-weight: 700;
  height: 32px;
  justify-content: center;
  width: 32px;
}

@media (max-width: 767px) {
  .home-start {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .home-start li {
    padding: 14px 12px;
  }

  .home-start li:nth-child(2n) {
    border-left: 1px solid rgba(255, 255, 255, 0.12);
  }

  .home-start li:nth-child(n + 3) {
    border-top: 1px solid rgba(255, 255, 255, 0.12);
  }

  .home-start li + li::before {
    display: none;
  }

  .home-start p {
    font-size: 12px;
    line-height: 1.4;
    overflow-wrap: anywhere;
  }

  .home-start__index {
    font-size: 12px;
    height: 24px;
    width: 24px;
  }
}

.home-compare__intro {
  max-width: none;
  min-width: 0;
  width: 100%;
}

.home-pricing__intro {
  max-width: 760px;
}

.home-compare__scroll {
  background: #fff;
  border: 1px solid #ececec;
  border-radius: 12px;
  box-shadow: 3px 6px 14px 0 #00003f0f;
  margin-top: 28px;
  overflow-x: auto;
}

.home-compare__table {
  border-collapse: collapse;
  min-width: 680px;
  width: 100%;
}

.home-compare__table th,
.home-compare__table td {
  border-bottom: 1px solid #ececec;
  font-size: 14px;
  line-height: 1.4;
  padding: 14px 16px;
  text-align: left;
  vertical-align: top;
}

.home-compare__table thead th {
  background: #eef2ff;
  color: #00003f;
  font-weight: 600;
}

.home-compare__table thead th:nth-child(2) {
  background: #e0e7ff;
  color: #2a4dfb;
}

.home-compare__table tbody th {
  background: #f4f6ff;
  color: #171717;
  font-weight: 600;
  width: 28%;
}

.home-compare__table td:nth-child(2) {
  background: #eef2ff;
  color: #171717;
  font-weight: 600;
}

.home-compare__table td:nth-child(3) {
  color: #4d4d4d;
}

.home-compare__table tr:last-child th,
.home-compare__table tr:last-child td {
  border-bottom: 0;
}

.home-pricing__actions {
  justify-content: flex-end;
}

@media (max-width: 767px) {
  .home-compare__intro,
  .home-compare__intro h2,
  .home-compare__intro p {
    overflow-wrap: break-word;
  }

  .home-compare .section-inner,
  .home-compare__scroll {
    max-width: 100%;
    min-width: 0;
  }

  .home-compare__scroll {
    overflow-x: visible;
  }

  .home-compare__table {
    min-width: 0;
  }

  .home-compare__table th,
  .home-compare__table td {
    font-size: 12px;
    overflow-wrap: anywhere;
    padding: 10px 8px;
  }
}

.home-pricing__note {
  align-items: center;
  background: #fff;
  border: 1px solid #ececec;
  border-left: 3px solid #2a4dfb;
  border-radius: 12px;
  box-shadow: 3px 6px 14px 0 #00003f0f;
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  justify-content: space-between;
  margin-top: 16px;
  padding: 14px 18px;
}

.home-pricing__note-copy {
  flex: 1 1 240px;
  margin: 0;
}

.home-pricing__note-copy a {
  color: #171717;
  font-size: 14px;
  font-weight: 600;
  line-height: 1.45;
  text-decoration: none;
}

.home-pricing__note-copy a:hover {
  color: #2a4dfb;
}

.home-pricing__note .home-pricing__actions {
  margin-top: 0;
}

.faq-section.home-faq {
  padding-top: 48px;
}

.faq-section.home-faq .faq-section__cta {
  margin-top: 32px;
}

@media (min-width: 1024px) {
  .faq-section.home-faq {
    padding-top: 64px;
  }
}

@media (max-width: 767px) {
  .faq-section.home-faq {
    padding-top: 40px;
  }
}

.home-pricing__grid {
  margin-top: 28px;
}

.home-pricing__card {
  min-height: 168px;
  position: relative;
}

.home-pricing__card::before {
  /* background: linear-gradient(90deg, #2a4dfb 0%, #7a5ff8 100%); */
  border-radius: 12px 12px 0 0;
  content: "";
  height: 3px;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
}

.home-pricing__actions,
.home-results-cta__actions {
  align-items: flex-start;
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: 20px;
}

.home-results-cta {
  align-items: center;
  background: #fff;
  border: 1px solid #ececec;
  border-radius: 12px;
  box-shadow: 3px 6px 14px 0 #00003f0f;
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-top: 20px;
  padding: 20px;
}

.home-results-cta__title {
  color: #171717;
  font-size: 18px;
  font-weight: 700;
  letter-spacing: -0.02em;
  line-height: 1.3;
}

.home-results-cta__copy p:last-child {
  color: #4d4d4d;
  font-size: 14px;
  line-height: 1.45;
  margin-top: 6px;
}

.home-final {
  background-color: #e8eefb;
  padding: 28px 0 40px;
}

.home-final__panel {
  background: #fff;
  border: 1px solid rgba(255, 255, 255, 0.95);
  border-radius: 32px;
  box-shadow: 0 20px 50px rgba(28, 43, 99, 0.06);
  padding: 40px 18px 28px;
}

.home-final__intro {
  margin-inline: auto;
  max-width: 720px;
  text-align: center;
}

.home-final__eyebrow {
  color: #3d63f5;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 0.18em;
  margin: 0 0 14px;
  text-transform: uppercase;
}

.home-final__title {
  color: #101433;
  font-size: clamp(28px, 3.1vw, 40px);
  font-weight: 800;
  letter-spacing: -0.035em;
  line-height: 1.12;
  margin: 0;
}

.home-final__title span {
  background: linear-gradient(90deg, #2f62ff 0%, #6d4dff 46%, #9b4dff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

.home-final__intro > p {
  color: #6d7586;
  font-size: 16px;
  line-height: 1.55;
  margin: 16px auto 0;
  max-width: 640px;
}

.home-final__cards {
  display: grid;
  gap: 20px;
  margin-top: 36px;
}

.home-final__offer {
  background: #fff;
  border: 1px solid #eef1f7;
  border-radius: 22px;
  box-shadow: 0 10px 28px rgba(16, 24, 64, 0.05);
  display: flex;
  flex-direction: column;
  min-width: 0;
  overflow: hidden;
  padding: 28px 26px 24px;
  position: relative;
}

.home-final__offer::after {
  border-radius: 50%;
  content: "";
  height: 150px;
  pointer-events: none;
  position: absolute;
  right: -48px;
  top: -56px;
  width: 150px;
}

.home-final__offer--estimate::after {
  background: radial-gradient(circle, rgba(47, 98, 255, 0.1) 0%, rgba(47, 98, 255, 0) 70%);
}

.home-final__offer--hire::after {
  background: radial-gradient(circle, rgba(138, 92, 246, 0.18) 0%, rgba(138, 92, 246, 0) 72%);
}

.home-final__icon {
  align-items: center;
  border-radius: 50%;
  display: grid;
  height: 56px;
  place-items: center;
  position: relative;
  width: 56px;
  z-index: 1;
}

.home-final__icon img {
  display: block;
  height: 22px;
  width: auto;
}

.home-final__offer--estimate .home-final__icon img {
  height: 28px;
}

.home-final__offer--estimate .home-final__icon {
  background: #eaf0ff;
  color: #2f62ff;
}

.home-final__offer--hire .home-final__icon {
  background: #f3edff;
  color: #7c4dff;
}

.home-final__offer h3,
.home-final__offer > p,
.home-final__offer ul,
.home-final__cta {
  position: relative;
  z-index: 1;
}

.home-final__offer h3 {
  color: #12163a;
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -0.03em;
  margin: 18px 0 0;
}

.home-final__offer > p {
  color: #6d7586;
  font-size: 15px;
  line-height: 1.5;
  margin: 8px 0 0;
}

.home-final__offer ul {
  display: grid;
  gap: 10px;
  list-style: none;
  margin: 18px 0 22px;
  padding: 0;
}

.home-final__offer li {
  align-items: flex-start;
  color: #3c4458;
  display: flex;
  font-size: 15px;
  font-weight: 500;
  gap: 10px;
  line-height: 1.4;
}

.home-final__offer li svg {
  flex-shrink: 0;
  height: 20px;
  margin-top: 1px;
  width: 20px;
}

.home-final__offer--estimate li svg {
  color: #2f62ff;
}

.home-final__offer--hire li svg {
  color: #7c4dff;
}

.home-final__cta {
  align-items: center;
  border: 0;
  border-radius: 12px;
  color: #fff;
  cursor: pointer;
  display: inline-flex;
  font-size: 16px;
  font-weight: 700;
  gap: 8px;
  justify-content: center;
  min-height: 52px;
  padding: 14px 18px;
}

.home-final__cta svg,
.home-final__direct a svg {
  height: 16px;
  width: 16px;
}

.home-final__cta {
  margin-top: auto;
  width: 100%;
}

.home-final__offer--estimate .home-final__cta {
  background: #2f62ff;
  box-shadow: 0 8px 18px rgba(47, 98, 255, 0.22);
}

.home-final__offer--hire .home-final__cta {
  background: #7c4dff;
  box-shadow: 0 8px 18px rgba(124, 77, 255, 0.22);
}

.home-final__offer--estimate .home-final__cta:hover {
  background: #2454f0;
}

.home-final__offer--hire .home-final__cta:hover {
  background: #6b3cf0;
}

.home-final__direct {
  align-items: center;
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  justify-content: center;
  margin-top: 32px;
}

.home-final__headset {
  align-items: center;
  background: #f3f6fb;
  border: 0;
  border-radius: 50%;
  color: #64748b;
  display: grid;
  flex-shrink: 0;
  height: 42px;
  place-items: center;
  width: 42px;
}

.home-final__direct p {
  color: #0b1036;
  font-size: 14px;
  line-height: 1.6;
  margin: 0;
}

.home-final__direct strong {
  font-weight: 700;
  margin-right: 6px;
}

.home-final__direct a {
  color: #2f62ff;
  font-weight: 600;
  text-decoration: none;
}

.home-final__direct a svg {
  display: inline-block;
  vertical-align: -2px;
}

.home-final__direct span[aria-hidden] {
  color: #94a3b8;
  margin-inline: 4px;
}

.home-final__trust {
  align-items: center;
  color: #7b8494;
  display: flex;
  flex-wrap: wrap;
  font-size: 14px;
  gap: 10px 36px;
  justify-content: center;
  list-style: none;
  margin: 22px 0 0;
  padding: 0;
}

.home-final__trust li {
  align-items: center;
  display: inline-flex;
  gap: 8px;
}

.home-final__trust svg {
  height: 16px;
  width: 16px;
}

@media (min-width: 640px) {
  .home-final__panel {
    padding: 56px 40px 36px;
  }
}

@media (min-width: 900px) {
  .home-final__cards {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (min-width: 768px) {
  .home-engage,
  .home-pricing__grid {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }

  .home-results-cta {
    flex-direction: row;
    justify-content: space-between;
    padding: 24px 28px;
  }

  .home-results-cta__actions {
    flex-shrink: 0;
    margin-top: 0;
  }

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

.digital-marketing-card__content h3,
.digital-marketing-card__headline {
  color: #171717;
  font-size: 14px;
  font-weight: 600;
  line-height: 100%;
}

.digital-marketing-card__content p {
  color: #4D4D4D;
  font-size: 14px;
  line-height: 1.25rem;
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
  justify-content: space-between;
  width: 100%;
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
  line-height: 1.25rem;
  text-decoration: none;
}

.digital-marketing-services__more a {
  color: #2a4dfb;
  margin-left: 8px;
  text-decoration: none;
  font-size: 14px;
  font-weight: 600;
}

@media (min-width: 1024px) {
  .home-start {
    flex-direction: row;
    flex-wrap: nowrap;
  }

  .home-start li {
    flex: 1 1 0;
    padding: 28px 24px;
  }

  .home-start li + li::before {
    bottom: 28px;
    height: auto;
    left: 0;
    right: auto;
    top: 28px;
    width: 1px;
  }

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
  }

  .offerings-showcase {
    overflow: visible;
  }

  .offerings-showcase > .section-inner {
    padding-block: 24px;
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
    align-items: flex-start;
    flex-direction: column;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 16px;
  }

  .offerings-pagination {
    flex: 1 1 auto;
    min-width: 0;
  }

  .offerings-expert-link {
    flex-shrink: 1;
    max-width: 100%;
    white-space: normal;
  }

  .digital-marketing-services__more {
    align-items: flex-start;
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-width: 100%;
  }

  .digital-marketing-services__more a {
    margin-left: 0;
  }

  .digital-marketing-services__more-text {
    display: none !important;
  }

  .digital-marketing-services {
    padding: 24px 0;
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

  .digital-marketing-card__content h3,
.digital-marketing-card__headline {
    font-size: 14px;
  }

  .digital-marketing-card__content p {
    font-size: 13px;
    line-height: 18px;
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

  .digital-marketing-card__number {
    font-size: 28px;
    height: auto;
    line-height: 1;
    top: 0;
    width: auto;
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
    --collage-gap: 10px;
    grid-template-columns: 190fr 180fr 154fr;
    justify-content: stretch;
    margin-inline: 0;
    max-width: 100%;
    width: 100%;
  }

  .about-collage__column--left,
  .about-collage__column--center,
  .about-collage__column--right {
    width: 100%;
  }

  .about-collage__tile,
  .about-collage__tile--team,
  .about-collage__tile--office-small,
  .about-collage__tile--portrait-tall,
  .about-collage__tile--leader,
  .about-collage__tile--portrait-main,
  .about-collage__tile--office-wide,
  .about-collage__tile--portrait-right,
  .about-collage__tile--meeting,
  .about-collage__tile--meeting-sm {
    height: auto;
    width: 100%;
  }

  .about-collage__tile--team,
  .about-collage__tile--office-small {
    aspect-ratio: 120 / 90;
  }

  .about-collage__tile--portrait-tall {
    aspect-ratio: 190 / 240;
  }

  .about-collage__tile--leader {
    aspect-ratio: 180 / 140;
  }

  .about-collage__tile--portrait-main {
    aspect-ratio: 180 / 280;
  }

  .about-collage__tile--office-wide {
    aspect-ratio: 180 / 120;
  }

  .about-collage__tile--portrait-right {
    aspect-ratio: 154 / 140;
  }

  .about-collage__tile--meeting {
    aspect-ratio: 154 / 112;
  }

  .about-collage__tile--meeting-sm {
    aspect-ratio: 124 / 94;
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

    var engageRoot = document.querySelector('[data-engage-counters]');

    if (engageRoot) {
      var engagePrices = engageRoot.querySelectorAll('.home-engage__price [data-counter-end]');
      var engageStarted = false;

      function formatEngagePrice(value, prefix) {
        return prefix + Math.round(value).toLocaleString('en-US');
      }

      function animateEngagePrices() {
        if (engageStarted) return;
        engageStarted = true;

        engagePrices.forEach(function (el) {
          var end = parseInt(el.getAttribute('data-counter-end'), 10) || 0;
          var prefix = el.getAttribute('data-counter-prefix') || '';

          if (reduceMotion) {
            el.textContent = formatEngagePrice(end, prefix);
            return;
          }

          el.textContent = formatEngagePrice(0, prefix);

          var duration = 1500;
          var startTime = null;

          function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = formatEngagePrice(progress === 1 ? end : end * eased, prefix);
            if (progress < 1) requestAnimationFrame(step);
          }

          requestAnimationFrame(step);
        });
      }

      if ('IntersectionObserver' in window) {
        var engageObserver = new IntersectionObserver(function (entries) {
          if (entries.some(function (entry) { return entry.isIntersecting; })) {
            animateEngagePrices();
            engageObserver.disconnect();
          }
        }, { threshold: 0.35 });
        engageObserver.observe(engageRoot);
      } else {
        animateEngagePrices();
      }
    }
  });

  window.suaveWhenSwiperReady(function () {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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
      rewind: true,
      watchOverflow: true,
      autoplay: reduceMotion
        ? false
        : { delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true },
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