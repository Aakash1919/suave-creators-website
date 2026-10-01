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
            'heroBackgroundImage' => 'assets/background/home-hero-cover-bg.webp',
            // LCP poster for home hero mosaic preload in layouts/frontend.blade.php
            'heroCaseStudies' => CaseStudySupport::heroVisualScenes(4),
            'stats' => self::stats(),
            'offerings' => self::offerings(),
            'coreValues' => self::coreValues(),
            'digitalMarketingServices' => self::digitalMarketingServices(),
            'portfolioShowcaseProjects' => self::portfolioShowcaseProjects(),
            'testimonials' => self::testimonials(),
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
                'label' => 'production platforms delivered since 2021',
                'description' => 'Live CRM, ERP and web platforms shipped for client teams.',
                'icon' => 'assets/icons/brands-growth-rocket-icon.svg',
                'accent' => '#4C24F4',
                'tint' => '#F0EAFF',
                'alt' => 'Scalable enterprise web applications, proprietary CRMs, and high-volume commerce platforms.',
            ],
            [
                'end' => 10,
                'suffix' => '+',
                'label' => 'years average engineer experience',
                'description' => 'Average experience of our senior engineers, not the age of the company.',
                'icon' => 'assets/icons/years-experience-icon.svg',
                'accent' => '#1873E7',
                'tint' => '#EAF5FC',
                'alt' => 'Senior solution architects and full-stack engineers building modern web systems.',
            ],
            [
                'end' => 98,
                'suffix' => '%',
                'label' => 'client retention rate',
                'description' => 'Clients who returned for a second project.',
                'icon' => 'assets/icons/funding-secured-icon.svg',
                'accent' => '#0C7A73',
                'tint' => '#E8F8F6',
                'alt' => 'Long-term engineering partnerships driven by transparent communication and dedicated SLAs.',
            ],
            [
                'end' => 15,
                'suffix' => '+',
                'label' => 'in-house engineers',
                'description' => 'Laravel, React, Node.js and AWS, all full-time Suave Creators employees.',
                'icon' => 'assets/team/expert-team-icon.svg',
                'accent' => '#C4520D',
                'tint' => '#FFF0E7',
                'alt' => 'Full-time in-house developers specializing in Laravel, React, Angular, Node.js, and cloud infrastructure.
',
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
                'title' => '1. Paid discovery and scoping (1–2 weeks)',
                'description' => 'We map your workflows, data and integrations, then deliver a fixed scope, timeline and cost.',
                'image' => 'assets/media/summary-report-team-meeting.webp',
                'alt' => 'Solution architect mapping a client workflow on a whiteboard',
            ],
            [
                'title' => '2. UX and data model design (1–2 weeks)',
                'description' => 'Clickable Figma prototypes and a database design you approve before any code.',
                'image' => 'assets/media/big-project-sticky-notes-planning.webp',
                'alt' => 'Designer reviewing a Figma prototype for a CRM dashboard',
            ],
            [
                'title' => '3. Build in 2-week sprints',
                'description' => 'A working demo every sprint, with direct access to your lead engineer.',
                'image' => 'assets/media/developers-collaborating-code-review.webp',
                'alt' => 'Developers reviewing code during a software sprint',
            ],
            [
                'title' => '4. Data migration and launch',
                'description' => 'We move records from your current tools, train your team and launch in stages.',
                'image' => 'assets/media/marketing-analytics-team-presentation.webp',
                'alt' => 'Team launching a new custom software platform',
            ],
            [
                'title' => '5. Support, SLAs and iteration',
                'description' => 'Monitoring, security patches and new features under a monthly SLA.',
                'image' => 'assets/media/financial-dashboard-laptop-collaboration.webp',
                'alt' => 'Support engineer monitoring system uptime dashboards',
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
                'title' => 'You own everything',
                'description' => 'Source code, repositories, data and IP transfer to you. No lock-in or licence fees.',
                'image' => 'assets/media/conference-table-analytics-whiteboard.webp',
                'alt' => 'Innovation-focused software team reviewing analytics on a conference table',
            ],
            [
                'id' => 'quality',
                'title' => 'Senior engineers, direct access',
                'description' => 'You work with the architect and lead developer, not an account manager, at offshore rates under US contracts.',
                'image' => 'assets/media/financial-dashboard-laptop-collaboration.webp',
                'alt' => 'Quality-driven financial dashboard collaboration for software excellence',
            ],
            [
                'id' => 'trust',
                'title' => 'Predictable delivery',
                'description' => 'Fixed-scope discovery, 2-week sprints and a demo every sprint.',
                'image' => 'assets/media/diverse-team-data-meeting.webp',
                'alt' => 'Trusted diverse team aligning on client requirements with data insights',
            ],
            [
                'id' => 'customer',
                'title' => 'AI built in, not bolted on',
                'description' => 'We add AI where it saves time, using your data securely.',
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
                'title' => 'Laravel and PHP developers',
                'headline' => 'Hire Laravel developers',
                'description' => 'APIs, admin panels and complex business logic.',
                'image' => 'assets/media/developers-collaborating-code-review.webp',
                'alt' => 'Laravel and PHP developers reviewing API code for a custom software project',
                'iconAlt' => 'Laravel PHP developer hiring icon for Suave Creators',
            ],
            [
                'icon' => 'assets/icons/ppc-advertising-icon.svg',
                'title' => 'React and Next.js developers',
                'headline' => 'Hire React developers',
                'description' => 'Fast web front ends and dashboards.',
                'image' => 'assets/media/financial-dashboard-laptop-collaboration.webp',
                'alt' => 'React developers building a web dashboard for a custom software product',
                'iconAlt' => 'React developer hiring icon for Suave Creators',
            ],
            [
                'icon' => 'assets/icons/social-media-marketing-icon.svg',
                'title' => 'Node.js developers',
                'headline' => 'Hire Node.js developers',
                'description' => 'Real-time features, integrations and microservices.',
                'image' => 'assets/media/seo-infographic-on-imac.webp',
                'alt' => 'Node.js developers planning real-time software integrations',
                'iconAlt' => 'Node.js developer hiring icon for Suave Creators',
            ],
            [
                'icon' => 'assets/icons/content-strategy-icon.svg',
                'title' => 'Full-stack developers',
                'headline' => 'Hire full-stack developers',
                'description' => 'One engineer across front end, back end and database.',
                'image' => 'assets/media/content-strategy-team-planning.webp',
                'alt' => 'Full-stack developers planning a custom software build',
                'iconAlt' => 'Full-stack developer hiring icon for Suave Creators',
            ],
            [
                'icon' => 'assets/icons/online-reputation-icon.svg',
                'title' => 'AI and LLM engineers',
                'headline' => 'Hire AI engineers',
                'description' => 'AI agents, RAG search and workflow automation.',
                'image' => 'assets/media/big-project-sticky-notes-planning.webp',
                'alt' => 'AI engineers planning agents and workflow automation',
                'iconAlt' => 'AI engineer hiring icon for Suave Creators',
            ],
            [
                'icon' => 'assets/icons/answer-engine-optimization-icon.svg',
                'title' => 'UI/UX designers',
                'headline' => 'Hire UI/UX designers',
                'description' => 'Research, prototypes and design systems.',
                'image' => 'assets/media/summary-report-team-meeting.webp',
                'alt' => 'UI UX designers reviewing prototypes for a software product',
                'iconAlt' => 'UI UX designer hiring icon for Suave Creators',
            ],
            [
                'icon' => 'assets/icons/generative-engine-optimization-icon.svg',
                'title' => 'QA and DevOps engineers',
                'headline' => 'Hire QA and DevOps engineers',
                'description' => 'Automated testing, CI/CD and AWS.',
                'image' => 'assets/media/diverse-team-data-meeting.webp',
                'alt' => 'QA and DevOps engineers reviewing a software release pipeline',
                'iconAlt' => 'QA and DevOps hiring icon for Suave Creators',
            ],
        ];
    }

    /**
     * @return array<int, array{category: string, title: string, description: string, image: string, alt: string, url: string, external: bool}>
     */
    public static function portfolioShowcaseProjects(): array
    {
        return [
            [
                'category' => 'Custom CRM',
                'title' => 'B2B outreach CRM with AI lead scoring',
                'description' => 'Cut lead prospecting time by 65% with two-way email tracking and AI qualification.',
                'image' => 'assets/portfolio/suave-outreach-crm-laptop.webp',
                'alt' => 'Suave Creators outreach CRM platform on a laptop display',
                'url' => CaseStudySupport::urlForSlug('suave-crm-outreach-case-study'),
                'external' => false,
            ],
            [
                'category' => 'Logistics',
                'title' => 'Fleet telematics and dispatch portal',
                'description' => 'Turbo Trans Corp. 3.4× faster dispatch response and 42% more qualified dispatch leads.',
                'image' => 'assets/case-studies/turbo-trans/ttc_caseStudy.webp',
                'alt' => 'Turbo Trans fleet telematics and dispatch portal by Suave Creators',
                'url' => CaseStudySupport::urlForSlug('turbo-trans-corporation-case-study'),
                'external' => false,
            ],
            [
                'category' => 'AI integration',
                'title' => 'AI catalog matching for high-SKU inventory',
                'description' => '70% less look-alike research time at 99.2% matching accuracy.',
                'image' => 'assets/case-studies/ai-product-matching/ai-product-matching-logo.webp',
                'alt' => 'Automated AI catalog matching engine by Suave Creators',
                'url' => CaseStudySupport::urlForSlug('AI-product-matching'),
                'external' => false,
            ],
            [
                'category' => 'AI sales coach',
                'title' => 'AI sales coach',
                'description' => '55% faster ramp to quota and 60% less manager review time.',
                'image' => 'assets/case-studies/ai-sales-coaching/ai-sales-coach.webp',
                'alt' => 'AI sales coaching platform case study by Suave Creators',
                'url' => CaseStudySupport::urlForSlug('ai-sales-coaching-platform-case-study'),
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
            ['label' => 'Custom Software Development', 'style' => 'outlined', 'separator' => 'filled'],
            ['label' => 'Custom CRM', 'style' => 'filled', 'separator' => 'outlined'],
            ['label' => 'Custom ERP', 'style' => 'outlined', 'separator' => 'filled'],
            ['label' => 'Web Applications', 'style' => 'filled', 'separator' => 'outlined'],
            ['label' => 'AI Integration', 'style' => 'outlined', 'separator' => 'filled'],
            ['label' => 'Dedicated Developers', 'style' => 'filled', 'separator' => 'outlined'],
            ['label' => 'E-commerce Platforms', 'style' => 'outlined', 'separator' => 'filled'],
            ['label' => 'UI/UX Design', 'style' => 'filled', 'separator' => 'outlined'],
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
            ['src' => 'assets/clients/turbo-trans-corporation-logo.png', 'alt' => 'Turbo Trans Corporation logo partner of Suave Creators CRM development'],
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
            'faqCtaHref' => '#contact-modal',
            'faqCtaLabel' => 'Get a Scoped Estimate',
            'faqMedia' => 'assets/media/diverse-team-data-meeting.webp',
            'faqMediaType' => 'image',
            'faqMediaAlt' => 'Business team collaborating on a custom software project with Suave Creators',
            'faqs' => array_values((array) config('seo.site.default_faqs', [])),
        ];
    }

    /**
     * @return list<array{quote: string, name: string, role: string, initials: string, avatar: string, avatarAlt: string}>
     */
    public static function testimonials(): array
    {
        return app(TestimonialService::class)->cachedForFrontend();
    }
}
