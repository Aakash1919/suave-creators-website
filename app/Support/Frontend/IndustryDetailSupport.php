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
            'iconColors' => ['blue', 'orange', 'cyan', 'mint', 'rose', 'amber'],
            'processData' => $industry['processData'] ?? self::defaultProcessData(),
            'testimonials' => $industry['testimonialsData'] ?? self::defaultTestimonials(),
            'marqueeLabels' => $industry['marqueeLabels'] ?? ['INNOVATION', 'SECURITY', 'SCALABILITY', 'AI POWERED', 'GROWTH', 'SUPPORT'],
            'techStack' => AboutSupport::techStack(),
            'articles' => self::sampleInsights(),
            'ctaArrow' => ServiceSupport::ctaArrow(),
            'btnPrimary' => ServiceSupport::btnPrimary(),
        ];
    }

    /**
     * @return array<string, array<int, array<string, string>>>
     */
    protected static function defaultProcessData(): array
    {
        $icons = [
            'assets/icons/agile-icon-1.svg',
            'assets/icons/agile-icon-2.svg',
            'assets/icons/agile-icon-3.svg',
            'assets/icons/agile-icon-4.svg',
        ];

        return [
            'Planning & Consultation' => [
                ['icon' => $icons[0], 'title' => 'Vision and Goals Discussion', 'desc' => 'Define digital transformation goals and align stakeholders on outcomes.'],
                ['icon' => $icons[1], 'title' => 'Resource Allocation', 'desc' => 'Assign dedicated developers, analysts, and designers for secure delivery.'],
                ['icon' => $icons[2], 'title' => 'Project Roadmap Creation', 'desc' => 'Outline timeline, integrations, and milestones from prototype to launch.'],
                ['icon' => $icons[3], 'title' => 'Scope Definition', 'desc' => 'Define technical requirements, roles, and compliance frameworks.'],
            ],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    protected static function defaultTestimonials(): array
    {
        return [
            [
                'quote' => 'They took the time to understand our complex business needs and turned them into an elegant digital solution.',
                'name' => 'Steve',
                'role' => 'Director, Red3Sixty',
                'image' => 'assets/media/testimonial-portrait-1.webp',
            ],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    protected static function sampleInsights(): array
    {
        return array_map(static function (array $post): array {
            return [
                'title' => $post['title'],
                'excerpt' => $post['short_description'],
                'image' => $post['image'],
                'alt' => $post['title'],
                'date' => $post['published_label'],
                'datetime' => $post['published_date'],
                'author' => $post['author_name'],
                'url' => route(BlogSupport::routeNameForSlug($post['slug'])),
            ];
        }, array_slice(BlogSupport::posts(), 0, 3));
    }
}
