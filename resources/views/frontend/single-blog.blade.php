@extends('layouts.frontend')

@section('seo')
  <x-layouts.seo
    :title="$seoTitle"
    :description="$seoDescription"
    :og-title="$seoTitle"
    :og-description="$seoDescription"
    :canonical="url()->current()"
    :og-url="url()->current()"
  />
@endsection

@section('content')


<!-- Single Blog Hero Section Start -->
<section class="single-blog-top relative z-10 w-full pb-10 pt-6 md:pb-14 md:pt-8 lg:pb-16 site-container">
  <nav class="blog-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span aria-hidden="true">/</span>
    <a href="{{ route('blogs') }}">Blogs</a>
    <span aria-hidden="true">/</span>
    <span aria-current="page">{{ $post['title'] }}</span>
  </nav>

  <h1 class="single-blog-main__title">
    @if ($titleLead !== '')
      {{ $titleLead }}
    @endif
    <span class="single-blog-main__title-accent">{{ $titleAccent }}</span>
  </h1>

  <p class="single-blog-main__meta">
    <span>
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
      By {{ $post['author_name'] }}
    </span>
    <span>
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
      <time datetime="{{ $post['published_date'] }}">{{ $post['published_label'] }}</time>
    </span>
    <span class="single-blog-main__category">{{ $post['category'] }}</span>
  </p>
</section>
<!-- Single Blog Hero Section End -->

<!-- Single Blog Article Section Start -->
<section class="full-bleed bg-white py-12 md:py-16 lg:py-20" aria-label="Blog article">
  <div class="section-inner">
    <div class="single-blog-layout">
      <article class="single-blog-main">
        <div class="single-blog-content">
          {{ $articleContent }}
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
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
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
                  <a href="{{ route('blogs') }}">{{ $category }}</a>
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
                    <a href="{{ route('blog.' . $item['slug']) }}">{{ $item['title'] }}</a>
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
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" title="{{ $item['title'] }}" width="640" height="420" loading="lazy">
                      </figure>
                      <div class="articles-card__body">
                        <div class="articles-card__meta">
                          <span class="articles-card__byline">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 24 24" fill="none" stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                              <circle cx="12" cy="8" r="5" />
                              <path d="M20 21a8 8 0 0 0-16 0" />
                            </svg>
                            {{ $item['author_name'] }}
                          </span>
                          <time datetime="{{ $item['published_date'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 24 24" fill="none" stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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
                        <a class="articles-card__link underline mt-2 text-sm font-semibold text-[#2A4DFB]" href="{{ route('blog.' . $item['slug']) }}">Read More</a>
                      </div>
                    </article>
                  </div>
                @endforeach
              </div>
              <div class="blog-sidebar-slider__pagination" aria-label="Blog cards pagination"></div>
            </div>
          </div>
        @endif
      </aside>
    </div>
  </div>
</section>
<!-- Single Blog Article Section End -->

@php
$blogFaqs = !empty($post['faqs']) ? $post['faqs'] : array(
  array(
    'question' => 'How can Suave Creators help after reading this article?',
    'answer' => 'Share your goals with our team and we will map a practical next step — from strategy and design through to build and launch.',
  ),
  array(
    'question' => 'Do you work with startups and established businesses?',
    'answer' => 'Yes. We partner with early-stage teams and growing organisations that need reliable product, design, and engineering support.',
  ),
  array(
    'question' => 'How soon can we start a discovery conversation?',
    'answer' => 'Most teams hear back within one business day. Book a free consultation and we will align on scope, timeline, and the best way to begin.',
  ),
);
@endphp

<x-frontend.faq-section
  :qa="$blogFaqs"
  heading-id="blog-faq-heading"
  eyebrow="Questions before you get started?"
  description="Here are the most asked questions based on feedback from our readers."
  cta-label="Book a Consultation"
  class="faq-section--align faq-section--contact bg-cover bg-top bg-no-repeat"
  style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}')"
/>

<x-frontend.consultation-section />





@endsection
@push('custom-css')
<style>
.blog-breadcrumb {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 18px;
  font-size: 13px;
  font-weight: 600;
  color: #b1b9df;
}

.blog-breadcrumb a {
  color: #b1b9df;
  text-decoration: none;
  transition: color 0.2s ease;
}

.blog-breadcrumb a:hover {
  color: #fff;
}

.blog-breadcrumb span[aria-current] {
  color: #fff;
}

.single-blog-top {
  padding-top: 12px;
}

.single-blog-top .single-blog-main__title {
  margin-top: 18px;
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
  margin: 28px 0 32px;
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
  font-size: 15px;
  line-height: 1.85;
  color: var(--color-muted);
}

.single-blog-content h2 {
  margin-top: 36px;
  margin-bottom: 14px;
  font-size: clamp(1.25rem, 3vw, 1.75rem);
  font-weight: 700;
  color: var(--color-ink);
  scroll-margin-top: 100px;
}

.single-blog-content h3 {
  margin-top: 26px;
  margin-bottom: 10px;
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--color-ink);
  scroll-margin-top: 100px;
}

.single-blog-content p {
  margin-bottom: 18px;
}

.single-blog-content ul,
.single-blog-content ol {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin: 0 0 18px 20px;
}

.single-blog-content li {
  line-height: 1.7;
}

.single-blog-content a {
  color: var(--color-brand-start);
  font-weight: 600;
  text-decoration: underline;
}

.single-blog-content blockquote {
  position: relative;
  margin: 40px 0;
  padding: 28px 28px 28px 32px;
  border: 1px solid rgba(42, 77, 251, 0.12);
  border-radius: 20px;
  background: linear-gradient(135deg, rgba(42, 77, 251, 0.05), rgba(122, 95, 248, 0.08));
  box-shadow: 0 14px 36px rgba(42, 77, 251, 0.06);
  text-align: left;
  font-size: clamp(1.05rem, 2.2vw, 1.25rem);
  font-weight: 700;
  line-height: 1.6;
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
  content: "\201C";
  position: absolute;
  top: 8px;
  right: 18px;
  font-size: 4.5rem;
  font-weight: 800;
  line-height: 1;
  background: linear-gradient(180deg, #2f69fb 15%, #c56bff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  opacity: 0.28;
  pointer-events: none;
}

.single-blog-content blockquote p {
  position: relative;
  z-index: 1;
  margin: 0;
  padding-right: 1.5rem;
}

.single-blog-content blockquote p::before,
.single-blog-content blockquote p::after {
  content: none;
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
  display: block;
  padding: 12px 0 12px 12px;
  border-left: 2px solid transparent;
  font-size: 13px;
  line-height: 1.5;
  color: var(--color-muted);
  text-decoration: none;
  transition: color 0.2s ease, border-color 0.2s ease;
}

.blog-widget__list a:hover {
  border-color: rgba(42, 77, 251, 0.4);
  color: var(--color-brand-start);
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
    grid-template-columns: minmax(0, 1fr) 300px;
    gap: 56px;
  }

  .single-blog-comment__row {
    grid-template-columns: repeat(3, minmax(0, 1fr));
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
document.addEventListener('DOMContentLoaded', function () {
  if (typeof Swiper !== 'undefined') {
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
  }
});
</script>
@endpush
