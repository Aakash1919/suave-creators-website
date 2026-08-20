<?php

namespace App\Support\Frontend;

class CaseStudySupport
{
    /**
     * Catalog slug → named static marketing route.
     *
     * @var array<string, string>
     */
    public const ROUTES = [
        'turbo-trans-corporation-case-study' => 'turbo-trans-case-study',
        'ai-sales-coaching-platform-case-study' => 'ai-sales-coaching-case-study',
        'suave-crm-outreach-case-study' => 'outreach-case-study',
        'suave-crm-tasks-case-study' => 'tasks-case-study',
        'teerrath-spiritual-commerce' => 'teerrath-case-study',
        'appointment-insurance-platform-case-study' => 'appointment-insurance-case-study',
        'cabvi-product-matching' => 'cabvi-case-study',
    ];

    /**
     * Published case studies for the listing page, ordered for the grid.
     *
     * @return list<array<string, mixed>>
     */
    public static function cases(): array
    {
        return array_values(array_filter(
            self::catalog(),
            static fn (array $case): bool => ($case['status'] ?? '') === 'published'
        ));
    }

    public static function routeName(string $slug): ?string
    {
        return self::ROUTES[$slug] ?? null;
    }

    public static function urlForSlug(string $slug): string
    {
        $name = self::routeName($slug);

        return $name !== null ? route($name) : route('case-studies');
    }

    /**
     * Published case studies tagged for a service page (or any service when slug is null).
     *
     * @return list<array<string, mixed>>
     */
    public static function forService(?string $slug = null, int $limit = 6): array
    {
        return self::forPlacement('service_slugs', $slug, $limit);
    }

    /**
     * Static cards for the /services case study carousel.
     *
     * @return list<array<string, mixed>>
     */
    public static function servicesPageItems(): array
    {
        return self::forService(null, 6);
    }

    /**
     * Static cards for the /industries case study carousel.
     *
     * @return list<array<string, mixed>>
     */
    public static function industriesPageItems(): array
    {
        return self::forIndustry(null, 6);
    }

    /**
     * Published case studies tagged for an industry page (or any industry when slug is null).
     *
     * @return list<array<string, mixed>>
     */
    public static function forIndustry(?string $slug = null, int $limit = 6): array
    {
        return self::forPlacement('industry_slugs', $slug, $limit);
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected static function forPlacement(string $column, ?string $slug, int $limit): array
    {
        $items = [];

        foreach (self::cases() as $case) {
            $tags = is_array($case[$column] ?? null) ? array_values($case[$column]) : [];

            if ($slug !== null && $slug !== '') {
                if (! in_array($slug, $tags, true)) {
                    continue;
                }
            } elseif ($tags === []) {
                continue;
            }

            $items[] = $case;

            if (count($items) >= max(1, $limit)) {
                break;
            }
        }

        return $items;
    }

    /**
     * @return array<string, mixed>
     */
    public static function indexData(): array
    {
        $cases = self::cases();

        return [
            'cases' => $cases,
            'fanImages' => self::fanImages(),
        ];
    }

    /**
     * Static product snapshots for the listing hero filmstrip.
     *
     * @return list<array{src: string, alt: string, fan_rotate: float, fan_y: float, fan_scale: float, fan_z: int, featured?: bool}>
     */
    public static function fanImages(): array
    {
        return [
            [
                'src' => 'assets/case-studies/shownoshow/show_no _show banner.webp',
                'alt' => 'Show No Show event booking product banner by Suave Creators',
                'fan_rotate' => -1.6,
                'fan_y' => -18,
                'fan_scale' => 0.96,
                'fan_z' => 1,
            ],
            [
                'src' => 'assets/case-studies/ai-sales-coaching/ai_sales_coach.webp',
                'alt' => 'AI sales coaching dashboard software built by Suave Creators',
                'fan_rotate' => -0.8,
                'fan_y' => 10,
                'fan_scale' => 0.99,
                'fan_z' => 2,
            ],
            [
                'src' => 'assets/case-studies/suave-crm-outreach/outreach_right.webp',
                'alt' => 'CRM outreach map discovery software built by Suave Creators',
                'fan_rotate' => 0.35,
                'fan_y' => 0,
                'fan_scale' => 1.04,
                'fan_z' => 5,
                'featured' => true,
            ],
            [
                'src' => 'assets/case-studies/ai-sales-coaching/ai_sales_right.webp',
                'alt' => 'AI sales coaching product workspace designed by Suave Creators',
                'fan_rotate' => 0.9,
                'fan_y' => 12,
                'fan_scale' => 0.99,
                'fan_z' => 3,
            ],
            [
                'src' => 'assets/case-studies/shownoshow/show_no_show left.webp',
                'alt' => 'Show No Show booking features designed by Suave Creators',
                'fan_rotate' => 1.5,
                'fan_y' => -14,
                'fan_scale' => 0.96,
                'fan_z' => 1,
            ],
        ];
    }

    /**
     * Split a metric string such as "~55%", "3.4x", "~$261", or "01" for count-up animation.
     *
     * @return array{raw: string, numeric: bool, prefix: string, end: float, decimals: int, suffix: string, pad: int}
     */
    public static function parseMetricValue(string $value): array
    {
        $raw = trim($value);
        $empty = [
            'raw' => $raw,
            'numeric' => false,
            'prefix' => '',
            'end' => 0.0,
            'decimals' => 0,
            'suffix' => '',
            'pad' => 0,
        ];

        if ($raw === '') {
            return $empty;
        }

        if (preg_match('/^(.*?)(\d+(?:\.\d+)?)(.*)$/u', $raw, $matches) !== 1) {
            $empty['prefix'] = $raw;

            return $empty;
        }

        $number = $matches[2];
        $decimals = str_contains($number, '.') ? strlen(explode('.', $number, 2)[1]) : 0;
        $pad = ($decimals === 0 && strlen($number) > 1 && str_starts_with($number, '0'))
            ? strlen($number)
            : 0;

        return [
            'raw' => $raw,
            'numeric' => true,
            'prefix' => $matches[1],
            'end' => (float) $number,
            'decimals' => $decimals,
            'suffix' => $matches[3],
            'pad' => $pad,
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected static function catalog(): array
    {
        static $hydrated = null;

        if (is_array($hydrated)) {
            return $hydrated;
        }

        $file = base_path('database/data/case-studies/cases.php');
        $catalog = file_exists($file) ? require $file : [];

        if (! is_array($catalog)) {
            $hydrated = [];

            return $hydrated;
        }

        $hydrated = [];

        foreach ($catalog as $item) {
            if (! is_array($item) || empty($item['slug'])) {
                continue;
            }

            $hydrated[] = self::hydrateCase($item);
        }

        return $hydrated;
    }

    /**
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>
     */
    protected static function hydrateCase(array $item): array
    {
        $slug = (string) ($item['slug'] ?? '');
        $status = (string) ($item['status'] ?? 'draft');

        return [
            'slug' => $slug,
            'title' => (string) ($item['title'] ?? ''),
            'status' => $status,
            'is_draft' => $status === 'draft',
            'image' => self::publicImageUrl((string) ($item['image'] ?? '')),
            'short_description' => (string) ($item['short_description'] ?? ''),
            'listing_subtitle' => (string) ($item['listing_subtitle'] ?? ''),
            'industry' => (string) ($item['industry'] ?? ''),
            'service_slugs' => is_array($item['service_slugs'] ?? null) ? array_values($item['service_slugs']) : [],
            'industry_slugs' => is_array($item['industry_slugs'] ?? null) ? array_values($item['industry_slugs']) : [],
            'technologies' => is_array($item['technologies'] ?? null) ? $item['technologies'] : [],
            'results' => is_array($item['results'] ?? null) ? $item['results'] : [],
            'url' => self::urlForSlug($slug),
        ];
    }

    protected static function publicImageUrl(string $path): string
    {
        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        if ($normalized === '') {
            return '';
        }

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return $normalized;
        }

        if (str_starts_with($normalized, 'assets/')) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'storage/')) {
            return '/'.$normalized;
        }

        return '/storage/'.$normalized;
    }
}
