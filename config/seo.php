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
        'logo' => 'assets/brand/logo.svg',
        'favicon' => 'assets/brand/favicon-192.png',
        'in_language' => 'en-US',
        'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
        'google_site_verification' => '8gnHTv-hWNxTIE6HmJwKSMZH5v_ryZuDVQRbAinOpAQ',
        'google_analytics_id' => 'G-NFN8FD2B2D',
        'google_tag_manager_id' => 'GTM-TN9JMPST',
        'hreflang' => [
            'en',
            'en-in',
            'en-us',
            'en-gb',
            'x-default',
        ],
        'organization' => [
            'legal_name' => 'Suave Creators',
            'email' => 'Info@suavecreators.com',
            'telephone' => '+91 97369 00142',
            'telephone_href' => 'tel:+919736900142',
            'telephone_schema' => '+91-9736900142',
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
                'https://www.instagram.com/suavecreators/?igsh=MWRscWJoZXJrNG10cw%3D%3D#',
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
                'AI-Integrated Applications',
                'SaaS Development',
            ],
        ],
        'default_faqs' => [
            [
                'question' => 'What services do you offer?',
                'answer' => 'We offer web development, CRM development, e-commerce solutions, CMS development, enterprise software, SEO, digital marketing, and UI/UX design.',
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
    |
    */

    'pages' => [
        'home' => [
            'title' => 'Custom Software & Web Development Company | Suave Creators',
            'description' => 'Suave Creators builds custom software, CRM systems, and scalable web applications for startups & enterprises. Boost growth with secure, future-ready solutions.',
            'og_title' => 'Custom Software & Web Development Company | Suave Creators',
            'og_description' => 'Suave Creators builds custom software, CRM systems, and scalable web applications. Grow faster with secure, future-ready digital solutions.',
            'json_ld_name' => 'Suave Creators — Web Development, CRM & Digital Growth Experts',
            'json_ld_description' => 'Suave Creators offers custom web development, CRM solutions, e-commerce development, enterprise software, mobile apps, digital marketing and SEO services.',
        ],
        'about-us' => [
            'title' => 'About Suave Creators | Leading IT Company, Digital Solutions',
            'description' => 'Learn about Suave Creators, a trusted IT company delivering innovative web development, AI-driven solutions, and digital growth services for global businesses.',
            'og_title' => 'About Suave Creators | Innovation-Driven IT Company',
            'og_description' => 'Learn about Suave Creators, a trusted IT company delivering innovative web development, AI solutions, and digital growth services for businesses worldwide.',
        ],
        'contact-us' => [
            'title' => 'Contact Suave Creators | Let’s Discuss Your Digital Project',
            'description' => 'Get in touch with Suave Creators to discuss your web development, app, or custom digital solution. Our team responds within 3 hours on business days.',
            'og_title' => 'Contact Suave Creators | Let’s Discuss Your Digital Project',
            'og_description' => 'Have a project in mind? Contact Suave Creators to discuss web development, apps, and custom digital solutions with our expert team.',
        ],
        'services' => [
            'title' => 'Offshore Web & Software Development Company | Suave Creators',
            'description' => 'Get offshore web, software, CRM & AI development from Suave Creators. We build scalable, secure digital solutions for global businesses.',
            'og_title' => 'Offshore Web & Software Development Company | Suave Creators',
            'og_description' => 'We provide offshore web development, software development, CRM, enterprise solutions, UI/UX, e-commerce, and AI services for startups & enterprises globally.',
        ],
        'industries' => [
            'title' => 'Industry Solutions | Suave Creators',
            'description' => 'Industry-specific web design, software, and AI solutions for finance, healthcare, education, retail, logistics, and more.',
        ],
        'product' => [
            'title' => 'Product - AI-Powered Business Platform | Suave Creators',
            'description' => 'Run your organization with Suave Creators product suite — AI at the core, unified modules, enterprise security, and a single workspace for your team.',
            'og_title' => 'Product - AI-Powered Business Platform | Suave Creators',
            'og_description' => 'Run your organization with Suave Creators product suite — AI at the core, unified modules, and enterprise security.',
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
