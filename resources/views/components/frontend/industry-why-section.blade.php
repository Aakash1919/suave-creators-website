<section class="full-bleed industry-why-section relative overflow-hidden bg-[#F8FAFC] section-pad-m py-6 lg:py-20"
  aria-labelledby="industry-why-heading">
  <div class="industry-why-section__bg" aria-hidden="true"></div>
  <div class="section-inner relative z-10">
    <header class="mx-auto mb-8 max-w-[720px] text-center sm:mb-10 lg:mb-14">
      <div class="mb-4 flex items-center justify-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">{{ $eyebrow }}</span>
      </div>
      <h2 id="industry-why-heading"
        class="home-type-h2 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">
        {{ $title }}</h2>
      <p class="mx-auto mt-3 max-w-[560px] text-[13px] leading-[18px] text-[#4D4D4D] sm:mt-4 sm:text-[14px] sm:leading-5">
        {{ $description }}</p>
    </header>
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
      @foreach ($cards as $card)
        <article class="flex min-h-full flex-col gap-3 rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white p-[22px] shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          @if (!empty($card['icon']))
            @php
              $iconAlt = ($card['title'] ?? 'Why choose Suave Creators').' icon';
            @endphp
            <span class="inline-flex h-[52px] w-[52px] items-center justify-center rounded-[14px] bg-[#EEF1FF]"><img
                src="{{ $card['icon'] }}" alt="{{ $iconAlt }}" title="{{ $iconAlt }}" width="26"
                height="26" class="h-[26px] w-[26px] object-contain" loading="lazy"></span>
          @endif
          <h3 class="text-[14px] font-semibold leading-[18px] text-[#171717]">{{ $card['title'] ?? '' }}</h3>
          <p class="flex-1 text-[14px] leading-5 text-[#4D4D4D]">{{ $card['text'] ?? '' }}</p>
          <a href="{{ $demoHref }}"
            class="mt-1 inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#2A4DFB] no-underline hover:underline">Get
            Started <x-frontend.cta-arrow /></a>
        </article>
      @endforeach
    </div>
  </div>
</section>
