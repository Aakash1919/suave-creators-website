@if (count($items) > 0)
{{-- Case Studies Carousel (light, services pages) --}}
<section
  {{ $attributes->merge(['class' => trim("full-bleed case-studies-carousel bg-cover bg-top bg-no-repeat {$sectionClass}")]) }}
  style="background-image: url('{{ asset('assets/background/offerings-section-bg.webp') }}')"
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner case-studies-carousel__inner">
    <header class="case-studies-carousel__header">
      <p class="case-studies-carousel__eyebrow">
        <span class="case-studies-carousel__eyebrow-bar" aria-hidden="true"></span>
        <span class="case-studies-carousel__eyebrow-text">{{ $eyebrow }}</span>
      </p>
      <h2 id="{{ $headingId }}" class="case-studies-carousel__title">{{ $title }}</h2>
      @if ($subtitle !== '')
        <p class="case-studies-carousel__subtitle">{{ $subtitle }}</p>
      @endif
    </header>

    <div class="caseStudiesCarouselSwiper swiper case-studies-carousel__swiper">
      <div class="swiper-wrapper">
        @foreach ($items as $item)
          <div class="swiper-slide">
            <article class="case-studies-carousel__card">
              <div class="case-studies-carousel__copy">
                @if ($item['category'] !== '')
                  <p class="case-studies-carousel__category">{{ $item['category'] }}</p>
                @endif
                <h3 class="case-studies-carousel__card-title">{{ $item['title'] }}</h3>
                @if ($item['description'] !== '')
                  <p class="case-studies-carousel__desc">{{ $item['description'] }}</p>
                @endif
                @if (! empty($item['stats']))
                  <div class="case-studies-carousel__stats" aria-label="Key results">
                    @foreach ($item['stats'] as $stat)
                      <div class="case-studies-carousel__stat">
                        <span class="case-studies-carousel__stat-value">{{ $stat['value'] }}</span>
                        <span class="case-studies-carousel__stat-label">{{ $stat['label'] }}</span>
                      </div>
                    @endforeach
                  </div>
                @endif
                <x-frontend.cta-button :href="$item['url']" class="case-studies-carousel__cta">
                  {{ $ctaLabel }}
                </x-frontend.cta-button>
              </div>
              @if ($item['image'] !== '')
                <a href="{{ $item['url'] }}" class="case-studies-carousel__media">
                  <img
                    src="{{ $item['image'] }}"
                    alt="{{ $item['imageAlt'] }}"
                    title="{{ $item['imageAlt'] }}"
                    width="720"
                    height="520"
                    loading="lazy"
                    decoding="async"
                  >
                </a>
              @endif
            </article>
          </div>
        @endforeach
      </div>
    </div>

    <nav class="case-studies-carousel__pagination" aria-label="Case studies pagination"></nav>
  </div>
</section>

@if ($initSwiper)
@once
@push('scripts')
<script>
  window.suaveWhenSwiperReady(function () {
    document.querySelectorAll('.caseStudiesCarouselSwiper:not(.swiper-initialized)').forEach(function (el) {
      var root = el.closest('.case-studies-carousel');
      if (!root) return;
      new Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 16,
        speed: 550,
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
          prevSlideMessage: 'Previous case study',
          nextSlideMessage: 'Next case study',
          containerMessage: 'Case studies carousel'
        },
        pagination: {
          el: root.querySelector('.case-studies-carousel__pagination'),
          clickable: true
        }
      });
    });
  });
</script>
@endpush
@endonce
@endif
@endif
