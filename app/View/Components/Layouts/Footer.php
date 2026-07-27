<?php

namespace App\View\Components\Layouts;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Footer extends Component
{
    use NormalizesAssetPaths;

    public string $emailHref;

    public string $year;

    /**
     * @var array<string, array<int, array{route: string, params?: array<string, string>, label: string, href: string}>>
     */
    public array $columns;

    /**
     * @var array<int, array{href: string, label: string, icon: string}>
     */
    public array $socialLinks;

    /**
     * @param  array<string, array<int, array{route: string, params?: array<string, string>, label: string}>>|null  $columns
     * @param  array<int, array{href: string, label: string, icon: string}>|null  $socialLinks
     */
    public function __construct(
        public string $ctaText = "Got a project? Let's talk",
        public string $backgroundImage = 'assets/background/footer-bg.png',
        public string $phone = '+91 97369 00142',
        public string $phoneHref = 'tel:+919736900142',
        public string $email = 'Info@suavecreators.com',
        public string $address = '30 N Gould St, STE R Sheridan, WY 82801, USA',
        ?string $year = null,
        ?array $columns = null,
        ?array $socialLinks = null,
    ) {
        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);
        $this->emailHref = Str::lower($this->email);
        $this->year ??= (string) now()->year;

        $columns ??= [
            'Services' => [
                ['route' => 'service.show', 'params' => ['slug' => 'web-development-services'], 'label' => 'Web Development'],
                ['route' => 'service.show', 'params' => ['slug' => 'custom-crm-development'], 'label' => 'CRM Development'],
                ['route' => 'service.show', 'params' => ['slug' => 'enterprise-software-solutions'], 'label' => 'Enterprise Software'],
                ['route' => 'service.show', 'params' => ['slug' => 'e-commerce-development'], 'label' => 'E-commerce Software'],
            ],
            'Industry' => [
                ['route' => 'industry.show', 'params' => ['slug' => 'healthcare'], 'label' => 'Healthcare'],
                ['route' => 'industry.show', 'params' => ['slug' => 'it-software-solutions-for-startups'], 'label' => 'IT Solutions'],
                ['route' => 'industry.show', 'params' => ['slug' => 'finance-banking-software-development'], 'label' => 'Banking'],
                ['route' => 'industry.show', 'params' => ['slug' => 'retail-ecommerce-solutions'], 'label' => 'E-commerce'],
                ['route' => 'industry.show', 'params' => ['slug' => 'logistics-supply-chain-apps'], 'label' => 'Logistics'],
                ['route' => 'industry.show', 'params' => ['slug' => 'education-elearning-platforms'], 'label' => 'Education'],
            ],
            'Product' => [
                ['route' => 'product', 'label' => 'HR Module'],
                ['route' => 'product', 'label' => 'Attendance & Holiday'],
                ['route' => 'product', 'label' => 'Messenger & AI Chat'],
                ['route' => 'product', 'label' => 'Daily Work Record'],
                ['route' => 'product', 'label' => 'Comments'],
                ['route' => 'product', 'label' => 'Attachment & Documents'],
            ],
            'Site Links' => [
                ['route' => 'home', 'label' => 'Home'],
                ['route' => 'about-us', 'label' => 'About Us'],
                ['route' => 'services', 'label' => 'Services'],
                ['route' => 'product', 'label' => 'Product'],
                ['route' => 'blogs', 'label' => 'Blog'],
                ['route' => 'contact-us', 'label' => 'Contact Us'],
            ],
        ];

        $this->columns = collect($columns)
            ->map(fn (array $items): array => array_values(array_map(function (array $item): array {
                $item['href'] = route($item['route'], $item['params'] ?? []);

                return $item;
            }, $items)))
            ->all();

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
