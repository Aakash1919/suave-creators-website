<section
  class="full-bleed bg-cover bg-center bg-no-repeat section-pad-m py-6 lg:py-20"
  style="background-image: url('{{ $backgroundImage }}');"
  aria-labelledby="service-body-heading">
  <div class="section-inner">
    <div class="mx-auto max-w-[1100px] text-center">
      <p class="offerings-eyebrow mb-4 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $eyebrow }}</p>
      <h2 id="service-body-heading" class="home-type-h2 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">{{ $title }}</h2>
      @foreach ($paragraphs as $para)
        <p class="mt-4 text-[14px] leading-5 text-[#4D4D4D]">{{ $para }}</p>
      @endforeach
      <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:gap-5 items-center justify-center">
        <x-frontend.cta-button :href="$resolvedPrimaryHref">
          {{ $primaryLabel }}
        </x-frontend.cta-button>
        <a href="{{ $resolvedSecondaryHref }}" class="group inline-flex max-lg:min-h-[44px] items-center gap-1.5 pb-0.5 border-b border-[#00003F] text-sm font-semibold leading-tight text-[#00003F]">
          {{ $secondaryLabel }}
          <x-frontend.cta-arrow />
        </a>
      </div>
    </div>
  </div>
</section>
