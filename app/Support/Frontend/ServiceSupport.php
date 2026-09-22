<?php

namespace App\Support\Frontend;

use App\Support\Frontend\Concerns\MapsDesignAssets;

class ServiceSupport
{
    use MapsDesignAssets;

    /** @var array<int, string> */
    public const SLUGS = [
        'web-development-services',
        'custom-crm-development',
        'enterprise-software-solutions',
        'e-commerce-development',
        'ui-ux-design-services',
        'ai-solutions',
    ];

    /**
     * @return array<string, mixed>
     */
    public static function indexData(): array
    {
        $faqs = self::faqs();

        return [
            'techStack' => self::techStack(),
            'expertiseItems' => self::expertiseItems(),
            'servicesData' => self::servicesData(),
            'offshoreSlides' => self::offshoreSlides(),
            'techCards' => self::techCards(),
            'processCards' => self::processCards(),
            'faqs' => $faqs,
            'articles' => self::articles(),
            'caseStudies' => self::indexCaseStudies(),
            'connectCta' => [
                'eyebrow' => '',
                'title' => 'Ready to Start Your Project?',
                'description' => 'Collaborate directly with senior software architects to scope your roadmap, evaluate your technology stack, and accelerate your time to market.',
                'primaryLabel' => "Let's Connect to Discuss",
                'secondaryLabel' => 'Discuss Your Technical Roadmap →',
            ],
            'consultation' => [
                'backgroundImage' => 'assets/background/work-with-us-bg.webp',
                'eyebrow' => '',
                'title' => 'Ready to Start Your Project?',
                'description' => 'Speak directly with an enterprise software architect to discuss your requirements, review your technical roadmap, and get an accurate project estimate.',
                'ctaLabel' => "Let's Connect to Discuss",
                'secondaryCtaLabel' => 'Book Direct via Google Calendar →',
                'solo' => false,
                'showPeople' => false,
            ],
            'seoFaqs' => $faqs,
            ...self::indexSeoStructuredData(),
        ];
    }

    /**
     * @return array<int, array{icon: string, title: string, description: string, accent: string, tint: string, alt: string}>
     */
    public static function expertiseItems(): array
    {
        return [
            [
                'icon' => 'assets/portfolio/project-analysis-dashboard.png',
                'title' => 'Project Analysis',
                'description' => 'Comprehensive workflow evaluation and technical requirements scoping.',
                'accent' => '#4C24F4',
                'tint' => '#F0EAFF',
                'alt' => 'Project analysis dashboard for Suave Creators software development services',
            ],
            [
                'icon' => 'assets/icons/research-and-strategy-icon.webp',
                'title' => 'Research & Strategy',
                'description' => 'Competitive benchmarking, user journey mapping, and architecture planning.',
                'accent' => '#1873E7',
                'tint' => '#EAF5FC',
                'alt' => 'Research and strategy step icon for Suave Creators software engineering',
            ],
            [
                'icon' => 'assets/media/build-strategy-visual.png',
                'title' => 'Build Strategy',
                'description' => 'Database schema design, tech stack selection, and milestone roadmapping.',
                'accent' => '#0F968E',
                'tint' => '#E8F8F6',
                'alt' => 'Build strategy visual for Suave Creators custom software architecture',
            ],
            [
                'icon' => 'assets/icons/wireframe-and-design-icon.webp',
                'title' => 'Wireframe & Design',
                'description' => 'Interactive Figma prototypes and responsive design systems.',
                'accent' => '#C4520D',
                'tint' => '#FFF0E7',
                'alt' => 'Wireframe and product design step icon for Suave Creators UI UX services',
            ],
            [
                'icon' => 'assets/icons/development-and-scale-icon.webp',
                'title' => 'Development & Scale',
                'description' => 'Full-stack agile coding with bi-weekly staging demonstrations.',
                'accent' => '#2A4DFB',
                'tint' => '#EEF1FF',
                'alt' => 'Development and scale step icon for Suave Creators full-stack engineering',
            ],
            [
                'icon' => 'assets/media/launch-live-visual.png',
                'title' => 'Launch & Live',
                'description' => 'Zero-downtime deployment, data migration, and production cutover.',
                'accent' => '#0C7A73',
                'tint' => '#E8F8F6',
                'alt' => 'Launch and live product visual for Suave Creators development services',
            ],
            [
                'icon' => 'assets/brand/maintenance-mark-logo.png',
                'title' => 'Maintenance',
                'description' => 'Proactive 24/7 server monitoring, security patching, and SLA support.',
                'accent' => '#FA6811',
                'tint' => '#FFF0E7',
                'alt' => 'Maintenance support mark for Suave Creators software services',
            ],
        ];
    }

    /**
     * @return array<int, array{icon: string, number: string, title: string, tags: array<int, string>, description: string, cta: string, href: string, color: string, flagship: bool}>
     */
    public static function servicesData(): array
    {
        return [
            [
                'icon' => 'assets/icons/service-icon-1.svg',
                'number' => '01',
                'title' => 'Web Development Services',
                'tags' => ['Custom Cloud Applications', 'High-Concurrency Microservices', 'REST APIs'],
                'description' => 'We engineer fast, responsive, and secure custom web applications using modern frameworks like Laravel, Node.js, and React. Built from the ground up for scalability, search engine visibility, and seamless user interaction as your data volume expands.',
                'cta' => 'Explore Web Development',
                'href' => route('service.show', ['slug' => 'web-development-services']),
                'color' => 'blue',
                'flagship' => false,
            ],
            [
                'icon' => 'assets/icons/service-icon-2.svg',
                'number' => '02',
                'title' => 'Enterprise Software Solutions',
                'tags' => ['ERP Systems', 'Operational Workflow Automation', 'Legacy System Modernization'],
                'description' => 'Replace fragmented spreadsheets and disconnected departments with a unified enterprise platform. We build scalable ERP solutions featuring role-based permissions (RBAC), multi-branch inventory tracking, and custom automation.',
                'cta' => 'Explore Enterprise Solutions',
                'href' => route('service.show', ['slug' => 'enterprise-software-solutions']),
                'color' => 'blue',
                'flagship' => false,
            ],
            [
                'icon' => 'assets/icons/service-icon-3.svg',
                'number' => '03',
                'title' => 'UI/UX Design Services',
                'tags' => ['Design Systems', 'Interactive Wireframes', 'Mobile & Web Product Interfaces'],
                'description' => 'Exceptional software demands intuitive user experiences that minimize rep error and maximize adoption. Our team designs clickable Figma prototypes, user-tested design systems, and responsive layouts that drive conversions.',
                'cta' => 'See UI/UX Services',
                'href' => route('service.show', ['slug' => 'ui-ux-design-services']),
                'color' => 'blue',
                'flagship' => false,
            ],
            [
                'icon' => 'assets/icons/service-icon-4.svg',
                'number' => '04',
                'title' => 'Custom CRM Development',
                'tags' => ['Zero Per-Seat Licensing', 'Pipeline Automation', 'Native S-Mail Outreach'],
                'description' => 'Eliminate escalating monthly SaaS subscription fees. We build bespoke sales operating systems tailored to your unique deal stages—featuring drag-and-drop Kanban boards, automated lead scoring, and 100% data ownership.',
                'cta' => 'Learn More About Custom CRM Builder',
                'href' => route('service.show', ['slug' => 'custom-crm-development']),
                'color' => 'blue',
                'flagship' => true,
            ],
            [
                'icon' => 'assets/icons/service-icon-5.svg',
                'number' => '05',
                'title' => 'E-Commerce Development',
                'tags' => ['Shopify Plus', 'Headless E-Commerce', 'Custom Checkout APIs', 'POS Sync'],
                'description' => 'Build high-converting, scalable e-commerce storefronts engineered for fast page loads and frictionless checkout. We engineer custom platforms or scale enterprise stores on Shopify Plus, WooCommerce, and Magento.',
                'cta' => 'Explore E-Commerce Services',
                'href' => route('service.show', ['slug' => 'e-commerce-development']),
                'color' => 'blue',
                'flagship' => false,
            ],
            [
                'icon' => 'assets/icons/service-icon-6.svg',
                'number' => '06',
                'title' => 'AI Solutions & Multi-Agent Systems',
                'tags' => ['Production AI Agents', 'Vector Databases (RAG)', 'Automated Lead Qualification'],
                'description' => 'We move beyond basic chatbot wrappers. Our engineers integrate deterministic state machines, automated voice call coaching, and multi-agent document validation directly into your software with zero third-party token markups.',
                'cta' => 'Explore AI Services',
                'href' => route('service.show', ['slug' => 'ai-solutions']),
                'color' => 'blue',
                'flagship' => false,
            ],
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: array<int, string>, 4: string}>
     */
    public static function offshoreSlides(): array
    {
        return [
            [
                'assets/media/developers-collaborating-code-review.webp',
                'End-to-End Development Expertise',
                'From initial requirements analysis and schema design to cloud deployment and ongoing maintenance, we manage the complete lifecycle. You receive senior engineering capacity that delivers high-performance software while cutting your development budget by up to 60%.',
                ['Requirements', 'Cloud Deploy', 'Maintenance'],
                'Offshore development team reviewing custom software code together',
            ],
            [
                'assets/media/seo-infographic-on-imac.webp',
                'SEO-Optimisation and High-Performance Architecture',
                'Fast page speeds and clean code structure are built into every application. We implement semantic HTML5, server-side rendering, sub-second TTFB, and schema markup to ensure your platform performs for users and ranks across search engines.',
                ['Semantic HTML5', 'SSR', 'Core Web Vitals'],
                'SEO optimisation strategy on screen for high performance websites',
            ],
            [
                'assets/media/financial-dashboard-laptop-collaboration.webp',
                'Global Security and Scalable Infrastructure',
                'Our platforms are built to grow. Whether you are a venture-backed startup launching an MVP or an enterprise handling millions of database transactions, we design microservices architectures that scale securely with AES-256 data encryption and strict access controls.',
                ['AES-256', 'Microservices', 'Access Controls'],
                'Secure scalable analytics dashboard monitored by an enterprise software team',
            ],
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: string, 4: string}>
     */
    public static function techCards(): array
    {
        return [
            ['assets/icons/tech/shopify-technology-icon.png', 'Shopify & WooCommerce', 'High-volume e-commerce storefronts, custom checkout extensions, and inventory synchronization.', '#7AB55C', route('service.show', ['slug' => 'e-commerce-development'])],
            ['assets/icons/tech/react-technology-icon.png', 'React & Angular', 'Dynamic, reactive frontend interfaces and collaborative real-time dashboards.', '#149ECA', route('service.show', ['slug' => 'web-development-services'])],
            ['assets/icons/tech/php-technology-icon.png', 'Laravel & PHP', 'Scalable, secure backend architectures, robust REST APIs, and enterprise CRM solutions.', '#999999', route('service.show', ['slug' => 'custom-crm-development'])],
            ['assets/icons/tech/nodejs-technology-icon.png', 'Node.js', 'Real-time event-driven applications, high-concurrency microservices, and WebSockets.', '#68A063', route('service.show', ['slug' => 'web-development-services'])],
            ['assets/icons/tech/wordpress-technology-icon.png', 'WordPress', 'Fast, SEO-optimized business websites and content platforms with custom Gutenberg blocks.', '#21759B', route('service.show', ['slug' => 'web-development-services'])],
        ];
    }

    /**
     * @return array<int, array{icon: string, title: string, text: string}>
     */
    public static function processCards(): array
    {
        return [
            ['icon' => 'fa-solid fa-magnifying-glass-chart', 'title' => 'Discovery Phase', 'text' => 'We analyze workflows, evaluate legacy databases, define functional specifications, and select the optimal technology stack.'],
            ['icon' => 'fa-solid fa-route', 'title' => 'Strategy Development', 'text' => 'We establish clear milestone roadmaps, database schemas, API boundaries, and sprint deliverables.'],
            ['icon' => 'fa-solid fa-code', 'title' => 'Implementation & QA', 'text' => 'Full-stack development in transparent two-week sprints with continuous testing, security verification, and live demos.'],
        ];
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    public static function faqs(): array
    {
        return [
            [
                'question' => 'Do you work with international clients?',
                'answer' => 'Yes. Suave Creators works extensively with international clients across the United States, United Kingdom, Canada, Australia, the UAE, and Switzerland. All client contracts, non-disclosure agreements (NDAs), and intellectual property assignments are governed under United States law via our headquarters in Sheridan, Wyoming, providing complete legal protection and seamless cross-border collaboration.',
            ],
            [
                'question' => 'How do you ensure SEO-friendly development in your services?',
                'answer' => 'We build software with search engine visibility at the architectural core. This includes clean semantic HTML5 markup, server-side rendering (SSR) or static site generation via Next.js where appropriate, optimized Core Web Vitals (sub-second TTFB and minimal LCP), structured JSON-LD schema integration, automatic XML sitemaps, and proper canonicalization to ensure immediate indexation and high ranking potential.',
            ],
            [
                'question' => 'What industries do you serve?',
                'answer' => 'We deliver specialized software engineering across several key verticals: Logistics & Freight Forwarding (real-time dispatch and spot-quote engines), B2B SaaS & Tech Startups (custom MVPs and scalable platforms), Healthcare (HIPAA-compliant patient portals and appointment tools), Retail & E-Commerce (high-volume transactional stores), and Financial Services.',
            ],
            [
                'question' => 'What is the typical project timeline?',
                'answer' => 'A focused Minimum Viable Product (MVP) or custom CRM typically takes 8 to 12 weeks from architecture scoping to live deployment. Full-scale enterprise software suites, multi-system ERP integrations, and complex AI agent workflows generally require 16 to 24 weeks, structured across transparent, bi-weekly agile development sprints.',
            ],
            [
                'question' => 'Do you offer post-launch support and maintenance?',
                'answer' => 'Yes. We provide structured SLA maintenance agreements that include 24/7 automated uptime monitoring, proactive security patching, dependency upgrades, daily encrypted offsite backups, and allocated monthly developer hours for ongoing feature enhancements and technical optimizations.',
            ],
            [
                'question' => 'Why should we choose Suave Creators for our digital projects?',
                'answer' => 'Suave Creators gives you the best of both worlds: the legal protection, communication standards, and strategic leadership of a US-headquartered software firm, paired with the cost efficiency and scale of a dedicated engineering center. This model delivers up to 60% total cost of ownership (TCO) savings, 100% source code ownership, and direct collaboration with senior software architects without middle-management bloat.',
            ],
        ];
    }

    /**
     * @return array<int, array{title: string, excerpt: string, image: string, alt: string, date: string, datetime: string, author: string, url: string}>
     */
    public static function articles(): array
    {
        return BlogSupport::articleCards(3);
    }

    /**
     * @return array<int, array{label: string, src: string, alt: string}>
     */
    public static function techStack(): array
    {
        return [
            ['label' => 'HTML5', 'src' => 'assets/icons/tech/html5.svg', 'alt' => 'HTML5 technology logo for Suave Creators web development'],
            ['label' => 'JavaScript (ES6+)', 'src' => 'assets/icons/tech/javascript.svg', 'alt' => 'JavaScript ES6 technology logo for Suave Creators software development'],
            ['label' => 'TypeScript', 'src' => 'assets/icons/tech/TypeScript.webp', 'alt' => 'TypeScript technology logo for Suave Creators software development'],
            ['label' => 'Node.Js', 'src' => 'assets/icons/tech/nodedotjs.svg', 'alt' => 'Node.js technology logo partner of Suave Creators'],
            ['label' => 'ReactJS', 'src' => 'assets/icons/tech/react-logo.svg', 'alt' => 'ReactJS technology logo for Suave Creators web applications'],
            ['label' => 'Next.js', 'src' => 'assets/icons/tech/Next.js.webp', 'alt' => 'Next.js technology logo for Suave Creators web development'],
            ['label' => 'Python', 'src' => 'assets/icons/tech/python-logo.svg', 'alt' => 'Python technology logo for Suave Creators custom software'],
            ['label' => 'FastAPI', 'src' => 'assets/icons/tech/fast-api.webp', 'alt' => 'FastAPI technology logo for Suave Creators Python services'],
            ['label' => 'Laravel (PHP)', 'src' => 'assets/icons/tech/php-logo.svg', 'alt' => 'Laravel PHP technology logo for Suave Creators backend development'],
            ['label' => 'Vue.js', 'src' => 'assets/icons/tech/vuedotjs.svg', 'alt' => 'Vue.js technology logo for Suave Creators frontend development'],
            ['label' => 'Angular', 'src' => 'assets/icons/tech/angular.svg', 'alt' => 'Angular technology logo for Suave Creators web development'],
            ['label' => 'PostgreSQL', 'src' => 'assets/icons/tech/PostgresSQL.webp', 'alt' => 'PostgreSQL technology logo for Suave Creators database engineering'],
            ['label' => 'Redis', 'src' => 'assets/icons/tech/Redis.webp', 'alt' => 'Redis technology logo for Suave Creators caching infrastructure'],
            ['label' => 'Docker', 'src' => 'assets/icons/tech/Docker.webp', 'alt' => 'Docker technology logo for Suave Creators cloud engineering'],
            ['label' => 'AWS', 'src' => 'assets/icons/tech/aws-logo.webp', 'alt' => 'AWS technology logo for Suave Creators cloud infrastructure'],
            ['label' => 'Shopify Plus', 'src' => 'assets/icons/tech/shopify-technology-icon.png', 'alt' => 'Shopify Plus technology logo for Suave Creators ecommerce development'],
            ['label' => 'WooCommerce', 'src' => 'assets/icons/tech/WooCommerce.webp', 'alt' => 'WooCommerce technology logo for Suave Creators ecommerce development'],
            ['label' => 'WordPress', 'src' => 'assets/icons/tech/wordpress.svg', 'alt' => 'WordPress CMS technology logo for Suave Creators'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function indexCaseStudies(): array
    {
        $outcomes = [
            'ai-sales-coaching-platform-case-study' => [
                'title' => 'An AI Sales Coach That Practices, Whispers, and Scores',
                'short_description' => 'Voice practice modules, live call coaching, and automated post-call scoring resulting in +55% faster ramp time to quota and +60% less manager time spent reviewing calls.',
                'cta' => 'Explore the AI Sales Coaching Case Study',
            ],
            'suave-crm-outreach-case-study' => [
                'title' => 'The Suave App Outreach - B2B CRM Sales Workspace',
                'short_description' => 'Consolidated fragmented outbound prospecting into one workspace with map discovery and automated cold email, achieving 65% fewer operational steps and a 35% reduction in sales pipeline effort.',
                'cta' => 'Explore the B2B CRM Outreach Case Study',
            ],
            'suave-crm-tasks-case-study' => [
                'title' => 'The Suave App Tasks - B2B CRM Task Management Workspace',
                'short_description' => 'Redesigned task management with unified Kanban and List views, inline creation, and an AI assistant—cutting view switching by 50%.',
                'cta' => 'Explore the Tasks Workspace Case Study',
            ],
            'appointment-insurance-platform-case-study' => [
                'title' => 'Appointment Insurance That Makes Showing Up the Default',
                'short_description' => 'Automated deposit protection with smart Stripe refunds that eliminated 90% of credit card fee waste on returned deposits.',
                'cta' => 'Explore the Appointment Insurance Case Study',
            ],
            'AI-product-matching' => [
                'title' => 'AI Product Matching to an Automated Workspace',
                'short_description' => 'Automated catalog search and AI-assisted match qualification, reducing manual supplier site hunting by 70%.',
                'cta' => 'Explore the AI Product Matching Case Study',
            ],
            'turbo-trans-corporation-case-study' => [
                'title' => 'Custom Software Engineering: The Turbo Trans Corporation',
                'short_description' => 'Streamlined freight operations and automated spot-quote routing, generating 42% more qualified loads and 3.4x faster lead response times.',
                'cta' => 'Explore the Turbo Trans Logistics Case Study',
            ],
        ];

        return array_values(array_map(static function (array $item) use ($outcomes): array {
            $slug = (string) ($item['slug'] ?? '');
            $overlay = $outcomes[$slug] ?? null;

            if (is_array($overlay)) {
                if (isset($overlay['title'])) {
                    $item['title'] = (string) $overlay['title'];
                }
                $item['short_description'] = (string) $overlay['short_description'];
                $item['cta'] = (string) $overlay['cta'];
            }

            return $item;
        }, CaseStudySupport::servicesPageItems()));
    }

    /**
     * @return array{seoJsonLdGraph: array<int, array<string, mixed>>, seoJsonLdWebpageAbout: string}
     */
    public static function indexSeoStructuredData(): array
    {
        $pageUrl = rtrim(route('services'), '/');
        $serviceId = $pageUrl.'/#service';
        $baseUrl = rtrim((string) config('app.url', url('/')), '/');

        return [
            'seoJsonLdGraph' => [[
                '@type' => 'Service',
                '@id' => $serviceId,
                'name' => 'Custom Software, CRM & Digital Product Engineering Services',
                'provider' => [
                    '@id' => $baseUrl.'/#organization',
                ],
                'serviceType' => 'B2B Software Development Services',
                'areaServed' => [
                    '@type' => 'AdministrativeArea',
                    'name' => 'Worldwide',
                ],
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog',
                    'name' => 'Core Software Engineering Services',
                    'itemListElement' => array_values(array_map(static function (array $service): array {
                        return [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => (string) $service['title'],
                            ],
                        ];
                    }, self::servicesData())),
                ],
            ]],
            'seoJsonLdWebpageAbout' => $serviceId,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function service(string $slug): ?array
    {
        if (! in_array($slug, self::SLUGS, true)) {
            return null;
        }

        $path = self::dataPath('services/'.$slug.'.php');

        if (! is_file($path)) {
            return null;
        }

        /** @var array<string, mixed> $service */
        $service = include $path;

        return self::assetizeDesignData(self::mapDesignData($service));
    }

    /**
     * @return array<string, mixed>
     */
    public static function showData(string $slug): array
    {
        $service = self::service($slug);

        if ($service === null) {
            abort(404);
        }

        $bodyImage = (string) ($service['bodyImage'] ?? '');
        $bodyBg = (string) ($service['bodyBg'] ?? '');
        $useBodyImageLayout = $bodyImage !== '';
        $introLinkUrl = (string) ($service['introLinkRoute'] ?? $service['introLinkUrl'] ?? '');

        if ($introLinkUrl === '' || $introLinkUrl === 'services' || $introLinkUrl === '/services' || $introLinkUrl === '/services/') {
            $service['introLinkUrl'] = route('services');
        } else {
            $service['introLinkUrl'] = self::resolveInternalHref($introLinkUrl);
        }

        return [
            'service' => $service,
            'seoTitle' => (string) ($service['pageTitle'] ?? 'Service | Suave Creators'),
            'seoDescription' => (string) ($service['pageDescription'] ?? 'Suave Creators service details.'),
            'seoOgTitle' => (string) ($service['ogTitle'] ?? $service['pageTitle'] ?? ''),
            'seoOgDescription' => (string) ($service['ogDescription'] ?? $service['pageDescription'] ?? ''),
            'mainClass' => 'site-main site-main--service-detail',
            'seoFaqs' => array_values(array_filter(
                array_map(static function (array $faq): array {
                    return [
                        'question' => (string) ($faq['question'] ?? ''),
                        'answer' => (string) ($faq['answer'] ?? ''),
                    ];
                }, is_array($service['faqs'] ?? null) ? $service['faqs'] : []),
                static fn (array $faq): bool => $faq['question'] !== '' && $faq['answer'] !== '',
            )),
            'bannerBg' => (string) ($service['bannerBg'] ?? ''),
            'bannerSideImage' => (string) ($service['bannerSideImage'] ?? ''),
            'introBg' => asset(self::mapDesignPath('/assets/background/technology-section-bg.png')),
            'collabBackground' => asset(self::mapDesignPath((string) ($service['collabBackground'] ?? '/assets/media/collaboration-back-visual.png'))),
            'collabImage' => asset(self::mapDesignPath((string) ($service['collabImage'] ?? '/assets/media/collaboration-front-visual.png'))),
            'marqueeIcons' => array_map(
                fn (mixed $icon): string => asset(is_string($icon) ? self::mapDesignPath($icon) : ''),
                $service['marqueeIcons'] ?? self::defaultMarqueeIcons(),
            ),
            'portfolioItems' => self::mapPortfolioItems($service['portfolioImages'] ?? self::defaultPortfolioImages()),
            'introStats' => self::introStats(),
            'industryCards' => self::mapIndustryCards($service['industries'] ?? []),
            'standoutCards' => self::mapStandoutCards($service['standoutCards'] ?? []),
            'processSteps' => self::mapProcessSteps($service['processSteps'] ?? []),
            'articles' => self::articles(),
            'caseStudies' => CaseStudySupport::forService($slug, 6),
            'techStack' => AboutSupport::techStack(),
            'webDevLayoutSlugs' => self::SLUGS,
            'isWebDevelopmentService' => in_array($slug, self::SLUGS, true),
            'capabilitiesAsSlider' => ! empty($service['capabilitiesAsSlider']),
            'capabilitiesGridColumns' => (int) ($service['capabilitiesGridColumns'] ?? 3),
            'useBodyImageLayout' => $useBodyImageLayout,
            'bodySectionStyle' => $useBodyImageLayout
                ? "--service-body-image: url('".e($bodyImage)."');"
                : ($bodyBg !== '' ? "background-image: url('".e($bodyBg)."');" : ''),
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string, 3: string, 4: string}>
     */
    public static function introStats(): array
    {
        return [
            ['50+', 'Projects Delivered', 'Successfully delivered websites, software, CRMs, mobile apps, and digital solutions.', 'assets/icons/projects-delivered-stat-icon.svg', '#4C24F4'],
            ['10+', 'Years Experience', 'Building scalable digital products with modern technologies.', 'assets/icons/years-experience-stat-icon.svg', '#1873E7'],
            ['98%', 'Client Satisfaction', 'Focused on quality, transparency, and long-term partnerships.', 'assets/icons/funding-secured-stat-icon.svg', '#0C7A73'],
            ['15+', 'Expert Team', '15+ passionate developers and management specialists ready to build with you.', 'assets/icons/expert-team-stat-icon.svg', '#C4520D'],
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $industries
     * @return array<int, array{image: string, title: string, text: string, href: string}>
     */
    protected static function mapIndustryCards(array $industries): array
    {
        return array_values(array_map(static function (array $ind): array {
            return [
                'image' => (string) ($ind['icon'] ?? ''),
                'title' => (string) ($ind['title'] ?? ''),
                'text' => (string) ($ind['desc'] ?? ''),
                'href' => self::industryHref($ind),
            ];
        }, $industries));
    }

    /**
     * @param  array<int, array<string, mixed>>  $cards
     * @return array<int, array{image: string, title: string, text: string, step: string}>
     */
    protected static function mapStandoutCards(array $cards): array
    {
        return array_values(array_map(static function (array $card): array {
            return [
                'image' => (string) ($card['icon'] ?? ''),
                'title' => (string) ($card['title'] ?? ''),
                'text' => (string) ($card['desc'] ?? ''),
                'step' => (string) ($card['step'] ?? ''),
            ];
        }, $cards));
    }

    /**
     * @param  array<string, mixed>  $ind
     */
    protected static function industryHref(array $ind): string
    {
        $slug = trim((string) ($ind['slug'] ?? ''));

        if ($slug !== '') {
            return route('industry.show', ['slug' => $slug]);
        }

        return self::resolveInternalHref((string) ($ind['link'] ?? ''));
    }

    protected static function resolveInternalHref(string $href): string
    {
        $href = trim($href);

        if ($href === '' || $href === '#') {
            return $href;
        }

        if (str_starts_with($href, 'http://') || str_starts_with($href, 'https://') || str_starts_with($href, 'mailto:') || str_starts_with($href, 'tel:')) {
            return $href;
        }

        $path = (string) str($href)->before('#')->trim('/');

        return match (true) {
            $path === 'services' => route('services'),
            $path === 'contact-us' => ContactSupport::demoHref(),
            $path === 'blogs' => route('blogs'),
            str_starts_with($path, 'industries/') => route('industry.show', ['slug' => (string) str($path)->after('industries/')]),
            str_starts_with($path, 'services/') => route('service.show', ['slug' => (string) str($path)->after('services/')]),
            str_starts_with($path, 'service/') => route('service.show', ['slug' => (string) str($path)->after('service/')]),
            default => $href,
        };
    }

    /**
     * @param  array<int, array<string, mixed>>  $steps
     * @return array<int, array{step: string, icon: string, title: string, desc: string}>
     */
    protected static function mapProcessSteps(array $steps): array
    {
        $defaultIcons = [
            'assets/media/industry-discovery-strategy.svg',
            'assets/media/industry-design-development.svg',
            'assets/media/industry-goals.svg',
            'assets/media/industry-multi-channel-communication.svg',
            'assets/media/industry-launch-growth.svg',
        ];

        return array_values(array_map(static function (array $step, int $index) use ($defaultIcons): array {
            return [
                'step' => (string) ($step['step'] ?? str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)),
                'icon' => (string) ($step['icon'] ?? $defaultIcons[$index % count($defaultIcons)]),
                'title' => (string) ($step['title'] ?? ''),
                'desc' => (string) ($step['desc'] ?? ''),
            ];
        }, $steps, array_keys($steps)));
    }

    /**
     * @return array<int, string>
     */
    protected static function defaultMarqueeIcons(): array
    {
        return [
            '/assets/media/service-process-step-1.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
            '/assets/media/service-process-step-2.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
            '/assets/media/service-process-step-3.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
            '/assets/media/service-process-step-4.svg',
            '/assets/icons/service-process-step-arrow-icon.svg',
        ];
    }

    /**
     * @return array<int, string>
     */
    protected static function defaultPortfolioImages(): array
    {
        return [
            '/assets/portfolio/swastik-culture-hub-website.webp',
            '/assets/portfolio/mavan-growth-agency-website.webp',
            '/assets/portfolio/sales-automation-project-dashboard.webp',
            '/assets/portfolio/hubops-software-company-website.webp',
            '/assets/portfolio/suave-outreach-crm-laptop.webp',
            '/assets/portfolio/ematrics-ai-sales-website.webp',
        ];
    }

    /**
     * @param  array<int, mixed>  $images
     * @return array<int, array{image: string, url: string, alt: string, external: bool}>
     */
    protected static function mapPortfolioItems(array $images): array
    {
        $byBasename = [];

        foreach (HomeSupport::portfolioShowcaseProjects() as $project) {
            $basename = basename((string) ($project['image'] ?? ''));

            if ($basename !== '') {
                $byBasename[$basename] = $project;
            }
        }

        $items = [];

        foreach ($images as $index => $image) {
            if (! is_string($image) || $image === '') {
                continue;
            }

            $mapped = self::mapDesignPath($image);
            $basename = basename($mapped);
            $project = $byBasename[$basename] ?? null;
            $alt = is_array($project) && is_string($project['alt'] ?? null)
                ? (string) $project['alt']
                : 'Suave Creators project showcase '.($index + 1);
            $url = is_array($project) && is_string($project['url'] ?? null)
                ? (string) $project['url']
                : '';

            $items[] = [
                'image' => asset($mapped),
                'url' => $url,
                'alt' => $alt,
                'external' => is_array($project) ? (bool) ($project['external'] ?? false) : false,
            ];
        }

        return $items;
    }
}
