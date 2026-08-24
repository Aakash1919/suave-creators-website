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
        'tagline' => 'Custom Software & Web Development Company',
        'default_title' => 'Custom Software & Web Development Company | Suave Creators',
        'default_description' => 'Suave Creators builds custom software, CRM systems, and scalable web applications for startups & enterprises. Boost growth with secure, future-ready solutions.',
        'default_og_image' => 'assets/brand/og-default.png',
        'default_og_image_width' => 1200,
        'default_og_image_height' => 630,
        'default_og_image_alt' => 'Suave Creators - Custom Software & Web Development Company',
        'logo' => 'assets/brand/logo.png',
        'favicon' => 'assets/brand/favicon-192.png',
        'in_language' => 'en-US',
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
            'address_secondary_display' => '3M Plaza, Second Floor, Maranda, Kasoti, Palampur, Himachal Pradesh 176102',
            'offices' => [
                [
                    'label' => 'First office',
                    'display' => '30 N Gould St, STE R, Sheridan, WY 82801, USA',
                    'lines' => [
                        '30 N Gould St, STE R,',
                        'Sheridan, WY 82801, USA',
                    ],
                ],
                [
                    'label' => 'Second office',
                    'display' => '3M Plaza, Second Floor, Maranda, Kasoti, Palampur, Himachal Pradesh 176102',
                    'lines' => [
                        '3M Plaza, Second Floor,',
                        'Maranda, Kasoti, Palampur,',
                        'Himachal Pradesh 176102',
                    ],
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
                'Web Development',
                'UI/UX Design',
                'Custom CRM Development',
                'CMS Development',
                'E-commerce Development',
                'Enterprise Software Development',
                'Mobile App Development',
                'Digital Marketing',
                'SEO Services',
                'Answer Engine Optimization',
                'Generative Engine Optimization',
                'Branding & Identity',
                'AI Solutions',
                'AI-Integrated Applications',
                'SaaS Development',
            ],
        ],
        'default_faqs' => [
            [
                'question' => 'What services do you offer?',
                'answer' => 'We offer web development, CRM development, e-commerce solutions, enterprise software, UI/UX design, AI solutions, SEO, and digital marketing.',
            ],
            [
                'question' => 'Do you provide ongoing support?',
                'answer' => 'Yes, we provide full maintenance, updates, and long-term support after launch.',
            ],
            [
                'question' => 'Will my website be mobile-friendly?',
                'answer' => 'Yes, all our websites are fully responsive and optimized for all devices.',
            ],
            [
                'question' => 'Do you offer SEO services?',
                'answer' => 'Yes, we provide SEO, AEO, GEO, content marketing, and digital growth services.',
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
            'title' => 'Build Software That Creates Real Business Results | Suave Creators',
            'description' => 'Ready to invest in custom software, CRM, ERP, web apps, or AI? See what it takes, what you get, and how Suave Creators can help.',
            'og_title' => 'Build Software That Creates Real Business Results',
            'og_description' => 'Ready to invest in custom software, CRM, ERP, web apps, or AI? See what it takes, what you get, and how Suave Creators can help.',
            'json_ld_name' => 'Suave Creators — Web Development, CRM & Digital Growth Experts',
            'json_ld_description' => 'Suave Creators offers custom web development, CRM solutions, e-commerce development, enterprise software, UI/UX design, AI solutions, mobile apps, digital marketing and SEO services.',
        ],
        'about-us' => [
            'title' => 'About Suave Creators | Leading IT Company, Digital Solutions',
            'description' => 'Learn about Suave Creators, a trusted IT company delivering innovative web development, AI-driven solutions, and digital growth services for global businesses.',
            'og_title' => 'About Suave Creators | Innovation-Driven IT Company',
            'og_description' => 'Learn about Suave Creators, a trusted IT company delivering innovative web development, AI solutions, and digital growth services for businesses worldwide.',
        ],
        'contact-us' => [
            'title' => 'Ready to Build? Get a Free Project Consultation | Suave Creators',
            'description' => 'Tell us what you want to build. We’ll help clarify what it takes, what you’ll get, and the next steps to create real business results.',
            'og_title' => 'Ready to Build? Get a Free Project Consultation | Suave Creators',
            'og_description' => 'Tell us what you want to build. We’ll help clarify what it takes, what you’ll get, and the next steps to create real business results.',
        ],
        'services' => [
            'title' => 'Software Development Services for Serious Growth | Suave Creators',
            'description' => 'Explore web, CRM, e-commerce, AI, and enterprise software services for businesses ready to invest in measurable digital growth.',
            'og_title' => 'Software Development Services for Serious Growth | Suave Creators',
            'og_description' => 'Explore web, CRM, e-commerce, AI, and enterprise software services for businesses ready to invest in measurable digital growth.',
        ],
        'industries' => [
            'title' => 'Industry Software Solutions for Growing Businesses | Suave Creators',
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
            'title' => 'Software Case Studies That Prove Real Results | Suave Creators',
            'description' => 'See how Suave Creators designs and ships real products — stories from the software we build for clients.',
        ],
        'turbo-trans-case-study' => [
            'title' => 'Success Story : Turbo Trans Corporation | Case Study | Suave Creators',
            'description' => 'See how a logistics leader transformed their sales operations with AI-powered CRM automation',
            'og_title' => 'Success Story: Turbo Trans Corporation',
            'og_description' => 'See how a logistics leader transformed their sales operations with AI-powered CRM automation',
            'og_image' => 'assets/case-studies/turbo-trans/turbo-trans-corporation-logo.png',
        ],
        'ai-sales-coaching-case-study' => [
            'title' => 'AI Sales Coaching Platform Case Study | Case Study | Suave Creators',
            'description' => 'Case study: how Suave Creators built an AI sales coaching platform with voice practice, live call assist, and post-call scoring for faster ramp and consistent call quality.',
            'og_title' => 'AI Sales Coaching Platform Case Study',
            'og_description' => 'See how an AI sales coach practices with reps, whispers live tips, and scores calls so growing teams ramp faster without living in a recording queue.',
            'og_image' => 'assets/case-studies/ai-sales-coaching/ai_sales_coach.webp',
        ],
        'outreach-case-study' => [
            'title' => 'B2B CRM Outbound Sales Workflow | Case Study | Suave Creators',
            'description' => 'How Suave Creators unified B2B CRM outbound sales — map discovery, AI prospecting, cold email, and pipeline tracking in one workspace with 65% fewer steps.',
            'og_title' => 'B2B CRM Outbound Sales Redesign | Case Study | Suave Creators',
            'og_description' => 'Map-based company discovery, AI sales briefings, and cold email automation in one B2B CRM workspace — 65% fewer prospecting steps.',
            'og_image' => 'assets/case-studies/suave-crm-outreach/outreach-before-after-hero.png',
        ],
        'tasks-case-study' => [
            'title' => 'B2B CRM Task Management Redesign | Case Study | Suave Creators',
            'description' => 'How Suave Creators unified B2B CRM task management — Kanban and List views, AI project management, and an automated task assistant in one workspace.',
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
            'title' => 'Appointment Insurance Platform Case Study | Case Study | Suave Creators',
            'description' => 'Case study: how Suave Creators built an appointment insurance platform with deposits, text invites, check-in, and smart Stripe refunds that cut card fees on returned deposits.',
            'og_title' => 'Appointment Insurance Platform Case Study | Case Study | Suave Creators',
            'og_description' => 'See how appointment insurance turns no-shows into fair payouts — clear deposits, arrival check-in, and smart Stripe refunds that save card fees.',
            'og_image' => 'assets/case-studies/shownoshow/show_no_show_banner.webp',
        ],
        'cabvi-case-study' => [
            'title' => 'CABVI AI Product Matching Case Study | Case Study | Suave Creators',
            'description' => 'CABVI replaces hand-checking supplier sites, manual match qualification, and spreadsheet record-keeping with automated catalog search, AI help on close calls, and one place to decide with proof.',
            'og_image' => 'assets/case-studies/cabvi/cabvi-logo.png',
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
