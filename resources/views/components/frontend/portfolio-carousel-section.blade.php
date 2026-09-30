<section class="full-bleed portfolio-showcase portfolio-hero-showcase overflow-hidden bg-[linear-gradient(180deg,#F8FAFF_0%,#FFFFFF_100%)] section-pad-m !py-6 md:!py-14" aria-labelledby="service-portfolio-heading">
  <div class="section-inner">
    <header class="mx-auto mb-10 max-w-[720px] text-center lg:mb-12">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $eyebrow }}</p>
      <h2 id="service-portfolio-heading" class="mt-4 home-type-h2 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">{{ $title }}</h2>
      <p class="mx-auto mt-4 max-w-[560px] text-[14px] leading-5 text-[#4D4D4D]">{{ $description }}</p>
    </header>
    <div class="service-portfolio-rail portfolio-hero-rail">
      <div class="swiper servicePortfolioSwiper !overflow-hidden" aria-label="Project showcase carousel">
        <div class="swiper-wrapper">
          @foreach ($items as $item)
            <div class="swiper-slide h-auto">
              @if ($item['url'] !== '')
                <a href="{{ $item['url'] }}" class="portfolio-showcase__link block h-full w-full" @if ($item['external']) target="_blank" rel="noopener noreferrer" @endif aria-label="{{ $item['alt'] }}">
                  <figure class="portfolio-showcase__image h-full w-full">
                    <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" title="{{ $item['alt'] }}" loading="lazy" draggable="false">
                  </figure>
                </a>
              @else
                <figure class="portfolio-showcase__image h-full w-full">
                  <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" title="{{ $item['alt'] }}" loading="lazy" draggable="false">
                </figure>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="portfolio-hero-pagination"></div>
    @if ($slot->isNotEmpty())
      {{ $slot }}
    @else
      <div class="mt-10 flex flex-col items-center justify-center gap-4">
        <x-frontend.inline-consultation-form
          theme="light"
          placeholder="Enter your phone or email"
          button-text="Get Free Consultation"
          :secondary-href="$demoHref"
          secondary-label="Book a Call" />
      </div>
    @endif
  </div>
</section>

@once
  @push('scripts')
    <script>
      window.suaveWhenSwiperReady(function () {
        if (!document.querySelector('.servicePortfolioSwiper')) return;
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
        new Swiper('.servicePortfolioSwiper', {
          slidesPerView: 1,
          spaceBetween: 16,
          speed: 700,
          rewind: true,
          allowTouchMove: true,
          simulateTouch: true,
          grabCursor: true,
          touchEventsTarget: 'container',
          touchStartPreventDefault: false,
          watchOverflow: true,
          autoplay: reduce.matches
            ? false
            : { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: true },
          pagination: {
            el: '.portfolio-hero-pagination',
            clickable: true
          },
          a11y: {
            enabled: true,
            containerMessage: 'Project showcase carousel'
          },
          breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 18 },
            1024: { slidesPerView: 4, spaceBetween: 20 }
          }
        });
      });
    </script>
  @endpush
@endonce
