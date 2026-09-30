<section
  {{ $attributes->merge(['class' => 'full-bleed core-values core-values-section bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20']) }}
  style="background-image: url('{{ asset($backgroundImage) }}');"
  @if ($titleId !== '') aria-labelledby="{{ $titleId }}" @endif>
  @if ($hasIcons)
    <svg class="core-values__symbols" aria-hidden="true">
      <symbol id="core-value-fintech" viewBox="0 0 24 24">
        <path d="M3 9L12 4l9 5H3Z" />
        <path d="M5 10v8M9 10v8M15 10v8M19 10v8" />
        <path d="M3 18h18M2 21h20" />
        <circle cx="12" cy="14" r="2" />
      </symbol>
      <symbol id="core-value-ecommerce" viewBox="0 0 24 24">
        <path d="M3 4h2l2.4 10.2a2 2 0 0 0 2 1.5h8.8a2 2 0 0 0 2-1.6L21 8H7" />
        <path d="M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" />
        <path d="M17 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" />
        <path d="M9 8h10" />
      </symbol>
      <symbol id="core-value-healthcare" viewBox="0 0 24 24">
        <path d="M12 21s-7-4.5-9-9.2C1.5 8.5 3.5 5 7 5c2 0 3.3 1.2 5 3 1.7-1.8 3-3 5-3 3.5 0 5.5 3.5 4 6.8C19 16.5 12 21 12 21Z" />
        <path d="M12 9v6" />
        <path d="M9 12h6" />
      </symbol>
      <symbol id="core-value-education" viewBox="0 0 24 24">
        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v17H6.5A2.5 2.5 0 0 0 4 22V5.5Z" />
        <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v17h5.5a2.5 2.5 0 0 1 2.5 2.5V5.5Z" />
      </symbol>
      <symbol id="core-value-it" viewBox="0 0 24 24">
        <path d="M8 9 4 12l4 3" />
        <path d="m16 9 4 3-4 3" />
        <path d="m14 6-4 12" />
      </symbol>
      <symbol id="core-value-logistics" viewBox="0 0 24 24">
        <path d="M3 6h11v11H3z" />
        <path d="M14 10h4l3 3v4h-7z" />
        <circle cx="7" cy="18" r="2" />
        <circle cx="18" cy="18" r="2" />
      </symbol>
    </svg>
  @endif
  <div class="core-values__inner section-inner">
    <header class="core-values__header">
      <div class="mb-4 flex items-start gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"
          aria-hidden="true"></span>
        <span
          class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">
          {{ $eyebrow }}
        </span>
      </div>
      <div class="core-values__heading">
        @if ($titleId !== '')
          <h2 id="{{ $titleId }}" class="home-type-h2">{{ $title }}</h2>
        @else
          <h2 class="home-type-h2">{{ $title }}</h2>
        @endif
        @if ($description !== '')
          <p>{{ $description }}</p>
        @endif
      </div>
    </header>

    <div class="core-values__grid {{ $gridClass }}">
      @foreach ($items as $item)
        <article class="core-value-card">
          @if ($item['icon'] !== '')
            <div class="core-value-card__content">
              <svg class="core-value-card__icon" aria-hidden="true">
                <use href="#core-value-{{ $item['icon'] }}"></use>
              </svg>
              <div class="core-value-card__text">
                <h3>{{ $item['title'] }}</h3>
                <p>{{ $item['desc'] }}</p>
              </div>
            </div>
          @else
            <div class="core-value-card__content !sm:flex !sm:flex-col">
              <h3>{{ $item['title'] }}</h3>
              <p>{{ $item['desc'] }}</p>
            </div>
          @endif
          @if ($item['image'] !== '')
            <div class="core-value-card__image">
              <x-frontend.responsive-webp-image
                :src="$item['image']"
                :alt="$item['alt']"
                sizes="(min-width: 1024px) 366px, (min-width: 768px) 292px, 90vw"
                loading="lazy"
                decoding="async" />
            </div>
          @endif
        </article>
      @endforeach
    </div>
  </div>
</section>
