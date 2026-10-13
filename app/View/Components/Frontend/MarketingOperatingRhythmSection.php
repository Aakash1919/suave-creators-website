<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarketingOperatingRhythmSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  list<array{title: string, description: string, image?: string, imageAlt?: string, icon?: string, iconAlt?: string}>  $items
     */
    public function __construct(
        public string $eyebrow = 'A clear operating rhythm',
        public string $title = 'How We Work',
        public array $items = [],
        public string $headingId = 'digital-marketing-how-we-work-heading',
    ) {
        $this->items = array_values(array_map(function (array $item): array {
            $image = (string) ($item['image'] ?? '');
            $icon = (string) ($item['icon'] ?? '');

            return [
                'title' => (string) ($item['title'] ?? ''),
                'description' => (string) ($item['description'] ?? ''),
                'image' => $image !== '' ? $this->normalizeAssetPath($image) : '',
                'imageAlt' => (string) ($item['imageAlt'] ?? ''),
                'icon' => $icon !== '' ? $this->normalizeAssetPath($icon) : '',
                'iconAlt' => (string) ($item['iconAlt'] ?? ''),
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.marketing-operating-rhythm-section');
    }
}
