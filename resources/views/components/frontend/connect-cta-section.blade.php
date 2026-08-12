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

    <div class="smart-together-cta__actions flex flex-row flex-nowrap items-center gap-2 sm:gap-3">
      <x-frontend.cta-button :href="$primaryHref">
        {{ $primaryLabel }}
      </x-frontend.cta-button>
      @if ($secondaryLabel !== '')
        <a href="{{ $secondaryHref }}"
          @if (str_starts_with($secondaryHref, 'http')) target="_blank" rel="noopener noreferrer" @endif
          class="inline-flex shrink-0 cursor-pointer items-center border-b border-white/70 pb-px text-sm font-semibold text-white">
          {{ $secondaryLabel }}
        </a>
      @endif
    </div>

    @if ($showPhone)
      <span class="smart-together-cta__phone" aria-hidden="true">
        <video
          class="smart-together-cta__phone-video rounded-[10px]"
          width="140"
          height="140"
          autoplay
          muted
          loop
          playsinline
          preload="metadata"
          poster="{{ asset($phonePoster) }}"
          aria-label="{{ $phoneAlt }}">
          <source src="{{ asset($phoneVideo) }}" type="video/mp4">
        </video>
        <img
          class="smart-together-cta__phone-poster rounded-[10px]"
          src="{{ asset($phonePoster) }}"
          alt="{{ $phoneAlt }}"
          title="{{ $phoneAlt }}"
          width="140"
          height="140"
          decoding="async"
          loading="lazy">
      </span>
    @endif
  </div>
</section>
