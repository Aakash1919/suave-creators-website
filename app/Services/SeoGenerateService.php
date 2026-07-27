<?php

namespace App\Services;

class SeoGenerateService
{
    /**
     * @var array<string, mixed>
     */
    protected array $overrides = [];

    /**
     * @param  array<string, mixed>  $data
     */
    public function override(array $data): self
    {
        $this->overrides = array_merge($this->overrides, array_filter(
            $data,
            static fn (mixed $value): bool => $value !== null && $value !== ''
        ));

        return $this;
    }

    /**
     * @param  array<string, mixed>|null  $overrides
     * @return array<string, mixed>
     */
    public function generate(?array $overrides = null): array
    {
        $site = config('seo.site', []);
        $routeName = optional(request()->route())->getName();
        $page = is_string($routeName)
            ? (array) config("seo.pages.{$routeName}", [])
            : [];

        $merged = array_merge(
            [
                'title' => $site['default_title'] ?? ($site['name'] ?? 'Suave Creators'),
                'description' => $site['default_description'] ?? ($site['name'] ?? 'Suave Creators'),
                'og_title' => null,
                'og_description' => null,
                'image' => $site['default_og_image'] ?? null,
                'og_image_width' => $site['default_og_image_width'] ?? 1200,
                'og_image_height' => $site['default_og_image_height'] ?? 630,
                'og_image_alt' => $site['default_og_image_alt'] ?? ($site['name'] ?? 'Suave Creators'),
                'type' => 'website',
                'robots' => $site['robots'] ?? 'index, follow',
                'faqs' => $routeName === 'home' ? ($site['default_faqs'] ?? null) : null,
            ],
            array_filter([
                'title' => $page['title'] ?? null,
                'description' => $page['description'] ?? null,
                'og_title' => $page['og_title'] ?? null,
                'og_description' => $page['og_description'] ?? null,
                'image' => $page['og_image'] ?? null,
                'robots' => $page['robots'] ?? null,
                'json_ld_name' => $page['json_ld_name'] ?? null,
                'json_ld_description' => $page['json_ld_description'] ?? null,
                'faqs' => $page['faqs'] ?? null,
            ], static fn (mixed $value): bool => $value !== null && $value !== ''),
            $this->overrides,
            array_filter(
                $overrides ?? [],
                static fn (mixed $value): bool => $value !== null && $value !== ''
            )
        );

        $title = (string) $merged['title'];
        $description = (string) $merged['description'];
        $ogTitle = (string) ($merged['og_title'] ?? $title);
        $ogDescription = (string) ($merged['og_description'] ?? $description);
        $canonical = (string) ($merged['canonical'] ?? url()->current());
        $imageUrl = $this->resolveAssetUrl($merged['image'] ?? null);
        $siteName = (string) ($site['name'] ?? 'Suave Creators');

        $hreflang = [];
        foreach ((array) ($site['hreflang'] ?? []) as $locale) {
            $hreflang[(string) $locale] = $canonical;
        }

        $faqs = is_array($merged['faqs'] ?? null) ? $merged['faqs'] : null;

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'robots' => (string) ($merged['robots'] ?? 'index, follow'),
            'verification' => (string) ($site['google_site_verification'] ?? ''),
            'hreflang' => $hreflang,
            'og' => [
                'title' => $ogTitle,
                'description' => $ogDescription,
                'type' => (string) ($merged['type'] ?? 'website'),
                'url' => $canonical,
                'image' => $imageUrl,
                'image_width' => (int) ($merged['og_image_width'] ?? 1200),
                'image_height' => (int) ($merged['og_image_height'] ?? 630),
                'image_alt' => (string) ($merged['og_image_alt'] ?? $siteName),
                'site_name' => $siteName,
            ],
            'twitter' => [
                'card' => 'summary_large_image',
                'title' => $ogTitle,
                'description' => $ogDescription,
                'image' => $imageUrl,
            ],
            'jsonLd' => $this->buildJsonLd(
                $site,
                (string) ($merged['json_ld_name'] ?? $title),
                (string) ($merged['json_ld_description'] ?? $description),
                $canonical,
                $imageUrl,
                is_array($faqs) ? $faqs : null,
                is_string($routeName) ? $routeName : null
            ),
        ];
    }

    /**
     * @param  array<string, mixed>  $site
     * @param  array<int, array{question?: string, answer?: string, name?: string, text?: string}>|null  $faqs
     * @return array<string, mixed>
     */
    protected function buildJsonLd(
        array $site,
        string $title,
        string $description,
        string $canonical,
        ?string $imageUrl,
        ?array $faqs,
        ?string $routeName
    ): array {
        $org = (array) ($site['organization'] ?? []);
        $baseUrl = rtrim((string) config('app.url', url('/')), '/');
        $logoUrl = $this->resolveAssetUrl($site['logo'] ?? null) ?? $imageUrl;
        $email = strtolower((string) ($org['email'] ?? ''));
        $telephone = (string) ($org['telephone_schema'] ?? $org['telephone'] ?? '');
        $pageUrl = rtrim($canonical, '/');
        $webPageId = $routeName === 'home'
            ? $baseUrl.'/#homepage'
            : $pageUrl.'/#webpage';
        $breadcrumbId = $routeName === 'home'
            ? $baseUrl.'/#breadcrumb'
            : $pageUrl.'/#breadcrumb';

        $organization = [
            '@type' => 'Organization',
            '@id' => $baseUrl.'/#organization',
            'name' => (string) ($org['legal_name'] ?? $site['name'] ?? 'Suave Creators'),
            'url' => $baseUrl.'/',
            'logo' => $logoUrl,
            'image' => $imageUrl,
            'email' => $email !== '' ? 'mailto:'.$email : null,
            'telephone' => $telephone !== '' ? $telephone : null,
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $telephone !== '' ? $telephone : null,
                'contactType' => 'customer service',
                'email' => $email !== '' ? $email : null,
                'areaServed' => (string) ($org['area_served'] ?? 'Worldwide'),
                'availableLanguage' => array_values((array) ($org['available_language'] ?? ['en'])),
            ],
            'address' => array_merge(
                ['@type' => 'PostalAddress'],
                (array) ($org['address'] ?? [])
            ),
            'sameAs' => array_values((array) ($org['sameAs'] ?? [])),
            'knowsAbout' => array_values((array) ($org['knowsAbout'] ?? [])),
        ];

        $organization['contactPoint'] = array_filter(
            $organization['contactPoint'],
            static fn (mixed $value): bool => $value !== null && $value !== ''
        );

        $graph = [
            array_filter($organization, static fn (mixed $value): bool => $value !== null),
            [
                '@type' => 'WebSite',
                '@id' => $baseUrl.'/#website',
                'url' => $baseUrl.'/',
                'name' => (string) ($site['name'] ?? 'Suave Creators'),
                'inLanguage' => (string) ($site['in_language'] ?? 'en-US'),
                'publisher' => [
                    '@id' => $baseUrl.'/#organization',
                ],
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => $baseUrl.'/?q={search_term}',
                    'query-input' => 'required name=search_term',
                ],
            ],
            [
                '@type' => 'WebPage',
                '@id' => $webPageId,
                'url' => $canonical,
                'name' => $title,
                'description' => $description,
                'inLanguage' => (string) ($site['in_language'] ?? 'en-US'),
                'isPartOf' => [
                    '@id' => $baseUrl.'/#website',
                ],
                'breadcrumb' => [
                    '@id' => $breadcrumbId,
                ],
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $breadcrumbId,
                'itemListElement' => $this->breadcrumbItems($canonical, $title, $baseUrl, $routeName),
            ],
        ];

        if (is_array($faqs) && $faqs !== []) {
            $faqPageUrl = ($routeName === 'home' ? $baseUrl.'/' : $canonical).'#faq';

            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $faqPageUrl,
                'mainEntity' => array_values(array_map(static function (array $faq, int $index) use ($faqPageUrl): array {
                    $question = (string) ($faq['question'] ?? $faq['name'] ?? '');
                    $answer = (string) ($faq['answer'] ?? $faq['text'] ?? '');
                    $answerUrl = $faqPageUrl.'-'.($index + 1);

                    return [
                        '@type' => 'Question',
                        'name' => $question,
                        'answerCount' => 1,
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $answer,
                            'url' => $answerUrl,
                        ],
                    ];
                }, $faqs, array_keys($faqs))),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function breadcrumbItems(string $canonical, string $title, string $baseUrl, ?string $routeName): array
    {
        if ($routeName === 'home') {
            return [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => $baseUrl.'/',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Services',
                    'item' => $baseUrl.'/services',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => 'Contact',
                    'item' => $baseUrl.'/contact-us',
                ],
            ];
        }

        return [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $baseUrl.'/',
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $title,
                'item' => $canonical,
            ],
        ];
    }

    protected function resolveAssetUrl(mixed $path): ?string
    {
        if (! is_string($path) || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}
