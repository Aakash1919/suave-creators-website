<div id="announcement-bar" {{ $attributes->merge(['class' => 'site-topbar flex min-h-[30px] w-full items-center overflow-hidden bg-[#010062] py-1']) }} role="region" aria-label="Announcements">
    <div class="site-container grid grid-cols-[1fr_auto] items-center gap-2 sm:grid-cols-[1fr_auto_1fr]">
        <span class="hidden sm:block" aria-hidden="true"></span>
        <p class="site-topbar__copy m-0 flex min-w-0 items-center justify-start gap-2 sm:justify-center">
            <img
                src="{{ asset($icon) }}"
                alt="{{ $iconAlt }}" title="{{ $iconAlt }}"
                class="h-3.5 w-3.5 shrink-0 object-contain"
                width="14"
                height="14"
                decoding="async"
            >
            <a href="{{ $href() }}" class="site-topbar__text min-w-0 no-underline hover:opacity-90">
                <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[11px] font-bold leading-[1.35] text-transparent sm:text-xs">{{ $title }}</span>
                <span class="hidden text-[11px] font-semibold leading-[1.35] text-white min-[480px]:inline sm:text-xs">{{ $subtitle }}</span>
            </a>
            <i class="fa-solid fa-arrow-right hidden shrink-0 text-xs text-white min-[480px]:inline" aria-hidden="true"></i>
            <span class="ml-2 hidden shrink-0 items-center gap-1 sm:ml-4 sm:flex" aria-hidden="true">
                <span class="h-2 w-2 rounded-full bg-white"></span>
                <span class="h-2 w-2 rounded-full bg-white/40"></span>
            </span>
        </p>
        <button type="button" class="site-topbar__dismiss u-touch-target justify-self-end text-sm text-white opacity-40 hover:opacity-70" aria-label="Dismiss announcement" onclick="document.getElementById('announcement-bar').remove()">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>
</div>
