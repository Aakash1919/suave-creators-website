<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Block search indexing (staging / non-public hosts)
    |--------------------------------------------------------------------------
    |
    | When true, every page emits robots noindex/nofollow and /robots.txt
    | disallows all crawlers. Set SEO_NOINDEX=true on staging .env.
    | Defaults to true when APP_ENV=staging.
    |
    */

    'noindex' => (bool) env('SEO_NOINDEX', env('APP_ENV') === 'staging'),

    /*
    |--------------------------------------------------------------------------
    | Site-wide SEO defaults
    |--------------------------------------------------------------------------
    |
    | Single source of truth for marketing meta, Open Graph defaults, and
    | Organization contact details used in JSON-LD and the site footer.
    |
    */

    'site' => [
        'name' => 'Suave Creators',
        'tagline' => 'Custom Software, CRM & Web App Development',
        'default_title' => 'Custom Software, CRM & Web App Development | Suave Creators',
        'default_description' => 'Engineer custom software, bespoke CRM systems, and AI-driven web applications. Explore verified engineering case studies, tech stack, and ROI blueprints.',
        'default_keywords' => 'custom software development, bespoke CRM development, enterprise web application, AI solutions, Laravel development, React web apps, SaaS development company',
        'author' => 'Suave Creators',
        'website_description' => 'Enterprise Software Engineering, Custom CRM Architecture & Scalable Web Solutions',
        'default_og_image' => 'assets/brand/og-default.png',
        'default_og_image_width' => 1200,
        'default_og_image_height' => 630,
        'default_og_image_alt' => 'Suave Creators - Custom Software, CRM and Web Development Company',
        'logo' => 'assets/brand/logo.png',
        'logo_caption' => 'Suave Creators Logo',
        'favicon' => 'assets/brand/favicon-192.png',
        'in_language' => 'en-US',
        'og_locale' => 'en_US',
        'og_locale_alternate' => ['en_IN'],
        'twitter_site' => '@suavecreators',
        'twitter_creator' => '@suavecreators',
        'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
        'google_site_verification' => '8gnHTv-hWNxTIE6HmJwKSMZH5v_ryZuDVQRbAinOpAQ',
        'google_analytics_id' => 'G-5HX7B8X9QP',
        'google_tag_manager_id' => 'GTM-THXXRSV6',
        // One English site: only en + x-default. Extra locales pointing at the
        // same URL (en-in, en-us, en-gb) are invalid hreflang.
        'hreflang' => [
            'en',
            'x-default',
        ],
        'organization' => [
            'legal_name' => 'Suave Creators',
            'email' => 'info@suavecreators.com',
            'telephone' => '+1 (307) 435-9605',
            'telephone_href' => 'tel:+13074359605',
            'telephone_schema' => '+1-307-435-9605',
            'area_served' => 'Worldwide',
            'available_language' => ['en', 'en-IN', 'en-US'],
            'address_display' => '30 N Gould St, STE R, Sheridan, WY 82801, USA',
            'address_secondary_display' => '3M Plaza, Second Floor, Maranda, Kasoti, Palampur, HP 176102, India',
            'offices' => [
                [
                    'label' => 'United States Headquarters',
                    'display' => '30 N Gould St, STE R, Sheridan, WY 82801, USA',
                    'lines' => [
                        '30 N Gould St, STE R,',
                        'Sheridan, WY 82801, USA',
                    ],
                    'phone' => '+1 (307) 435-9605',
                    'phone_href' => 'tel:+13074359605',
                    'phone_schema' => '+1-307-435-9605',
                    'email' => 'info@suavecreators.com',
                    'country' => 'US',
                    'contact_type' => 'sales',
                    'area_served' => ['US', 'Worldwide'],
                    'available_language' => ['en', 'en-US'],
                ],
                [
                    'label' => 'India Engineering Center',
                    'display' => '3M Plaza, Second Floor, Maranda, Kasoti, Palampur, HP 176102, India',
                    'lines' => [
                        '3M Plaza, Second Floor,',
                        'Maranda, Kasoti, Palampur,',
                        'HP 176102, India',
                    ],
                    'phone' => '+91 88949 00142',
                    'phone_href' => 'tel:+918894900142',
                    'phone_schema' => '+91-88949-00142',
                    'email' => 'info@suavecreators.com',
                    'country' => 'IN',
                    'contact_type' => 'customer service',
                    'area_served' => ['IN', 'Worldwide'],
                    'available_language' => ['en', 'en-IN'],
                ],
            ],
            'address' => [
                'streetAddress' => '30 N Gould St, STE R',
                'addressLocality' => 'Sheridan',
                'addressRegion' => 'WY',
                'postalCode' => '82801',
                'addressCountry' => 'US',
            ],
            'address_secondary' => [
                'streetAddress' => '3M Plaza, Second Floor, Maranda, Kasoti',
                'addressLocality' => 'Palampur',
                'addressRegion' => 'Himachal Pradesh',
                'postalCode' => '176102',
                'addressCountry' => 'IN',
            ],
            'sameAs' => [
                'https://www.linkedin.com/company/suave-creators/',
                'https://www.facebook.com/share/1Zt4fotyAa/',
                'https://www.instagram.com/suavecreators',
            ],
            'knowsAbout' => [
                'Custom Software Development',
                'Bespoke CRM Development',
                'Enterprise Software Solutions',
                'Web Application Development',
                'Answer Engine Optimization',
                'Generative Engine Optimization',
                'Applied AI Solutions',
                'Laravel Development',
                'React and Angular Engineering',
                'E-commerce Software Engineering',
            ],
            'aggregateRating' => [
                'ratingValue' => '5.0',
                'reviewCount' => '4',
                'bestRating' => '5',
                'worstRating' => '1',
            ],
        ],
        'default_faqs' => [
            [
                'question' => 'What software engineering and digital growth services does Suave Creators offer?',
                'answer' => 'We specialize in custom web application development, bespoke CRM and ERP system engineering, enterprise software modernization, UI/UX product design, applied AI integrations, and full-funnel search visibility (SEO, AEO, and GEO).',
            ],
            [
                'question' => 'How long does a typical custom software or web application project take to complete?',
                'answer' => 'A production-ready MVP or targeted custom CRM typically takes 8 to 12 weeks from initial architectural discovery to live deployment. Larger enterprise modernization platforms or high-SKU commerce projects typically range between 14 to 20 weeks, executed in two-week agile sprints.',
            ],
            [
                'question' => 'Who owns the intellectual property (IP) and codebase once the project is completed?',
                'answer' => 'You own 100% of the intellectual property, codebase, design assets, and databases. Upon final milestone acceptance, all code repositories, documentation, and cloud environment credentials are fully transferred to your company with zero proprietary vendor lock-in.',
            ],
            [
                'question' => 'Do you provide dedicated post-launch support and ongoing SLA maintenance?',
                'answer' => 'Yes. We provide comprehensive post-deployment SLA maintenance packages covering 24/7 server uptime monitoring, continuous security patching, database optimization, framework updates, and dedicated monthly hours for new feature iterations.',
            ],
            [
                'question' => 'Can Suave Creators audit, refactor, or modernize an existing legacy codebase?',
                'answer' => 'Yes. We regularly conduct code audits on legacy systems (e.g., monolithic PHP, legacy Angular, or outdated Laravel codebases). We identify performance bottlenecks, security vulnerabilities, and architectural flaws, then execute phased refactoring without disrupting ongoing business operations.',
            ],
            [
                'question' => 'Are all web and software applications optimized for mobile devices and Core Web Vitals?',
                'answer' => 'Yes. Every application is built mobile-first, responsive across all screen sizes, and rigorously tested against Google\'s Core Web Vitals metrics - consistently targeting an LCP under 2.5 seconds, CLS under 0.1, and an INP under 200 milliseconds.',
            ],
            [
                'question' => 'How does Suave Creators optimize websites for Answer Engines (AEO) and AI Search (GEO)?',
                'answer' => 'We implement semantic HTML5 hierarchies, valid Schema.org JSON-LD graphs (Organization, Service, FAQPage, TechArticle), answer-first modular text blocks, and llms.txt directories. This ensures your content is eligible for Google AI Overviews, Featured Snippets, and conversational citations across ChatGPT, Perplexity, and Gemini.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Per-route page meta
    |--------------------------------------------------------------------------
    |
    | Keys match named routes in routes/web.php. Dynamic pages (service.show,
    | industry.show, blog.*) override via seoTitle / seoDescription view data.
    | Case study detail routes use the static entries below.
    |
    */

    'pages' => [
        'home' => [
            'title' => 'Custom Software, CRM & Web App Development | Suave Creators',
            'description' => 'Engineer custom software, bespoke CRM systems, and AI-driven web applications. Explore verified engineering case studies, tech stack, and ROI blueprints.',
            'keywords' => 'custom software development, bespoke CRM development, enterprise web application, AI solutions, Laravel development, React web apps, SaaS development company',
            'og_title' => 'Custom Software, CRM & Web App Development | Suave Creators',
            'og_description' => 'Engineer custom software, bespoke CRM systems, and AI-driven web applications. Explore verified engineering case studies, tech stack, and ROI blueprints.',
            'json_ld_name' => 'Custom Software, CRM & Web App Development | Suave Creators',
            'json_ld_description' => 'Engineer custom software, bespoke CRM systems, and AI-driven web applications. Explore verified engineering case studies, tech stack, and ROI blueprints.',
        ],
        'about-us' => [
            'title' => 'About Suave Creators | Software & AI Development Company',
            'description' => 'Learn about Suave Creators, a software and AI development company delivering custom web, mobile, CRM, enterprise, and digital solutions for businesses worldwide.',
            'og_title' => 'About Suave Creators | Innovation-Driven IT Company',
            'og_description' => 'Learn about Suave Creators, a trusted IT company delivering innovative web development, AI solutions, and digital growth services for businesses worldwide.',
        ],
        'contact-us' => [
            'title' => 'Contact Suave Creators | Get a Free Software Consultation',
            'description' => 'Tell us what you want to build. We’ll help clarify what it takes, what you’ll get, and the next steps to create real business results.',
            'og_title' => 'Ready to Build? Get a Free Project Consultation | Suave Creators',
            'og_description' => 'Tell us what you want to build. We’ll help clarify what it takes, what you’ll get, and the next steps to create real business results.',
        ],
        'services' => [
            'title' => 'Software Development Services for B2B & SaaS Businesses',
            'description' => 'Explore web, CRM, e-commerce, AI, and enterprise software services for businesses ready to invest in measurable digital growth.',
            'og_title' => 'Software Development Services for Serious Growth | Suave Creators',
            'og_description' => 'Explore web, CRM, e-commerce, AI, and enterprise software services for businesses ready to invest in measurable digital growth.',
        ],
        'industries' => [
            'title' => 'Industry-Specific Software Development Solutions | Suave Creators',
            'description' => 'Industry-specific web design, software, and AI solutions for finance, healthcare, education, retail, logistics, and more.',
        ],
        'product' => [
            'title' => 'AI Outreach CRM & Sales Automation | Suave Creators',
            'description' => 'Automate outreach, capture leads, and close deals with Suave Creators AI Outreach CRM. Start free and scale sales with intelligent workflows.',
            'og_title' => 'AI-Powered Outreach CRM | Suave Creators',
            'og_description' => 'Discover Suave AI Outreach CRM for lead management, automated sales outreach, and AI-driven business growth.',
            'og_image' => 'assets/product/product-og-banner.webp',
            'og_image_width' => 1200,
            'og_image_height' => 630,
            'og_image_alt' => 'Suave AI sales CRM dashboard with lead capture and outreach analytics',
            'json_ld_name' => 'Suave AI-Powered Outreach CRM',
            'json_ld_description' => 'Suave CRM helps teams discover companies, brief prospects with Suave AI, send cold email through S-Mail, and manage sales pipelines with optional work management add-ons.',
            'json_ld_breadcrumb_name' => 'Our Product',
        ],
        'blogs' => [
            'title' => 'Blog - Software Development Insights | Suave Creators',
            'description' => 'Explore Suave Creators blogs on custom software, web development, CRM, AI, and digital transformation. Practical insights for startups and enterprises.',
            'og_title' => 'Blog - Software Development Insights | Suave Creators',
            'og_description' => 'Explore Suave Creators blogs on custom software, web development, CRM, AI, and digital transformation.',
        ],
        'privacy-policy' => [
            'title' => 'Privacy Policy | Suave Creators',
            'description' => 'Learn how Suave Creators collects, uses, and protects your personal information when you visit our website or contact our team.',
        ],
        'terms-and-conditions' => [
            'title' => 'Terms & Conditions | Suave Creators',
            'description' => 'Read the terms and conditions for using the Suave Creators website and services at suavecreators.com.',
        ],
        'service.show' => [
            'title' => 'Service | Suave Creators',
            'description' => 'Suave Creators service details.',
        ],
        'industry.show' => [
            'title' => 'Industry Solutions | Suave Creators',
            'description' => 'Industry-specific software development solutions from Suave Creators.',
        ],
        'case-studies' => [
            'title' => 'Software Development Case Studies & Success Stories | Suave Creators',
            'description' => 'See how Suave Creators designs and ships real products — stories from the software we build for clients.',
        ],
        'turbo-trans-case-study' => [
            'title' => 'Custom Software Development Case Study: Turbo Trans | Suave Creators',
            'description' => 'See how a logistics leader transformed their sales operations with AI-powered CRM automation',
            'og_title' => 'Success Story: Turbo Trans Corporation',
            'og_description' => 'See how a logistics leader transformed their sales operations with AI-powered CRM automation',
            'og_image' => 'assets/case-studies/turbo-trans/turbo-trans-corporation-logo.png',
        ],
        'ai-sales-coaching-case-study' => [
            'title' => 'AI Sales Coaching Platform Case Study | Suave Creators',
            'description' => 'Explore how Suave Creators built an AI sales coaching platform with voice practice, live call assistance, and post-call scoring to support sales team performance.',
            'og_title' => 'AI Sales Coaching Platform Case Study',
            'og_description' => 'See how an AI sales coach practices with reps, whispers live tips, and scores calls so growing teams ramp faster without living in a recording queue.',
            'og_image' => 'assets/case-studies/ai-sales-coaching/ai_sales_coach.webp',
        ],
        'outreach-case-study' => [
            'title' => 'B2B CRM Sales Automation Case Study | Suave Creators',
            'description' => 'Explore how Suave Creators built a B2B CRM for lead discovery, AI prospecting, cold email, and sales pipeline management to streamline outbound sales.',
            'og_title' => 'B2B CRM Outbound Sales Redesign | Case Study | Suave Creators',
            'og_description' => 'Map-based company discovery, AI sales briefings, and cold email automation in one B2B CRM workspace — 65% fewer prospecting steps.',
            'og_image' => 'assets/case-studies/suave-crm-outreach/outreach-before-after-hero.png',
        ],
        'tasks-case-study' => [
            'title' => 'B2B CRM Task Management Case Study | Suave Creators',
            'description' => 'See how Suave Creators redesigned B2B CRM task management with Kanban and List views, AI assistance, and automated workflows in one workspace.',
            'og_title' => 'B2B CRM Task Management | Case Study | Suave Creators',
            'og_description' => 'Kanban and List view integration plus an automated task assistant AI — one AI project management workspace with 50% less view switching.',
            'og_image' => 'assets/case-studies/suave-crm-tasks/the-suave-app-task-banner.webp',
        ],
        'teerrath-case-study' => [
            'title' => 'Teerrath Spiritual Energy Scan Case Study | Case Study | Suave Creators',
            'description' => 'A free Spiritual Energy Scan in under 2 minutes becomes AI-personalized Vedic insight across six life areas — then a clear Dev, Mantra, Yantra, or Daan path to buy, gift, or fulfill.',
            'og_image' => 'assets/case-studies/teerrath/spiritual-energy-scan-hero.png',
            'robots' => 'noindex, nofollow',
        ],
        'appointment-insurance-case-study' => [
            'title' => 'Appointment Insurance Platform Case Study | Suave Creators',
            'description' => 'Discover how Suave Creators built an appointment insurance platform with deposits, SMS invitations, check-in, and automated Stripe refund workflows.',
            'og_title' => 'Appointment Insurance Platform Case Study | Case Study | Suave Creators',
            'og_description' => 'See how appointment insurance turns no-shows into fair payouts — clear deposits, arrival check-in, and smart Stripe refunds that save card fees.',
            'og_image' => 'assets/case-studies/appointment-insurance/appointment-insurance-banner.webp',
        ],
        'ai-product-matching-case-study' => [
            'title' => 'AI Product Matching Case Study | Case Study | Suave Creators',
            'description' => 'AI Product Matching replaces hand-checking supplier sites, manual match qualification, and spreadsheet record-keeping with automated catalog search, AI help on close calls, and one place to decide with proof.',
            'og_image' => 'assets/case-studies/ai-product-matching/ai-product-matching-logo.webp',
            'robots' => 'noindex, nofollow',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Weekly SEO audit report
    |--------------------------------------------------------------------------
    |
    | Scheduled artisan command seo:audit-report crawls every public sitemap
    | URL (APP_URL), builds an on-page SEO report, and emails it. Runs Monday
    | morning by default via schedule:run. Localhost / 127.0.0.1 URLs are
    | rendered in-process (avoids php artisan serve self-request deadlocks).
    |
    */

    'audit_report' => [
        'enabled' => (bool) env('SEO_AUDIT_REPORT_ENABLED', true),
        'time' => env('SEO_AUDIT_REPORT_TIME', '09:00'),
        'to' => env('SEO_AUDIT_REPORT_TO', 'info@suavecreators.com'),
        // Use "log" until real SMTP is ready; set SEO_AUDIT_REPORT_MAILER=smtp (or default) to send.
        'mailer' => env('SEO_AUDIT_REPORT_MAILER', 'log'),
        'timeout' => (int) env('SEO_AUDIT_REPORT_TIMEOUT', 15),
        'delay_ms' => (int) env('SEO_AUDIT_REPORT_DELAY_MS', 150),
    ],

];
