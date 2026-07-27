<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\AboutSupport;
use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TechPartnershipsSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{label: string, src: string, alt: string}>|null  $items
     */
    public function __construct(
        public ?array $items = null,
        public string $sectionClass = 'full-bleed full-bleed--edge bg-white py-10 lg:py-14',
        public string $backgroundImage = '',
        public string $ariaLabel = 'Technologies and partnerships',
        public string $eyebrow = 'Technologies & Partnerships',
    ) {
        $this->items ??= AboutSupport::techStack();
        $this->backgroundImage = $this->backgroundImage !== ''
            ? $this->normalizeAssetPath($this->backgroundImage)
            : '';

        $this->items = array_values(array_map(function (array $item): array {
            return [
                'label' => (string) ($item['label'] ?? ''),
                'src' => $this->normalizeAssetPath((string) ($item['src'] ?? '')),
                'alt' => (string) ($item['alt'] ?? ($item['label'] ?? 'Technology partner logo')),
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.tech-partnerships-section');
    }
}
