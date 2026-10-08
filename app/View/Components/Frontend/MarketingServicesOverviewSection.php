<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarketingServicesOverviewSection extends Component
{
    /**
     * @param  array{before?: string, accent?: string, after?: string}|string  $title
     * @param  list<string>  $columns
     * @param  list<array{service: string, anchor?: string, does: string, bestFor: string, measured: string}>  $rows
     */
    public function __construct(
        public array|string $title = 'Digital Marketing Services That Drive Business Growth',
        public string $description = '',
        public array $columns = [],
        public array $rows = [],
        public string $headingId = 'digital-marketing-overview-heading',
        public string $sectionId = 'overview',
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

    public function render(): View|Closure|string
    {
        return view('components.frontend.marketing-services-overview-section');
    }
}
