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
        @endphp
        <{{ $tag }}
          @if ($card['href'] !== '') href="{{ $card['href'] }}" @endif
          class="{{ $cardClass }}">
          @if ($card['step'] !== '')
            <span class="industry-card__step">{{ $card['step'] }}</span>
          @endif
          @if ($card['image'] !== '')
            <img src="{{ asset($card['image']) }}" alt="{{ $card['title'] }}" title="{{ $card['title'] }}"
              class="industry-card__image" loading="lazy" decoding="async">
          @elseif ($card['icon'] !== '')
            <i class="industry-card__icon {{ $card['icon'] }}" aria-hidden="true"></i>
          @endif
          <h3>{{ $card['title'] }}</h3>
          <p>{{ $card['text'] }}</p>
          <span class="industry-card__arrow" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 8L22 12L18 16"></path>
              <path d="M2 12H22"></path>
            </svg>
          </span>
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
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
              <path d="M18 8L22 12L18 16"></path>
              <path d="M2 12H22"></path>
            </svg>
          </a>
        </div>
      </aside>
    @endif
  </div>
</section>
