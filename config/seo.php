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
    | Retired hosts (HTTP 410 Gone)
    |--------------------------------------------------------------------------
    |
    | Point these DNS records at the same server as production, then every
    | path on those Host headers returns 410 so Google drops them faster
    | than NXDOMAIN / DNS errors (which burn crawl budget indefinitely).
    | www. prefixes are treated as the same retired host automatically.
    |
    */

    'retired_hosts' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('SEO_RETIRED_HOSTS', 'turbo.suavecreators.com,backend.suavecreators.com'))
    ))),

    /*
    |--------------------------------------------------------------------------
    | Allowed public query parameters
    |--------------------------------------------------------------------------
    |
    | GET/HEAD requests on the marketing site that include any other query
    | key are 301-redirected to the same path with only these keys kept.
    | Admin / SuaveAgent routes are excluded.
    |
    */

    'allowed_query_params' => [
        'page',
        'per_page',
        'category',
        'q',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'gclid',
        'fbclid',
        'msclkid',
        '_ga',
    ],

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
        'default_title' => 'Web & Software Development Company | Suave Creators',
        'default_description' => 'Suave Creators builds custom web applications, software, CRM, ERP, AI and digital solutions that help businesses improve efficiency, scale faster and grow.',
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
        'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
        'theme_color' => '#0B3D91',
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
            'alternate_name' => ['SuaveCreators', 'Suave Creators Software'],
            'description' => 'Suave Creators is a custom software development company that builds CRM, ERP, web applications and AI automation for US mid-market companies, and provides dedicated developers. Clients own 100% of the code.',
            'slogan' => 'Custom software you own.',
            'founding_date' => '2021',
            'number_of_employees_min' => 10,
            'founder' => [
                'name' => 'Aakash Choudhary',
                'job_title' => 'Founder & Solution Architect',
                'sameAs' => [
                    'https://www.linkedin.com/in/aakash-choudhary-b821b3191/',
                ],
            ],
            'homepage_area_served' => ['United States', 'United Kingdom', 'Australia'],
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
                'https://www.instagram.com/suavecreators/',
                'https://www.facebook.com/suavecreators/',
                'https://www.crunchbase.com/organization/suave-creators',
            ],
            'knowsAbout' => [
                'Custom software development',
                'Custom CRM development',
                'Custom ERP development',
                'Web application development',
                'AI integration',
                'Workflow automation',
                'Dedicated development teams',
                'Staff augmentation',
                'Laravel',
                'React',
                'Node.js',
            ],
            'engineering_center' => [
                'name' => 'Suave Creators – India Engineering Center',
                'price_range' => '$$',
                'latitude' => 32.0841192,
                'longitude' => 76.5132446,
                'opening_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '10:00',
                'closes' => '19:00',
            ],
            'offer_catalog' => [
                [
                    'name' => 'Custom CRM development',
                    'route' => 'service.show',
                    'parameters' => ['slug' => 'custom-crm-development'],
                ],
                [
                    'name' => 'Custom ERP and enterprise software development',
                    'route' => 'service.show',
                    'parameters' => ['slug' => 'enterprise-software-solutions'],
                ],
                [
                    'name' => 'Web application development',
                    'route' => 'service.show',
                    'parameters' => ['slug' => 'web-development-services'],
                ],
                [
                    'name' => 'AI integration and workflow automation',
                    'route' => 'service.show',
                    'parameters' => ['slug' => 'ai-solutions'],
                ],
                [
                    'name' => 'E-commerce platform development',
                    'route' => 'service.show',
                    'parameters' => ['slug' => 'e-commerce-development'],
                ],
                [
                    'name' => 'UI/UX product design',
                    'route' => 'service.show',
                    'parameters' => ['slug' => 'ui-ux-design-services'],
                ],
                [
                    'name' => 'Dedicated software developers and staff augmentation',
                    'service_type' => 'Staff augmentation',
                    'route' => 'hire-dedicated-developers',
                ],
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
                'question' => 'How much does custom software development cost?',
                'answer' => 'Custom software development typically costs $15,000–$50,000 for an MVP or single-workflow tool and $50,000–$150,000 for a multi-team platform. Enterprise systems cost more. At Suave Creators, dedicated developers start at $2,000 per developer per month, and fixed-price projects begin with a paid discovery phase that sets the final price.',
            ],
            [
                'question' => 'How long does it take to build custom software?',
                'answer' => 'Most custom software projects take 8–16 weeks from discovery to launch. An MVP can launch in 6–10 weeks, while enterprise platforms take 16 weeks or more. We deliver working software every 2 weeks, so you see progress throughout.',
            ],
            [
                'question' => 'How do I hire a software development company?',
                'answer' => 'Start by defining the problem, budget and timeline, then shortlist firms with relevant case studies and verified reviews. Ask each for a written scope, the team\'s seniority, who owns the code, and how they handle changes. At Suave Creators, a solution architect replies within 1 business day and sends a scope and cost range within 48 hours.',
            ],
            [
                'question' => 'Can I hire dedicated developers instead of a full project team?',
                'answer' => 'Yes. You can hire individual Laravel, React, Node.js, full-stack or AI developers who join your team, or a dedicated team that works only on your product. Developers are full-time Suave Creators employees, you interview them first, and most start within 5–10 business days.',
            ],
            [
                'question' => 'Is custom software cheaper than SaaS tools?',
                'answer' => 'Custom software is usually cheaper over three years for teams with 25+ users or workflows that SaaS tools can\'t support. SaaS tools charge per seat every year and add paid tiers for automation and AI. Custom software is a one-time build plus predictable hosting and support.',
            ],
            [
                'question' => 'Who owns the code and data?',
                'answer' => 'You own 100% of the source code, data and intellectual property. Code lives in your repository from the first sprint, and full IP transfer is written into every contract. There are no licence fees or lock-in.',
            ],
            [
                'question' => 'Where is Suave Creators based?',
                'answer' => 'Suave Creators is a US-registered company (Wyoming) with its engineering center in Palampur, India. US clients sign US contracts, and our team overlaps with US business hours for calls and sprint reviews. Founded in 2021, we have delivered 50+ production platforms.',
            ],
            [
                'question' => 'Do you provide support after launch?',
                'answer' => 'Yes. Every project can move onto a monthly support plan covering uptime monitoring, security patches, bug fixes and new features. Response times are set in a written SLA, starting at 4 business hours for critical issues.',
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
            'title' => 'Custom Software Development Company | Suave Creators',
            'description' => 'Hire a custom software development company that builds CRM, ERP and web apps you own. Senior developers, 2-week sprints, US contracts. Get a scoped estimate.',
            'keywords' => 'custom software development company, software development company for US businesses, hire software developers, dedicated development team, custom software development services',
            'og_title' => 'Custom Software Development Company | Software You Own',
            'og_description' => 'Custom CRM, ERP and web applications built by senior developers in 2-week sprints. 100% code ownership. Hire a team or get a scoped estimate.',
            'twitter_description' => 'Custom CRM, ERP and web apps by senior developers. 100% code ownership, 2-week sprints.',
            'og_image' => 'assets/brand/og-default.png',
            'og_image_width' => 1200,
            'og_image_height' => 630,
            'og_image_alt' => 'Suave Creators custom software development team and product dashboard',
            'date_published' => '2021-01-01',
            'date_modified' => '2026-10-07',
            'json_ld_name' => 'Custom Software Development Company | Suave Creators',
            'json_ld_description' => 'Hire a custom software development company that builds CRM, ERP and web apps you own. Senior developers, 2-week sprints, US contracts. Get a scoped estimate.',
        ],
        'about-us' => [
            'title' => 'About Suave Creators | Software & AI Development Company',
            'description' => 'Learn about Suave Creators, a software and AI development company delivering custom web, mobile, CRM, enterprise, and digital solutions for businesses worldwide.',
            'og_title' => 'About Suave Creators | Software & AI Development Company',
            'og_description' => 'Learn about Suave Creators, a software and AI development company delivering custom web, mobile, CRM, enterprise, and digital solutions for businesses worldwide.',
        ],
        'contact-us' => [
            'title' => 'Contact Suave Creators | Get a Free Software Consultation',
            'description' => 'Have a software, web, CRM, ERP or AI project in mind? Contact Suave Creators for a free consultation and discuss your business requirements with our experts.',
            'og_title' => 'Contact Suave Creators | Get a Free Software Consultation',
            'og_description' => 'Have a software, web, CRM, ERP or AI project in mind? Contact Suave Creators for a free consultation and discuss your business requirements with our experts.',
        ],
        'services' => [
            'title' => 'Custom Software, CRM & AI Development Services | Suave Creators',
            'description' => 'Enterprise B2B software development services: custom CRM builder, scalable web apps, enterprise software, UI/UX, and AI solutions with 100% code ownership.',
            'og_title' => 'Custom Software, CRM & AI Development Services | Suave Creators',
            'og_description' => 'Enterprise B2B software development services: custom CRM builder, scalable web apps, enterprise software, UI/UX, and AI solutions with 100% code ownership.',
            'json_ld_breadcrumb_name' => 'Services',
        ],
        'technologies' => [
            'title' => 'Web & Software Development Technology Stack | Suave Creators',
            'description' => 'Laravel, Node.js, React, React Native, Angular, Vue.js, WordPress, Shopify Plus and Magento: what we build with each for web, mobile and commerce.',
            'keywords' => 'technology stack for web development, software development technology stack, web development technologies, enterprise technology stack',
            'og_title' => 'Our Technology Stack: Laravel, React, Node.js, Shopify Plus & More',
            'og_description' => 'What Suave Creators builds with Laravel, Node.js, React & React Native, Angular, Vue.js, WordPress & Headless CMS, Shopify Plus and Magento (Adobe Commerce).',
            'twitter_title' => 'Our Technology Stack: Laravel, React, Node.js & More',
            'twitter_description' => 'Eight technologies, what each is for, and what we build with them: web, mobile, CMS and e-commerce.',
            'json_ld_name' => 'Web & Software Development Technology Stack | Suave Creators',
            'json_ld_description' => 'Laravel, Node.js, React, React Native, Angular, Vue.js, WordPress, Shopify Plus and Magento: what we build with each for web, mobile and commerce.',
            'json_ld_breadcrumb_name' => 'Technologies',
        ],
        'industries' => [
            'title' => 'Industry-Specific Software Development Solutions | Suave Creators',
            'description' => 'Explore custom software development solutions for healthcare, startups, finance, e-commerce, logistics, and education, built by Suave Creators.',
            'og_title' => 'Industry-Specific Software Development Solutions | Suave Creators',
            'og_description' => 'Explore custom software development solutions for healthcare, startups, finance, e-commerce, logistics, and education, built by Suave Creators.',
        ],
        'custom-crm-builder' => [
            'title' => 'Custom CRM Builder & Software Development Company | Suave Creators',
            'description' => 'Build a custom CRM tailored to your sales workflows. Eliminate per-seat licensing fees with scalable, secure, AI-powered custom CRM development from Suave Creators.',
            'og_title' => 'Custom CRM Builder & Software Development Company | Suave Creators',
            'og_description' => 'Build a custom CRM tailored to your sales workflows. Eliminate per-seat licensing fees with scalable, secure, AI-powered custom CRM development from Suave Creators.',
            'og_image' => 'assets/background/custom-crm-builder-hero-bg.webp',
            'og_image_width' => 1200,
            'og_image_height' => 630,
            'og_image_alt' => 'Suave Creators Custom CRM Builder Architecture and Dashboard Interface',
            'json_ld_name' => 'Custom CRM Builder & Software Development Company | Suave Creators',
            'json_ld_description' => 'Build a custom CRM tailored to your sales workflows. Eliminate per-seat licensing fees with scalable, secure, AI-powered custom CRM development from Suave Creators.',
            'json_ld_breadcrumb_name' => 'Custom CRM Builder',
            'json_ld_breadcrumb_parent_name' => 'Services',
            'json_ld_breadcrumb_parent_route' => 'services',
        ],
        'enterprise-ai-erp-uae' => [
            'title' => 'Enterprise AI & Custom ERP Solutions UAE | Suave Creators',
            'description' => 'Custom ERP software and enterprise AI agent solutions for UAE businesses. VAT-compliant, single-tenant, bilingual (AR/EN) architecture with 100% IP ownership.',
            'keywords' => 'enterprise ai and erp solutions uae, custom ERP development dubai, enterprise AI solutions UAE, bespoke ERP software UAE, AI automation company dubai, custom ERP software abu dhabi',
            'og_title' => 'Enterprise AI & Custom ERP Solutions UAE | Suave Creators',
            'og_description' => 'Custom ERP software and enterprise AI agent solutions for UAE businesses. VAT-compliant, single-tenant, bilingual (AR/EN) architecture with 100% IP ownership.',
            'og_image' => 'assets/media/enterprise-ai-erp-og-banner.webp',
            'og_image_width' => 1200,
            'og_image_height' => 630,
            'og_image_alt' => 'Enterprise AI and custom ERP dashboard for UAE businesses',
            'og_locale' => 'en_AE',
            'og_locale_alternate' => ['en_US'],
            'hreflang' => ['en', 'en-ae', 'x-default'],
            'json_ld_name' => 'Enterprise AI & Custom ERP Solutions UAE | Suave Creators',
            'json_ld_description' => 'Custom ERP software and enterprise AI agent solutions for UAE businesses. VAT-compliant, single-tenant, bilingual (AR/EN) architecture with 100% IP ownership.',
            'json_ld_breadcrumb_name' => 'Enterprise AI & ERP Solutions UAE',
            'json_ld_breadcrumb_parent_name' => 'Services',
            'json_ld_breadcrumb_parent_route' => 'services',
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
            'description' => 'Explore software development case studies showcasing CRM, AI, automation, web and custom software projects built to solve real business challenges.',
            'og_title' => 'Software Development Case Studies & Success Stories | Suave Creators',
            'og_description' => 'Explore software development case studies showcasing CRM, AI, automation, web and custom software projects built to solve real business challenges.',
        ],
        'turbo-trans-case-study' => [
            'title' => 'Custom Software Development Case Study: Turbo Trans | Suave Creators',
            'description' => 'Explore how Suave Creators delivered a custom software solution for Turbo Trans Corporation, addressing business workflows, usability, and operational needs.',
            'og_title' => 'Custom Software Development Case Study: Turbo Trans | Suave Creators',
            'og_description' => 'Explore how Suave Creators delivered a custom software solution for Turbo Trans Corporation, addressing business workflows, usability, and operational needs.',
            'og_image' => 'assets/case-studies/turbo-trans/turbo-trans-corporation-logo.png',
        ],
        'ai-sales-coaching-case-study' => [
            'title' => 'AI Sales Coaching Platform Case Study | Suave Creators',
            'description' => 'Explore how Suave Creators built an AI sales coaching platform with voice practice, live call assistance, and post-call scoring to support sales team performance.',
            'og_title' => 'AI Sales Coaching Platform Case Study | Suave Creators',
            'og_description' => 'Explore how Suave Creators built an AI sales coaching platform with voice practice, live call assistance, and post-call scoring to support sales team performance.',
            'og_image' => 'assets/case-studies/ai-sales-coaching/ai-sales-coach.webp',
        ],
        'outreach-case-study' => [
            'title' => 'B2B CRM Sales Automation Case Study | Suave Creators',
            'description' => 'Explore how Suave Creators built a B2B CRM for lead discovery, AI prospecting, cold email, and sales pipeline management to streamline outbound sales.',
            'og_title' => 'B2B CRM Sales Automation Case Study | Suave Creators',
            'og_description' => 'Explore how Suave Creators built a B2B CRM for lead discovery, AI prospecting, cold email, and sales pipeline management to streamline outbound sales.',
            'og_image' => 'assets/case-studies/suave-crm-outreach/outreach-before-after-hero.webp',
        ],
        'tasks-case-study' => [
            'title' => 'B2B CRM Task Management Case Study | Suave Creators',
            'description' => 'See how Suave Creators redesigned B2B CRM task management with Kanban and List views, AI assistance, and automated workflows in one workspace.',
            'og_title' => 'B2B CRM Task Management Case Study | Suave Creators',
            'og_description' => 'See how Suave Creators redesigned B2B CRM task management with Kanban and List views, AI assistance, and automated workflows in one workspace.',
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
            'og_title' => 'Appointment Insurance Platform Case Study | Suave Creators',
            'og_description' => 'Discover how Suave Creators built an appointment insurance platform with deposits, SMS invitations, check-in, and automated Stripe refund workflows.',
            'og_image' => 'assets/case-studies/appointment-insurance/appointment-insurance-banner.webp',
        ],
        'ai-product-matching-case-study' => [
            'title' => 'AI Product Matching Case Study | Case Study | Suave Creators',
            'description' => 'AI Product Matching replaces hand-checking supplier sites, manual match qualification, and spreadsheet record-keeping with automated catalog search, AI help on close calls, and one place to decide with proof.',
            'og_image' => 'assets/case-studies/ai-product-matching/ai-product-matching-logo.webp',
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
