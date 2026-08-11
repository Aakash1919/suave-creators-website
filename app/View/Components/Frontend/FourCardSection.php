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
        public string $eyebrow = 'Industries We Serve',
        public string $title = 'The Technology Behind Our Solutions',
        public string $subtitle = 'We use modern development frameworks to create smart software solutions that are fast, flexible, and designed for long-term growth. From AI to cloud computing, we integrate technologies that help businesses stay ahead of the curve.',
        public array $items = [],
        public string $headingId = 'four-card-title',
        public string $backgroundImage = 'assets/background/technology-section-bg.png',
        public string $ctaHref = '',
        public string $ctaLabel = 'Book a Consultation',
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        if ($this->ctaHref === '') {
            $this->ctaHref = ContactSupport::demoHref();
        }

        if ($this->items === []) {
            $this->items = [
                ['Laravel', 'Laravel is ideal for high-performing, data-driven, enterprise-level web solutions.', 'fa-laravel', '#FF2D20'],
                ['React', 'We create responsive user experiences for modern web and mobile applications.', 'fa-react', '#149ECA'],
                ['Angular', 'We build dynamic, modular architectures with strong performance and security.', 'fa-angular', '#DD0031'],
                ['Node.js', 'It powers real-time data processing and scalable server-side applications.', 'fa-node-js', '#68A063'],
                ['Vue.js', 'We create flexible user interfaces and fast single-page applications.', 'fa-vuejs', '#42B883'],
                ['WordPress', 'The popular CMS for websites, blogs, and e-commerce solutions.', 'fa-wordpress', '#21759B'],
                ['Shopify', 'Secure payments and inventory management for high-converting online stores.', 'fa-shopify', '#7AB55C'],
                ['Magento', 'Robust catalog management, multi-store setups, and personalized shopping.', 'fa-magento', '#F26322'],
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
