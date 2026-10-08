<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarketingOperatingRhythmSection extends Component
{
    /**
     * @param  list<array{title: string, description: string, image?: string, imageAlt?: string, icon?: string, iconAlt?: string}>  $items
     */
    public function __construct(
        public string $eyebrow = 'A clear operating rhythm',
        public string $title = 'How We Work',
        public array $items = [],
        public string $headingId = 'digital-marketing-how-we-work-heading',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.marketing-operating-rhythm-section');
    }
}
