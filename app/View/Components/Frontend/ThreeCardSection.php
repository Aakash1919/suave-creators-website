<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ThreeCardSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{0?: string, 1?: string, 2?: string, 3?: string, 4?: string, icon?: string, category?: string, title?: string, description?: string, tone?: string, href?: string, iconAlt?: string}>  $items
     */
    public function __construct(
        public string $eyebrow = 'Core capabilities',
        public string $title = 'Custom software development services',
        public string $subtitle = 'Six services, one team. Each is built to automate operations, connect your data and scale without per-seat fees.',
        public array $items = [],
        public string $headingId = 'three-card-title',
        public string $backgroundImage = 'assets/background/web-services-section-bg.png',
        public string $ctaHref = '',
        public string $ctaLabel = 'All software development services',
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        if ($this->ctaHref === '') {
            $this->ctaHref = route('services');
        }

        if ($this->items === []) {
            $this->items = [
                ['assets/icons/custom-crm-icon.svg', 'Custom CRM development', 'Custom CRM development', 'Pipelines, lead scoring, two-way email and calendar sync, and dashboards designed around your sales process.', 'mint', 'Custom CRM development icon for sales and customer management software', route('service.show', ['slug' => 'custom-crm-development']), 'Explore custom CRM development'],
                ['assets/icons/enterprise-software-icon.svg', 'Custom ERP and operations software', 'Custom ERP and operations software', 'Inventory, procurement, billing and multi-warehouse logistics in one system, without per-module licence fees.', 'orange', 'Custom ERP development icon for operations software', route('service.show', ['slug' => 'enterprise-software-solutions']), 'See custom ERP development'],
                ['assets/icons/web-development-icon.svg', 'Enterprise web application development', 'Enterprise web application development', 'Secure, high-traffic web platforms and customer portals built with Laravel, React and Node.js.', 'blue', 'Web application development icon for custom web platforms', route('service.show', ['slug' => 'web-development-services']), 'View web application development'],
                ['assets/icons/ai-solutions-icon.svg', 'AI integration and workflow automation', 'AI integration and workflow automation', 'AI agents, document processing and natural-language search added to the systems you already run.', 'amber', 'AI integration service icon for workflow automation', route('service.show', ['slug' => 'ai-solutions']), 'Explore AI integration services'],
                ['assets/icons/ecommerce-development-icon.svg', 'E-commerce platform development', 'E-commerce platform development', 'Custom and headless commerce on Shopify Plus, Magento or a custom stack, built for large catalogs and fast checkout.', 'rose', 'Ecommerce development icon for online store platforms', route('service.show', ['slug' => 'e-commerce-development']), 'See e-commerce development'],
                ['assets/icons/ui-ux-design-icon.svg', 'UI/UX product design', 'UI/UX product design', 'Research, wireframes and Figma design systems that make complex internal tools easy to adopt.', 'cyan', 'UI UX design services icon for product interfaces', route('service.show', ['slug' => 'ui-ux-design-services']), 'View UI/UX design services'],
            ];
        }

        $this->items = array_values(array_map(function (array $item): array {
            $title = (string) ($item['title'] ?? $item[2] ?? '');

            return [
                'icon' => $this->normalizeImageAssetPath((string) ($item['icon'] ?? $item[0] ?? '')),
                'category' => (string) ($item['category'] ?? $item[1] ?? ''),
                'title' => $title,
                'description' => (string) ($item['description'] ?? $item[3] ?? ''),
                'tone' => (string) ($item['tone'] ?? $item[4] ?? 'blue'),
                'iconAlt' => (string) ($item['iconAlt'] ?? $item[5] ?? ($title !== '' ? $title.' service icon' : 'Suave Creators service icon')),
                'href' => (string) ($item['href'] ?? $item[6] ?? route('services')),
                'linkLabel' => (string) ($item['linkLabel'] ?? $item[7] ?? ''),
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.three-card-section');
    }
}
