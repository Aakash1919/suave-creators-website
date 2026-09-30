<section {{ $attributes->merge(['class' => $sectionClass]) }} aria-labelledby="{{ $titleId }}">
  <div class="smart-together-cta__inner section-inner">
    <div class="smart-together-cta__copy">
      @if (filled($eyebrow))
        <div class="smart-together-cta__eyebrow">
          <span>{{ $eyebrow }}</span>
        </div>
      @endif
      <h2 id="{{ $titleId }}">{{ $title }}</h2>
      @if (filled($description))
        <p>{{ $description }}</p>
      @endif
    </div>

    <div class="smart-together-cta__actions">
      <x-frontend.cta-button
        :href="$primaryHref"
        :modal="$primaryModal"
        :service="$primaryService"
      >
        {{ $primaryLabel }}
      </x-frontend.cta-button>
      @if ($secondaryLabel !== '')
        <x-frontend.cta-button
          :href="$secondaryHref"
          variant="secondary"
          :modal="$secondaryModal"
          :service="$secondaryService"
        >
          <span>{{ $secondaryLabel }}</span>
        </x-frontend.cta-button>
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
