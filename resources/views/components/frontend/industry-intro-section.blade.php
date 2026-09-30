<section class="full-bleed bg-white bg-cover bg-top bg-no-repeat section-pad-m py-6 lg:py-20"
  style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}')"
  aria-labelledby="industry-intro-heading">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-start gap-8 sm:gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:gap-14">
      <div class="min-w-0">
        <div class="mb-3 flex items-center gap-2 sm:mb-4">
          <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[13px] font-bold text-transparent sm:text-[14px]">{{ $eyebrow }}</span>
        </div>
        <h2 id="industry-intro-heading"
          class="home-type-h2 text-[20px] font-semibold leading-[28px] tracking-[-0.025em] text-[#171717] sm:leading-[32px] lg:text-[24px] lg:leading-[36px]">
          {{ $title }}</h2>
        <p class="mt-3 max-w-[560px] text-[13px] leading-[18px] text-[#4D4D4D] sm:mt-4 sm:text-[14px] sm:leading-5">
          {{ $description }}</p>
        <div class="mt-6 sm:mt-8">
          <x-frontend.cta-button :href="route('services', absolute: false)" variant="compact">Explore Services</x-frontend.cta-button>
        </div>
      </div>
      <div class="grid grid-cols-1 gap-3 min-[480px]:grid-cols-2 sm:gap-3.5">
        @foreach ($stats as $stat)
          <article
            class="flex min-w-0 items-start gap-3 rounded-[16px] border border-[rgb(31_38_68_/_3%)] bg-white p-3.5 shadow-[0_16px_36px_rgb(35_38_91_/_10%)] sm:gap-3.5 sm:rounded-[20px] sm:p-4">
            <span class="inline-flex h-[44px] w-[44px] shrink-0 items-center justify-center sm:h-[52px] sm:w-[52px]">
              <img src="{{ asset($stat[3]) }}"
                alt="{{ $stat[1] }} stat icon for Suave Creators software development"
                title="{{ $stat[1] }} stat icon for Suave Creators software development"
                width="52" height="52"
                class="h-[44px] w-[44px] object-contain sm:h-[52px] sm:w-[52px]">
            </span>
            <div class="min-w-0">
              <strong class="block text-[24px] font-semibold leading-none tracking-tight sm:text-[28px]"
                style="color: {{ $stat[4] }};">{{ $stat[0] }}</strong>
              <h3 class="mt-1 text-[12px] font-semibold leading-snug sm:text-[13px] sm:leading-none"
                style="color: {{ $stat[4] }};">{{ $stat[1] }}</h3>
              <p class="mt-1 text-[12px] font-medium leading-4 text-[#171717] sm:text-[13px]">{{ $stat[2] }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
