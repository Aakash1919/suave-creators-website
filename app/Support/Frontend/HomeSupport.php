<?php

namespace App\Support\Frontend;

use App\Services\TestimonialService;

class HomeSupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return array_merge(self::faqData(), [
            'heroShellClass' => 'bg-[#00003f]',
            'heroBackgroundImage' => 'assets/background/home-hero-cover-bg.png',
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
     * @return array<int, array{end: int, suffix: string, label: string, description: string, icon: string, accent: string, tint: string, alt: string}>
     */
    public static function stats(): array
    {
        return [
            [
                'end' => 50,
                'suffix' => '+',
                'label' => 'Projects Delivered',
                'description' => 'Successfully delivered websites, software, CRMs, mobile apps, and digital solutions.',
                'icon' => 'assets/icons/brands-growth-rocket-icon.svg',
                'accent' => '#4C24F4',
                'tint' => '#F0EAFF',
                'alt' => 'Successfully delivered websites, software, CRMs, mobile apps, and digital solutions.',
            ],
            [
                'end' => 10,
                'suffix' => '+',
                'label' => 'Years of Experience',
                'description' => 'Building scalable digital products with modern technologies.',
                'icon' => 'assets/icons/years-experience-icon.svg',
                'accent' => '#1873E7',
                'tint' => '#EAF5FC',
                'alt' => 'Building scalable digital products with modern technologies.',
            ],
            [
                'end' => 98,
                'suffix' => '%',
                'label' => 'Client Satisfaction',
                'description' => 'Focused on quality, transparency, and long-term partnerships.',
                'icon' => 'assets/icons/funding-secured-icon.svg',
                'accent' => '#0C7A73',
                'tint' => '#E8F8F6',
                'alt' => 'Focused on quality, transparency, and long-term partnerships.',
            ],
            [
                'end' => 15,
                'suffix' => '+',
                'label' => 'Expert Team',
                'description' => '15+ passionate developers and management specialists ready to build with you.',
                'icon' => 'assets/team/expert-team-icon.svg',
                'accent' => '#C4520D',
                'tint' => '#FFF0E7',
                'alt' => '15+ passionate developers and management specialists ready to build with you.',
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
                'image' => 'assets/media/summary-report-team-meeting.webp',
                'alt' => 'Product strategy experts planning intelligent software solutions',
            ],
            [
                'title' => 'Design that Defines Your Brand',
                'description' => 'We merge creative design, intuitive UX/UI, and brand storytelling.',
                'image' => 'assets/media/big-project-sticky-notes-planning.webp',
                'alt' => 'UI UX designers planning a brand experience for digital products',
            ],
            [
                'title' => 'Smart Development, Seamless Performance',
                'description' => 'Our team crafts high-performance, scalable applications.',
                'image' => 'assets/media/developers-collaborating-code-review.webp',
                'alt' => 'Software engineers building scalable web applications',
            ],
            [
                'title' => 'Marketing that Fuels Growth',
                'description' => 'We help your app grow, retain, and dominate its market space.',
                'image' => 'assets/media/marketing-analytics-team-presentation.webp',
                'alt' => 'Digital marketing experts presenting app growth analytics',
            ],
            [
                'title' => 'Continuous Support & Innovation',
                'description' => 'We keep your product reliable, relevant, and ready to evolve with ongoing support and smart improvements.',
                'image' => 'assets/media/summary-report-team-meeting.webp',
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
                'image' => 'assets/media/conference-table-analytics-whiteboard.webp',
                'alt' => 'Innovation-focused software team reviewing analytics on a conference table',
            ],
            [
                'id' => 'quality',
                'title' => 'Quality',
                'description' => 'Delivering the best quality, ensuring our clients get nothing less than the best.',
                'image' => 'assets/media/financial-dashboard-laptop-collaboration.webp',
                'alt' => 'Quality-driven financial dashboard collaboration for software excellence',
            ],
            [
                'id' => 'trust',
                'title' => 'Trust',
                'description' => 'We build trust by focusing on the exact client requirements.',
                'image' => 'assets/media/diverse-team-data-meeting.webp',
                'alt' => 'Trusted diverse team aligning on client requirements with data insights',
            ],
            [
                'id' => 'customer',
                'title' => 'Customer Focus',
                'description' => 'We put our clients at the heart of everything we build.',
                'image' => 'assets/media/summary-report-team-meeting.webp',
                'alt' => 'Customer focused team reviewing a summary report in a client meeting',
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
                'image' => 'assets/media/seo-infographic-on-imac.webp',
                'alt' => 'SEO analytics dashboard for search engine optimization services',
                'iconAlt' => 'Search engine optimization SEO service icon',
            ],
            [
                'icon' => 'assets/icons/ppc-advertising-icon.svg',
                'title' => 'Pay-Per-Click Advertising',
                'headline' => 'Instant Reach, Tangible Results',
                'description' => 'Reach high-intent audiences quickly with focused campaigns that maximise conversions and measurable ROI.',
                'image' => 'assets/media/ppc-campaign-planning.webp',
                'alt' => 'PPC advertising campaign planning for higher conversions',
                'iconAlt' => 'Pay per click advertising PPC service icon',
            ],
            [
                'icon' => 'assets/icons/social-media-marketing-icon.svg',
                'title' => 'Social Media Marketing',
                'headline' => 'Engage & Grow Your Community',
                'description' => 'Build meaningful connections with relevant content that inspires engagement, loyalty, and lasting growth.',
                'image' => 'assets/media/social-media-marketing-mobile.webp',
                'alt' => 'Social media marketing content strategy on a mobile device',
                'iconAlt' => 'Social media marketing service icon',
            ],
            [
                'icon' => 'assets/icons/content-strategy-icon.svg',
                'title' => 'Content Strategy & Planning',
                'headline' => 'Plan. Create. Convert.',
                'description' => 'Turn ideas into purposeful content that strengthens your brand and guides customers to act.',
                'image' => 'assets/media/content-strategy-team-planning.webp',
                'alt' => 'Content strategy team planning digital marketing campaigns',
                'iconAlt' => 'Content strategy and planning service icon',
            ],
            [
                'icon' => 'assets/icons/online-reputation-icon.svg',
                'title' => 'Online Reputation Management',
                'headline' => 'Protect Trust. Build Credibility.',
                'description' => 'Monitor brand conversations and strengthen the online reputation that shapes customer confidence.',
                'image' => 'assets/media/online-reputation-admin-dashboard.webp',
                'alt' => 'Online reputation management review of brand sentiment analytics',
                'iconAlt' => 'Online reputation management service icon',
            ],
            [
                'icon' => 'assets/icons/answer-engine-optimization-icon.svg',
                'title' => 'Answer Engine Optimization',
                'headline' => 'Be the Answer Customers Find',
                'description' => 'Structure authoritative content so voice assistants and answer engines can surface your expertise.',
                'image' => 'assets/media/answer-engine-inspiration-mindmap.webp',
                'alt' => 'Answer engine optimization content planning for AI search',
                'iconAlt' => 'Answer engine optimization AEO service icon',
            ],
            [
                'icon' => 'assets/icons/generative-engine-optimization-icon.svg',
                'title' => 'Generative Engine Optimization',
                'headline' => 'Stay Visible in AI Search',
                'description' => 'Position your brand for discovery across generative platforms with trusted content and clear signals.',
                'image' => 'assets/media/generative-engine-dev-team-coding.webp',
                'alt' => 'Generative engine optimization for brand visibility in AI search',
                'iconAlt' => 'Generative engine optimization GEO service icon',
            ],
        ];
    }

    /**
     * @return array<int, array{category: string, title: string, description: string, image: string, alt: string}>
     */
    public static function portfolioShowcaseProjects(): array
    {
        return [
            [
                'category' => 'CRM Development',
                'title' => 'Suave Outreach CRM Platform',
                'description' => 'An AI-assisted outreach CRM for discovering leads, enriching business context, and sending personalized emails.',
                'image' => 'assets/portfolio/suave-outreach-crm-laptop.webp',
                'alt' => 'Suave Creators outreach CRM platform on a laptop display',
                'url' => route('product'),
                'external' => false,
            ],
            [
                'category' => 'Custom Software',
                'title' => 'Sales Automation Project Dashboard',
                'description' => 'A project workspace for tracking sales automation rollouts, task priorities, and team progress in one place.',
                'image' => 'assets/portfolio/sales-automation-project-dashboard.webp',
                'alt' => 'Sales automation project dashboard software by Suave Creators',
                'url' => CaseStudySupport::urlForSlug('suave-crm-tasks-case-study'),
                'external' => false,
            ],
            [
                'category' => 'Web Development',
                'title' => 'MAVAN Growth Agency Website',
                'description' => 'A conversion-focused site for a growth agency that embeds elite talent to solve complex scaling problems.',
                'image' => 'assets/portfolio/mavan-growth-agency-website.webp',
                'alt' => 'MAVAN growth agency website built by Suave Creators',
                'url' => 'https://www.mavan.com/',
                'external' => true,
            ],
            [
                'category' => 'Web Design',
                'title' => 'HubOps Software Company Website',
                'description' => 'A high-impact marketing site for a custom software company focused on SaaS, APIs, and industry solutions.',
                'image' => 'assets/portfolio/hubops-software-company-website.webp',
                'alt' => 'HubOps custom software company website by Suave Creators',
                'url' => 'https://thehubops.com/',
                'external' => true,
            ],
            [
                'category' => 'Web Design',
                'title' => 'Swastik Culture Hub Website',
                'description' => 'A digital hub for Indian history, art, and culture with curated libraries and original series.',
                'image' => 'assets/portfolio/swastik-culture-hub-website.webp',
                'alt' => 'Swastik culture hub website for history art and culture content',
                'url' => 'https://swastikstories.com/',
                'external' => true,
            ],
            [
                'category' => 'AI Product',
                'title' => 'Ematrics AI Sales Website',
                'description' => 'A product site for an AI sales catalyst that trains reps, assists live calls, and delivers post-call analytics.',
                'image' => 'assets/portfolio/ematrics-ai-sales-website.webp',
                'alt' => 'Ematrics AI sales catalyst website built by Suave Creators',
                'url' => 'https://www.ematrics.com/',
                'external' => true,
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
            'faqCtaHref' => ContactSupport::demoHref(),
            'faqCtaLabel' => 'Get Free Consultation',
            'faqMedia' => 'assets/media/diverse-team-data-meeting.webp',
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
     * @return list<array{quote: string, name: string, role: string, initials: string, avatar: string, avatarAlt: string}>
     */
    public static function testimonials(): array
    {
        return app(TestimonialService::class)->cachedForFrontend();
    }

    /**
     * @return array<int, array{title: string, excerpt: string, image: string, alt: string, date: string, datetime: string, author: string, url: string}>
     */
    public static function articles(): array
    {
        return BlogSupport::articleCards(4);
    }
}
