<?php

namespace App\Support\Frontend;

class CustomCrmBuilderSupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        $faq = self::faq();

        return [
            'bodyClass' => 'min-h-screen bg-white font-sans text-slate-900',
            'mainClass' => 'site-main site-main--crm-builder',
            'useHeroBackground' => true,
            'heroBackgroundImage' => '',
            'bannerBackgroundImage' => 'assets/background/custom-crm-builder-hero-bg.webp',
            'trustBackgroundImage' => 'assets/background/crm-trust-triangle-pattern.webp',
            'demoHref' => ContactSupport::demoHref(),
            'eyebrow' => 'Our Tailor-Made Software Services',
            'heroLead' => 'Custom CRM Builder &',
            'heroMid' => 'Bespoke',
            'heroAccent' => 'CRM Software',
            'heroPurple' => 'Development',
            'heroDescription' => 'Replace rigid off-the-shelf software and escalating per-seat subscription fees with an enterprise-grade, AI-native CRM tailored to your company\'s exact sales pipeline, data architecture, and operational workflows.',
            'primaryCta' => 'Get Free Consultation',
            'definitionEyebrow' => 'What is a custom CRM builder?',
            'definitionCopy' => 'A custom CRM builder is an end-to-end software engineering approach that designs, develops, and deploys a proprietary customer relationship management system tailored to an organization\'s unique operational workflows. Unlike commercial platforms like Salesforce or HubSpot that charge recurring monthly per-user licensing fees, a custom CRM delivers 100% intellectual property and data ownership, zero per-seat licensing costs, native integration with internal ERPs/APIs, and private LLM automations engineered around your exact sales process.',
            'trustEyebrow' => 'Custom CRM Software Development',
            'trustTitle' => 'Trusted by High-Growth Startups & Mid-Market Enterprises',
            'trustDescription' => 'We engineer custom CRM architectures that eliminate workflow bottlenecks and scale without artificial user-license limits. From initial discovery and schema modeling to cloud deployment and AI orchestration, our technical leads build alongside your team with complete transparency.',
            'trustLinkText' => 'Explore All Services',
            'dashboard' => self::dashboard(),
            'stats' => self::stats(),
            'tco' => self::tco(),
            'modules' => self::modules(),
            'verticals' => self::verticals(),
            'stack' => self::stack(),
            'stackMarquee' => self::stackMarquee(),
            'valuePillars' => self::valuePillars(),
            'standsOut' => self::standsOut(),
            'execution' => self::execution(),
            'results' => self::results(),
            'faq' => $faq,
            'seoFaqs' => $faq['items'],
            'articles' => BlogSupport::articleCards(3),
            'consultation' => self::consultation(),
            'partnerLogos' => self::partnerLogos(),
            ...self::seoStructuredData(),
        ];
    }

    /**
     * @return array{
     *     title: string,
     *     scoreLabel: string,
     *     score: string,
     *     scoreMax: string,
     *     metrics: array<int, array{label: string, value: string}>,
     *     stages: array<int, array{label: string, count: string, value: string, width: string, tone: string}>
     * }
     */
    protected static function dashboard(): array
    {
        return [
            'title' => 'CRM Dashboard - Pipeline Overview',
            'scoreLabel' => 'AI Lead Score',
            'score' => '94',
            'scoreMax' => '/100',
            'metrics' => [
                ['label' => 'Pipeline value', 'value' => ''],
                ['label' => 'Win Rate', 'value' => '38.2%'],
                ['label' => 'Avg. Deal Velocity', 'value' => '18D'],
            ],
            'stages' => [
                ['label' => 'Prospecting', 'count' => '48', 'value' => '$2.4M', 'width' => '100%', 'tone' => 'blue'],
                ['label' => 'Qualified', 'count' => '31', 'value' => '$1.8M', 'width' => '78%', 'tone' => 'sky'],
                ['label' => 'Proposal sent', 'count' => '19', 'value' => '$1.1M', 'width' => '58%', 'tone' => 'purple'],
                ['label' => 'Negotiation', 'count' => '11', 'value' => '$380K', 'width' => '36%', 'tone' => 'orange'],
                ['label' => 'Closed Won', 'count' => '07', 'value' => '$420K', 'width' => '28%', 'tone' => 'green'],
            ],
        ];
    }

    /**
     * @return array<int, array{value: string, label: string, detail: string}>
     */
    protected static function stats(): array
    {
        return [
            ['value' => '50+', 'label' => 'Projects Delivered', 'detail' => 'High-performance web apps, custom CRMs, enterprise ERPs, and cloud systems.'],
            ['value' => '>70%', 'label' => '3-Year Cost Reduction', 'detail' => 'Massive total cost of ownership (TCO) savings compared to commercial SaaS platforms.'],
            ['value' => '100%', 'label' => 'Code & IP Ownership', 'detail' => 'Complete repository handover with zero vendor lock-in or recurring per-seat fees.'],
            ['value' => '15+', 'label' => 'Senior Engineers', 'detail' => 'Full-stack developers, system architects, and AI automation specialists.'],
        ];
    }

    /**
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     titleAccent: string,
     *     description: string,
     *     metricHeading: string,
     *     metricIcon: string,
     *     metricIconAlt: string,
     *     saasHeading: string,
     *     saasNote: string,
     *     saasIcon: string,
     *     saasIconAlt: string,
     *     customHeading: string,
     *     customNote: string,
     *     customIcon: string,
     *     customIconAlt: string,
     *     rowIcon: string,
     *     rowIconAlt: string,
     *     rows: array<int, array{metric: string, saasValue: string, saasDetail: string, customValue: string, customDetail: string}>
     * }
     */
    protected static function tco(): array
    {
        return [
            'eyebrow' => 'Financial & Operational Efficiency',
            'title' => 'Why Build a Custom CRM in 2026?',
            'titleAccent' => 'The TCO Advantage',
            'description' => 'Off-the-shelf CRM solutions penalize business growth: every new hire, sales rep, and operations manager adds hundreds of dollars to your monthly software bill. A custom CRM converts ongoing operational expenses into a permanent balance-sheet asset.',
            'metricHeading' => 'Evaluation Metric / Cost Layer',
            'metricIcon' => 'assets/icons/evaluated-metric-icon.webp',
            'metricIconAlt' => 'Evaluated metric icon for custom CRM software cost comparison',
            'saasHeading' => 'Commercial SaaS',
            'saasNote' => '(Salesforce / HubSpot — 50 Seats)',
            'saasIcon' => 'assets/icons/tech/salesforce-logo.webp',
            'saasIconAlt' => 'Salesforce logo for custom CRM total cost comparison',
            'customHeading' => 'Suave Creators Custom CRM',
            'customNote' => 'Development',
            'customIcon' => 'assets/icons/custom-crm-icon.webp',
            'customIconAlt' => 'Custom CRM software icon for total cost comparison',
            'rowIcon' => 'assets/icons/calendar-metric-icon.webp',
            'rowIconAlt' => 'Calendar metric icon for custom CRM total cost comparison',
            'rows' => [
                [
                    'metric' => 'Year 1 Capital Investment',
                    'saasValue' => '$ 90,000',
                    'saasDetail' => '$ 150/user/mo + mandatory onboarding & tier-1 add-ons',
                    'customValue' => '$45,000 – $65,000',
                    'customDetail' => 'Full-cycle architecture, UI/UX, and production build',
                ],
                [
                    'metric' => 'Year 2 Operational Cost',
                    'saasValue' => '$ 95,000',
                    'saasDetail' => 'Base licensing fees + standard 5% renewal inflation',
                    'customValue' => '$ 6,000',
                    'customDetail' => 'Dedicated cloud hosting, database backups & security patches',
                ],
                [
                    'metric' => 'Year 3 Operational Cost',
                    'saasValue' => '$ 100,000',
                    'saasDetail' => 'Base licensing + additional storage & pipeline tiers',
                    'customValue' => '$ 6,000',
                    'customDetail' => 'Dedicated cloud hosting, maintenance & minor feature iterations',
                ],
                [
                    'metric' => '3-Year Cumulative Spend',
                    'saasValue' => '$ 285,000',
                    'saasDetail' => 'Pure subscription expense with zero equity',
                    'customValue' => '$ 57,000 – $77,000',
                    'customDetail' => '>70% Net Capital Savings',
                ],
                [
                    'metric' => 'User Seat Scalability',
                    'saasValue' => 'Penalized',
                    'saasDetail' => 'Each additional seat adds $1,800+/year',
                    'customValue' => 'Unlimited Users',
                    'customDetail' => 'Add unlimited reps, managers, and partners at $0 extra',
                ],
                [
                    'metric' => 'Data & Pipeline Ownership',
                    'saasValue' => 'Vendor-locked',
                    'saasDetail' => 'Proprietary database with restrictive export limits',
                    'customValue' => '100% Client-Owned',
                    'customDetail' => 'Self-hosted PostgreSQL database with direct query access',
                ],
                [
                    'metric' => 'Custom AI & LLM Automation',
                    'saasValue' => 'Expensive credits',
                    'saasDetail' => 'Rigid, generic add-on assistants billed as extra credits',
                    'customValue' => 'Native LLM Orchestration',
                    'customDetail' => 'Tailored models running directly on your data',
                ],
                [
                    'metric' => 'Custom Business Logic',
                    'saasValue' => 'Constrained',
                    'saasDetail' => 'Vendor app-store plugins and governor limits',
                    'customValue' => 'Zero Limitations',
                    'customDetail' => 'Built directly to your operational workflows and rules',
                ],
            ],
        ];
    }

    /**
     * Image and icon paths stay empty until assets are added under public/assets/.
     *
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     description: string,
     *     cta: string,
     *     items: array<int, array{
     *         image: string,
     *         imageAlt: string,
     *         icon: string,
     *         iconAlt: string,
     *         title: string,
     *         copy: string,
     *         tags: array<int, string>
     *     }>
     * }
     */
    protected static function modules(): array
    {
        return [
            'eyebrow' => 'Our Technical Capabilities',
            'title' => 'Enterprise-Grade Functional Modules Engineered for High Velocity',
            'description' => 'We build modular, extensible CRM platforms designed to handle complex pipelines, multi-channel inbound capture, and high-concurrency operations.',
            'cta' => 'Get Free Consultation',
            'items' => [
                [
                    'image' => 'assets/icons/tech/technical_capabilites1.webp',
                    'imageAlt' => 'Lead ingestion and unified CRM pipeline architecture for custom CRM software',
                    'icon' => 'assets/icons/lead-ingestion-funnel-icon.webp',
                    'iconAlt' => 'Lead ingestion pipeline icon for custom CRM software development',
                    'title' => 'Lead Ingestion & Unified Pipeline Architecture',
                    'copy' => 'Automated capture across website forms, marketing funnels, and partner APIs into a normalized database. Built-in deduplication, qualification rules, and intelligent round-robin distribution to sales reps in real time.',
                    'tags' => ['Website', 'API Endpoints', 'Webhook Integrations', 'Lead Scoring'],
                ],
                [
                    'image' => 'assets/media/ai-outreach-chat-support-laptop.webp',
                    'imageAlt' => 'AI-assisted outreach and S-Mail follow-up sequences for custom CRM software',
                    'icon' => 'assets/icons/ai-outreach-spark-icon.webp',
                    'iconAlt' => 'AI outreach icon for custom CRM software development',
                    'title' => 'AI-Assisted Outreach & Automated Follow-Up (S-Mail Native)',
                    'copy' => 'Deep integration with Google Workspace, Microsoft 365, and proprietary S-Mail infrastructure. Features LLM-driven personalized email drafting, automated follow-up cadences, and reply sentiment classification.',
                    'tags' => ['Email Sequences', 'Generative AI', 'Sentiment Analysis', 'Follow-ups'],
                ],
                [
                    'image' => 'assets/media/kanban-workflow-automation-meeting.webp',
                    'imageAlt' => 'Collaborative Kanban deal stages for custom CRM software operations',
                    'icon' => 'assets/icons/kanban-task-checklist-icon.webp',
                    'iconAlt' => 'Kanban operations icon for custom CRM software development',
                    'title' => 'Task, Deal Stage & Collaborative Kanban Operations',
                    'copy' => 'Ultra-responsive drag-and-drop Kanban boards with custom deal stages, task reminders, automated pipeline movement triggers, and collaborative audit logs that keep cross-functional teams aligned.',
                    'tags' => ['Kanban Views', 'List Tables', 'Deal Forecasting', 'Team Workspaces'],
                ],
                [
                    'image' => 'assets/media/secure-verified-compliance-phone.webp',
                    'imageAlt' => 'Role-based access control and compliance for custom CRM software',
                    'icon' => 'assets/icons/rbac-access-columns-icon.webp',
                    'iconAlt' => 'RBAC and compliance icon for custom CRM software development',
                    'title' => 'Role-Based Access Control (RBAC) & Enterprise Compliance',
                    'copy' => 'Multi-tiered role hierarchies restricting data visibility by team, region, or seniority. Field-level masking, immutable audit logging, and enterprise AES-256 encryption at rest and in transit.',
                    'tags' => ['Granular Permissions', 'Audit Trails', 'GDPR / HIPAA / SOC2', 'MFA'],
                ],
                [
                    'image' => 'assets/media/realtime-analytics-dashboard-touch.webp',
                    'imageAlt' => 'Real-time analytics and multi-currency dashboards for custom CRM software',
                    'icon' => 'assets/icons/forecasting-dashboard-icon.webp',
                    'iconAlt' => 'Forecasting dashboard icon for custom CRM software development',
                    'title' => 'Real-Time Analytics, Forecasting & Multi-Currency Dashboards',
                    'copy' => 'Live data visualization dashboards displaying pipeline conversion rates, projected cash flow, sales velocity, and multi-currency billing integration without third-party BI software costs.',
                    'tags' => ['Executive Reporting', 'Win/Loss Ratios', 'Rep Velocity', 'Financial KPIs'],
                ],
                [
                    'image' => 'assets/media/erp-folder-integration-diagram.webp',
                    'imageAlt' => 'Bi-directional ERP and accounting integrations for custom CRM software',
                    'icon' => 'assets/icons/erp-cloud-sync-icon.webp',
                    'iconAlt' => 'ERP integration icon for custom CRM software development',
                    'title' => 'Bi-Directional ERP, Accounting & Third-Party Integrations',
                    'copy' => 'Synchronize your CRM directly with your ERP, payment gateways, accounting ledgers, and logistics management tools via robust, rate-limited APIs.',
                    'tags' => ['REST / GraphQL', 'QuickBooks', 'SAP', 'Stripe', 'Inventory Systems'],
                ],
            ],
        ];
    }

    /**
     * Overlay icons stay empty until assets are added under public/assets/.
     *
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     description: string,
     *     descriptionLine: string,
     *     backgroundImage: string,
     *     challengeLabel: string,
     *     architectureLabel: string,
     *     items: array<int, array{
     *         id: string,
     *         number: string,
     *         title: string,
     *         icon: string,
     *         iconAlt: string,
     *         challenge: string,
     *         architecture: string,
     *         proofPrefix?: string,
     *         proofRoute?: string,
     *         proofLabel?: string
     *     }>
     * }
     */
    protected static function verticals(): array
    {
        return [
            'eyebrow' => 'Industries We Serve',
            'title' => 'Tailored Architecture for High-Complexity Verticals',
            'description' => 'Generic CRM templates fail when applied to specialized business models. We build purpose-built data models and interfaces designed for your',
            'descriptionLine' => 'industry\'s exact operational requirements.',
            'backgroundImage' => 'assets/background/custom-crm-builder-industries-bg.webp',
            'challengeLabel' => 'Challenge',
            'architectureLabel' => 'Custom Architecture',
            'items' => [
                [
                    'id' => 'logistics',
                    'number' => '01',
                    'title' => 'Logistics, Freight & Supply Chain Management',
                    'icon' => 'assets/icons/logistics-freight-delivery-icon.webp',
                    'iconAlt' => 'Logistics freight CRM architecture icon for custom CRM software',
                    'challenge' => 'Fragmented rate sheets, delayed spot-quote confirmations, and disconnected dispatchers.',
                    'architecture' => 'Real-time spot-quote calculators, load-matching modules, automated carrier onboarding, and automated delivery milestone SMS alerts.',
                    'proofPrefix' => 'Built on patterns proven in our',
                    'proofRoute' => 'turbo-trans-case-study',
                    'proofLabel' => 'Turbo Trans Corporation Custom Logistics Software',
                ],
                [
                    'id' => 'saas',
                    'number' => '02',
                    'title' => 'B2B Technology & High-Growth SaaS',
                    'icon' => 'assets/icons/ai-solutions-icon.svg',
                    'iconAlt' => 'B2B SaaS CRM architecture icon for custom CRM software',
                    'challenge' => 'Disconnected product-usage data, complex multi-touch attribution, and SDR-to-AE account handoffs.',
                    'architecture' => 'Product-led growth (PLG) telemetry ingestion, automated account tiering, map-based prospect discovery, and AI outbound sequencing',
                    'proofPrefix' => 'based on our',
                    'proofRoute' => 'outreach-case-study',
                    'proofLabel' => 'B2B CRM Outbound Sales Workflow Architecture',
                ],
                [
                    'id' => 'healthcare',
                    'number' => '03',
                    'title' => 'Healthcare, Clinics & Patient Intake',
                    'icon' => 'assets/icons/healthcare-icon1.svg',
                    'iconAlt' => 'Healthcare patient intake CRM icon for custom CRM software',
                    'challenge' => 'Stringent HIPAA compliance regulations, no-show appointment attrition, and manual intake forms.',
                    'architecture' => 'Secure, encrypted patient intake portals, automated multi-channel appointment reminders, and automated deposit management',
                    'proofPrefix' => 'built using principles from our',
                    'proofRoute' => 'appointment-insurance-case-study',
                    'proofLabel' => 'Appointment Insurance Platform',
                ],
                [
                    'id' => 'retail',
                    'number' => '04',
                    'title' => 'Retail & High-Volume E-Commerce',
                    'icon' => 'assets/icons/retail-icon-1.svg',
                    'iconAlt' => 'Retail ecommerce CRM architecture icon for custom CRM software',
                    'challenge' => 'High transaction velocity, fragmented customer support histories, and multi-store data silos.',
                    'architecture' => 'Centralized customer profiles combining Shopify/WooCommerce purchases, POS terminal data, loyalty point balances, and automated abandoned-cart follow-up triggers.',
                ],
                [
                    'id' => 'fintech',
                    'number' => '05',
                    'title' => 'Financial Services & Fintech',
                    'icon' => 'assets/icons/finance-icon1.svg',
                    'iconAlt' => 'Fintech CRM architecture icon for custom CRM software',
                    'challenge' => 'Strict KYC/AML compliance workflows, complex multi-stakeholder document approvals, and encrypted record archiving.',
                    'architecture' => 'Secure document vaults, automated risk-scoring calculations, time-stamped compliance audit trails, and banking API integrations.',
                ],
                [
                    'id' => 'real-estate',
                    'number' => '06',
                    'title' => 'Real Estate & Property Development',
                    'icon' => 'assets/icons/enterprise-software-icon.svg',
                    'iconAlt' => 'Real estate CRM architecture icon for custom CRM software',
                    'challenge' => 'Multi-property lead routing, lengthy development sales cycles, and complex broker commission structures.',
                    'architecture' => 'Unit inventory tracking, buyer preference matching engines, automated contract generation, and commission split accounting modules.',
                ],
            ],
        ];
    }

    /**
     * Card photos stay empty until assets are added under public/assets/.
     *
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     items: array<int, array{image: string, imageAlt: string, title: string, items: array<int, string>}>
     * }
     */
    protected static function stack(): array
    {
        return [
            'eyebrow' => 'Modern Engineering Practices',
            'title' => 'Built with Modern, Scalable, Enterprise-Grade Technologies',
            'items' => [
                [
                    'image' => 'assets/media/backend_engennering.webp',
                    'imageAlt' => 'Backend engineering stack for custom CRM software development',
                    'title' => 'Backend Engineering',
                    'items' => [
                        'Laravel (PHP 8.3+)',
                        'Node.js (NestJS / Express)',
                        'Python (FastAPI / Celery for AI orchestration)',
                    ],
                ],
                [
                    'image' => 'assets/media/frontend_dashboard.webp',
                    'imageAlt' => 'Frontend dashboards stack for custom CRM software development',
                    'title' => 'Frontend & Dashboards',
                    'items' => [
                        'ReactJS',
                        'Next.js',
                        'Vue.js',
                        'Angular',
                        'Tailwind CSS',
                        'WebSockets for live pipeline updates',
                    ],
                ],
                [
                    'image' => 'assets/media/database_coaching.webp',
                    'imageAlt' => 'Databases and caching stack for custom CRM software development',
                    'title' => 'Databases & Caching',
                    'items' => [
                        'PostgreSQL',
                        'MySQL',
                        'Redis (Distributed caching & queue management)',
                        'Elasticsearch',
                    ],
                ],
                [
                    'image' => 'assets/media/infrastructure_security.webp',
                    'imageAlt' => 'Infrastructure and security stack for custom CRM software development',
                    'title' => 'Infrastructure & Security',
                    'items' => [
                        'AWS',
                        'Google Cloud Platform',
                        'Docker',
                        'Kubernetes',
                        'Cloudflare Enterprise CDN',
                        'AES-256 bit encryption',
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array<int, array{label: string, src: string, alt: string}>
     */
    protected static function stackMarquee(): array
    {
        return [
            ['label' => 'Docker', 'src' => 'assets/icons/tech/docker-logo.svg', 'alt' => 'Docker logo for custom CRM software development'],
            ['label' => 'Redis', 'src' => 'assets/icons/tech/redis-logo.svg', 'alt' => 'Redis logo for custom CRM caching infrastructure'],
            ['label' => 'PostgreSQL', 'src' => 'assets/icons/tech/postgresql-logo.svg', 'alt' => 'PostgreSQL logo for custom CRM database engineering'],
            ['label' => 'Kubernetes', 'src' => 'assets/icons/tech/kubernetes-logo.svg', 'alt' => 'Kubernetes logo for custom CRM cloud orchestration'],
            ['label' => 'AWS', 'src' => 'assets/icons/tech/aws-color-logo.svg', 'alt' => 'AWS logo for custom CRM cloud infrastructure'],
            ['label' => 'Stripe', 'src' => 'assets/icons/tech/stripe-logo.svg', 'alt' => 'Stripe logo for custom CRM payment integrations'],
            ['label' => 'FastAPI', 'src' => 'assets/icons/tech/fastapi-logo.svg', 'alt' => 'FastAPI logo for custom CRM Python services'],
            ['label' => 'Python', 'src' => 'assets/icons/tech/python.svg', 'alt' => 'Python logo for custom CRM software development'],
            ['label' => 'Vue.js', 'src' => 'assets/icons/tech/vuedotjs.svg', 'alt' => 'Vue.js logo for custom CRM frontend dashboards'],
            ['label' => 'TypeScript', 'src' => 'assets/icons/tech/typescript-logo.svg', 'alt' => 'TypeScript logo for custom CRM software development'],
            ['label' => 'GraphQL', 'src' => 'assets/icons/tech/graphql-logo.svg', 'alt' => 'GraphQL logo for custom CRM API development'],
            ['label' => 'Elasticsearch', 'src' => 'assets/icons/tech/elasticsearch-logo.svg', 'alt' => 'Elasticsearch logo for custom CRM search infrastructure'],
            ['label' => 'Laravel', 'src' => 'assets/icons/tech/laravel-mark-logo.svg', 'alt' => 'Laravel logo for custom CRM backend engineering'],
            ['label' => 'Node.js', 'src' => 'assets/icons/tech/nodedotjs.svg', 'alt' => 'Node.js logo for custom CRM software development'],
            ['label' => 'React', 'src' => 'assets/icons/tech/react.svg', 'alt' => 'React logo for custom CRM dashboard interfaces'],
            ['label' => 'Next.js', 'src' => 'assets/icons/tech/nextjs-logo.svg', 'alt' => 'Next.js logo for custom CRM web applications'],
            ['label' => 'MySQL', 'src' => 'assets/icons/tech/mysql-logo.svg', 'alt' => 'MySQL logo for custom CRM database engineering'],
            ['label' => 'Angular', 'src' => 'assets/icons/tech/angular.svg', 'alt' => 'Angular logo for custom CRM frontend development'],
        ];
    }

    /**
     * Card icons stay empty until assets are added under public/assets/.
     *
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     cta: string,
     *     items: array<int, array{icon: string, iconAlt: string, title: string, copy: string}>
     * }
     */
    protected static function valuePillars(): array
    {
        return [
            'eyebrow' => 'Value Pillars',
            'title' => 'Engineered for Speed, Total Data Autonomy, and Business Growth',
            'cta' => 'Get Free Consultation',
            'items' => [
                [
                    'icon' => 'assets/icons/source-code-ownership-icon.webp',
                    'iconAlt' => 'Intellectual property and source code ownership icon for custom CRM software',
                    'title' => '100% Intellectual Property & Source Code Ownership',
                    'copy' => 'When your project ships, you own the entire repository, documentation, and database schemas. There are no proprietary runtime dependencies, no recurring seat licenses, and no artificial restrictions on adding users, integrations, or features.',
                ],
                [
                    'icon' => 'assets/icons/native-ai-cloud-icon.webp',
                    'iconAlt' => 'Native AI integration icon for custom CRM software development',
                    'title' => 'Native AI Integration without Expensive Per-Token Markups',
                    'copy' => 'We build custom LLM agents directly into your backend architecture. Whether running automated lead qualification, dynamic email generation, or transcription sentiment analysis, your data remains secure and runs directly against optimal model endpoints.',
                ],
                [
                    'icon' => 'assets/icons/scalable-team-users-icon.webp',
                    'iconAlt' => 'Modular microservices icon for scalable custom CRM software',
                    'title' => 'Modular Microservices That Scale with Your Team',
                    'copy' => 'We engineer CRM platforms to handle high-concurrency database queries and millions of customer interactions. Our containerized cloud setups ensure your application delivers sub-second page loads whether you have 10 reps or 5,000 active users worldwide.',
                ],
            ],
        ];
    }

    /**
     * Card photos stay empty until assets are added under public/assets/.
     *
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     backgroundImage: string,
     *     items: array<int, array{number: string, image: string, imageAlt: string, title: string, copy: string}>
     * }
     */
    protected static function standsOut(): array
    {
        return [
            'eyebrow' => 'Suave Creators Stands Out',
            'title' => 'Why Suave Creators Stands Out',
            'backgroundImage' => 'assets/background/custom-crm-builder-stands-out-bg.webp',
            'items' => [
                [
                    'number' => '01',
                    'image' => 'assets/media/ai-neural-network-engineering-laptop.webp',
                    'imageAlt' => 'B2B domain expertise for custom CRM software development',
                    'title' => 'Proven Experience & Deep B2B Domain Expertise',
                    'copy' => 'We have developed and deployed proprietary SaaS platforms, multi-tenant databases, and high-concurrency systems. We build software engineered for real business operations, not just aesthetic prototypes.',
                ],
                [
                    'number' => '02',
                    'image' => 'assets/media/sprint-timeline-dashboard-laptop.webp',
                    'imageAlt' => 'Transparent sprint delivery for custom CRM software development',
                    'title' => 'Fixed Milestones, Transparent Sprints & Timely Delivery',
                    'copy' => 'We provide clear project timelines and defined deliverables before writing a line of code. You receive predictable sprint updates, transparent repository access, and dependable launch execution.',
                ],
                [
                    'number' => '03',
                    'image' => 'assets/media/technical-leadership-handshake.webp',
                    'imageAlt' => 'Direct technical leadership for custom CRM software partnerships',
                    'title' => 'Direct Technical Leadership & Client-Centered Partnership',
                    'copy' => 'You communicate directly with senior software architects and technical leads who understand your business model, ensuring your platform is built to scale alongside your long-term goals.',
                ],
            ],
        ];
    }

    /**
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     backgroundImage: string,
     *     deliverableLabel: string,
     *     items: array<int, array{number: string, tone: string, icon: string, iconAlt: string, title: string, copy: string, deliverable: string}>
     * }
     */
    protected static function execution(): array
    {
        return [
            'eyebrow' => 'Systematic Execution',
            'title' => 'From Workflow Blueprint to Production Deployment',
            'backgroundImage' => 'assets/background/custom-crm-builder-execution-bg.webp',
            'deliverableLabel' => 'Deliverables:',
            'items' => [
                [
                    'number' => '01',
                    'tone' => 'blue',
                    'icon' => 'assets/media/execution_logo.webp',
                    'iconAlt' => 'Discovery and architecture modeling icon for custom CRM software development',
                    'title' => 'Discovery & Architecture Modeling',
                    'copy' => 'We analyze your sales stages, data schemas, API integrations, and user roles.',
                    'deliverable' => 'System Architecture Document, ERD, and project roadmap.',
                ],
                [
                    'number' => '02',
                    'tone' => 'green',
                    'icon' => 'assets/media/execution_logo4.webp',
                    'iconAlt' => 'UI UX prototyping icon for custom CRM software development',
                    'title' => 'UI/UX Design & High-Fidelity Prototyping',
                    'copy' => 'We craft intuitive, clean interfaces prioritizing sales velocity and minimal data entry friction.',
                    'deliverable' => 'Interactive Figma prototypes covering desktop, tablet, and mobile views.',
                ],
                [
                    'number' => '03',
                    'tone' => 'violet',
                    'icon' => 'assets/media/execution_logo3.webp',
                    'iconAlt' => 'Full-stack engineering icon for custom CRM software development',
                    'title' => 'Full-Stack Engineering & AI Pipeline Orchestration',
                    'copy' => 'We develop the core application using Laravel/Node.js backends and dynamic React frontends.',
                    'deliverable' => 'Bi-weekly sprint demos, containerized test builds, and integrated API endpoints.',
                ],
                [
                    'number' => '04',
                    'tone' => 'amber',
                    'icon' => 'assets/media/execution_logo2.webp',
                    'iconAlt' => 'Quality assurance and security audit icon for custom CRM software',
                    'title' => 'Rigorous QA, Security Audits & Performance Tuning',
                    'copy' => 'We conduct end-to-end testing, role-permission verification, load testing, and security scans.',
                    'deliverable' => 'Automated test suites, vulnerability audit reports, and sub-second query tuning.',
                ],
                [
                    'number' => '05',
                    'tone' => 'sky',
                    'icon' => 'assets/media/execution_logo1.webp',
                    'iconAlt' => 'Production deployment icon for custom CRM software development',
                    'title' => 'Deployment, Team Training & Ongoing Evolution',
                    'copy' => 'We execute zero-downtime production deployment, assist with data migration, and provide documentation.',
                    'deliverable' => 'Production launch, staff onboarding sessions, SLA maintenance, and ongoing updates.',
                ],
            ],
        ];
    }

    /**
     * Metric icons stay empty until assets are added under public/assets/.
     *
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     backgroundImage: string,
     *     storyTitle: string,
     *     storyCopy: string,
     *     cta: string,
     *     ctaRoute: string,
     *     items: array<int, array{icon: string, iconAlt: string, value: string, label: string}>
     * }
     */
    protected static function results(): array
    {
        return [
            'eyebrow' => 'Verified Results',
            'title' => 'Proven Delivery: How We Engineered a Modern Sales & CRM Workspace',
            'backgroundImage' => 'assets/background/custom-crm-builder-results-bg.webp',
            'storyTitle' => 'B2B CRM Outbound Sales Workflow & Task Redesign',
            'storyCopy' => 'Suave Creators redesigned and engineered a custom B2B CRM workspace featuring unified lead discovery, AI-assisted outreach sequencing, and interactive Kanban deal stages. The new system replaced three disconnected subscription tools and streamlined pipeline operations.',
            'cta' => 'Read the Full Case Study',
            'ctaRoute' => 'outreach-case-study',
            'items' => [
                [
                    'icon' => 'assets/icons/pipeline-reduction-metric-icon.webp',
                    'iconAlt' => 'Pipeline reduction icon for custom CRM software results',
                    'value' => '+35%',
                    'label' => 'Reduction in manual sales pipeline coordination and data entry',
                ],
                [
                    'icon' => 'assets/icons/zero-seat-fee-metric-icon.webp',
                    'iconAlt' => 'Zero per-seat fee icon for custom CRM software results',
                    'value' => '0',
                    'label' => 'Per-Seat Fees saving thousands in annual third-party subscription overhead',
                ],
                [
                    'icon' => 'assets/icons/lead-qualification-metric-icon.webp',
                    'iconAlt' => 'Faster lead qualification icon for custom CRM software results',
                    'value' => '2.4×',
                    'label' => 'Faster Lead Qualification via automated prospect verification and scoring',
                ],
                [
                    'icon' => 'assets/icons/data-sovereignty-metric-icon.webp',
                    'iconAlt' => 'Data sovereignty icon for custom CRM software results',
                    'value' => '100%',
                    'label' => 'Data Sovereignty deployed in a dedicated, secure cloud environment',
                ],
            ],
        ];
    }

    /**
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     description: string,
     *     ctaLabel: string,
     *     secondaryCtaLabel: string,
     *     cardPosition: string,
     *     people: array<int, array{src: string, alt: string, tone: string, column: string}>
     * }
     */
    protected static function consultation(): array
    {
        return [
            'eyebrow' => 'Your Digital Future Together',
            'title' => 'Ready to Stop Paying Per-User Fees and Build Your Custom CRM?',
            'description' => 'Schedule a technical discovery call with our system architects. We will analyze your current sales workflows, evaluate your three-year TCO savings, and provide an actionable architectural roadmap.',
            'ctaLabel' => 'Schedule a Free CRM Discovery Consultation',
            'secondaryCtaLabel' => 'Book Direct via Google Calendar →',
            'cardPosition' => 'top',
            'people' => [
                ['src' => 'assets/media/analyst-headset-custom-crm-dashboard.webp', 'alt' => 'Analyst reviewing custom CRM analytics dashboard during software consultation', 'tone' => 'pink', 'column' => 'left'],
                ['src' => 'assets/media/executive-tablet-crm-hologram.webp', 'alt' => 'Executive holding a tablet with a CRM hologram for custom software consultation', 'tone' => 'orange', 'column' => 'left'],
                ['src' => 'assets/media/floating-analytics-dashboard-laptop.webp', 'alt' => 'Laptop with a floating analytics dashboard for custom CRM consultation', 'tone' => 'yellow', 'column' => 'center'],
                ['src' => 'assets/media/analyst-performance-metrics-laptop.webp', 'alt' => 'Analyst reviewing performance metrics for custom CRM software consulting', 'tone' => 'blue', 'column' => 'center'],
                ['src' => 'assets/media/crm-contact-hologram-keyboard.webp', 'alt' => 'CRM contact hologram above a keyboard for product consultation', 'tone' => 'coral', 'column' => 'right'],
                ['src' => 'assets/media/consultant-crm-team-tablet.webp', 'alt' => 'Consultant using a CRM team interface on a tablet', 'tone' => 'cyan', 'column' => 'right'],
            ],
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
     * @return array{seoJsonLdGraph: array<int, array<string, mixed>>, seoJsonLdWebpageAbout: string}
     */
    protected static function seoStructuredData(): array
    {
        $pageUrl = rtrim(route('custom-crm-builder'), '/');
        $serviceId = $pageUrl.'/#service';
        $baseUrl = rtrim((string) config('app.url', url('/')), '/');

        return [
            'seoJsonLdGraph' => [[
                '@type' => 'Service',
                '@id' => $serviceId,
                'name' => 'Custom CRM Builder & Bespoke CRM Software Development',
                'serviceType' => 'Custom CRM Software Engineering',
                'provider' => [
                    '@id' => $baseUrl.'/#organization',
                ],
                'url' => $pageUrl,
                'description' => 'End-to-end custom CRM software development, database modeling, AI automation, and API integration for mid-market and enterprise businesses. Eliminates recurring per-seat licensing fees.',
                'areaServed' => [
                    '@type' => 'AdministrativeArea',
                    'name' => 'Worldwide',
                ],
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog',
                    'name' => 'Custom CRM Engineering Modules',
                    'itemListElement' => [
                        [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => 'Lead Ingestion & Pipeline Architecture',
                            ],
                        ],
                        [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => 'AI-Assisted Outreach & S-Mail Sequencing',
                            ],
                        ],
                        [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => 'Collaborative Kanban & Task Management',
                            ],
                        ],
                        [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => 'Enterprise RBAC & Compliance Frameworks',
                            ],
                        ],
                        [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => 'Bi-Directional ERP & Accounting Integrations',
                            ],
                        ],
                    ],
                ],
            ]],
            'seoJsonLdWebpageAbout' => $serviceId,
        ];
    }

    /**
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     description: string,
     *     backgroundImage: string,
     *     items: array<int, array{question: string, answer: string}>
     * }
     */
    protected static function faq(): array
    {
        return [
            'eyebrow' => 'Frequently Asked Questions',
            'title' => 'Everything You Need to Know About Custom CRM Development',
            'description' => '',
            'backgroundImage' => 'assets/background/custom-crm-builder-faq-bg.webp',
            'items' => [
                [
                    'question' => 'What is a custom CRM builder?',
                    'answer' => 'A custom CRM builder is a bespoke software development approach where an engineering partner designs, builds, and deploys a CRM tailored to an organization\'s exact sales pipeline and operational workflows. Unlike commercial SaaS systems (like Salesforce or HubSpot) that charge monthly per-user licensing fees, a custom CRM provides complete intellectual property ownership, zero user-licensing costs, and native integrations with your internal systems.',
                ],
                [
                    'question' => 'How much does it cost to build a custom CRM?',
                    'answer' => 'Developing a custom CRM typically ranges from $20,000 to $60,000 for a streamlined, high-performance sales MVP with core pipeline management, contact tracking, and email integration. For large-scale enterprise deployments featuring advanced AI automation agents, complex ERP integrations, and custom analytics dashboards, costs generally range from $60,000 to $120,000+. Over a three-year period, this one-time development model saves mid-market companies 60% to 75% compared to commercial SaaS subscriptions for 50+ users.',
                ],
                [
                    'question' => 'How long does it take to develop a custom CRM from scratch?',
                    'answer' => 'A focused, production-ready MVP CRM typically takes 8 to 12 weeks from initial discovery to deployment. An advanced enterprise CRM featuring multi-system ERP synchronization, role-based security tiers, and specialized AI outbound engines typically requires 16 to 24 weeks, structured across iterative two-week agile development sprints.',
                ],
                [
                    'question' => 'Custom CRM vs. Salesforce: Which is better for mid-market businesses?',
                    'answer' => 'Salesforce is suited for massive enterprises (1,000+ seats) requiring pre-built third-party app ecosystems and standardized corporate governance. A custom CRM is significantly better for mid-market businesses (20 to 500 users) that have specialized sales workflows, want to eliminate escalating per-seat software fees, require total data privacy, or find standard commercial tools overly bloated and rigid.',
                ],
                [
                    'question' => 'Can a custom CRM integrate with our existing ERP, accounting, and email systems?',
                    'answer' => 'Yes. We build custom CRMs with RESTful and GraphQL API adapters that synchronize bi-directionally with existing infrastructure, including ERP platforms (SAP, NetSuite), accounting suites (QuickBooks, Xero), communication services (Google Workspace, Microsoft 365, S-Mail), payment processors (Stripe), and marketing automation tools.',
                ],
                [
                    'question' => 'How does Suave Creators embed AI into a custom CRM?',
                    'answer' => 'We integrate native Large Language Model (LLM) pipelines directly into the CRM application. Capabilities include automated inbound lead qualification and scoring, context-aware email drafting, call transcription analysis, reply sentiment classification, and predictive pipeline forecasting, all operating securely without sharing sensitive data with public AI training models.',
                ],
                [
                    'question' => 'Who owns the source code and intellectual property of the custom CRM?',
                    'answer' => 'You do. Upon completion and milestone settlement, 100% of the intellectual property, source code, design assets, and database schemas are transferred directly to your organization. Suave Creators retains no proprietary lock-in, licensing rights, or ongoing software claims.',
                ],
                [
                    'question' => 'What security protocols protect sensitive customer data in a custom CRM?',
                    'answer' => 'We implement defense-in-depth enterprise security standards, including AES-256 encryption at rest, TLS 1.3 encryption in transit, multi-factor authentication (MFA), strict Role-Based Access Control (RBAC), immutable audit logging, and automated daily encrypted database snapshots. All architectures are engineered to comply with GDPR, HIPAA, and SOC2 standards.',
                ],
                [
                    'question' => 'Can a custom CRM scale as our company grows from 50 to 5,000 employees?',
                    'answer' => 'Yes. We design custom CRMs using cloud-native, microservices-ready architectures on AWS or Google Cloud. By decoupling the frontend interface from the backend API, implementing Redis caching layers, and using managed relational databases with read-replicas, the platform easily scales to thousands of concurrent users with sub-second response times.',
                ],
                [
                    'question' => 'What post-launch support and SLA guarantees does Suave Creators provide?',
                    'answer' => 'We provide comprehensive post-launch warranty support, 24/7 server and uptime monitoring, routine security patching, and ongoing feature enhancement retainers. Our dedicated maintenance agreements ensure your software stays fast, secure, and aligned with your evolving business requirements.',
                ],
            ],
        ];
    }
}
