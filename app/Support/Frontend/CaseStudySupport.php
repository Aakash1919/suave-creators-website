<?php

namespace App\Support\Frontend;

/**
 * Static marketing catalog for listing cards, carousels, and sitemap.
 * Story copy lives in resources/views/frontend/case-studies/, not here.
 */
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
        'ai-product-matching' => 'ai-product-matching-case-study',
        'cabvi-product-matching' => 'ai-product-matching-case-study',
        'AI-product-matching' => 'ai-product-matching-case-study',
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

    /**
     * Per-case mosaic scenes for the case-studies visual (one scene = one published case).
     *
     * @param  list<string>|null  $slugs  Optional catalog slug allowlist (order preserved when provided)
     * @return list<array<string, mixed>>
     */
    public static function heroVisualScenes(int $limit = 4, ?array $slugs = null): array
    {
        $scenes = [];
        $allow = null;

        if (is_array($slugs) && $slugs !== []) {
            $allow = array_values(array_filter(array_map(
                static fn ($slug): string => trim((string) $slug),
                $slugs
            ), static fn (string $slug): bool => $slug !== ''));
            $allow = $allow === [] ? null : $allow;
        }

        $cases = self::cases();

        if (is_array($allow)) {
            $bySlug = [];
            foreach ($cases as $case) {
                $slug = (string) ($case['slug'] ?? '');
                if ($slug !== '') {
                    $bySlug[$slug] = $case;
                }
            }

            $ordered = [];
            foreach ($allow as $slug) {
                if (isset($bySlug[$slug])) {
                    $ordered[] = $bySlug[$slug];
                }
            }
            $cases = $ordered;
        }

        foreach ($cases as $case) {
            $slug = (string) ($case['slug'] ?? '');
            $title = trim((string) ($case['title'] ?? ''));
            $industry = trim((string) ($case['industry'] ?? ''));
            $listingImage = (string) ($case['image'] ?? '');

            if ($slug === '' || $title === '' || $listingImage === '') {
                continue;
            }

            $results = is_array($case['results'] ?? null) ? $case['results'] : [];
            $primaryResult = is_array($results[0] ?? null) ? $results[0] : [];
            $secondaryResult = is_array($results[1] ?? null) ? $results[1] : $primaryResult;
            $primaryLabel = (string) ($primaryResult['label'] ?? '');
            $secondaryLabel = (string) ($secondaryResult['label'] ?? '');
            $subtitle = trim((string) ($case['listing_subtitle'] ?? ''));
            $altBase = $industry !== '' ? "{$title} — {$industry}" : $title;
            $alt = trim($altBase.' case study by Suave Creators');

            $gallery = self::heroGalleryForSlug($slug, $listingImage);
            $brandImage = $gallery[0];
            $photoImage = $gallery[1] ?? $gallery[0];
            $extraImage = $gallery[2] ?? null;

            $scenes[] = [
                'slug' => $slug,
                'title' => $title,
                'url' => (string) ($case['url'] ?? self::urlForSlug($slug)),
                'alt' => $alt,
                'tag' => $subtitle !== '' ? $subtitle : ($industry !== '' ? $industry : 'Case Study'),
                'primary' => [
                    'value' => (string) ($primaryResult['value'] ?? ''),
                    'label' => $primaryLabel,
                    'label_short' => self::shortHeroLabel($primaryLabel),
                ],
                'secondary' => [
                    'value' => (string) ($secondaryResult['value'] ?? ''),
                    'label' => $secondaryLabel,
                    'label_short' => self::shortHeroLabel($secondaryLabel),
                ],
                'brand_image' => $brandImage,
                'photo_image' => $photoImage,
                'chart_image' => $extraImage,
                'bars' => self::heroBarsFromResults($results),
            ];

            if (count($scenes) >= max(1, $limit)) {
                break;
            }
        }

        return $scenes;
    }

    /**
     * @deprecated Use heroVisualScenes(); kept as a thin alias for HomeSupport callers.
     *
     * @return list<array<string, mixed>>
     */
    public static function heroVisualItems(int $limit = 4): array
    {
        return self::heroVisualScenes($limit);
    }

    /**
     * Relative asset paths for a case-study hero gallery (brand, photo, optional chart image).
     *
     * @return list<string> Hydrated public URLs
     */
    protected static function heroGalleryForSlug(string $slug, string $fallbackImage): array
    {
        $map = [
            'turbo-trans-corporation-case-study' => [
                'assets/case-studies/turbo-trans/turbo-trans-corporation-logo.png',
                'assets/case-studies/turbo-trans/turbo-trans-dispatch-fleet-tile.webp',
                'assets/case-studies/turbo-trans/turbo-trans-pipeline-chart-tile.webp',
            ],
            'ai-sales-coaching-platform-case-study' => [
                'assets/case-studies/ai-sales-coaching/ai-sales-coach-brand-mark.webp',
                'assets/case-studies/ai-sales-coaching/ai-sales-coach-live-practice-tile.webp',
                'assets/case-studies/ai-sales-coaching/ai-sales-coach-score-chart-tile.webp',
            ],
            'suave-crm-outreach-case-study' => [
                'assets/case-studies/suave-crm-outreach/outreach-crm-brand-mark.webp',
                'assets/case-studies/suave-crm-outreach/outreach-map-discovery-tile.webp',
                'assets/case-studies/suave-crm-outreach/outreach-ai-analysis-tile.webp',
            ],
            'suave-crm-tasks-case-study' => [
                'assets/case-studies/suave-crm-tasks/tasks-crm-brand-mark.webp',
                'assets/case-studies/suave-crm-tasks/tasks-kanban-board-tile.webp',
                'assets/case-studies/suave-crm-tasks/tasks-drawer-metric-tile.webp',
            ],
            'appointment-insurance-platform-case-study' => [
                'assets/case-studies/shownoshow/show-check-brand-mark.webp',
                'assets/case-studies/shownoshow/show-check-confirmed-tile.webp',
                'assets/case-studies/shownoshow/show-check-savings-chart-tile.webp',
            ],
            'teerrath-spiritual-commerce' => [
                'assets/case-studies/teerrath/teerrath-brand-mark.webp',
                'assets/case-studies/teerrath/teerrath-energy-scan-tile.webp',
                'assets/case-studies/teerrath/teerrath-insight-chart-tile.webp',
            ],
            'ai-product-matching' => [
                'assets/case-studies/cabvi/cabvi-brand-mark.webp',
                'assets/case-studies/cabvi/cabvi-product-matching-tile.webp',
                'assets/case-studies/cabvi/cabvi-efficiency-chart-tile.webp',
            ],
        ];

        $paths = $map[$slug] ?? [];

        if ($paths === []) {
            $paths = [$fallbackImage];
        }

        $urls = [];

        foreach ($paths as $path) {
            $url = str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
                ? $path
                : self::publicImageUrl($path);

            if ($url !== '') {
                $urls[] = $url;
            }
        }

        if ($urls === []) {
            $urls[] = $fallbackImage;
        }

        return $urls;
    }

    /**
     * @param  list<array<string, mixed>>  $results
     * @return list<int>
     */
    protected static function heroBarsFromResults(array $results): array
    {
        $defaults = [42, 68, 92, 58, 76];
        $heights = [];

        foreach (array_slice($results, 0, 5) as $index => $result) {
            $parsed = self::parseMetricValue((string) ($result['value'] ?? ''));
            if (! empty($parsed['numeric']) && $parsed['end'] > 0) {
                $end = (float) $parsed['end'];
                // Percent-like values stay in range; multipliers (3.4x) scale up.
                $height = $end <= 100 ? max(28, min(96, (int) round($end))) : max(40, min(96, (int) round(28 + ($end * 12))));
                $heights[] = $height;
            } else {
                $heights[] = $defaults[$index] ?? 55;
            }
        }

        while (count($heights) < 5) {
            $heights[] = $defaults[count($heights)] ?? 55;
        }

        return $heights;
    }

    /**
     * Keep mosaic metric captions readable (GrowthNatives-style short lines).
     */
    protected static function shortHeroLabel(string $label, int $maxWords = 5): string
    {
        $label = trim(preg_replace('/\s+/u', ' ', $label) ?? '');

        if ($label === '') {
            return '';
        }

        $words = preg_split('/\s+/u', $label, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if (count($words) <= $maxWords) {
            return $label;
        }

        return implode(' ', array_slice($words, 0, $maxWords));
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
                'src' => 'assets/case-studies/shownoshow/show_no_show_banner.webp',
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
     * Split a metric string such as "+55%", "3.4x", "+$261", or "01" for count-up animation.
     *
     * @return array{raw: string, numeric: bool, prefix: string, end: float, decimals: int, suffix: string, pad: int, initial: string}
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
            'initial' => '0',
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

        $parsed = [
            'raw' => $raw,
            'numeric' => true,
            'prefix' => $matches[1],
            'end' => (float) $number,
            'decimals' => $decimals,
            'suffix' => $matches[3],
            'pad' => $pad,
        ];
        $parsed['initial'] = self::metricInitialNumber($parsed);

        return $parsed;
    }

    /**
     * @param  array{decimals: int, pad: int}  $parsed
     */
    protected static function metricInitialNumber(array $parsed): string
    {
        if (! empty($parsed['decimals'])) {
            return number_format(0, (int) $parsed['decimals'], '.', '');
        }

        $pad = (int) ($parsed['pad'] ?? 0);

        return $pad > 1 ? str_pad('0', $pad, '0', STR_PAD_LEFT) : '0';
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

        $hydrated = [];

        foreach (self::listingItems() as $item) {
            if (empty($item['slug'])) {
                continue;
            }

            $hydrated[] = self::hydrateCase($item);
        }

        return $hydrated;
    }

    /**
     * Listing cards, carousels, and sitemap only. Story copy lives in Blade.
     *
     * @return list<array<string, mixed>>
     */
    protected static function listingItems(): array
    {
        return [
            
            [
                'slug' => 'ai-sales-coaching-platform-case-study',
                'title' => 'An AI Sales Coach That Practices, Whispers, and Scores',
                'status' => 'published',
                'image' => 'assets/case-studies/ai-sales-coaching/ai_sales_coach.webp',
                'short_description' => 'An AI sales coaching platform that helps fast-growing teams keep performance consistent as they hire — with voice practice, live call coaching, and clear scores so new reps ramp faster and managers don’t wait on recordings.',
                'listing_subtitle' => 'AI Sales Coaching Platform for Growing Teams',
                'industry' => 'Sales Enablement',
                'service_slugs' => ['enterprise-software-solutions', 'ai-solutions'],
                'industry_slugs' => ['it-software-solutions-for-startups'],
                'results' => [
                    ['value' => '+55%', 'label' => 'Faster path from hire to confident customer calls'],
                    ['value' => '+60%', 'label' => 'Less manager time spent reviewing recordings for feedback'],
                    ['value' => '+50%', 'label' => 'Improvement in call quality consistency as the team expands'],
                    ['value' => '+45%', 'label' => 'Fewer opportunities lost waiting on delayed coaching'],
                ],
                'technologies' => [
                    'AI sales coaching',
                    'Voice practice',
                    'Live call assist',
                    'Call scoring',
                    'Buyer personas',
                    'Calendar sync',
                ],
            ],
            [
                'slug' => 'suave-crm-outreach-case-study',
                'title' => 'The Suave App Outreach - From a Complex Process to a Clear B2B CRM Sales Workspace',
                'status' => 'published',
                'image' => 'assets/case-studies/suave-crm-outreach/outreach-before-after-hero.png',
                'short_description' => 'We redesigned the suave app’s fragmented B2B CRM outbound sales workflow into one prospecting workspace — map-based company discovery, AI sales briefings, cold email automation, and pipeline tracking — with about 65% fewer steps.',
                'listing_subtitle' => 'B2B CRM Outbound Sales Workflow Redesign',
                'industry' => 'B2B SaaS / Sales CRM',
                'service_slugs' => ['custom-crm-development', 'ui-ux-design-services'],
                'industry_slugs' => ['it-software-solutions-for-startups'],
                'results' => [
                    ['value' => '+65%', 'label' => 'Fewer steps for routine B2B CRM outbound sales prospecting'],
                    ['value' => '+35%', 'label' => 'Less effort to complete the same sales pipeline work'],
                    ['value' => '1', 'label' => 'Connected CRM workspace from map discovery to cold email'],
                    ['value' => '3', 'label' => 'Focused areas — Outreach, Targets, and Email automation'],
                ],
                'technologies' => [
                    'Map-based company discovery',
                    'AI sales prospecting briefings',
                    'Cold email CRM automation',
                    'B2B sales call practice',
                    'Outbound sales pipeline CRM',
                    'Territory distance planning',
                ],
            ],
            [
                'slug' => 'suave-crm-tasks-case-study',
                'title' => 'The Suave App Tasks - From a Complex Process to a Clear B2B CRM Task Management Workspace',
                'status' => 'published',
                'image' => 'assets/case-studies/suave-crm-tasks/the-suave-app-task-banner.webp',
                'short_description' => 'We redesigned the suave app’s Tasks module into one B2B CRM task management workspace — Kanban and List view integration, inline create, a task drawer, and an automated task assistant AI — with about 50% less switching between views.',
                'listing_subtitle' => 'B2B CRM Task Management Workflow Redesign',
                'industry' => 'B2B SaaS / Work Management',
                'service_slugs' => ['custom-crm-development'],
                'industry_slugs' => ['it-software-solutions-for-startups'],
                'results' => [
                    ['value' => '+50%', 'label' => 'Less switching between separate Kanban and List views'],
                    ['value' => '+45%', 'label' => 'Faster answers to overdue and assigned task questions'],
                    ['value' => '1', 'label' => 'Connected B2B CRM task management workspace from search to drawer'],
                    ['value' => '4', 'label' => 'Focused drawer areas — Overview, Comments, Log Time, Attachments'],
                ],
                'technologies' => [
                    'Kanban and List view integration',
                    'Automated task assistant AI',
                    'B2B CRM task management',
                    'AI project management software',
                    'Searchable project sidebar',
                    'Inline & bulk create',
                ],
            ],
            [
                'slug' => 'teerrath-spiritual-commerce',
                'title' => 'Teerrath — From Stuck to a Clear Sacred Path',
                'status' => 'draft',
                'image' => 'assets/case-studies/teerrath/spiritual-energy-scan-hero.png',
                'short_description' => 'A free Spiritual Energy Scan in under 2 minutes becomes AI-personalized Vedic insight across six life areas — then a clear Dev, Mantra, Yantra, or Daan path to buy, gift, or fulfill.',
                'listing_subtitle' => 'Spiritual Energy Scan to Sacred Commerce',
                'industry' => 'Spiritual Wellness / Ecommerce',
                'service_slugs' => ['e-commerce-development'],
                'industry_slugs' => ['retail-ecommerce-solutions'],
                'results' => [
                    ['value' => '<2m', 'label' => 'Free Spiritual Energy Scan completion'],
                    ['value' => '6', 'label' => 'Life areas with scored AI insight'],
                    ['value' => '4', 'label' => 'Sacred sadhna paths (live catalog)'],
                    ['value' => '1', 'label' => 'Prioritized “start here” practice'],
                ],
                'technologies' => [
                    'AI spiritual guidance',
                    'Vedic energy scan',
                    'Razorpay payments',
                    'WhatsApp via Fast2SMS',
                    'Zoho Books sync',
                    'Teerrath Kamals',
                    'Sacred ecommerce',
                    'Order fulfillment',
                ],
            ],
            [
                'slug' => 'appointment-insurance-platform-case-study',
                'title' => 'Appointment Insurance That Makes Showing Up the Default',
                'status' => 'published',
                'image' => 'assets/case-studies/shownoshow/show_no_show_banner.webp',

                'short_description' => 'An appointment insurance platform that protects calendars with clear deposits, text invites, arrival check-in, and smart Stripe refunds — so unused deposit money comes back without wasting card fees, and no-shows pay the person who waited.',
                'listing_subtitle' => 'Appointment Insurance Platform Against No-Shows',
                'industry' => 'Appointment Scheduling / Fintech',
                'service_slugs' => ['web-development-services', 'enterprise-software-solutions'],
                'industry_slugs' => ['healthcare', 'finance-banking-software-development'],
                'results' => [
                    ['value' => '+$261', 'label' => 'Card fees saved on a $10k example by returning unused money the smart way'],
                    ['value' => '+90%', 'label' => 'Less card-fee waste on unused deposit money that comes back'],
                    ['value' => '+70%', 'label' => 'Less manual chasing for confirmations, deposits, and “are you coming?”'],
                    ['value' => '+65%', 'label' => 'Improvement in recovering value from no-shows instead of treating them as pure loss'],
                ],
                'technologies' => [
                    'Appointment insurance',
                    'No-show protection',
                    'Deposit scheduling',
                    'Stripe smart refunds',
                    'SMS invites',
                    'Location check-in',
                ],
            ],
            [
                'slug' => 'ai-product-matching',
                'title' => 'AI Product Matching to an Automated AI Workspace',
                'status' => 'published',
                'image' => 'assets/case-studies/cabvi/cabvi-logo.webp',
                'short_description' => 'AI product matching replaces hand-checking supplier sites, manual match qualification, and spreadsheet record-keeping with automated catalog search, AI help on close calls, and one place to decide with proof.',
                'listing_subtitle' => 'Automated AI Product Matching',
                'industry' => 'Nonprofit / Procurement',
                'service_slugs' => ['enterprise-software-solutions', 'ai-solutions'],
                'industry_slugs' => ['it-software-solutions-for-startups', 'education-elearning-platforms'],
                'results' => [
                    ['value' => '+70%', 'label' => 'Less time spent hunting look-alikes across supplier sites by hand'],
                    ['value' => '+60%', 'label' => 'Improvement in match qualification speed'],
                    ['value' => '+75%', 'label' => 'Less spreadsheet re-entry to keep match records'],
                    ['value' => '+50%', 'label' => 'Less manpower burned on the find–qualify–record loop'],
                ],
            ],
            [
                'slug' => 'turbo-trans-corporation-case-study',
                'title' => 'Success Story : The Turbo Trans Corporation',
                'status' => 'published',
                'image' => 'assets/case-studies/turbo-trans/ttc_caseStudy.webp',
                'short_description' => 'See how a logistics leader transformed their sales operations with AI-powered CRM automation TurboTrans Corporation is a leading logistics and freight forwarding company specializing in air freight, ocean freight, land transportation, customs clearance, and end-to-end supply chain solutions.',
                'listing_subtitle' => 'Global Operations',
                'industry' => 'Logistics & Freight',
                'service_slugs' => ['custom-crm-development'],
                'industry_slugs' => ['logistics-supply-chain-apps'],
                'results' => [
                    ['value' => '42%', 'label' => 'More Qualified Leads vs. Previous Quarter'],
                    ['value' => '3.4x', 'label' => 'Faster Response Time Average Lead Response'],
                    ['value' => '68%', 'label' => 'Pipeline Visibility Complete Deal Tracking'],
                    ['value' => '2.8x', 'label' => 'Revenue Growth Year-over-Year Increase'],
                ],
                'technologies' => [
                    'AI-powered lead qualification',
                    'Automated follow-up reminders',
                    'Visual sales pipeline',
                    'Real-time sales dashboard',
                    'Team collaboration',
                    'Smart reporting & analytics',
                    'Customer activity timeline',
                ],
            ],
        ];
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
