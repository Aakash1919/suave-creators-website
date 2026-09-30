<section class="full-bleed bg-white section-pad-m py-6 lg:py-20" aria-labelledby="service-intro-heading">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:gap-14">
      <div>
        <div class="mb-4 flex items-center gap-2">
          <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">{{ $eyebrow }}</span>
        </div>
        <h2 id="service-intro-heading" class="home-type-h2 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">{{ $title }}</h2>
        <p class="mt-4 max-w-[560px] text-[14px] leading-5 text-[#4D4D4D]">{{ $description }}</p>
        <div class="mt-8">
          <x-frontend.cta-button :href="$linkHref">
            {{ $linkLabel }}
          </x-frontend.cta-button>
          {{ $slot }}
        </div>
      </div>
      <div class="grid grid-cols-1 gap-3.5 min-[480px]:grid-cols-2">
        @foreach ($stats as $stat)
          <article class="flex min-w-0 items-start gap-3.5 rounded-[20px] border border-[rgb(31_38_68_/_3%)] bg-white p-4 shadow-[0_16px_36px_rgb(35_38_91_/_10%)]">
            <img src="{{ asset($stat[3]) }}" alt="{{ $stat[1] }} stat icon for Suave Creators software development" title="{{ $stat[1] }} stat icon for Suave Creators software development" width="26" height="26" class="h-[26px] w-[26px] shrink-0 object-contain" loading="lazy">
            <div class="min-w-0">
              <strong class="block text-[28px] font-semibold leading-none tracking-tight" style="color: {{ $stat[4] }};">{{ $stat[0] }}</strong>
              <h3 class="mt-1 text-[13px] font-semibold leading-none" style="color: {{ $stat[4] }};">{{ $stat[1] }}</h3>
              <p class="mt-1 text-[13px] font-medium leading-4 text-[#171717]">{{ $stat[2] }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
