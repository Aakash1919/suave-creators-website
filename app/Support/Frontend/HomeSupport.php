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
            // LCP poster for home hero mosaic preload in layouts/frontend.blade.php
            'heroCaseStudies' => CaseStudySupport::heroVisualScenes(4),
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
                'label' => ' Production Platforms Delivered',
                'description' => 'Scalable enterprise web applications, proprietary CRMs, and high-volume commerce platforms.',
                'icon' => 'assets/icons/brands-growth-rocket-icon.svg',
                'accent' => '#4C24F4',
                'tint' => '#F0EAFF',
                'alt' => 'Scalable enterprise web applications, proprietary CRMs, and high-volume commerce platforms.',
            ],
            [
                'end' => 10,
                'suffix' => '+',
                'label' => 'Years of Technical Experience',
                'description' => 'Senior solution architects and full-stack engineers building modern web systems.',
                'icon' => 'assets/icons/years-experience-icon.svg',
                'accent' => '#1873E7',
                'tint' => '#EAF5FC',
                'alt' => 'Senior solution architects and full-stack engineers building modern web systems.',
            ],
            [
                'end' => 98,
                'suffix' => '%',
                'label' => ' Client Satisfaction Rate',
                'description' => 'Long-term engineering partnerships driven by transparent communication and dedicated SLAs.',
                'icon' => 'assets/icons/funding-secured-icon.svg',
                'accent' => '#0C7A73',
                'tint' => '#E8F8F6',
                'alt' => 'Long-term engineering partnerships driven by transparent communication and dedicated SLAs.',
            ],
            [
                'end' => 15,
                'suffix' => '+',
                'label' => 'Senior Engineers & Specialists',
                'description' => 'Full-time in-house developers specializing in Laravel, React, Angular, Node.js, and cloud infrastructure.',
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
                'title' => 'Strategy with Built-in Intelligence',
                'description' => 'We validate market assumptions, map technical constraints, and define data models before writing production code.',
                'image' => 'assets/media/summary-report-team-meeting.webp',
                'alt' => 'Product strategy experts planning intelligent software solutions',
            ],
            [
                'title' => 'Interfaces That Drive Adoption',
                'description' => ' Intuitive, accessible Figma design systems that turn complex enterprise workflows into frictionless user experiences.',
                'image' => 'assets/media/big-project-sticky-notes-planning.webp',
                'alt' => 'UI UX designers planning a brand experience for digital products',
            ],
            [
                'title' => 'Clean Code, Seamless Scalability',
                'description' => 'Modern microservices and scalable monolithic web applications built with Laravel, React, Angular, and Node.js.',
                'image' => 'assets/media/developers-collaborating-code-review.webp',
                'alt' => 'Software engineers building scalable web applications',
            ],
            [
                'title' => ' Visibility That Drives Pipeline',
                'description' => 'Optimizing technical foundations and content architecture for Google AI Overviews, Featured Snippets, and LLM search engines.',
                'image' => 'assets/media/marketing-analytics-team-presentation.webp',
                'alt' => 'Digital marketing experts presenting app growth analytics',
            ],
            [
                'title' => 'Continuous Reliability & Iteration',
                'description' => 'Automated testing pipelines, 24/7 uptime monitoring, security patching, and agile feature expansion post-launch.',
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
                'description' => 'We adopt modern development frameworks, containerized environments, and emerging AI tools to keep your software ahead of competitors.',
                'image' => 'assets/media/conference-table-analytics-whiteboard.webp',
                'alt' => 'Innovation-focused software team reviewing analytics on a conference table',
            ],
            [
                'id' => 'quality',
                'title' => 'Code Quality',
                'description' => 'Strict coding standards, peer code reviews, and automated CI/CD testing ensure production reliability on day one.',
                'image' => 'assets/media/financial-dashboard-laptop-collaboration.webp',
                'alt' => 'Quality-driven financial dashboard collaboration for software excellence',
            ],
            [
                'id' => 'trust',
                'title' => 'Mutual Trust',
                'description' => 'Transparent sprint tracking, direct developer communication, and complete client ownership of code repositories and IP.',
                'image' => 'assets/media/diverse-team-data-meeting.webp',
                'alt' => 'Trusted diverse team aligning on client requirements with data insights',
            ],
            [
                'id' => 'customer',
                'title' => 'Client Focus',
                'description' => 'We evaluate every feature by its ability to solve operational bottlenecks and maximize return on investment.',
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
                'title' => 'Search Engine Optimization (SEO)',
                'headline' => ' High-Intent Organic Discovery',
                'description' => ' Technical crawlability audits, Core Web Vitals optimization, and topical cluster authority that convert searches into clients.',
                'image' => 'assets/media/seo-infographic-on-imac.webp', 
                'alt' => 'SEO analytics dashboard for search engine optimization services',
                'iconAlt' => 'Search engine optimization SEO service icon',
            ],
            [
                'icon' => 'assets/icons/ppc-advertising-icon.svg',
                'title' => 'Pay-Per-Click Advertising (PPC)',
                'headline' => 'Precision Paid Acquisition',
                'description' => 'Laser-focused Google and LinkedIn campaigns capturing high-intent enterprise searches with optimized conversion landing pages.',
                'image' => 'assets/media/ppc-campaign-planning.webp',
                'alt' => 'PPC advertising campaign planning for higher conversions',
                'iconAlt' => 'Pay per click advertising PPC service icon',
            ],
            [
                'icon' => 'assets/icons/social-media-marketing-icon.svg',
                'title' => 'Social Media & Brand Positioning',
                'headline' => 'Authority & Brand Trust',
                'description' => 'Establishing technical thought leadership across LinkedIn and industry channels to drive brand recognition and client trust.',
                'image' => 'assets/media/social-media-marketing-mobile.webp',
                'alt' => 'Social media marketing content strategy on a mobile device',
                'iconAlt' => 'Social media marketing service icon',
            ],
            [
                'icon' => 'assets/icons/content-strategy-icon.svg',
                'title' => ' Technical Content Strategy',
                'headline' => 'Topical Cluster Architecture',
                'description' => 'Deeply technical whitepapers, architecture tear-downs, and TCO breakdowns that build undeniable authority for B2B decision-makers.',
                'image' => 'assets/media/content-strategy-team-planning.webp',
                'alt' => 'Content strategy team planning digital marketing campaigns',
                'iconAlt' => 'Content strategy and planning service icon',
            ],
            [
                'icon' => 'assets/icons/online-reputation-icon.svg',
                'title' => 'Online Reputation Management (ORM)',
                'headline' => 'Trust & Entity Protection',
                'description' => 'Monitoring and cultivating authentic third-party review profiles across G2, Clutch, and Google Business to reinforce domain credibility.',
                'image' => 'assets/media/online-reputation-admin-dashboard.webp',
                'alt' => 'Online reputation management review of brand sentiment analytics',
                'iconAlt' => 'Online reputation management service icon',
            ],
            [
                'icon' => 'assets/icons/answer-engine-optimization-icon.svg',
                'title' => 'Answer Engine Optimization (AEO)',
                'headline' => ' Featured Snippets & Direct Answers',
                'description' => 'Structuring pages with concise answers, clear definitions, and FAQ schema to dominate Google Featured Snippets and PAA boxes.',
                'image' => 'assets/media/answer-engine-inspiration-mindmap.webp',
                'alt' => 'Answer engine optimization content planning for AI search',
                'iconAlt' => 'Answer engine optimization AEO service icon',
            ],
            [
                'icon' => 'assets/icons/generative-engine-optimization-icon.svg',
                'title' => 'Generative Engine Optimization (GEO)',
                'headline' => 'AI Search Citations (ChatGPT / Perplexity)',
                'description' => 'Positioning your brand as a primary source for conversational AI engines using structured entity data, first-party proof, and llms.txt.',
                'image' => 'assets/media/generative-engine-dev-team-coding.webp',
                'alt' => 'Generative engine optimization for brand visibility in AI search',
                'iconAlt' => 'Generative engine optimization GEO service icon',
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
                'category' => 'CRM & AI Sales Automation',
                'title' => 'Multichannel B2B Outreach & Lead Scoring Engine',
                'description' => 'An automated sales platform that reduced lead prospecting time by 65% while integrating two-way email tracking and AI lead qualification.',
                'image' => 'assets/portfolio/suave-outreach-crm-laptop.webp',
                'alt' => 'Suave Creators outreach CRM platform on a laptop display',
                'url' => CaseStudySupport::urlForSlug('suave-crm-outreach-case-study'),
                'external' => false,
            ],
            [
                'category' => 'Enterprise Logistics Platform',
                'title' => 'Fleet Telematics & Dispatch Coordination Portal',
                'description' => 'Architected a real-time freight management system yielding 42% more qualified dispatch leads and 3.4x faster response times.',
                'image' => 'assets/case-studies/turbo-trans/ttc_caseStudy.webp',
                'alt' => 'Turbo Trans fleet telematics and dispatch portal by Suave Creators',
                'url' => CaseStudySupport::urlForSlug('turbo-trans-corporation-case-study'),
                'external' => false,
            ],
            [
                'category' => 'Procurement & Applied AI',
                'title' => 'Automated Catalog Matching for High-SKU Inventories',
                'description' => 'Engineered a visual and textual AI matching pipeline that reduced catalog look-alike research time by 70% with 99.2% accuracy.',
                'image' => 'assets/case-studies/ai-product-matching/ai-product-matching-logo.webp',
                'alt' => 'Automated AI catalog matching engine by Suave Creators',
                'url' => CaseStudySupport::urlForSlug('AI-product-matching'),
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
            ['label' => 'CUSTOM WEB DEVELOPMENT', 'style' => 'outlined', 'separator' => 'filled'],
            ['label' => 'ENTERPRISE CRM PLATFORMS', 'style' => 'filled', 'separator' => 'outlined'],
            ['label' => 'APPLIED AI SOLUTIONS', 'style' => 'outlined', 'separator' => 'filled'],
            ['label' => 'ANSWER ENGINE OPTIMIZATION (AEO) ', 'style' => 'filled', 'separator' => 'outlined'],
            ['label' => 'SCALABLE SAAS ARCHITECTURE ', 'style' => 'outlined', 'separator' => 'filled'],
            ['label' => ' CLOUD DEVOPS', 'style' => 'filled', 'separator' => 'outlined'],
            ['label' => 'GENERATIVE ENGINE OPTIMIZATION (GEO)', 'style' => 'outlined', 'separator' => 'filled'],
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
            'faqCtaHref' => ContactSupport::demoHref(),
            'faqCtaLabel' => 'Get Free Architecture Consultation ',
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

    /**
     * @return array<int, array{title: string, excerpt: string, image: string, alt: string, date: string, datetime: string, author: string, url: string}>
     */
    public static function articles(): array
    {
        return BlogSupport::articleCards(4);
    }
}
