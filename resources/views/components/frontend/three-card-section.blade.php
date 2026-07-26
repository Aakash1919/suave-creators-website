<section
    {{ $attributes->merge(['class' => 'full-bleed web-services bg-cover bg-top bg-no-repeat py-12 lg:py-20']) }}
    @if (filled($backgroundImage)) style="background-image: url('{{ asset($backgroundImage) }}');" @endif
    aria-labelledby="{{ $headingId }}">
    <div class="web-services__inner section-inner">
        <header class="web-services__header">
            <div class="mb-4 flex items-center gap-2">
                <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
                <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
                    {{ $eyebrow }}
                </span>
            </div>
            <div class="web-services__intro">
                <h2 id="{{ $headingId }}" class="mb-4 text-[24px] font-semibold leading-[100%] text-[#171717]">
                    {{ $title }}
                </h2>
                @if (filled($subtitle))
                    <p class="text-[14px] leading-[100%] text-[#4D4D4D]">{{ $subtitle }}</p>
                @endif
            </div>
        </header>

        <div class="web-services__grid">
            @foreach ($items as $item)
                <article class="web-service-card">
                    <span class="web-service-card__icon web-service-card__icon--{{ $item['tone'] }}">
                        <img src="{{ asset($item['icon']) }}" alt="{{ $item['iconAlt'] }}" title="{{ $item['iconAlt'] }}" width="16" height="16" decoding="async" loading="lazy">
                    </span>

                    <div class="web-service-card__category">
                        <span class="text-[10px] font-semibold uppercase leading-[100%] text-[#4D4D4D]">{{ $item['category'] }}</span>
                        <div class="flex items-center justify-between">
                            <h3 class="mt-2 text-[14px] font-semibold leading-[100%] text-[#171717]">
                                {{ $item['title'] }}
                            </h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="#2A4DFB" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-move-right-icon lucide-move-right">
                                <path d="M18 8L22 12L18 16" />
                                <path d="M2 12H22" />
                            </svg>
                        </div>
                    </div>

                    <p class="mt-1 text-[14px] text-[#4D4D4D]">{{ $item['description'] }}</p>
                </article>
            @endforeach
        </div>

        @if (filled($ctaHref) && filled($ctaLabel))
            <div class="web-services__footer">
                <a href="{{ url($ctaHref) }}">{{ $ctaLabel }}</a>
            </div>
        @endif
    </div>
</section>
