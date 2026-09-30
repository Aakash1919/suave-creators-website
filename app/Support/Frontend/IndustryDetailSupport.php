<?php

namespace App\Support\Frontend;

use App\Support\Frontend\Concerns\MapsDesignAssets;

class IndustryDetailSupport
{
    use MapsDesignAssets;

    /** @var array<string, string> */
    public const SLUG_FILES = [
        'healthcare-software-development' => 'healthcare-software-development.php',
        'it-software-solutions-for-startups' => 'it-software-solutions-for-startups.php',
        'finance-banking-software-development' => 'finance-banking-software-development.php',
        'retail-ecommerce-solutions' => 'retail-ecommerce-solutions.php',
        'logistics-supply-chain-apps' => 'logistics-supply-chain-apps.php',
        'education-elearning-platforms' => 'education-elearning-platforms.php',
    ];

    /**
     * Blog category slug for the insights section. Null when this industry has no matching category.
     */
    public static function insightCategory(?string $slug): ?string
    {
        return match ($slug) {
            'it-software-solutions-for-startups' => 'startups',
            default => null,
        };
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function industry(string $slug): ?array
    {
        $file = self::SLUG_FILES[$slug] ?? null;

        if ($file === null) {
            return null;
        }

        $path = self::dataPath('industries/'.$file);

        if (! is_file($path)) {
            return null;
        }

        /** @var array<string, mixed> $industry */
        $industry = include $path;

        return self::assetizeDesignData(self::mapDesignData($industry));
    }

    /**
     * @return array<string, mixed>
     */
    public static function showData(string $slug): array
    {
        $industry = self::industry($slug);

        if ($industry === null) {
            abort(404);
        }

        $industry = array_replace(self::detailDefaults(), $industry);

        return [
            'industry' => $industry,
            'seoTitle' => (string) ($industry['pageTitle'] ?? 'Industry Solutions | Suave Creators'),
            'seoDescription' => (string) ($industry['pageDescription'] ?? 'Suave Creators industry software development.'),
            'seoOgTitle' => (string) ($industry['ogTitle'] ?? $industry['pageTitle'] ?? ''),
            'seoOgDescription' => (string) ($industry['ogDescription'] ?? $industry['pageDescription'] ?? ''),
            'mainClass' => 'site-main site-main--industry-detail',
            'agilePhases' => self::agilePhases(),
            'introStats' => ServiceSupport::introStats(),
            'sectors' => self::sectors(),
            'testimonialItems' => HomeSupport::testimonials(),
            'marqueeItems' => self::marqueeItems($industry['marqueeLabels']),
            'insightCategory' => self::insightCategory($slug),
            'caseStudies' => CaseStudySupport::forIndustry($slug, 6),
        ];
    }

    /**
     * Copy fallbacks for every industry page; data files override per slug.
     *
     * @return array<string, mixed>
     */
    protected static function detailDefaults(): array
    {
        return [
            'eyebrow' => 'Industry Solutions',
            'pageTitle' => 'Industry',
            'heroTitle' => [],
            'heroDescription' => '',
            'bannerBg' => '',
            'bannerSideImage' => '',
            'introEyebrow' => 'Professional Solutions',
            'introTitle' => '',
            'introDescription' => '',
            'servicesEyebrow' => 'Services',
            'servicesTitle' => '',
            'servicesDescription' => '',
            'services' => [],
            'ctaEyebrow' => 'Ready to Start Your Project?',
            'ctaTitle' => '',
            'ctaDescription' => '',
            'specializedEyebrow' => 'Specialized Services',
            'specializedTitle' => '',
            'specializedDescription' => '',
            'specialized' => [],
            'marqueeLabels' => ['INNOVATION', 'SECURITY', 'SCALABILITY', 'AI POWERED', 'GROWTH', 'SUPPORT'],
            'whyEyebrow' => 'Why Us',
            'whyTitle' => '',
            'whyDescription' => '',
            'whyCards' => [],
            'agileTitle' => 'Our Agile Development Process',
            'agileSubtitle' => 'Let’s connect with our experienced developers for expert guidance and tailored solutions.',
            'faqs' => [],
            'finalBg' => 'assets/background/consultation-section-bg.png',
            'finalEyebrow' => 'Your Digital Future Together',
            'finalTitle' => "Let's Build Your Next Digital Solution with us!",
            'finalDescription' => '',
            'hideFinalBgBelowDesktop' => false,
        ];
    }

    /**
     * Sector cards shared by every industry page; icon keys match the core-values-section SVG symbols.
     *
     * @return array<int, array{icon: string, title: string, desc: string, image: string, alt: string}>
     */
    public static function sectors(): array
    {
        return [
            ['icon' => 'fintech', 'title' => 'Fintech & Banking Sector', 'desc' => 'Building secure, scalable platforms for modern finance.', 'image' => 'assets/media/fintech-dashboard-financial-analytics.webp', 'alt' => 'Building secure, scalable platforms for modern finance.'],
            ['icon' => 'ecommerce', 'title' => 'E-commerce & Retail Sector', 'desc' => 'Powering secure e-commerce payments and fraud protection.', 'image' => 'assets/media/ecommerce-storefront-laptop-checkout.webp', 'alt' => 'Powering secure e-commerce payments and fraud protection.'],
            ['icon' => 'healthcare', 'title' => 'Healthcare & Insurance Sector', 'desc' => 'Seamless billing, claims & policy management solutions.', 'image' => 'assets/media/healthcare.webp', 'alt' => 'Seamless billing, claims & policy management solutions.'],
            ['icon' => 'education', 'title' => 'Education & EdTech Sector', 'desc' => 'Secure fee and payment solutions for education.', 'image' => 'assets/media/elearning-platform-online-classroom.webp', 'alt' => 'Secure fee and payment solutions for education'],
            ['icon' => 'it', 'title' => 'IT Solutions for Startups', 'desc' => 'Innovative solutions tailored to your business needs.', 'image' => 'assets/media/it-solutions.webp', 'alt' => 'Innovative solutions tailored to your business needs.'],
            ['icon' => 'logistics', 'title' => 'Logistics and Supply Chain', 'desc' => 'Streamlined warehouse, inventory & transport management.', 'image' => 'assets/media/supply-chain.webp', 'alt' => 'Streamlined warehouse, inventory & transport management.'],
        ];
    }

    /**
     * Alternate filled / outlined marquee labels.
     *
     * @param  array<int, string>  $labels
     * @return array<int, array{label: string, style: string, separator: string}>
     */
    protected static function marqueeItems(array $labels): array
    {
        return array_values(array_map(static function (string $label, int $index): array {
            $style = $index % 2 === 0 ? 'filled' : 'outlined';

            return ['label' => $label, 'style' => $style, 'separator' => $style];
        }, $labels, array_keys($labels)));
    }

    /**
     * @return array<string, array<int, array<string, string>>>
     */
    protected static function agilePhases(): array
    {
        $icons = [
            asset('assets/icons/agile-icon-1.svg'),
            asset('assets/icons/agile-icon-2.svg'),
            asset('assets/icons/agile-icon-3.svg'),
            asset('assets/icons/agile-icon-4.svg'),
        ];

        $card = static function (int $iconIndex, string $title, string $desc) use ($icons): array {
            return [
                'icon' => $icons[$iconIndex],
                'title' => $title,
                'desc' => $desc,
            ];
        };

        return [
            'Planning & Consultation' => [
                $card(0, 'Vision and Goals Discussion', 'Define digital transformation goals and align stakeholders on outcomes.'),
                $card(1, 'Resource Allocation', 'Assign dedicated developers, analysts, and designers for secure delivery.'),
                $card(2, 'Project Roadmap Creation', 'Outline timeline, integrations, and milestones from prototype to launch.'),
                $card(3, 'Scope Definition', 'Define technical requirements, roles, and compliance frameworks.'),
            ],
            'Design' => [
                $card(0, 'User Journey Mapping', 'Map journeys for every role to design intuitive interfaces.'),
                $card(1, 'UI/UX Design', 'Create dashboards and mobile-first layouts tailored to the industry.'),
                $card(2, 'Wireframes & Prototypes', 'Build wireframes focused on accessibility and key workflows.'),
                $card(3, 'Design Finalisation', 'Finalise visuals, content flow, and interactive patterns.'),
            ],
            'Development' => [
                $card(0, 'Secure Build', 'Translate goals into secure, scalable software modules.'),
                $card(1, 'Engineering Team', 'Assign Laravel, React, and API specialists for robust systems.'),
                $card(2, 'Sprint Delivery', 'Structured sprints for backend APIs, front-end, and integrations.'),
                $card(3, 'Stack & Security', 'Define stack, third-party integrations, and security layers.'),
            ],
            'Testing' => [
                $card(0, 'Test Objectives', 'Verify accuracy, privacy, and performance before go-live.'),
                $card(1, 'QA Specialists', 'Domain QA for validation, workflow simulation, and load handling.'),
                $card(2, 'Test Cycles', 'Unit, integration, UAT, and security audits across releases.'),
                $card(3, 'Quality Benchmarks', 'Define coverage criteria and automated testing tools.'),
            ],
            'Deployment' => [
                $card(0, 'Deployment Goals', 'Seamless integration with existing systems and cloud infra.'),
                $card(1, 'DevOps Support', 'Server configs, API connections, and compliance checks.'),
                $card(2, 'Migration Plan', 'Step-by-step migration, onboarding, and backup strategies.'),
                $card(3, 'Go-Live Readiness', 'Environments, rollback procedures, and monitoring metrics.'),
            ],
            'Maintenance' => [
                $card(0, 'Long-term Goals', 'Sustainability, uptime, and data integrity after launch.'),
                $card(1, 'Support Team', 'Patches, performance optimisation, and major updates.'),
                $card(2, 'Update Roadmap', 'Periodic updates aligned with new tech and regulations.'),
                $card(3, 'SLA & Monitoring', 'Monitoring tools, reporting, and service-level commitments.'),
            ],
        ];
    }
}
