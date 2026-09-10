<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IndustriesSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{icon?: string, title?: string, text?: string, href?: string, step?: string, image?: string, 0?: string, 1?: string, 2?: string}>|null  $cards
     */
    public function __construct(
        public ?array $cards = null,
        public string $eyebrow = 'SECTOR EXPERTISE',
        public string $title = 'Custom Software Architecture for Specialized & Regulated Industries',
        public string $description = 'We build compliant, high-security software tailored to the operational demands and regulatory standards of each sector.',
        public string $headingId = 'industries-title',
        public string $backgroundImage = 'assets/background/industries-section-bg.png',
        public string $variant = 'default',
        public string $footerHref = '',
        public string $footerLabel = '',
        public bool $showSupportAside = false,
        public string $supportText = 'The Services and Supports You Need for Online Platforms in Suave Creators',
        public string $supportHref = '',
        public string $supportLabel = 'Schedule an Industry-Specific Consultation',
        public string $supportImage = 'assets/brand/chat-widget-icon.png',
        public string $supportImageAlt = 'Chat support widget for Suave Creators software development services',
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);
        $this->supportImage = $this->normalizeAssetPath($this->supportImage);

        if ($this->footerHref === '' && $this->footerLabel !== '') {
            $this->footerHref = ContactSupport::demoHref();
        }

        if ($this->supportHref === '') {
            $this->supportHref = ContactSupport::demoHref();
        }

        $this->cards ??= [
            ['icon' => 'fa-solid fa-heart-pulse', 'title' => 'Healthcare', 'text' => 'HIPAA-compliant patient portals, telehealth integrations, automated appointment workflows, and secure medical data management', 'href' => route('industry.show', ['slug' => 'healthcare'])],
            ['icon' => 'fa-solid fa-gears', 'title' => 'Startups & SaaS', 'text' => 'Accelerated MVP development, scalable cloud backends, and multi-tenant architectures engineered to help funded startups scale.', 'href' => route('industry.show', ['slug' => 'it-software-solutions-for-startups'])],
            ['icon' => 'fa-solid fa-landmark', 'title' => 'Finance & FinTech', 'text' => 'Zero-trust banking architectures, secure payment processing gateways, automated billing ledgers, and compliance auditing tools.', 'href' => route('industry.show', ['slug' => 'finance-banking-software-development'])],
            ['icon' => 'fa-solid fa-cart-shopping', 'title' => 'Retail & E-Commerce', 'text' => 'High-volume omnichannel platforms, custom inventory management, dynamic pricing engines, and headless commerce builds.', 'href' => route('industry.show', ['slug' => 'retail-ecommerce-solutions'])],
            ['icon' => 'fa-solid fa-truck-fast', 'title' => 'Logistics & Supply Chain', 'text' => 'Real-time fleet tracking, automated carrier dispatch, route optimization algorithms, and warehouse inventory sync. ', 'href' => route('industry.show', ['slug' => 'logistics-supply-chain-apps'])],
            ['icon' => 'fa-solid fa-laptop-file', 'title' => 'Education & E-Learning', 'text' => 'Scalable LMS platforms, interactive student testing portals, video streaming infrastructure, and certification management.', 'href' => route('industry.show', ['slug' => 'education-elearning-platforms'])],
        ];

        $this->cards = array_values(array_map(function (array $card): array {
            $image = (string) ($card['image'] ?? '');

            return [
                'icon' => (string) ($card['icon'] ?? $card[0] ?? ''),
                'title' => (string) ($card['title'] ?? $card[1] ?? ''),
                'text' => (string) ($card['text'] ?? $card[2] ?? ''),
                'href' => (string) ($card['href'] ?? ''),
                'step' => (string) ($card['step'] ?? ''),
                'image' => $image !== '' ? $this->normalizeAssetPath($image) : '',
            ];
        }, $this->cards));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.industries-section');
    }
}
