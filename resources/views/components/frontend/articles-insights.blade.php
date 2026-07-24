@if (count($items) > 0)
<!-- Articles Insights Section Start -->
<section
  {{ $attributes->merge(['class' => "full-bleed articles-insights bg-[url('/images/blog-bg.png')] bg-cover bg-top bg-no-repeat relative overflow-hidden {$sectionClass}"]) }}
  aria-labelledby="{{ $headingId }}">
  <div class="articles-insights__inner section-inner">
    <div class="articles-insights__content">
      <header class="portfolio-showcase__header">
        <p
          class="offerings-eyebrow text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block leading-[100%]">
          {{ $eyebrow }}
        </p>
        <h2 id="{{ $headingId }}"
          class="mt-4 text-[20px] font-semibold leading-[36px] tracking-[-0.025em] text-[#171717] sm:text-[18px] lg:text-[24px]">
          {{ $title }}
        </h2>
        <p
          class="portfolio-showcase__intro mx-auto mt-2 max-w-[690px] text-[14px] leading-[24px] text-[#4D4D4D] sm:text-[14px]">
          {{ $subtitle }}
        </p>
      </header>

      <div class="articlesInsightsSwiper swiper">
        <div class="swiper-wrapper">
          @foreach ($items as $article)
            @php
              $articleTitle = (string) ($article['title'] ?? '');
              $excerpt = (string) ($article['excerpt'] ?? '');
              $image = (string) ($article['image'] ?? '/images/blog-1.png');
              $alt = (string) ($article['alt'] ?? $articleTitle);
              $date = (string) ($article['date'] ?? '');
              $datetime = (string) ($article['datetime'] ?? '');
              $author = (string) ($article['author'] ?? 'Suave Creators');
              $url = (string) ($article['url'] ?? '/blogs');
            @endphp
            <div class="swiper-slide">
              <article class="articles-card">
                <figure class="articles-card__image">
                  <img src="{{ $image }}" alt="{{ $alt }}" width="1024" height="683" loading="lazy">
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
                      {{ $author }}
                    </span>
                    @if ($date !== '')
                      <time datetime="{{ $datetime }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 24 24" fill="none"
                          stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          aria-hidden="true">
                          <path d="M8 2v4" />
                          <path d="M16 2v4" />
                          <rect width="18" height="18" x="3" y="4" rx="2" />
                          <path d="M3 10h18" />
                        </svg>
                        {{ $date }}
                      </time>
                    @endif
                  </div>
                  <h3>{{ $articleTitle }}</h3>
                  <p>{{ $excerpt }}</p>
                  <a class="articles-card__link underline mt-2 text-sm font-semibold text-[#2A4DFB]"
                    href="{{ $url }}">Read More</a>
                </div>
              </article>
            </div>
          @endforeach
        </div>
      </div>

      <footer class="articles-insights__footer">
        <button class="articles-insights-prev articles-insights__control" type="button"
          aria-label="Previous article">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <div class="articles-insights-pagination" aria-label="Articles pagination"></div>
        <a class="articles-insights__more" href="{{ $moreHref }}">{{ $moreLabel }}</a>
        <button class="articles-insights-next articles-insights__control" type="button"
          aria-label="Next article">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </footer>
    </div>
  </div>
</section>
<!-- Articles Insights Section End -->

@if ($initSwiper)
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper === 'undefined') return;
    document.querySelectorAll('.articlesInsightsSwiper:not(.swiper-initialized)').forEach(function (el) {
      var root = el.closest('.articles-insights');
      if (!root) return;
      new Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 16,
        speed: 500,
        rewind: true,
        allowTouchMove: true,
        simulateTouch: true,
        grabCursor: true,
        watchOverflow: true,
        keyboard: {
          enabled: true,
          onlyInViewport: true
        },
        a11y: {
          prevSlideMessage: 'Previous article',
          nextSlideMessage: 'Next article',
          containerMessage: 'Blogs and insights carousel'
        },
        navigation: {
          nextEl: root.querySelector('.articles-insights-next'),
          prevEl: root.querySelector('.articles-insights-prev')
        },
        pagination: {
          el: root.querySelector('.articles-insights-pagination'),
          clickable: true
        },
        breakpoints: {
          768: { slidesPerView: 2, spaceBetween: 20 },
          1024: { slidesPerView: 3, spaceBetween: 26 }
        }
      });
    });
  });
</script>
@endpush
@endif
@endif
