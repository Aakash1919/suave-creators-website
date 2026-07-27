@extends('layouts.frontend')

@section('content')
<section class="blogs-hero relative z-10 w-full pb-8 pt-6 md:pb-10 md:pt-8 lg:pb-12 lg:pt-10 site-container">
  <div class="mx-auto max-w-[900px] text-center">
    <p class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-sm font-bold uppercase tracking-wide text-transparent pragati-narrow-regular">Blogs &amp; Insights</p>
    <h1 class="mt-2 text-[34px] font-semibold leading-[1.15] text-white min-[375px]:text-[40px] sm:text-5xl lg:text-[52px]">
      Ideas, Strategy &amp; <span class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text pb-1 font-extrabold text-transparent">Engineering Insights</span>
    </h1>
    <p class="mt-4 text-sm leading-6 text-[#B1B9DF]">Practical articles from our team on digital strategy, product growth, AI, startups, and design — written to help you build better software.</p>
  </div>

  <div class="blogs-hero__gallery" aria-label="Featured workspace imagery">
    @foreach ($heroImages as $image)
      <figure class="blogs-hero__frame blogs-hero__frame--{{ $image['size'] }}">
        <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}" title="{{ $image['alt'] }}" width="440" height="560" loading="eager" decoding="async">
      </figure>
    @endforeach
  </div>
</section>

<section class="full-bleed bg-white py-16 lg:py-20" aria-label="All blog posts">
  <div class="section-inner">
    <div class="blog-grid">
      @foreach ($posts as $post)
        <article class="articles-card">
          <figure class="articles-card__image">
            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" title="{{ $post['title'] }}" width="1024" height="683" loading="lazy">
          </figure>
          <div class="articles-card__body">
            <div class="articles-card__meta">
              <span class="articles-card__byline">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 24 24" fill="none"
                  stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  aria-hidden="true">
                  <circle cx="12" cy="8" r="5" />
                  <path d="M20 21a8 8 0 0 0-16 0" />
                </svg>
                {{ $post['author_name'] }}
              </span>
              <time datetime="{{ $post['published_date'] }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 24 24" fill="none"
                  stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  aria-hidden="true">
                  <path d="M8 2v4" />
                  <path d="M16 2v4" />
                  <rect width="18" height="18" x="3" y="4" rx="2" />
                  <path d="M3 10h18" />
                </svg>
                {{ $post['published_label'] }}
              </time>
            </div>
            <h3>{{ $post['title'] }}</h3>
            <p>{{ $post['short_description'] }}</p>
            <a class="articles-card__link underline mt-2 text-sm font-semibold text-[#2A4DFB]"
              href="{{ $post['url'] }}">Read More</a>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>

<x-frontend.consultation-section
  title="Have an Idea? Let's Turn It<br class=&quot;hidden sm:block&quot;> Into a Digital Product"
  description="Whatever stage your business is at, our team is ready to help you plan, design, and build the right solution."
  cta-label="Get a Free Quote"
/>
@endsection
