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
      <x-frontend.cta-button :href="$primaryHref">
        {{ $primaryLabel }}
      </x-frontend.cta-button>
      @if ($secondaryLabel !== '')
        <a href="{{ $secondaryHref }}"
          @if (str_starts_with($secondaryHref, 'http')) target="_blank" rel="noopener noreferrer" @endif
          class="{{ $secondaryClass !== '' ? $secondaryClass : 'smart-together-cta__btn-secondary group' }}">
          <span>{{ $secondaryLabel }}</span>
          @if (!str_contains($secondaryLabel, '→') && !str_contains($secondaryLabel, '&rarr;'))
            <x-frontend.cta-arrow />
          @endif
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
