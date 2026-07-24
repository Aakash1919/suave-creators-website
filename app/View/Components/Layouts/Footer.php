<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * @param  array<string, array<int, array{href: string, label: string}>>|null  $columns
     * @param  array<int, array{href: string, label: string, icon: string}>|null  $socialLinks
     */
    public function __construct(
        public string $ctaText = "Got a project? Let's talk",
        public string $logo = '/images/gradient-logo.svg',
        public string $backgroundImage = '/images/footer-bg.png',
        public string $phone = '+91 97369 00142',
        public string $phoneHref = 'tel:+919736900142',
        public string $email = 'Info@suavecreators.com',
        public string $address = '30 N Gould St, STE R Sheridan, WY 82801, USA',
        public ?string $year = null,
        public ?array $columns = null,
        public ?array $socialLinks = null,
    ) {
        $this->year ??= date('Y');

        $this->columns ??= [
            'Services' => [
                ['href' => '/service/web-development-services', 'label' => 'Web Development'],
                ['href' => '/service/custom-crm-development', 'label' => 'CRM Development'],
                ['href' => '/service/enterprise-software-solutions', 'label' => 'Enterprise Software'],
                ['href' => '/service/e-commerce-development', 'label' => 'E-commerce Software'],
            ],
            'Industry' => [
                ['href' => '/industries/healthcare', 'label' => 'Healthcare'],
                ['href' => '/industries/it-software-solutions-for-startups', 'label' => 'IT Solutions'],
                ['href' => '/industries/finance-banking-software-development', 'label' => 'Banking'],
                ['href' => '/industries/retail-ecommerce-solutions', 'label' => 'E-commerce'],
                ['href' => '/industries/logistics-supply-chain-apps', 'label' => 'Logistics'],
                ['href' => '/industries/education-elearning-platforms', 'label' => 'Education'],
            ],
            'Product' => [
                ['href' => '/product', 'label' => 'HR Module'],
                ['href' => '/product', 'label' => 'Attendance & Holiday'],
                ['href' => '/product', 'label' => 'Messenger & AI Chat'],
                ['href' => '/product', 'label' => 'Daily Work Record'],
                ['href' => '/product', 'label' => 'Comments'],
                ['href' => '/product', 'label' => 'Attachment & Documents'],
            ],
            'Site Links' => [
                ['href' => '/', 'label' => 'Home'],
                ['href' => '/about-us', 'label' => 'About Us'],
                ['href' => '/services', 'label' => 'Services'],
                ['href' => '/product', 'label' => 'Product'],
                ['href' => '/blogs', 'label' => 'Blog'],
                ['href' => '/contact-us', 'label' => 'Contact Us'],
            ],
        ];

        $this->socialLinks ??= [
            ['href' => 'https://www.facebook.com/share/1Zt4fotyAa/', 'label' => 'Facebook', 'icon' => 'fa-brands fa-facebook-f'],
            ['href' => 'https://www.linkedin.com/company/suave-creators/', 'label' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin-in'],
            ['href' => 'https://www.instagram.com/suavecreators/?igsh=MWRscWJoZXJrNG10cw%3D%3D#', 'label' => 'Instagram', 'icon' => 'fa-brands fa-instagram'],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.footer');
    }
}
