<?php

return [

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
            'address_display' => '30 N Gould St, STE R Sheridan, WY 82801, USA',
            'address' => [
                'streetAddress' => '30 N Gould St, STE R',
                'addressLocality' => 'Sheridan',
                'addressRegion' => 'WY',
                'postalCode' => '82801',
                'addressCountry' => 'US',
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
            'title' => 'About Suave Creators | Leading IT Company with Web Design & Development',
            'description' => 'Suave Creators is a leading IT company offering budget-friendly web design, development, and digital solutions for startups, SMBs, and enterprise businesses.',
        ],
        'contact-us' => [
            'title' => 'Contact Suave Creators | Have a Project in Mind? Let\'s Discuss',
            'description' => 'Tell Suave Creators about your website, app, or custom software project. Our team usually responds within 12 business hours.',
        ],
        'services' => [
            'title' => 'Web, Software & Digital Development Services | Suave Creators',
            'description' => 'Explore Suave Creators offshore web development, enterprise software, UI/UX design, custom CRM, e-commerce, and AI solutions built for global businesses.',
        ],
        'industries' => [
            'title' => 'Industry Solutions | Suave Creators',
            'description' => 'Industry-specific software development solutions from Suave Creators.',
        ],
        'product' => [
            'title' => 'Product | AI-Powered Business Platform | Suave Creators',
            'description' => 'Run your organization with Suave Creators product suite - AI at the core, unified modules, enterprise security, and a single workspace for your team.',
            'og_description' => 'Run your organization with Suave Creators product suite - AI at the core, unified modules, and enterprise security.',
        ],
        'blogs' => [
            'title' => 'Blogs & Insights | Suave Creators',
            'description' => 'Articles and insights from Suave Creators on software development, digital strategy, and product design.',
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

];
