@extends('layouts.frontend')

@section('theme-color', '#05070A')

@push('custom-css')
<link rel="preload" as="image" href="{{ asset($service['heroBackgroundImage']) }}" type="image/webp">
<link rel="preload" as="image" href="{{ asset($service['radarVisualImage']) }}" type="image/webp">
@endpush

@section('content')

<x-frontend.marketing-radar-hero-section
  :eyebrow="$service['eyebrow']"
  :title="$service['heroTitle']"
  :description="$service['heroDescription']"
  :breadcrumb-current="$service['breadcrumbName']"
  :primary-label="$service['heroPrimaryCta']"
  :secondary-label="$service['heroSecondaryCta']"
  primary-service="digital-marketing"
  :background-image="$service['heroBackgroundImage']"
  :visual-image="$service['radarVisualImage']"
  :visual-alt="$service['radarVisualAlt']"
  :proof-points="$service['radarProofPoints']" />

@php
  $overview = $service['overview'];
  $seoChannel = $service['seoChannel'];
  $ppcChannel = $service['ppcChannel'];
  $contentChannel = $service['contentChannel'];
  $socialChannel = $service['socialChannel'];
  $funnelMatrix = $service['funnelMatrix'];
  $howWeWork = $service['howWeWork'];
  $whySuave = $service['whySuave'];
  $consultation = $service['consultation'];
  $demoHref = \App\Support\Frontend\ContactSupport::demoHref();
  $partnerLogos = array_values(array_filter(
      \App\Support\Frontend\HomeSupport::partnerMarqueeItems(),
      static fn (array $item): bool => ! str_contains((string) ($item['src'] ?? ''), 'turbo-trans')
  ));
@endphp

<x-frontend.marketing-services-overview-section
  :eyebrow="$overview['eyebrow']"
  :title="$overview['title']"
  :description="$overview['description']"
  :rows="$overview['rows']"
  heading-id="digital-marketing-overview-heading"
  section-id="overview" />

<x-frontend.marketing-channel-detail-section
  :index="$seoChannel['index']"
  :total="$seoChannel['total']"
  :title="$seoChannel['title']"
  :intro="$seoChannel['intro']"
  :intro-highlight="$seoChannel['introHighlight']"
  :covers-heading="$seoChannel['coversHeading']"
  :covers="$seoChannel['covers']"
  :callout-label="$seoChannel['calloutLabel']"
  :callout-body="$seoChannel['calloutBody']"
  :section-id="$seoChannel['sectionId'] ?? 'seo'"
  heading-id="digital-marketing-seo-heading"
  icon="search" />

<x-frontend.marketing-channel-detail-section
  :index="$ppcChannel['index']"
  :total="$ppcChannel['total']"
  :title="$ppcChannel['title']"
  :intro="$ppcChannel['intro']"
  :intro-highlight="$ppcChannel['introHighlight']"
  :covers-heading="$ppcChannel['coversHeading']"
  :covers="$ppcChannel['covers']"
  :callout-label="$ppcChannel['calloutLabel']"
  :callout-body="$ppcChannel['calloutBody']"
  :section-id="$ppcChannel['sectionId'] ?? 'ppc'"
  heading-id="digital-marketing-ppc-heading"
  icon="dollar" />

<x-frontend.marketing-channel-detail-section
  :index="$contentChannel['index']"
  :total="$contentChannel['total']"
  :title="$contentChannel['title']"
  :intro="$contentChannel['intro']"
  :intro-highlight="$contentChannel['introHighlight']"
  :covers-heading="$contentChannel['coversHeading']"
  :covers="$contentChannel['covers']"
  :bridge="$contentChannel['bridge'] ?? ''"
  :callout-label="$contentChannel['calloutLabel']"
  :callout-body="$contentChannel['calloutBody']"
  :section-id="$contentChannel['sectionId'] ?? 'content-marketing'"
  heading-id="digital-marketing-content-heading"
  icon="blog" />

<x-frontend.marketing-channel-detail-section
  :index="$socialChannel['index']"
  :total="$socialChannel['total']"
  :title="$socialChannel['title']"
  :intro="$socialChannel['intro']"
  :intro-highlight="$socialChannel['introHighlight']"
  :covers-heading="$socialChannel['coversHeading']"
  :covers="$socialChannel['covers']"
  :callout-label="$socialChannel['calloutLabel']"
  :callout-body="$socialChannel['calloutBody']"
  :section-id="$socialChannel['sectionId'] ?? 'social-media-marketing'"
  heading-id="digital-marketing-social-heading"
  icon="share" />

<x-frontend.marketing-funnel-matrix-section
  :eyebrow="$funnelMatrix['eyebrow']"
  :title="$funnelMatrix['title']"
  :description="$funnelMatrix['description']"
  :columns="$funnelMatrix['columns']"
  :rows="$funnelMatrix['rows']"
  :examples="$funnelMatrix['examples']"
  :ai-visibility="$funnelMatrix['aiVisibility']"
  :section-id="$funnelMatrix['sectionId'] ?? 'integrated'"
  heading-id="digital-marketing-funnel-heading" />

<x-frontend.marketing-operating-rhythm-section
  :eyebrow="$howWeWork['eyebrow']"
  :title="$howWeWork['title']"
  :items="$howWeWork['items']"
  heading-id="digital-marketing-how-we-work-heading" />

<x-frontend.marketing-why-panel-section
  :eyebrow="$whySuave['eyebrow']"
  :title="$whySuave['title']"
  :description="$whySuave['description']"
  :cta-label="$whySuave['ctaLabel']"
  :items="$whySuave['items']"
  primary-service="digital-marketing"
  heading-id="digital-marketing-why-heading" />

<x-frontend.faq-section
  :qa="$service['faqs']"
  :media="null"
  :show-cta="false"
  :eyebrow="$service['faqEyebrow']"
  :title="$service['faqTitle']"
  :description="$service['faqDescription']"
  heading-id="digital-marketing-faq-heading"
  question-heading="h3"
  class="faq-section--crm-builder bg-cover bg-top bg-no-repeat"
  style="background-image: url('{{ asset($service['faqBackgroundImage']) }}')"
/>

<x-frontend.consultation-section
  :eyebrow="$consultation['eyebrow']"
  :title="$consultation['title']"
  :description="$consultation['description']"
  :cta-label="$consultation['ctaLabel']"
  :secondary-cta-label="$consultation['secondaryCtaLabel']"
  :secondary-cta-href="$demoHref"
  :card-position="$consultation['cardPosition']"
  :people="$consultation['people']"
  service="digital-marketing"
  :allow-html-title="false"
/>

<section
  class="full-bleed partnership-section crm-builder-partners bg-repeat"
  style="background-image: url('{{ asset('assets/background/portfolio-section-pattern-bg.png') }}');"
  aria-label="{{ $service['partnersHeading'] }}">
  <div class="partnership-inner section-inner text-center">
    <p class="crm-builder-partners__heading">
      <span>{{ $service['partnersHeading'] }}</span>
    </p>
    <ul class="partnership-grid">
      @foreach ($partnerLogos as $partner)
        <li class="partnership-tile">
          <img
            src="{{ asset($partner['src']) }}"
            alt="{{ $partner['alt'] }}"
            title="{{ $partner['alt'] }}"
            width="160"
            height="42"
            loading="lazy"
            decoding="async">
        </li>
      @endforeach
    </ul>
  </div>
</section>

@endsection
