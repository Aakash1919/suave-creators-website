<?php

namespace App\Support\Frontend;

class ContactSupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return [
            'contactCards' => self::contactCards(),
            'formServices' => self::formServices(),
            'techStack' => AboutSupport::techStack(),
            'faqs' => self::faqs(),
            'faqMedia' => 'assets/media/faq-team-collaboration.gif',
            'faqMediaAlt' => 'Business team collaborating on a custom software project with Suave Creators',
            'faqCtaHref' => route('contact-us').'#contact-id',
            'faqCtaLabel' => 'Send a Message',
        ];
    }

    /**
     * @return array<int, array{label: string, display: string, lines: array<int, string>}>
     */
    public static function offices(): array
    {
        $org = (array) config('seo.site.organization', []);
        $offices = (array) ($org['offices'] ?? []);

        if ($offices !== []) {
            return array_values(array_map(static function (array $office): array {
                return [
                    'label' => (string) ($office['label'] ?? 'Office'),
                    'display' => (string) ($office['display'] ?? ''),
                    'lines' => array_values(array_filter(
                        (array) ($office['lines'] ?? []),
                        static fn (mixed $line): bool => is_string($line) && $line !== ''
                    )),
                ];
            }, $offices));
        }

        $primary = (string) ($org['address_display'] ?? '30 N Gould St, STE R, Sheridan, WY 82801, USA');
        $secondary = (string) ($org['address_secondary_display'] ?? '');

        $result = [
            [
                'label' => 'First office',
                'display' => $primary,
                'lines' => array_values(array_filter(array_map('trim', explode(',', $primary)))),
            ],
        ];

        if ($secondary !== '') {
            $result[] = [
                'label' => 'Second office',
                'display' => $secondary,
                'lines' => array_values(array_filter(array_map('trim', explode(',', $secondary)))),
            ];
        }

        return $result;
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
        $addressLines = [];
        foreach (self::offices() as $office) {
            $addressLines[] = $office['label'].':';
            foreach ($office['lines'] as $line) {
                $addressLines[] = $line;
            }
            $addressLines[] = '';
        }

        while ($addressLines !== [] && end($addressLines) === '') {
            array_pop($addressLines);
        }

        $org = (array) config('seo.site.organization', []);
        $email = strtolower((string) ($org['email'] ?? 'info@suavecreators.com'));

        return [
            [
                'icon' => 'fa-solid fa-location-dot',
                'label' => 'Visit our office',
                'title' => 'Address',
                'lines' => $addressLines,
                'links' => [],
            ],
            [
                'icon' => 'fa-regular fa-envelope',
                'label' => 'Write to our team',
                'title' => 'Mail Support',
                'lines' => [],
                'links' => [
                    ['href' => 'mailto:'.$email, 'text' => $email],
                ],
            ],
            [
                'icon' => 'fa-solid fa-phone',
                'label' => 'Speak with an expert',
                'title' => 'Phone',
                'lines' => [],
                'links' => [
                    ['href' => 'tel:+918894900142', 'text' => '+91 88949 00142'],
                    ['href' => 'tel:+911894455019', 'text' => '+91 18944 55019'],
                    [
                        'href' => (string) ($org['telephone_href'] ?? 'tel:+919736900142'),
                        'text' => (string) ($org['telephone'] ?? '+91 97369 00142'),
                    ],
                ],
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
        ];
    }
}
