<section class="full-bleed bg-white section-pad-m py-6 lg:py-20" aria-labelledby="agile-process-title" data-agile-process>
  <div class="section-inner">
    <header class="mx-auto mb-8 max-w-[720px] text-center sm:mb-10 lg:mb-12">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">
        Need it simpler and faster? We have a solution for you!</p>
      <h2 id="agile-process-title"
        class="home-type-h2 mt-3 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:mt-4 lg:text-[24px] lg:leading-[36px]">
        {{ $title }}</h2>
      <p class="mx-auto mt-3 max-w-[560px] text-[13px] leading-[18px] text-[#4D4D4D] sm:mt-4 sm:text-[14px] sm:leading-5">
        {{ $subtitle }}
      </p>
    </header>
    <div class="agile-process-tabs swiper mb-8 sm:mb-10" data-agile-tabs>
      <div class="swiper-wrapper agile-process-tabs__list" role="tablist" aria-label="Agile process phases">
        @foreach (array_keys($phases) as $ti => $tab)
          <div class="swiper-slide agile-process-tabs__slide">
            <button type="button"
              class="agile-process-tabs__tab shrink-0 cursor-pointer rounded-full border border-[rgba(42,77,251,0.16)] bg-white px-5 py-2.5 text-[13px] font-semibold text-[#4D4D4D] transition hover:border-[rgba(42,77,251,0.4)] hover:text-[#171717] aria-selected:border-transparent aria-selected:bg-gradient-to-r aria-selected:from-[#2A4DFB] aria-selected:to-[#7A5FF8] aria-selected:text-white aria-selected:shadow-[0_10px_24px_rgba(42,77,251,0.28)]"
              role="tab" aria-selected="{{ $ti === 0 ? 'true' : 'false' }}"
              data-agile-tab="{{ $tab }}">{{ $tab }}</button>
          </div>
        @endforeach
      </div>
      <nav class="agile-process-tabs__pagination" aria-label="Process phases pagination"></nav>
    </div>
    @foreach ($phases as $tab => $items)
      <div role="tabpanel" data-agile-panel="{{ $tab }}" {{ $loop->first ? '' : 'hidden' }}>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
          @foreach ($items as $item)
            @php
              $iconAlt = ($item['title'] ?? 'Agile process').' icon for Suave Creators industry development';
            @endphp
            <article class="flex min-h-full flex-col gap-3 rounded-[20px] border border-[rgba(42,77,251,0.08)] bg-white p-[22px] shadow-[0_18px_40px_rgba(36,36,84,0.06)] transition hover:-translate-y-1 hover:shadow-[0_22px_48px_rgba(36,36,84,0.1)]">
              <span class="inline-flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#EEF1FF]"><img
                  src="{{ $item['icon'] ?? asset('assets/icons/agile-icon-1.svg') }}"
                  alt="{{ $iconAlt }}" title="{{ $iconAlt }}"
                  width="24" height="24" class="h-6 w-6 object-contain" loading="lazy"></span>
              <h3 class="text-[14px] font-semibold leading-[18px] text-[#171717]">{{ $item['title'] ?? '' }}</h3>
              <p class="text-[13px] leading-[18px] text-[#4D4D4D]">{{ $item['desc'] ?? '' }}</p>
            </article>
          @endforeach
        </div>
      </div>
    @endforeach
    <div class="mt-10 flex flex-nowrap items-center justify-center gap-3 sm:gap-5">
      <x-frontend.cta-button :href="$demoHref" class="shrink-0">Let's Connect to Discuss</x-frontend.cta-button>
      <a href="{{ $demoHref }}"
        class="inline-flex shrink-0 items-center border-b border-[#00003F] text-sm font-semibold text-[#00003F]">Book
        a Call</a>
    </div>
  </div>
</section>

@once
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var agileRoot = document.querySelector('[data-agile-process]');
        if (!agileRoot) return;

        var tabs = agileRoot.querySelectorAll('[data-agile-tab]');
        var panels = agileRoot.querySelectorAll('[data-agile-panel]');
        var tabsEl = agileRoot.querySelector('[data-agile-tabs]');
        var tabsMq = window.matchMedia('(max-width: 767px)');
        var tabsSwiper = null;

        tabs.forEach(function (tab, index) {
          tab.addEventListener('click', function () {
            var key = tab.getAttribute('data-agile-tab');
            tabs.forEach(function (t) {
              t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
            });
            panels.forEach(function (p) {
              if (p.getAttribute('data-agile-panel') === key) p.removeAttribute('hidden');
              else p.setAttribute('hidden', '');
            });
            if (tabsSwiper) {
              tabsSwiper.slideTo(index, 300);
            }
          });
        });

        window.suaveWhenSwiperReady(function () {
          function syncAgileTabsSwiper() {
            if (tabsMq.matches) {
              if (tabsSwiper) return;
              tabsSwiper = new Swiper(tabsEl, {
                slidesPerView: 3,
                spaceBetween: 8,
                slidesPerGroup: 1,
                grabCursor: true,
                allowTouchMove: true,
                simulateTouch: true,
                watchOverflow: true,
                touchStartPreventDefault: false,
                pagination: {
                  el: tabsEl.querySelector('.agile-process-tabs__pagination'),
                  clickable: true
                },
                a11y: {
                  enabled: true,
                  containerMessage: 'Agile process phases'
                }
              });
              return;
            }

            if (tabsSwiper) {
              tabsSwiper.destroy(true, true);
              tabsSwiper = null;
            }
          }

          syncAgileTabsSwiper();
          if (typeof tabsMq.addEventListener === 'function') {
            tabsMq.addEventListener('change', syncAgileTabsSwiper);
          } else if (typeof tabsMq.addListener === 'function') {
            tabsMq.addListener(syncAgileTabsSwiper);
          }
        });
      });
    </script>
  @endpush
@endonce
