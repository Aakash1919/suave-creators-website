<section
  class="full-bleed partnership-section bg-repeat"
  style="background-image: url('{{ asset($backgroundImage) }}');"
  aria-label="{{ $ariaLabel }}">
  <div class="partnership-inner section-inner text-center">
    <p
      class="offerings-eyebrow mb-8 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
      {{ $eyebrow }}
    </p>

    <x-frontend.marquee-section
      type="image"
      direction="left"
      position="contained"
      :items="$items"
      :aria-label="$ariaLabel"
      :speed="28"
    />
  </div>
</section>
