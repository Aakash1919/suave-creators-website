<?php

namespace App\Support\Frontend;

class SuaveAgentKnowledge
{
    /**
     * Authoritative company email, phones, and dual offices for the agent and tools.
     *
     * @return array{
     *     company: string,
     *     email: string,
     *     phones: array<int, string>,
     *     offices: array<int, array{label: string, display: string, lines: array<int, string>}>
     * }
     */
    public static function companyContacts(): array
    {
        $org = (array) config('seo.site.organization', []);

        return [
            'company' => (string) ($org['legal_name'] ?? 'Suave Creators'),
            'email' => strtolower((string) ($org['email'] ?? 'info@suavecreators.com')),
            'phones' => array_values(array_unique(array_filter([
                (string) ($org['telephone'] ?? '+91 88949 00142'),
                '+91 18944 55019',
            ]))),
            'offices' => ContactSupport::offices(),
        ];
    }

    /**
     * Compact services list derived from ServiceSupport for agent catalog tools.
     *
     * @return array<int, array{slug: string|null, title: string, summary: string, url: string|null}>
     */
    public static function servicesCatalog(): array
    {
        return array_map(static function (array $row): array {
            $url = (string) ($row[4] ?? '');
            $slug = null;
            if (preg_match('#/services?/([^/?#]+)#', $url, $matches) === 1) {
                $slug = $matches[1];
            }

            return [
                'slug' => $slug,
                'title' => (string) ($row[1] ?? ''),
                'summary' => (string) ($row[2] ?? ''),
                'url' => $url !== '' ? $url : null,
            ];
        }, ServiceSupport::servicesData());
    }

    /**
     * Trimmed service detail payload for a slug, without heavy media fields.
     *
     * @return array<string, mixed>|null
     */
    public static function serviceDetail(string $slug): ?array
    {
        $service = ServiceSupport::service($slug);

        if ($service === null) {
            return null;
        }

        return self::trimPayload($service, [
            'slug',
            'seoTitle',
            'seoDescription',
            'heroTitle',
            'heroDescription',
            'introTitle',
            'introDescription',
            'bodyParagraphs',
            'capabilities',
            'industries',
            'whyCards',
            'processSteps',
            'standoutCards',
            'faqs',
            'finalTitle',
            'finalDescription',
        ]);
    }

    /**
     * Compact industries list for agent catalog tools.
     *
     * @return array<int, array{slug: string, title: string, summary: string}>
     */
    public static function industriesCatalog(): array
    {
        $catalog = [];

        foreach (IndustrySupport::aiSolutions() as $item) {
            $url = (string) ($item[4] ?? '');
            $slug = self::slugFromRouteUrl($url);

            $catalog[] = [
                'slug' => $slug,
                'title' => (string) ($item[0] ?? ''),
                'summary' => (string) ($item[1] ?? ''),
                'url' => $url !== '' ? $url : null,
            ];
        }

        if ($catalog === []) {
            foreach (array_keys(IndustryDetailSupport::SLUG_FILES) as $slug) {
                $industry = IndustryDetailSupport::industry($slug);
                if ($industry === null) {
                    continue;
                }

                $catalog[] = [
                    'slug' => $slug,
                    'title' => is_array($industry['heroTitle'] ?? null)
                        ? (string) ($industry['heroTitle'][0] ?? $slug)
                        : (string) ($industry['seoTitle'] ?? $slug),
                    'summary' => (string) ($industry['heroDescription'] ?? $industry['introDescription'] ?? ''),
                    'url' => route('industry.show', ['slug' => $slug]),
                ];
            }
        }

        return $catalog;
    }

    /**
     * Trimmed industry detail payload for a slug, without heavy media fields.
     *
     * @return array<string, mixed>|null
     */
    public static function industryDetail(string $slug): ?array
    {
        $industry = IndustryDetailSupport::industry($slug);

        if ($industry === null) {
            return null;
        }

        return self::trimPayload($industry, [
            'slug',
            'seoTitle',
            'seoDescription',
            'heroTitle',
            'heroDescription',
            'introTitle',
            'introDescription',
            'services',
            'specialized',
            'whyCards',
            'processes',
            'faqs',
            'marqueeLabels',
            'finalTitle',
            'finalDescription',
        ]);
    }

    /**
     * Keep only selected keys and strip media/asset noise from nested values.
     *
     * @param  array<string, mixed>  $payload
     * @param  list<string>  $keys
     * @return array<string, mixed>
     */
    protected static function trimPayload(array $payload, array $keys): array
    {
        $trimmed = [];

        foreach ($keys as $key) {
            if (! array_key_exists($key, $payload)) {
                continue;
            }

            $trimmed[$key] = self::stripMediaNoise($payload[$key]);
        }

        return $trimmed;
    }

    /**
     * Recursively drop image/icon/url noise keys while keeping service/industry hrefs.
     */
    protected static function stripMediaNoise(mixed $value): mixed
    {
        if (is_array($value)) {
            $cleaned = [];
            foreach ($value as $key => $item) {
                if (is_string($key) && preg_match('/(image|img|icon|logo|banner|background|alt|href|url|src)/i', $key) === 1) {
                    if (in_array($key, ['href', 'url'], true) && is_string($item) && (str_contains($item, '/service/') || str_contains($item, '/industries/'))) {
                        $cleaned[$key] = $item;
                    }

                    continue;
                }

                $cleaned[$key] = self::stripMediaNoise($item);
            }

            return $cleaned;
        }

        return $value;
    }

    /**
     * Extract an industry slug from a marketing route URL.
     */
    protected static function slugFromRouteUrl(string $url): string
    {
        if (preg_match('#/industries/([^/?#]+)#', $url, $matches) === 1) {
            return $matches[1];
        }

        return '';
    }
}
