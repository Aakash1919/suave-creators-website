<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FourCardSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{0?: string, 1?: string, 2?: string, 3?: string, title?: string, description?: string, icon?: string, color?: string}>  $items
     */
    public function __construct(
        public string $eyebrow = 'Tech ecosystem',
        public string $title = 'Technologies and frameworks we use',
        public string $subtitle = 'We use proven, well-supported frameworks so your software is easy to maintain and hire for long after launch.',
        public array $items = [],
        public string $headingId = 'four-card-title',
        public string $backgroundImage = 'assets/background/technology-section-bg.png',
        public string $ctaHref = '',
        public string $ctaLabel = 'Talk to a Solution Architect',
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        if ($this->ctaHref === '') {
            $this->ctaHref = ContactSupport::demoHref();
        }

        if ($this->items === []) {
            $this->items = [
                ['Laravel (PHP)', 'Our primary back-end framework for secure APIs and complex business logic.', 'fa-laravel', '#FF2D20'],
                ['React and React Native', 'Responsive web front ends and cross-platform mobile apps.', 'fa-react', '#149ECA'],
                ['Angular', 'Structured TypeScript front ends for large admin portals.', 'fa-angular', '#DD0031'],
                ['Node.js', 'Real-time features, WebSockets and lightweight API services.', 'fa-node-js', '#68A063'],
                ['Vue.js', 'Lightweight, reactive interfaces and single-page apps.', 'fa-vuejs', '#42B883'],
                ['WordPress and headless CMS', 'Custom themes and decoupled publishing.', 'fa-wordpress', '#21759B'],
                ['Shopify Plus', 'Custom themes, private apps and headless storefronts.', 'fa-shopify', '#7AB55C'],
                ['Magento (Adobe Commerce)', 'Multi-store B2B and multi-currency commerce.', 'fa-magento', '#F26322'],
            ];
        }

        $this->items = array_values(array_map(function (array $item): array {
            return [
                'title' => (string) ($item['title'] ?? $item[0] ?? ''),
                'description' => (string) ($item['description'] ?? $item[1] ?? ''),
                'icon' => (string) ($item['icon'] ?? $item[2] ?? ''),
                'color' => (string) ($item['color'] ?? $item[3] ?? '#2A4DFB'),
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.four-card-section');
    }
}
