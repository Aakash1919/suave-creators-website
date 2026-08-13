@extends('layouts.frontend')

@section('content')


<!-- 1. Hero / Service Banner Section Start -->
<section
  class="full-bleed service-banner relative z-10 bg-cover bg-center bg-no-repeat pt-24 pb-16 md:pt-28 md:pb-20 lg:pt-[100px]"
  style="background-image: url('{{ $bannerBg }}');"
  aria-labelledby="service-banner-heading">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-12">
      <div class="relative z-0 flex max-w-xl min-w-0 flex-col text-left lg:max-w-[560px]">
        <p class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-sm font-bold uppercase tracking-wide text-transparent">{{ $service['eyebrow'] ?? 'Our Services' }}</p>
        <h1 id="service-banner-heading" class="mb-2 mt-2 flex flex-col text-[34px] font-semibold leading-tight text-white min-[375px]:text-[40px] sm:text-5xl sm:leading-none lg:text-[52px]">
          @foreach (($service['heroTitle'] ?? []) as $i => $line)
            @if ($i === 0)
              <span class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text font-extrabold text-transparent">{{ $line }}</span>
            @else
              <span>{{ $line }}</span>
            @endif
          @endforeach
        </h1>
        <p class="mb-2 mt-2 text-sm leading-6 text-white">{{ $service['heroDescription'] ?? '' }}</p>
        <div class="mt-8 mb-6 flex flex-wrap items-center gap-x-4 gap-y-3 sm:mb-0 sm:gap-7">
          <x-frontend.cta-button class="shrink-0 whitespace-nowrap px-4 py-2 text-[13px] sm:px-5 sm:text-sm">
            {{ $service['primaryCta'] ?? "Let's Connect to Discuss" }}
          </x-frontend.cta-button>
          <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer" class="inline-flex shrink-0 items-center border-b border-white/70 pb-px text-[13px] font-semibold whitespace-nowrap text-white sm:text-sm">{{ $service['secondaryCta'] ?? 'Book a Call' }}</a>
        </div>
      </div>
      <div class="relative z-10 hidden w-full min-w-0 items-center justify-center lg:flex lg:justify-end">
        <div class="relative mx-auto flex aspect-square w-full max-w-[420px] items-center justify-center">
          @if (!empty($service['heroImage1']))
            <img src="{{ $service['heroImage1'] }}" alt="Decorative orbit graphic for Suave Creators service banner" title="Decorative orbit graphic for Suave Creators service banner" width="480" height="480" class="service-banner__orbit absolute inset-0 z-[1] h-full w-full object-contain" loading="eager" aria-hidden="true">
          @endif
          @if (!empty($service['heroImage2']))
            <img src="{{ $service['heroImage2'] }}" alt="{{ $service['pageTitle'] ?? '' }}" title="{{ $service['pageTitle'] ?? '' }}" width="160" height="160" class="relative z-[2] w-[32%] max-w-[140px] object-contain drop-shadow-xl" loading="eager">
          @endif
        </div>
      </div>
    </div>

    @if (!empty($service['bannerLogos']))
      <div class="service-banner-logos serviceBannerLogosSwiper swiper mt-10 md:mt-12" aria-label="Technologies">
        <div class="swiper-wrapper">
          @foreach ($service['bannerLogos'] as $logo)
            <div class="swiper-slide">
              <div class="service-banner-logo">
                <img src="{{ $logo['src'] ?? $logo }}" alt="{{ $logo['alt'] ?? '' }}" title="{{ $logo['alt'] ?? '' }}" class="service-banner-logo__img" loading="lazy">
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>
<!-- 1. Hero / Service Banner Section End -->

<!-- 2. Intro + Stats (ProjectProcess) Section Start -->
<section class="full-bleed bg-white bg-[url('{{ $introBg }}')] bg-cover bg-top bg-no-repeat py-16 lg:py-20" aria-labelledby="service-intro-heading">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:gap-14">
      <div>
        <div class="mb-4 flex items-center gap-2">
          <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $service['introEyebrow'] ?? 'Our Services' }}</span>
        </div>
        <h2 id="service-intro-heading" class="text-[clamp(1.75rem,4vw,2.75rem)] font-bold leading-tight text-[#171717]">{{ $service['introTitle'] ?? '' }}</h2>
        <p class="mt-4 max-w-[560px] text-[14px] leading-6 text-[#4D4D4D]">{{ $service['introDescription'] ?? '' }}</p>
        <div class="mt-8">
          <x-frontend.cta-button :href="$service['introLinkUrl'] ?? route('services')">
            {{ $service['introLinkText'] ?? 'Explore Services' }}
          </x-frontend.cta-button>
          @if (($service['slug'] ?? '') === 'custom-crm-development')
            <p class="mt-4">
              <a href="{{ route('product') }}" class="inline-flex items-end border-b border-[#2A4DFB]/70 pb-0.5 text-sm font-semibold text-[#2A4DFB]">
                Explore our live Suave Outreach CRM
              </a>
            </p>
          @endif
        </div>
      </div>
      <div class="grid grid-cols-1 gap-3.5 min-[480px]:grid-cols-2">
        @foreach ($introStats as $stat)
          <article class="flex min-w-0 items-start gap-3.5 rounded-[20px] border border-[rgb(31_38_68_/_3%)] bg-white p-4 shadow-[0_16px_36px_rgb(35_38_91_/_10%)]">
            <img src="{{ asset($stat[3]) }}" alt="{{ $stat[1] }} stat icon for Suave Creators software development" title="{{ $stat[1] }} stat icon for Suave Creators software development" width="26" height="26" class="h-[26px] w-[26px] shrink-0 object-contain" loading="lazy">
            <div class="min-w-0">
              <strong class="block text-[28px] font-semibold leading-none tracking-tight" style="color: {{ $stat[4] }};">{{ $stat[0] }}</strong>
              <h3 class="mt-1 text-[13px] font-semibold leading-none" style="color: {{ $stat[4] }};">{{ $stat[1] }}</h3>
              <p class="mt-1 text-[13px] font-medium leading-4 text-[#171717]">{{ $stat[2] }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
<!-- 2. Intro + Stats Section End -->

@if ($isWebDevelopmentService)
<x-frontend.connect-cta-section title-id="service-collab-title" />
@endif

<!-- 4. Service Body (ServiceSection) Start -->
<section
  class="full-bleed{{ $useBodyImageLayout ? ' full-bleed--edge service-body service-body--webdev' : (($service['bodyBg'] ?? '') !== '' ? ' bg-cover bg-center bg-no-repeat py-16 lg:py-20' : ' bg-white py-16 lg:py-20') }}"
  @if ($bodySectionStyle !== '')style="{{ $bodySectionStyle }}"@endif
  aria-labelledby="service-body-heading">
  <div class="{{ $useBodyImageLayout ? 'service-body__inner' : 'section-inner' }}">
    <div class="{{ $useBodyImageLayout ? 'service-body__content' : 'mx-auto max-w-[1100px] text-center' }}">
      @if ($useBodyImageLayout)
      <div class="mb-4 flex items-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $service['bodyEyebrow'] ?? 'Suave Creators' }}</span>
      </div>
      @else
      <p class="offerings-eyebrow mb-4 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $service['bodyEyebrow'] ?? 'Suave Creators' }}</p>
      @endif
      <h2 id="service-body-heading" class="text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]">{{ $service['bodyTitle'] ?? '' }}</h2>
      @foreach (($service['bodyParagraphs'] ?? []) as $para)
        <p class="mt-4 text-[14px] leading-6 text-[#4D4D4D]">{{ $para }}</p>
      @endforeach
      <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:gap-5{{ $useBodyImageLayout ? ' items-start sm:items-center' : ' items-center justify-center' }}">
        <x-frontend.cta-button>
          Let's Connect to Discuss
        </x-frontend.cta-button>
        <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer" class="inline-flex max-lg:min-h-[44px] items-end pb-0.5 border-b border-[#00003F] text-sm font-semibold leading-tight text-[#00003F]">Let's Build Your Digital Future Together</a>
      </div>
    </div>
  </div>
</section>
<!-- 4. Service Body Section End -->

<!-- 5. Service Move Marquee Section Start -->
@if (!$isWebDevelopmentService)
<section class="full-bleed full-bleed--edge digital-services-marquee digital-services-marquee--white" aria-label="Service capabilities">
  <div class="digital-services-marquee__track">
    @for ($g = 0; $g < 2; $g++)
      <div class="digital-services-marquee__group" {{ $g === 1 ? 'aria-hidden="true"' : '' }}>
        @foreach ($marqueeIcons as $icon)
          <span class="digital-services-marquee__icon"><img src="{{ $icon }}" alt="Service capability icon for Suave Creators software development" title="Service capability icon for Suave Creators software development" loading="lazy" width="40" height="40"></span>
        @endforeach
      </div>
    @endfor
  </div>
</section>
@endif
<!-- 5. Service Move Marquee Section End -->

<!-- 6. Capabilities Section Start -->
<section class="full-bleed web-services{{ $capabilitiesAsSlider ? ' web-services--capabilities-slider' : '' }} bg-cover bg-top bg-no-repeat py-16 lg:py-20" style="background-image: url('{{ asset('assets/background/web-services-section-bg.png') }}')" aria-labelledby="service-capabilities-heading">
  <div class="web-services__inner section-inner">
    <header class="web-services__header">
      <div class="mb-4 flex items-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $service['capabilitiesEyebrow'] ?? "Let's Build Together" }}</span>
      </div>
      <div class="web-services__intro">
        <h2 id="service-capabilities-heading" class="mb-4 text-[24px] font-semibold text-[#171717]">{{ $service['capabilitiesTitle'] ?? 'Our Expertise' }}</h2>
        <p class="text-[14px] leading-[150%] text-[#4D4D4D]">{{ $service['capabilitiesDescription'] ?? '' }}</p>
      </div>
    </header>
    @if ($capabilitiesAsSlider)
      <div class="service-capabilities-slider">
        <div class="swiper serviceCapabilitiesSwiper" aria-label="Technologies carousel">
          <div class="swiper-wrapper">
            @foreach (($service['capabilities'] ?? []) as $index => $cap)
              <div class="swiper-slide h-auto">
                <article class="web-service-card">
                  <img class="web-service-card__icon-img" src="{{ $cap['image'] ?? '' }}" alt="{{ ($cap['title'] ?? 'Service').' capability icon for Suave Creators software development' }}" title="{{ ($cap['title'] ?? 'Service').' capability icon for Suave Creators software development' }}" width="80" height="64">
                  <div class="web-service-card__category">
                    <span class="text-[10px] font-semibold uppercase text-[#4D4D4D]">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . ' - Capability' }}</span>
                    <h3 class="mt-2 text-[14px] font-semibold leading-[130%] text-[#171717]">{{ $cap['title'] ?? '' }}</h3>
                  </div>
                  @if (!empty($cap['tags']))
                    <div class="mt-2 flex flex-wrap gap-1.5">
                      @foreach ($cap['tags'] as $tag)
                        <span class="rounded-full bg-[#EEF1FF] px-2.5 py-0.5 text-[10px] font-semibold text-[#2A4DFB]">{{ $tag }}</span>
                      @endforeach
                    </div>
                  @endif
                  <p class="mt-2 text-[14px] text-[#4D4D4D]">{{ $cap['desc'] ?? '' }}</p>
                </article>
              </div>
            @endforeach
          </div>
        </div>
        <div class="service-capabilities-slider__controls">
          <button class="service-capabilities-prev offerings-control" type="button" aria-label="Previous technology">
            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
          </button>
          <button class="service-capabilities-next offerings-control" type="button" aria-label="Next technology">
            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    @else
      <div class="web-services__grid{{ $capabilitiesGridColumns === 2 ? ' web-services__grid--cols-2' : '' }}">
        @foreach (($service['capabilities'] ?? []) as $index => $cap)
          <article class="web-service-card">
            <img class="web-service-card__icon-img" src="{{ $cap['image'] ?? '' }}" alt="{{ ($cap['title'] ?? 'Service').' capability icon for Suave Creators software development' }}" title="{{ ($cap['title'] ?? 'Service').' capability icon for Suave Creators software development' }}" width="80" height="64">
            <div class="web-service-card__category">
              <span class="text-[10px] font-semibold uppercase text-[#4D4D4D]">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . ' - Capability' }}</span>
              <h3 class="mt-2 text-[14px] font-semibold leading-[130%] text-[#171717]">{{ $cap['title'] ?? '' }}</h3>
            </div>
            @if (!empty($cap['tags']))
              <div class="mt-2 flex flex-wrap gap-1.5">
                @foreach ($cap['tags'] as $tag)
                  <span class="rounded-full bg-[#EEF1FF] px-2.5 py-0.5 text-[10px] font-semibold text-[#2A4DFB]">{{ $tag }}</span>
                @endforeach
              </div>
            @endif
            <p class="mt-2 text-[14px] text-[#4D4D4D]">{{ $cap['desc'] ?? '' }}</p>
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>
<!-- 6. Capabilities Section End -->

<!-- 7. Collab Band Section Start -->
@if (!$isWebDevelopmentService)
<section
  class="full-bleed collab-section bg-cover bg-center bg-no-repeat py-12 md:py-16"
  style="background-image: url('{{ $collabBackground }}');"
  aria-labelledby="service-collab-title">
  <div class="section-inner collab-section__inner">
    <div class="collab-section__content">
      <p class="collab-section__message">
        <em>{{ $service['collabText'] ?? 'Come and build together a better business with' }}</em>
        <strong id="service-collab-title">{{ $service['collabBrand'] ?? 'SUAVE CREATORS.' }}</strong>
      </p>
      <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer" class="collab-section__link">{{ $service['collabButtonText'] ?? 'REQUEST A QUOTE' }}</a>
    </div>
    @if ($collabImage !== '')
      <div class="collab-section__media">
        <img src="{{ $collabImage }}" alt="Suave Creators collaboration visual for custom software development" title="Suave Creators collaboration visual for custom software development" width="500" height="360" class="collab-section__image" loading="lazy">
      </div>
    @endif
  </div>
</section>
@endif
<!-- 7. Collab Band Section End -->

<!-- 8. Portfolio Showcase Section Start -->
@if ($isWebDevelopmentService)
<section class="full-bleed portfolio-showcase portfolio-hero-showcase overflow-hidden bg-[linear-gradient(180deg,#F8FAFF_0%,#FFFFFF_100%)] !py-10 md:!py-14" aria-labelledby="service-portfolio-heading">
  <div class="section-inner">
    <header class="mx-auto mb-10 max-w-[720px] text-center lg:mb-12">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $service['portfolioEyebrow'] ?? 'Our Projects' }}</p>
      <h2 id="service-portfolio-heading" class="mt-4 text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]">{{ $service['portfolioTitle'] ?? '' }}</h2>
      <p class="mx-auto mt-4 max-w-[560px] text-[14px] leading-6 text-[#4D4D4D]">{{ $service['portfolioDescription'] ?? '' }}</p>
    </header>
    <div class="service-portfolio-rail portfolio-hero-rail">
      <div class="swiper servicePortfolioSwiper !overflow-hidden" aria-label="Project showcase carousel">
        <div class="swiper-wrapper">
          @foreach ($portfolioItems as $item)
            <div class="swiper-slide h-auto">
              @if (($item['url'] ?? '') !== '')
                <a href="{{ $item['url'] }}" class="portfolio-showcase__link block h-full w-full" @if (!empty($item['external'])) target="_blank" rel="noopener noreferrer" @endif aria-label="{{ $item['alt'] }}">
                  <figure class="portfolio-showcase__image h-full w-full">
                    <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" title="{{ $item['alt'] }}" loading="lazy" draggable="false">
                  </figure>
                </a>
              @else
                <figure class="portfolio-showcase__image h-full w-full">
                  <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" title="{{ $item['alt'] }}" loading="lazy" draggable="false">
                </figure>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="portfolio-hero-pagination"></div>
    <div class="mt-10 flex flex-wrap items-center justify-center gap-5">
      <x-frontend.cta-button>
        Start your Project
      </x-frontend.cta-button>
      <a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer" class="border-b border-[#00003F] text-sm font-semibold text-[#00003F]">Book a Call</a>
    </div>
  </div>
</section>
@else
<section class="full-bleed full-bleed--edge portfolio-showcase portfolio-hero-showcase service-portfolio-showcase overflow-hidden bg-cover bg-top bg-no-repeat py-16 lg:py-20" style="background-image: url('{{ asset('assets/background/portfolio-section-bg.png') }}')" aria-labelledby="service-portfolio-heading">
  <div class="section-inner">
    <header class="mx-auto mb-10 max-w-[720px] text-center lg:mb-12">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $service['portfolioEyebrow'] ?? 'Our Projects' }}</p>
      <h2 id="service-portfolio-heading" class="mt-4 text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]">{{ $service['portfolioTitle'] ?? '' }}</h2>
      <p class="mx-auto mt-4 max-w-[560px] text-[14px] leading-6 text-[#4D4D4D]">{{ $service['portfolioDescription'] ?? '' }}</p>
    </header>
  </div>
  <div class="service-portfolio-rail">
    <div class="swiper servicePortfolioSwiper !overflow-hidden" aria-label="Project showcase carousel">
      <div class="swiper-wrapper">
        @foreach ($portfolioItems as $item)
          <div class="swiper-slide h-auto">
            @if (($item['url'] ?? '') !== '')
              <a href="{{ $item['url'] }}" class="portfolio-showcase__link block h-full w-full" @if (!empty($item['external'])) target="_blank" rel="noopener noreferrer" @endif aria-label="{{ $item['alt'] }}">
                <figure class="portfolio-showcase__image service-portfolio-showcase__image h-full w-full">
                  <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" title="{{ $item['alt'] }}" loading="lazy" draggable="false">
                </figure>
              </a>
            @else
              <figure class="portfolio-showcase__image service-portfolio-showcase__image h-full w-full">
                <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" title="{{ $item['alt'] }}" loading="lazy" draggable="false">
              </figure>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif
<!-- 8. Portfolio Showcase Section End -->

<x-frontend.industries-section
  :cards="$industryCards"
  :eyebrow="$service['industriesEyebrow'] ?? 'Industries We Offer'"
  :title="$service['industriesTitle'] ?? ''"
  :description="$service['industriesDescription'] ?? ''"
  heading-id="service-industries-heading"
  class="py-[80px]"
/>

<!-- 9. Technologies & Partnerships Marquee Section Start -->
<x-frontend.tech-partnerships-section :items="$techStack" />
<!-- 9. Technologies & Partnerships Marquee Section End -->

@if (!$isWebDevelopmentService)
<x-frontend.connect-cta-section
  :eyebrow="$service['ctaEyebrow'] ?? 'Ready to Start Your Project?'"
  :title="$service['ctaTitle'] ?? ''"
  :description="$service['ctaDescription'] ?? ''"
  title-id="service-cta-heading"
  primary-label="Let's Connect to Discuss"
/>
@endif

<!-- 11. Why Choose Us Section Start -->
<section class="full-bleed overflow-hidden bg-[#F9FAFC] bg-cover bg-top bg-no-repeat py-16 lg:py-20" style="background-image: url('{{ asset('assets/background/offerings-section-bg.png') }}')" aria-labelledby="service-why-heading">
  <div class="section-inner">
    <header class="mx-auto mb-10 max-w-[720px] text-center lg:mb-14">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $service['whyEyebrow'] ?? 'Suave Creators' }}</p>
      <h2 id="service-why-heading" class="mt-4 text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]">{{ $service['whyTitle'] ?? '' }}</h2>
      <p class="mx-auto mt-4 max-w-[560px] text-[14px] leading-6 text-[#4D4D4D]">{{ $service['whyDescription'] ?? '' }}</p>
    </header>
    <div class="why-choose-list lg:hidden" role="list">
      @foreach (($service['whyCards'] ?? []) as $index => $card)
        @php
$n = $index + 1;
          $isOpen = $index === 0;
          $whyIndex = str_pad((string) $n, 2, '0', STR_PAD_LEFT);
          $whyTags = array_values(array_filter($card['tags'] ?? [], static fn ($t) => $t !== null && $t !== ''));
          $whyFeatures = array_values(array_filter($card['features'] ?? [], static fn ($f) => $f !== null && $f !== ''));
@endphp
        <article class="why-choose-item{{ $isOpen ? ' is-open' : '' }}" role="listitem">
          <button
            type="button"
            class="why-choose-item__summary"
            id="service-why-q-{{ $n }}"
            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
            aria-controls="service-why-panel-{{ $n }}"
          >
            <span class="why-choose-item__top">
              <span class="why-choose-item__index">{{ $whyIndex }}</span>
              <span class="why-choose-item__toggle" aria-hidden="true"></span>
            </span>
            <span class="why-choose-item__title">{{ $card['title'] ?? '' }}</span>
            @if ($whyTags)
              <span class="why-choose-item__tags">{{ implode(' • ', $whyTags) }}</span>
            @endif
          </button>
          <div
            class="why-choose-item__panel"
            id="service-why-panel-{{ $n }}"
            role="region"
            aria-labelledby="service-why-q-{{ $n }}"
            aria-hidden="{{ $isOpen ? 'false' : 'true' }}"
          >
            <div class="why-choose-item__panel-inner">
              @if (!empty($card['image']))
                <figure class="why-choose-item__image">
                  <img src="{{ $card['image'] }}" alt="{{ ($card['title'] ?? 'Service').' benefit visual for Suave Creators software services' }}" title="{{ ($card['title'] ?? 'Service').' benefit visual for Suave Creators software services' }}" class="h-full w-full object-cover" width="640" height="400" loading="{{ $isOpen ? 'eager' : 'lazy' }}">
                </figure>
              @endif
              @if (!empty($card['text']))
                <p class="why-choose-item__text">{{ $card['text'] }}</p>
              @endif
              @if ($whyFeatures)
                <ul class="why-choose-item__features">
                  @foreach ($whyFeatures as $feature)
                    <li>{{ $feature }}</li>
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        </article>
      @endforeach
    </div>
    <div class="hidden grid-cols-1 gap-5 sm:grid-cols-2 lg:grid lg:grid-cols-3 lg:gap-6">
      @foreach (($service['whyCards'] ?? []) as $card)
        <article class="flex min-h-full flex-col gap-3 overflow-hidden rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          @if (!empty($card['image']))
            <figure class="aspect-[16/10] overflow-hidden"><img src="{{ $card['image'] }}" alt="{{ ($card['title'] ?? 'Service').' benefit visual for Suave Creators software services' }}" title="{{ ($card['title'] ?? 'Service').' benefit visual for Suave Creators software services' }}" class="h-full w-full object-cover" loading="lazy"></figure>
          @endif
          <div class="flex flex-1 flex-col gap-3 p-[22px]">
            <h3 class="text-base font-bold leading-tight text-[#171717]">{{ $card['title'] ?? '' }}</h3>
            <p class="flex-1 text-sm leading-relaxed text-[#4D4D4D]">{{ $card['text'] ?? '' }}</p>
          </div>
        </article>
      @endforeach
    </div>
    <div class="mt-10 flex justify-center">
      <x-frontend.cta-button :href="$demoHref">
        {{ $service['whyButtonText'] ?? "Let's Discuss Your Vision" }}
      </x-frontend.cta-button>
    </div>
  </div>
</section>
<!-- 11. Why Choose Us Section End -->

<!-- 12. Development Process Section Start -->
<section class="full-bleed development-process-section{{ $isWebDevelopmentService ? ' development-process-section--webdev' : '' }}" aria-labelledby="service-process-heading">
  <div class="section-inner">
    <header class="development-process-section__header">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $service['processEyebrow'] ?? 'Suave Creators' }}</p>
      <h2 id="service-process-heading" class="development-process-section__title">{{ $service['processTitle'] ?? '' }}</h2>
      <p class="development-process-section__description font-sans">{{ $service['processDescription'] ?? '' }}</p>
    </header>
    <div class="development-process-section__inner">
      <div class="development-process-section__steps">
        @foreach ($processSteps as $index => $step)
          <article class="development-process-section__step">
            <div class="development-process-section__step-top">
              <span class="development-process-section__step-icon">
                <img src="{{ asset($step['icon']) }}" alt="{{ $step['title'] !== '' ? $step['title'] : 'Development process step' }} icon for Suave Creators" title="{{ $step['title'] !== '' ? $step['title'] : 'Development process step' }} icon for Suave Creators" width="28" height="28" loading="lazy">
              </span>
              <span class="development-process-section__step-number" aria-hidden="true">{{ $step['step'] }}</span>
            </div>
            <h3 class="development-process-section__step-title">{{ $step['title'] }}</h3>
            <p class="development-process-section__step-text">{{ $step['desc'] }}</p>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
<!-- 12. Development Process Section End -->

<x-frontend.industries-section
  :cards="$standoutCards"
  :eyebrow="$service['standoutEyebrow'] ?? 'Why Suave Creators Stands Out'"
  :title="$service['standoutTitle'] ?? ''"
  :description="$service['standoutDescription'] ?? ''"
  heading-id="service-standout-heading"
  variant="standout"
  class="py-[80px]"
/>

<!-- 14. Logo Shape Marquee Section Start -->
@if (!$isWebDevelopmentService)
<section class="full-bleed full-bleed--edge digital-services-marquee digital-services-marquee--white" aria-label="Brand marks">
  <div class="digital-services-marquee__track">
    @for ($g = 0; $g < 2; $g++)
      <div class="digital-services-marquee__group" {{ $g === 1 ? 'aria-hidden="true"' : '' }}>
        @for ($i = 0; $i < 8; $i++)
          <span class="digital-services-marquee__icon"><img src="{{ asset('assets/brand/logo-mark-shape.svg') }}" alt="Logo Mark Shape for Suave Creators software development" title="Logo Mark Shape for Suave Creators software development" loading="lazy" width="40" height="40"></span>
        @endfor
      </div>
    @endfor
  </div>
</section>
@endif
<!-- 14. Logo Shape Marquee Section End -->

<x-frontend.faq-section
  :qa="$service['faqs'] ?? []"
  heading-id="service-faq-heading"
  eyebrow="Have questions about our Services?"
  description="Here are the most asked questions for this service."
  class="faq-section--align faq-section--desktop-media"
/>

<x-frontend.consultation-section
  :background-image="$service['finalBg'] ?? ($service['bannerBg'] ?? 'assets/media/webservice-bg.webp')"
  :eyebrow="$service['finalEyebrow'] ?? 'Your Digital Future Together'"
  :title="$service['finalTitle'] ?? 'Let\'s Build Your Business Website Together'"
  :description="$service['finalDescription'] ?? ''"
  :cta-label="$service['finalPrimaryCta'] ?? 'Get a Free Quote'"
  :secondary-cta-label="$service['finalSecondaryCta'] ?? 'Contact us Today'"
  :show-people="($service['showFinalPeople'] ?? true) !== false"
  :hide-bg-below-desktop="($service['hideFinalBgBelowDesktop'] ?? false) === true"
  :allow-html-title="false"
/>

<x-frontend.articles-insights-section
  :items="$articles"
  heading-id="service-insights-title"
  title="Explore Our Insights"
  subtitle="Get in touch with industry trends with our updated blogs from technology and development experts."
  section-class="py-16 lg:py-18"
  more-href="{{ route('blogs') }}"
  more-label="View all blog articles"
/>

@endsection
@push('custom-css')
<style>
.web-services__grid--cols-2 {
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

.web-service-card__icon-img {
  display: block;
  height: 64px;
  margin-bottom: 14px;
  min-width: 80px;
  object-fit: contain;
  width: 80px;
}

.why-choose-list {
  display: grid;
  gap: 14px;
  margin-inline: auto;
  max-width: 820px;
}

@media (min-width: 1024px) {
  .why-choose-list {
    display: none;
  }
}

.why-choose-item {
  background: #fff;
  border: 1px solid rgba(42, 77, 251, 0.08);
  border-radius: 18px;
  box-shadow: 0 18px 40px rgba(36, 36, 84, 0.06);
  overflow: hidden;
  transition: box-shadow 180ms ease;
}

.why-choose-item__summary {
  align-items: stretch;
  background: transparent;
  border: 0;
  color: inherit;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  font-family: inherit;
  gap: 6px;
  padding: 18px 20px;
  text-align: left;
  width: 100%;
}

.why-choose-item__summary:focus-visible {
  outline: 2px solid #2a4dfb;
  outline-offset: -2px;
}

.why-choose-item__top {
  align-items: center;
  display: flex;
  justify-content: space-between;
  width: 100%;
}

.why-choose-item__index {
  color: #6b7280;
  font-family: "PP Mori", "Roboto Flex", ui-sans-serif, system-ui, sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 0.04em;
  line-height: 1;
}

.why-choose-item__toggle {
  color: #171717;
  flex: 0 0 auto;
  font-size: 22px;
  font-weight: 400;
  line-height: 1;
  position: relative;
  width: 1em;
  height: 1em;
}

.why-choose-item__toggle::before,
.why-choose-item__toggle::after {
  background: currentColor;
  content: "";
  left: 50%;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  transition: opacity 180ms ease, transform 180ms ease;
}

.why-choose-item__toggle::before {
  height: 2px;
  width: 14px;
}

.why-choose-item__toggle::after {
  height: 14px;
  width: 2px;
}

.why-choose-item__title {
  color: #171717;
  display: block;
  font-size: 16px;
  font-weight: 700;
  line-height: 1.35;
  padding-right: 28px;
}

.why-choose-item__tags {
  color: #6b7280;
  display: block;
  font-size: 13px;
  font-weight: 500;
  line-height: 1.45;
  padding-right: 28px;
}

.why-choose-item__panel {
  height: 0;
  opacity: 0;
  overflow: hidden;
  transition: height 280ms ease, opacity 220ms ease;
}

.why-choose-item__panel-inner {
  border-top: 1px solid rgba(23, 23, 23, 0.08);
  display: grid;
  gap: 16px;
  margin: 0 20px;
  padding: 18px 0 20px;
}

.why-choose-item__image {
  aspect-ratio: 16 / 10;
  border-radius: 12px;
  margin: 0;
  overflow: hidden;
}

.why-choose-item__image img {
  display: block;
  height: 100%;
  object-fit: cover;
  width: 100%;
}

.why-choose-item__text {
  color: #4d4d4d;
  font-size: 14px;
  line-height: 1.65;
  margin: 0;
}

.why-choose-item__features {
  display: grid;
  gap: 10px;
  list-style: none;
  margin: 0;
  padding: 0;
}

.why-choose-item__features li {
  align-items: flex-start;
  color: #171717;
  display: flex;
  font-size: 14px;
  font-weight: 500;
  gap: 10px;
  line-height: 1.45;
}

.why-choose-item__features li::before {
  background: transparent;
  border: 1.5px solid #2a4dfb;
  border-radius: 50%;
  content: "";
  flex: 0 0 auto;
  height: 10px;
  margin-top: 4px;
  width: 10px;
}

.service-capabilities-slider {
  min-width: 0;
}

.serviceCapabilitiesSwiper {
  overflow: hidden;
}

.service-capabilities-slider__controls {
  display: flex;
  gap: 8px;
  justify-content: flex-end;
  margin-top: 24px;
}

.service-body--webdev {
  background-color: #efeef1;
  background-image: var(--service-body-image);
  background-position: left center;
  background-repeat: no-repeat;
  background-size: cover;
  min-height: min(100vh, 820px);
  overflow: hidden;
  padding-block: 60px;
  position: relative;
}

.digital-services-marquee--white {
  background: #ffffff;
}

.collab-section {
  color: #fff;
}

.collab-section__inner {
  align-items: center;
  display: flex;
  gap: 40px;
  justify-content: space-between;
}

.collab-section__content {
  flex: 0 1 60%;
  max-width: 720px;
}

.collab-section__message {
  color: #fff;
  font-family: Georgia, "Times New Roman", serif;
  font-size: clamp(1.125rem, 2.2vw, 1.5rem);
  font-style: normal;
  line-height: 1.6;
  margin: 0;
}

.collab-section__message em {
  font-style: italic;
  font-weight: 400;
}

.collab-section__message strong {
  color: #fff;
  display: block;
  font-style: normal;
  font-weight: 700;
  margin-top: 0.35rem;
}

.collab-section__link {
  color: #6c63ff;
  display: inline-block;
  font-size: 16px;
  font-style: normal;
  font-weight: 700;
  margin-top: 10px;
  text-decoration: underline;
  text-transform: uppercase;
}

.collab-section__link:hover {
  color: #8b84ff;
}

.collab-section__link:focus-visible {
  outline: 2px solid #fff;
  outline-offset: 3px;
}

.collab-section__media {
  display: flex;
  flex: 1 1 40%;
  justify-content: center;
  min-width: 0;
}

.collab-section__image {
  border-radius: 10px;
  display: block;
  height: auto;
  max-width: 500px;
  object-fit: cover;
  width: 100%;
}

.service-portfolio-rail {
  margin-top: 0;
  min-width: 0;
  width: 100%;
}

.service-portfolio-showcase .servicePortfolioSwiper {
  overflow: hidden;
  width: 100%;
}

.service-portfolio-showcase .service-portfolio-showcase__image {
  aspect-ratio: auto;
  border-radius: 12px;
  height: clamp(280px, 42vw, 520px);
  box-shadow: 0 16px 36px rgb(36 36 84 / 10%);
}

.service-portfolio-showcase .service-portfolio-showcase__image img {
  height: 100%;
  object-fit: cover;
  width: 100%;
}

.service-banner-logos {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 12px;
  width: 100%;
  max-width: 100%;
  overflow: hidden;
}

@media (min-width: 1024px) {
  .service-banner-logos {
    overflow: visible;
    padding: 10px;
    margin: -10px;
    width: calc(100% + 20px);
    max-width: none;
  }
}

.service-banner__orbit {
  animation: service-banner-orbit 13s linear infinite;
}

.service-banner-logo {
  position: relative;
  isolation: isolate;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  min-width: 0;
  min-height: 88px;
  padding: 14px 10px;
  border-radius: 16px;
  overflow: hidden;
  background: radial-gradient(
  90.16% 143.01% at 15.32% 21.04%,
  rgba(165, 239, 255, 0.2) 0%,
  rgba(110, 191, 244, 0.05) 77.08%,
  rgba(70, 144, 213, 0) 100%
  );
  backdrop-filter: blur(80px);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  z-index: 1;
}

@media (min-width: 640px) {
  .service-banner-logo {
    min-height: 96px;
    padding: 16px 12px;
  }
}

.service-banner-logo::before {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: inherit;
  padding: 2px;
  background: linear-gradient(270deg, #98f9ff, #eabfff, #8726b7, #98f9ff);
  background-size: 400% 400%;
  animation: serviceBannerLogoGradient 8s linear infinite;
  mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  mask-composite: exclude;
  -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;
  pointer-events: none;
  z-index: 0;
}

.service-banner-logo:hover {
  z-index: 2;
  transform: scale(1.05);
  box-shadow: 0 0 25px rgba(152, 249, 255, 0.3),
  0 0 50px rgba(234, 191, 255, 0.15);
}

.service-banner-logo__img {
  position: relative;
  z-index: 1;
  max-width: 88px;
  max-height: 52px;
  width: auto;
  height: auto;
  object-fit: contain;
  opacity: 0.9;
  transition: opacity 0.3s ease;
}

.service-banner-logo:hover .service-banner-logo__img {
  opacity: 1;
}

.development-process-section {
  background: linear-gradient(5deg, #edf0ff 0%, #ffffff 100%);
  padding: 80px 0;
  text-align: center;
}

.development-process-section__header {
  align-items: center;
  display: flex;
  flex-direction: column;
  margin: 0 auto 32px;
  max-width: 720px;
  text-align: center;
  width: 100%;
}

.development-process-section__title {
  color: #171717;
  font-size: clamp(1.75rem, 4vw, 2.75rem);
  font-weight: 600;
  line-height: 1.2;
  margin: 16px auto 0;
  max-width: 680px;
  text-align: center;
}

.development-process-section__description {
  color: #4d4d4d;
  font-family: "PP Mori", "Roboto Flex", ui-sans-serif, system-ui, sans-serif;
  font-size: 14px;
  line-height: 1.5;
  margin: 16px auto 0;
  max-width: 700px;
  text-align: center;
  width: 100%;
}

.development-process-section__inner {
  aspect-ratio: auto;
  background-image: none;
  max-width: none;
  min-height: 0;
  padding: 0;
  text-align: left;
  width: 100%;
}

.development-process-section__inner::before {
  content: none;
  display: none;
}

.development-process-section__steps {
  display: grid;
  gap: 16px;
  grid-template-columns: minmax(0, 1fr);
}

.development-process-section__step {
  background: #fff;
  border: 1px solid rgba(42, 77, 251, 0.08);
  border-radius: 22px;
  box-shadow: 0 18px 40px rgba(36, 36, 84, 0.06);
  box-sizing: border-box;
  margin-top: 0;
  max-width: none;
  min-width: 0;
  padding: 24px;
  text-align: left;
  width: 100%;
}

.development-process-section__step-top {
  align-items: center;
  display: flex;
  justify-content: space-between;
  margin-bottom: 16px;
  width: 100%;
}

.development-process-section__step-icon {
  align-items: center;
  background: #eef1ff;
  border-radius: 16px;
  display: inline-flex;
  flex-shrink: 0;
  height: 56px;
  justify-content: center;
  width: 56px;
}

.development-process-section__step-icon img {
  height: 28px;
  object-fit: contain;
  width: 28px;
}

.development-process-section__step-number {
  background: linear-gradient(180deg, #2f69fb 12%, #c56bff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  flex-shrink: 0;
  font-size: 28px;
  font-weight: 800;
  letter-spacing: -0.04em;
  line-height: 1;
}

.development-process-section__step-title {
  color: #171717;
  font-size: 16px;
  font-weight: 700;
  line-height: 1.35;
  margin: 0 0 8px;
}

.development-process-section__step-text {
  color: #4d4d4d;
  font-size: 14px;
  line-height: 1.5;
  margin: 0;
}

@media (max-width: 639px) {
  .development-process-section {
    padding: 40px 0;
  }

  .development-process-section__header {
    margin-bottom: 24px;
  }

  .development-process-section__title {
    font-size: clamp(1.375rem, 7vw, 1.75rem);
    overflow-wrap: break-word;
  }

  .development-process-section__description {
    overflow-wrap: break-word;
  }

  .development-process-section__steps {
    gap: 14px;
  }

  .development-process-section__step {
    padding: 20px;
  }
}

@media (min-width: 640px) and (max-width: 1279px) {
  .development-process-section {
    padding: 48px 0;
  }

  .development-process-section__inner {
    aspect-ratio: auto;
    background-image: none;
    margin: 0 auto;
    max-width: none;
    min-height: 0;
    padding: 0;
    position: static;
    width: 100%;
  }

  .development-process-section__steps {
    display: grid;
    gap: 18px;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    height: auto;
    justify-content: initial;
    margin: 0;
    max-width: none;
    min-height: 0;
    width: 100%;
  }

  .development-process-section__step,
  .development-process-section__step:nth-child(odd),
  .development-process-section__step:nth-child(even) {
    align-self: stretch;
    max-width: none;
    padding: 28px 24px;
    width: 100%;
  }

  .development-process-section__step:last-child:nth-child(odd) {
    grid-column: 1 / -1;
  }

  .development-process-section__step-title {
    font-size: 17px;
    margin: 0 0 8px;
    overflow-wrap: break-word;
  }

  .development-process-section__step-text {
    font-size: 14px;
    line-height: 1.5;
    overflow-wrap: break-word;
  }
}

@media (min-width: 1024px) {
  .service-banner-logos {
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 20px;
  }

  .service-banner-logo {
    min-height: 130px;
    padding: 24px 16px;
  }

  .service-banner-logo__img {
    max-width: 110px;
    max-height: 64px;
  }
}

@media (max-width: 767px) {
  .web-services__grid--cols-2 {
    grid-template-columns: 1fr;
  }

  .web-service-card__icon-img {
    margin-inline: auto;
  }
}

@media (prefers-reduced-motion: reduce) {
  .why-choose-item,
  .why-choose-item__toggle::before,
  .why-choose-item__toggle::after,
  .why-choose-item__panel {
    transition: none;
  }

  .service-banner-logo::before {
    animation: none;
  }

  .service-banner-logo:hover {
    transform: none;
  }

  .service-banner__orbit {
    animation: none;
  }
}

@media (min-width: 1280px) {
  .development-process-section {
    padding: 120px 0 80px;
  }

  .development-process-section__header {
    margin-bottom: 8px;
  }

  .development-process-section__inner {
    background-image: url("/assets/media/development-vector-visual.png");
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
    min-height: 620px;
    padding: 32px 0 56px;
    text-align: center;
  }

  .development-process-section__inner::before {
    content: none;
    display: none;
  }

  .development-process-section__steps {
    display: grid;
    gap: 0 10px;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    align-items: start;
  }

  .development-process-section__step,
  .development-process-section__step:nth-child(odd),
  .development-process-section__step:nth-child(even) {
    align-self: auto;
    background: none;
    border: 0;
    border-radius: 0;
    box-shadow: none;
    grid-column: auto;
    max-width: none;
    padding: 0 12px;
    width: auto;
  }

  .development-process-section__step-top {
    display: none;
  }

  .development-process-section__step:nth-child(odd) {
    margin-top: 340px;
  }

  .development-process-section__step:nth-child(even) {
    margin-top: 0;
    padding-bottom: 24px;
  }

  .development-process-section__step:last-child:nth-child(odd) {
    grid-column: auto;
  }

  .development-process-section__step-title {
    font-size: 16px;
    margin: 0 0 8px;
  }

  .development-process-section__step-text {
    color: rgba(17, 17, 17, 1);
    line-height: 1.45;
  }
}

@media (max-width: 1280px) {
  .service-body--webdev {
    background-image: none;
    background-color: #efeef1;
    min-height: 0;
    padding-block: 48px;
  }
}

@media (max-width: 900px) {
  .collab-section__inner {
    flex-direction: column;
    text-align: center;
  }

  .collab-section__content {
    flex-basis: auto;
    max-width: none;
    width: 100%;
  }

  .collab-section__media {
    width: 100%;
  }

  .collab-section__image {
    margin-inline: auto;
    margin-top: 20px;
    max-width: min(100%, 360px);
  }
}

@media (min-width: 640px) and (max-width: 1023px) {
  .service-banner-logos {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
  }

  .service-banner-logo {
    min-height: 110px;
    padding: 20px 16px;
  }

  .service-banner-logo__img {
    max-width: 100px;
    max-height: 58px;
  }
}
</style>
@endpush

@push('scripts')
<script>
window.suaveWhenSwiperReady(function () {
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');

  if (document.querySelector('.servicePortfolioSwiper')) {
    var isIndustryStylePortfolio = !!document.querySelector('.portfolio-hero-rail .servicePortfolioSwiper');
    var portfolioMarqueeSpeed = 18000;
    var portfolioDragSpeed = 500;
    new Swiper('.servicePortfolioSwiper', isIndustryStylePortfolio
      ? {
          slidesPerView: 1,
          spaceBetween: 16,
          speed: 700,
          rewind: true,
          allowTouchMove: true,
          simulateTouch: true,
          grabCursor: true,
          touchEventsTarget: 'container',
          touchStartPreventDefault: false,
          watchOverflow: true,
          autoplay: reduce.matches
            ? false
            : { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: true },
          pagination: {
            el: '.portfolio-hero-pagination',
            clickable: true
          },
          a11y: {
            enabled: true,
            containerMessage: 'Project showcase carousel'
          },
          breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 18 },
            1024: { slidesPerView: 4, spaceBetween: 20 }
          }
        }
      : {
          slidesPerView: 1.15,
          spaceBetween: 16,
          speed: portfolioMarqueeSpeed,
          loop: true,
          loopAdditionalSlides: 4,
          allowTouchMove: true,
          simulateTouch: true,
          grabCursor: true,
          touchEventsTarget: 'container',
          touchStartPreventDefault: false,
          watchSlidesProgress: true,
          watchOverflow: true,
          autoplay: reduce.matches
            ? false
            : { delay: 0, disableOnInteraction: false, pauseOnMouseEnter: true },
          a11y: {
            enabled: true,
            containerMessage: 'Project showcase carousel'
          },
          breakpoints: {
            640: { slidesPerView: 2.2, spaceBetween: 18 },
            1024: { slidesPerView: 3.2, spaceBetween: 22 },
            1400: { slidesPerView: 3.8, spaceBetween: 24 }
          },
          on: {
            touchStart: function (swiper) {
              swiper.params.speed = portfolioDragSpeed;
              if (swiper.autoplay && swiper.autoplay.running) {
                swiper.autoplay.stop();
              }
            },
            touchEnd: function (swiper) {
              swiper.params.speed = portfolioMarqueeSpeed;
              if (!reduce.matches && swiper.params.autoplay && swiper.autoplay) {
                swiper.autoplay.start();
              }
            }
          }
        });
  }

  if (document.querySelector('.serviceCapabilitiesSwiper')) {
    new Swiper('.serviceCapabilitiesSwiper', {
      slidesPerView: 1,
      spaceBetween: 16,
      speed: 650,
      rewind: true,
      watchOverflow: true,
      navigation: {
        nextEl: '.service-capabilities-next',
        prevEl: '.service-capabilities-prev'
      },
      a11y: {
        enabled: true,
        containerMessage: 'Technologies carousel'
      },
      breakpoints: {
        768: { slidesPerView: 2, spaceBetween: 18 },
        1024: { slidesPerView: 3, spaceBetween: 20 }
      }
    });
  }

  var bannerLogosEl = document.querySelector('.serviceBannerLogosSwiper');
  if (bannerLogosEl) {
    var bannerLogosMq = window.matchMedia('(max-width: 1023px)');
    var bannerLogosSwiper = null;

    function syncBannerLogosSwiper() {
      if (bannerLogosMq.matches) {
        if (bannerLogosSwiper) return;
        bannerLogosSwiper = new Swiper(bannerLogosEl, {
          slidesPerView: 2,
          spaceBetween: 10,
          speed: 500,
          loop: true,
          watchOverflow: true,
          allowTouchMove: true,
          autoplay: reduce.matches
            ? false
            : { delay: 2000, disableOnInteraction: false, pauseOnMouseEnter: true },
          a11y: {
            enabled: true,
            containerMessage: 'Technologies carousel'
          },
          breakpoints: {
            640: { slidesPerView: 3, spaceBetween: 16 }
          }
        });
        return;
      }

      if (bannerLogosSwiper) {
        bannerLogosSwiper.destroy(true, true);
        bannerLogosSwiper = null;
      }
    }

    syncBannerLogosSwiper();
    if (typeof bannerLogosMq.addEventListener === 'function') {
      bannerLogosMq.addEventListener('change', syncBannerLogosSwiper);
    } else if (typeof bannerLogosMq.addListener === 'function') {
      bannerLogosMq.addListener(syncBannerLogosSwiper);
    }
  }
});

document.addEventListener('DOMContentLoaded', function () {
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
  var whyItems = document.querySelectorAll('.why-choose-list .why-choose-item');
  function setWhyAria(item, open) {
    item.querySelector('.why-choose-item__summary').setAttribute('aria-expanded', open ? 'true' : 'false');
    item.querySelector('.why-choose-item__panel').setAttribute('aria-hidden', open ? 'false' : 'true');
  }
  function openWhy(item) {
    var panel = item.querySelector('.why-choose-item__panel');
    item.classList.add('is-open');
    setWhyAria(item, true);
    if (reduce.matches) { panel.style.height = 'auto'; return; }
    panel.style.height = panel.getBoundingClientRect().height + 'px';
    panel.offsetHeight;
    panel.style.height = panel.scrollHeight + 'px';
    panel.addEventListener('transitionend', function once(e) {
      if (e.propertyName === 'height' && item.classList.contains('is-open')) {
        panel.style.height = 'auto';
        panel.removeEventListener('transitionend', once);
      }
    });
  }
  function closeWhy(item) {
    var panel = item.querySelector('.why-choose-item__panel');
    if (reduce.matches) {
      item.classList.remove('is-open');
      setWhyAria(item, false);
      panel.style.height = '0px';
      return;
    }
    panel.style.height = (panel.style.height === 'auto' ? panel.scrollHeight : panel.getBoundingClientRect().height) + 'px';
    panel.offsetHeight;
    item.classList.remove('is-open');
    setWhyAria(item, false);
    requestAnimationFrame(function () { panel.style.height = '0px'; });
  }
  whyItems.forEach(function (item) {
    var panel = item.querySelector('.why-choose-item__panel');
    var open = item.classList.contains('is-open');
    panel.style.transition = 'none';
    panel.style.height = open ? 'auto' : '0px';
    setWhyAria(item, open);
  });
  if (whyItems.length) whyItems[0].offsetHeight;
  whyItems.forEach(function (item) {
    var panel = item.querySelector('.why-choose-item__panel');
    panel.style.removeProperty('transition');
    item.querySelector('.why-choose-item__summary').addEventListener('click', function () {
      var should = !item.classList.contains('is-open');
      whyItems.forEach(function (sibling) {
        if (sibling !== item && sibling.classList.contains('is-open')) closeWhy(sibling);
      });
      if (should) openWhy(item); else closeWhy(item);
    });
  });
});
</script>
@endpush
