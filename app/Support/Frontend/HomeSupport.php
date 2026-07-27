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
            'stats' => self::stats(),
            'offerings' => self::offerings(),
            'coreValues' => self::coreValues(),
            'digitalMarketingServices' => self::digitalMarketingServices(),
            'portfolioShowcaseProjects' => self::portfolioShowcaseProjects(),
            'testimonials' => self::testimonials(),
            'articles' => self::articles(),
            'servicesMarqueeItems' => self::servicesMarqueeItems(),
            'partnerMarqueeItems' => self::partnerMarqueeItems(),
        ]);
    }

    /**
     * @return array<int, array{value: string, label: string, description: string, icon: string, accent: string, tint: string, alt: string}>
     */
    public static function stats(): array
    {
        return [
            [
                'value' => '50+',
                'label' => 'Brands trust us for AI',
                'description' => 'Successfully completed more than 50+ projects.',
                'icon' => 'assets/icons/brands-growth-rocket-icon.svg',
                'accent' => '#4C24F4',
                'tint' => '#F0EAFF',
                'alt' => 'AI software growth icon for brands trusting Suave Creators',
            ],
            [
                'value' => '10+',
                'label' => 'Years of Experience',
                'description' => 'Years of Combined Experience.',
                'icon' => 'assets/icons/years-experience-icon.svg',
                'accent' => '#1873E7',
                'tint' => '#EAF5FC',
                'alt' => 'Years of experience icon for Suave Creators development team',
            ],
            [
                'value' => '$40M+',
                'label' => 'Funding Secured',
                'description' => 'Our creative work has helped clients secure more than $40M+ in funding.',
                'icon' => 'assets/icons/funding-secured-icon.svg',
                'accent' => '#0F968E',
                'tint' => '#E8F8F6',
                'alt' => 'Funding secured icon for startups built with Suave Creators',
            ],
            [
                'value' => '15+',
                'label' => 'Expert Team',
                'description' => '15+ Passionate Developers and Management Teams.',
                'icon' => 'assets/team/expert-team-icon.svg',
                'accent' => '#FA6811',
                'tint' => '#FFF0E7',
                'alt' => 'Expert software development team icon at Suave Creators',
            ],
        ];
    }

    /**
     * @return array<int, array{title: string, description: string, image: string, alt: string}>
     */
    public static function offerings(): array
    {
        return [
            [
                'title' => 'Product Strategy with Intelligence Inside',
                'description' => 'Our team helps define your vision, validate your idea.',
                'image' => 'assets/team/expert-portrait-1.png',
                'alt' => 'Product strategy experts planning intelligent software solutions',
            ],
            [
                'title' => 'Design that Defines Your Brand',
                'description' => 'We merge creative design, intuitive UX/UI, and brand storytelling.',
                'image' => 'assets/team/expert-portrait-2.png',
                'alt' => 'UI UX designer planning a brand experience for digital products',
            ],
            [
                'title' => 'Smart Development, Seamless Performance',
                'description' => 'Our team crafts high-performance, scalable applications.',
                'image' => 'assets/team/expert-portrait-3.png',
                'alt' => 'Software engineers building scalable web applications',
            ],
            [
                'title' => 'Marketing that Fuels Growth',
                'description' => 'We help your app grow, retain, and dominate its market space.',
                'image' => 'assets/team/expert-portrait-4.png',
                'alt' => 'Digital marketing experts presenting app growth analytics',
            ],
            [
                'title' => 'Continuous Support & Innovation',
                'description' => 'We keep your product reliable, relevant, and ready to evolve with ongoing support and smart improvements.',
                'image' => 'assets/team/expert-portrait-1.png',
                'alt' => 'Product support team planning continuous software innovation',
            ],
        ];
    }

    /**
     * @return array<int, array{id: string, title: string, description: string, image: string, alt: string}>
     */
    public static function coreValues(): array
    {
        return [
            [
                'id' => 'innovation',
                'title' => 'Innovation',
                'description' => 'We work with future trends and the latest technologies.',
                'image' => 'assets/portfolio/modern-office-yellow-accent-lounge.png',
                'alt' => 'Modern workspace reflecting innovative software development culture',
            ],
            [
                'id' => 'quality',
                'title' => 'Quality',
                'description' => 'Delivering the best quality, ensuring our clients get nothing less than the best.',
                'image' => 'assets/portfolio/contemporary-living-room-kitchen.png',
                'alt' => 'Contemporary interior design showcasing quality digital craftsmanship',
            ],
            [
                'id' => 'trust',
                'title' => 'Trust',
                'description' => 'We build trust by focusing on the exact client requirements.',
                'image' => 'assets/portfolio/warm-lounge-plants-artwork.png',
                'alt' => 'Warm collaborative lounge built for trusted client partnerships',
            ],
            [
                'id' => 'customer',
                'title' => 'Customer Focus',
                'description' => 'We put our clients at the heart of everything we build.',
                'image' => 'assets/portfolio/office-glass-meeting-rooms.png',
                'alt' => 'Glass meeting rooms for customer focused software consulting',
            ],
        ];
    }

    /**
     * @return array<int, array{icon: string, title: string, headline: string, description: string, image: string, alt: string, iconAlt: string}>
     */
    public static function digitalMarketingServices(): array
    {
        return [
            [
                'icon' => 'assets/icons/seo-icon.svg',
                'title' => 'Search Engine Optimization',
                'headline' => 'Boost Your Organic Visibility',
                'description' => 'With our expertise, we enhance the online visibility of your professional website.',
                'image' => 'assets/media/seo-infographic-on-imac.png',
                'alt' => 'SEO analytics dashboard for search engine optimization services',
                'iconAlt' => 'Search engine optimization SEO service icon',
            ],
            [
                'icon' => 'assets/icons/ppc-advertising-icon.svg',
                'title' => 'Pay-Per-Click Advertising',
                'headline' => 'Instant Reach, Tangible Results',
                'description' => 'Reach high-intent audiences quickly with focused campaigns that maximise conversions and measurable ROI.',
                'image' => 'assets/media/ppc-campaign-planning.png',
                'alt' => 'PPC advertising campaign planning for higher conversions',
                'iconAlt' => 'Pay per click advertising PPC service icon',
            ],
            [
                'icon' => 'assets/icons/social-media-marketing-icon.svg',
                'title' => 'Social Media Marketing',
                'headline' => 'Engage & Grow Your Community',
                'description' => 'Build meaningful connections with relevant content that inspires engagement, loyalty, and lasting growth.',
                'image' => 'assets/media/social-media-marketing-mobile.png',
                'alt' => 'Social media marketing content strategy on a mobile device',
                'iconAlt' => 'Social media marketing service icon',
            ],
            [
                'icon' => 'assets/icons/content-strategy-icon.svg',
                'title' => 'Content Strategy & Planning',
                'headline' => 'Plan. Create. Convert.',
                'description' => 'Turn ideas into purposeful content that strengthens your brand and guides customers to act.',
                'image' => 'assets/media/content-strategy-team-planning.png',
                'alt' => 'Content strategy team planning digital marketing campaigns',
                'iconAlt' => 'Content strategy and planning service icon',
            ],
            [
                'icon' => 'assets/icons/online-reputation-icon.svg',
                'title' => 'Online Reputation Management',
                'headline' => 'Protect Trust. Build Credibility.',
                'description' => 'Monitor brand conversations and strengthen the online reputation that shapes customer confidence.',
                'image' => 'assets/media/seo-infographic-on-imac.png',
                'alt' => 'Online reputation management review of brand sentiment analytics',
                'iconAlt' => 'Online reputation management service icon',
            ],
            [
                'icon' => 'assets/icons/answer-engine-optimization-icon.svg',
                'title' => 'Answer Engine Optimization',
                'headline' => 'Be the Answer Customers Find',
                'description' => 'Structure authoritative content so voice assistants and answer engines can surface your expertise.',
                'image' => 'assets/media/ppc-campaign-planning.png',
                'alt' => 'Answer engine optimization content planning for AI search',
                'iconAlt' => 'Answer engine optimization AEO service icon',
            ],
            [
                'icon' => 'assets/icons/generative-engine-optimization-icon.svg',
                'title' => 'Generative Engine Optimization',
                'headline' => 'Stay Visible in AI Search',
                'description' => 'Position your brand for discovery across generative platforms with trusted content and clear signals.',
                'image' => 'assets/media/social-media-marketing-mobile.png',
                'alt' => 'Generative engine optimization for brand visibility in AI search',
                'iconAlt' => 'Generative engine optimization GEO service icon',
            ],
        ];
    }

    /**
     * @return array<int, array{image: string, alt: string}>
     */
    public static function portfolioShowcaseProjects(): array
    {
        return [
            [
                'image' => 'assets/portfolio/timber-glass-creative-studio.png',
                'alt' => 'Modern timber and glass creative studio for digital product teams',
            ],
            [
                'image' => 'assets/portfolio/bright-contemporary-residence.png',
                'alt' => 'Bright contemporary space reflecting premium digital design quality',
            ],
            [
                'image' => 'assets/portfolio/warm-modern-lounge-interior.png',
                'alt' => 'Warm modern lounge for collaborative software product workshops',
            ],
            [
                'image' => 'assets/portfolio/timber-glass-creative-studio.png',
                'alt' => 'Creative studio exterior showcasing Suave Creators portfolio quality',
            ],
        ];
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
        return BlogSupport::articleCards(4);
    }
}
