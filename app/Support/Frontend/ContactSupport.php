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
        return [
            [
                'icon' => 'fa-solid fa-location-dot',
                'label' => 'Visit our office',
                'title' => 'Address',
                'lines' => ['30 N Gould St, STE R,', 'Sheridan, WY 82801, USA'],
                'links' => [],
            ],
            [
                'icon' => 'fa-regular fa-envelope',
                'label' => 'Write to our team',
                'title' => 'Mail Support',
                'lines' => [],
                'links' => [
                    ['href' => 'mailto:info@suavecreators.com', 'text' => 'info@suavecreators.com'],
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
