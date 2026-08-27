@extends('layouts.frontend')

@section('content')


<!-- Single Blog Hero Section Start -->
<section class="single-blog-top relative z-10 w-full pb-3 pt-1 md:pb-4 md:pt-2 lg:pb-6 lg:pt-3 site-container">
  <nav class="blog-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span aria-hidden="true">/</span>
    <a href="{{ route('blogs') }}">Blogs</a>
    <span aria-hidden="true">/</span>
    <span aria-current="page">{{ $post['title'] }}</span>
  </nav>

  @if (! empty($isDraft) || ! empty($post['is_draft']))
    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-amber-300 bg-amber-50 px-3 py-1.5 text-sm font-semibold text-amber-800" role="status">
      Draft preview — only visible while logged in
    </p>
  @endif

  <h1 class="page-hero-title single-blog-main__title">
    @if ($titleLead !== '')
      {{ $titleLead }}
    @endif
    <span class="single-blog-main__title-accent">{{ $titleAccent }}</span>
  </h1>

  <p class="single-blog-main__meta">
    <span>
      <svg xmlns="https://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
      By {{ $post['author_name'] }}
    </span>
    <span>
      <svg xmlns="https://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
      <time datetime="{{ $post['published_date'] }}">{{ $post['published_label'] }}</time>
    </span>
    <span class="single-blog-main__category">
      @if (! empty($post['category_url']))
        <a href="{{ $post['category_url'] }}">{{ $post['category'] }}</a>
      @else
        {{ $post['category'] }}
      @endif
    </span>
  </p>
</section>
<!-- Single Blog Hero Section End -->

<!-- Single Blog Article Section Start -->
<section class="full-bleed bg-white section-pad-m py-6 md:py-8 lg:py-10" aria-label="Blog article">
  <div class="section-inner">
    <div class="single-blog-layout">
      <article class="single-blog-main">
        <div class="single-blog-content">
          {!! $articleContent !!}
        </div>

        <div class="single-blog-footer">
          <ul class="single-blog-tags" aria-label="Tags">
            @foreach ($tags as $tag)
              <li><span class="single-blog-tag">{{ $tag }}</span></li>
            @endforeach
          </ul>
        </div>

        @php
/*
        <div class="single-blog-comment">
          <h2 class="single-blog-comment__title">Leave a comment</h2>
          <form class="single-blog-comment__form" action="/contact-us/#contact-id" method="get">
            <label class="sr-only" for="blog-comment">Your comment</label>
            <textarea id="blog-comment" name="message" rows="6" placeholder="Your comment" required></textarea>

            <div class="single-blog-comment__row">
              <label class="sr-only" for="blog-comment-name">Your name</label>
              <input id="blog-comment-name" name="name" type="text" autocomplete="name" placeholder="Your name" required>

              <label class="sr-only" for="blog-comment-email">Your email</label>
              <input id="blog-comment-email" name="email" type="email" autocomplete="email" placeholder="Your email" required>

              <label class="sr-only" for="blog-comment-website">Your website</label>
              <input id="blog-comment-website" name="website" type="url" autocomplete="url" placeholder="Your website">
            </div>

            <button type="submit" class="u-btn-cta single-blog-comment__submit group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110">
              Submit
              <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
                <path d="M18 8L22 12L18 16"></path>
                <path d="M2 12H22"></path>
              </svg>
            </button>
          </form>
        </div>
        */
@endphp
      </article>

      <aside class="single-blog-sidebar" aria-label="Blog sidebar">
        @if (!empty($categories))
          <div class="blog-widget blog-widget--categories">
            <h2 class="blog-widget__title">Categories</h2>
            <ul class="blog-widget__list">
              @foreach ($categories as $category)
                <li>
                  <a href="{{ $category['url'] ?? route('blogs') }}" @class(['is-active' => ! empty($category['active'])])>
                    <span>{{ $category['name'] ?? '' }}</span>
                    <span class="blog-widget__count">{{ (int) ($category['count'] ?? 0) }}</span>
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        @endif

        @if (!empty($topPosts))
          <div class="blog-widget blog-widget--top-posts">
            <h2 class="blog-widget__title">Top Posts</h2>
            <ol class="blog-top-posts">
              @foreach ($topPosts as $rank => $item)
                <li>
                  <span class="blog-top-posts__num" aria-hidden="true">{{ $rank + 1 }}</span>
                  <div class="blog-top-posts__body">
                    <a href="{{ $item['url'] ?? route('blog.show', $item['slug']) }}">{{ $item['title'] }}</a>
                    <p>{{ $item['short_description'] }}</p>
                  </div>
                </li>
              @endforeach
            </ol>
          </div>
        @endif

        @if (!empty($sliderPosts))
          <div class="blog-widget blog-widget--slider">
            <h2 class="blog-widget__title">More Articles</h2>
            <div class="blogSidebarSwiper swiper" aria-label="More blog articles">
              <div class="swiper-wrapper">
                @foreach ($sliderPosts as $item)
                  <div class="swiper-slide">
                    <article class="articles-card blog-sidebar-card">
                      <figure class="articles-card__image">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" title="{{ $item['title'] }}" width="480" height="280" loading="lazy">
                      </figure>
                      <div class="articles-card__body">
                        <div class="articles-card__meta">
                          <span class="articles-card__byline">
                            <svg xmlns="https://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 24 24" fill="none" stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                              <circle cx="12" cy="8" r="5" />
                              <path d="M20 21a8 8 0 0 0-16 0" />
                            </svg>
                            {{ $item['author_name'] }}
                          </span>
                          <time datetime="{{ $item['published_date'] }}">
                            <svg xmlns="https://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 24 24" fill="none" stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                              <path d="M8 2v4" />
                              <path d="M16 2v4" />
                              <rect width="18" height="18" x="3" y="4" rx="2" />
                              <path d="M3 10h18" />
                            </svg>
                            {{ $item['published_label'] }}
                          </time>
                        </div>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['short_description'] }}</p>
                        <a class="articles-card__link group" href="{{ $item['url'] ?? route('blog.show', $item['slug']) }}">
                          Read more<span class="sr-only"> about {{ $item['title'] }}</span>
                          <x-frontend.cta-arrow />
                        </a>
                      </div>
                    </article>
                  </div>
                @endforeach
              </div>
              <nav class="blog-sidebar-slider__pagination" aria-label="Blog cards pagination"></nav>
            </div>
          </div>
        @endif
      </aside>
    </div>
  </div>
</section>
<!-- Single Blog Article Section End -->

@if (! empty($faqs))
<x-frontend.faq-section
  :qa="$faqs"
  heading-id="blog-faq-heading"
  eyebrow="Questions before you get started?"
  description="Here are the most asked questions based on feedback from our readers."
  cta-label="Book a Consultation"
  class="faq-section--align faq-section--contact bg-cover bg-top bg-no-repeat"
  style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}')"
/>
@endif

<x-frontend.consultation-section />





@endsection

@push('fixed-widgets')
@include('frontend.partials.blog-share', [
    'shareLinks' => $shareLinks ?? [],
    'url' => $post['url'] ?? '',
])
@endpush

@push('custom-css')
<style>
.blog-breadcrumb {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 8px;
  font-size: 13px;
  font-weight: 600;
  color: #b1b9df;
  max-width: 100%;
  min-width: 0;
}

.blog-breadcrumb a {
  color: #b1b9df;
  flex: 0 0 auto;
  text-decoration: none;
  transition: color 0.2s ease;
}

.blog-breadcrumb a:hover {
  color: #fff;
}

.blog-breadcrumb span[aria-hidden="true"] {
  flex: 0 0 auto;
}

.blog-breadcrumb span[aria-current] {
  color: #fff;
  display: block;
  flex: 1 1 0;
  min-width: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.site-main > .single-blog-top {
  min-height: 0 !important;
  padding-top: 0.25rem;
  padding-bottom: 0.75rem;
}

@media (min-width: 768px) {
  .site-main > .single-blog-top {
    padding-top: 0.5rem;
    padding-bottom: 1rem;
  }
}

@media (min-width: 1024px) {
  .site-main > .single-blog-top {
    padding-top: 0.75rem;
    padding-bottom: 1.5rem;
  }
}

.single-blog-top .single-blog-main__title {
  display: block;
  margin-top: 10px;
  max-width: 920px;
  color: #fff;
}

.single-blog-main__title-accent {
  display: inline;
  background-image: linear-gradient(180deg, #2f69fb 15%, #c56bff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  font-weight: 800;
}

.single-blog-top .single-blog-main__meta {
  margin-bottom: 0;
  color: #b1b9df;
}

.single-blog-layout {
  display: grid;
  gap: 48px;
  grid-template-columns: minmax(0, 1fr);
  align-items: start;
}

.single-blog-main {
  min-width: 0;
}

.single-blog-main__image {
  margin: 0;
  overflow: hidden;
  border-radius: 20px;
  background: var(--color-surface);
  box-shadow: 3px 7px 12px -1px #11182714;
}

.single-blog-main__image--inline {
  margin: 20px 0;
}

.single-blog-main__image img {
  display: block;
  width: 100%;
  height: auto;
  aspect-ratio: 16 / 9;
  object-fit: cover;
}

.single-blog-main__title {
  margin-top: 0;
  font-size: clamp(1.75rem, 4vw, 2.75rem);
  font-weight: 800;
  line-height: 1.2;
  color: var(--color-ink);
}

.single-blog-main__meta {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 14px 18px;
  margin-top: 16px;
  margin-bottom: 28px;
  font-size: 13px;
  line-height: 1.5;
  color: #85868c;
}

.single-blog-main__meta > span {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.single-blog-main__category {
  display: inline-flex;
  align-items: center;
  padding: 5px 12px;
  border-radius: var(--radius-pill);
  background: linear-gradient(90deg, var(--color-brand-start), var(--color-brand-end));
  color: #fff;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.04em;
}

.single-blog-content {
  min-width: 0;
  font-size: 16px;
  line-height: 1.75;
  color: #1a1a1a;
}

.single-blog-content > * {
  margin-top: 0;
  margin-bottom: 0;
}

.single-blog-content > * + p {
  margin-top: 16px;
}

.single-blog-content > h2 + p,
.single-blog-content > h3 + p {
  margin-top: 0;
}

.single-blog-content h2 {
  margin-top: 32px;
  margin-bottom: 16px;
  font-size: 24px;
  font-weight: 700;
  line-height: 1.35;
  color: var(--color-ink);
  scroll-margin-top: 100px;
}

.single-blog-content h2:first-child,
.single-blog-main__image + h2 {
  margin-top: 24px;
}

.single-blog-content h3 {
  margin-top: 24px;
  margin-bottom: 12px;
  font-size: 20px;
  font-weight: 700;
  line-height: 1.4;
  color: var(--color-ink);
  scroll-margin-top: 100px;
}

.single-blog-content p {
  margin: 0;
}

.single-blog-content ul,
.single-blog-content ol {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin: 16px 0 0 1.15rem;
}

.single-blog-content p + ul,
.single-blog-content p + ol {
  margin-top: 12px;
}

.single-blog-content ul + p,
.single-blog-content ol + p {
  margin-top: 16px;
}

.single-blog-content li {
  line-height: 1.75;
}

.single-blog-content li > p {
  margin: 0;
}

.single-blog-content a {
  color: var(--color-brand-start);
  font-weight: 600;
  text-decoration: underline;
}

.single-blog-content blockquote {
  position: relative;
  margin: 24px 0 0;
  padding: 18px 20px 18px 22px;
  border: 1px solid rgba(42, 77, 251, 0.12);
  border-radius: 12px;
  background: #f7f8ff;
  box-shadow: none;
  text-align: left;
  font-size: 16px;
  font-weight: 600;
  line-height: 1.65;
  color: var(--color-ink);
  overflow: hidden;
}

.single-blog-content blockquote::before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 4px;
  background: linear-gradient(180deg, #2a4dfb, #7a5ff8);
}

.single-blog-content blockquote::after {
  content: none;
}

.single-blog-content blockquote p {
  position: relative;
  z-index: 1;
  margin: 0;
  padding-right: 0;
}

.single-blog-content blockquote p::before,
.single-blog-content blockquote p::after {
  content: none;
}

.single-blog-content figure:not(.single-blog-main__image) {
  margin: 24px 0 0;
}

.single-blog-content figure img {
  display: block;
  width: 100%;
  height: auto;
  border-radius: 16px;
}

.single-blog-content figcaption {
  margin-top: 10px;
  font-size: 13px;
  line-height: 1.5;
  color: #85868c;
}

.single-blog-content > h2 + .blog-table-wrap,
.single-blog-content > h2 + .blog-checklist,
.single-blog-content > h2 + .blog-stats,
.single-blog-content > h2 + .blog-chart,
.single-blog-content > h2 + .blog-takeaways,
.single-blog-content > h2 + .blog-results {
  margin-top: 8px;
}

.blog-table-wrap {
  margin: 24px 0 0;
  overflow-x: auto;
  border: 1px solid rgba(17, 24, 39, 0.08);
  border-radius: 12px;
  background: #fff;
}

.single-blog-content table {
  width: 100%;
  min-width: 480px;
  border-collapse: collapse;
  font-size: 15px;
  line-height: 1.55;
  color: var(--color-ink);
}

.single-blog-content thead th {
  padding: 14px 16px;
  text-align: left;
  font-size: 13px;
  font-weight: 700;
  color: var(--color-ink);
  background: #f4f6ff;
  border-bottom: 1px solid rgba(42, 77, 251, 0.12);
}

.single-blog-content tbody th,
.single-blog-content tbody td {
  padding: 14px 16px;
  border-top: 1px solid rgba(17, 24, 39, 0.06);
  vertical-align: top;
}

.single-blog-content tbody th {
  font-weight: 700;
  white-space: nowrap;
}

.single-blog-content tbody tr:nth-child(even) {
  background: #fafbff;
}

.blog-chart {
  display: flex;
  flex-direction: column;
  gap: 14px;
  margin: 24px 0 0;
  padding: 20px;
  border: 1px solid rgba(17, 24, 39, 0.08);
  border-radius: 12px;
  background: #fafbff;
}

.blog-chart:not(:has(.blog-chart__row, .blog-chart__bar, figcaption)) {
  display: none;
}

.blog-chart > figcaption {
  margin: 0;
  font-size: 14px;
  font-weight: 700;
  color: var(--color-ink);
}

.blog-chart__row {
  display: grid;
  grid-template-columns: minmax(110px, 30%) minmax(0, 1fr) auto;
  gap: 10px 14px;
  align-items: center;
}

.blog-chart__row:not(:has(.blog-chart__value:not(:empty))) {
  grid-template-columns: minmax(110px, 30%) minmax(0, 1fr);
}

.blog-chart__label,
.blog-chart__value {
  font-size: 13px;
  font-weight: 600;
  line-height: 1.35;
  color: var(--color-ink);
}

.blog-chart__value {
  text-align: right;
  color: var(--color-brand-start);
}

.blog-chart__value:empty {
  display: none;
}

.blog-chart__track {
  height: 12px;
  overflow: hidden;
  border-radius: 999px;
  background: rgba(42, 77, 251, 0.1);
}

.blog-chart__bar {
  display: block;
  height: 100%;
  min-height: 12px;
  border-radius: inherit;
  background: linear-gradient(90deg, var(--color-brand-start), #7a5ff8);
}

.blog-chart__bar--high {
  width: 90%;
}

.blog-chart__bar--mid {
  width: 58%;
}

.blog-chart__bar--low {
  width: 28%;
}

.blog-chart > .blog-chart__bar {
  display: grid;
  grid-template-columns: minmax(110px, 30%) minmax(0, 1fr);
  align-items: center;
  gap: 14px;
  width: 100%;
  height: auto;
  padding: 0;
  color: var(--color-ink);
  font-size: 13px;
  font-weight: 600;
  background: none;
  border-radius: 0;
}

.blog-chart > .blog-chart__bar::after {
  content: "";
  display: block;
  height: 12px;
  border-radius: 999px;
  background: linear-gradient(90deg, var(--color-brand-start), #7a5ff8);
  justify-self: start;
}

.blog-chart > .blog-chart__bar--high::after {
  width: 90%;
}

.blog-chart > .blog-chart__bar--mid::after {
  width: 58%;
}

.blog-chart > .blog-chart__bar--low::after {
  width: 28%;
}

.blog-insight {
  margin: 24px 0 0;
  padding: 18px 20px 18px 22px;
  border-left: 4px solid var(--color-brand-start);
  border-radius: 0 12px 12px 0;
  background: #f7f8ff;
  box-shadow: none;
}

.blog-insight:empty,
.blog-insight:not(:has(:not(:empty))) {
  display: none;
}

.blog-insight p {
  margin: 0;
  color: var(--color-ink);
}

.blog-takeaways,
.blog-checklist,
.blog-results {
  margin: 24px 0 0;
  padding: 20px 22px;
  border: 1px solid rgba(17, 24, 39, 0.08);
  border-radius: 12px;
  background: #fafbff;
}

.blog-takeaways__title,
.blog-checklist__title,
.blog-results__title {
  margin: 0 0 12px;
  font-size: 15px;
  font-weight: 800;
  color: var(--color-ink);
}

.blog-takeaways ul,
.blog-checklist ul,
.blog-results ul {
  margin: 0;
  padding: 0;
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.blog-takeaways li,
.blog-checklist li,
.blog-results li {
  padding-left: 1.4rem;
  position: relative;
}

.blog-takeaways li::before,
.blog-results li::before {
  content: "";
  position: absolute;
  left: 0;
  top: 0.55em;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: var(--color-brand-start);
}

.blog-checklist li::before {
  content: "\2713";
  position: absolute;
  left: 0;
  top: 0;
  font-size: 13px;
  font-weight: 800;
  color: var(--color-brand-start);
}

.blog-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 14px;
  margin: 24px 0 0;
}

.blog-stats:empty {
  display: none;
}

.blog-stat {
  padding: 18px 16px;
  border: 1px solid rgba(17, 24, 39, 0.08);
  border-radius: 12px;
  background: #fff;
}

.blog-stat:not(:has(.blog-stat__value:not(:empty), .blog-stat__label:not(:empty))) {
  display: none;
}

.blog-stat__value {
  margin: 0 0 8px;
  font-size: clamp(1.35rem, 2.4vw, 1.85rem);
  font-weight: 800;
  line-height: 1.15;
  color: var(--color-brand-start);
}

.blog-stat__label {
  margin: 0;
  font-size: 13px;
  line-height: 1.5;
  color: #6b7280;
}

@media (max-width: 767px) {
  .blog-chart__row,
  .blog-chart__row:not(:has(.blog-chart__value:not(:empty))),
  .blog-chart > .blog-chart__bar {
    grid-template-columns: minmax(0, 1fr);
  }

  .blog-chart__label {
    grid-column: auto;
  }
}

.blog-share {
  --blog-share-chat-size: 48px;
  --blog-share-size: 44px;
  --blog-share-inset: 24px;
  --blog-share-gap: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  position: fixed;
  right: var(--blog-share-inset);
  bottom: calc(var(--blog-share-inset) + var(--blog-share-chat-size) + var(--blog-share-gap));
  z-index: 9998;
  width: var(--blog-share-size);
  margin: 0;
  pointer-events: none;
}

.blog-share__toggle,
.blog-share__list,
.blog-share__copied {
  pointer-events: auto;
}

.blog-share__toggle {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  flex: 0 0 var(--blog-share-size);
  width: var(--blog-share-size);
  height: var(--blog-share-size);
  margin: 0;
  padding: 0;
  border: 1px solid rgba(42, 77, 251, 0.16);
  border-radius: 999px;
  color: var(--color-brand-start);
  background: #fff;
  box-shadow: 0 8px 20px rgba(17, 24, 39, 0.1);
  cursor: pointer;
}

.blog-share__toggle:hover,
.blog-share__toggle:focus-visible {
  color: #fff;
  border-color: transparent;
  background: linear-gradient(90deg, var(--color-brand-start), var(--color-brand-end));
}

.blog-share__toggle-icon--close {
  display: none;
}

.blog-share.is-open .blog-share__toggle-icon--share {
  display: none;
}

.blog-share.is-open .blog-share__toggle-icon--close {
  display: block;
}

.blog-share__list {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  margin: 0;
  padding: 0;
  list-style: none;
  width: var(--blog-share-size);
  max-height: 0;
  opacity: 0;
  overflow: hidden;
  pointer-events: none;
  transform: translateY(12px);
  border: 0 solid transparent;
  border-radius: 999px;
  background: transparent;
  box-shadow: none;
  transition: max-height 0.32s ease, opacity 0.24s ease, transform 0.28s ease, padding 0.24s ease, box-shadow 0.24s ease;
}

.blog-share.is-open .blog-share__list {
  max-height: 280px;
  padding: 8px 0;
  opacity: 1;
  pointer-events: auto;
  transform: none;
  border: 0;
  box-shadow: none;
}

.blog-share__list li {
  opacity: 0;
  transform: translateY(8px) scale(0.88);
  transition: opacity 0.22s ease, transform 0.22s ease;
}

.blog-share.is-open .blog-share__list li {
  opacity: 1;
  transform: none;
}

.blog-share.is-open .blog-share__list li:nth-child(1) { transition-delay: 0.04s; }
.blog-share.is-open .blog-share__list li:nth-child(2) { transition-delay: 0.08s; }
.blog-share.is-open .blog-share__list li:nth-child(3) { transition-delay: 0.12s; }
.blog-share.is-open .blog-share__list li:nth-child(4) { transition-delay: 0.16s; }
.blog-share.is-open .blog-share__list li:nth-child(5) { transition-delay: 0.2s; }

.blog-share__btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border: 1px solid rgba(42, 77, 251, 0.16);
  border-radius: 999px;
  color: var(--color-brand-start);
  background: transparent;
  text-decoration: none;
  cursor: pointer;
  transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
}

.blog-share__btn:hover,
.blog-share__btn:focus-visible {
  color: #fff;
  border-color: transparent;
  background: linear-gradient(90deg, var(--color-brand-start), var(--color-brand-end));
}

.blog-share__copied {
  position: absolute;
  right: calc(100% + 10px);
  bottom: 12px;
  margin: 0;
  padding: 6px 10px;
  white-space: nowrap;
  font-size: 12px;
  font-weight: 600;
  color: #fff;
  background: #111827;
  border-radius: 8px;
}

body:has(.suave-agent.is-open) .blog-share {
  opacity: 0;
  pointer-events: none;
}

@media (max-width: 1023px) {
  .blog-share {
    --blog-share-chat-size: 44px;
    --blog-share-size: 40px;
    --blog-share-inset: 16px;
    --blog-share-gap: 8px;
  }
}

@media (max-width: 767px) {
  .blog-share {
    right: max(16px, env(safe-area-inset-right, 0px));
    bottom: calc(max(16px, env(safe-area-inset-bottom, 0px)) + 44px + 8px);
  }
}

@media (prefers-reduced-motion: reduce) {
  .blog-share__list,
  .blog-share__list li {
    transition: none;
  }
}

.single-blog-footer {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  margin-top: 40px;
  padding-top: 28px;
  border-top: 1px solid rgba(42, 77, 251, 0.1);
}

.single-blog-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin: 0;
  padding: 0;
  list-style: none;
}

.single-blog-tag {
  display: inline-flex;
  align-items: center;
  padding: 6px 14px;
  border: 1px solid rgba(42, 77, 251, 0.16);
  border-radius: var(--radius-pill);
  font-size: 12px;
  font-weight: 600;
  color: var(--color-brand-start);
  background: #f3f6ff;
}

.single-blog-nav {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.single-blog-nav__btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  min-height: 40px;
  padding: 8px 16px;
  border: 1px solid rgba(42, 77, 251, 0.16);
  border-radius: var(--radius-pill);
  font-size: 13px;
  font-weight: 600;
  color: var(--color-ink);
  text-decoration: none;
  background: #fff;
  box-shadow: 3px 7px 12px -6px #11182714;
  transition: border-color 0.2s ease, color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
}

.single-blog-nav__btn:hover {
  border-color: transparent;
  color: #fff;
  background: linear-gradient(90deg, var(--color-brand-start), var(--color-brand-deep));
  box-shadow: 3px 7px 18px -6px #2a4dfb40;
}

.single-blog-nav__btn--disabled {
  opacity: 0.45;
  cursor: not-allowed;
  pointer-events: none;
  box-shadow: none;
}

.single-blog-comment {
  margin-top: 48px;
  padding: 28px 24px;
  border: 1px solid rgba(42, 77, 251, 0.08);
  border-radius: 20px;
  background: var(--color-surface);
}

.single-blog-comment__title {
  margin: 0 0 20px;
  font-size: clamp(1.25rem, 2.5vw, 1.5rem);
  font-weight: 700;
  color: var(--color-ink);
}

.single-blog-comment__form textarea,
.single-blog-comment__form input {
  width: 100%;
  margin: 0;
  padding: 14px 16px;
  border: 1px solid var(--color-border-soft);
  border-radius: 12px;
  background: #fff;
  color: var(--color-ink);
  font: inherit;
  font-size: 14px;
  line-height: 1.5;
  outline: none;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.single-blog-comment__form textarea {
  min-height: 140px;
  resize: vertical;
}

.single-blog-comment__form textarea:focus,
.single-blog-comment__form input:focus {
  border-color: rgba(42, 77, 251, 0.45);
  box-shadow: 0 0 0 3px rgba(42, 77, 251, 0.12);
}

.single-blog-comment__form textarea::placeholder,
.single-blog-comment__form input::placeholder {
  color: #a0a2ac;
}

.single-blog-comment__row {
  display: grid;
  gap: 12px;
  grid-template-columns: 1fr;
  margin-top: 12px;
}

.single-blog-comment__submit {
  margin-top: 16px;
  border: 0;
  cursor: pointer;
}

.single-blog-sidebar {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.blog-widget {
  padding: 22px;
  border: 1px solid rgba(42, 77, 251, 0.08);
  border-radius: 20px;
  background: var(--color-surface);
}

.blog-widget--search {
  padding: 0;
  border: 0;
  background: transparent;
}

.blog-widget__title {
  margin: 0 0 14px;
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: var(--color-ink);
}

.blog-widget__list {
  margin: 0;
  padding: 0;
  list-style: none;
}

.blog-widget__list li {
  border-bottom: 1px solid rgba(42, 77, 251, 0.08);
}

.blog-widget__list li:last-child {
  border-bottom: 0;
}

.blog-widget__list a {
  align-items: center;
  border-left: 2px solid transparent;
  color: var(--color-muted);
  display: flex;
  font-size: 13px;
  gap: 12px;
  justify-content: space-between;
  line-height: 1.5;
  padding: 12px 0 12px 12px;
  text-decoration: none;
  transition: color 0.2s ease, border-color 0.2s ease;
}

.blog-widget__list a:hover,
.blog-widget__list a.is-active {
  border-color: rgba(42, 77, 251, 0.4);
  color: var(--color-brand-start);
}

.blog-widget__count {
  background: rgba(42, 77, 251, 0.08);
  border-radius: 999px;
  color: inherit;
  flex: 0 0 auto;
  font-size: 11px;
  font-weight: 700;
  line-height: 1;
  min-width: 1.75rem;
  padding: 5px 8px;
  text-align: center;
}

.blog-search {
  position: relative;
  display: flex;
  align-items: center;
}

.blog-search input {
  width: 100%;
  padding: 14px 48px 14px 16px;
  border: 1px solid rgba(42, 77, 251, 0.12);
  border-radius: 14px;
  background: #fff;
  color: var(--color-ink);
  font: inherit;
  font-size: 14px;
  outline: none;
  box-shadow: 3px 7px 12px -6px #11182714;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.blog-search input:focus {
  border-color: rgba(42, 77, 251, 0.45);
  box-shadow: 0 0 0 3px rgba(42, 77, 251, 0.12);
}

.blog-search input::placeholder {
  color: #a0a2ac;
}

.blog-search button {
  position: absolute;
  right: 6px;
  top: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border: 0;
  border-radius: 50%;
  background: linear-gradient(90deg, var(--color-brand-start), var(--color-brand-deep));
  color: #fff;
  cursor: pointer;
  transform: translateY(-50%);
  transition: filter 0.2s ease;
}

.blog-search button:hover {
  filter: brightness(1.08);
}

.blog-top-posts {
  margin: 0;
  padding: 0;
  list-style: none;
}

.blog-top-posts li {
  display: grid;
  grid-template-columns: 28px minmax(0, 1fr);
  gap: 12px;
  align-items: start;
  padding: 14px 0;
  border-bottom: 1px solid rgba(42, 77, 251, 0.08);
}

.blog-top-posts li:first-child {
  padding-top: 0;
}

.blog-top-posts li:last-child {
  padding-bottom: 0;
  border-bottom: 0;
}

.blog-top-posts__num {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: linear-gradient(90deg, var(--color-brand-start), var(--color-brand-end));
  color: #fff;
  font-size: 13px;
  font-weight: 700;
  line-height: 1;
}

.blog-top-posts__body a {
  display: block;
  font-size: 14px;
  font-weight: 700;
  line-height: 1.4;
  color: var(--color-ink);
  text-decoration: none;
  transition: color 0.2s ease;
}

.blog-top-posts__body a:hover {
  color: var(--color-brand-start);
}

.blog-top-posts__body p {
  display: -webkit-box;
  margin: 6px 0 0;
  overflow: hidden;
  font-size: 12px;
  line-height: 1.5;
  color: #85868c;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
}

.blog-widget--slider {
  overflow: hidden;
}

.blogSidebarSwiper {
  width: 100%;
  overflow: hidden;
}

.blog-sidebar-card {
  margin: 0;
  height: 100%;
  padding: 8px;
}

.blog-sidebar-card h3 {
  display: -webkit-box;
  overflow: hidden;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
}

.blog-sidebar-slider__pagination {
  display: flex;
  justify-content: center;
  gap: 6px;
  margin-top: 12px;
}

@media (prefers-reduced-motion: reduce) {
  .single-blog-nav__btn:hover {
    transform: none;
  }
}

@media (min-width: 1024px) {

  .single-blog-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 320px;
    gap: 56px;
    align-items: start;
  }

  .single-blog-sidebar {
    position: sticky;
    top: 100px;
    align-self: start;
  }
}

@media (max-width: 767px) {
  .single-blog-layout {
    gap: 36px;
  }

  .single-blog-footer {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>
@endpush

@push('scripts')
<script>
(function () {
  var roots = document.querySelectorAll('[data-blog-share]');

  var setOpen = function (root, open) {
    var toggle = root.querySelector('[data-blog-share-toggle]');
    root.classList.toggle('is-open', open);
    if (toggle) {
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
  };

  roots.forEach(function (root) {
    var toggle = root.querySelector('[data-blog-share-toggle]');
    if (toggle) {
      toggle.addEventListener('click', function (event) {
        event.stopPropagation();
        setOpen(root, !root.classList.contains('is-open'));
      });
    }

    root.querySelectorAll('[data-blog-share-copy]').forEach(function (button) {
      button.addEventListener('click', function () {
        var url = button.getAttribute('data-url') || window.location.href;
        var copied = root.querySelector('[data-blog-share-copied]');
        var showCopied = function () {
          if (!copied) return;
          copied.hidden = false;
          window.setTimeout(function () { copied.hidden = true; }, 2000);
        };
        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(url).then(showCopied).catch(function () {
            window.prompt('Copy this link', url);
          });
          return;
        }
        window.prompt('Copy this link', url);
      });
    });
  });

  document.addEventListener('click', function (event) {
    roots.forEach(function (root) {
      if (!root.contains(event.target)) {
        setOpen(root, false);
      }
    });
  });

  document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;
    roots.forEach(function (root) {
      setOpen(root, false);
    });
  });

  var agent = document.querySelector('[data-suave-agent]');
  if (agent && window.MutationObserver) {
    new MutationObserver(function () {
      if (agent.classList.contains('is-open')) {
        roots.forEach(function (root) {
          setOpen(root, false);
        });
      }
    }).observe(agent, { attributes: true, attributeFilter: ['class'] });
  }
})();

window.suaveWhenSwiperReady(function () {
  document.querySelectorAll('.blogSidebarSwiper:not(.swiper-initialized)').forEach(function (el) {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    new Swiper(el, {
      slidesPerView: 1,
      spaceBetween: 12,
      speed: 550,
      loop: el.querySelectorAll('.swiper-slide').length > 1,
      watchOverflow: true,
      allowTouchMove: true,
      grabCursor: true,
      autoplay: reduceMotion ? false : {
        delay: 3500,
        disableOnInteraction: false,
        pauseOnMouseEnter: true
      },
      pagination: {
        el: el.querySelector('.blog-sidebar-slider__pagination'),
        clickable: true
      },
      a11y: {
        containerMessage: 'More blog articles carousel'
      },
      keyboard: {
        enabled: true,
        onlyInViewport: true
      }
    });
  });
});
</script>
@endpush
