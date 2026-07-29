@if (count($qa) > 0 || filled($media))
<section
  {{ $attributes->merge(['class' => 'full-bleed faq-section']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="faq-section__inner section-inner">
    <div class="faq-section__intro">
      <p class="faq-section__eyebrow flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent font-bold text-[14px]">
          {{ $eyebrow }}
        </span>
      </p>
      <h2 id="{{ $headingId }}">{{ $title }}</h2>
      @if (filled($description))
        <p class="faq-section__description">{{ $description }}</p>
      @endif

      @if ($showCta)
        <a href="{{ str_starts_with((string) $ctaHref, '#') || str_starts_with((string) $ctaHref, 'http') ? $ctaHref : (str_starts_with((string) $ctaHref, '/') ? $ctaHref : route($ctaHref)) }}"
          class="faq-section__cta group inline-flex w-fit cursor-pointer items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110">
          {{ $ctaLabel }}
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
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
          <img
            class="faq-section__image"
            src="{{ asset($media) }}"
            alt="{{ $mediaAlt }}" title="{{ $mediaAlt }}"
            width="418"
            height="244"
            loading="lazy"
            decoding="async">
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
    const faqItems = document.querySelectorAll('.faq-list .faq-item');
    if (!faqItems.length) return;

    const faqMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    const faqAnimationTokens = new WeakMap();
    const faqTransitionHandlers = new WeakMap();

    function nextFaqAnimationToken(item) {
      const token = (faqAnimationTokens.get(item) || 0) + 1;
      faqAnimationTokens.set(item, token);
      return token;
    }

    function clearFaqTransitionHandler(answer) {
      const handler = faqTransitionHandlers.get(answer);

      if (handler) {
        answer.removeEventListener('transitionend', handler);
        faqTransitionHandlers.delete(answer);
      }
    }

    function setFaqAria(item, isOpen) {
      const button = item.querySelector('.faq-item__summary');
      const answer = item.querySelector('.faq-item__answer');

      button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      answer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    }

    function openFaq(item) {
      const answer = item.querySelector('.faq-item__answer');
      const token = nextFaqAnimationToken(item);

      clearFaqTransitionHandler(answer);
      item.classList.add('is-open');
      setFaqAria(item, true);

      if (faqMotionQuery.matches) {
        answer.style.height = 'auto';
        return;
      }

      const startHeight = answer.getBoundingClientRect().height;
      answer.style.height = startHeight + 'px';
      answer.offsetHeight;

      const onHeightEnd = function (event) {
        if (
          event.propertyName === 'height' &&
          faqAnimationTokens.get(item) === token &&
          item.classList.contains('is-open')
        ) {
          answer.style.height = 'auto';
          clearFaqTransitionHandler(answer);
        }
      };

      faqTransitionHandlers.set(answer, onHeightEnd);
      answer.addEventListener('transitionend', onHeightEnd);

      requestAnimationFrame(function () {
        if (faqAnimationTokens.get(item) === token) {
          answer.style.height = answer.scrollHeight + 'px';
        }
      });
    }

    function closeFaq(item) {
      const answer = item.querySelector('.faq-item__answer');
      const token = nextFaqAnimationToken(item);

      clearFaqTransitionHandler(answer);

      if (faqMotionQuery.matches) {
        item.classList.remove('is-open');
        setFaqAria(item, false);
        answer.style.height = '0px';
        return;
      }

      const startHeight = answer.style.height === 'auto'
        ? answer.scrollHeight
        : answer.getBoundingClientRect().height;

      answer.style.height = startHeight + 'px';
      answer.offsetHeight;
      item.classList.remove('is-open');
      setFaqAria(item, false);

      const onHeightEnd = function (event) {
        if (
          event.propertyName === 'height' &&
          faqAnimationTokens.get(item) === token &&
          !item.classList.contains('is-open')
        ) {
          answer.style.height = '0px';
          clearFaqTransitionHandler(answer);
        }
      };

      faqTransitionHandlers.set(answer, onHeightEnd);
      answer.addEventListener('transitionend', onHeightEnd);

      requestAnimationFrame(function () {
        if (faqAnimationTokens.get(item) === token) {
          answer.style.height = '0px';
        }
      });
    }

    faqItems.forEach(function (item) {
      const answer = item.querySelector('.faq-item__answer');
      const isOpen = item.classList.contains('is-open');

      answer.style.transition = 'none';
      answer.style.height = isOpen ? 'auto' : '0px';
      setFaqAria(item, isOpen);
    });

    if (faqItems.length) {
      faqItems[0].offsetHeight;
    }

    faqItems.forEach(function (item) {
      const button = item.querySelector('.faq-item__summary');
      const answer = item.querySelector('.faq-item__answer');

      answer.style.removeProperty('transition');

      button.addEventListener('click', function () {
        const shouldOpen = !item.classList.contains('is-open');

        faqItems.forEach(function (sibling) {
          if (sibling !== item && sibling.classList.contains('is-open')) {
            closeFaq(sibling);
          }
        });

        if (shouldOpen) {
          openFaq(item);
        } else {
          closeFaq(item);
        }
      });
    });
  });
</script>
@endpush
@endonce
@endif
