@props([
    'items' => null,
    'eyebrow' => 'Testimonial',
    'title' => 'Words That Inspire Us',
    'subtitle' => 'Our clients\' feedback reflects the trust, partnership, and measurable results we deliver—from ambitious startups to established organizations.',
    'headingId' => 'testimonials-title',
])

@php
    $items ??= [
        [
            'quote' => 'Working with this team was one of the best business decisions we made. They understood our vision and delivered a website that performs exceptionally well.',
            'name' => 'Saurabh Singh Shah',
            'role' => 'Founder, NorthRose Technologies',
            'initials' => 'SS',
            'avatar' => '/images/team-2.png',
        ],
        [
            'quote' => 'The communication was clear from the start, and every milestone arrived with thoughtful solutions. Our new platform is faster, easier to use, and ready to scale.',
            'name' => 'Ananya Mehta',
            'role' => 'Operations Director',
            'initials' => 'AM',
            'avatar' => '/images/team-5.png',
        ],
        [
            'quote' => 'They combined strong product thinking with excellent engineering. The result has improved our workflow and given our customers a much smoother experience.',
            'name' => 'Daniel Carter',
            'role' => 'Co-founder, Vertex Labs',
            'initials' => 'DC',
            'avatar' => '/images/team-3.png',
        ],
        [
            'quote' => 'From discovery to launch, the team felt like an extension of our own company. They challenged assumptions and kept the project focused on real business outcomes.',
            'name' => 'Priya Nair',
            'role' => 'Head of Digital',
            'initials' => 'PN',
            'avatar' => '/images/team-6.png',
        ],
    ];
@endphp

<!-- Testimonial Section Start -->
<section
  {{ $attributes->merge(['class' => "full-bleed testimonial-section bg-[url('/images/testimonial-bg.png')] bg-cover bg-top bg-no-repeat relative overflow-hidden py-12 lg:py-24"]) }}
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
        @foreach ($items as $index => $testimonial)
          <div class="swiper-slide">
            <article class="testimonial-card flex h-full flex-col justify-between rounded-lg border border-white/10 p-6">
              <div>
                <span class="text-sm font-bold text-[#2A4DFB]">/{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                <div class="mt-2 tracking-[3px] text-[#FFC107] text-[20px]" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="mt-4 text-sm font-medium leading-6 text-[#FAFBFA]">{{ $testimonial['quote'] }}</p>
              </div>
              <div class="mt-6 flex items-center gap-4">
                <span class="testimonial-card__initials grid h-14 w-14 shrink-0 place-items-center rounded-full bg-gradient-to-br from-[#2A4DFB] to-[#7A5FF8] text-sm font-bold text-white">{{ $testimonial['initials'] }}</span>
                <img class="testimonial-card__avatar" src="{{ $testimonial['avatar'] }}"
                  alt="{{ $testimonial['name'] }}" width="56" height="56" loading="lazy">
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
