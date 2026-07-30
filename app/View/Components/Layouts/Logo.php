<?php

namespace App\View\Components\Layouts;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use InvalidArgumentException;

class Logo extends Component
{
    use NormalizesAssetPaths;

    public string $resolvedSrc;

    public string $imgClass;

    public bool $useResponsiveLogo;

    public string $sizes;

    public function __construct(
        public string $variant = 'header',
        public ?string $src = null,
        public string $alt = 'Suave Creators logo web and software development company',
    ) {
        $this->variant = Str::lower($this->variant);

        if (! in_array($this->variant, ['header', 'footer'], true)) {
            throw new InvalidArgumentException('Logo variant must be "header" or "footer".');
        }

        $defaultSrc = 'assets/brand/logo-white.png';
        $this->resolvedSrc = $this->normalizeAssetPath($this->src ?? $defaultSrc);
        $this->useResponsiveLogo = $this->resolvedSrc === $defaultSrc;

        $this->imgClass = $this->variant === 'footer'
            ? 'h-9 w-auto max-w-full object-contain sm:h-12'
            : 'block h-9 w-auto object-contain sm:h-10';

        // Header ~89px / footer ~107px wide; 220w+440w covers 1x–3x DPR without the 1024px master.
        $this->sizes = $this->variant === 'footer'
            ? '(min-width: 640px) 107px, 80px'
            : '(min-width: 640px) 89px, 80px';
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.logo');
    }
}
