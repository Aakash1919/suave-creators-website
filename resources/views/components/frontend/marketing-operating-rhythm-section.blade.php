<section
  {{ $attributes->merge(['class' => 'full-bleed marketing-operating-rhythm']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner marketing-operating-rhythm__inner">
    <header class="marketing-operating-rhythm__header">
      <p class="marketing-operating-rhythm__eyebrow">{{ $eyebrow }}</p>
      <h2 id="{{ $headingId }}" class="marketing-operating-rhythm__title">{{ $title }}</h2>
    </header>

    @if ($items !== [])
      <div class="marketing-operating-rhythm__grid">
        @foreach ($items as $item)
          @php
            $image = (string) ($item['image'] ?? '');
            $imageAlt = (string) ($item['imageAlt'] ?? ($item['title'] ?? 'Digital marketing process'));
            $icon = (string) ($item['icon'] ?? '');
            $iconAlt = (string) ($item['iconAlt'] ?? (($item['title'] ?? 'Process').' icon'));
          @endphp
          <article class="marketing-operating-rhythm__card">
            <div class="marketing-operating-rhythm__media">
              @if (filled($image))
                <img
                  src="{{ asset($image) }}"
                  alt="{{ $imageAlt }}"
                  title="{{ $imageAlt }}"
                  width="640"
                  height="400"
                  loading="lazy"
                  decoding="async">
              @else
                <span
                  class="marketing-operating-rhythm__image-placeholder"
                  role="img"
                  aria-label="{{ $imageAlt }}"></span>
              @endif
            </div>

            <div class="marketing-operating-rhythm__icon">
              @if (filled($icon))
                <img
                  src="{{ asset($icon) }}"
                  alt="{{ $iconAlt }}"
                  title="{{ $iconAlt }}"
                  width="40"
                  height="40"
                  loading="lazy"
                  decoding="async">
              @else
                <span
                  class="marketing-operating-rhythm__icon-placeholder"
                  role="img"
                  aria-label="{{ $iconAlt }}"></span>
              @endif
            </div>

            <h3 class="marketing-operating-rhythm__card-title">{{ $item['title'] }}</h3>
            <p class="marketing-operating-rhythm__card-copy">{{ $item['description'] }}</p>
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>
