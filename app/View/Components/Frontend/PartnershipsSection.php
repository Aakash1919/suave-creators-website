<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use App\Support\Frontend\HomeSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PartnershipsSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{src: string, alt: string}>|null  $items
     */
    public function __construct(
        public ?array $items = null,
        public string $eyebrow = 'Our Partnerships & Growth Stack',
        public string $ariaLabel = 'Client partnerships',
        public string $backgroundImage = 'assets/background/portfolio-section-pattern-bg.png',
    ) {
        $this->items ??= HomeSupport::partnerMarqueeItems();
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        $this->items = array_values(array_map(function (array $item): array {
            $alt = (string) ($item['alt'] ?? $item['logoAlt'] ?? 'Partner logo');

            return [
                'src' => $this->normalizeAssetPath((string) ($item['src'] ?? '')),
                'alt' => $alt,
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.partnerships-section');
    }
}
