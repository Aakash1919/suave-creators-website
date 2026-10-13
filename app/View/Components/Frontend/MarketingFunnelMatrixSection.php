<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarketingFunnelMatrixSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array{before?: string, accent?: string, after?: string}|string  $title
     * @param  list<string|array{label: string, icon?: string, iconAlt?: string}>  $columns
     * @param  list<array{index?: string, stage: string, subtitle: string, seo: string, ppc: string, content: string, social: string, icon?: string, iconAlt?: string, theme?: string}>  $rows
     * @param  list<array{index?: string, title?: string, body: string, icon?: string, iconAlt?: string, theme?: string}>  $examples
     * @param  array{icon?: string, iconAlt?: string, title: string, body: string}  $aiVisibility
     */
    public function __construct(
        public string $eyebrow = 'Full-funnel thinking',
        public array|string $title = 'How Our Digital Marketing Services Work Together',
        public string $description = '',
        public array $columns = [],
        public array $rows = [],
        public string $examplesIntro = '',
        public array $examples = [],
        public array $aiVisibility = [],
        public string $backgroundImage = 'assets/background/marketing-funnel-matrix-bg.webp',
        public string $headingId = 'digital-marketing-funnel-heading',
        public string $sectionId = 'integrated',
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);
    }

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
        return view('components.frontend.marketing-funnel-matrix-section');
    }
}
