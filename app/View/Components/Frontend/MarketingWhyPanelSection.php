<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarketingWhyPanelSection extends Component
{
    public string $ctaHref;

    /**
     * @param  list<array{title: string, description: string, icon?: string, iconAlt?: string}>  $items
     */
    public function __construct(
        public string $eyebrow = 'Why Suave Creators',
        public string $title = 'B2B Marketing With Engineering Depth',
        public string $description = '',
        public string $ctaLabel = 'Work with your team',
        public ?string $ctaHrefOverride = null,
        public string $primaryService = 'digital-marketing',
        public array $items = [],
        public string $headingId = 'digital-marketing-why-heading',
    ) {
        $this->ctaHref = $ctaHrefOverride ?? ContactSupport::demoHref();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.marketing-why-panel-section');
    }
}
