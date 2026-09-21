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
      </aside>
    </div>
  </div>
</section>
<!-- Single Blog Article Section End -->

@if (! empty($faqs))
<x-frontend.faq-section
  :qa="$faqs"
  heading-id="blog-faq-heading"
  title="Frequently Asked Questions"
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

@push('scripts')
<script defer src="{{ asset('js/blog-share.js') }}?v={{ filemtime(public_path('js/blog-share.js')) }}"></script>
@endpush
