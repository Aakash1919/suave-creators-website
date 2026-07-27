<section {{ $attributes->merge(['class' => $sectionClass]) }} aria-labelledby="{{ $titleId }}">
  <div class="smart-together-cta__inner section-inner">
    <div class="smart-together-cta__eyebrow mb-4 flex items-center gap-2">
      <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
        aria-hidden="true"></span>
      <span
        class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        {{ $eyebrow }}
      </span>
    </div>

    <div class="smart-together-cta__copy">
      <h2 id="{{ $titleId }}">{{ $title }}</h2>
      <p>{{ $description }}</p>
    </div>

    <div class="smart-together-cta__actions flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:gap-3">
      <a href="{{ $primaryHref }}"
        class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110">
        {{ $primaryLabel }}
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
          <path d="M18 8L22 12L18 16"></path>
          <path d="M2 12H22"></path>
        </svg>
      </a>
      @if ($secondaryLabel !== '')
        <a href="{{ $secondaryHref }}"
          class="inline-flex items-end border-b border-white/70 pb-0.5 text-sm font-semibold text-white max-lg:min-h-[44px]">
          {{ $secondaryLabel }}
        </a>
      @endif
    </div>

    @if ($showPhone)
      <span class="smart-together-cta__phone">
        <img src="{{ asset($phoneImage) }}" alt="{{ $phoneAlt }}" title="{{ $phoneAlt }}" class="rounded-[10px]"
          decoding="async" loading="lazy">
      </span>
    @endif
  </div>
</section>
