<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarketingChannelDetailSection extends Component
{
    /**
     * @param  list<array{title: string, description: string}>  $covers
     */
    public function __construct(
        public string $index = '01',
        public string $total = '04',
        public string $title = 'Search Engine Optimization (SEO)',
        public string $intro = '',
        public string $introHighlight = 'SEO service',
        public string $coversHeading = 'What our SEO service covers',
        public array $covers = [],
        public string $calloutLabel = 'When SEO is the right investment',
        public string $calloutBody = '',
        public string $headingId = 'marketing-channel-detail-heading',
        public string $sectionId = '',
        public string $icon = 'search',
    ) {}

    public function indexLabel(): string
    {
        return $this->index.'/'.$this->total;
    }

    /**
     * Split intro so the highlight phrase can be styled blue/bold.
     *
     * @return array{before: string, highlight: string, after: string}
     */
    public function introParts(): array
    {
        $intro = $this->intro;
        $highlight = $this->introHighlight;

        if ($highlight === '' || ! str_contains($intro, $highlight)) {
            return [
                'before' => $intro,
                'highlight' => '',
                'after' => '',
            ];
        }

        $parts = explode($highlight, $intro, 2);

        return [
            'before' => $parts[0] ?? '',
            'highlight' => $highlight,
            'after' => $parts[1] ?? '',
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.marketing-channel-detail-section');
    }
}
