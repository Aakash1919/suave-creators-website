<?php

namespace App\View\Components\Layouts;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TheSuaveStarPearl extends Component
{
    use NormalizesAssetPaths;

    public string $assetBase;

    public string $starSrc;

    public string $pearlSrc;

    /**
     * Animated silver star and pearl brand emblem (layout chrome).
     */
    public function __construct(
        public string $ariaLabel = 'Suave Creators silver star and pearl emblem',
        public string $starAlt = 'Suave Creators metallic star brand emblem for software development',
        public string $pearlAlt = 'Suave Creators white pearl brand emblem for software development',
        public ?string $size = null,
        public bool $decorative = false,
        public int $width = 72,
        public int $height = 72,
        ?string $assetBase = null,
    ) {
        $this->assetBase = $this->normalizeAssetPath($assetBase ?? 'assets/brand');
        $this->starSrc = $this->normalizeAssetPath($this->assetBase.'/the-suave-metallic-star.png');
        $this->pearlSrc = $this->normalizeAssetPath($this->assetBase.'/the-suave-white-pearl.png');
    }

    /**
     * Render the star-and-pearl emblem Blade view.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.the-suave-star-pearl');
    }
}
