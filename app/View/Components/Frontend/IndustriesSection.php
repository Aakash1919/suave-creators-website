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
        public string $eyebrow = 'Industries We Serve',
        public string $title = 'Industries We Serve',
        public string $description = 'Empowering multiple industries with tailored digital and smart solutions designed to drive growth, innovation, and long-lasting impact.',
        public string $headingId = 'industries-title',
        public string $backgroundImage = 'assets/background/industries-section-bg.png',
        public string $variant = 'default',
        public string $footerHref = '',
        public string $footerLabel = '',
        public bool $showSupportAside = false,
        public string $supportText = 'The Services and Supports You Need for Online Platforms in Suave Creators',
        public string $supportHref = '',
        public string $supportLabel = 'Talk to an Expert',
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
            ['icon' => 'fa-solid fa-heart-pulse', 'title' => 'Custom Healthcare Software Development Services', 'text' => 'By leveraging our deep industry expertise and top-level technologies, such as AI and chatbots, we develop innovative healthcare software solutions designed to improve care and efficiency.'],
            ['icon' => 'fa-solid fa-gears', 'title' => 'IT Services for Startups with Innovative Technology', 'text' => 'Get tailored IT services and software development solutions that empower startups to innovate, grow, and compete in a fast-paced digital economy.'],
            ['icon' => 'fa-solid fa-landmark', 'title' => 'We develop Smart Financial Software', 'text' => 'We help you create secure banking and financial solutions, from mobile banking experiences to comprehensive software for financial institutions.'],
            ['icon' => 'fa-solid fa-cart-shopping', 'title' => 'Elevating E-Commerce With AI-Powered Solutions', 'text' => 'We develop next-generation, reliable, and feature-rich e-commerce solutions that empower businesses, delight customers, and improve sales performance.'],
            ['icon' => 'fa-solid fa-truck-fast', 'title' => 'We develop Logistics & Supply Chain Apps', 'text' => 'We build logistics software that helps supply chains move faster with greater speed, reliability, visibility, and cost efficiency.'],
            ['icon' => 'fa-solid fa-laptop-file', 'title' => 'E-Learning Software Development Services', 'text' => 'We deliver education and e-learning software for schools, colleges, training platforms, and online learning portals.'],
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
