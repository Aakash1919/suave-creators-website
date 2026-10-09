<?php

namespace App\Support\Frontend;

class TechnologySupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        $faq = self::faq();

        return [
            'bodyClass' => 'min-h-screen bg-white font-sans text-slate-900',
            'mainClass' => 'site-main site-main--technologies',
            'useHeroBackground' => false,
            'eyebrow' => 'Technology stack',
            'heroLead' => 'Technologies &',
            'heroMid' => 'Development Stack for',
            'heroBlue' => 'Web,',
            'heroBlueLine' => 'Mobile and E-commerce',
            'heroPurple' => 'Applications',
            'heroDescriptionBefore' => 'Suave Creators builds custom web applications, mobile apps, enterprise systems, content platforms and e-commerce stores on eight proven technologies: ',
            'heroDescriptionNames' => [
                ['name' => 'Laravel (PHP)', 'separator' => ', '],
                ['name' => 'Node.js', 'separator' => ', '],
                ['name' => 'React & React Native', 'separator' => ', '],
                ['name' => 'Angular', 'separator' => ', '],
                ['name' => 'Vue.js', 'separator' => ', '],
                ['name' => 'WordPress & Headless CMS', 'separator' => ', '],
                ['name' => 'Shopify Plus', 'separator' => ' and '],
                ['name' => 'Magento (Adobe Commerce)', 'separator' => ''],
            ],
            'heroDescriptionAfter' => '. We choose the stack during discovery, based on your data, integrations, traffic and who will maintain the system after launch.',
            'primaryCta' => 'Get a Scoped Estimate',
            'secondaryCta' => 'Hire Developers',
            'bannerBackgroundImage' => 'assets/background/technologies-hero-bg.webp',
            'heroVisualImage' => 'assets/media/hero-technology.webp',
            'heroVisualLabel' => 'Laravel React and ecommerce technology logos with web software development previews',
            'trust' => self::trust(),
            'stack' => self::stack(),
            'backend' => self::backend(),
            'frontend' => self::frontend(),
            'mobile' => self::mobile(),
            'cms' => self::cms(),
            'commerce' => self::commerce(),
            'combinations' => self::combinations(),
            'selection' => self::selection(),
            'why' => self::why(),
            'faq' => $faq,
            'consultation' => self::consultation(),
            'partnerLogos' => self::partnerLogos(),
            'seoBreadcrumbName' => 'Technologies',
            'seoFaqs' => $faq['items'],
            ...self::seoStructuredData(),
        ];
    }

    /**
     * @return list<array{key: string, icon: string, iconAlt: string, lines: list<string>}>
     */
    protected static function trust(): array
    {
        return [
            [
                'key' => 'ownership',
                'icon' => 'assets/icons/ownership-logo.webp',
                'iconAlt' => 'Code and IP ownership icon for custom software development',
                'lines' => ['100% code and', 'IP ownership'],
            ],
            [
                'key' => 'architect',
                'icon' => 'assets/icons/admin-logo.webp',
                'iconAlt' => 'Senior architect access icon for software development services',
                'lines' => ['Direct senior', 'architect access'],
            ],
            [
                'key' => 'sprints',
                'icon' => 'assets/icons/time-sprint-logo.webp',
                'iconAlt' => 'Two-week sprint delivery icon for software development',
                'lines' => ['Transparent', '2-week sprints'],
            ],
        ];
    }

    /**
     * Stack cards below the hero. Each card links to its detail anchor.
     *
     * @return array{eyebrow: string, titleOur: string, titleAccent: string, description: string, items: list<array<string, mixed>>}
     */
    protected static function stack(): array
    {
        return [
            'eyebrow' => 'Full stack',
            'titleOur' => 'Our',
            'titleAccent' => 'Technology Stack',
            'description' => 'Suave Creators uses Laravel and Node.js for back-end development, React, Angular and Vue.js for web front ends, React Native for cross-platform mobile apps, WordPress and headless CMS setups for content platforms, and Shopify Plus and Magento (Adobe Commerce) for e-commerce. Laravel is our primary back-end framework.',
            'items' => [
                self::stackItem('Laravel (PHP)', 'laravel', 'Back end', 'laravel', 'Secure APIs, CRM and ERP platforms, database-heavy business applications', 'Laravel logo for Suave Creators backend development'),
                self::stackItem('Node.js', 'nodejs', 'Back end', 'node', 'Real-time features, WebSockets, microservices, streaming APIs', 'Node.js logo for Suave Creators backend development'),
                self::stackItem('React', 'react', 'Front end', 'react', 'Interactive web interfaces, dashboards, single-page applications', 'React logo for Suave Creators web applications'),
                self::stackItem('React Native', 'react-native', 'Mobile', 'react-native', 'iOS and Android apps from one codebase', 'React Native logo for Suave Creators mobile app development'),
                self::stackItem('Angular', 'angular', 'Front end', 'angular', 'Enterprise administration portals, large structured front ends', 'Angular logo for Suave Creators web development'),
                self::stackItem('Vue.js', 'vuejs', 'Front end', 'vue', 'Lightweight reactive interfaces, progressive single-page applications', 'Vue.js logo for Suave Creators frontend development'),
                self::stackItem('WordPress & Headless CMS', 'wordpress', 'Content', 'wordpress', 'Marketing sites, publishing, decoupled content delivery', 'WordPress logo for Suave Creators content platforms'),
                self::stackItem('Shopify Plus', 'shopify-plus', 'E-commerce', 'shopify', 'High-volume stores, custom themes, headless storefronts', 'Shopify logo for Suave Creators ecommerce development'),
                self::stackItem('Magento (Adobe Commerce)', 'magento', 'E-commerce', 'magento', 'B2B commerce, multi-store and multi-currency catalogs', 'Magento logo for Suave Creators ecommerce development'),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function stackItem(
        string $name,
        string $anchor,
        string $role,
        string $tone,
        string $usage,
        string $logoAlt,
    ): array {
        return [
            'name' => $name,
            'anchor' => $anchor,
            'role' => $role,
            'tone' => $tone,
            'usage' => $usage,
            'logo' => self::logoPath($tone),
            'logoAlt' => $logoAlt,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function backend(): array
    {
        return [
            'backgroundImage' => 'assets/background/technologies-backend-bg.webp',
            'eyebrow' => 'Back end',
            'titleLead' => 'Backend Development:',
            'titleLaravel' => 'Laravel',
            'titleJoin' => 'and',
            'titleNode' => 'Node.js',
            'description' => 'The back end holds your business rules, data and integrations. We use Laravel for most business applications, and Node.js where the workload is dominated by many simultaneous connections or real-time events.',
            'columns' => [
                self::detailColumn(
                    'laravel',
                    'laravel',
                    'Laravel (PHP)',
                    'Laravel logo for Suave Creators backend development',
                    'Laravel is an open-source PHP web framework built on the model-view-controller (MVC) pattern. It ships with routing, the Eloquent ORM, database migrations, queues, authentication and testing tools, so teams spend their time on business logic instead of plumbing. It is Suave Creators\' primary back-end framework.',
                    [
                        'REST APIs that serve web front ends and mobile apps',
                        'Custom CRM and ERP platforms with roles, permissions, workflows and reporting',
                        'Enterprise web applications and customer portals',
                        'Database-driven systems with complex relationships, versioned migrations and background jobs',
                        'Integrations with third-party tools through APIs and webhooks',
                    ],
                    'Laravel suits applications with a lot of business logic and relational data. Its conventions make a codebase predictable for the next developer, migrations keep database changes versioned with the code, and queues move slow work such as imports, emails and AI calls out of the user\'s request. PHP hosting and PHP developers are widely available, which keeps long-term maintenance practical.',
                    'The core of the product is thousands of long-lived real-time connections, such as live chat or vehicle tracking. A common pattern is a Laravel core with a separate Node.js service for the real-time layer.',
                    'React, Vue.js or Angular front ends · React Native apps through Laravel APIs · Node.js services for real-time features',
                ),
                self::detailColumn(
                    'node',
                    'nodejs',
                    'Node.js',
                    'Node.js logo for Suave Creators backend development',
                    'Node.js is an open-source JavaScript runtime built on Google\'s V8 engine. Its event-driven, non-blocking I/O model lets one process handle many simultaneous connections efficiently, which makes it a strong fit for real-time and I/O-heavy workloads.',
                    [
                        'Real-time features over WebSockets: live dashboards, notifications, chat and tracking',
                        'Microservices that split a large system into independently deployable parts',
                        'Lightweight and streaming API back ends, including streamed responses from AI models',
                        'Integration and webhook-processing services',
                    ],
                    'One language, JavaScript or TypeScript, across front end and back end; efficient handling of high concurrency; and the npm ecosystem, which covers almost every integration.',
                    'The work is CPU-heavy, such as large report generation or image processing. Long computations block Node\'s event loop, so they belong in worker threads, a queue or a separate service.',
                    'React, Vue.js and Angular front ends · Laravel back ends · React Native apps',
                ),
            ],
            'chooser' => [
                'title' => 'Laravel or Node.js?',
                'situationHeading' => 'If your application…',
                'choiceHeading' => 'Start with',
                'rows' => [
                    [
                        'icon' => 'database',
                        'situation' => 'Is heavy on business rules and relational data (CRM, ERP, portals)',
                        'note' => '',
                        'picks' => [
                            ['key' => 'laravel', 'name' => 'Laravel', 'logo' => self::logoPath('laravel'), 'logoAlt' => 'Laravel logo for Suave Creators backend development'],
                        ],
                    ],
                    [
                        'icon' => 'live',
                        'situation' => 'Holds many live connections (chat, tracking, live dashboards)',
                        'note' => '',
                        'picks' => [
                            ['key' => 'node', 'name' => 'Node.js', 'logo' => self::logoPath('node'), 'logoAlt' => 'Node.js logo for Suave Creators backend development'],
                        ],
                    ],
                    [
                        'icon' => 'both',
                        'situation' => 'Needs both',
                        'note' => 'Laravel core + Node.js real-time service',
                        'picks' => [
                            ['key' => 'laravel', 'name' => 'Laravel', 'logo' => self::logoPath('laravel'), 'logoAlt' => 'Laravel logo for Suave Creators backend development'],
                            ['key' => 'node', 'name' => 'Node.js', 'logo' => self::logoPath('node'), 'logoAlt' => 'Node.js logo for Suave Creators backend development'],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function frontend(): array
    {
        return [
            'eyebrow' => 'Front end',
            'titleLead' => 'Frontend and Web Application Development:',
            'titleReact' => 'React,',
            'titleAngular' => 'Angular',
            'titleJoin' => 'and',
            'titleVue' => 'Vue.js',
            'description' => 'All three build fast, component-based interfaces. The right one depends on the size of the application, how many teams will work on it, and how much built-in structure you want.',
            'columns' => [
                self::detailColumn(
                    'react',
                    'react',
                    'React',
                    'React logo for Suave Creators frontend development',
                    'React is an open-source JavaScript library, maintained by Meta, for building user interfaces from reusable components. It re-renders only the parts of a page whose data changed, which keeps complex interfaces responsive.',
                    [
                        'Responsive web application front ends and single-page applications',
                        'Dashboards and data-heavy admin screens',
                        'Customer portals',
                        'Front ends for headless CMS and headless commerce builds',
                    ],
                    'The largest ecosystem and hiring pool of the three; it pairs with any API back end; and its component logic carries over to mobile apps through React Native, part of the same React & React Native practice.',
                    '',
                    'Laravel or Node.js APIs · React Native · headless WordPress · Shopify\'s Hydrogen framework, which is built on React',
                ),
                self::detailColumn(
                    'angular',
                    'angular',
                    'Angular',
                    'Angular logo for Suave Creators frontend development',
                    'Angular is an open-source, TypeScript-based front-end framework maintained by Google. Unlike React, it is a complete framework: routing, forms, an HTTP client and built-in dependency injection come as standard, which gives large teams one consistent structure.',
                    [
                        'Complex administration portals',
                        'Internal enterprise tools with many forms, roles and workflows',
                        'Long-lived front ends maintained by several teams',
                    ],
                    'Enforced structure and TypeScript typing reduce drift in large codebases, and modular dependency injection keeps parts testable and replaceable.',
                    'You are building a small interactive site or marketing pages. Angular\'s structure adds overhead there; React or Vue.js is lighter.',
                    '',
                ),
                self::detailColumn(
                    'vue',
                    'vuejs',
                    'Vue.js',
                    'Vue.js logo for Suave Creators frontend development',
                    'Vue.js is an open-source progressive JavaScript framework for building user interfaces. "Progressive" means it can enhance one part of an existing page or scale up to a full single-page application.',
                    [
                        'Lightweight reactive interfaces',
                        'Progressive single-page applications',
                        'Interactive components added to existing server-rendered applications, such as Laravel pages',
                    ],
                    'A gentle learning curve, reactive data binding and single-file components. Vue.js also has a long-standing pairing with Laravel; Laravel\'s official starter kits include a Vue option.',
                    '',
                    '',
                ),
            ],
            'compare' => [
                'headers' => ['React', 'Angular', 'Vue.js'],
                'rows' => [
                    ['label' => 'Type', 'cells' => ['UI library', 'Full framework', 'Progressive framework']],
                    ['label' => 'Language', 'cells' => ['JavaScript or TypeScript', 'TypeScript', 'JavaScript or TypeScript']],
                    ['label' => 'Built-in structure', 'cells' => ['Flexible; you choose routing and state tools', 'Opinionated; routing, forms and dependency injection included', 'Moderate; official router and state tools']],
                    ['label' => 'Best fit', 'cells' => ['Interactive apps, dashboards, shared web and mobile code', 'Large enterprise portals, multi-team codebases', 'Lightweight apps, adding interactivity to existing pages']],
                    ['label' => 'Mobile path', 'cells' => ['React Native', '—', '—']],
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function mobile(): array
    {
        return [
            'backgroundImage' => 'assets/background/technologies-mobile-bg.webp',
            'eyebrow' => 'Mobile app',
            'titleLead' => 'Mobile Application Development with',
            'titleAccent' => 'React Native',
            'name' => 'React Native',
            'logo' => self::logoPath('react-native'),
            'logoAlt' => 'React Native logo for Suave Creators mobile app development',
            'summary' => 'React Native is an open-source framework, created by Meta, for building native iOS and Android apps with React and JavaScript or TypeScript. It renders real native interface components rather than a web page in a wrapper, and most business logic is shared between both platforms.',
            'practice' => 'React Native is the mobile half of our React & React Native practice: the same component patterns, state management and API layer can serve both your web app and your mobile app.',
            'points' => [
                'Cross-platform apps for customers, field teams and sales teams',
                'Mobile companions to web platforms and CRMs',
                'Apps that consume Laravel or Node.js APIs',
            ],
            'whyTitle' => 'Why businesses choose it',
            'why' => 'One codebase for two platforms reduces build and maintenance effort, and native modules can be added when a feature needs direct device access.',
            'consider' => 'The app is dominated by heavy 3D graphics or deep platform-specific hardware features; fully native development may justify its extra cost there.',
            'features' => [
                [
                    'key' => 'platforms',
                    'icon' => 'assets/icons/ios-android-notification-icon.webp',
                    'iconAlt' => 'iOS and Android notification icon for Suave Creators mobile app development',
                    'title' => 'iOS + Android',
                    'text' => 'One codebase targets both platforms natively',
                ],
                [
                    'key' => 'shared',
                    'icon' => 'assets/icons/share-nodes-icon.webp',
                    'iconAlt' => 'Shared logic share icon for Suave Creators React Native development',
                    'title' => 'Shared logic',
                    'text' => 'Business logic shared with your React web app',
                ],
                [
                    'key' => 'native',
                    'icon' => 'assets/icons/native-code-brackets-icon.webp',
                    'iconAlt' => 'Native UI code icon for Suave Creators mobile app development',
                    'title' => 'Native UI',
                    'text' => 'Real native components, not a web view wrapper',
                ],
                [
                    'key' => 'api',
                    'icon' => 'assets/icons/api-first-link-icon.webp',
                    'iconAlt' => 'API-first link icon for Suave Creators mobile backend development',
                    'title' => 'API-first',
                    'text' => 'Connects to any Laravel or Node.js back end',
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function cms(): array
    {
        return [
            'backgroundImage' => 'assets/background/technologies-backend-bg.webp',
            'eyebrow' => 'Content platforms',
            'titleLead' => 'CMS and Content Platforms:',
            'titleWordPress' => 'WordPress',
            'titleJoin' => '&',
            'titleHeadless' => 'Headless CMS',
            'description' => '',
            'columns' => [
                self::detailColumn(
                    'wordpress',
                    'wordpress',
                    'WordPress',
                    'WordPress logo for Suave Creators content platforms',
                    'WordPress is an open-source content management system written in PHP. It lets marketing and content teams publish and update pages without developer involvement.',
                    [
                        'Custom theme engineering for fast, maintainable sites',
                        'Marketing and corporate websites',
                        'Secure enterprise content setups with editorial roles and hardened configuration',
                    ],
                    'A familiar editor for non-technical teams, a large plugin ecosystem, and a PHP base that fits alongside Laravel systems.',
                    'Plugin sprawl is the main source of WordPress security and speed problems. Keep plugins few, maintained and updated.',
                    '',
                    'Watch-out',
                ),
                self::detailColumn(
                    'headless',
                    'headless-cms',
                    'Headless CMS',
                    'Headless CMS logo for Suave Creators content platforms',
                    'A headless CMS stores and manages content but delivers it through an API instead of rendering web pages itself. The front end is a separate application, for example in React or Vue.js. This decoupled architecture lets one content source feed a website, a mobile app and other channels. WordPress can run headless through its REST API, so editors keep the familiar dashboard while the public site is built as a modern front end.',
                    [],
                    '',
                    'The same content must reach several channels, the front end needs full design and performance freedom, or you want the editing system separated from the public site.',
                    'It is a straightforward marketing site managed by a small team; classic WordPress is simpler and cheaper to run.',
                    'Go headless when',
                    'Stay traditional when',
                ),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function commerce(): array
    {
        return [
            'eyebrow' => 'E-commerce',
            'titleLead' => 'E-commerce Platforms:',
            'titleShopify' => 'Shopify Plus',
            'titleJoin' => 'and',
            'titleMagento' => 'Magento (Adobe Commerce)',
            'description' => '',
            'columns' => [
                self::detailColumn(
                    'shopify',
                    'shopify-plus',
                    'Shopify Plus',
                    'Shopify Plus logo for Suave Creators ecommerce development',
                    'Shopify Plus is Shopify\'s enterprise plan for high-volume merchants. Shopify hosts, secures and scales the platform, so your team focuses on the storefront, checkout and integrations rather than servers.',
                    [
                        'Custom Shopify themes',
                        'Custom app integrations with ERP, CRM and inventory systems (Shopify now calls the older "private apps" custom apps)',
                        'Headless storefronts built on the Storefront API, including React-based front ends',
                    ],
                    'No infrastructure to manage, enterprise features for checkout customisation and automation, and a fast path to launch.',
                    'Catalog, pricing and B2B rules are unusually complex, or you need full control of hosting and code. Magento (Adobe Commerce) or a custom platform may fit better.',
                    '',
                ),
                self::detailColumn(
                    'magento',
                    'magento',
                    'Magento (Adobe Commerce)',
                    'Magento logo for Suave Creators ecommerce development',
                    'Magento is an open-source e-commerce platform written in PHP; Adobe Commerce is its commercial edition from Adobe, and Magento Open Source remains the free edition. One installation can run several websites, stores and store views, each with its own currency, language and pricing.',
                    [
                        'Enterprise B2B commerce with company accounts and shared catalogs',
                        'Complex multi-store catalogs',
                        'Multi-currency global retail platforms',
                        'Integrations with ERP and product data systems',
                    ],
                    'Full code-level customisation, a native multi-store structure and extensive B2B features.',
                    'You want minimal hosting and maintenance. Magento needs experienced developers and managed infrastructure; Shopify Plus shifts that work to Shopify.',
                    '',
                ),
            ],
            'compareTitle' => 'Shopify Plus vs Magento (Adobe Commerce)',
            'compare' => [
                'headers' => ['Shopify Plus', 'Magento (Adobe Commerce)'],
                'rows' => [
                    ['label' => 'Hosting', 'cells' => ['Fully hosted by Shopify', 'Self-hosted, or Adobe\'s cloud for Adobe Commerce']],
                    ['label' => 'Customisation', 'cells' => ['Themes, apps, checkout extensions, headless', 'Full code access to every layer']],
                    ['label' => 'B2B', 'cells' => ['Native B2B features', 'Extensive B2B features in Adobe Commerce']],
                    ['label' => 'Multi-store', 'cells' => ['Additional stores under one plan', 'Websites → stores → store views in one installation']],
                    ['label' => 'Best fit', 'cells' => ['High-volume brands that want speed and low maintenance', 'Complex catalogs, B2B buying and global multi-store setups']],
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function combinations(): array
    {
        return [
            'eyebrow' => 'Stack combinations',
            'title' => 'How These Technologies Work Together',
            'description' => 'Most products use more than one of these technologies. These are common combinations and where each leads on our site.',
            'rows' => [
                self::combinationRow('crm', 'Custom CRM or ERP', 'Build scalable systems with complex data, roles and workflows.', [
                    self::combinationPill('laravel', 'Laravel API'),
                    self::combinationPill('react', 'React', '+'),
                    self::combinationPill('vue', 'Vue.js', 'or'),
                ], 'Custom CRM development', 'service.show', ['slug' => 'custom-crm-development']),
                self::combinationRow('portal', 'Enterprise administration portal', 'Run internal tools for roles, approvals and day-to-day operations.', [
                    self::combinationPill('laravel', 'Laravel API'),
                    self::combinationPill('node', 'Node.js', 'or'),
                    self::combinationPill('angular', 'Angular', '+'),
                ], 'Enterprise software solutions', 'service.show', ['slug' => 'enterprise-software-solutions']),
                self::combinationRow('live', 'Real-time tracking or live dashboard', 'Show live status, alerts and tracking on one dashboard.', [
                    self::combinationPill('laravel', 'Laravel'),
                    self::combinationPill('node', 'Node.js', '+'),
                    self::combinationPill('react', 'React', '+'),
                ], 'Logistics and supply chain software', 'industry.show', ['slug' => 'logistics-supply-chain-apps']),
                self::combinationRow('marketing', 'Marketing website your team edits', 'Publish and update campaign pages without a developer.', [
                    self::combinationPill('wordpress', 'WordPress'),
                ], 'Web application development', 'service.show', ['slug' => 'web-development-services']),
                self::combinationRow('content', 'Content across web and mobile', 'Serve the same content on the website and the mobile app.', [
                    self::combinationPill('headless', 'Headless CMS'),
                    self::combinationPill('react', 'React', '+'),
                    self::combinationPill('native', 'React Native', '+'),
                ], 'UI/UX design services', 'service.show', ['slug' => 'ui-ux-design-services']),
                self::combinationRow('store', 'High-volume online store', 'Sell at high volume with a storefront your team can run.', [
                    self::combinationPill('shopify', 'Shopify Plus'),
                    self::combinationPill('react', 'React', 'or'),
                ], 'E-commerce development', 'service.show', ['slug' => 'e-commerce-development']),
                self::combinationRow('catalog', 'B2B or multi-store catalog', 'Manage complex catalogs, B2B buying and ERP-connected stores.', [
                    self::combinationPill('magento', 'Magento'),
                ], 'E-commerce development', 'service.show', ['slug' => 'e-commerce-development']),
                self::combinationRow('ai', 'AI features in an existing product', 'Add model-backed features to a product you already run.', [
                    self::combinationPill('laravel', 'Laravel'),
                    self::combinationPill('node', 'Node.js', 'or'),
                ], 'AI solutions', 'service.show', ['slug' => 'ai-solutions']),
            ],
        ];
    }

    /**
     * @param  list<array{key: string, label: string, join: string, logo: string, logoAlt: string}>  $pills
     * @param  array<string, string>  $serviceParams
     * @return array<string, mixed>
     */
    protected static function combinationRow(string $icon, string $title, string $description, array $pills, string $serviceLabel, string $serviceRoute, array $serviceParams): array
    {
        return [
            'icon' => $icon,
            'title' => $title,
            'description' => $description,
            'pills' => $pills,
            'serviceLabel' => $serviceLabel,
            'serviceRoute' => $serviceRoute,
            'serviceParams' => $serviceParams,
        ];
    }

    /**
     * @return array{key: string, label: string, join: string, logo: string, logoAlt: string}
     */
    protected static function combinationPill(string $key, string $label, string $join = ''): array
    {
        $logoKey = $key === 'native' ? 'react-native' : $key;
        $brand = match ($key) {
            'laravel' => 'Laravel',
            'node' => 'Node.js',
            'react' => 'React',
            'native' => 'React Native',
            'angular' => 'Angular',
            'vue' => 'Vue.js',
            'wordpress' => 'WordPress',
            'headless' => 'Headless CMS',
            'shopify' => 'Shopify',
            'magento' => 'Magento',
            default => $label,
        };

        return [
            'key' => $key,
            'label' => $label,
            'join' => $join,
            'logo' => self::logoPath($logoKey),
            'logoAlt' => $brand.' logo for Suave Creators technology combinations',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function selection(): array
    {
        $marks = [
            'Laravel' => ['laravel', 'Laravel logo for Suave Creators technology stack selection'],
            'Node.js' => ['node', 'Node.js logo for Suave Creators technology stack selection'],
            'React' => ['react', 'React logo for Suave Creators technology stack selection'],
            'Angular' => ['angular', 'Angular logo for Suave Creators technology stack selection'],
            'Vue.js' => ['vue', 'Vue.js logo for Suave Creators technology stack selection'],
            'WordPress' => ['wordpress', 'WordPress logo for Suave Creators technology stack selection'],
            'Shopify' => ['shopify', 'Shopify logo for Suave Creators technology stack selection'],
            'Magento' => ['magento', 'Magento logo for Suave Creators technology stack selection'],
        ];

        $stack = [];

        foreach ($marks as $name => [$key, $alt]) {
            $stack[] = ['name' => $name, 'logo' => self::logoPath($key), 'logoAlt' => $alt];
        }

        return [
            'eyebrow' => 'Stack selection',
            'titleLead' => 'How We Choose a',
            'titleAccent' => 'Technology Stack',
            'description' => 'We choose the stack in the discovery phase, before any production code is written. We map your workflows, data model and technical constraints, then recommend the technologies that fit, with the trade-offs written down.',
            'discoveryTitle' => 'Discovery',
            'discovery' => ['Your goals', 'Workflows', 'Data model', 'Constraints'],
            'stackTitle' => 'Recommended stack',
            'stack' => $stack,
            'resultLead' => 'Right stack.',
            'resultText' => 'Real results.',
            'factors' => [
                ['number' => '01', 'tone' => 'blue', 'icon' => 'database', 'title' => 'Data and business logic.', 'text' => 'Relational, rule-heavy systems favour Laravel; event-heavy systems favour Node.js.'],
                ['number' => '02', 'tone' => 'green', 'icon' => 'bolt', 'title' => 'Real-time and concurrency needs.', 'text' => 'Live updates and many open connections point to a Node.js layer.'],
                ['number' => '03', 'tone' => 'purple', 'icon' => 'pencil', 'title' => 'Who edits content.', 'text' => 'If non-technical teams publish daily, WordPress or a headless CMS belongs in the stack.'],
                ['number' => '04', 'tone' => 'orange', 'icon' => 'puzzle', 'title' => 'Integrations.', 'text' => 'ERP, CRM, payment and inventory systems shape the API design and the commerce platform.'],
                ['number' => '05', 'tone' => 'teal', 'icon' => 'users', 'title' => 'Ownership after launch.', 'text' => 'We favour widely used technologies so your in-house team can hire for and maintain the code you own.'],
                ['number' => '06', 'tone' => 'pink', 'icon' => 'coins', 'title' => 'Total cost of ownership.', 'text' => 'Hosting, platform licences and maintenance effort are compared over several years, not just the build.'],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function why(): array
    {
        return [
            'eyebrow' => 'Why us',
            'title' => 'Build With Suave Creators',
            'items' => [
                [
                    'icon' => 'assets/icons/developers-code-gear-icon.webp',
                    'iconAlt' => 'In-house software developers code gear icon for Suave Creators',
                    'title' => 'Full-time in-house developers',
                    'text' => 'Specialising in Laravel, React, Angular and Node.js, led by senior solution architects.',
                ],
                [
                    'icon' => 'assets/icons/code-ip-ownership-icon.webp',
                    'iconAlt' => 'Code and IP ownership security icon for Suave Creators clients',
                    'title' => '100% code and IP ownership',
                    'text' => 'Repositories and intellectual property belong to you.',
                ],
                [
                    'icon' => 'assets/icons/sprint-calendar-icon.webp',
                    'iconAlt' => 'Two-week sprint calendar icon for Suave Creators delivery',
                    'title' => 'Transparent 2-week sprints',
                    'text' => 'Direct access to the architect and lead developer.',
                ],
                [
                    'icon' => 'assets/icons/documented-decisions-icon.webp',
                    'iconAlt' => 'Documented stack decisions document icon for Suave Creators',
                    'title' => 'Documented stack decisions',
                    'text' => 'Stack decisions documented during discovery, so the reasoning outlives the project.',
                ],
            ],
            'primaryCta' => 'See our case studies',
            'primaryRoute' => 'case-studies',
            'secondaryCta' => 'About our team',
            'secondaryRoute' => 'about-us',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function faq(): array
    {
        return [
            'eyebrow' => 'Frequently Asked Questions',
            'title' => 'Technology FAQs',
            'description' => '',
            'backgroundImage' => 'assets/background/custom-crm-builder-faq-bg.webp',
            'items' => [
                [
                    'question' => 'What technologies does Suave Creators use?',
                    'answer' => 'Suave Creators builds with eight core technologies: Laravel (PHP) and Node.js for back ends, React, Angular and Vue.js for web front ends, React Native for cross-platform mobile apps, WordPress and headless CMS setups for content platforms, and Shopify Plus and Magento (Adobe Commerce) for e-commerce. Laravel is our primary back-end framework.',
                ],
                [
                    'question' => 'Which technology is best for an enterprise web application?',
                    'answer' => 'No single technology is best; the right choice depends on data complexity, real-time needs, integrations and who will maintain the system. For business-logic-heavy applications with relational data, a Laravel back end with an Angular or React front end is a common, maintainable choice, with Node.js added for real-time features.',
                ],
                [
                    'question' => 'What is Laravel used for?',
                    'answer' => 'Laravel is a PHP framework used to build web applications, REST APIs and database-driven business systems such as CRMs, ERPs and customer portals. It includes routing, an ORM, database migrations, queues and authentication, which speeds up the development of secure, maintainable back ends.',
                ],
                [
                    'question' => 'Why use React for web development?',
                    'answer' => 'React builds interfaces from reusable components and re-renders only what changes, so complex screens such as dashboards stay responsive. It has one of the largest ecosystems and developer pools, works with any API back end, and its patterns carry over to mobile apps through React Native.',
                ],
                [
                    'question' => 'What is React Native used for?',
                    'answer' => 'React Native is used to build native iOS and Android apps from one JavaScript or TypeScript codebase. It renders native interface components and shares business logic across both platforms, which reduces development and maintenance effort compared with two separate native apps.',
                ],
                [
                    'question' => 'What is Angular used for?',
                    'answer' => 'Angular is a TypeScript framework used for large, structured front ends such as enterprise administration portals and internal tools. It includes routing, forms, an HTTP client and dependency injection, giving several teams one consistent architecture across a long-lived codebase.',
                ],
                [
                    'question' => 'What is Node.js used for?',
                    'answer' => 'Node.js is a JavaScript runtime used for back-end services that handle many simultaneous connections, such as real-time dashboards, chat and notifications over WebSockets, microservices and streaming APIs. Its event-driven, non-blocking model makes it efficient for I/O-heavy workloads.',
                ],
                [
                    'question' => 'What is Vue.js used for?',
                    'answer' => 'Vue.js is a progressive JavaScript framework used to build reactive user interfaces, from small interactive components added to existing pages to full single-page applications. It is known for a gentle learning curve and works well alongside Laravel.',
                ],
                [
                    'question' => 'What is a headless CMS?',
                    'answer' => 'A headless CMS manages content but delivers it through an API instead of rendering web pages. The front end is built separately, for example in React or Vue.js, so the same content can feed a website, a mobile app and other channels. WordPress can run as a headless CMS through its REST API.',
                ],
                [
                    'question' => 'What is Shopify Plus?',
                    'answer' => 'Shopify Plus is Shopify\'s enterprise plan for high-volume merchants. Shopify hosts and scales the platform, while merchants customise themes, checkout and integrations, and can build headless storefronts through the Storefront API.',
                ],
                [
                    'question' => 'What is Magento (Adobe Commerce)?',
                    'answer' => 'Magento is an open-source PHP e-commerce platform, and Adobe Commerce is its commercial edition from Adobe. It is used for complex commerce: B2B buying, large catalogs, and multiple stores, currencies and languages from one installation.',
                ],
                [
                    'question' => 'How do you choose a technology stack for a business application?',
                    'answer' => 'Start from requirements, not frameworks: the data model and business logic, real-time needs, content editing, integrations, expected scale and who will maintain the code. At Suave Creators, we make this decision during discovery and document the trade-offs before development begins.',
                ],
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected static function consultation(): array
    {
        return [
            'eyebrow' => 'Get started',
            'title' => 'Discuss Your Technology Stack With a Solution Architect',
            'description' => 'Tell us what you\'re building and what you run today. A solution architect will recommend a stack, explain the trade-offs and give you a scoped estimate, whether you need a full project team or developers who join yours.',
            'ctaLabel' => 'Get a Scoped Estimate',
            'secondaryCtaLabel' => 'Hire Developers',
            'cardPosition' => 'center',
        ];
    }

    /**
     * @return array<int, array{src: string, alt: string}>
     */
    protected static function partnerLogos(): array
    {
        return array_values(array_filter(
            HomeSupport::partnerMarqueeItems(),
            static fn (array $item): bool => ! str_contains((string) ($item['src'] ?? ''), 'turbo-trans')
        ));
    }

    /**
     * Brand mark for a stack key. Missing files stay empty so the Blade placeholder renders.
     */
    protected static function logoPath(string $key): string
    {
        $relative = match ($key) {
            'laravel' => 'assets/icons/tech/laravel-mark-logo.svg',
            'node' => 'assets/icons/tech/nodedotjs.svg',
            'react', 'react-native' => 'assets/icons/tech/react.svg',
            'angular' => 'assets/icons/tech/angular.svg',
            'vue' => 'assets/icons/tech/vuedotjs.svg',
            'wordpress' => 'assets/icons/tech/wordpress.svg',
            'headless' => 'assets/icons/tech/cms-speech-bubble-logo.webp',
            'shopify' => 'assets/icons/tech/shopify-technology-icon.png',
            'magento' => 'assets/icons/tech/magento.svg',
            default => '',
        };

        if ($relative === '' || ! is_file(public_path($relative))) {
            return '';
        }

        return $relative;
    }

    /**
     * @param  list<string>  $builds
     * @return array<string, mixed>
     */
    protected static function detailColumn(
        string $key,
        string $id,
        string $name,
        string $logoAlt,
        string $summary,
        array $builds,
        string $why,
        string $consider,
        string $works,
        string $considerLabel = 'Consider a different fit when',
        string $worksLabel = 'Works with',
    ): array {
        return [
            'key' => $key,
            'id' => $id,
            'name' => $name,
            'logo' => self::logoPath($key),
            'logoAlt' => $logoAlt,
            'summary' => $summary,
            'builds' => $builds,
            'why' => $why,
            'consider' => $consider,
            'considerLabel' => $considerLabel,
            'works' => $works,
            'worksLabel' => $worksLabel,
        ];
    }

    /**
     * Extra JSON-LD nodes for the technology list. FAQ answers travel through seoFaqs.
     *
     * @return array{seoJsonLdGraph: list<array<string, mixed>>, seoJsonLdAbout: list<array<string, string>>, seoJsonLdMainEntity: string}
     */
    protected static function seoStructuredData(): array
    {
        $pageUrl = rtrim(route('technologies'), '/');
        $listId = $pageUrl.'#technology-list';
        $organizationId = rtrim((string) config('app.url', url('/')), '/').'/#organization';

        $services = [
            ['id' => 'laravel-development', 'anchor' => 'laravel', 'name' => 'Laravel (PHP) development', 'serviceType' => 'Laravel development', 'description' => 'REST APIs, custom CRM and ERP platforms, enterprise web applications and database-driven systems built with Laravel.'],
            ['id' => 'nodejs-development', 'anchor' => 'nodejs', 'name' => 'Node.js development', 'serviceType' => 'Node.js development', 'description' => 'Real-time WebSocket features, microservices and streaming API back ends built with Node.js.'],
            ['id' => 'react-development', 'anchor' => 'react', 'name' => 'React development', 'serviceType' => 'React development', 'description' => 'Responsive web application front ends, dashboards and customer portals built with React.'],
            ['id' => 'react-native-development', 'anchor' => 'react-native', 'name' => 'React Native app development', 'serviceType' => 'Cross-platform mobile app development', 'description' => 'Cross-platform iOS and Android apps built with React Native.'],
            ['id' => 'angular-development', 'anchor' => 'angular', 'name' => 'Angular development', 'serviceType' => 'Angular development', 'description' => 'Enterprise administration portals and structured TypeScript front ends built with Angular.'],
            ['id' => 'vuejs-development', 'anchor' => 'vuejs', 'name' => 'Vue.js development', 'serviceType' => 'Vue.js development', 'description' => 'Lightweight reactive interfaces and progressive single-page applications built with Vue.js.'],
            ['id' => 'wordpress-development', 'anchor' => 'wordpress', 'name' => 'WordPress and headless CMS development', 'serviceType' => 'WordPress development', 'description' => 'Custom WordPress themes, decoupled publishing environments and secure enterprise content setups.'],
            ['id' => 'shopify-plus-development', 'anchor' => 'shopify-plus', 'name' => 'Shopify Plus development', 'serviceType' => 'Shopify Plus development', 'description' => 'Custom Shopify themes, custom app integrations and headless storefronts for high-volume merchants.'],
            ['id' => 'magento-development', 'anchor' => 'magento', 'name' => 'Magento (Adobe Commerce) development', 'serviceType' => 'Magento development', 'description' => 'Enterprise B2B commerce, multi-store catalogs and multi-currency retail platforms on Magento (Adobe Commerce).'],
        ];

        $items = [];

        foreach ($services as $position => $service) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position + 1,
                'item' => [
                    '@type' => 'Service',
                    '@id' => $pageUrl.'#'.$service['id'],
                    'name' => $service['name'],
                    'serviceType' => $service['serviceType'],
                    'url' => $pageUrl.'#'.$service['anchor'],
                    'description' => $service['description'],
                    'provider' => ['@id' => $organizationId],
                ],
            ];
        }

        return [
            'seoJsonLdGraph' => [[
                '@type' => 'ItemList',
                '@id' => $listId,
                'name' => 'Suave Creators technology stack',
                'numberOfItems' => count($services),
                'itemListElement' => $items,
            ]],
            'seoJsonLdAbout' => [
                ['@type' => 'Thing', 'name' => 'Laravel', 'sameAs' => 'https://en.wikipedia.org/wiki/Laravel'],
                ['@type' => 'Thing', 'name' => 'PHP', 'sameAs' => 'https://en.wikipedia.org/wiki/PHP'],
                ['@type' => 'Thing', 'name' => 'Node.js', 'sameAs' => 'https://en.wikipedia.org/wiki/Node.js'],
                ['@type' => 'Thing', 'name' => 'React', 'sameAs' => 'https://en.wikipedia.org/wiki/React_(software)'],
                ['@type' => 'Thing', 'name' => 'React Native', 'sameAs' => 'https://en.wikipedia.org/wiki/React_Native'],
                ['@type' => 'Thing', 'name' => 'Angular', 'sameAs' => 'https://en.wikipedia.org/wiki/Angular_(web_framework)'],
                ['@type' => 'Thing', 'name' => 'Vue.js', 'sameAs' => 'https://en.wikipedia.org/wiki/Vue.js'],
                ['@type' => 'Thing', 'name' => 'WordPress', 'sameAs' => 'https://en.wikipedia.org/wiki/WordPress'],
                ['@type' => 'Thing', 'name' => 'Headless content management system', 'sameAs' => 'https://en.wikipedia.org/wiki/Headless_content_management_system'],
                ['@type' => 'Thing', 'name' => 'Shopify', 'sameAs' => 'https://en.wikipedia.org/wiki/Shopify'],
                ['@type' => 'Thing', 'name' => 'Magento', 'sameAs' => 'https://en.wikipedia.org/wiki/Magento'],
            ],
            'seoJsonLdMainEntity' => $listId,
        ];
    }
}
