<?php

namespace App\Support\Frontend;

class TechnologySupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return [
            'bodyClass' => 'min-h-screen bg-white font-sans text-slate-900',
            'mainClass' => 'site-main site-main--technologies',
            'useHeroBackground' => false,
            'demoHref' => ContactSupport::demoHref(),
            'eyebrow' => 'Technology stack',
            'heroLead' => 'Technologies &',
            'heroMid' => 'Development Stack for',
            'heroBlue' => 'Web,',
            'heroBlueLine' => 'Mobile and E-commerce',
            'heroPurple' => 'Applications',
            'heroDescription' => 'Suave Creators builds custom web applications, mobile apps, enterprise systems, content platforms and e-commerce stores on eight proven technologies: Laravel (PHP), Node.js, React & React Native, Angular, Vue.js, WordPress & Headless CMS, Shopify Plus and Magento (Adobe Commerce). We choose the stack during discovery, based on your data, integrations, traffic and who will maintain the system after launch.',
            'primaryCta' => 'Get Free Consultation',
            'secondaryCta' => 'Hire Developers',
            'logos' => self::logos(),
            'devices' => self::devices(),
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
            'faq' => self::faq(),
            'consultation' => self::consultation(),
            'partnerLogos' => self::partnerLogos(),
            'seoBreadcrumbName' => 'Technologies',
        ];
    }

    /**
     * @return list<array{label: string, src: string, alt: string}>
     */
    protected static function logos(): array
    {
        return [
            ['label' => 'Laravel', 'src' => 'assets/icons/tech/laravel-mark-logo.svg', 'alt' => 'Laravel logo for Suave Creators web development'],
            ['label' => 'Node.js', 'src' => 'assets/icons/tech/nodedotjs.svg', 'alt' => 'Node.js logo for Suave Creators backend development'],
            ['label' => 'React', 'src' => 'assets/icons/tech/react-color-logo.svg', 'alt' => 'React logo for Suave Creators web applications'],
            ['label' => 'Angular', 'src' => 'assets/icons/tech/angular-color-logo.svg', 'alt' => 'Angular logo for Suave Creators web development'],
            ['label' => 'Vue.js', 'src' => 'assets/icons/tech/vue-color-logo.svg', 'alt' => 'Vue.js logo for Suave Creators frontend development'],
            ['label' => 'WordPress', 'src' => 'assets/icons/tech/wordpress.svg', 'alt' => 'WordPress CMS logo for Suave Creators content platforms'],
            ['label' => 'Shopify', 'src' => 'assets/icons/tech/shopify-technology-icon.png', 'alt' => 'Shopify logo for Suave Creators ecommerce development'],
            ['label' => 'Magento', 'src' => 'assets/icons/tech/magento.svg', 'alt' => 'Magento ecommerce logo for Suave Creators'],
        ];
    }

    /**
     * Device screens. Leave image empty until the final assets/media file is set.
     *
     * @return list<array{slot: string, label: string, image: string}>
     */
    protected static function devices(): array
    {
        return [
            [
                'slot' => 'tablet',
                'label' => 'Tablet preview of Suave Creators web and mobile applications',
                'image' => '',
            ],
            [
                'slot' => 'laptop',
                'label' => 'Laptop preview of Suave Creators web development stack',
                'image' => '',
            ],
            [
                'slot' => 'phone',
                'label' => 'Phone preview of Suave Creators mobile applications',
                'image' => '',
            ],
        ];
    }

    /**
     * @return list<array{key: string, lines: list<string>}>
     */
    protected static function trust(): array
    {
        return [
            ['key' => 'ownership', 'lines' => ['100% code and', 'IP ownership']],
            ['key' => 'architect', 'lines' => ['Direct senior', 'architect access']],
            ['key' => 'sprints', 'lines' => ['Transparent', '2-week sprints']],
        ];
    }

    /**
     * Stack cards below the hero. Leave logo empty until the final file is set.
     *
     * @return array{eyebrow: string, title: string, description: string, items: list<array{name: string, role: string, tone: string, usage: string, logo: string, logoAlt: string, serviceLabel: string, serviceRoute: string, serviceParams: array<string, string>}>}
     */
    protected static function stack(): array
    {
        $usage = 'Secure APIs, CRM and ERP platforms, database-heavy business applications.';
        $service = [
            'serviceLabel' => 'Web Application Development',
            'serviceRoute' => 'service.show',
            'serviceParams' => ['slug' => 'web-development-services'],
        ];

        return [
            'eyebrow' => 'Full stack',
            'title' => 'Our Technology Stack',
            'description' => 'Suave Creators uses Laravel and Node.js for back-end development, React, Angular and Vue.js for web front ends, React Native for cross-platform mobile apps, WordPress and headless CMS setups for content platforms, and Shopify Plus and Magento (Adobe Commerce) for e-commerce. Laravel is our primary back-end framework.',
            'items' => [
                self::stackItem('Laravel', 'Back end', 'laravel', $usage, 'Laravel logo for Suave Creators backend development', $service),
                self::stackItem('Node.js', 'Back end', 'node', $usage, 'Node.js logo for Suave Creators backend development', $service),
                self::stackItem('React', 'Front end', 'react', $usage, 'React logo for Suave Creators web applications', $service),
                self::stackItem('React Native', 'Mobile', 'react', $usage, 'React Native logo for Suave Creators mobile app development', $service),
                self::stackItem('Angular', 'Front end', 'angular', $usage, 'Angular logo for Suave Creators web development', $service),
                self::stackItem('Vue.js', 'Front end', 'vue', $usage, 'Vue.js logo for Suave Creators frontend development', $service),
                self::stackItem('WordPress', 'Content', 'wordpress', $usage, 'WordPress logo for Suave Creators content platforms', $service),
                self::stackItem('Shopify', 'E-commerce', 'shopify', $usage, 'Shopify logo for Suave Creators ecommerce development', $service),
                self::stackItem('Magento', 'E-commerce', 'magento', $usage, 'Magento logo for Suave Creators ecommerce development', $service),
            ],
        ];
    }

    /**
     * @param  array{serviceLabel: string, serviceRoute: string, serviceParams: array<string, string>}  $service
     * @return array{name: string, role: string, tone: string, usage: string, logo: string, logoAlt: string, serviceLabel: string, serviceRoute: string, serviceParams: array<string, string>}
     */
    protected static function stackItem(string $name, string $role, string $tone, string $usage, string $logoAlt, array $service): array
    {
        return [
            'name' => $name,
            'role' => $role,
            'tone' => $tone,
            'usage' => $usage,
            'logo' => '',
            'logoAlt' => $logoAlt,
            ...$service,
        ];
    }

    /**
     * Backend comparison below the stack grid. Leave logo empty until the final file is set.
     *
     * @return array<string, mixed>
     */
    protected static function backend(): array
    {
        $builds = [
            'REST APIs that serve web front ends and mobile apps.',
            'Custom CRM and ERP platforms with roles, permissions, workflows and reporting.',
            'Enterprise web applications and customer portals.',
            'Database-driven systems with complex relationships, versioned migrations and background jobs.',
            'Integrations with third-party tools through APIs and webhooks.',
        ];

        $consider = 'The core of the product is thousands of long-lived real-time connections, such as live chat or vehicle tracking. A common pattern is a Laravel core with a separate Node.js service for the real-time layer.';
        $works = 'React, Vue.js or Angular front ends · React Native apps through Laravel APIs · Node.js services for real-time features';

        return [
            'eyebrow' => 'Back end',
            'titleLead' => 'Backend Development:',
            'titleLaravel' => 'Laravel',
            'titleJoin' => 'and',
            'titleNode' => 'Node.js',
            'description' => 'The back end holds your business rules, data and integrations. We use Laravel for most business applications, and Node.js where the workload is dominated by many simultaneous connections or real-time events.',
            'columns' => [
                [
                    'key' => 'laravel',
                    'name' => 'Laravel',
                    'logo' => '',
                    'logoAlt' => 'Laravel logo for Suave Creators backend development',
                    'summary' => 'Laravel is an open-source PHP web framework built on the MVC pattern. It ships with routing, the Eloquent ORM, database migrations, queues, authentication and testing tools, so teams spend their time on business logic instead of plumbing. It is Suave Creators\' primary back-end framework.',
                    'builds' => $builds,
                    'why' => 'Laravel suits applications with a lot of business logic and relational data. Its conventions make a codebase predictable for the next developer, migrations keep database changes versioned with the code, and queues move slow work such as imports, emails and AI calls out of the user\'s request.',
                    'consider' => $consider,
                    'works' => $works,
                ],
                [
                    'key' => 'node',
                    'name' => 'Node.js',
                    'logo' => '',
                    'logoAlt' => 'Node.js logo for Suave Creators backend development',
                    'summary' => 'Node.js is an open-source JavaScript runtime built on Google\'s V8 engine. Its event-driven, non-blocking I/O model lets one process handle many simultaneous connections efficiently, which makes it a strong fit for real-time and I/O-heavy workloads.',
                    'builds' => $builds,
                    'why' => 'Node.js suits products that keep many connections open at once, such as live chat, tracking and dashboards. One process can serve those connections without a thread per user, and the same JavaScript used on the front end can run in the real-time service.',
                    'consider' => $consider,
                    'works' => $works,
                ],
            ],
            'chooser' => [
                'situationHeading' => 'If your application...',
                'choiceHeading' => 'Start with',
                'rows' => [
                    [
                        'icon' => 'database',
                        'situation' => 'Is heavy on business rules and relational data (CRM, ERP, portals)',
                        'note' => '',
                        'picks' => [
                            ['key' => 'laravel', 'name' => 'Laravel', 'logo' => '', 'logoAlt' => 'Laravel logo for Suave Creators backend development'],
                        ],
                    ],
                    [
                        'icon' => 'live',
                        'situation' => 'Holds many live connections (chat, tracking, live dashboards)',
                        'note' => '',
                        'picks' => [
                            ['key' => 'node', 'name' => 'Node.js', 'logo' => '', 'logoAlt' => 'Node.js logo for Suave Creators backend development'],
                        ],
                    ],
                    [
                        'icon' => 'both',
                        'situation' => 'Needs both',
                        'note' => 'Laravel core + Node.js real-time service',
                        'picks' => [
                            ['key' => 'laravel', 'name' => 'Laravel', 'logo' => '', 'logoAlt' => 'Laravel logo for Suave Creators backend development'],
                            ['key' => 'node', 'name' => 'Node.js', 'logo' => '', 'logoAlt' => 'Node.js logo for Suave Creators backend development'],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Frontend comparison below the backend section. Leave logo empty until the final file is set.
     *
     * @return array<string, mixed>
     */
    protected static function frontend(): array
    {
        $builds = [
            'Responsive web application front ends and single-page applications',
            'Dashboards and data-heavy admin screens',
            'Customer portals',
            'Front ends for headless CMS and headless commerce builds',
        ];
        $works = 'Laravel or Node.js APIs · React Native · headless WordPress · Shopify\'s Hydrogen framework';

        return [
            'eyebrow' => 'Front end',
            'titleLead' => 'Frontend Development:',
            'titleReact' => 'React,',
            'titleAngular' => 'Angular',
            'titleJoin' => 'and',
            'titleVue' => 'Vue.js',
            'description' => 'All three build fast, component-based interfaces. The right one depends on the size of the application, how many teams will work on it, and how much built-in structure you want.',
            'columns' => [
                [
                    'key' => 'react',
                    'name' => 'React',
                    'logo' => '',
                    'logoAlt' => 'React logo for Suave Creators frontend development',
                    'summary' => 'React is an open-source JavaScript library, maintained by Meta, for building user interfaces from reusable components. It re-renders only the parts of a page whose data changed, which keeps complex interfaces responsive.',
                    'builds' => $builds,
                    'why' => 'The largest ecosystem and hiring pool of the three. It pairs with any API back end, and its component logic carries over to mobile apps through React Native.',
                    'consider' => 'The product needs routing, forms, and dependency injection decided for every team, or many squads will share one large portal. Angular includes that structure. A small page that only needs a little interactivity is a closer fit for Vue.js.',
                    'works' => $works,
                ],
                [
                    'key' => 'angular',
                    'name' => 'Angular',
                    'logo' => '',
                    'logoAlt' => 'Angular logo for Suave Creators frontend development',
                    'summary' => 'Angular is an open-source framework, maintained by Google, for building large applications in TypeScript. Routing, forms, and dependency injection ship with the framework, so teams follow one structure instead of assembling it.',
                    'builds' => $builds,
                    'why' => 'A full framework with TypeScript as the default. Routing, forms, and dependency injection are included, which keeps large enterprise portals and multi-team codebases consistent.',
                    'consider' => 'The interface is a smaller interactive app, or the mobile product should share the web component code. React is the closer fit then, and Vue.js is lighter when the page only needs a modest amount of structure.',
                    'works' => $works,
                ],
                [
                    'key' => 'vue',
                    'name' => 'Vue.js',
                    'logo' => '',
                    'logoAlt' => 'Vue.js logo for Suave Creators frontend development',
                    'summary' => 'Vue.js is an open-source progressive framework for building user interfaces. It can enhance an existing page or, with its official router and state tools, run a complete application without a large prescribed structure.',
                    'builds' => $builds,
                    'why' => 'Enough official structure for routing and state, without forcing a large framework on a small product. It is a strong fit for lightweight apps and for adding interactivity to pages that already exist.',
                    'consider' => 'Many teams need one opinionated structure, or the mobile app should share the web UI code. Angular fits the first case, and React Native fits the second.',
                    'works' => $works,
                ],
            ],
            'compare' => [
                'headers' => ['React', 'Angular', 'Vue.js'],
                'rows' => [
                    ['label' => 'Type', 'cells' => ['UI library', 'Full framework', 'Progressive framework']],
                    ['label' => 'Language', 'cells' => ['JS or TypeScript', 'TypeScript', 'JS or TypeScript']],
                    ['label' => 'Built-in structure', 'cells' => ['Flexible; you choose routing and state tools', 'Opinionated: routing, forms and DI included', 'Moderate; official router and state tools']],
                    ['label' => 'Best fit', 'cells' => ['Interactive apps, dashboards, shared web and mobile code', 'Large enterprise portals, multi-team codebases', 'Lightweight apps, adding interactivity to existing pages']],
                    ['label' => 'Mobile path', 'cells' => ['React native', '—', '—']],
                ],
            ],
        ];
    }

    /**
     * React Native block below the frontend comparison. Leave logo empty until the final file is set.
     *
     * @return array<string, mixed>
     */
    protected static function mobile(): array
    {
        return [
            'eyebrow' => 'Mobile app',
            'titleLead' => 'Mobile Application Development with',
            'titleAccent' => 'React Native',
            'name' => 'React Native',
            'logo' => '',
            'logoAlt' => 'React Native logo for Suave Creators mobile app development',
            'summary' => 'React Native is an open-source framework, created by Meta, for building native iOS and Android apps with React and JavaScript or TypeScript. It renders real native interface components rather than a web page in a wrapper, and most business logic is shared between both platforms.',
            'practice' => 'React Native is the mobile half of our React & React Native practice: the same component patterns, state management and API layer can serve both your web app and your mobile app.',
            'points' => [
                'Cross-platform apps for customers, field teams and sales teams.',
                'Mobile companions to web platforms and CRMs.',
                'Apps that consume Laravel or Node.js APIs.',
            ],
            'whyTitle' => 'Why business choose it',
            'why' => 'One codebase for two platforms reduces build and maintenance effort, and native modules can be added when a feature needs direct device access.',
            'features' => [
                [
                    'key' => 'platforms',
                    'title' => 'iOS + Android',
                    'text' => 'One codebase targets both platforms natively',
                ],
                [
                    'key' => 'shared',
                    'title' => 'Shared logic',
                    'text' => 'Business logic shared with your React web app',
                ],
                [
                    'key' => 'native',
                    'title' => 'Native UI',
                    'text' => 'Real native components, not a web view wrapper',
                ],
                [
                    'key' => 'api',
                    'title' => 'API-first',
                    'text' => 'Connects to any Laravel or Node.js back end',
                ],
            ],
        ];
    }

    /**
     * CMS block below the React Native section. Leave logo empty until the final file is set.
     *
     * @return array<string, mixed>
     */
    protected static function cms(): array
    {
        return [
            'eyebrow' => 'Content platforms',
            'titleLead' => 'CMS and Content Platforms:',
            'titleWordPress' => 'WordPress',
            'titleJoin' => '&',
            'titleHeadless' => 'Headless CMS',
            'description' => 'Content platforms are where editors publish and where the public site stays fast. We use WordPress when the team wants a familiar editor, and a headless CMS when the same content should feed a separate web or mobile front end.',
            'columns' => [
                [
                    'key' => 'wordpress',
                    'name' => 'WordPress & Headless CMS',
                    'logo' => '',
                    'logoAlt' => 'WordPress logo for Suave Creators content platforms',
                    'summary' => 'WordPress is an open-source content platform. Editors publish pages, posts, and media in a familiar admin. We can keep the public site on a custom theme, or expose the same content through a headless API to a React, Vue, or mobile front end.',
                    'builds' => [
                        'Marketing sites, blogs, and resource libraries with a familiar editor.',
                        'Custom themes, blocks, and editorial workflows.',
                        'Role-based publishing for marketing and content teams.',
                        'SEO-ready page structures and media libraries.',
                        'Headless WordPress when the front end is built separately.',
                    ],
                    'why' => 'Editors already know the WordPress admin. Roles, revisions, and a large plugin ecosystem keep a content site moving, and a headless setup is available when the public experience should be a custom front end.',
                    'consider' => 'The content model is highly custom, or the product is an application first and a website second. A dedicated headless CMS, or a Laravel-built platform, is the closer fit.',
                    'works' => 'React, Vue.js or Angular front ends · React Native apps · Laravel or Node.js APIs · Shopify when commerce sits beside the content',
                ],
                [
                    'key' => 'headless',
                    'name' => 'Headless CMS',
                    'logo' => '',
                    'logoAlt' => 'Headless CMS logo for Suave Creators content platforms',
                    'summary' => 'A headless CMS stores content and delivers it through an API. The website, app, or storefront is built separately, so the same pages and articles can feed more than one channel without a theme rendering the page.',
                    'builds' => [
                        'Content APIs for the website, a mobile app, and other channels.',
                        'Editorial models for pages, articles, and campaigns.',
                        'Draft, preview, and publish workflows for marketing teams.',
                        'Front ends in React, Vue.js, or Angular.',
                        'Publishing that stays independent of the presentation layer.',
                    ],
                    'why' => 'The content model stays stable while the front end can change. One API can feed the website and a mobile app, and page speed is not tied to a theme render.',
                    'consider' => 'The team wants to write and publish in the same place the site is rendered, with themes and plugins, and does not need a separate front end. Traditional WordPress is simpler.',
                    'works' => 'React, Vue.js or Angular front ends · React Native apps · Laravel or Node.js APIs · Shopify storefronts beside the content',
                ],
            ],
        ];
    }

    /**
     * E-commerce block below the CMS section. Leave logo empty until the final file is set.
     *
     * @return array<string, mixed>
     */
    protected static function commerce(): array
    {
        return [
            'eyebrow' => 'E-commerce',
            'titleLead' => 'E-commerce Platforms:',
            'titleShopify' => 'Shopify Plus',
            'titleJoin' => 'and',
            'titleMagento' => 'Magento',
            'description' => 'Both run a serious store. Shopify Plus is the hosted path when speed and low maintenance matter. Magento, including Adobe Commerce, is the path when the catalog, checkout, or B2B rules need full code access.',
            'columns' => [
                [
                    'key' => 'shopify',
                    'name' => 'Shopify Plus',
                    'logo' => '',
                    'logoAlt' => 'Shopify Plus logo for Suave Creators ecommerce development',
                    'summary' => 'Shopify Plus is Shopify’s hosted commerce platform for high-volume brands. Themes, apps, and checkout extensions cover most custom work, and the store stays on Shopify’s infrastructure.',
                    'builds' => [
                        'High-volume storefronts fully hosted by Shopify.',
                        'Themes, apps, checkout extensions, and headless storefronts.',
                        'Native B2B company accounts and catalogs.',
                        'Additional stores under one Plus plan.',
                        'Checkout and merchandising that stay easy to operate.',
                    ],
                    'why' => 'The platform is hosted, so the team spends time on merchandising instead of servers. Plus adds checkout control, B2B features, and room for more than one store without a separate install.',
                    'consider' => 'The catalog, pricing, or checkout needs behavior Shopify will not allow, or the business wants to own every layer of the code. Magento is the closer fit.',
                    'works' => 'Hydrogen or a custom React storefront · Laravel or Node.js services · headless WordPress for content · ERP and payment integrations',
                ],
                [
                    'key' => 'magento',
                    'name' => 'Magento (Adobe Commerce)',
                    'logo' => '',
                    'logoAlt' => 'Magento logo for Suave Creators ecommerce development',
                    'summary' => 'Magento, and Adobe Commerce, is an open commerce platform with full code access. One install can hold websites, stores, and store views, which suits complex catalogs and global B2B buying.',
                    'builds' => [
                        'Self-hosted stores, or Adobe Commerce on Adobe’s cloud.',
                        'Custom catalog, checkout, and admin behavior in code.',
                        'B2B quotes, company accounts, and shared catalogs.',
                        'Websites, stores, and store views in one install.',
                        'Global multi-store catalogs with local pricing and language.',
                    ],
                    'why' => 'Nothing in the stack is locked to a hosted checkout. Complex catalogs, B2B buying rules, and a global multi-store model can live in one codebase the team owns.',
                    'consider' => 'The priority is a fast launch and low maintenance, and the catalog fits a hosted platform. Shopify Plus is the closer fit.',
                    'works' => 'Custom React, Vue.js, or Hyvä-style storefronts · Laravel or Node.js services · ERP and PIM integrations · headless content beside the catalog',
                ],
            ],
            'compare' => [
                'headers' => ['Shopify Plus', 'Magento (Adobe Commerce)'],
                'rows' => [
                    ['label' => 'Hosting', 'cells' => ['Fully hosted by Shopify', 'Self-hosted, or Adobe cloud for Adobe Commerce']],
                    ['label' => 'Customisation', 'cells' => ['Themes, apps, checkout extensions, headless', 'Full code access to every layer']],
                    ['label' => 'B2B', 'cells' => ['Native B2B features', 'Extensive B2B features in Adobe Commerce']],
                    ['label' => 'Multi-store', 'cells' => ['Additional stores under one plan', 'Websites, stores, and store views in one install']],
                    ['label' => 'Best fit', 'cells' => ['High-volume brands that want speed and low maintenance', 'Complex catalogs, B2B buying and global multi-store']],
                ],
            ],
        ];
    }

    /**
     * Combination table below the e-commerce section. Leave logo empty until the final file is set.
     *
     * @return array<string, mixed>
     */
    protected static function combinations(): array
    {
        return [
            'eyebrow' => 'Stack combinations',
            'title' => 'How These Technologies Work Together',
            'description' => 'Most products use more than one of these technologies. These are common combinations and where each leads on our site.',
            'rows' => [
                self::combinationRow('crm', 'Custom CRM + ERP', 'Build systems with complex data, roles, and workflows.', ['laravel' => 'Laravel', 'react' => 'React'], 'Custom CRM Development', 'custom-crm-development'),
                self::combinationRow('portal', 'Enterprise administration portal', 'Give operations teams one place for data, permissions, and reporting.', ['laravel' => 'Laravel', 'angular' => 'Angular'], 'Enterprise Software', 'enterprise-software-solutions'),
                self::combinationRow('live', 'Real-time tracking or live dashboard', 'Keep many live connections open for tracking, chat, or dashboards.', ['node' => 'Node.js', 'react' => 'React'], 'Web Development', 'web-development-services'),
                self::combinationRow('marketing', 'Marketing website your team edits', 'Let the team publish pages without a developer for every change.', ['wordpress' => 'WordPress'], 'Web Development', 'web-development-services'),
                self::combinationRow('content', 'Content across web and mobile', 'Publish once and show the same content on the site and the app.', ['headless' => 'Headless CMS', 'react' => 'React', 'native' => 'React Native'], 'Web Development', 'web-development-services'),
                self::combinationRow('store', 'High-volume online store', 'Run a hosted store that can take high order volume with low maintenance.', ['shopify' => 'Shopify Plus'], 'E-commerce Development', 'e-commerce-development'),
                self::combinationRow('catalog', 'B2B or multi-store catalog', 'Sell across companies, catalogs, and store views from one platform.', ['magento' => 'Magento'], 'E-commerce Development', 'e-commerce-development'),
                self::combinationRow('ai', 'AI features in an existing product', 'Add assistants, automation, or recommendations inside the product you already have.', ['laravel' => 'Laravel', 'react' => 'React'], 'AI Solutions', 'ai-solutions'),
            ],
        ];
    }

    /**
     * @param  array<string, string>  $stack
     * @return array<string, mixed>
     */
    protected static function combinationRow(string $icon, string $title, string $text, array $stack, string $serviceLabel, string $serviceSlug): array
    {
        $pills = [];

        foreach ($stack as $key => $name) {
            $pills[] = [
                'key' => $key,
                'name' => $name,
                'logo' => '',
                'logoAlt' => $name.' logo for Suave Creators technology combinations',
            ];
        }

        return [
            'icon' => $icon,
            'title' => $title,
            'text' => $text,
            'pills' => $pills,
            'serviceLabel' => $serviceLabel,
            'serviceRoute' => 'service.show',
            'serviceParams' => ['slug' => $serviceSlug],
        ];
    }

    /**
     * Stack-selection block below the combinations table. Leave logo empty until the final file is set.
     *
     * @return array<string, mixed>
     */
    protected static function selection(): array
    {
        $marks = [
            'Laravel' => 'Laravel logo for Suave Creators technology stack selection',
            'Node.js' => 'Node.js logo for Suave Creators technology stack selection',
            'React' => 'React logo for Suave Creators technology stack selection',
            'Angular' => 'Angular logo for Suave Creators technology stack selection',
            'Vue.js' => 'Vue.js logo for Suave Creators technology stack selection',
            'WordPress' => 'WordPress logo for Suave Creators technology stack selection',
            'Shopify' => 'Shopify logo for Suave Creators technology stack selection',
            'Magento' => 'Magento logo for Suave Creators technology stack selection',
        ];

        $stack = [];

        foreach ($marks as $name => $alt) {
            $stack[] = ['name' => $name, 'logo' => '', 'logoAlt' => $alt];
        }

        return [
            'eyebrow' => 'Stack selection',
            'titleLead' => 'How we choose a',
            'titleAccent' => 'Technology Stack',
            'description' => 'We choose the stack in the discovery phase, before any production code is written. We map your workflows, data model and technical constraints, then recommend the technologies that fit, with the trade-offs written down.',
            'discoveryTitle' => 'Discovery',
            'discovery' => ['Your goals', 'Workflows', 'Data model', 'Constraints'],
            'stackTitle' => 'Recommended stack',
            'stack' => $stack,
            'resultLead' => 'Right stack.',
            'resultText' => 'Real results.',
            'factors' => [
                ['number' => '01', 'tone' => 'blue', 'title' => 'Data and business logic.', 'text' => 'Relational, rule-heavy systems favour Laravel; event-heavy systems favour Node.js.'],
                ['number' => '02', 'tone' => 'green', 'title' => 'Real-time and concurrency needs.', 'text' => 'Live updates and many open connections point to a Node.js layer.'],
                ['number' => '03', 'tone' => 'purple', 'title' => 'Who edits content.', 'text' => 'If non-technical teams publish daily, WordPress or a headless CMS belongs in the stack.'],
                ['number' => '04', 'tone' => 'orange', 'title' => 'Integrations.', 'text' => 'ERP, CRM, payment and inventory systems shape the API design and the commerce platform.'],
                ['number' => '05', 'tone' => 'teal', 'title' => 'Ownership after launch.', 'text' => 'We favour widely used technologies so your in-house team can hire for and maintain the code you own.'],
                ['number' => '06', 'tone' => 'sky', 'title' => 'Total cost of ownership.', 'text' => 'Hosting, platform licences and maintenance effort are compared over several years, not just the build.'],
            ],
        ];
    }

    /**
     * Why-us band below stack selection.
     *
     * @return array<string, mixed>
     */
    protected static function why(): array
    {
        return [
            'eyebrow' => 'Why us',
            'title' => 'Build with Suave Creators',
            'items' => [
                [
                    'icon' => 'delivery',
                    'title' => 'Senior-led delivery',
                    'text' => 'Full-time in-house developers specialising in Laravel, React, Angular and Node.js, led by senior solution architects.',
                ],
                [
                    'icon' => 'ownership',
                    'title' => '100% code and IP ownership',
                    'text' => 'Repositories and intellectual property belong to you from day one.',
                ],
                [
                    'icon' => 'sprints',
                    'title' => 'Transparent 2-week sprints',
                    'text' => 'Direct access to the architect and lead developer throughout the project.',
                ],
                [
                    'icon' => 'decisions',
                    'title' => 'Documented decisions',
                    'text' => 'Stack decisions documented during discovery so the reasoning outlives the project.',
                ],
            ],
            'primaryCta' => 'See Our Case Studies',
            'primaryRoute' => 'case-studies',
            'secondaryCta' => 'About Our Team',
            'secondaryRoute' => 'about-us',
        ];
    }

    /**
     * Technology FAQ below the why-us band. Reuses the dark CRM FAQ treatment.
     *
     * @return array<string, mixed>
     */
    protected static function faq(): array
    {
        return [
            'eyebrow' => 'Frequently Asked Questions',
            'title' => 'Technology FAQs',
            'description' => 'Here are the most asked questions based on feedback from our users.',
            'backgroundImage' => 'assets/background/custom-crm-builder-faq-bg.webp',
            'items' => [
                [
                    'question' => 'How do you choose a technology stack?',
                    'answer' => 'We choose it in the discovery phase, before any production code is written. We map your workflows, data model, and technical constraints, then recommend the technologies that fit and write the trade-offs down.',
                ],
                [
                    'question' => 'When do you recommend Laravel, and when Node.js?',
                    'answer' => 'Relational, rule-heavy systems favour Laravel. Event-heavy systems, live updates, and many open connections favour a Node.js layer. When a product needs both, Laravel stays the core and Node.js runs the real-time service.',
                ],
                [
                    'question' => 'React, Angular, or Vue.js: how do you decide?',
                    'answer' => 'React fits interactive product interfaces and pairs with React Native for mobile. Angular fits large enterprise portals that want routing, forms, and dependency injection included. Vue.js fits lighter applications and teams that want a progressive framework.',
                ],
                [
                    'question' => 'Can one team cover web and mobile?',
                    'answer' => 'Yes. React Native shares the React model across iOS and Android, and a headless CMS can feed the same content to the website and the app.',
                ],
                [
                    'question' => 'Should we use WordPress or a headless CMS?',
                    'answer' => 'If a non-technical team publishes every day on a marketing site, WordPress belongs in the stack. If the same content must ship to web and mobile apps, a headless CMS with React or React Native is the better fit.',
                ],
                [
                    'question' => 'Shopify Plus or Magento for our store?',
                    'answer' => 'Shopify Plus fits high-volume brands that want hosting, checkout, and apps managed by Shopify. Magento fits complex catalogs, B2B buying, and global multi-store setups that need full code access.',
                ],
                [
                    'question' => 'Who owns the source code and intellectual property?',
                    'answer' => 'You do. Repositories and intellectual property belong to you from day one. Suave Creators does not keep a licence on the code we write for you.',
                ],
                [
                    'question' => 'Can the stack connect to our ERP, CRM, and payment systems?',
                    'answer' => 'Yes. Those systems shape the API design and, for a store, the commerce platform. We plan the integrations during discovery rather than adding them after launch.',
                ],
                [
                    'question' => 'Who do we work with during the build?',
                    'answer' => 'Full-time in-house developers, led by senior solution architects. You have direct access to the architect and the lead developer through transparent two-week sprints.',
                ],
                [
                    'question' => 'Are stack decisions written down?',
                    'answer' => 'Yes. Decisions made in discovery are documented so the reasoning stays with the project after the people who made them have moved on.',
                ],
            ],
        ];
    }

    /**
     * Closing consultation card. Hire Developers opens the inquiry dialog from the Blade.
     *
     * @return array<string, string>
     */
    protected static function consultation(): array
    {
        return [
            'eyebrow' => 'Get started',
            'title' => 'Discuss Your Technology Stack With a Solution Architect',
            'description' => 'Tell us what you\'re building and what you run today. A solution architect will recommend a stack, explain the trade-offs and give you a scoped estimate — whether you need a full project team or developers who join yours.',
            'ctaLabel' => 'Get a Scoped Estimate',
            'secondaryCtaLabel' => 'Hire Developers',
            'cardPosition' => 'center',
        ];
    }

    /**
     * Same partner set as the CRM page, without the Turbo Trans logo.
     *
     * @return array<int, array{src: string, alt: string}>
     */
    protected static function partnerLogos(): array
    {
        return array_values(array_filter(
            HomeSupport::partnerMarqueeItems(),
            static fn (array $item): bool => ! str_contains((string) ($item['src'] ?? ''), 'turbo-trans')
        ));
    }
}
