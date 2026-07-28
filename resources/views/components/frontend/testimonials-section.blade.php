<!-- Testimonial Section Start -->
<section
  {{ $attributes->merge(['class' => 'full-bleed testimonial-section bg-cover bg-top bg-no-repeat relative overflow-hidden py-12 lg:py-24']) }}
  style="background-image: url('{{ asset('assets/background/testimonials-section-bg.png') }}');"
  aria-labelledby="{{ $headingId }}">
  <div class="testimonial-layout section-inner relative z-10">
    <div class="testimonial-intro flex flex-col justify-between">
      <div>
        <div class="flex items-center gap-2">
          <span class="h-4 w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">
            {{ $eyebrow }}
          </span>
        </div>
        <h2 id="{{ $headingId }}" class="mt-4 text-2xl font-semibold text-white">{{ $title }}</h2>
        <p class="mt-5 max-w-sm text-sm leading-[22px] text-[#B1B9DF]">
          {{ $subtitle }}
        </p>
      </div>
    </div>

    <div class="testimonialSwiper swiper w-full">
      <div class="swiper-wrapper">
        @foreach ($items as $testimonial)
          <div class="swiper-slide">
            <article class="testimonial-card flex h-full flex-col justify-between rounded-lg border border-white/10 p-6">
              <div>
                <span class="text-sm font-bold text-[#2A4DFB]">/{{ $testimonial['number'] }}</span>
                <div class="mt-2 tracking-[3px] text-[#FFC107] text-[20px]" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="mt-4 text-sm font-medium leading-6 text-[#FAFBFA]">{{ $testimonial['quote'] }}</p>
              </div>
              <div class="mt-6 flex items-center gap-4">
                <span class="testimonial-card__initials grid h-14 w-14 shrink-0 place-items-center rounded-full bg-gradient-to-br from-[#2A4DFB] to-[#7A5FF8] text-sm font-bold text-white">{{ $testimonial['initials'] }}</span>
                <div>
                  <h3 class="font-semibold text-white">{{ $testimonial['name'] }}</h3>
                  <p class="mt-1 text-[13px] text-[#B1B9DF]">{{ $testimonial['role'] }}</p>
                </div>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    </div>

    <div class="testimonial-navigation">
      <button class="testimonial-prev" type="button" aria-label="Previous testimonial">
        <i class="fa-solid fa-chevron-left testimonial-prev__mobile" aria-hidden="true"></i>
        <i class="fa-solid fa-chevron-up testimonial-prev__desktop" aria-hidden="true"></i>
      </button>
      <div class="testimonial-pagination" aria-label="Testimonial pagination"></div>
      <button class="testimonial-next" type="button" aria-label="Next testimonial">
        <i class="fa-solid fa-chevron-right testimonial-next__mobile" aria-hidden="true"></i>
        <i class="fa-solid fa-chevron-down testimonial-next__desktop" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</section>
<!-- Testimonial Section End -->

@once
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper === 'undefined') return;

    document.querySelectorAll('.testimonialSwiper:not(.swiper-initialized)').forEach(function (el) {
      var root = el.closest('.testimonial-section') || el.parentElement;
      new Swiper(el, {
        direction: window.matchMedia('(min-width: 1024px)').matches ? 'vertical' : 'horizontal',
        slidesPerView: 1,
        spaceBetween: 16,
        loop: true,
        speed: 700,
        autoplay: { delay: 4500, disableOnInteraction: false, pauseOnMouseEnter: true },
        navigation: {
          nextEl: root.querySelector('.testimonial-next'),
          prevEl: root.querySelector('.testimonial-prev')
        },
        pagination: {
          el: root.querySelector('.testimonial-pagination'),
          clickable: true
        },
        breakpoints: { 1024: { slidesPerView: 2, spaceBetween: 24 } }
      });
    });
  });
</script>
@endpush
@endonce
