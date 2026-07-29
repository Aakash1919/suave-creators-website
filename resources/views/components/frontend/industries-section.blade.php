<section
  {{ $attributes->merge(['class' => 'full-bleed industries-served bg-cover bg-top bg-no-repeat py-12 lg:py-[80px]']) }}
  style="background-image: url('{{ asset($backgroundImage) }}');"
  aria-labelledby="{{ $headingId }}">
  <div class="industries-served__inner section-inner">
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
        <h2 id="{{ $headingId }}">{{ $title }}</h2>
        @if ($description !== '')
          <p>{{ $description }}</p>
        @endif
      </div>
    </header>

    <div class="industries-served__grid">
      @foreach ($cards as $card)
        @php
          $tag = $card['href'] !== '' ? 'a' : 'article';
          $cardClass = 'industry-card'.($variant === 'standout' ? ' industry-card--standout' : '');
          $hasStep = $card['step'] !== '';
          $hasImage = $card['image'] !== '';
          $hasIcon = $card['icon'] !== '';
        @endphp
        <{{ $tag }}
          @if ($card['href'] !== '') href="{{ $card['href'] }}" @endif
          class="{{ $cardClass }}">
          @if ($variant === 'standout' && ($hasImage || $hasIcon || $hasStep))
            <div class="industry-card__top">
              @if ($hasImage)
                <span class="industry-card__icon inline-flex">
                  <img src="{{ str_starts_with($card['image'], 'http') || str_starts_with($card['image'], '/') ? $card['image'] : asset($card['image']) }}"
                    alt="{{ $card['title'] }} industry icon for Suave Creators software services"
                    title="{{ $card['title'] }} industry icon for Suave Creators software services"
                    width="28" height="28" class="h-7 w-7 object-contain" loading="lazy" decoding="async">
                </span>
              @elseif ($hasIcon)
                <i class="industry-card__icon {{ $card['icon'] }}" aria-hidden="true"></i>
              @endif
              @if ($hasStep)
                <span class="industry-card__step" aria-hidden="true">{{ $card['step'] }}</span>
              @endif
            </div>
          @else
            @if ($hasImage)
              <span class="industry-card__icon inline-flex">
                <img src="{{ str_starts_with($card['image'], 'http') || str_starts_with($card['image'], '/') ? $card['image'] : asset($card['image']) }}"
                  alt="{{ $card['title'] }} industry icon for Suave Creators software services"
                  title="{{ $card['title'] }} industry icon for Suave Creators software services"
                  width="26" height="26" class="h-[26px] w-[26px] object-contain" loading="lazy" decoding="async">
              </span>
            @elseif ($hasIcon)
              <i class="industry-card__icon {{ $card['icon'] }}" aria-hidden="true"></i>
            @endif
            @if ($hasStep)
              <span class="industry-card__step" aria-hidden="true">{{ $card['step'] }}</span>
            @endif
          @endif
          <h3>{{ $card['title'] }}</h3>
          <p>{{ $card['text'] }}</p>
          @if (! $hasStep)
            <span class="industry-card__arrow" aria-hidden="true">
              <img src="{{ asset('assets/media/soft-white-right-arrow.png') }}"
                alt="Soft white right arrow for Suave Creators industries we serve"
                title="Soft white right arrow for Suave Creators industries we serve"
                width="18" height="5" decoding="async" loading="lazy">
            </span>
          @endif
        </{{ $tag }}>
      @endforeach
    </div>

    @if ($footerLabel !== '')
      <div class="industries-served__project">
        <a href="{{ $footerHref }}" class="border-b border-white/70 text-sm font-semibold text-white">{{ $footerLabel }}</a>
      </div>
    @endif

    @if ($showSupportAside)
      <aside class="industries-support" aria-label="Online platform services support">
        <div class="industries-support__copy">
          <p>{{ $supportText }}</p>
          <a href="{{ $supportHref }}">
            {{ $supportLabel }}
            <x-frontend.cta-arrow />
          </a>
        </div>
        @if ($supportImage !== '')
          <div class="industries-support__illustration" aria-hidden="true">
            <img src="{{ asset($supportImage) }}" alt="{{ $supportImageAlt }}" title="{{ $supportImageAlt }}"
              loading="lazy" decoding="async">
          </div>
        @endif
      </aside>
    @endif
  </div>
</section>
