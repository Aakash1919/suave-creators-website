<section
  {{ $attributes->merge(['class' => $sectionClass.($backgroundImage !== '' ? ' bg-cover bg-center bg-no-repeat' : '')]) }}
  @if ($backgroundImage !== '') style="background-image: url('{{ asset($backgroundImage) }}');" @endif
  aria-label="{{ $ariaLabel }}">
  <div class="section-inner text-center">
    <p
      class="offerings-eyebrow mb-8 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
      {{ $eyebrow }}
    </p>
  </div>
  <div class="about-tech-marquee overflow-hidden">
    <div class="about-tech-marquee__track">
      @for ($g = 0; $g < 4; $g++)
        <div class="about-tech-marquee__group" @if ($g > 0) aria-hidden="true" @endif>
          @foreach ($items as $tech)
            <article class="about-tech-card">
              <img src="{{ asset($tech['src']) }}" alt="{{ $tech['alt'] }}" title="{{ $tech['alt'] }}" width="48"
                height="48" class="about-tech-card__icon" loading="lazy" decoding="async">
              <span class="about-tech-card__label">{{ $tech['label'] }}</span>
            </article>
          @endforeach
        </div>
      @endfor
    </div>
  </div>
</section>
