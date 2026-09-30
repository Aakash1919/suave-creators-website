<section class="full-bleed web-services web-services--brown-hover bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20" style="background-image: url('{{ asset('assets/background/web-services-section-bg.png') }}')" aria-labelledby="service-capabilities-heading">
  <div class="web-services__inner section-inner">
    <header class="web-services__header">
      <div class="mb-4 flex items-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $eyebrow }}</span>
      </div>
      <div class="web-services__intro">
        <h2 id="service-capabilities-heading" class="home-type-h2 mb-4 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">{{ $title }}</h2>
        <p class="text-[14px] leading-5 text-[#4D4D4D]">{{ $description }}</p>
      </div>
    </header>
    <div class="web-services__grid{{ $columns === 2 ? ' web-services__grid--cols-2' : '' }}">
      @foreach ($items as $index => $cap)
        <a href="{{ $demoHref }}" class="web-service-card group" aria-label="Contact Suave Creators about {{ $cap['title'] ?? 'this capability' }}">
          <div class="web-service-card__head">
            <img class="web-service-card__icon-img" src="{{ $cap['image'] ?? '' }}" alt="{{ ($cap['title'] ?? 'Service').' capability icon for Suave Creators software development' }}" title="{{ ($cap['title'] ?? 'Service').' capability icon for Suave Creators software development' }}" width="80" height="64">
            <x-frontend.cta-arrow class="web-service-card__arrow" />
          </div>
          <div class="web-service-card__category">
            <span class="text-[10px] font-semibold uppercase text-[#4D4D4D]">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . ' - Capability' }}</span>
            <h3 class="mt-2 text-[14px] font-semibold leading-[18px] text-[#171717]">{{ $cap['title'] ?? '' }}</h3>
          </div>
          @if (!empty($cap['tags']))
            <div class="mt-2 flex flex-wrap gap-1.5">
              @foreach ($cap['tags'] as $tag)
                <span class="rounded-full bg-[#EEF1FF] px-2.5 py-0.5 text-[10px] font-semibold text-[#2A4DFB]">{{ $tag }}</span>
              @endforeach
            </div>
          @endif
          <p class="mt-2 text-[14px] leading-5 text-[#4D4D4D]">{{ $cap['desc'] ?? '' }}</p>
        </a>
      @endforeach
    </div>
  </div>
</section>
