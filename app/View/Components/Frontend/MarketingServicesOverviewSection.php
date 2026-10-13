<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarketingServicesOverviewSection extends Component
{
    /**
     * @param  array{before?: string, accent?: string, after?: string}|string  $title
     * @param  list<array{service: string, anchor?: string, theme?: string, icon?: string, does: string, bestFor: string, measured: string, ctaLabel?: string}>  $rows
     */
    public function __construct(
        public array|string $title = 'Digital Marketing Services That Drive Business Growth',
        public string $eyebrow = '',
        public string $description = '',
        public string $descriptionHighlight = 'Suave Creators',
        public array $rows = [],
        public string $headingId = 'digital-marketing-overview-heading',
        public string $sectionId = 'overview',
        public string $ctaLabel = 'Explore service',
    ) {}

    /**
     * @return array{before: string, accent: string, after: string}
     */
    public function titleParts(): array
    {
        if (is_array($this->title)) {
            return [
                'before' => (string) ($this->title['before'] ?? ''),
                'accent' => (string) ($this->title['accent'] ?? ''),
                'after' => (string) ($this->title['after'] ?? ''),
            ];
        }

        return [
            'before' => (string) $this->title,
            'accent' => '',
            'after' => '',
        ];
    }

    /**
     * @return array{before: string, highlight: string, after: string}
     */
    public function descriptionParts(): array
    {
        $description = $this->description;
        $highlight = trim($this->descriptionHighlight);

        if ($description === '' || $highlight === '') {
            return [
                'before' => $description,
                'highlight' => '',
                'after' => '',
            ];
        }

        $position = mb_stripos($description, $highlight);

        if ($position === false) {
            return [
                'before' => $description,
                'highlight' => '',
                'after' => '',
            ];
        }

        $length = mb_strlen($highlight);

        return [
            'before' => mb_substr($description, 0, $position),
            'highlight' => mb_substr($description, $position, $length),
            'after' => mb_substr($description, $position + $length),
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.marketing-services-overview-section');
    }
}
