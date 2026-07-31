<section
  {{ $attributes->merge(['class' => 'full-bleed core-values core-values-section bg-cover bg-top bg-no-repeat py-16 lg:py-20']) }}
  style="background-image: url('{{ asset($backgroundImage) }}');"
  @if ($titleId !== '') aria-labelledby="{{ $titleId }}" @endif>
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
          <h2 id="{{ $titleId }}">{{ $title }}</h2>
        @else
          <h2>{{ $title }}</h2>
        @endif
        @if ($description !== '')
          <p>{{ $description }}</p>
        @endif
      </div>
    </header>

    <div class="core-values__grid {{ $gridClass }}">
      @foreach ($items as $item)
        <article class="core-value-card">
          <div class="core-value-card__content !sm:flex !sm:flex-col">
            <h3>{{ $item['title'] }}</h3>
            <p>{{ $item['desc'] }}</p>
          </div>
          @if ($item['image'] !== '')
            <div class="core-value-card__image">
              <img src="{{ asset($item['image']) }}" alt="{{ $item['alt'] }}" title="{{ $item['alt'] }}"
                loading="lazy" decoding="async">
            </div>
          @endif
        </article>
      @endforeach
    </div>
  </div>
</section>
