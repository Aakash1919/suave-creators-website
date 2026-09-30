<section class="full-bleed overflow-hidden bg-[#F9FAFC] bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20"
  style="background-image: url('{{ asset('assets/background/offerings-section-bg.webp') }}')"
  aria-labelledby="industry-specialized-heading">
  <div class="section-inner">
    <div class="mx-auto mb-8 max-w-[720px] text-center sm:mb-10 lg:mb-14">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">
        {{ $eyebrow }}</p>
      <h2 id="industry-specialized-heading"
        class="home-type-h2 mt-3 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:mt-4 lg:text-[24px] lg:leading-[36px]">
        {{ $title }}</h2>
      <p class="mx-auto mt-3 max-w-[605px] text-[13px] leading-[18px] text-[#4D4D4D] sm:mt-4 sm:text-[14px] sm:leading-5">
        {{ $description }}</p>
    </div>
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 lg:gap-6">
      @foreach ($items as $item)
        <article class="flex min-h-full flex-col gap-3 rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white p-[22px] shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          @if (!empty($item['icon']))
            @php
              $iconAlt = ($item['title'] ?? 'Specialized service').' icon for Suave Creators industry solutions';
            @endphp
            <span class="inline-flex h-[52px] w-[52px] items-center justify-center rounded-[14px] bg-[#EEF1FF]"><img
                src="{{ $item['icon'] }}" alt="{{ $iconAlt }}" title="{{ $iconAlt }}"
                width="26" height="26" class="h-[26px] w-[26px] object-contain" loading="lazy"></span>
          @endif
          <h3 class="text-[14px] font-semibold leading-[18px] text-[#171717]">{{ $item['title'] ?? '' }}</h3>
          <p class="flex-1 text-[14px] leading-5 text-[#4D4D4D]">{{ $item['desc'] ?? '' }}</p>
        </article>
      @endforeach
    </div>
    <div class="mt-10 flex justify-center"><a href="{{ route('services') }}"
        class="border-b border-[#00003F] text-sm font-semibold text-[#00003F]">Explore all Services</a></div>
  </div>
</section>
