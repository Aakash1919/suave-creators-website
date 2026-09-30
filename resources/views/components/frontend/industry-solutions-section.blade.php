<section class="full-bleed web-services industry-detail-services bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20"
  style="background-image: url('{{ asset('assets/background/web-services-section-bg.png') }}')"
  aria-labelledby="industry-services-heading">
  <div class="web-services__inner section-inner">
    <header class="web-services__header">
      <div class="mb-3 flex items-center gap-2 sm:mb-4">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">{{ $eyebrow }}</span>
      </div>
      <div class="web-services__intro">
        <h2 id="industry-services-heading"
          class="home-type-h2 mb-3 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:mb-4 lg:text-[24px] lg:leading-[36px]">
          {{ $title }}</h2>
        <p class="text-[13px] leading-[18px] text-[#4D4D4D] sm:text-[14px] sm:leading-5">
          {{ $description }}</p>
      </div>
    </header>
    <div class="web-services__grid">
      @foreach ($items as $index => $item)
        @php
          $itemTitle = $item['title'] ?? '';
          $iconAlt = ($itemTitle !== '' ? $itemTitle : 'Industry service').' icon for Suave Creators software development';
          $imageAlt = ($itemTitle !== '' ? $itemTitle : 'Custom software').' service by Suave Creators software development team';
        @endphp
        <a href="{{ route('contact-us') }}#contact-id" class="web-service-card group">
          <span class="web-service-card__icon">
            <img src="{{ $item['icon'] ?? '' }}" alt="{{ $iconAlt }}" title="{{ $iconAlt }}" width="36" height="36">
          </span>
          <div class="web-service-card__category">
            <span class="text-[10px] font-semibold uppercase text-[#4D4D4D]">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . ' - Service' }}</span>
            <div class="flex items-start justify-between gap-2">
              <h3 class="mt-2 min-w-0 text-[14px] font-semibold leading-[18px] text-[#171717]">{{ $itemTitle }}</h3>
              <x-frontend.cta-arrow class="industry-service-card__arrow mt-2 shrink-0 text-[#2A4DFB]" />
            </div>
          </div>
          <p class="mt-1 text-[13px] leading-[18px] text-[#4D4D4D] sm:text-[14px] sm:leading-5">
            {{ $item['desc'] ?? '' }}</p>
          @if (!empty($item['img']))
            <figure class="mt-3 aspect-video overflow-hidden rounded-[12px] sm:rounded-[14px]"><img
                src="{{ $item['img'] }}" alt="{{ $imageAlt }}" title="{{ $imageAlt }}" width="640" height="360"
                class="h-full w-full object-cover" loading="lazy"></figure>
          @endif
        </a>
      @endforeach
    </div>
    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:mt-10 sm:flex-row sm:flex-wrap sm:gap-5">
      <x-frontend.cta-button :href="$demoHref" variant="compact" class="w-fit">Let's Connect to Discuss</x-frontend.cta-button>
      <a href="{{ $demoHref }}"
        class="inline-flex w-fit border-b border-[#00003F] text-[13px] font-semibold text-[#00003F] sm:text-sm">Let's
        Build Your Digital Future Together</a>
    </div>
  </div>
</section>
