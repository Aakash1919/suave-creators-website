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
  $seoChannel = $service['seoChannel'];
  $seoRelatedLinks = array_map(static function (array $link): array {
      return [
          'label' => $link['label'],
          'href' => route($link['route'], $link['params'] ?? []),
      ];
  }, $seoChannel['relatedLinks'] ?? []);
@endphp

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
  :related-links="$seoRelatedLinks"
  heading-id="digital-marketing-seo-heading"
  icon="search" />

@endsection
