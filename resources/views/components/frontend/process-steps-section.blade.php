<section class="full-bleed development-process-section" aria-labelledby="service-process-heading">
  <div class="section-inner">
    <header class="development-process-section__header">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $eyebrow }}</p>
      <h2 id="service-process-heading" class="home-type-h2 development-process-section__title">{{ $title }}</h2>
      <p class="development-process-section__description font-sans">{{ $description }}</p>
    </header>
    <div class="development-process-section__inner">
      <div class="development-process-section__steps">
        @foreach ($steps as $step)
          @php
            $stepAlt = ($step['title'] !== '' ? $step['title'] : 'Development process step').' icon for Suave Creators';
          @endphp
          <article class="development-process-section__step">
            <div class="development-process-section__step-top">
              <span class="development-process-section__step-icon">
                <img src="{{ asset($step['icon']) }}" alt="{{ $stepAlt }}" title="{{ $stepAlt }}" width="40" height="40" loading="lazy">
              </span>
              <span class="development-process-section__step-number" aria-hidden="true">{{ $step['step'] }}</span>
            </div>
            <h3 class="development-process-section__step-title">{{ $step['title'] }}</h3>
            <p class="development-process-section__step-text">{{ $step['desc'] }}</p>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
