<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * @param  array<string, array<int, array{href: string, label: string, icon: string}>>|null  $dropdowns
     */
    public function __construct(
        public string $phone = '+91 88949 00142',
        public string $phoneHref = 'tel:+918894900142',
        public string $ctaHref = '/contact-us/#contact-id',
        public string $ctaLabel = 'Talk to an expert',
        public string $ctaLabelShort = 'Talk to us',
        public string $logo = '/images/white_logo.svg',
        public ?array $dropdowns = null,
    ) {
        $this->dropdowns ??= [
            'Services' => [
                ['href' => '/service/web-development-services', 'label' => 'Web Development Service', 'icon' => 'fa-solid fa-laptop-code'],
                ['href' => '/service/custom-crm-development', 'label' => 'CRM Development Service', 'icon' => 'fa-solid fa-users'],
                ['href' => '/service/enterprise-software-solutions', 'label' => 'Enterprise Software Solutions', 'icon' => 'fa-solid fa-building'],
                ['href' => '/service/e-commerce-development', 'label' => 'E-commerce Development Service', 'icon' => 'fa-solid fa-cart-shopping'],
            ],
            'Industry' => [
                ['href' => '/industries/healthcare', 'label' => 'Healthcare', 'icon' => 'fa-solid fa-heart-pulse'],
                ['href' => '/industries/it-software-solutions-for-startups', 'label' => 'IT & Software Solutions for Startups', 'icon' => 'fa-solid fa-rocket'],
                ['href' => '/industries/finance-banking-software-development', 'label' => 'Finance & Banking', 'icon' => 'fa-solid fa-building-columns'],
                ['href' => '/industries/retail-ecommerce-solutions', 'label' => 'Retail & E-commerce', 'icon' => 'fa-solid fa-store'],
                ['href' => '/industries/logistics-supply-chain-apps', 'label' => 'Logistics & Supply Chain', 'icon' => 'fa-solid fa-truck'],
                ['href' => '/industries/education-elearning-platforms', 'label' => 'Education & E-learning', 'icon' => 'fa-solid fa-graduation-cap'],
            ],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.header');
    }
}
