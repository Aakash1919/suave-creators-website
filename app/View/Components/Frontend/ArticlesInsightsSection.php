<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArticlesInsightsSection extends Component
{
    /**
     * @param  array<int, array{title?: string, excerpt?: string, image?: string, alt?: string, date?: string, datetime?: string, author?: string, url?: string}>  $items
     */
    public function __construct(
        public array $items = [],
        public string $eyebrow = 'Blogs and Insights',
        public string $title = 'Latest Insights from Our Experts',
        public string $subtitle = 'We build digital experiences that help brands grow through design, development, branding, and marketing.',
        public string $headingId = 'articles-insights-title',
        public string $moreHref = '/blogs',
        public string $moreLabel = 'View More',
        public string $sectionClass = 'py-12 lg:py-18',
        public bool $initSwiper = true,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.articles-insights-section');
    }
}
