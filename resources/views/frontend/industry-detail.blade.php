@extends('layouts.frontend')

@section('content')


<!-- Hero Section Start -->
<section class="relative z-10 w-full overflow-x-clip pb-10 pt-6 sm:pb-12 sm:pt-8 md:pb-16 md:pt-10 lg:min-h-[600px] lg:pb-20 lg:pt-[52px] site-container">
  <div class="grid grid-cols-1 items-center gap-8 sm:gap-10 lg:grid-cols-2 lg:gap-12">
    <div class="relative z-0 order-2 flex max-w-xl min-w-0 flex-col text-left lg:order-1 lg:max-w-[560px]">
      <p class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[11px] font-bold uppercase tracking-wide text-transparent sm:text-sm">{{ $industry['eyebrow'] ?? 'Industry Solutions' }}</p>
      <h1 class="mb-2 mt-1 flex flex-col text-[28px] font-semibold leading-[1.05] text-white min-[375px]:text-[34px] sm:mt-2 sm:text-5xl lg:text-[52px] lg:leading-none">
        @foreach (($industry['heroTitle'] ?? []) as $i => $line)
          @if ($i === 0)
            <span class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text font-extrabold text-transparent">{{ $line }}</span>
          @else
            <span>{{ $line }}</span>
          @endif
        @endforeach
      </h1>
      <p class="mb-2 mt-2 text-[13px] leading-6 text-[#B1B9DF] sm:text-sm">{{ $industry['heroDescription'] ?? '' }}</p>
      <div class="mt-6 flex flex-col items-start gap-3 sm:mt-8 sm:flex-row sm:items-center sm:gap-7">
        <a href="{{ route('contact-us') }}#contact-id" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] w-fit items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">
          Let's Connect to Discuss
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
        </a>
        <a href="{{ route('contact-us') }}#contact-id" class="inline-flex w-fit items-center border-b border-white/70 text-[13px] font-semibold text-white sm:text-sm">Book a Call</a>
      </div>
    </div>
    <div class="relative z-10 order-1 mx-auto flex w-full max-w-[360px] min-w-0 items-center justify-center sm:max-w-[420px] lg:order-2 lg:mx-0 lg:max-w-[480px] lg:justify-end">
      @if (!empty($industry['heroImage']))
        <img src="{{ $industry['heroImage'] }}" alt="{{ $industry['pageTitle'] ?? '' }}" title="{{ $industry['pageTitle'] ?? '' }}" width="560" height="560" class="block h-auto w-full rounded-[20px] object-cover shadow-[0_24px_60px_rgba(0,0,63,0.35)] sm:rounded-[28px]" loading="eager">
      @endif
    </div>
  </div>
</section>
<!-- Hero Section End -->

<!-- Intro + Stats Section Start -->
<section class="full-bleed bg-white bg-cover bg-top bg-no-repeat py-10 sm:py-14 lg:py-20" style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}')" aria-labelledby="industry-intro-heading">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-start gap-8 sm:gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:gap-14">
      <div class="min-w-0">
        <div class="mb-3 flex items-center gap-2 sm:mb-4">
          <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">{{ $industry['introEyebrow'] ?? 'Professional Solutions' }}</span>
        </div>
        <h2 id="industry-intro-heading" class="text-[22px] font-bold leading-tight text-[#171717] sm:text-[clamp(1.75rem,4vw,2.75rem)]">{{ $industry['introTitle'] ?? '' }}</h2>
        <p class="mt-3 max-w-[560px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px]">{{ $industry['introDescription'] ?? '' }}</p>
        <div class="mt-6 sm:mt-8">
          <a href="{{ route('services') }}" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">
            Explore Services
            <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
          </a>
        </div>
      </div>
      <div class="grid grid-cols-1 gap-3 min-[480px]:grid-cols-2 sm:gap-3.5">
        @foreach ($introStats as $stat)
          <article class="flex min-w-0 items-start gap-3 rounded-[16px] border border-[rgb(31_38_68_/_3%)] bg-white p-3.5 shadow-[0_16px_36px_rgb(35_38_91_/_10%)] sm:gap-3.5 sm:rounded-[20px] sm:p-4">
            <span class="inline-flex h-[44px] w-[44px] shrink-0 items-center justify-center sm:h-[52px] sm:w-[52px]">
              <img src="{{ asset($stat[3]) }}" alt="{{ $stat[1] }} stat icon for Suave Creators software development" title="{{ $stat[1] }} stat icon for Suave Creators software development" width="52" height="52" class="h-[44px] w-[44px] object-contain sm:h-[52px] sm:w-[52px]">
            </span>
            <div class="min-w-0">
              <strong class="block text-[24px] font-semibold leading-none tracking-tight sm:text-[28px]" style="color: {{ $stat[4] }};">{{ $stat[0] }}</strong>
              <h3 class="mt-1 text-[12px] font-semibold leading-snug sm:text-[13px] sm:leading-none" style="color: {{ $stat[4] }};">{{ $stat[1] }}</h3>
              <p class="mt-1 text-[12px] font-medium leading-4 text-[#171717] sm:text-[13px]">{{ $stat[2] }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
<!-- Intro + Stats Section End -->

<!-- Services Hub Section Start -->
<section class="full-bleed web-services industry-detail-services bg-cover bg-top bg-no-repeat py-10 sm:py-14 lg:py-20" style="background-image: url('{{ asset('assets/background/web-services-section-bg.png') }}')" aria-labelledby="industry-services-heading">
  <div class="web-services__inner section-inner">
    <header class="web-services__header">
      <div class="mb-3 flex items-center gap-2 sm:mb-4">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">{{ $industry['servicesEyebrow'] ?? 'Services' }}</span>
      </div>
      <div class="web-services__intro">
        <h2 id="industry-services-heading" class="mb-3 text-[20px] font-semibold leading-tight text-[#171717] sm:mb-4 sm:text-[22px] lg:text-[24px]">{{ $industry['servicesTitle'] ?? '' }}</h2>
        <p class="text-[13px] leading-[150%] text-[#4D4D4D] sm:text-[14px]">{{ $industry['servicesDescription'] ?? '' }}</p>
      </div>
    </header>
    <div class="web-services__grid">
      @foreach (($industry['services'] ?? []) as $index => $service)
        <article class="web-service-card">
          <span class="web-service-card__icon">
            <img src="{{ $service['icon'] ?? '' }}" alt="{{ $service['title'] ?? 'Industry service' }} icon for Suave Creators software development" title="{{ $service['title'] ?? 'Industry service' }} icon for Suave Creators software development" width="36" height="36">
          </span>
          <div class="web-service-card__category">
            <span class="text-[10px] font-semibold uppercase text-[#4D4D4D]">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . ' - Service' }}</span>
            <div class="flex items-start justify-between gap-2">
              <h3 class="mt-2 min-w-0 text-[14px] font-semibold leading-[130%] text-[#171717]">{{ $service['title'] ?? '' }}</h3>
              <svg xmlns="https://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-2 shrink-0" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
            </div>
          </div>
          <p class="mt-1 text-[13px] leading-relaxed text-[#4D4D4D] sm:text-[14px]">{{ $service['desc'] ?? '' }}</p>
          @if (!empty($service['img']))
            @php
              $serviceImageAlt = trim(($service['title'] ?? 'Custom software') . ' service by Suave Creators software development team');
            @endphp
            <figure class="mt-3 aspect-video overflow-hidden rounded-[12px] sm:rounded-[14px]"><img src="{{ $service['img'] }}" alt="{{ $serviceImageAlt }}" title="{{ $serviceImageAlt }}" width="640" height="360" class="h-full w-full object-cover" loading="lazy"></figure>
          @endif
        </article>
      @endforeach
    </div>
    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:mt-10 sm:flex-row sm:flex-wrap sm:gap-5">
      <a href="{{ route('contact-us') }}#contact-id" class="u-btn-cta group inline-flex h-[34px] min-h-[34px] w-fit items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm">Let's Connect to Discuss<svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
      <a href="{{ route('contact-us') }}#contact-id" class="inline-flex w-fit border-b border-[#00003F] text-[13px] font-semibold text-[#00003F] sm:text-sm">Let's Build Your Digital Future Together</a>
    </div>
  </div>
</section>
<!-- Services Hub Section End -->

<x-frontend.connect-cta-section
  :eyebrow="$industry['ctaEyebrow'] ?? 'Ready to Start Your Project?'"
  :title="$industry['ctaTitle'] ?? ''"
  :description="$industry['ctaDescription'] ?? ''"
  title-id="industry-cta-heading"
  primary-label="Let's Connect to Discuss"
  section-class="full-bleed smart-together-cta py-5 sm:py-6"
/>

<!-- Specialized Services Section Start -->
<section class="full-bleed overflow-hidden bg-[#F9FAFC] bg-cover bg-top bg-no-repeat py-10 sm:py-14 lg:py-20" style="background-image: url('{{ asset('assets/background/offerings-section-bg.png') }}')" aria-labelledby="industry-specialized-heading">
  <div class="section-inner">
    <div class="mx-auto mb-8 max-w-[720px] text-center sm:mb-10 lg:mb-14">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">{{ $industry['specializedEyebrow'] ?? 'Specialized Services' }}</p>
      <h2 id="industry-specialized-heading" class="mt-3 text-[20px] font-semibold leading-[1.3] text-[#171717] sm:mt-4 lg:text-[24px] lg:leading-[36px]">{{ $industry['specializedTitle'] ?? '' }}</h2>
      <p class="mx-auto mt-3 max-w-[605px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px] sm:leading-[24px]">{{ $industry['specializedDescription'] ?? '' }}</p>
    </div>
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 lg:gap-6">
      @foreach (($industry['specialized'] ?? []) as $item)
        <article class="flex min-h-full flex-col gap-3 rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white p-[22px] shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          @if (!empty($item['icon']))<span class="inline-flex h-[52px] w-[52px] items-center justify-center rounded-[14px] bg-[#EEF1FF]"><img src="{{ $item['icon'] }}" alt="{{ ($item['title'] ?? 'Specialized service').' icon for Suave Creators industry solutions' }}" title="{{ ($item['title'] ?? 'Specialized service').' icon for Suave Creators industry solutions' }}" width="26" height="26" class="h-[26px] w-[26px] object-contain" loading="lazy"></span>@endif
          <h3 class="text-base font-bold leading-tight text-[#171717]">{{ $item['title'] ?? '' }}</h3>
          <p class="flex-1 text-sm leading-relaxed text-[#4D4D4D]">{{ $item['desc'] ?? '' }}</p>
        </article>
      @endforeach
    </div>
    <div class="mt-10 flex justify-center"><a href="{{ route('services') }}" class="border-b border-[#00003F] text-sm font-semibold text-[#00003F]">Explore all Services</a></div>
  </div>
</section>
<!-- Specialized Services Section End -->

<!-- Marquee Section Start -->
<section class="full-bleed full-bleed--edge digital-services-marquee" aria-label="Industry focus areas">
  <div class="digital-services-marquee__track">
    @for ($g = 0; $g < 2; $g++)
      <div class="digital-services-marquee__group" {{ $g === 1 ? 'aria-hidden="true"' : '' }}>
        @foreach ($marqueeLabels as $i => $label)
          @php
$style = $i % 2 === 0 ? 'filled' : 'outlined';
@endphp
          <span class="digital-services-marquee__label digital-services-marquee__label--{{ $style }}">{{ $label }}</span>
          <span class="digital-services-marquee__separator digital-services-marquee__separator--{{ $style }}" aria-hidden="true"></span>
        @endforeach
      </div>
    @endfor
  </div>
</section>
<!-- Marquee Section End -->

<!-- Why Choose Section Start -->
<section class="full-bleed industry-why-section relative overflow-hidden bg-[#F8FAFC] py-10 sm:py-14 lg:py-20" aria-labelledby="industry-why-heading">
  <div class="industry-why-section__bg" aria-hidden="true"></div>
  <div class="section-inner relative z-10">
    <header class="mx-auto mb-8 max-w-[720px] text-center sm:mb-10 lg:mb-14">
      <div class="mb-4 flex items-center justify-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">{{ $industry['whyEyebrow'] ?? 'Why Us' }}</span>
      </div>
      <h2 id="industry-why-heading" class="text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]">{{ $industry['whyTitle'] ?? '' }}</h2>
      <p class="mx-auto mt-3 max-w-[560px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px]">{{ $industry['whyDescription'] ?? '' }}</p>
    </header>
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
      @foreach (($industry['whyCards'] ?? []) as $card)
        <article class="flex min-h-full flex-col gap-3 rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white p-[22px] shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          @if (!empty($card['icon']))<span class="inline-flex h-[52px] w-[52px] items-center justify-center rounded-[14px] bg-[#EEF1FF]"><img src="{{ $card['icon'] }}" alt="{{ $card['title'] ?? 'Why choose Suave Creators' }} icon" title="{{ $card['title'] ?? 'Why choose Suave Creators' }} icon" width="26" height="26" class="h-[26px] w-[26px] object-contain" loading="lazy"></span>@endif
          <h3 class="text-base font-bold leading-tight text-[#171717]">{{ $card['title'] ?? '' }}</h3>
          <p class="flex-1 text-sm leading-relaxed text-[#4D4D4D]">{{ $card['text'] ?? '' }}</p>
          <a href="{{ route('contact-us') }}#contact-id" class="mt-1 inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#2A4DFB] no-underline hover:underline">Get Started <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
        </article>
      @endforeach
    </div>
  </div>
</section>
<!-- Why Choose Section End -->

<!-- Agile Process Section Start -->
<section class="full-bleed bg-white py-10 sm:py-14 lg:py-20" aria-labelledby="agile-process-title" data-agile-process>
  <div class="section-inner">
    <header class="mx-auto mb-8 max-w-[720px] text-center sm:mb-10 lg:mb-12">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">Need it simpler and faster? We have a solution for you!</p>
      <h2 id="agile-process-title" class="mt-3 text-[clamp(1.75rem,4vw,2.75rem)] font-bold leading-tight text-[#171717] sm:mt-4">{{ $industry['agileTitle'] ?? 'Our Agile Development Process' }}</h2>
      <p class="mx-auto mt-3 max-w-[560px] text-[13px] leading-6 text-[#4D4D4D] sm:mt-4 sm:text-[14px]">{{ $industry['agileSubtitle'] ?? 'Let’s connect with our experienced developers for expert guidance and tailored solutions.' }}</p>
    </header>
    <div class="agile-process-tabs swiper mb-8 sm:mb-10" data-agile-tabs>
      <div class="swiper-wrapper agile-process-tabs__list" role="tablist" aria-label="Agile process phases">
        @foreach ($agileTabs as $ti => $tab)
          <div class="swiper-slide agile-process-tabs__slide">
            <button type="button"
              class="agile-process-tabs__tab shrink-0 cursor-pointer rounded-full border border-[rgba(42,77,251,0.16)] bg-white px-5 py-2.5 text-[13px] font-semibold text-[#4D4D4D] transition hover:border-[rgba(42,77,251,0.4)] hover:text-[#171717] aria-selected:border-transparent aria-selected:bg-gradient-to-r aria-selected:from-[#2A4DFB] aria-selected:to-[#7A5FF8] aria-selected:text-white aria-selected:shadow-[0_10px_24px_rgba(42,77,251,0.28)]"
              role="tab"
              aria-selected="{{ $ti === 0 ? 'true' : 'false' }}"
              data-agile-tab="{{ $tab }}">{{ $tab }}</button>
          </div>
        @endforeach
      </div>
      <div class="agile-process-tabs__pagination" aria-label="Process phases pagination"></div>
    </div>
    @foreach ($agileTabs as $ti => $tab)
      <div role="tabpanel" data-agile-panel="{{ $tab }}" {{ $ti === 0 ? '' : 'hidden' }}>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
          @foreach ($processData[$tab] as $item)
            <article class="flex min-h-full flex-col gap-3 rounded-[20px] border border-[rgba(42,77,251,0.08)] bg-white p-[22px] shadow-[0_18px_40px_rgba(36,36,84,0.06)] transition hover:-translate-y-1 hover:shadow-[0_22px_48px_rgba(36,36,84,0.1)]">
              <span class="inline-flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#EEF1FF]"><img src="{{ $item['icon'] ?? asset('assets/icons/agile-icon-1.svg') }}" alt="{{ ($item['title'] ?? 'Agile process').' icon for Suave Creators industry development' }}" title="{{ ($item['title'] ?? 'Agile process').' icon for Suave Creators industry development' }}" width="24" height="24" class="h-6 w-6 object-contain" loading="lazy"></span>
              <h3 class="text-[15px] font-bold text-[#171717]">{{ $item['title'] ?? '' }}</h3>
              <p class="text-[13px] leading-relaxed text-[#4D4D4D]">{{ $item['desc'] ?? '' }}</p>
            </article>
          @endforeach
        </div>
      </div>
    @endforeach
    <div class="mt-10 flex flex-nowrap items-center justify-center gap-3 sm:gap-5">
      <a href="{{ route('contact-us') }}#contact-id" class="u-btn-cta group inline-flex shrink-0 items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:px-5">Let's Connect to Discuss<svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
      <a href="{{ route('contact-us') }}#contact-id" class="inline-flex shrink-0 items-center border-b border-[#00003F] text-sm font-semibold text-[#00003F]">Book a Call</a>
    </div>
  </div>
</section>
<!-- Agile Process Section End -->

<!-- Industries Delivered Section Start -->
<x-frontend.core-values-section
  :eyebrow="$industry['processEyebrow'] ?? 'Our Process'"
  :title="$industry['processTitle'] ?? ''"
  :description="$industry['processDescription'] ?? ''"
  title-id="industry-process-heading"
  :grid-class="$industry['processGridClass'] ?? 'core-values__grid--3'"
  :items="$coreValuesItems"
/>
<!-- Industries Delivered Section End -->

<x-frontend.faq-section
  :qa="$industry['faqs'] ?? []"
  heading-id="industry-faq-heading"
  eyebrow="Have questions about our Industry Solutions?"
  description="Here are the most asked questions for this industry."
  class="faq-section--align !py-10 sm:!py-14 lg:!py-[76px]"
/>

<x-frontend.consultation-section
  :background-image="$industry['finalBg'] ?? 'assets/background/consultation-section-bg.png'"
  :eyebrow="$industry['finalEyebrow'] ?? 'Your Digital Future Together'"
  :title="$industry['finalTitle'] ?? 'Let\'s Build Your Next Digital Solution with us!'"
  :description="$industry['finalDescription'] ?? ''"
  cta-label="Get a Free Quote"
  secondary-cta-label="Contact us Today"
  :show-people="false"
  :hide-bg-below-desktop="($industry['hideFinalBgBelowDesktop'] ?? false) === true"
  :allow-html-title="false"
/>

<x-frontend.testimonials-section
  :items="$testimonialItems"
  eyebrow="Client Testimonials"
  title="What Our Clients Say"
  subtitle=""
  heading-id="industry-testimonials-title"
/>

<x-frontend.articles-insights-section
  :items="$articles"
  heading-id="industry-insights-title"
  title="Explore Our Insights"
  subtitle="Get in touch with industry trends with our updated blogs from technology and development experts."
  section-class="py-10 sm:py-14 lg:py-18"
  more-href="{{ route('blogs') }}"
  more-label="View all blog articles"
/>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof Swiper !== 'undefined' && document.querySelector('.industry-testimonial-swiper')) {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    new Swiper('.industry-testimonial-swiper', {
      direction: window.matchMedia('(min-width: 1024px)').matches ? 'vertical' : 'horizontal',
      slidesPerView: 1,
      spaceBetween: 16,
      loop: true,
      speed: 700,
      watchOverflow: true,
      autoplay: reduceMotion ? false : { delay: 4500, disableOnInteraction: false, pauseOnMouseEnter: true },
      navigation: { nextEl: '.testimonial-next', prevEl: '.testimonial-prev' },
      pagination: {
        el: '.testimonial-pagination',
        clickable: true
      },
      breakpoints: { 1024: { slidesPerView: 2, spaceBetween: 24 } }
    });
  }

  var agileRoot = document.querySelector('[data-agile-process]');
  if (agileRoot) {
    var tabs = agileRoot.querySelectorAll('[data-agile-tab]');
    var panels = agileRoot.querySelectorAll('[data-agile-panel]');
    var tabsEl = agileRoot.querySelector('[data-agile-tabs]');
    var tabsMq = window.matchMedia('(max-width: 767px)');
    var tabsSwiper = null;

    function syncAgileTabsSwiper() {
      if (!tabsEl || typeof Swiper === 'undefined') return;

      if (tabsMq.matches) {
        if (tabsSwiper) return;
        tabsSwiper = new Swiper(tabsEl, {
          slidesPerView: 'auto',
          spaceBetween: 10,
          freeMode: {
            enabled: true,
            sticky: false
          },
          grabCursor: true,
          allowTouchMove: true,
          simulateTouch: true,
          watchOverflow: true,
          touchStartPreventDefault: false,
          pagination: {
            el: tabsEl.querySelector('.agile-process-tabs__pagination'),
            clickable: true
          },
          a11y: {
            enabled: true,
            containerMessage: 'Agile process phases'
          }
        });
        return;
      }

      if (tabsSwiper) {
        tabsSwiper.destroy(true, true);
        tabsSwiper = null;
      }
    }

    tabs.forEach(function (tab, index) {
      tab.addEventListener('click', function () {
        var key = tab.getAttribute('data-agile-tab');
        tabs.forEach(function (t) {
          var on = t === tab;
          t.setAttribute('aria-selected', on ? 'true' : 'false');
        });
        panels.forEach(function (p) {
          var on = p.getAttribute('data-agile-panel') === key;
          if (on) p.removeAttribute('hidden'); else p.setAttribute('hidden', '');
        });
        if (tabsSwiper) {
          tabsSwiper.slideTo(index, 300);
        }
      });
    });

    syncAgileTabsSwiper();
    if (typeof tabsMq.addEventListener === 'function') {
      tabsMq.addEventListener('change', syncAgileTabsSwiper);
    } else if (typeof tabsMq.addListener === 'function') {
      tabsMq.addListener(syncAgileTabsSwiper);
    }
  }
});
</script>
@endpush
