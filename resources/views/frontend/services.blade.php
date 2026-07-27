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
  class="full-bleed relative flex items-center bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('assets/media/top-banner-visual.webp') }}')"
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
        <a href="{{ route('contact-us') }}#contact-id" class="{{ $btnPrimary }}">
          Let&rsquo;s Discuss About Vision
          {{ $ctaArrow }}
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
<section class="full-bleed bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('assets/background/digital-marketing-section-bg.png') }}')" aria-labelledby="expertise-title">
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

    @php
$expertiseItems = [
      ['assets/media/project-analysis.png', 'Project analysis', 'Research and strategy', '#4C24F4', '#F0EAFF'],
      ['assets/media/build-strategy-visual.png', 'Build strategy', 'Wireframe and design', '#1873E7', '#EAF5FC'],
      ['assets/media/launch-live-visual.png', 'Launch and live', 'Development and scale', '#0F968E', '#E8F8F6'],
      ['assets/media/maintenance-logo.png', 'Maintenance', 'Maintaining strong', '#FA6811', '#FFF0E7'],
    ];
@endphp
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
<section id="core-services" class="full-bleed web-services bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('assets/background/web-services-section-bg.png') }}')"
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

    @php
$servicesData = [
      ['assets/media/service-icon-1.svg', 'Web Development Services', 'Explore our top-notch web development services to get the best possible digital solution to enhance user interaction and scale seamlessly as your needs grow.', 'Explore Web Development', route('service.show', ['slug' => 'web-development-services']), 'blue'],
      ['assets/media/service-icon-2.svg', 'Enterprise Software Solutions', 'We offer the best and industry-specific Enterprise Software Solutions for organisations to manage their work more conveniently. Get a secure and scalable solution with us.', 'Explore Enterprise Solutions', route('service.show', ['slug' => 'enterprise-software-solutions']), 'orange'],
      ['assets/media/service-icon-3.svg', 'UI/UX Design Services', 'UI/UX Designs help you to stand out in the competition. We are experts in front-end design, optimising custom code to deliver the best UI/UX design services.', 'See UI/UX Services', route('services'), 'cyan'],
      ['assets/media/service-icon-4.svg', 'Custom CRM Development', 'Suave Creators develops custom-tailored CRM Solutions, implementing application development software features and functionalities that drive businesses forward.', 'Learn More About CRM', route('service.show', ['slug' => 'custom-crm-development']), 'mint'],
      ['assets/media/service-icon-5.svg', 'E-commerce Development', 'Choosing e-commerce development with us is the best option for you. Try our best development services and get a reliable solution for your digital business needs.', 'Explore E-commerce Services', route('service.show', ['slug' => 'e-commerce-development']), 'rose'],
      ['assets/media/service-icon-6.svg', 'AI Solutions', 'With this fast technology world, everyone needs an AI solution. We embed an AI solution with all of our software solutions. AI helps businesses to make it more secure, advanced, and productive.', 'Explore AI Services', route('services'), 'amber'],
    ];
@endphp

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
  eyebrow="Ready to Start Your Project?"
  title="Are you Ready to Start Your Project?"
  description="As the best development company, we help you to develop your next digital product. Get Innovative and advanced solutions with us and see the quick growth."
  title-id="services-cta-title"
/>

<!-- 7. Offshore Services Section Start -->
<section class="full-bleed bg-[#F9FAFC] bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('assets/background/offerings-section-bg.png') }}')"
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

    @php
$offshoreSlides = [
      [
        'assets/media/end-to-end-development-expertise.webp',
        'End-to-End Development Expertise',
        'With all of our projects, we always provide end-to-end development services. By leveraging our global young talent and systematic resource allocation, we provide the best and competitive pricing that helps you to get expert solutions and optimise your development budget.',
        ['SEO', 'Mobile', 'First Performance'],
      ],
      [
        'assets/media/SEO-Performance-Optimization.webp',
        'SEO-Optimisation and Performance',
        'SEO optimization and high performance are the needs of every website and application nowadays. All of our solutions perform better and follow Search engine algorithms so that they easily gain good visibility on Google soon.',
        ['UI/UX', 'Research', 'Prototyping'],
      ],
      [
        'assets/media/global-scalable-security.webp',
        'Global and Scalable Security',
        'Our solutions are built to grow with your business. Whether you&rsquo;re a startup expanding into new markets or an enterprise business managing high volumes, we design platforms that scale without performance issues.',
        ['SEO', 'Mobile', 'First Performance'],
      ],
    ];
@endphp
    <div class="grid grid-cols-1 gap-5 md:grid-cols-3 lg:gap-6">
      @foreach ($offshoreSlides as $slide)
        <article
          class="flex min-h-full flex-col gap-3 overflow-hidden rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          <figure class="aspect-[16/10] overflow-hidden">
            <img src="{{ $slide[0] }}" alt="{{ $slide[1] }}" title="{{ $slide[1] }}" class="h-full w-full object-cover" loading="lazy">
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
      <a href="{{ route('contact-us') }}#contact-id" class="{{ $btnPrimary }}">
        Request a Free Consultation
        {{ $ctaArrow }}
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

    @php
$techData = [
      ['assets/media/tech-icon-1.png', 'Shopify & WooCommerce', 'We suggest CRM according to the clients\' needs. We develop websites for Shopify and WooCommerce for your e-commerce websites.', '#7AB55C'],
      ['assets/media/tech-icon-2.png', 'React & Angular', 'We built websites on React & Angular to deliver high performance and a strong security system.', '#149ECA'],
      ['assets/media/tech-icon-3.png', 'Laravel & PHP', 'We specialize in building web applications using the PHP programming language and the Laravel framework.', '#FF2D20'],
      ['assets/media/tech-icon-4.png', 'Node.js', 'We use Node.js to build real-time apps, high-performance results, robust and mobile solutions, etc.', '#68A063'],
      ['assets/media/tech-icon-5.png', 'WordPress', 'A best and reliable easy-to-use CMS solution for all types of businesses with all SEO capabilities.', '#21759B'],
    ];
@endphp
    <div class="grid overflow-hidden border-l border-t border-[#ECECEC] grid-cols-1 sm:grid-cols-2 lg:grid-cols-5">
      @foreach ($techData as $tech)
        <article class="technology-card group relative min-h-[210px] border-b border-r border-[#ECECEC] bg-white p-5"
          style="--technology-color: {{ $tech[3] }}">
          <span
            class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            style="background: radial-gradient(circle at 100% 100%, color-mix(in srgb, var(--technology-color) 12%, transparent), transparent 58%);"></span>
          <img src="{{ $tech[0] }}" alt="{{ $tech[0]  }}" title="{{ $tech[0]  }}" class="relative h-10 w-10 object-contain" loading="lazy">
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

@php
$processCards = [
  ['icon' => 'fa-solid fa-magnifying-glass-chart', 'title' => 'Discovery Phase', 'text' => 'Before starting anything, we do deep research and define the fundamental features of your future product.'],
  ['icon' => 'fa-solid fa-route', 'title' => 'Strategy Development', 'text' => 'We craft a transparent roadmap for success. Our professional crew defines the project planning, sets deadlines, and chooses the right technologies to bring your vision to life.'],
  ['icon' => 'fa-solid fa-code', 'title' => 'Implementation', 'text' => 'Our expert designers collaborate to transform strategy into a fully functional, high-performing product and deliver you the best possible solution.'],
];
@endphp
<x-frontend.industries-section
  :cards="$processCards"
  eyebrow="Our Process"
  title="Our process guides you step by step towards achieving success"
  description="We follow a clear, collaborative process that takes your idea from research to a fully functional, high-performing product."
  heading-id="services-process-title"
/>
@php
$servicesFaqs = [
  ['question' => 'Do you work with international clients?', 'answer' => 'Yes, Suave Creators works with international clients, including the UK, USA, Canada, Australia, and all countries across the globe.'],
  ['question' => 'How do you ensure SEO-friendly development in your services?', 'answer' => 'We have the best team of seo experts who sit with the developer and do a complete audit step-by-step, and it will cover all technical and on-page aspects.'],
  ['question' => 'What industries do you serve?', 'answer' => 'We specialise in offering solutions for all types of industries, like healthcare, education, banking, e-commerce, and logistics. Each solution is tailored to the industry standards, compliance needs, and customer experience.'],
  ['question' => 'What is the typical project timeline?', 'answer' => 'It totally depends on the project complexity. Sometimes it will take 3 months or sometimes more than 6 months to 1 year.'],
  ['question' => 'Do you offer post-launch support and maintenance?', 'answer' => "Yes, of course, we always do post-launch support and maintenance as per the client's requirements."],
  ['question' => 'Why should we choose Suave Creators for our digital projects?', 'answer' => 'Suave Creators is a team of young talent who always work under timelines and deliver the best possible results.'],
];
@endphp
<x-frontend.faq-section
  :qa="$servicesFaqs"
  heading-id="services-faq-heading"
  eyebrow="Have questions about our Web Services?"
  description="Here are the most asked questions about our offshore web, software and digital development services."
  class="faq-section--align bg-cover bg-top bg-no-repeat"
  style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}')"
/>

<x-frontend.consultation-section
  background-image="assets/background/work-with-us-bg.webp"
  :solo="true"
  :show-people="false"
  title="Are you Ready to Start Your Project?"
  description="As the best development company, we help you to develop your next digital product. Get Innovative and advanced solutions with us and see the quick growth."
  cta-label="Let's Connect to Discuss"
  :allow-html-title="false"
/>

<x-frontend.testimonials-section heading-id="services-testimonials-title" />

<x-frontend.articles-insights-section
  :items="collect($latestPosts)->map(fn ($post) => [
    'title' => $post['title'] ?? '',
    'excerpt' => $post['short_description'] ?? '',
    'image' => $post['image'] ?? '',
    'alt' => $post['title'] ?? '',
    'date' => $post['published_label'] ?? '',
    'datetime' => $post['published_date'] ?? '',
    'author' => $post['author_name'] ?? 'Suave Creators',
    'url' => $post['url'] ?? route('blogs'),
  ])->all()"
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

