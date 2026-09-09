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
        public string $eyebrow = 'CORE CAPABILITIES',
        public string $title = 'Specialized Software Development & Digital Engineering Services',
        public string $subtitle = 'Tailored engineering solutions built to automate operations, improve customer experience, and scale without constraints.',
        public array $items = [],
        public string $headingId = 'three-card-title',
        public string $backgroundImage = 'assets/background/web-services-section-bg.png',
        public string $ctaHref = '',
        public string $ctaLabel = 'Explore All Engineering Capabilities →',
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);

        if ($this->ctaHref === '') {
            $this->ctaHref = route('services');
        }

        if ($this->items === []) {
            $this->items = [
                ['assets/icons/web-development-icon.svg', '01 — Web Application Development', 'Custom Web Applications', 'Robust, secure, and data-intensive web platforms tailored to your business logic, engineered for millions of requests.', 'blue', 'Web development service icon for custom web applications', route('service.show', ['slug' => 'web-development-services'])],
                ['assets/icons/enterprise-software-icon.svg', '02 — Enterprise Software Solutions', ' Enterprise Software Engineering', ' Modernize legacy platforms, automate departmental workflows, and connect fragmented tools with custom enterprise architectures.', 'orange', 'Enterprise software solutions icon for secure business platforms', route('service.show', ['slug' => 'enterprise-software-solutions'])],
                ['assets/icons/ui-ux-design-icon.svg', '03 — UI/UX Product Design', 'UI/UX Design Services', 'User-focused research, interactive wireframing, and custom design tokens built to drive engagement and user retention.', 'cyan', 'UI UX design services icon for user-focused product interfaces', route('service.show', ['slug' => 'ui-ux-design-services'])],
                ['assets/icons/custom-crm-icon.svg', '04 — Custom CRM Development', 'Bespoke CRM & ERP Solutions', 'Eliminate high per-seat SaaS costs with custom CRM architectures featuring automated pipelines, AI scoring, and two-way sync.', 'mint', 'Custom CRM development icon for sales and customer management software', route('service.show', ['slug' => 'custom-crm-development'])],
                ['assets/icons/ecommerce-development-icon.svg', '05 - E-commerce Development', 'High-Throughput E-Commerce', 'Custom digital commerce platforms with advanced catalog matrices, multi-warehouse logistics, and sub-second checkout speeds.', 'rose', 'Ecommerce development icon for online store and shopping platforms', route('service.show', ['slug' => 'e-commerce-development'])],
                ['assets/icons/ai-solutions-icon.svg', '06 — Applied AI Solutions', 'Applied AI & Model Integration', 'Integrate proprietary intelligence: custom AI agents, automated workflow scrapers, and natural language retrieval pipelines.', 'amber', 'AI solutions icon for intelligent software and automation features', route('service.show', ['slug' => 'ai-solutions'])],
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
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.three-card-section');
    }
}
