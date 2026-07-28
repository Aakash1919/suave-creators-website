@extends('layouts.frontend')

@section('content')

<!-- 1. About Banner Section Start -->
<section class="full-bleed bg-cover bg-center bg-no-repeat py-10 sm:py-14 lg:py-20"
  style="background-image: url('{{ asset('assets/background/about-banner-bg.png') }}');" aria-labelledby="about-banner-title">
  <div class="section-inner flex flex-col">
    <div class="order-2 mx-auto mt-6 max-w-[900px] text-center sm:order-1 sm:mt-0">
      <h1 id="about-banner-title"
        class="text-[28px] font-semibold leading-[1.15] tracking-[-0.03em] text-[#171717] min-[375px]:text-[32px] sm:text-[40px] md:text-[44px] lg:text-[48px]">
        Leading IT Company with
        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent font-extrabold">
          Web Design &amp; Development
        </span>
      </h1>

      <p class="mx-auto mt-4 max-w-[780px] text-[13px] leading-5 text-[#171717] sm:mt-5 sm:text-[14px] sm:leading-6 lg:text-[16px]">
        <span class="font-bold"> Suave Creators is a leading and smart IT company offering budget-friendly and robust
          digital solutions.</span><span class="font-semibold"> With our expertise, we help clients deliver exceptional
          technology solutions for world-class businesses in every business industry, from dynamic startups and SMBs to
          Fortune 500 companies.</span>
      </p>

      <a href="{{ route('contact-us') }}#contact-id"
        class="group mt-8 inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-[3px_7px_22px_-6px_#2A4DFB24] transition hover:brightness-110 whitespace-nowrap sm:mt-10 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">
        Let's Discuss
        <x-frontend.cta-arrow />
      </a>
    </div>

    <div class="order-1 mx-auto w-full overflow-hidden rounded-xl border-[6px] border-white sm:order-2 sm:mt-8 sm:rounded-2xl sm:border-[10px]">
      <img src="{{ asset('assets/media/about-banner-visual.png') }}"
        alt="Suave Creators IT company team portraits for web design and development"
        title="Suave Creators IT company team portraits for web design and development"
        class="block h-auto w-full rounded-lg object-cover sm:rounded-[12px]" loading="eager" decoding="async">
    </div>
  </div>
</section>
<!-- 1. About Banner Section End -->

<!-- 2. About / Stats Section Start -->
<section class="full-bleed bg-white py-10 sm:py-12 md:py-16 lg:py-20" aria-labelledby="about-stats-title">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-start gap-8 md:gap-10 lg:grid-cols-2 lg:gap-14 xl:gap-16">
      <div class="min-w-0">
        <div class="flex items-center gap-2">
          <span class="inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
            aria-hidden="true"></span>
          <p
            class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
            About Us
          </p>
        </div>

        <h2 id="about-stats-title"
          class="mt-4 max-w-[480px] text-[20px] font-bold leading-tight tracking-[-0.02em] text-[#171717] lg:text-[24px]">
          At Suave Creators, we craft powerful and innovative digital solutions.
        </h2>

        <p class="mt-4 max-w-[520px] text-[13px] leading-6 text-[#4D4D4D] lg:text-[14px]">
          From web development and UI/UX design to custom CRM and eCommerce
          platforms—engineered for scalability, performance, SEO success,
          and long-term business growth.
        </p>

        <div class="mt-6 flex flex-wrap items-center gap-4 sm:mt-8 sm:gap-5">
          <a href="{{ route('contact-us') }}#contact-id"
            class="inline-flex min-h-11 items-center underline text-sm font-semibold bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] bg-clip-text text-transparent transition hover:opacity-80">
            Need more services based on your demand?
          </a>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-3 min-[480px]:grid-cols-2 sm:gap-4 lg:max-w-[560px] lg:justify-self-end"
        data-about-counters>
        @foreach ($stats as $stat)
          <article
            class="flex min-h-[128px] flex-col justify-between rounded-[16px] border-2 border-white bg-[#F8FAFB] p-4 shadow-[0_10px_28px_rgba(35,38,91,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_36px_rgba(35,38,91,0.10)] sm:min-h-[156px] sm:p-5 md:p-6">
            <div class="min-w-0">
              <p class="m-0 text-[28px] font-semibold font-mori italic leading-none tracking-[-0.04em] text-[#00003F] sm:text-[32px] lg:text-[36px]">
                <span data-counter-end="{{ (int) $stat['end'] }}">0</span>{{ $stat['suffix'] }}
              </p>
              <h3 class="mt-2 text-[13px] font-semibold leading-snug text-[#2A4DFB] sm:text-[14px]">
                {{ $stat['label'] }}
              </h3>
            </div>
            <p class="mt-3 text-[13px] leading-5 text-[#4D4D4D] sm:mt-4 sm:text-[14px]">
              {{ $stat['description'] }}
            </p>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
<!-- 2. About / Stats Section End -->

<!-- 3. Why Suave Creators Section Start -->
<section class="full-bleed bg-white py-10 sm:py-14 md:py-16 lg:py-20" aria-labelledby="about-why-title">
  <div class="section-inner">
    <header class="mb-8 grid grid-cols-1 items-start gap-4 sm:mb-10 lg:mb-14 lg:grid-cols-[190px_minmax(0,1fr)] lg:gap-8">
      <div class="flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
          aria-hidden="true"></span>
        <p
          class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
          Suave Creators
        </p>
      </div>
      <div class="min-w-0">
        <h2 id="about-why-title" class="text-[20px] font-bold leading-tight text-[#171717] lg:text-[24px]">
          Why Suave Creators
        </h2>
        <p class="mt-3 max-w-[720px] text-[13px] leading-6 text-[#4D4D4D] lg:text-[14px]">
          We are one of the reputed website development companies where we focus on giving cent percent to the
          client&rsquo;s requirement.
        </p>
      </div>
    </header>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:gap-7 lg:grid-cols-3 lg:gap-8">
      @foreach ($shoreSlides as $slide)
        <article class="flex min-w-0 flex-col">
          <figure class="overflow-hidden rounded-[14px]">
            <img src="{{ asset($slide['image']) }}" alt="{{ $slide['alt'] }}" title="{{ $slide['alt'] }}"
              class="aspect-[4/3] h-auto w-full object-cover" width="640" height="480" loading="lazy" decoding="async">
          </figure>
          <div class="mt-4 flex flex-wrap gap-2">
            @foreach ($slide['tags'] as $tag)
              <span
                class="inline-flex items-center rounded-full bg-[#EEF1FF] px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-[#2A4DFB] sm:text-[12px]">
                {{ $tag }}
              </span>
            @endforeach
          </div>
          <h3 class="mt-4 text-[18px] font-semibold leading-snug text-[#171717] lg:text-[20px]">
            {{ $slide['title'] }}
          </h3>
          <p class="mt-3 text-[13px] leading-6 text-[#4D4D4D] lg:text-[14px]">
            {{ $slide['text'] }}
          </p>
        </article>
      @endforeach
    </div>
  </div>
</section>
<!-- 3. Why Suave Creators Section End -->

<!-- 4. Smart Modules Section Start -->
<section class="full-bleed about-modules-section py-12 md:py-14 lg:py-16" aria-labelledby="about-modules-title">
  <div class="section-inner">
    <header class="mx-auto mb-8 max-w-[720px] text-center md:mb-10">
      <h2 id="about-modules-title" class="text-[14px] font-semibold leading-snug text-[#5B6CFF]">
        &ldquo;17+ Smart Modules. One Unified Workspace.&rdquo;
      </h2>
      <span class="mx-auto mt-1 block h-[2px] w-[28px] rounded-full bg-[#5B6CFF]" aria-hidden="true"></span>
    </header>

    <div class="grid grid-cols-2 gap-3 min-[480px]:grid-cols-3 sm:gap-4 lg:grid-cols-6 lg:gap-5">
      @foreach ($smartModules as $module)
        <article class="about-module-card">
          <span class="about-module-card__icon" aria-hidden="true">
            <i class="{{ $module['icon'] }}"></i>
          </span>
          <span class="about-module-card__label">{{ $module['label'] }}</span>
        </article>
      @endforeach
    </div>
  </div>
</section>
<!-- 4. Smart Modules Section End -->

<!-- 5. Core Values Section Start -->
<section class="full-bleed bg-cover bg-top bg-no-repeat py-12 sm:py-16 lg:py-24"
  style="background-image: url('{{ asset('assets/background/core-section-bg.png') }}');"
  aria-labelledby="core-values-title">
  <div class="section-inner">
    <header class="mb-8 grid grid-cols-1 items-start gap-4 sm:mb-10 lg:mb-14 lg:grid-cols-[190px_minmax(0,1fr)] lg:gap-8">
      <div class="flex items-center gap-2">
        <span class="mt-0.5 inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
          aria-hidden="true"></span>
        <p
          class="text-[14px] font-bold leading-[100%] bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent">
          Values</p>
      </div>
      <div class="min-w-0">
        <h2 id="core-values-title" class="text-[20px] font-bold leading-tight text-[#171717] lg:text-[24px]">Our Core
          Values</h2>
        <p class="mt-4 max-w-[760px] text-[13px] leading-5 text-[#4D4D4D] sm:leading-6 lg:text-[14px] lg:leading-6">
          Driven by innovation, integrity, and excellence, we focus on delivering meaningful digital solutions that
          empower businesses, inspire creativity, and build lasting partnerships.
        </p>
      </div>
    </header>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 md:gap-0">
      @foreach ($coreValues as $index => $value)
        <article
          class="about-value-card about-value-card--{{ $index + 1 }} group relative overflow-hidden rounded-2xl border border-[#ECECEC] bg-white px-5 py-7 sm:px-7 sm:py-9 md:rounded-none {{ $index === 0 ? 'md:rounded-l-2xl' : '' }} {{ $index === 2 ? 'md:rounded-r-2xl' : '' }} {{ $index < 2 ? 'md:border-r' : '' }}"
          style="--about-value-accent: {{ $index === 0 ? '#FF0047' : ($index === 1 ? '#289AF6' : '#00EA9D') }}">
          <span
            class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            style="background: radial-gradient(circle at 100% 100%, color-mix(in srgb, var(--about-value-accent) 12%, transparent), transparent 58%);"
            aria-hidden="true"></span>
          <span class="about-value-card__icon relative inline-flex">
            <img src="{{ asset($value['icon']) }}" alt="{{ $value['alt'] }}" title="{{ $value['alt'] }}" width="48"
              height="48" loading="lazy" decoding="async">
          </span>
          <h3 class="about-value-card__title relative">{{ $value['title'] }}</h3>
          <p class="about-value-card__text relative">{{ $value['text'] }}</p>
        </article>
      @endforeach
    </div>
  </div>
</section>
<!-- 5. Core Values Section End -->

<!-- 6. Work With Us CTA Section Start -->
<section class="full-bleed overflow-hidden bg-white py-10 sm:py-14 lg:py-20" aria-labelledby="about-work-title">
  <div class="section-inner rounded-2xl bg-cover bg-center bg-no-repeat p-5 sm:p-8 lg:p-12"
    style="background-image: url('{{ asset('assets/background/core-values-section-bg.png') }}');">
    <div class="grid items-center gap-6 sm:gap-8 lg:grid-cols-2 lg:gap-12">
      <div class="order-2 w-full lg:order-1">
        <img src="{{ asset('assets/media/right-transform-visual.png') }}"
          alt="Business transformation with Suave Creators custom software solutions"
          title="Business transformation with Suave Creators custom software solutions"
          class="ml-auto h-auto w-full max-w-[520px] object-cover lg:max-w-none" loading="lazy" decoding="async">
      </div>
      <div class="order-1 max-w-[640px] text-left lg:order-2">
        <h2 id="about-work-title" class="text-[20px] font-semibold leading-tight text-white lg:text-[24px]">
          Ready to transform your business?
        </h2>
        <p class="mt-4 text-[13px] font-normal leading-6 text-[#B1B9DF] sm:text-[14px]">
          Let’s transform your idea into a high-performing digital solution. Our team is ready to collaborate, innovate, and deliver results that matter.
        </p>
        <x-frontend.cta-button variant="compact" class="mt-6 sm:mt-8">
          Let&rsquo;s Connect to Discuss
        </x-frontend.cta-button>
      </div>
    </div>
  </div>
</section>
<!-- 6. Work With Us CTA Section End -->

<!-- 7. Technologies Marquee Section Start -->
<x-frontend.tech-partnerships-section
  :items="$techStack"
  section-class="full-bleed full-bleed--edge bg-[white] pt-6 pb-10 lg:pt-10 lg:pb-14"
/>
<!-- 7. Technologies Marquee Section End -->

<!-- 8. Why Choose Us Section Start -->
<section class="full-bleed bg-[#050A24] bg-cover bg-center bg-no-repeat py-10 sm:py-14 md:py-16 lg:py-20"
  style="background-image: url('{{ asset('assets/background/core-values-section-bg.png') }}');"
  aria-labelledby="digital-growth-title">
  <div class="section-inner">
    <header class="mb-8 grid grid-cols-1 items-start gap-4 sm:mb-10 lg:mb-12 lg:grid-cols-[190px_minmax(0,1fr)] lg:gap-8">
      <div class="flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] shrink-0 rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
          aria-hidden="true"></span>
        <p
          class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
          Why Choose Us
        </p>
      </div>
      <div class="min-w-0">
        <h2 id="digital-growth-title" class="text-[20px] font-bold leading-tight text-white lg:text-[24px]">
          Expertise for your <span class="font-extrabold">digital growth journey</span>
        </h2>
        <p class="mt-3 max-w-[760px] text-[13px] leading-6 text-[#B1B9DF] lg:text-[14px]">
          By empowering your digital growth journey with expert solutions in custom web development, UX/UI design,
          AI solutions, and brand identity. We pursue innovative, scalable, and user-centric experiences to promote
          your brand, engage your audience, and drive success in the digital landscape.
        </p>
      </div>
    </header>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 md:gap-6 lg:grid-cols-3 lg:gap-7">
      @foreach ($growthFeatures as $feature)
        <article
          class="overflow-hidden rounded-[16px] border border-white/10 bg-[#0B1235]/80 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-[2px]">
          <figure class="overflow-hidden">
            <img src="{{ asset($feature['image']) }}" alt="{{ $feature['alt'] }}" title="{{ $feature['alt'] }}"
              class="aspect-[16/10] h-auto w-full object-cover" width="640" height="400" loading="lazy" decoding="async">
          </figure>
          <div class="p-5 sm:p-6">
            <h3 class="text-[18px] font-semibold leading-snug text-white lg:text-[20px]">{{ $feature['title'] }}</h3>
            <p class="mt-3 text-[13px] leading-6 text-[#B1B9DF] lg:text-[14px]">{{ $feature['text'] }}</p>
          </div>
        </article>
      @endforeach
    </div>

    <div class="mt-10 flex flex-wrap items-center justify-start gap-2 sm:justify-end sm:gap-3">
      <span class="text-[13px] font-medium text-white/90 lg:text-[14px]">Let&rsquo;s Connect to Discuss</span>
      <a href="{{ route('contact-us') }}#contact-id"
        class="text-[13px] font-semibold text-[#8B95FF] underline underline-offset-4 transition hover:text-white lg:text-[14px]">
        Book a Call
      </a>
    </div>
  </div>
</section>
<!-- 8. Why Choose Us Section End -->

<x-frontend.articles-insights-section
  :items="$articles"
  heading-id="about-insights-title"
  more-href="{{ route('blogs') }}"
  more-label="View all blog articles"
  section-class="py-10 sm:py-12 lg:py-18"
/>

<x-frontend.consultation-section />

<!-- 11. Partnerships Section Start -->
<x-frontend.partnerships-section :items="$partnerMarqueeItems" />
<!-- 11. Partnerships Section End -->
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var root = document.querySelector('[data-about-counters]');
    if (!root) return;

    var counters = root.querySelectorAll('[data-counter-end]');
    var started = false;

    function animateCounters() {
      if (started) return;
      started = true;

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
      var observer = new IntersectionObserver(function (entries) {
        if (entries.some(function (entry) { return entry.isIntersecting; })) {
          animateCounters();
          observer.disconnect();
        }
      }, { threshold: 0.35 });
      observer.observe(root);
    } else {
      animateCounters();
    }
  });
</script>
@endpush
