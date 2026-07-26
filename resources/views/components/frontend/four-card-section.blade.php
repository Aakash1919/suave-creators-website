<section {{ $attributes->merge(['class' => 'full-bleed bg-cover bg-top bg-no-repeat py-12 lg:py-20']) }}
    @if (filled($backgroundImage)) style="background-image: url('{{ asset($backgroundImage) }}');" @endif
    aria-labelledby="{{ $headingId }}">
    <div class="section-inner">
        <div class="grid gap-2 md:gap-6 lg:grid-cols-[200px_1fr] lg:gap-12">
            <div class="mb-4 flex items-start gap-2">
                <span
                    class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
                <span
                    class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">
                    {{ $eyebrow }}
                </span>
            </div>
            <div class="max-w-[760px]">
                <h2 id="{{ $headingId }}" class="text-2xl font-semibold leading-tight text-[#171717]">
                    {{ $title }}</h2>
                @if (filled($subtitle))
                    <p class="mt-2 text-sm leading-6 text-[#4D4D4D] sm:mt-5">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        </div>

        <div
            class="mt-8 grid grid-cols-1 overflow-hidden border-l border-t border-[#ECECEC] sm:mt-14 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($items as $item)
                <article
                    class="technology-card group relative min-h-[190px] border-b border-r border-[#ECECEC] bg-white p-5"
                    style="--technology-color: {{ $item['color'] }}">
                    <span
                        class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        style="background: radial-gradient(circle at 100% 100%, color-mix(in srgb, var(--technology-color) 12%, transparent), transparent 58%);"></span>
                    <i class="fa-brands {{ $item['icon'] }} relative text-[30px]" style="color: {{ $item['color'] }}"
                        aria-hidden="true"></i>
                    <h3 class="relative mt-3 text-base font-bold text-[#171717]">{{ $item['title'] }}</h3>
                    <p class="relative mt-2 pr-5 text-sm leading-[22px] text-[#4D4D4D]">{{ $item['description'] }}</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="#2A4DFB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-move-right-icon lucide-move-right absolute bottom-5 right-5">
                        <path d="M18 8L22 12L18 16"></path>
                        <path d="M2 12H22"></path>
                    </svg>
                </article>
            @endforeach
        </div>

        @if (filled($ctaHref) && filled($ctaLabel))
            <div class="mt-8 flex justify-end">
                <a href="{{ url($ctaHref) }}"
                    class="border-b border-[#2A4DFB] text-sm font-semibold text-[#2A4DFB]">{{ $ctaLabel }}</a>
            </div>
        @endif
    </div>
</section>
