<?php

namespace App\Support\Frontend;

use App\Support\Frontend\Concerns\MapsDesignAssets;

class ServiceSupport
{
    use MapsDesignAssets;

    /** @var array<int, string> */
    public const SLUGS = [
        'web-development-services',
        'custom-crm-development',
        'enterprise-software-solutions',
        'e-commerce-development',
    ];

    /**
     * @return array<string, mixed>
     */
    public static function indexData(): array
    {
        return [
            'latestPosts' => array_slice(BlogSupport::posts(), 0, 3),
            'btnPrimary' => self::btnPrimary(),
            'ctaArrow' => self::ctaArrow(),
            'techStack' => AboutSupport::techStack(),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function service(string $slug): ?array
    {
        if (! in_array($slug, self::SLUGS, true)) {
            return null;
        }

        $path = self::dataPath('services/'.$slug.'.php');

        if (! is_file($path)) {
            return null;
        }

        /** @var array<string, mixed> $service */
        $service = include $path;

        return self::assetizeDesignData(self::mapDesignData($service));
    }

    /**
     * @return array<string, mixed>
     */
    public static function showData(string $slug): array
    {
        $service = self::service($slug);

        if ($service === null) {
            abort(404);
        }

        $posts = BlogSupport::posts();

        return [
            'service' => $service,
            'seoTitle' => (string) ($service['pageTitle'] ?? 'Service | Suave Creators'),
            'seoDescription' => (string) ($service['pageDescription'] ?? 'Suave Creators service details.'),
            'bannerBg' => asset(self::mapDesignPath((string) ($service['bannerBg'] ?? '/assets/background/service-banner-bg.webp'))),
            'introBg' => asset(self::mapDesignPath('/assets/background/technology-section-bg.png')),
            'collabBackground' => asset(self::mapDesignPath((string) ($service['collabBackground'] ?? '/assets/media/collaboration-back-visual.png'))),
            'collabImage' => asset(self::mapDesignPath((string) ($service['collabImage'] ?? '/assets/media/collaboration-front-visual.png'))),
            'marqueeIcons' => array_map(
                fn (mixed $icon): string => asset(is_string($icon) ? self::mapDesignPath($icon) : ''),
                $service['marqueeIcons'] ?? self::defaultMarqueeIcons(),
            ),
            'portfolioImages' => array_map(
                fn (mixed $image): string => asset(is_string($image) ? self::mapDesignPath($image) : ''),
                $service['portfolioImages'] ?? self::defaultPortfolioImages(),
            ),
            'latestPosts' => array_slice($posts, 0, 3),
            'techStack' => AboutSupport::techStack(),
            'webDevLayoutSlugs' => self::SLUGS,
            'isWebDevelopmentService' => in_array($slug, self::SLUGS, true),
            'capabilitiesAsSlider' => ! empty($service['capabilitiesAsSlider']),
            'capabilitiesGridColumns' => (int) ($service['capabilitiesGridColumns'] ?? 3),
            'ctaArrow' => self::ctaArrow(),
            'btnPrimary' => self::btnPrimary(),
        ];
    }

    /**
     * @return array<int, string>
     */
    protected static function defaultMarqueeIcons(): array
    {
        return [
            '/assets/media/service-process-step-1.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
            '/assets/media/service-process-step-2.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
            '/assets/media/service-process-step-3.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
            '/assets/media/service-process-step-4.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
        ];
    }

    /**
     * @return array<int, string>
     */
    protected static function defaultPortfolioImages(): array
    {
        return [
            '/assets/portfolio/portfolio-showcase-1.webp',
            '/assets/portfolio/portfolio-showcase-2.webp',
            '/assets/portfolio/portfolio-showcase-3.webp',
            '/assets/portfolio/portfolio-showcase-4.webp',
            '/assets/portfolio/portfolio-showcase-5.webp',
            '/assets/portfolio/portfolio-showcase-6.webp',
        ];
    }

    public static function ctaArrow(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>';
    }

    public static function btnPrimary(): string
    {
        return 'u-btn-cta group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110';
    }
}
