<?php

namespace App\Support\Frontend;

use App\Support\Frontend\Concerns\MapsDesignAssets;

class IndustryDetailSupport
{
    use MapsDesignAssets;

    /** @var array<string, string> */
    public const SLUG_FILES = [
        'healthcare' => 'healthcare.php',
        'it-software-solutions-for-startups' => 'it-software-solutions-for-startups.php',
        'finance-banking-software-development' => 'finance-banking-software-development.php',
        'retail-ecommerce-solutions' => 'retail-ecommerce-solutions.php',
        'logistics-supply-chain-apps' => 'logistics-supply-chain-apps.php',
        'education-elearning-platforms' => 'education-elearning-platforms.php',
    ];

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

        return [
            'industry' => $industry,
            'seoTitle' => (string) ($industry['pageTitle'] ?? 'Industry Solutions | Suave Creators'),
            'seoDescription' => (string) ($industry['pageDescription'] ?? 'Suave Creators industry software development.'),
            'seoOgTitle' => (string) ($industry['ogTitle'] ?? $industry['pageTitle'] ?? ''),
            'seoOgDescription' => (string) ($industry['ogDescription'] ?? $industry['pageDescription'] ?? ''),
            'iconColors' => ['blue', 'orange', 'cyan', 'mint', 'rose', 'amber'],
            'processData' => $processData = $industry['processData'] ?? self::defaultProcessData(),
            'agileTabs' => array_keys($processData),
            'introStats' => ServiceSupport::introStats(),
            'coreValuesItems' => self::mapCoreValuesItems($industry['processes'] ?? []),
            'testimonialItems' => HomeSupport::testimonials(),
            'marqueeLabels' => $industry['marqueeLabels'] ?? ['INNOVATION', 'SECURITY', 'SCALABILITY', 'AI POWERED', 'GROWTH', 'SUPPORT'],
            'techStack' => AboutSupport::techStack(),
            'articles' => self::sampleInsights(),
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $processes
     * @return array<int, array{icon: string, title: string, desc: string, image: string, alt: string}>
     */
    protected static function mapCoreValuesItems(array $processes): array
    {
        $iconCycle = ['innovation', 'quality', 'trust', 'customer'];
        $processImages = [
            'assets/portfolio/modern-office-yellow-accent-lounge.png',
            'assets/portfolio/contemporary-living-room-kitchen.png',
            'assets/portfolio/warm-lounge-plants-artwork.png',
            'assets/portfolio/office-glass-meeting-rooms.png',
            'assets/blog/insight-digital-strategy.jpg',
            'assets/media/retail-solutions-visual-5.webp',
        ];
        $processAlts = [
            'Modern building exterior for industry software delivery',
            'Contemporary living room for digital product design',
            'Modern lounge with plants for software team collaboration',
            'Contemporary office for enterprise software development',
            'Startup team collaborating on digital strategy',
            'Logistics software on tablet in a warehouse',
        ];

        $items = [];

        foreach ($processes as $index => $process) {
            $imgIndex = $index % count($processImages);
            $items[] = [
                'icon' => $iconCycle[$index % count($iconCycle)],
                'title' => (string) ($process['title'] ?? ''),
                'desc' => (string) ($process['desc'] ?? ''),
                'image' => (string) ($process['image'] ?? $processImages[$imgIndex]),
                'alt' => (string) ($process['alt'] ?? $processAlts[$imgIndex]),
            ];
        }

        return $items;
    }

    /**
     * @return array<string, array<int, array<string, string>>>
     */
    protected static function defaultProcessData(): array
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

    /**
     * @return array<int, array<string, string>>
     */
    protected static function sampleInsights(): array
    {
        return BlogSupport::articleCards(3);
    }
}
