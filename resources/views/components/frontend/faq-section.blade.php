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
        <x-frontend.faq-cta-button :href="$ctaHref" :label="$ctaLabel" />
      @endif

      @if (filled($media))
        @if ($resolvedMediaType === 'video')
          <video
            class="faq-section__image"
            src="{{ $media }}"
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
            src="{{ $media }}"
            alt="{{ $mediaAlt }}"
            width="640"
            height="960"
            loading="lazy">
        @endif
      @endif
    </div>

    @if (count($qa) > 0)
      <div class="faq-list">
        @foreach ($qa as $index => $item)
          @php $faqNumber = $index + 1; @endphp
          <div class="faq-item{{ $index === 0 ? ' is-open' : '' }}">
            <button type="button" class="faq-item__summary"
              aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
              aria-controls="faq-answer-{{ $faqNumber }}"
              id="faq-question-{{ $faqNumber }}">
              <span>{{ $item['question'] }}</span>
              <i class="fa-solid fa-chevron-down faq-item__chevron" aria-hidden="true"></i>
            </button>
            <div class="faq-item__answer" id="faq-answer-{{ $faqNumber }}" role="region"
              aria-labelledby="faq-question-{{ $faqNumber }}"
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

      answer.style.height = '0px';
      answer.offsetHeight;
      answer.style.height = answer.scrollHeight + 'px';

      const onHeightEnd = function (event) {
        if (event.propertyName !== 'height') return;
        if (faqAnimationTokens.get(item) === token && item.classList.contains('is-open')) {
          answer.style.height = 'auto';
        }
        clearFaqTransitionHandler(answer);
      };

      faqTransitionHandlers.set(answer, onHeightEnd);
      answer.addEventListener('transitionend', onHeightEnd);

      window.setTimeout(function () {
        if (faqAnimationTokens.get(item) === token && item.classList.contains('is-open')) {
          answer.style.height = 'auto';
          clearFaqTransitionHandler(answer);
        }
      }, 400);
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

      if (answer.style.height === 'auto' || !answer.style.height) {
        answer.style.height = answer.scrollHeight + 'px';
      }
      answer.offsetHeight;
      item.classList.remove('is-open');
      setFaqAria(item, false);
      answer.style.height = '0px';

      const onHeightEnd = function (event) {
        if (event.propertyName !== 'height') return;
        if (faqAnimationTokens.get(item) === token) {
          clearFaqTransitionHandler(answer);
        }
      };

      faqTransitionHandlers.set(answer, onHeightEnd);
      answer.addEventListener('transitionend', onHeightEnd);

      window.setTimeout(function () {
        if (faqAnimationTokens.get(item) === token) {
          clearFaqTransitionHandler(answer);
        }
      }, 400);
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
