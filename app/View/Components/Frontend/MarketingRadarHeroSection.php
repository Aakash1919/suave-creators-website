<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarketingRadarHeroSection extends Component
{
    use NormalizesAssetPaths;

    public string $demoHref;

    /**
     * @param  array{lead: string, accent: string, soft: string}  $title
     * @param  list<string>  $proofPoints
     */
    public function __construct(
        public array $title,
        public string $description,
        public string $eyebrow = 'Digital growth, engineered',
        public string $breadcrumbCurrent = 'Digital Marketing Services',
        public string $primaryLabel = 'Get a Scoped Estimate',
        public string $secondaryLabel = 'Explore our services',
        public string $primaryService = 'digital-marketing',
        public string $headingId = 'digital-marketing-hero-heading',
        public string $backgroundImage = 'assets/background/marketing-radar-hero-bg.webp',
        public string $visualImage = 'assets/media/digital-marketing-hero.webp',
        public string $visualAlt = 'Digital marketing radar showing qualified leads, SEO, PPC, social channels, and pipeline influenced for Suave Creators',
        public array $proofPoints = [],
    ) {
        $this->demoHref = ContactSupport::demoHref();
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);
        $this->visualImage = $this->normalizeAssetPath($this->visualImage);

        if ($this->proofPoints === []) {
            $this->proofPoints = [
                'Search, paid, content and social under one strategy',
                'Technical fixes built by our own engineering team',
                'Content shaped with senior developers',
            ];
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.marketing-radar-hero-section');
    }
}
