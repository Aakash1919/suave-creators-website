<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
                'keywords' => $site['default_keywords'] ?? null,
                'author' => $site['author'] ?? ($site['name'] ?? 'Suave Creators'),
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
                'keywords' => $page['keywords'] ?? null,
                'author' => $page['author'] ?? null,
                'og_title' => $page['og_title'] ?? null,
                'og_description' => $page['og_description'] ?? null,
                'twitter_description' => $page['twitter_description'] ?? null,
                'image' => $page['og_image'] ?? null,
                'og_image_width' => $page['og_image_width'] ?? null,
                'og_image_height' => $page['og_image_height'] ?? null,
                'og_image_alt' => $page['og_image_alt'] ?? null,
                'robots' => $page['robots'] ?? null,
                'json_ld_name' => $page['json_ld_name'] ?? null,
                'json_ld_description' => $page['json_ld_description'] ?? null,
                'json_ld_breadcrumb_name' => $page['json_ld_breadcrumb_name'] ?? null,
                'faqs' => $page['faqs'] ?? null,
                'hreflang' => $page['hreflang'] ?? null,
                'og_locale' => $page['og_locale'] ?? null,
                'og_locale_alternate' => $page['og_locale_alternate'] ?? null,
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
        $canonical = $this->canonicalUrl($merged['canonical'] ?? null);
        $imageUrl = $this->resolveAssetUrl($merged['image'] ?? null);
        $siteName = (string) ($site['name'] ?? 'Suave Creators');
        $imageAlt = (string) ($merged['og_image_alt'] ?? $siteName);

        $hreflangLocales = is_array($merged['hreflang'] ?? null) && $merged['hreflang'] !== []
            ? $merged['hreflang']
            : (array) ($site['hreflang'] ?? []);
        $hreflang = [];
        foreach ($hreflangLocales as $locale) {
            $hreflang[(string) $locale] = $canonical;
        }

        $faqs = is_array($merged['faqs'] ?? null) ? $merged['faqs'] : null;
        $robots = (string) ($merged['robots'] ?? 'index, follow');

        if (config('seo.noindex')) {
            $robots = 'noindex, nofollow';
        }

        $twitterSite = (string) ($site['twitter_site'] ?? '');
        $twitterCreator = (string) ($site['twitter_creator'] ?? $twitterSite);

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => (string) ($merged['keywords'] ?? ''),
            'author' => (string) ($merged['author'] ?? $siteName),
            'canonical' => $canonical,
            'robots' => $robots,
            'verification' => (string) ($site['google_site_verification'] ?? ''),
            'hreflang' => $hreflang,
            'og' => [
                'title' => $ogTitle,
                'description' => $ogDescription,
                'type' => (string) ($merged['type'] ?? 'website'),
                'url' => $canonical,
                'image' => $imageUrl,
                'image_secure_url' => $imageUrl,
                'image_type' => $this->imageMimeType($imageUrl),
                'image_width' => (int) ($merged['og_image_width'] ?? 1200),
                'image_height' => (int) ($merged['og_image_height'] ?? 630),
                'image_alt' => $imageAlt,
                'site_name' => $siteName,
                'locale' => (string) ($merged['og_locale'] ?? $site['og_locale'] ?? 'en_US'),
                'locale_alternate' => array_values(array_filter(
                    (array) ($merged['og_locale_alternate'] ?? $site['og_locale_alternate'] ?? []),
                    static fn (mixed $value): bool => is_string($value) && $value !== ''
                )),
            ],
            'twitter' => [
                'card' => 'summary_large_image',
                'site' => $twitterSite,
                'creator' => $twitterCreator,
                'title' => (string) ($merged['twitter_title'] ?? $ogTitle),
                'description' => (string) ($merged['twitter_description'] ?? $ogDescription),
                'image' => $imageUrl,
                'image_alt' => $imageAlt,
            ],
            'jsonLd' => $this->buildJsonLd(
                $site,
                (string) ($merged['json_ld_name'] ?? $title),
                (string) ($merged['json_ld_description'] ?? $description),
                $canonical,
                $imageUrl,
                is_array($faqs) ? $faqs : null,
                is_string($routeName) ? $routeName : null,
                is_array($merged['json_ld_graph'] ?? null) ? $merged['json_ld_graph'] : null,
                is_string($merged['json_ld_webpage_about'] ?? null) ? $merged['json_ld_webpage_about'] : null,
                is_string($merged['json_ld_breadcrumb_name'] ?? null) ? $merged['json_ld_breadcrumb_name'] : null,
                is_array($merged['json_ld_webpage_about_topics'] ?? null) ? $merged['json_ld_webpage_about_topics'] : null,
                is_array($merged['json_ld_webpage_mentions'] ?? null) ? $merged['json_ld_webpage_mentions'] : null,
            ),
        ];
    }

    /**
     * @param  array<string, mixed>  $site
     * @param  array<int, array{question?: string, answer?: string, name?: string, text?: string}>|null  $faqs
     * @param  array<int, array<string, mixed>>|null  $extraGraph
     * @param  array<int, array<string, mixed>>|null  $webPageAboutTopics
     * @param  array<int, array<string, mixed>>|null  $webPageMentions
     * @return array<string, mixed>
     */
    protected function buildJsonLd(
        array $site,
        string $title,
        string $description,
        string $canonical,
        ?string $imageUrl,
        ?array $faqs,
        ?string $routeName,
        ?array $extraGraph = null,
        ?string $webPageAboutId = null,
        ?string $breadcrumbName = null,
        ?array $webPageAboutTopics = null,
        ?array $webPageMentions = null,
    ): array {
        if ($routeName === 'home') {
            return $this->buildHomeJsonLd($site, $title, $description, $canonical, $imageUrl, $faqs);
        }

        $org = (array) ($site['organization'] ?? []);
        $baseUrl = rtrim((string) config('app.url', url('/')), '/');
        $logoUrl = $this->resolveAssetUrl($site['logo'] ?? null) ?? $imageUrl;
        $email = strtolower((string) ($org['email'] ?? ''));
        $telephone = (string) ($org['telephone_schema'] ?? $org['telephone'] ?? '');
        $pageUrl = rtrim($canonical, '/');
        $webPageId = $routeName === 'home' ? $baseUrl.'/#homepage' : $pageUrl.'/#webpage';
        $breadcrumbId = $routeName === 'home' ? $baseUrl.'/#breadcrumb' : $pageUrl.'/#breadcrumb';
        $organizationId = $baseUrl.'/#organization';

        $logo = $logoUrl === null ? null : [
            '@type' => 'ImageObject',
            '@id' => $baseUrl.'/#logo',
            'url' => $logoUrl,
            'caption' => (string) ($site['logo_caption'] ?? (($site['name'] ?? 'Suave Creators').' Logo')),
        ];

        $contactPoints = $this->contactPoints($org, $email, $telephone);
        $aggregateRating = $this->aggregateRating($org);

        $organization = [
            '@type' => 'Organization',
            '@id' => $organizationId,
            'name' => (string) ($org['legal_name'] ?? $site['name'] ?? 'Suave Creators'),
            'url' => $baseUrl.'/',
            'logo' => $logo,
            'image' => $imageUrl,
            'email' => $email !== '' ? $email : null,
            'telephone' => $telephone !== '' ? $telephone : null,
            'contactPoint' => $contactPoints,
            'address' => self::postalAddresses($org),
            'sameAs' => array_values((array) ($org['sameAs'] ?? [])),
            'knowsAbout' => array_values((array) ($org['knowsAbout'] ?? [])),
            'aggregateRating' => $aggregateRating,
        ];

        $graph = [
            array_filter($organization, static fn (mixed $value): bool => $value !== null && $value !== []),
            [
                '@type' => 'WebSite',
                '@id' => $baseUrl.'/#website',
                'url' => $baseUrl.'/',
                'name' => (string) ($site['name'] ?? 'Suave Creators'),
                'description' => (string) ($site['website_description'] ?? ($site['default_description'] ?? '')),
                'publisher' => [
                    '@id' => $organizationId,
                ],
                'inLanguage' => (string) ($site['in_language'] ?? 'en-US'),
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
                'isPartOf' => [
                    '@id' => $baseUrl.'/#website',
                ],
                'about' => [
                    '@id' => $organizationId,
                ],
                'breadcrumb' => [
                    '@id' => $breadcrumbId,
                ],
                'inLanguage' => (string) ($site['in_language'] ?? 'en-US'),
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $breadcrumbId,
                'itemListElement' => $this->breadcrumbItems($canonical, $breadcrumbName ?? $title, $baseUrl, $routeName),
            ],
        ];

        if (is_array($faqs) && $faqs !== []) {
            $faqPageUrl = ($routeName === 'home' ? $baseUrl.'/' : $canonical).'#faq';

            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $faqPageUrl,
                'isPartOf' => ['@id' => $webPageId],
                'mainEntity' => $this->faqMainEntity($faqs),
            ];
        }

        if ($imageUrl !== null && $imageUrl !== '') {
            foreach ($graph as $index => $node) {
                if (($node['@type'] ?? '') === 'WebPage') {
                    $graph[$index]['primaryImageOfPage'] = [
                        '@type' => 'ImageObject',
                        'url' => $imageUrl,
                        'width' => 1200,
                        'height' => 630,
                    ];
                    break;
                }
            }
        }

        if ($webPageAboutId !== null && $webPageAboutId !== '') {
            foreach ($graph as $index => $node) {
                if (($node['@type'] ?? '') === 'WebPage') {
                    $graph[$index]['about'] = is_array($webPageAboutTopics) && $webPageAboutTopics !== []
                        ? $webPageAboutTopics
                        : ['@id' => $webPageAboutId];
                    $graph[$index]['mainEntity'] = ['@id' => $webPageAboutId];
                    $graph[$index]['publisher'] = ['@id' => $organizationId];

                    if (is_array($webPageMentions) && $webPageMentions !== []) {
                        $graph[$index]['mentions'] = $webPageMentions;
                    }
                    break;
                }
            }
        }

        if (is_array($extraGraph) && $extraGraph !== []) {
            foreach ($extraGraph as $node) {
                $graph[] = $node;
            }
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    /**
     * Homepage graph: Organization, India engineering center, offer catalog,
     * WebSite, WebPage, and FAQPage. Other routes keep the shared graph.
     *
     * @param  array<string, mixed>  $site
     * @param  array<int, array{question?: string, answer?: string, name?: string, text?: string}>|null  $faqs
     * @return array<string, mixed>
     */
    protected function buildHomeJsonLd(
        array $site,
        string $title,
        string $description,
        string $canonical,
        ?string $imageUrl,
        ?array $faqs,
    ): array {
        $org = (array) ($site['organization'] ?? []);
        $baseUrl = rtrim((string) config('app.url', url('/')), '/');
        $organizationId = $baseUrl.'/#organization';
        $webpageId = $baseUrl.'/#webpage';
        $logoUrl = $this->resolveAssetUrl($site['logo'] ?? null);
        $email = strtolower((string) ($org['email'] ?? ''));
        $telephone = (string) ($org['telephone_schema'] ?? $org['telephone'] ?? '');
        $siteName = (string) ($site['name'] ?? 'Suave Creators');

        $logo = $logoUrl === null ? null : array_filter([
            '@type' => 'ImageObject',
            '@id' => $baseUrl.'/#logo',
            'url' => $logoUrl,
            'width' => is_numeric($site['logo_width'] ?? null) ? (int) $site['logo_width'] : null,
            'height' => is_numeric($site['logo_height'] ?? null) ? (int) $site['logo_height'] : null,
        ], static fn (mixed $value): bool => $value !== null && $value !== '');

        $primaryAddress = (array) ($org['address'] ?? []);
        $address = $primaryAddress === [] ? null : array_merge(['@type' => 'PostalAddress'], $primaryAddress);

        $organization = [
            '@type' => 'Organization',
            '@id' => $organizationId,
            'name' => $siteName,
            'legalName' => (string) ($org['legal_name'] ?? $siteName),
            'alternateName' => array_values(array_filter(
                (array) ($org['alternate_name'] ?? []),
                static fn (mixed $value): bool => is_string($value) && $value !== ''
            )),
            'url' => $baseUrl.'/',
            'logo' => $logo === [] ? null : $logo,
            'image' => $logo === [] ? $imageUrl : ['@id' => $baseUrl.'/#logo'],
            'description' => (string) ($org['description'] ?? ''),
            'slogan' => (string) ($org['slogan'] ?? ''),
            'foundingDate' => (string) ($org['founding_date'] ?? ''),
            'founder' => $this->homeFounder($org, $baseUrl),
            'numberOfEmployees' => $this->homeNumberOfEmployees($org),
            'email' => $email !== '' ? $email : null,
            'telephone' => $telephone !== '' ? $telephone : null,
            'address' => $address,
            'areaServed' => array_values(array_map(
                static fn (string $country): array => ['@type' => 'Country', 'name' => $country],
                array_values(array_filter(
                    (array) ($org['homepage_area_served'] ?? []),
                    static fn (mixed $value): bool => is_string($value) && $value !== ''
                ))
            )),
            'knowsAbout' => array_values(array_filter(
                (array) ($org['knowsAbout'] ?? []),
                static fn (mixed $value): bool => is_string($value) && $value !== ''
            )),
            'contactPoint' => $this->homeContactPoints($org, $email, $telephone),
            'department' => ['@id' => $baseUrl.'/#india-engineering-center'],
            'hasOfferCatalog' => ['@id' => $baseUrl.'/#services'],
            'sameAs' => array_values(array_filter(
                (array) ($org['sameAs'] ?? []),
                static fn (mixed $value): bool => is_string($value) && $value !== '' && ! str_contains($value, '[')
            )),
        ];

        $graph = [
            $this->withoutEmpty($organization),
            $this->homeEngineeringCenter($org, $baseUrl, $organizationId, $email),
            $this->homeOfferCatalog($org, $baseUrl, $organizationId),
            [
                '@type' => 'WebSite',
                '@id' => $baseUrl.'/#website',
                'url' => $baseUrl.'/',
                'name' => $siteName,
                'inLanguage' => (string) ($site['in_language'] ?? 'en-US'),
                'publisher' => ['@id' => $organizationId],
            ],
            $this->withoutEmpty([
                '@type' => 'WebPage',
                '@id' => $webpageId,
                'url' => $canonical,
                'name' => $title,
                'description' => $description,
                'isPartOf' => ['@id' => $baseUrl.'/#website'],
                'about' => ['@id' => $organizationId],
                'primaryImageOfPage' => $imageUrl === null ? null : [
                    '@type' => 'ImageObject',
                    'url' => $imageUrl,
                ],
                'inLanguage' => (string) ($site['in_language'] ?? 'en-US'),
                'datePublished' => $this->homePageDate('date_published', $org),
                'dateModified' => $this->homePageDate('date_modified', $org),
                'potentialAction' => [
                    '@type' => 'CommunicateAction',
                    'name' => 'Get a Scoped Estimate',
                    'target' => route('contact-us'),
                ],
            ]),
        ];

        if (is_array($faqs) && $faqs !== []) {
            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $baseUrl.'/#faq',
                'isPartOf' => ['@id' => $webpageId],
                'mainEntity' => $this->faqMainEntity($faqs),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    /**
     * Prefer pages.home date fields; fall back to founding year-01-01 for published.
     *
     * @param  array<string, mixed>  $org
     */
    protected function homePageDate(string $key, array $org): ?string
    {
        $configured = (string) config("seo.pages.home.{$key}", '');

        if ($configured !== '' && ! str_contains($configured, '[') && preg_match('/^\d{4}-\d{2}-\d{2}$/', $configured) === 1) {
            return $configured;
        }

        if ($key === 'date_published') {
            $year = (string) ($org['founding_date'] ?? '');
            if (preg_match('/^\d{4}$/', $year) === 1) {
                return $year.'-01-01';
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $org
     * @return array<string, mixed>|null
     */
    protected function homeNumberOfEmployees(array $org): ?array
    {
        $min = $org['number_of_employees_min'] ?? null;

        if (! is_numeric($min) || (int) $min < 1) {
            return null;
        }

        return [
            '@type' => 'QuantitativeValue',
            'minValue' => (int) $min,
        ];
    }

    /**
     * @param  array<string, mixed>  $org
     * @return array<string, mixed>|null
     */
    protected function homeFounder(array $org, string $baseUrl): ?array
    {
        $founder = (array) ($org['founder'] ?? []);
        $name = trim((string) ($founder['name'] ?? ''));

        if ($name === '' || str_contains($name, '[')) {
            return null;
        }

        $sameAs = array_values(array_filter(
            (array) ($founder['sameAs'] ?? []),
            static fn (mixed $value): bool => is_string($value) && $value !== '' && ! str_contains($value, '[')
        ));

        return $this->withoutEmpty([
            '@type' => 'Person',
            '@id' => $baseUrl.'/#founder',
            'name' => $name,
            'jobTitle' => (string) ($founder['job_title'] ?? ''),
            'sameAs' => $sameAs,
        ]);
    }

    /**
     * @param  array<string, mixed>  $org
     * @return array<int, array<string, mixed>>
     */
    protected function homeContactPoints(array $org, string $email, string $fallbackTelephone): array
    {
        $offices = array_values(array_filter(
            (array) ($org['offices'] ?? []),
            static fn (mixed $office): bool => is_array($office)
        ));

        $sales = null;
        $engineering = null;

        foreach ($offices as $office) {
            $country = (string) ($office['country'] ?? '');
            if ($country === 'US') {
                $sales = $office;
            }
            if ($country === 'IN') {
                $engineering = $office;
            }
        }

        $salesPhone = (string) ($sales['phone_schema'] ?? $fallbackTelephone);
        $engineeringPhone = (string) ($engineering['phone_schema'] ?? '');

        return array_values(array_filter([
            $this->withoutEmpty([
                '@type' => 'ContactPoint',
                'contactType' => 'sales',
                'telephone' => $salesPhone !== '' ? $salesPhone : null,
                'email' => $email !== '' ? $email : null,
                'areaServed' => 'US',
                'availableLanguage' => ['English'],
            ]),
            $this->withoutEmpty([
                '@type' => 'ContactPoint',
                'contactType' => 'technical support',
                'telephone' => $engineeringPhone !== '' ? $engineeringPhone : null,
                'email' => $email !== '' ? $email : null,
                'availableLanguage' => ['English', 'Hindi'],
            ]),
        ], static fn (array $point): bool => isset($point['telephone']) || isset($point['email'])));
    }

    /**
     * @param  array<string, mixed>  $org
     * @return array<string, mixed>
     */
    protected function homeEngineeringCenter(array $org, string $baseUrl, string $organizationId, string $email): array
    {
        $center = (array) ($org['engineering_center'] ?? []);
        $address = (array) ($org['address_secondary'] ?? []);
        $phone = '';

        foreach ((array) ($org['offices'] ?? []) as $office) {
            if (is_array($office) && ($office['country'] ?? '') === 'IN') {
                $phone = (string) ($office['phone_schema'] ?? $office['phone'] ?? '');
                break;
            }
        }

        $days = array_values(array_filter(
            (array) ($center['opening_days'] ?? []),
            static fn (mixed $value): bool => is_string($value) && $value !== ''
        ));

        $latitude = $center['latitude'] ?? null;
        $longitude = $center['longitude'] ?? null;
        $geo = is_numeric($latitude) && is_numeric($longitude)
            ? [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $latitude,
                'longitude' => (float) $longitude,
            ]
            : null;

        return $this->withoutEmpty([
            '@type' => 'ProfessionalService',
            '@id' => $baseUrl.'/#india-engineering-center',
            'name' => (string) ($center['name'] ?? 'Suave Creators – India Engineering Center'),
            'parentOrganization' => ['@id' => $organizationId],
            'url' => $baseUrl.'/',
            'telephone' => $phone !== '' ? $phone : null,
            'email' => $email !== '' ? $email : null,
            'priceRange' => (string) ($center['price_range'] ?? ''),
            'address' => $address === [] ? null : array_merge(['@type' => 'PostalAddress'], $address),
            'geo' => $geo,
            'openingHoursSpecification' => $days === [] ? null : [[
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => $days,
                'opens' => (string) ($center['opens'] ?? ''),
                'closes' => (string) ($center['closes'] ?? ''),
            ]],
        ]);
    }

    /**
     * @param  array<string, mixed>  $org
     * @return array<string, mixed>
     */
    protected function homeOfferCatalog(array $org, string $baseUrl, string $organizationId): array
    {
        $items = [];

        foreach ((array) ($org['offer_catalog'] ?? []) as $offer) {
            if (! is_array($offer)) {
                continue;
            }

            $routeName = (string) ($offer['route'] ?? '');
            $name = (string) ($offer['name'] ?? '');

            if ($routeName === '' || $name === '' || ! Route::has($routeName)) {
                continue;
            }

            $parameters = is_array($offer['parameters'] ?? null) ? $offer['parameters'] : [];
            $service = [
                '@type' => 'Service',
                'name' => $name,
                'url' => route($routeName, $parameters),
                'provider' => ['@id' => $organizationId],
            ];

            $serviceType = (string) ($offer['service_type'] ?? '');
            if ($serviceType !== '') {
                $service['serviceType'] = $serviceType;
            }

            $items[] = [
                '@type' => 'Offer',
                'itemOffered' => $service,
            ];
        }

        return [
            '@type' => 'OfferCatalog',
            '@id' => $baseUrl.'/#services',
            'name' => 'Custom software development services',
            'itemListElement' => $items,
        ];
    }

    /**
     * @param  array<int, array{question?: string, answer?: string, name?: string, text?: string}>  $faqs
     * @return array<int, array<string, mixed>>
     */
    protected function faqMainEntity(array $faqs): array
    {
        return array_values(array_map(static function (array $faq): array {
            return [
                '@type' => 'Question',
                'name' => (string) ($faq['question'] ?? $faq['name'] ?? ''),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => (string) ($faq['answer'] ?? $faq['text'] ?? ''),
                ],
            ];
        }, $faqs));
    }

    /**
     * @param  array<string, mixed>  $node
     * @return array<string, mixed>
     */
    protected function withoutEmpty(array $node): array
    {
        return array_filter(
            $node,
            static fn (mixed $value): bool => $value !== null && $value !== '' && $value !== []
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function breadcrumbItems(string $canonical, string $title, string $baseUrl, ?string $routeName): array
    {
        $position = 1;
        $breadcrumb[] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => 'Home',
            'item' => $baseUrl.'/',
        ];

        if (is_string($routeName)) {
            $parentName = config("seo.pages.{$routeName}.json_ld_breadcrumb_parent_name");
            $parentRoute = config("seo.pages.{$routeName}.json_ld_breadcrumb_parent_route");

            if (is_string($parentName) && $parentName !== '' && is_string($parentRoute) && $parentRoute !== '') {
                $breadcrumb[] = [
                    '@type' => 'ListItem',
                    'position' => ++$position,
                    'name' => $parentName,
                    'item' => route($parentRoute),
                ];
            }
        }

        if (in_array($routeName, ['service.show', 'industry.show', 'blog.show'])) {
            $parentUrl = Str::beforeLast($canonical, '/');
            $parentSlug = Str::afterLast($parentUrl, '/');
            $pageTitle = config("seo.pages.$parentSlug.json_ld_breadcrumb_name") ?? config("seo.pages.$parentSlug.title") ?? ucfirst(str_replace('-', ' ', $parentSlug));
            $breadcrumb[] = [
                '@type' => 'ListItem',
                'position' => ++$position,
                'name' => $pageTitle,
                'item' => $parentUrl,
            ];
        }

        if ($routeName != 'home') {
            $breadcrumb[] = [
                '@type' => 'ListItem',
                'position' => ++$position,
                'name' => $title,
                'item' => $canonical,
            ];
        }

        return $breadcrumb;
    }

    protected function resolveAssetUrl(mixed $path): ?string
    {
        if (! is_string($path) || $path === '') {
            return null;
        }

        $baseUrl = rtrim((string) config('app.url', url('/')), '/');

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            $assetHost = strtolower((string) (parse_url($path, PHP_URL_HOST) ?: ''));
            $primaryHost = strtolower((string) (parse_url($baseUrl, PHP_URL_HOST) ?: ''));

            if ($assetHost !== '' && $primaryHost !== '' && in_array($assetHost, [$primaryHost, 'www.'.$primaryHost], true)) {
                $assetPath = (string) (parse_url($path, PHP_URL_PATH) ?: '/');
                $query = (string) (parse_url($path, PHP_URL_QUERY) ?: '');

                return $baseUrl.'/'.ltrim($assetPath, '/').($query !== '' ? '?'.$query : '');
            }

            return $path;
        }

        return $baseUrl.'/'.ltrim($path, '/');
    }

    protected function canonicalUrl(mixed $url): string
    {
        $baseUrl = rtrim((string) config('app.url', url('/')), '/');
        $currentUrl = is_string($url) && $url !== '' ? $url : url()->current();

        if (! str_starts_with($currentUrl, 'http://') && ! str_starts_with($currentUrl, 'https://')) {
            $currentUrl = '/'.ltrim($currentUrl, '/');
        }

        $path = (string) (parse_url($currentUrl, PHP_URL_PATH) ?: '/');
        $query = (string) (parse_url($currentUrl, PHP_URL_QUERY) ?: '');
        $path = '/'.ltrim($path, '/');

        if ($query !== '') {
            parse_str($query, $params);
            $allowed = array_fill_keys(
                array_map('strval', (array) config('seo.allowed_query_params', [])),
                true
            );
            // Pagination stays off canonicals even when the request allows the keys.
            unset($params['page'], $params['per_page']);
            $params = array_filter(
                $params,
                static fn (mixed $value, mixed $key): bool => isset($allowed[(string) $key]),
                ARRAY_FILTER_USE_BOTH
            );
            $query = http_build_query($params);
        }

        return $baseUrl.$path.($query !== '' ? '?'.$query : '');
    }

    /**
     * @param  array<string, mixed>  $org
     * @return array<int, array<string, mixed>>|array<string, mixed>|null
     */
    protected function postalAddresses(array $org): ?array
    {
        $addresses = [];

        $primary = (array) ($org['address'] ?? []);
        if ($primary !== []) {
            $addresses[] = array_merge(['@type' => 'PostalAddress'], $primary);
        }

        $secondary = (array) ($org['address_secondary'] ?? []);
        if ($secondary !== []) {
            $addresses[] = array_merge(['@type' => 'PostalAddress'], $secondary);
        }

        if ($addresses === []) {
            return null;
        }

        return count($addresses) === 1 ? $addresses[0] : $addresses;
    }

    /**
     * @param  array<string, mixed>  $org
     * @return array<int, array<string, mixed>>
     */
    protected function contactPoints(array $org, string $email, string $fallbackTelephone): array
    {
        $offices = array_values(array_filter(
            (array) ($org['offices'] ?? []),
            static fn (mixed $office): bool => is_array($office)
        ));

        if ($offices === []) {
            $point = array_filter([
                '@type' => 'ContactPoint',
                'telephone' => $fallbackTelephone !== '' ? $fallbackTelephone : null,
                'contactType' => 'customer service',
                'email' => $email !== '' ? $email : null,
                'areaServed' => (string) ($org['area_served'] ?? 'Worldwide'),
                'availableLanguage' => array_values((array) ($org['available_language'] ?? ['en'])),
            ], static fn (mixed $value): bool => $value !== null && $value !== '');

            return $point === [] ? [] : [$point];
        }

        $points = [];

        foreach ($offices as $office) {
            $telephone = (string) ($office['phone_schema'] ?? $office['phone'] ?? '');
            $officeEmail = strtolower((string) ($office['email'] ?? $email));
            $areaServed = $office['area_served'] ?? [(string) ($office['country'] ?? 'Worldwide'), 'Worldwide'];
            $availableLanguage = $office['available_language'] ?? ($org['available_language'] ?? ['en']);

            $point = array_filter([
                '@type' => 'ContactPoint',
                'telephone' => $telephone !== '' ? $telephone : null,
                'contactType' => (string) ($office['contact_type'] ?? 'customer service'),
                'email' => $officeEmail !== '' ? $officeEmail : null,
                'areaServed' => array_values((array) $areaServed),
                'availableLanguage' => array_values((array) $availableLanguage),
            ], static fn (mixed $value): bool => $value !== null && $value !== '' && $value !== []);

            if ($point !== []) {
                $points[] = $point;
            }
        }

        return $points;
    }

    /**
     * @param  array<string, mixed>  $org
     * @return array<string, mixed>|null
     */
    protected function aggregateRating(array $org): ?array
    {
        $rating = (array) ($org['aggregateRating'] ?? []);
        $ratingValue = (string) ($rating['ratingValue'] ?? '');
        $reviewCount = (string) ($rating['reviewCount'] ?? '');

        if ($ratingValue === '' || $reviewCount === '') {
            return null;
        }

        return array_filter([
            '@type' => 'AggregateRating',
            'ratingValue' => $ratingValue,
            'reviewCount' => $reviewCount,
            'bestRating' => (string) ($rating['bestRating'] ?? '5'),
            'worstRating' => (string) ($rating['worstRating'] ?? '1'),
        ], static fn (mixed $value): bool => $value !== null && $value !== '');
    }

    protected function imageMimeType(?string $url): string
    {
        if (! is_string($url) || $url === '') {
            return 'image/png';
        }

        $path = strtolower((string) (parse_url($url, PHP_URL_PATH) ?: $url));

        return match (true) {
            str_ends_with($path, '.jpg'), str_ends_with($path, '.jpeg') => 'image/jpeg',
            str_ends_with($path, '.webp') => 'image/webp',
            str_ends_with($path, '.gif') => 'image/gif',
            str_ends_with($path, '.svg') => 'image/svg+xml',
            default => 'image/png',
        };
    }
}
