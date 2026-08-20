@extends('layouts.frontend')

@section('content')


<!-- 1. Hero Section (MainService) Start -->
<section
  class="full-bleed relative flex items-center bg-cover bg-center bg-no-repeat py-6 md:py-12 lg:py-16" style="background-image: url('{{ asset('assets/media/top-banner-visual.webp') }}')"
  aria-labelledby="services-hero-title">
  <div class="section-inner relative z-[1]">
    <div class="relative max-w-[720px] pl-6 sm:pl-8 md:max-w-[66%] lg:pl-10">
      <p
        class="absolute left-0 top-4 text-[12px] font-medium uppercase tracking-[2px] text-[#111827] underline [writing-mode:vertical-rl] rotate-180">
        Our Services
      </p>
      <h1 id="services-hero-title"
        class="page-hero-title mb-3 text-[26px] font-bold leading-[28px] text-[#111827] sm:mb-4 sm:text-[44px] sm:leading-[1.15] lg:text-[50px] lg:leading-[1.15]">
        Offshore Web, Software &amp;<br class="hidden sm:block">
        Digital Development Services<br class="hidden sm:block">
        for Global Businesses
      </h1>
      <p class="mb-0 mt-1 max-w-xl text-[14px] leading-5 text-[#4D4D4D]">
        Let&rsquo;s transform your business with custom software and digital development services. At Suave Creators,
        we build websites and trust by developing top-notch digital products. Our custom offshore development
        services are a merger of cost-effective and innovative design solutions that drive digital transformation.
        Our expert team focuses on reducing operational costs and enhancing mobile and cloud capabilities for
        businesses of all sizes.
      </p>
      <div class="mt-5 flex flex-col items-start gap-4">
        <x-frontend.inline-consultation-form
          theme="light"
          placeholder="Enter your phone or email"
          button-text="Get Free Consultation"
          :secondary-href="$demoHref"
          secondary-label="Schedule a discovery call" />
        {{-- <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:gap-7">
          <a href="#core-services" class="banner-text-link items-end border-b border-[#111827]/70 pb-0.5 text-[13px] font-semibold leading-[18px] text-[#111827] sm:text-sm">
            Explore Our Services
          </a>
          <a href="{{ route('product') }}" class="banner-text-link items-end border-b border-[#111827]/70 pb-0.5 text-[13px] font-semibold leading-[18px] text-[#111827] sm:text-sm">
            Explore Suave Outreach CRM
          </a>
        </div> --}}
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
        <img src="{{ asset('assets/media/circular-text-badge.png') }}" alt="Circular Text Badge for Suave Creators software development" title="Circular Text Badge for Suave Creators software development" class="digital-solution-section__ring" width="120" height="120">
        <img src="{{ asset('assets/icons/circular-icon.png') }}" alt="Circular Icon for Suave Creators software development" title="Circular Icon for Suave Creators software development" class="digital-solution-section__icon" width="40" height="40">
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
<section class="full-bleed bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20" style="background-image: url('{{ asset('assets/background/digital-marketing-section-bg.png') }}')" aria-labelledby="expertise-title">
  <div class="section-inner">
    <header class="mb-8 max-w-[960px] lg:mb-16">
      <p
        class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Expertise
      </p>
      <h2 id="expertise-title" class="home-type-h2 mt-4 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:text-[18px] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">
        We Build impactful solutions through web design and development.
      </h2>
    </header>

    <div class="about-stats">
      @foreach ($expertiseItems as $item)
        <article class="about-stat"
          style="--stat-accent: {{ $item[3] }}; --stat-tint: {{ $item[4] }};">
          <span class="about-stat__icon">
            <img src="{{ asset($item[0]) }}" alt="{{ $item[5] ?? $item[1] }}" title="{{ $item[5] ?? $item[1] }}" class="about-stat__icon-image" width="40" height="40" decoding="async" loading="lazy">
          </span>
          <div class="about-stat__content">
            <strong class="about-stat__value about-stat__value--title">{{ $item[1] }}</strong>
            <p class="about-stat__description">{{ $item[2] }}</p>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
<!-- 3. Expertise Section End -->

<!-- 4. Technologies & Partnerships Marquee Section Start -->
<x-frontend.tech-partnerships-section :items="$techStack" />
<!-- 4. Technologies & Partnerships Marquee Section End -->

<!-- 5. Core Services Section Start -->
<section id="core-services" class="full-bleed web-services bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20" style="background-image: url('{{ asset('assets/background/web-services-section-bg.png') }}')"
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
        <h2 id="core-services-title" class="home-type-h2 mb-4 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:text-[18px] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">
          Our Core Services
        </h2>
        <p class="text-[14px] leading-5 text-[#4D4D4D]">
          A complete offshore development suite covering web, software, design, CRM, e-commerce and AI &mdash;
          everything you need under one roof.
        </p>
      </div>
    </header>

    <div class="web-services__grid">
      @foreach ($servicesData as $service)
        <a href="{{ $service[4] }}" class="web-service-card block">
          <span class="web-service-card__icon web-service-card__icon--lg web-service-card__icon--{{ $service[5] }}">
            <img src="{{ asset($service[0]) }}" alt="{{ $service[1] }}" title="{{ $service[1] }}" width="28" height="28">
          </span>

          <div class="web-service-card__category">
            <h3 class="text-[14px] font-semibold leading-[18px] text-[#171717]">
              {{ $service[1] }}
            </h3>
          </div>

          <p class="mt-1 text-[14px] leading-5 text-[#4D4D4D]">{{ $service[2] }}</p>

          <span class="mt-3 inline-flex items-center gap-1.5 text-[13px] font-semibold leading-[18px] text-[#2A4DFB]">
            {{ $service[3] }}
            <svg xmlns="https://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 24 24" fill="none"
              stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 8L22 12L18 16" />
              <path d="M2 12H22" />
            </svg>
          </span>
        </a>
      @endforeach
    </div>

    <div class="web-services__footer">
      <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer">Discuss your Requirements</a>
      <a href="{{ route('product') }}">Explore Suave Outreach CRM</a>
    </div>
  </div>
</section>
<!-- 5. Core Services Section End -->

<x-frontend.connect-cta-section
  :eyebrow="$connectCta['eyebrow']"
  :title="$connectCta['title']"
  :description="$connectCta['description']"
  :primary-label="$connectCta['primaryLabel']"
  title-id="services-cta-title"
/>

<!-- 7. Offshore Services Section Start -->
<section class="full-bleed bg-[#F9FAFC] bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20" style="background-image: url('{{ asset('assets/background/offerings-section-bg.webp') }}')"
  aria-labelledby="offshore-services-title">
  <div class="section-inner">
    <header class="mx-auto mb-8 max-w-[720px] text-center lg:mb-14">
      <p
        class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Offshore Services
      </p>
      <h2 id="offshore-services-title"
        class="home-type-h2 mt-4 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:text-[18px] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">
        Why Global Businesses Choose Our Offshore Services
      </h2>
      <p class="mx-auto mt-4 max-w-[620px] text-[14px] leading-5 text-[#4D4D4D]">
        Our Offshore services provide a flexible and scalable solution for your business needs. You can easily
        adjust your service requirements up or down as and when needed.
      </p>
    </header>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-3 lg:gap-6">
      @foreach ($offshoreSlides as $slide)
        <article
          class="flex min-h-full flex-col gap-3 overflow-hidden rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          <figure class="aspect-[16/10] overflow-hidden">
            <img src="{{ asset($slide[0]) }}" alt="{{ $slide[4] }}" title="{{ $slide[4] }}" class="h-full w-full object-cover" loading="lazy">
          </figure>
          <div class="flex flex-1 flex-col gap-3 p-[22px]">
            <h3 class="text-[14px] font-semibold leading-[18px] text-[#171717]">{{ $slide[1] }}</h3>
            <p class="flex-1 text-[14px] leading-5 text-[#4D4D4D]">{{ $slide[2] }}</p>
            <div class="flex flex-wrap gap-1.5">
              @foreach ($slide[3] as $tag)
                <span
                  class="rounded-full bg-[#EEF1FF] px-2.5 py-0.5 text-[11px] font-semibold text-[#2A4DFB]">{{ $tag }}</span>
              @endforeach
            </div>
          </div>
        </article>
      @endforeach
    </div>

    <div class="mt-10 flex flex-col items-center justify-center gap-4">
      <x-frontend.inline-consultation-form
        theme="light"
        placeholder="Enter your phone or email"
        button-text="Get Free Consultation"
        :secondary-href="$demoHref"
        secondary-label="Book a Call" />
    </div>
  </div>
</section>
<!-- 7. Offshore Services Section End -->



<!-- 9. Tech Stack Section Start -->
<section class="full-bleed bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20" style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}');" aria-labelledby="tech-stack-title">
  <div class="section-inner">
    <header class="mx-auto mb-8 max-w-[720px] text-center lg:mb-16">
      <p
        class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Our Technology
      </p>
      <h2 id="tech-stack-title" class="home-type-h2 mt-4 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:text-[18px] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">
        The Technology Behind Our Solutions
      </h2>
    </header>

    <div class="grid overflow-hidden border-l border-t border-[#ECECEC] grid-cols-1 sm:grid-cols-2 lg:grid-cols-5">
      @foreach ($techCards as $tech)
        <article class="technology-card group relative min-h-[210px] border-b border-r border-[#ECECEC] bg-white p-5"
          style="--technology-color: {{ $tech[3] }}">
          <span
            class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            style="background: radial-gradient(circle at 100% 100%, color-mix(in srgb, var(--technology-color) 12%, transparent), transparent 58%);"></span>
          <img src="{{ asset($tech[0]) }}" alt="{{ $tech[1] }} technology icon for Suave Creators software development" title="{{ $tech[1] }} technology icon for Suave Creators software development" class="relative h-10 w-10 object-contain" loading="lazy">
          <h3 class="relative mt-3 text-[14px] font-semibold leading-[18px] text-[#171717]">{{ $tech[1] }}</h3>
          <p class="relative mt-2 pr-5 text-[14px] leading-5 text-[#4D4D4D]">{{ $tech[2] }}</p>
          <a href="{{ route('services') }}"
            class="relative mt-3 inline-flex items-center gap-1.5 text-[13px] font-semibold leading-[18px] text-[#2A4DFB]">
            Get Started
            <svg xmlns="https://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 24 24" fill="none"
              stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 8L22 12L18 16" />
              <path d="M2 12H22" />
            </svg>
          </a>
        </article>
      @endforeach
    </div>
  </div>
</section>
<!-- 9. Tech Stack Section End -->

<x-frontend.industries-section
  :cards="$processCards"
  eyebrow="Our Process"
  title="Our process guides you step by step towards achieving success"
  description="We follow a clear, collaborative process that takes your idea from research to a fully functional, high-performing product."
  heading-id="services-process-title"
  class="py-6 lg:py-[80px]"
/>
<x-frontend.faq-section
  :qa="$faqs"
  heading-id="services-faq-heading"
  eyebrow="Have questions about our Web Services?"
  description="Here are the most asked questions about our offshore web, software and digital development services."
  class="faq-section--align bg-cover bg-top bg-no-repeat"
  style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}')"
/>

<x-frontend.consultation-section
  :background-image="$consultation['backgroundImage']"
  :eyebrow="$consultation['eyebrow']"
  :solo="$consultation['solo']"
  :show-people="$consultation['showPeople']"
  :title="$consultation['title']"
  :description="$consultation['description']"
  :cta-label="$consultation['ctaLabel']"
  card-position="center"
  :allow-html-title="false"
/>

<x-frontend.testimonials-section heading-id="services-testimonials-title" class="py-6 lg:py-24" />

<x-frontend.case-studies-carousel-section
  :items="\App\Support\Frontend\CaseStudySupport::servicesPageItems()"
  heading-id="services-case-studies-title"
  title="Case studies from our services"
  subtitle="Selected delivery stories that show how we design and ship software across our practice areas."
/>

<x-frontend.articles-insights-section
  :items="$articles"
  heading-id="services-insights-title"
  title="Explore Our Latest Insights"
  subtitle="Get in touch with industry trends with our updated blogs from technology and development experts."
  section-class="section-pad-m py-6 lg:py-18"
  more-href="{{ route('blogs') }}"
  more-label="View all blog articles"
/>




@endsection

@push('custom-css')
<style>
@media (max-width: 767px) {
  #services-hero-title {
    font-size: 26px;
    line-height: 28px;
  }

  section[aria-labelledby="services-hero-title"],
  section[aria-labelledby="expertise-title"],
  section[aria-labelledby="core-services-title"],
  section[aria-labelledby="offshore-services-title"],
  section[aria-labelledby="tech-stack-title"],
  section[aria-labelledby="services-process-title"] {
    padding-block: 24px !important;
  }

  #core-services-title,
  .web-services__intro h2,
  #services-process-title {
    font-size: 20px !important;
    line-height: 28px !important;
  }

  .digital-solution-section {
    padding: 24px 0;
  }

  .digital-solution-section__title-top,
  .digital-solution-section__title-agency {
    font-size: 20px;
    line-height: 28px;
    letter-spacing: -0.025em;
  }

  .digital-solution-section__copy {
    font-size: 14px;
    line-height: 20px;
  }

  .about-stat__value--title {
    font-size: 14px !important;
    letter-spacing: -0.025em;
    line-height: 18px !important;
  }

  .about-stat__description {
    font-size: 13px !important;
    line-height: 18px !important;
  }
}
</style>
@endpush

