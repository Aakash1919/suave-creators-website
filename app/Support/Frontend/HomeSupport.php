<?php

namespace App\Support\Frontend;

class HomeSupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return array_merge(self::faqData(), [
            'testimonials' => self::testimonials(),
            'articles' => self::articles(),
            'servicesMarqueeItems' => self::servicesMarqueeItems(),
            'partnerMarqueeItems' => self::partnerMarqueeItems(),
        ]);
    }

    /**
     * @return array<int, array{label: string, style: string, separator: string}>
     */
    public static function servicesMarqueeItems(): array
    {
        return [
            ['label' => 'Web Development', 'style' => 'outlined', 'separator' => 'filled'],
            ['label' => 'Promotion Marketing', 'style' => 'filled', 'separator' => 'outlined'],
            ['label' => 'Advertising', 'style' => 'outlined', 'separator' => 'filled'],
            ['label' => 'CRM Development', 'style' => 'filled', 'separator' => 'outlined'],
        ];
    }

    /**
     * @return array<int, array{src: string, alt: string}>
     */
    public static function partnerMarqueeItems(): array
    {
        return [
            ['src' => 'assets/clients/verysoul-logo.png', 'alt' => 'VerySoul logo partner of Suave Creators software development'],
            ['src' => 'assets/clients/redsixity-logo.svg', 'alt' => 'RedSixity logo partner of Suave Creators digital solutions'],
            ['src' => 'assets/clients/dajj-logistics-logo.png', 'alt' => 'DAJJ Logistics logo partner of Suave Creators web development'],
            ['src' => 'assets/clients/ematrics-logo.png', 'alt' => 'Ematrics logo partner of Suave Creators custom software'],
            ['src' => 'assets/clients/bioassay-systems-logo.png', 'alt' => 'BioAssay Systems logo partner of Suave Creators technology services'],
        ];
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    public static function faqData(): array
    {
        return [
            'faqCtaHref' => route('contact-us').'#contact-id',
            'faqCtaLabel' => 'Start your Project',
            'faqMedia' => 'assets/media/faq-team-collaboration.gif',
            'faqMediaType' => 'image',
            'faqMediaAlt' => 'Business team collaborating on a custom software project with Suave Creators',
            'faqs' => [
                [
                    'question' => 'What services do you offer?',
                    'answer' => 'We offer the best web, software, CMS, CRM and custom development services in all the latest languages.',
                ],
                [
                    'question' => 'How long does it take to build a website?',
                    'answer' => 'Most website projects take 6–12 weeks, depending on complexity, integrations, and how quickly content and feedback are provided.',
                ],
                [
                    'question' => 'Do you provide ongoing support?',
                    'answer' => 'Yes. We offer maintenance, security updates, performance monitoring, and feature development after launch.',
                ],
                [
                    'question' => 'Can you redesign my existing website?',
                    'answer' => 'Yes. We can modernize the design, improve the user experience, migrate content, and preserve important SEO value.',
                ],
                [
                    'question' => 'Will my website be mobile-friendly?',
                    'answer' => 'Yes. Every website we build is responsive and tested across modern phones, tablets, and desktop browsers.',
                ],
                [
                    'question' => 'Do you optimize websites for speed and SEO?',
                    'answer' => 'Yes. Technical SEO, semantic markup, image optimization, caching, and performance testing are part of our delivery process.',
                ],
                [
                    'question' => 'How can digital marketing help my business?',
                    'answer' => 'A focused strategy can increase qualified traffic, improve conversions, and create measurable, repeatable customer acquisition.',
                ],
            ],

        ];
    }

    /**
     * @return array<int, array{quote: string, name: string, role: string, initials: string, avatar: string}>
     */
    public static function testimonials(): array
    {
        return [
            [
                'quote' => 'Working with this team was one of the best business decisions we made. They understood our vision and delivered a website that performs exceptionally well.',
                'name' => 'Saurabh Singh Shah',
                'role' => 'Founder, NorthRose Technologies',
                'initials' => 'SS',
                'avatar' => 'assets/team/professional-man-navy-blazer-portrait.png',
                'avatarAlt' => 'Saurabh Singh Shah client testimonial for Suave Creators web development',
            ],
            [
                'quote' => 'The communication was clear from the start, and every milestone arrived with thoughtful solutions. Our new platform is faster, easier to use, and ready to scale.',
                'name' => 'Ananya Mehta',
                'role' => 'Operations Director',
                'initials' => 'AM',
                'avatar' => 'assets/team/professional-woman-product-team-portrait.png',
                'avatarAlt' => 'Ananya Mehta client testimonial for Suave Creators software platform',
            ],
            [
                'quote' => 'They combined strong product thinking with excellent engineering. The result has improved our workflow and given our customers a much smoother experience.',
                'name' => 'Daniel Carter',
                'role' => 'Co-founder, Vertex Labs',
                'initials' => 'DC',
                'avatar' => 'assets/team/professional-designer-portrait.png',
                'avatarAlt' => 'Daniel Carter client testimonial for Suave Creators product engineering',
            ],
            [
                'quote' => 'From discovery to launch, the team felt like an extension of our own company. They challenged assumptions and kept the project focused on real business outcomes.',
                'name' => 'Priya Nair',
                'role' => 'Head of Digital',
                'initials' => 'PN',
                'avatar' => 'assets/team/professional-team-lead-portrait.png',
                'avatarAlt' => 'Priya Nair client testimonial for Suave Creators digital delivery',
            ],
        ];
    }

    /**
     * @return array<int, array{title: string, excerpt: string, image: string, alt: string, date: string, datetime: string, author: string, url: string}>
     */
    public static function articles(): array
    {
        return [
            [
                'title' => 'How to Build a Digital Strategy That Creates Real Business Value',
                'excerpt' => 'A practical framework for connecting customer needs, technology decisions, and measurable growth.',
                'image' => 'assets/blog/digital-strategy-collaboration.png',
                'alt' => 'Team collaborating on a digital strategy plan for business growth',
                'date' => 'Jun 24, 2026',
                'datetime' => '2026-06-24',
                'author' => 'Suave Creators',
                'url' => route('blog.digital-strategy-that-creates-value'),
            ],
            [
                'title' => 'Turning Product Data into Better Customer Experiences',
                'excerpt' => 'Learn how focused analytics can reveal friction, guide priorities, and improve every step of the user journey.',
                'image' => 'assets/blog/product-experience-mapping.png',
                'alt' => 'Designer mapping a digital product experience for better UX',
                'date' => 'Jun 12, 2026',
                'datetime' => '2026-06-12',
                'author' => 'Suave Creators',
                'url' => route('blog.product-data-customer-experiences'),
            ],
            [
                'title' => 'Designing Digital Workflows Your Team Will Actually Use',
                'excerpt' => 'Simple principles for creating connected tools that reduce busywork and make collaboration easier.',
                'image' => 'assets/blog/software-development-laptop-code.png',
                'alt' => 'Laptop with software development code for digital workflow tools',
                'date' => 'May 29, 2026',
                'datetime' => '2026-05-29',
                'author' => 'Suave Creators',
                'url' => route('blog.digital-workflows-teams-use'),
            ],
            [
                'title' => 'Designing Digital Workflows Your Team Will Actually Use',
                'excerpt' => 'Simple principles for creating connected tools that reduce busywork and make collaboration easier.',
                'image' => 'assets/blog/software-development-laptop-code.png',
                'alt' => 'Software engineering laptop screen showing application source code',
                'date' => 'May 29, 2026',
                'datetime' => '2026-05-29',
                'author' => 'Suave Creators',
                'url' => route('blog.digital-workflows-teams-use'),
            ],
        ];
    }
}
