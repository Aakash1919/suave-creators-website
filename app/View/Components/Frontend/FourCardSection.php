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
        public string $eyebrow = 'TECH ECOSYSTEM',
        public string $title = 'Modern Technologies, Frameworks & Cloud Infrastructure',
        public string $subtitle = 'We engineer digital solutions using modern, scalable, and battle-tested frameworks tailored to your platform \'s long-term performance and maintainability.',
        public array $items = [],
        public string $headingId = 'four-card-title',
        public string $backgroundImage = 'assets/background/technology-section-bg.png',
        public string $ctaHref = '',
        public string $ctaLabel = 'Book a Technical Consultation →',
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        if ($this->ctaHref === '') {
            $this->ctaHref = ContactSupport::demoHref();
        }

        if ($this->items === []) {
            $this->items = [
                ['Laravel (PHP)', ' Our primary backend framework for robust, secure APIs, complex database migrations, and high-performance enterprise applications.', 'fa-laravel', '#FF2D20'],
                ['React & React Native', ' Building responsive web frontends and cross-platform mobile apps with sub-second rendering and shared component logic.', 'fa-react', '#149ECA'],
                ['Angular', 'Structured, enterprise-grade TypeScript frontend architectures for complex administration portals requiring modular dependency injection.', 'fa-angular', '#DD0031'],
                ['Node.js', 'Event-driven, high-concurrency microservices, real-time websocket integrations, and lightweight streaming API backends.', 'fa-node-js', '#68A063'],
                ['Vue.js', ' Lightweight, reactive web interfaces and progressive single-page applications optimized for seamless user interaction.', 'fa-vuejs', '#42B883'],
                ['WordPress & Headless CMS', 'Custom theme engineering, decoupled publishing environments, and secure enterprise content management setups.', 'fa-wordpress', '#21759B'],
                [' Shopify Plus', 'Custom Shopify theme development, private app integrations, and headless storefronts for high-volume merchants.', 'fa-shopify', '#7AB55C'],
                ['Magento (Adobe Commerce)', 'Enterprise B2B digital commerce, complex multi-store catalogs, and multi-currency global retail platforms.', 'fa-magento', '#F26322'],
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
