<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CoreValuesSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{title?: string, desc?: string, image?: string, alt?: string, icon?: string}>  $items
     */
    public function __construct(
        public array $items = [],
        public string $eyebrow = 'Our Process',
        public string $title = '',
        public string $description = '',
        public string $titleId = '',
        public string $gridClass = '',
        public string $backgroundImage = 'assets/background/core-values-section-bg.png',
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        $this->items = array_values(array_map(function (array $item): array {
            $title = (string) ($item['title'] ?? '');
            $image = (string) ($item['image'] ?? '');

            return [
                'title' => $title,
                'desc' => (string) ($item['desc'] ?? ''),
                'image' => $image !== '' ? $this->normalizeAssetPath($image) : '',
                'alt' => (string) ($item['alt'] ?? ($title !== ''
                    ? $title.' process step for Suave Creators software delivery'
                    : 'Suave Creators process step visual')),
                'icon' => (string) ($item['icon'] ?? ''),
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.core-values-section');
    }
}
