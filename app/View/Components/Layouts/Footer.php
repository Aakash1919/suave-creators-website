<?php

namespace App\View\Components\Layouts;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Footer extends Component
{
    use NormalizesAssetPaths;

    public string $phone;

    public string $phoneHref;

    public string $email;

    /** @var array<int, array{label: string, display: string, lines: array<int, string>}> */
    public array $offices;

    public string $emailHref;

    public string $year;

    /**
     * @var array<string, array<int, array{route?: string, params?: array<string, string>, label: string, href: string}>>
     */
    public array $columns;

    /**
     * @var array<int, array{href: string, label: string, icon: string}>
     */
    public array $socialLinks;

    /**
     * @param  array<string, array<int, array{route?: string, params?: array<string, string>, href?: string, label: string}>>|null  $columns
     * @param  array<int, array{href: string, label: string, icon: string}>|null  $socialLinks
     */
    public function __construct(
        public string $ctaText = "Got a project? Let's talk",
        public string $backgroundImage = 'assets/background/footer-bg.png',
        ?string $phone = null,
        ?string $phoneHref = null,
        ?string $email = null,
        ?string $year = null,
        ?array $columns = null,
        ?array $socialLinks = null,
    ) {
        $org = (array) config('seo.site.organization', []);

        $this->phone = $phone ?? (string) ($org['telephone'] ?? '+91 88949 00142');
        $this->phoneHref = $phoneHref ?? (string) ($org['telephone_href'] ?? 'tel:+918894900142');
        $this->email = $email ?? (string) ($org['email'] ?? 'info@suavecreators.com');
        $this->offices = ContactSupport::offices();

        $this->backgroundImage = $this->normalizeAssetPath($this->backgroundImage);
        $this->emailHref = Str::lower($this->email);
        $this->year ??= (string) now()->year;

        $columns ??= [
            'Services' => [
                ['route' => 'service.show', 'params' => ['slug' => 'web-development-services'], 'label' => 'Web Development'],
                ['route' => 'service.show', 'params' => ['slug' => 'custom-crm-development'], 'label' => 'CRM Development'],
                ['route' => 'service.show', 'params' => ['slug' => 'enterprise-software-solutions'], 'label' => 'Enterprise Software'],
                ['route' => 'service.show', 'params' => ['slug' => 'e-commerce-development'], 'label' => 'E-commerce Software'],
                ['route' => 'service.show', 'params' => ['slug' => 'ui-ux-design-services'], 'label' => 'UI/UX Design'],
                ['route' => 'service.show', 'params' => ['slug' => 'ai-solutions'], 'label' => 'AI Solutions'],
            ],
            'Industries' => [
                ['route' => 'industry.show', 'params' => ['slug' => 'healthcare'], 'label' => 'Healthcare'],
                ['route' => 'industry.show', 'params' => ['slug' => 'it-software-solutions-for-startups'], 'label' => 'IT Solutions'],
                ['route' => 'industry.show', 'params' => ['slug' => 'finance-banking-software-development'], 'label' => 'Banking'],
                ['route' => 'industry.show', 'params' => ['slug' => 'retail-ecommerce-solutions'], 'label' => 'E-commerce'],
                ['route' => 'industry.show', 'params' => ['slug' => 'logistics-supply-chain-apps'], 'label' => 'Logistics'],
                ['route' => 'industry.show', 'params' => ['slug' => 'education-elearning-platforms'], 'label' => 'Education'],
            ],
            'Site Links' => [
                ['route' => 'home', 'label' => 'Home'],
                ['route' => 'about-us', 'label' => 'About Us'],
                ['route' => 'services', 'label' => 'Services'],
                ['route' => 'industries', 'label' => 'Industries'],
                ['route' => 'product', 'label' => 'AI Outreach CRM'],
                ['route' => 'case-studies', 'label' => 'Case Studies'],
                ['route' => 'blogs', 'label' => 'Blog'],
                ['route' => 'contact-us', 'fragment' => 'contact-id', 'label' => 'Contact Us'],
            ],
            'AI Outreach CRM' => [
                ['route' => 'product', 'fragment' => 'how-it-works', 'label' => 'How it Works'],
                ['route' => 'product', 'fragment' => 'add-ons', 'label' => 'Add Ons'],
                ['route' => 'product', 'fragment' => 'business-works', 'label' => 'The-Suave AI'],
                ['route' => 'product', 'fragment' => 'data-privacy', 'label' => 'Data & Privacy'],
                ['route' => 'product', 'fragment' => 'case-study', 'label' => 'Case Study'],
            ],
        ];

        $this->columns = collect($columns)
            ->map(fn (array $items): array => array_values(array_map(function (array $item): array {
                if (! isset($item['href'])) {
                    $href = route($item['route'], $item['params'] ?? []);

                    if (isset($item['fragment'])) {
                        $href .= '#'.$item['fragment'];
                    }

                    $item['href'] = $href;
                }

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
