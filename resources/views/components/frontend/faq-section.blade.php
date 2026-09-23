@if (count($qa) > 0 || filled($media))
<section
  {{ $attributes->merge(['class' => 'full-bleed faq-section']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="faq-section__inner section-inner">
    <div class="faq-section__intro">
      @if (filled($eyebrow))
        <p class="faq-section__eyebrow mb-4 flex items-center gap-2">
          <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
            {{ $eyebrow }}
          </span>
        </p>
      @endif
      <h2 id="{{ $headingId }}">{{ $title }}</h2>
      @if (filled($description))
        <p class="faq-section__description">{{ $description }}</p>
      @endif

      @if ($showCta)
        <x-frontend.cta-button class="faq-section__cta" :href="$ctaHref">
          {{ $ctaLabel }}
        </x-frontend.cta-button>
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
            @if ($questionHeading === 'h3')
              <h3 class="faq-item__heading">
            @endif
            <button type="button" class="faq-item__summary"
              aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
              aria-controls="faq-answer-{{ $item['number'] }}"
              id="faq-question-{{ $item['number'] }}">
              <span>{{ $item['question'] }}</span>
              <i class="fa-solid fa-chevron-down faq-item__chevron" aria-hidden="true"></i>
            </button>
            @if ($questionHeading === 'h3')
              </h3>
            @endif
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
