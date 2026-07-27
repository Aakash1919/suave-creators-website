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
      <x-frontend.cta-button :href="$primaryHref">
        {{ $primaryLabel }}
      </x-frontend.cta-button>
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
