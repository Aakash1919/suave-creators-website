<?php

namespace App\View\Components\Layouts;

use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * @var array<int, array{label: string, slug: string, hubRoute: string, id: string, items: array<int, array<string, mixed>>}>
     */
    public array $dropdowns;

    /**
     * @param  array<string, array<int, array{href?: string, label: string, icon: string, route?: string, params?: array<string, string>}>>|null  $dropdowns
     */
    public function __construct(
        public string $phone = '+91 88949 00142',
        public string $phoneHref = 'tel:+918894900142',
        public string $usPhone = '+1 (307) 435-9605',
        public string $usPhoneHref = 'tel:+13074359605',
        public string $ctaRoute = 'contact-us',
        public string $ctaFragment = 'contact-id',
        public string $ctaLabel = 'Talk to a Solution Architect',
        public string $ctaLabelShort = 'Talk to us',
        ?array $dropdowns = null,
    ) {
        $dropdowns ??= [
            'Services' => [
                ['route' => 'service.show', 'params' => ['slug' => 'web-development-services'], 'label' => 'Web Development', 'icon' => 'fa-solid fa-laptop-code'],
                ['route' => 'service.show', 'params' => ['slug' => 'custom-crm-development'], 'label' => 'CRM Development', 'icon' => 'fa-solid fa-users'],
                ['route' => 'service.show', 'params' => ['slug' => 'enterprise-software-solutions'], 'label' => 'Enterprise Software', 'icon' => 'fa-solid fa-building'],
                ['route' => 'service.show', 'params' => ['slug' => 'e-commerce-development'], 'label' => 'E-commerce', 'icon' => 'fa-solid fa-cart-shopping'],
                ['route' => 'service.show', 'params' => ['slug' => 'ui-ux-design-services'], 'label' => 'UI/UX Design', 'icon' => 'fa-solid fa-pen-ruler'],
                ['route' => 'service.show', 'params' => ['slug' => 'ai-solutions'], 'label' => 'AI Solutions', 'icon' => 'fa-solid fa-robot'],
            ],
            'Industries' => [
                ['route' => 'industry.show', 'params' => ['slug' => 'healthcare'], 'label' => 'Healthcare', 'icon' => 'fa-solid fa-heart-pulse'],
                ['route' => 'industry.show', 'params' => ['slug' => 'it-software-solutions-for-startups'], 'label' => 'Startups & SaaS', 'icon' => 'fa-solid fa-rocket'],
                ['route' => 'industry.show', 'params' => ['slug' => 'finance-banking-software-development'], 'label' => ' FinTech & Banking', 'icon' => 'fa-solid fa-building-columns'],
                ['route' => 'industry.show', 'params' => ['slug' => 'retail-ecommerce-solutions'], 'label' => 'Retail & E-Commerce', 'icon' => 'fa-solid fa-store'],
                ['route' => 'industry.show', 'params' => ['slug' => 'logistics-supply-chain-apps'], 'label' => 'Logistics & Fleet', 'icon' => 'fa-solid fa-truck'],
                ['route' => 'industry.show', 'params' => ['slug' => 'education-elearning-platforms'], 'label' => ' EdTech', 'icon' => 'fa-solid fa-graduation-cap'],
            ],
        ];

        $this->dropdowns = collect($dropdowns)
            ->map(function (array $items, string $label): array {
                $slug = Str::lower($label);
                $hubRoute = $slug === 'services' ? 'services' : 'industries';

                return [
                    'label' => $label,
                    'slug' => $slug,
                    'hubRoute' => $hubRoute,
                    'id' => 'mobile-nav-'.$slug,
                    'items' => array_values(array_map(function (array $item): array {
                        $item['href'] = isset($item['route'])
                            ? route($item['route'], $item['params'] ?? [])
                            : route($item['route'] ?? 'home');

                        return $item;
                    }, $items)),
                ];
            })
            ->values()
            ->all();
    }

    public function ctaHref(): string
    {
        return ContactSupport::demoHref();
    }

    public function contactHref(): string
    {
        $href = route($this->ctaRoute);

        return $this->ctaFragment !== ''
            ? $href.'#'.$this->ctaFragment
            : $href;
    }

    public function isNavActive(string ...$patterns): bool
    {
        return request()->routeIs(...$patterns);
    }

    public function isDropdownActive(array $dropdown): bool
    {
        return $dropdown['hubRoute'] === 'services'
            ? $this->isNavActive('services', 'service.show')
            : $this->isNavActive('industries', 'industry.show');
    }

    public function isNavHrefActive(string $href): bool
    {
        $path = parse_url($href, PHP_URL_PATH) ?: '/';

        return request()->is(ltrim($path, '/'));
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.header');
    }
}
