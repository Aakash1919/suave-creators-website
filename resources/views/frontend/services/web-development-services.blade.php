@extends('layouts.frontend')

@section('content')

<x-frontend.detail-hero-section
  :eyebrow="$service['eyebrow']"
  :title-lines="$service['heroTitle']"
  :description="$service['heroDescription']"
  :background-image="$service['bannerBg']"
  :side-image="$service['bannerSideImage']"
  :page-title="$service['pageTitle']"
  :framed-side="true"
  :primary-label="$service['heroPrimaryCta']"
  :secondary-label="$service['heroSecondaryCta']" />

<section class="full-bleed bg-white border-b border-[#e7e9ee] section-pad-m py-8 lg:py-14" aria-labelledby="service-scope-heading">
  <div class="section-inner">
    <div class="w-full">
      <div class="mb-4 flex items-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]" aria-hidden="true"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold uppercase tracking-wider text-transparent">
          {{ $service['introQuestionEyebrow'] }}
        </span>
      </div>
      <h2 id="service-scope-heading" class="home-type-h2 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">
        {{ $service['introQuestion'] }}
      </h2>
      <p class="mt-4 text-[15px] sm:text-[16px] leading-[26px] text-[#4D4D4D]">
        {{ $service['introAnswer'] }}
      </p>
    </div>
  </div>
</section>

<x-frontend.service-intro-section
  :eyebrow="$service['introEyebrow']"
  :title="$service['introTitle']"
  :description="$service['introDescription']"
  :link-href="$service['introLinkUrl']"
  :link-label="$service['introLinkText']"
  :stats="$introStats" />

<x-frontend.connect-cta-section
  :eyebrow="$service['crossSellEyebrow']"
  :title="$service['crossSellTitle']"
  :description="$service['crossSellDescription']"
  title-id="service-collab-title"
  :primary-label="$service['crossSellPrimaryLabel']"
  primary-service="web-development"
  :secondary-label="$service['crossSellSecondaryLabel']"
  :secondary-class="$service['crossSellSecondaryClass']"
  :show-phone="$service['crossSellShowPhone']" />

<x-frontend.service-overview-section
  :eyebrow="$service['bodyEyebrow']"
  :title="$service['bodyTitle']"
  :paragraphs="$service['bodyParagraphs']"
  :background-image="$service['bodyBg']"
  :primary-href="$service['bodyPrimaryHref']"
  :primary-label="$service['bodyPrimaryCta']"
  :secondary-href="$service['bodySecondaryHref']"
  :secondary-label="$service['bodySecondaryCta']" />

<x-frontend.service-capabilities-section
  :eyebrow="$service['capabilitiesEyebrow']"
  :title="$service['capabilitiesTitle']"
  :description="$service['capabilitiesDescription']"
  :items="$service['capabilities']"
  :columns="$service['capabilitiesGridColumns']" />

<x-frontend.portfolio-carousel-section
  :eyebrow="$service['portfolioEyebrow']"
  :title="$service['portfolioTitle']"
  :description="$service['portfolioDescription']"
  :items="$portfolioItems">
  <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row sm:gap-6">
    <x-frontend.cta-button :href="$service['portfolioPrimaryHref']">
      {{ $service['portfolioPrimaryCta'] }}
    </x-frontend.cta-button>
    <a href="{{ $service['portfolioSecondaryHref'] }}" class="group inline-flex max-lg:min-h-[44px] items-center gap-1.5 border-b border-[#2A4DFB] pb-0.5 text-sm font-semibold text-[#2A4DFB] hover:text-[#1835cc] transition">
      {{ $service['portfolioSecondaryCta'] }}
      <x-frontend.cta-arrow />
    </a>
  </div>
</x-frontend.portfolio-carousel-section>

<x-frontend.industries-section
  :cards="$industryCards"
  :eyebrow="$service['industriesEyebrow']"
  :title="$service['industriesTitle']"
  :description="$service['industriesDescription']"
  heading-id="service-industries-heading"
  class="section-pad-m py-6 lg:py-[80px]" />

<x-frontend.tech-partnerships-section :items="\App\Support\Frontend\ServiceSupport::techStack()" />

<x-frontend.why-choose-accordion-section
  :eyebrow="$service['whyEyebrow']"
  :title="$service['whyTitle']"
  :description="$service['whyDescription']"
  :cards="$service['whyCards']"
  :button-href="$service['whyButtonUrl']"
  :button-label="$service['whyButtonText']" />

<x-frontend.process-steps-section
  :eyebrow="$service['processEyebrow']"
  :title="$service['processTitle']"
  :description="$service['processDescription']"
  :steps="$processSteps" />

<x-frontend.industries-section
  :cards="$standoutCards"
  :eyebrow="$service['standoutEyebrow']"
  :title="$service['standoutTitle']"
  :description="$service['standoutDescription']"
  heading-id="service-standout-heading"
  variant="standout"
  class="section-pad-m py-6 lg:py-[80px]" />

<x-frontend.faq-section
  :qa="$service['faqs']"
  heading-id="service-faq-heading"
  :eyebrow="$service['faqEyebrow']"
  :title="$service['faqTitle']"
  :description="$service['faqDescription']"
  :question-heading="$service['faqQuestionHeading']"
  :show-cta="true"
  :cta-label="$service['faqCtaLabel']"
  :cta-href="$service['faqCtaHref']"
  class="faq-section--align faq-section--desktop-media" />

<x-frontend.consultation-section
  :background-image="$service['finalBg']"
  :eyebrow="$service['finalEyebrow']"
  :title="$service['finalTitle']"
  :description="$service['finalDescription']"
  :cta-label="$service['finalPrimaryCta']"
  :secondary-cta-label="$service['finalSecondaryCta']"
  :secondary-cta-href="$service['finalSecondaryHref']"
  service="web-development"
  :show-people="$service['showFinalPeople']"
  :hide-bg-below-desktop="$service['hideFinalBgBelowDesktop']"
  :allow-html-title="false" />

<x-frontend.case-studies-carousel-section
  :items="$caseStudies"
  heading-id="service-case-studies-title"
  :eyebrow="$service['caseStudiesEyebrow']"
  :title="$service['caseStudiesTitle']"
  :subtitle="$service['caseStudiesSubtitle']" />

<x-frontend.articles-insights-section
  :category="$insightCategory"
  heading-id="service-insights-title"
  :eyebrow="$service['articlesEyebrow']"
  :title="$service['articlesTitle']"
  :subtitle="$service['articlesSubtitle']"
  section-class="section-pad-m py-6 lg:py-18"
  :more-href="$service['articlesMoreUrl']"
  :more-label="$service['articlesMoreText']" />

@endsection
