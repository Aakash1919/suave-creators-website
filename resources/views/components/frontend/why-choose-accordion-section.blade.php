<section class="full-bleed overflow-hidden bg-[#F9FAFC] bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20" style="background-image: url('{{ asset('assets/background/offerings-section-bg.webp') }}')" aria-labelledby="service-why-heading">
  <div class="section-inner">
    <header class="mx-auto mb-10 max-w-[720px] text-center lg:mb-14">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $eyebrow }}</p>
      <h2 id="service-why-heading" class="mt-4 home-type-h2 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">{{ $title }}</h2>
      <p class="mx-auto mt-4 max-w-[560px] text-[14px] leading-5 text-[#4D4D4D]">{{ $description }}</p>
    </header>
    <div class="why-choose-list lg:hidden" role="list">
      @foreach ($cards as $index => $card)
        @php
          $n = $index + 1;
          $isOpen = $index === 0;
        @endphp
        <article class="why-choose-item{{ $isOpen ? ' is-open' : '' }}" role="listitem">
          <button
            type="button"
            class="why-choose-item__summary"
            id="service-why-q-{{ $n }}"
            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
            aria-controls="service-why-panel-{{ $n }}"
          >
            <span class="why-choose-item__top">
              <span class="why-choose-item__index">{{ str_pad((string) $n, 2, '0', STR_PAD_LEFT) }}</span>
              <span class="why-choose-item__toggle" aria-hidden="true"></span>
            </span>
            <span class="why-choose-item__title">{{ $card['title'] ?? '' }}</span>
            @if ($card['tags'])
              <span class="why-choose-item__tags">{{ implode(' • ', $card['tags']) }}</span>
            @endif
          </button>
          <div
            class="why-choose-item__panel"
            id="service-why-panel-{{ $n }}"
            role="region"
            aria-labelledby="service-why-q-{{ $n }}"
            aria-hidden="{{ $isOpen ? 'false' : 'true' }}"
          >
            <div class="why-choose-item__panel-inner">
              @if (!empty($card['image']))
                <figure class="why-choose-item__image">
                  <img src="{{ $card['image'] }}" alt="{{ $card['imageAlt'] }}" title="{{ $card['imageAlt'] }}" class="h-full w-full object-cover" width="640" height="400" loading="{{ $isOpen ? 'eager' : 'lazy' }}">
                </figure>
              @endif
              @if (!empty($card['text']))
                <p class="why-choose-item__text">{{ $card['text'] }}</p>
              @endif
              @if ($card['features'])
                <ul class="why-choose-item__features">
                  @foreach ($card['features'] as $feature)
                    <li>{{ $feature }}</li>
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        </article>
      @endforeach
    </div>
    <div class="hidden grid-cols-1 gap-5 sm:grid-cols-2 lg:grid lg:grid-cols-3 lg:gap-6">
      @foreach ($cards as $card)
        <article class="flex min-h-full flex-col gap-3 overflow-hidden rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          @if (!empty($card['image']))
            <figure class="aspect-[16/10] overflow-hidden"><img src="{{ $card['image'] }}" alt="{{ $card['imageAlt'] }}" title="{{ $card['imageAlt'] }}" class="h-full w-full object-cover" loading="lazy"></figure>
          @endif
          <div class="flex flex-1 flex-col gap-3 p-[22px]">
            <h3 class="text-[14px] font-semibold leading-[18px] text-[#171717]">{{ $card['title'] ?? '' }}</h3>
            <p class="flex-1 text-[14px] leading-5 text-[#4D4D4D]">{{ $card['text'] ?? '' }}</p>
          </div>
        </article>
      @endforeach
    </div>
    <div class="mt-10 flex justify-center">
      <x-frontend.cta-button :href="$buttonHref">
        {{ $buttonLabel }}
      </x-frontend.cta-button>
    </div>
  </div>
</section>

@once
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
        var whyItems = document.querySelectorAll('.why-choose-list .why-choose-item');
        function setWhyAria(item, open) {
          item.querySelector('.why-choose-item__summary').setAttribute('aria-expanded', open ? 'true' : 'false');
          item.querySelector('.why-choose-item__panel').setAttribute('aria-hidden', open ? 'false' : 'true');
        }
        function openWhy(item) {
          var panel = item.querySelector('.why-choose-item__panel');
          item.classList.add('is-open');
          setWhyAria(item, true);
          if (reduce.matches) { panel.style.height = 'auto'; return; }
          panel.style.height = panel.getBoundingClientRect().height + 'px';
          panel.offsetHeight;
          panel.style.height = panel.scrollHeight + 'px';
          panel.addEventListener('transitionend', function once(e) {
            if (e.propertyName === 'height' && item.classList.contains('is-open')) {
              panel.style.height = 'auto';
              panel.removeEventListener('transitionend', once);
            }
          });
        }
        function closeWhy(item) {
          var panel = item.querySelector('.why-choose-item__panel');
          if (reduce.matches) {
            item.classList.remove('is-open');
            setWhyAria(item, false);
            panel.style.height = '0px';
            return;
          }
          panel.style.height = (panel.style.height === 'auto' ? panel.scrollHeight : panel.getBoundingClientRect().height) + 'px';
          panel.offsetHeight;
          item.classList.remove('is-open');
          setWhyAria(item, false);
          requestAnimationFrame(function () { panel.style.height = '0px'; });
        }
        whyItems.forEach(function (item) {
          var panel = item.querySelector('.why-choose-item__panel');
          var open = item.classList.contains('is-open');
          panel.style.transition = 'none';
          panel.style.height = open ? 'auto' : '0px';
          setWhyAria(item, open);
        });
        if (whyItems.length) whyItems[0].offsetHeight;
        whyItems.forEach(function (item) {
          var panel = item.querySelector('.why-choose-item__panel');
          panel.style.removeProperty('transition');
          item.querySelector('.why-choose-item__summary').addEventListener('click', function () {
            var should = !item.classList.contains('is-open');
            whyItems.forEach(function (sibling) {
              if (sibling !== item && sibling.classList.contains('is-open')) closeWhy(sibling);
            });
            if (should) openWhy(item); else closeWhy(item);
          });
        });
      });
    </script>
  @endpush
@endonce
