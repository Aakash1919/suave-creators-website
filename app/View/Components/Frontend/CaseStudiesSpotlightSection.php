<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CaseStudiesSpotlightSection extends Component
{
    /**
     * @param  array<int, array<string, mixed>>  $items
     */
    public function __construct(
        public array $items = [],
        public string $eyebrow = 'Case Studies',
        public string $title = 'Work that proves the craft',
        public string $subtitle = 'Real products we designed and shipped — selected for this page.',
        public string $headingId = 'case-studies-spotlight-title',
        public string $moreHref = '',
        public string $moreLabel = 'View all case studies',
        public string $sectionClass = '',
    ) {
        if ($this->moreHref === '') {
            $this->moreHref = route('case-studies');
        }

        $this->items = array_values(array_map(function (array $item): array {
            $title = (string) ($item['title'] ?? '');
            $slug = (string) ($item['slug'] ?? '');
            $stats = is_array($item['results'] ?? null) ? array_slice($item['results'], 0, 2) : [];

            return [
                'slug' => $slug,
                'title' => $title,
                'client' => (string) ($item['client'] ?? ''),
                'subtitle' => trim((string) ($item['listing_subtitle'] ?? '')) !== ''
                    ? (string) $item['listing_subtitle']
                    : (string) ($item['industry'] ?? ''),
                'description' => (string) ($item['short_description'] ?? ''),
                'image' => (string) ($item['image'] ?? ''),
                'url' => $slug !== '' ? route('case-study.show', ['slug' => $slug]) : route('case-studies'),
                'stats' => $stats,
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.case-studies-spotlight-section');
    }
}
