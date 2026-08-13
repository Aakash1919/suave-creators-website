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
        public string $ctaLabel = 'Talk to an expert',
        public string $ctaLabelShort = 'Talk to us',
        ?array $dropdowns = null,
    ) {
        $dropdowns ??= [
            'Services' => [
                ['route' => 'service.show', 'params' => ['slug' => 'web-development-services'], 'label' => 'Web Development Service', 'icon' => 'fa-solid fa-laptop-code'],
                ['route' => 'service.show', 'params' => ['slug' => 'custom-crm-development'], 'label' => 'CRM Development Service', 'icon' => 'fa-solid fa-users'],
                ['route' => 'service.show', 'params' => ['slug' => 'enterprise-software-solutions'], 'label' => 'Enterprise Software Solutions', 'icon' => 'fa-solid fa-building'],
                ['route' => 'service.show', 'params' => ['slug' => 'e-commerce-development'], 'label' => 'E-commerce Development Service', 'icon' => 'fa-solid fa-cart-shopping'],
            ],
            'Industry' => [
                ['route' => 'industry.show', 'params' => ['slug' => 'healthcare'], 'label' => 'Healthcare', 'icon' => 'fa-solid fa-heart-pulse'],
                ['route' => 'industry.show', 'params' => ['slug' => 'it-software-solutions-for-startups'], 'label' => 'IT & Software Solutions for Startups', 'icon' => 'fa-solid fa-rocket'],
                ['route' => 'industry.show', 'params' => ['slug' => 'finance-banking-software-development'], 'label' => 'Finance & Banking', 'icon' => 'fa-solid fa-building-columns'],
                ['route' => 'industry.show', 'params' => ['slug' => 'retail-ecommerce-solutions'], 'label' => 'Retail & E-commerce', 'icon' => 'fa-solid fa-store'],
                ['route' => 'industry.show', 'params' => ['slug' => 'logistics-supply-chain-apps'], 'label' => 'Logistics & Supply Chain', 'icon' => 'fa-solid fa-truck'],
                ['route' => 'industry.show', 'params' => ['slug' => 'education-elearning-platforms'], 'label' => 'Education & E-learning', 'icon' => 'fa-solid fa-graduation-cap'],
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
