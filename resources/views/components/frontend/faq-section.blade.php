@if (count($qa) > 0 || filled($media))
<section
  {{ $attributes->merge(['class' => 'full-bleed faq-section']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="faq-section__inner section-inner">
    <div class="faq-section__intro">
      <p class="faq-section__eyebrow mb-4 flex items-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
          {{ $eyebrow }}
        </span>
      </p>
      <h2 id="{{ $headingId }}">{{ $title }}</h2>
      @if (filled($description))
        <p class="faq-section__description">{{ $description }}</p>
      @endif

      @if ($showCta)
        <a href="{{ str_starts_with((string) $ctaHref, '#') || str_starts_with((string) $ctaHref, 'http') ? $ctaHref : (str_starts_with((string) $ctaHref, '/') ? $ctaHref : route($ctaHref)) }}"
          @if (str_starts_with((string) $ctaHref, 'http')) target="_blank" rel="noopener noreferrer" @endif
          class="faq-section__cta u-btn-cta group inline-flex w-fit cursor-pointer items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110">
          {{ $ctaLabel }}
          <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
            <path d="M18 8L22 12L18 16"></path>
            <path d="M2 12H22"></path>
          </svg>
        </a>
      @endif

      @if (filled($media))
        @if ($resolvedMediaType === 'video')
          <video
            class="faq-section__image"
            src="{{ asset($media) }}"
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
            aria-label="{{ $mediaAlt }}">
          </video>
        @else
          <x-frontend.responsive-webp-image
            class="faq-section__image"
            :src="$media"
            :alt="$mediaAlt"
            sizes="(min-width: 768px) 418px, 90vw"
            loading="lazy"
            decoding="async" />
        @endif
      @endif
    </div>

    @if (count($qa) > 0)
      <div class="faq-list">
        @foreach ($qa as $index => $item)
          <div class="faq-item{{ $index === 0 ? ' is-open' : '' }}">
            <button type="button" class="faq-item__summary"
              aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
              aria-controls="faq-answer-{{ $item['number'] }}"
              id="faq-question-{{ $item['number'] }}">
              <span>{{ $item['question'] }}</span>
              <i class="fa-solid fa-chevron-down faq-item__chevron" aria-hidden="true"></i>
            </button>
            <div class="faq-item__answer" id="faq-answer-{{ $item['number'] }}" role="region"
              aria-labelledby="faq-question-{{ $item['number'] }}"
              aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
              <div class="faq-item__answer-inner">
                <p>{{ $item['answer'] }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>

@once
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var faqItems = document.querySelectorAll('.faq-list .faq-item');
    if (!faqItems.length) return;

    function setFaqAria(item, isOpen) {
      var button = item.querySelector('.faq-item__summary');
      var answer = item.querySelector('.faq-item__answer');
      button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      answer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    }

    faqItems.forEach(function (item) {
      var button = item.querySelector('.faq-item__summary');

      button.addEventListener('click', function () {
        var shouldOpen = !item.classList.contains('is-open');

        faqItems.forEach(function (sibling) {
          if (sibling !== item && sibling.classList.contains('is-open')) {
            sibling.classList.remove('is-open');
            setFaqAria(sibling, false);
          }
        });

        item.classList.toggle('is-open', shouldOpen);
        setFaqAria(item, shouldOpen);
      });
    });
  });
</script>
@endpush
@endonce
@endif
