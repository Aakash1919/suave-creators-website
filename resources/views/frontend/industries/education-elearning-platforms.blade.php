@extends('layouts.frontend')

@section('content')

<x-frontend.detail-hero-section
  heading-id="industry-banner-heading"
  :eyebrow="$industry['eyebrow']"
  eyebrow-class="industry-banner__eyebrow"
  :title-lines="$industry['heroTitle']"
  :accent-first="true"
  :description="$industry['heroDescription']"
  :background-image="$industry['bannerBg']"
  :side-image="$industry['bannerSideImage']"
  :page-title="$industry['pageTitle']"
  secondary-label="Schedule a discovery call"
  class="industry-banner" />

<x-frontend.industry-intro-section
  :eyebrow="$industry['introEyebrow']"
  :title="$industry['introTitle']"
  :description="$industry['introDescription']"
  :stats="$introStats" />

<x-frontend.industry-solutions-section
  :eyebrow="$industry['servicesEyebrow']"
  :title="$industry['servicesTitle']"
  :description="$industry['servicesDescription']"
  :items="$industry['services']" />

<x-frontend.connect-cta-section
  :eyebrow="$industry['ctaEyebrow']"
  :title="$industry['ctaTitle']"
  :description="$industry['ctaDescription']"
  title-id="industry-cta-heading"
  primary-label="Let's Connect to Discuss"
  section-class="full-bleed smart-together-cta py-5 sm:py-6" />

<x-frontend.industry-specialized-section
  :eyebrow="$industry['specializedEyebrow']"
  :title="$industry['specializedTitle']"
  :description="$industry['specializedDescription']"
  :items="$industry['specialized']" />

<x-frontend.marquee-section
  type="text"
  :items="$marqueeItems"
  :repeat="1"
  aria-label="Industry focus areas" />

<x-frontend.industry-why-section
  :eyebrow="$industry['whyEyebrow']"
  :title="$industry['whyTitle']"
  :description="$industry['whyDescription']"
  :cards="$industry['whyCards']" />

<x-frontend.agile-process-tabs-section
  :title="$industry['agileTitle']"
  :subtitle="$industry['agileSubtitle']"
  :phases="$agilePhases" />

<x-frontend.core-values-section
  :items="$sectors"
  eyebrow="Our Core Values"
  title="The Pillars Behind Our Excellence"
  description="We believe in offering seamless, effective, and custom-made solutions, which cater for your specific future goals"
  grid-class="core-values__grid--3" />

<x-frontend.faq-section
  :qa="$industry['faqs']"
  heading-id="industry-faq-heading"
  eyebrow="Have questions about our Industry Solutions?"
  description="Here are the most asked questions for this industry."
  class="faq-section--align" />

<x-frontend.consultation-section
  :background-image="$industry['finalBg']"
  :eyebrow="$industry['finalEyebrow']"
  :title="$industry['finalTitle']"
  :description="$industry['finalDescription']"
  cta-label="Get a Free Quote"
  :show-people="false"
  :hide-bg-below-desktop="$industry['hideFinalBgBelowDesktop']"
  :allow-html-title="false" />

<x-frontend.testimonials-section
  :items="$testimonialItems"
  eyebrow="Client Testimonials"
  title="What Our Clients Say"
  subtitle=""
  heading-id="industry-testimonials-title" />

<x-frontend.case-studies-carousel-section
  :items="$caseStudies"
  heading-id="industry-case-studies-title"
  title="Related case studies"
  subtitle="Projects where this industry context shaped the product — from discovery to shipped software." />

<x-frontend.articles-insights-section
  :category="$insightCategory"
  heading-id="industry-insights-title"
  title="Explore Our Insights"
  subtitle="Get in touch with industry trends with our updated blogs from technology and development experts."
  section-class="section-pad-m py-6 lg:py-18"
  :more-href="route('blogs')"
  more-label="View all blog articles" />

@endsection
