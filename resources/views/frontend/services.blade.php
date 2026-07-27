@extends('layouts.frontend')

@section('seo')
  <x-layouts.seo
    title="Web, Software & Digital Development Services | Suave Creators"
    description="Explore Suave Creators offshore web development, enterprise software, UI/UX design, custom CRM, e-commerce, and AI solutions built for global businesses."
    og-title="Web, Software & Digital Development Services | Suave Creators"
    og-description="Explore Suave Creators offshore web development, enterprise software, UI/UX design, custom CRM, e-commerce, and AI solutions built for global businesses."
    :canonical="url()->current()"
    :og-url="url()->current()"
  />
@endsection

@section('content')


<!-- 1. Hero Section (MainService) Start -->
<section
  class="full-bleed relative flex items-center bg-cover bg-center bg-no-repeat py-10 md:py-12 lg:py-16" style="background-image: url('{{ asset('assets/media/top-banner-visual.webp') }}')"
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
        <x-frontend.cta-button>
          Let&rsquo;s Discuss About Vision
        </x-frontend.cta-button>
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
<section class="full-bleed bg-cover bg-top bg-no-repeat py-16 lg:py-20" style="background-image: url('{{ asset('assets/background/digital-marketing-section-bg.png') }}')" aria-labelledby="expertise-title">
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

    <div class="about-stats">
      @foreach ($expertiseItems as $item)
        <article class="about-stat"
          style="--stat-accent: {{ $item[3] }}; --stat-tint: {{ $item[4] }};">
          <span class="about-stat__icon">
            <img src="{{ asset($item[0]) }}" alt="{{ $item[1] }}" title="{{ $item[1] }}" class="about-stat__icon-image" loading="lazy">
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
<section id="core-services" class="full-bleed web-services bg-cover bg-top bg-no-repeat py-16 lg:py-20" style="background-image: url('{{ asset('assets/background/web-services-section-bg.png') }}')"
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

    <div class="web-services__grid">
      @foreach ($servicesData as $service)
        <a href="{{ $service[4] }}" class="web-service-card block">
          <span class="web-service-card__icon web-service-card__icon--lg web-service-card__icon--{{ $service[5] }}">
            <img src="{{ asset($service[0]) }}" alt="{{ $service[1] }}" title="{{ $service[1] }}" width="28" height="28">
          </span>

          <div class="web-service-card__category">
            <h3 class="text-[14px] font-semibold leading-[130%] text-[#171717]">
              {{ $service[1] }}
            </h3>
          </div>

          <p class="mt-1 text-[14px] leading-[20px] text-[#4D4D4D]">{{ $service[2] }}</p>

          <span class="mt-3 inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#2A4DFB]">
            {{ $service[3] }}
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 24 24" fill="none"
              stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 8L22 12L18 16" />
              <path d="M2 12H22" />
            </svg>
          </span>
        </a>
      @endforeach
    </div>

    <div class="web-services__footer">
      <a href="{{ route('contact-us') }}#contact-id">Discuss your Requirements</a>
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
<section class="full-bleed bg-[#F9FAFC] bg-cover bg-top bg-no-repeat py-16 lg:py-20" style="background-image: url('{{ asset('assets/background/offerings-section-bg.png') }}')"
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

    <div class="grid grid-cols-1 gap-5 md:grid-cols-3 lg:gap-6">
      @foreach ($offshoreSlides as $slide)
        <article
          class="flex min-h-full flex-col gap-3 overflow-hidden rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          <figure class="aspect-[16/10] overflow-hidden">
            <img src="{{ asset($slide[0]) }}" alt="{{ $slide[1] }}" title="{{ $slide[1] }}" class="h-full w-full object-cover" loading="lazy">
          </figure>
          <div class="flex flex-1 flex-col gap-3 p-[22px]">
            <h3 class="text-base font-bold leading-tight text-[#171717]">{{ $slide[1] }}</h3>
            <p class="flex-1 text-sm leading-relaxed text-[#4D4D4D]">{{ $slide[2] }}</p>
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

    <div class="mt-10 flex justify-center">
      <x-frontend.cta-button>
        Request a Free Consultation
      </x-frontend.cta-button>
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

    <div class="grid overflow-hidden border-l border-t border-[#ECECEC] grid-cols-1 sm:grid-cols-2 lg:grid-cols-5">
      @foreach ($techCards as $tech)
        <article class="technology-card group relative min-h-[210px] border-b border-r border-[#ECECEC] bg-white p-5"
          style="--technology-color: {{ $tech[3] }}">
          <span
            class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            style="background: radial-gradient(circle at 100% 100%, color-mix(in srgb, var(--technology-color) 12%, transparent), transparent 58%);"></span>
          <img src="{{ asset($tech[0]) }}" alt="{{ $tech[1] }} technology icon for Suave Creators software development" title="{{ $tech[1] }} technology icon for Suave Creators software development" class="relative h-10 w-10 object-contain" loading="lazy">
          <h3 class="relative mt-3 text-base font-bold text-[#171717]">{{ $tech[1] }}</h3>
          <p class="relative mt-2 pr-5 text-sm leading-[22px] text-[#4D4D4D]">{{ $tech[2] }}</p>
          <a href="{{ route('services') }}"
            class="relative mt-3 inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#2A4DFB]">
            Get Started
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 24 24" fill="none"
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

<x-frontend.testimonials-section heading-id="services-testimonials-title" />

<x-frontend.articles-insights-section
  :items="$articles"
  heading-id="services-insights-title"
  title="Explore Our Latest Insights"
  subtitle="Get in touch with industry trends with our updated blogs from technology and development experts."
  section-class="py-16 lg:py-18"
  more-href="blogs"
  more-label="View More"
/>




@endsection
@push('custom-css')
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
@endpush

