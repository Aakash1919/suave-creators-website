<?php

namespace App\Support\Frontend;

class UiHelper
{
    /**
     * Primary CTA button class string.
     *
     * @param  'default'|'compact'  $variant
     */
    public static function btnPrimary(string $variant = 'default'): string
    {
        return match ($variant) {
            'compact' => 'u-btn-cta group inline-flex h-[34px] min-h-[34px] cursor-pointer items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-0 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:h-auto sm:min-h-11 sm:px-5 sm:py-2 sm:text-sm',
            default => 'u-btn-cta group inline-flex cursor-pointer items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110',
        };
    }

    public static function ctaArrow(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>';
    }
}
