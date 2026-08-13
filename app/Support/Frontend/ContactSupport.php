<?php

namespace App\Support\Frontend;

class ContactSupport
{
    public const DEMO_HREF = 'https://calendar.google.com/calendar/u/0/appointments/schedules/AcZssZ2D8d2UlApRNeJryaGldFknb4uF3ua7jFnBA4-ga1Q-lgnLz9K382sK5S2-4J2e-tWD8arDeGXy';

    public static function demoHref(): string
    {
        return self::DEMO_HREF;
    }

    public static function isBookingCtaLabel(string $label): bool
    {
        $normalized = strtolower($label);

        return str_contains($normalized, 'demo')
            || str_contains($normalized, 'consultation')
            || str_contains($normalized, 'book a call')
            || str_contains($normalized, 'discovery call')
            || str_contains($normalized, 'discuss your vision')
            || str_contains($normalized, 'discuss about vision')
            || str_contains($normalized, 'drop your vision');
    }

    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return [
            'contactCards' => self::contactCards(),
            'offices' => self::offices(),
            'formServices' => self::formServices(),
            'techStack' => AboutSupport::techStack(),
            'faqs' => self::faqs(),
            'faqMedia' => 'assets/media/diverse-team-data-meeting.webp',
            'faqMediaAlt' => 'Business team collaborating on a custom software project with Suave Creators',
            'faqCtaHref' => '#contact-id',
            'faqCtaLabel' => 'Send a Message',
        ];
    }

    /**
     * Dual offices from SEO config (Sheridan WY + Palampur), with legacy address fallbacks.
     *
     * @return array<int, array{label: string, display: string, lines: array<int, string>, country: string, flag: string, map_embed: string, map_link: string}>
     */
    public static function offices(): array
    {
        $org = (array) config('seo.site.organization', []);
        $offices = (array) ($org['offices'] ?? []);
        $countryByIndex = [
            strtoupper((string) data_get($org, 'address.addressCountry', 'US')),
            strtoupper((string) data_get($org, 'address_secondary.addressCountry', 'IN')),
        ];

        if ($offices !== []) {
            return array_values(array_map(static function (array $office, int $index) use ($countryByIndex): array {
                $country = strtoupper((string) ($office['country'] ?? $countryByIndex[$index] ?? 'US'));
                $display = (string) ($office['display'] ?? '');

                return [
                    'label' => (string) ($office['label'] ?? 'Office'),
                    'display' => $display,
                    'lines' => array_values(array_filter(
                        (array) ($office['lines'] ?? []),
                        static fn (mixed $line): bool => is_string($line) && $line !== ''
                    )),
                    'country' => $country,
                    'flag' => self::flagCode($country),
                    'map_embed' => (string) ($office['map_embed'] ?? self::mapEmbedUrl($display, $country)),
                    'map_link' => (string) ($office['map_link'] ?? self::mapLinkUrl($display)),
                ];
            }, $offices, array_keys($offices)));
        }

        $primary = (string) ($org['address_display'] ?? '30 N Gould St, STE R, Sheridan, WY 82801, USA');
        $secondary = (string) ($org['address_secondary_display'] ?? '');

        $result = [
            [
                'label' => 'First office',
                'display' => $primary,
                'lines' => array_values(array_filter(array_map('trim', explode(',', $primary)))),
                'country' => $countryByIndex[0],
                'flag' => self::flagCode($countryByIndex[0]),
                'map_embed' => self::mapEmbedUrl($primary, $countryByIndex[0]),
                'map_link' => self::mapLinkUrl($primary),
            ],
        ];

        if ($secondary !== '') {
            $result[] = [
                'label' => 'Second office',
                'display' => $secondary,
                'lines' => array_values(array_filter(array_map('trim', explode(',', $secondary)))),
                'country' => $countryByIndex[1],
                'flag' => self::flagCode($countryByIndex[1]),
                'map_embed' => self::mapEmbedUrl($secondary, $countryByIndex[1]),
                'map_link' => self::mapLinkUrl($secondary),
            ];
        }

        return $result;
    }

    /**
     * ISO-ish country code → flag asset key (us|in).
     */
    public static function flagCode(string $country): string
    {
        return match (strtoupper($country)) {
            'IN', 'IND', 'INDIA' => 'in',
            default => 'us',
        };
    }

    /**
     * Google Maps embed URL for an office (no API key required).
     */
    public static function mapEmbedUrl(string $query, string $country = 'US'): string
    {
        $q = trim($query);
        if ($q === '') {
            $q = self::flagCode($country) === 'in'
                ? '3M Plaza, Maranda, Kasoti, Palampur, Himachal Pradesh 176102'
                : '30 N Gould St, STE R, Sheridan, WY 82801, USA';
        }

        return 'https://maps.google.com/maps?q='.rawurlencode($q).'&z=16&output=embed';
    }

    /**
     * Google Maps open-in-new-tab URL for an office.
     */
    public static function mapLinkUrl(string $query): string
    {
        $q = trim($query) !== '' ? $query : 'Sheridan, WY 82801, USA';

        return 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($q);
    }

    /**
     * @return array<string, string>
     */
    public static function formServices(): array
    {
        return [
            'web-development' => 'Web Development',
            'ai-solutions' => 'AI Solutions',
            'ui-ux-design' => 'UI/UX Design',
            'ecommerce' => 'E-commerce Development',
            'custom-crm' => 'Custom CRM Development',
            'enterprise-software' => 'Enterprise Software',
            'other' => 'Other',
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function contactCards(): array
    {
        $org = (array) config('seo.site.organization', []);
        $email = strtolower((string) ($org['email'] ?? 'info@suavecreators.com'));
        $offices = self::offices();

        $addressLines = [];
        foreach ($offices as $office) {
            $addressLines[] = $office['label'].':';
            foreach ($office['lines'] as $line) {
                $addressLines[] = $line;
            }
            $addressLines[] = '';
        }

        while ($addressLines !== [] && end($addressLines) === '') {
            array_pop($addressLines);
        }

        return [
            [
                'icon' => 'fa-solid fa-location-dot',
                'label' => 'Visit our office',
                'title' => 'Address',
                'lines' => $addressLines,
                'offices' => $offices,
                'links' => [],
            ],
            [
                'icon' => 'fa-regular fa-envelope',
                'label' => 'Write to our team',
                'title' => 'Mail Support',
                'lines' => [],
                'offices' => [],
                'links' => [
                    ['href' => 'mailto:'.$email, 'text' => $email],
                ],
            ],
            [
                'icon' => 'fa-solid fa-phone',
                'label' => 'Speak with an expert',
                'title' => 'Phone',
                'lines' => [],
                'offices' => [],
                'links' => [
                    ['href' => 'tel:+13074359605', 'text' => '+1 (307) 435-9605', 'flag' => 'us'],
                    ['href' => 'tel:+918894900142', 'text' => '+91 88949 00142',  'flag' => 'in'],
                    ['href' => 'tel:+911894455019', 'text' => '+91 18944 55019',  'flag' => 'in'],
                ],
                'labels' => ['India', 'USA'],
            ],
        ];
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    public static function faqs(): array
    {
        return [
            [
                'question' => 'How soon will I get a response after contacting your team?',
                'answer' => 'Usually, we respond within 12 hours on business days. If you have shared project details, our team will review them and get back to you with the next steps or a discovery call invite.',
            ],
            [
                'question' => 'Do you work with clients outside of India?',
                'answer' => 'Yes! We work with clients globally. Our expert team is experienced in managing remote projects and communicating effectively across different time zones.',
            ],
            [
                'question' => 'What information should I include when contacting you about a project?',
                'answer' => 'You can include your project requirements, budget range, and deadline expectations, if available. This helps us understand your vision and provide a more accurate proposal or consultation.',
            ],
            [
                'question' => 'Is the initial consultation free?',
                'answer' => 'Yes. Your first discovery call is free and obligation-free. We use it to understand your goals, answer questions, and outline a practical next step for your project.',
            ],
            [
                'question' => 'How do I schedule a call with your team?',
                'answer' => 'Fill out the contact form with your preferred time and project details, or email us at info@suavecreators.com. We will confirm a discovery call that works across your time zone.',
            ],
        ];
    }
}
