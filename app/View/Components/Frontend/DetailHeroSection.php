<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DetailHeroSection extends Component
{
    public string $sideImageAlt;

    /**
     * @param  array<int, string>  $titleLines
     */
    public function __construct(
        public string $eyebrow,
        public array $titleLines,
        public string $description,
        public string $backgroundImage,
        public string $sideImage,
        public string $pageTitle,
        public string $headingId = 'service-banner-heading',
        public bool $accentFirst = false,
        public bool $framedSide = false,
        public string $eyebrowClass = '',
        public string $primaryLabel = 'Get Free Consultation',
        public string $secondaryLabel = 'Schedule a Discovery Call',
    ) {
        $this->sideImageAlt = $this->pageTitle.' side banner graphic for Suave Creators';
    }

    public function isAccentLine(int $index): bool
    {
        return ($index === 0) === $this->accentFirst;
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.detail-hero-section');
    }
}
