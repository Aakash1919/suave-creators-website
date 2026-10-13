<?php

namespace App\Support\Frontend;

class EnterpriseAiErpSupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        $faq = self::faq();

        return [
            'bodyClass' => 'min-h-screen bg-white font-sans text-slate-900',
            'mainClass' => 'site-main site-main--enterprise-ai-erp',
            'demoHref' => ContactSupport::demoHref(),
            'eyebrow' => 'Bespoke software engineering for UAE & GCC enterprises',
            'heroLead' => 'Enterprise AI &',
            'heroMid' => 'Custom ERP Solutions',
            'heroAccent' => 'in the UAE',
            'heroDescription' => 'Build resilient, AI-native ERP platforms and autonomous workflow agents tailored to your company\'s operational hierarchy. Eliminate recurring per-seat software taxes with 100% code ownership, bilingual Arabic-English interfaces, and complete UAE regulatory compliance (FTA VAT & Corporate Tax).',
            'primaryCta' => 'Schedule a Technical Discovery Session',
            'secondaryCta' => 'Let\'s Connect',
            'visualLabel' => 'Enterprise ERP dashboard laptop for UAE custom software',
            'heroVisualImage' => 'assets/media/laptop-image.webp',
            'heroFeatures' => self::heroFeatures(),
            'bannerBackgroundImage' => 'assets/media/erp-banner-bg.webp',
            'trustBackgroundImage' => 'assets/background/crm-trust-triangle-pattern.webp',
            'trustTitle' => 'Trust & Credibility Metrics Bar (UAE Enterprise Scale)',
            'trustStats' => self::trustStats(),
            'definitionEyebrow' => 'Enterprise AI and ERP',
            'definitionTitle' => 'What are enterprise AI and ERP solutions in the UAE?',
            'definitionCopy' => 'Enterprise AI and ERP solutions in the UAE are custom-built software architectures that integrate core resource planning modules—such as inventory, supply chain, procurement, and multi-entity accounting—with autonomous AI agent pipelines. Engineered specifically for the regulatory and operational landscape of Dubai, Abu Dhabi, and the wider GCC, these systems natively support UAE Federal Tax Authority (FTA) 5% VAT rules, Corporate Tax compliance, bilingual (Arabic/English) RTL/LTR interfaces, and localized cloud hosting (AWS UAE or Azure UAE regions) with',
            'definitionEmphasis' => 'zero per-user licensing fees.',
            'definitionCta' => 'Discuss Your Enterprise Architecture Blueprint',
            'allocationEyebrow' => 'Strategic Capital Allocation',
            'allocationTitle' => 'Break Free from Rigid Legacy ERPs & Escalating SaaS Licensing',
            'allocationParagraphs' => self::allocationParagraphs(),
            'allocationCta' => 'Discuss Your Enterprise Architecture Blueprint',
            'allocationVisuals' => self::allocationVisuals(),
            'tco' => self::tco(),
            'modules' => self::modules(),
            'verticals' => self::verticals(),
            'governance' => self::governance(),
            'stack' => self::stack(),
            'delivery' => self::delivery(),
            'lifecycle' => self::lifecycle(),
            'faq' => $faq,
            'evidence' => self::evidence(),
            'seoFaqs' => $faq['items'],
            'consultation' => self::consultation(),
            'partnerLogos' => self::partnerLogos(),
            'seoBreadcrumbName' => 'Enterprise AI & ERP Solutions UAE',
            ...self::seoStructuredData(),
        ];
    }

    /**
     * Hero feature labels. Leave icon empty until the final assets/icons or assets/media file is set.
     *
     * @return list<array{slot: string, label: string, icon: string, iconAlt: string}>
     */
    protected static function heroFeatures(): array
    {
        return [
            [
                'slot' => 'bilingual',
                'label' => 'Bilingual Arabic-English',
                'icon' => 'assets/media/arabic-english-logo.webp',
                'iconAlt' => 'Bilingual Arabic English icon for UAE enterprise ERP software',
            ],
            [
                'slot' => 'platforms',
                'label' => 'Custom ERP Platforms',
                'icon' => 'assets/media/custom-erp-logo.png',
                'iconAlt' => 'Custom ERP platforms icon for UAE enterprise software',
            ],
            [
                'slot' => 'automation',
                'label' => 'AI-Powered Automation',
                'icon' => 'assets/media/ai-logo.webp',
                'iconAlt' => 'AI-powered automation icon for enterprise ERP workflows',
            ],
            [
                'slot' => 'compliance',
                'label' => 'UAE Regulatory Compliance',
                'icon' => 'assets/media/compliance-logo.webp',
                'iconAlt' => 'UAE regulatory compliance icon for enterprise ERP software',
            ],
        ];
    }

    /**
     * @return list<array{value: string, label: string, detail: string}>
     */
    protected static function trustStats(): array
    {
        return [
            [
                'value' => 'AED 450K+',
                'label' => 'Average 3-Yr TCO',
                'detail' => 'Capital savings vs legacy ERP vendors (SAP / Oracle)',
            ],
            [
                'value' => '1.5 Hour',
                'label' => 'Timezone Overlap',
                'detail' => 'Direct real-time collaboration with UAE business hours',
            ],
            [
                'value' => '100% Code',
                'label' => 'Sovereignty',
                'detail' => 'Complete source code transfer to your private repo',
            ],
            [
                'value' => 'Zero Per-Seat',
                'label' => 'Licensing Tax',
                'detail' => 'Add unlimited employees, reps & external partners',
            ],
        ];
    }

    /**
     * @return list<array{before: string, emphasis: string, after: string}>
     */
    protected static function allocationParagraphs(): array
    {
        return [
            [
                'before' => 'Mid-market conglomerates, trading houses, and logistics operators across Dubai, Abu Dhabi, and Sharjah face a shared operational challenge: ',
                'emphasis' => 'legacy ERP systems are taxing commercial growth.',
                'after' => ' Traditional platforms like SAP, Oracle, or Microsoft Dynamics charge thousands of dirhams in recurring per-user monthly seat fees, while forcing companies into rigid, multi-year consulting retainers just to modify basic billing fields or add internal approval tiers.',
            ],
            [
                'before' => 'At the same time, off-the-shelf software fails to address regional nuances: multi-entity trade structures across UAE Free Zones (DIFC, JAFZA, ADGM) and mainland entities, mandatory FTA 5% VAT reporting, the UAE Corporate Tax regime, and bilingual English-Arabic document workflows.',
                'emphasis' => '',
                'after' => '',
            ],
            [
                'before' => 'Suave Creators builds ',
                'emphasis' => 'bespoke, client-owned enterprise ERP platforms and autonomous AI agent systems.',
                'after' => ' We engineer software that matches your proprietary operational logic, connects directly to your local banking and logistics APIs, and runs securely inside single-tenant cloud environments.',
            ],
        ];
    }

    /**
     * Collage photos. Replace each src with the final assets/media image.
     *
     * @return list<array{slot: string, src: string, label: string}>
     */
    protected static function allocationVisuals(): array
    {
        return [
            [
                'slot' => 'top-left',
                'src' => 'assets/media/saas-database-workflow-diagram.webp',
                'label' => 'SaaS database workflow diagram for enterprise ERP planning',
            ],
            [
                'slot' => 'top-right',
                'src' => 'assets/media/compliance-dashboard-laptop.webp',
                'label' => 'Compliance dashboard on a laptop for UAE VAT reporting',
            ],
            [
                'slot' => 'bottom-left',
                'src' => 'assets/media/erp-system-diagram-laptop.webp',
                'label' => 'ERP system diagram on a laptop for operations teams',
            ],
            [
                'slot' => 'bottom-right',
                'src' => 'assets/media/defi-network-diagram-laptop.webp',
                'label' => 'DeFi network diagram on a laptop for enterprise finance',
            ],
            [
                'slot' => 'center',
                'src' => 'assets/media/cloud-platform-hologram.webp',
                'label' => 'Cloud platform hologram for custom enterprise ERP software',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function tco(): array
    {
        return [
            'eyebrow' => 'Financial & Operational Efficiency',
            'title' => 'The 3-Year TCO Advantage: Commercial ERP SaaS vs. Suave Creators Custom Build',
            'description' => 'Compare the financial impact of recurring enterprise subscription models against an owned custom ERP asset for a UAE mid-market company with 75 active users.',
            'metricHeading' => 'Operational & Financial Factor',
            'metricIcon' => 'assets/media/operational_logo.webp',
            'metricIconAlt' => 'Operational factor icon for enterprise ERP total cost comparison',
            'saasHeading' => 'Commercial Tier-1 ERP',
            'saasNote' => '(SAP / Oracle SaaS — 75 Seats)',
            'saasIcon' => 'assets/media/tier1-erp-logo.webp',
            'saasIconAlt' => 'Commercial ERP software icon for SAP and Oracle cost comparison',
            'customHeading' => 'Suave Creators Bespoke AI-Native ERP',
            'customNote' => '',
            'customIcon' => 'assets/media/ai-erp-logo.webp',
            'customIconAlt' => 'Suave Creators custom ERP software icon for total cost comparison',
            'rowIcon' => 'assets/icons/calendar-metric-icon.webp',
            'rowIconAlt' => 'Calendar metric icon for enterprise ERP total cost comparison',
            'rows' => [
                [
                    'metric' => 'Year 1 Implementation & Licenses',
                    'saasValue' => 'AED 480,000',
                    'saasDetail' => '($130k+ licensing + mandatory partner setup)',
                    'customValue' => 'AED 185,000 – 240,000',
                    'customDetail' => '($50k–$65k full-cycle custom build)',
                ],
                [
                    'metric' => 'Year 2 Operational & License Cost',
                    'saasValue' => 'AED 320,000',
                    'saasDetail' => '(Base per-user subscription renewal fees)',
                    'customValue' => 'AED 22,000',
                    'customDetail' => '(Dedicated AWS UAE cloud hosting & maintenance)',
                ],
                [
                    'metric' => 'Year 3 Operational & License Cost',
                    'saasValue' => 'AED 340,000',
                    'saasDetail' => '(Renewals + add-on database storage tiers)',
                    'customValue' => 'AED 22,000',
                    'customDetail' => '(Dedicated cloud infrastructure & minor upgrades)',
                ],
                [
                    'metric' => '3-Year Cumulative Spend',
                    'saasValue' => 'AED 1,140,000',
                    'saasDetail' => '($310,000+) (Zero asset equity)',
                    'customValue' => 'AED 229,000 – 284,000',
                    'customDetail' => '($62k–$77k)',
                ],
                [
                    'metric' => 'Net 3-Year Capital Savings',
                    'saasValue' => 'Baseline',
                    'saasDetail' => '',
                    'customValue' => 'AED 856,000 – 911,000',
                    'customDetail' => '(>75% Capital Retained)',
                ],
                [
                    'metric' => 'Adding New Users (50+ Hires)',
                    'saasValue' => '+AED 180,000 / year',
                    'saasDetail' => '(Penalized per seat)',
                    'customValue' => 'AED 0 / year',
                    'customDetail' => '(Unlimited users at no marginal software fee)',
                ],
                [
                    'metric' => 'Intellectual Property Ownership',
                    'saasValue' => 'Proprietary vendor lock-in',
                    'saasDetail' => 'cannot export custom logic',
                    'customValue' => '100% Client-Owned',
                    'customDetail' => 'Source Code, Schemas & Repositories',
                ],
                [
                    'metric' => 'AI Workflow Automation',
                    'saasValue' => 'Costly proprietary add-ons',
                    'saasDetail' => 'with strict token quotas',
                    'customValue' => 'Native LLM & Multi-Agent Pipelines',
                    'customDetail' => 'Running in Private VPC',
                ],
                [
                    'metric' => 'Data Residency Compliance',
                    'saasValue' => 'Multi-tenant shared global clouds',
                    'saasDetail' => '',
                    'customValue' => 'Single-Tenant Deployment',
                    'customDetail' => 'in AWS UAE / Azure UAE North',
                ],
            ],
        ];
    }

    /**
     * Module card icons stay empty until assets are added under public/assets/icons/.
     *
     * @return array<string, mixed>
     */
    protected static function modules(): array
    {
        return [
            'backgroundImage' => 'assets/background/enterprise-ai-erp-modules-bg.webp',
            'eyebrow' => 'Architectural Practice Areas',
            'title' => 'Enterprise Modules Engineered for High-Concurrency UAE Operations',
            'description' => 'We do not deploy one-size-fits-all software. Every module is purpose-built to automate manual steps, eliminate data silos, and provide real-time operational visibility across your regional entities.',
            'items' => [
                [
                    'icon' => 'assets/media/module-icon1.webp',
                    'iconAlt' => 'FTA VAT and corporate tax icon for UAE enterprise ERP modules',
                    'title' => 'FTA VAT & UAE Corporate Tax Compliant Financial Engines',
                    'tags' => ['Automated 5% VAT', 'Corporate Tax Audits', 'Multi-Currency', 'E-Invoicing'],
                    'copy' => 'Multi-entity accounting engines built strictly to UAE Federal Tax Authority (FTA) standards. Automates VAT return preparation, compliant tax invoices, credit notes, and multi-currency ledgers (AED, USD, EUR, SAR, GBP) with automated daily central bank exchange rate updates.',
                ],
                [
                    'icon' => 'assets/media/module-icon2.webp',
                    'iconAlt' => 'Multi-agent AI workflow icon for UAE enterprise ERP modules',
                    'title' => 'Autonomous Multi-Agent AI Workflow Orchestration',
                    'tags' => ['Document Extraction', 'Customs HS Codes', 'Automated Matching', 'RAG Pipelines'],
                    'copy' => 'Move past simple chatbots. We engineer autonomous multi-agent systems using LangGraph and Python. Agents parse unstructured PDF bills of lading, cross-reference customs declarations, validate commercial purchase orders, and execute multi-tier approvals without human data entry.',
                ],
                [
                    'icon' => 'assets/media/module-icon3.webp',
                    'iconAlt' => 'Supply chain and free zone logistics icon for UAE enterprise ERP',
                    'title' => 'Supply Chain, Fleet & Free Zone Logistics Management',
                    'tags' => ['Spot-Quote Calculations', 'Load Matching', 'Customs Clearance', 'Driver Mobile'],
                    'copy' => 'Built on architectural patterns proven in our logistics software deployments (such as our Turbo Trans logistics software). Automates real-time freight dispatch, cross-border customs documentation, and carrier compliance tracking across JAFZA, Dubai South, and Abu Dhabi ports.',
                ],
                [
                    'icon' => 'assets/media/module-icon4.webp',
                    'iconAlt' => 'B2B CRM pipeline icon for UAE enterprise ERP modules',
                    'title' => 'Unified B2B CRM & Multi-Channel Pipeline Automation',
                    'tags' => ['Zero Per-Seat Fees', 'Drag-and-Drop Kanban', 'WhatsApp API', 'Email Sequences'],
                    'copy' => 'Centralize enterprise sales operations. Directly integrates with our specialized Custom CRM Builder services—featuring custom deal velocity tracking, automated lead scoring, and official WhatsApp Business API integrations tailored to Middle East commercial communication habits.',
                    'linkLabel' => 'Custom CRM Builder',
                    'linkRoute' => 'custom-crm-builder',
                ],
                [
                    'icon' => 'assets/media/module-icon5.webp',
                    'iconAlt' => 'Bilingual Arabic English interface icon for UAE enterprise ERP',
                    'title' => 'Bilingual (Arabic & English) Enterprise User Interfaces',
                    'tags' => ['Native RTL / LTR Switching', 'Localized Terminology', 'Executive Dashboards'],
                    'copy' => 'High-performance responsive interfaces built with ReactJS and Tailwind CSS. Features instant, lossless toggling between Right-to-Left (Arabic) and Left-to-Right (English) layouts with localized executive reporting views.',
                ],
                [
                    'icon' => 'assets/media/module-icon6.webp',
                    'iconAlt' => 'Single-tenant cloud security icon for UAE enterprise ERP',
                    'title' => 'Single-Tenant Cloud Security & UAE Data Sovereignty',
                    'tags' => ['AWS UAE (me-central-1)', 'Azure UAE North', 'AES-256', 'Granular RBAC'],
                    'copy' => 'In-country cloud architecture fully compliant with UAE Federal Decree-Law No. 45 of 2021 on Personal Data Protection (PDPL). Features single-tenant database isolation, field-level encryption, and automated encrypted backups.',
                ],
            ],
        ];
    }

    /**
     * Card photos and logos stay empty until assets are added under public/assets/media/.
     *
     * @return array<string, mixed>
     */
    protected static function verticals(): array
    {
        return [
            'eyebrow' => 'Vertical Industry Specialization',
            'title' => 'Tailored ERP & AI Architecture for UAE Commercial Sectors',
            'description' => 'Generic enterprise software breaks when applied to the multi-jurisdictional realities of the UAE. We engineer systems around the exact operational models of key regional industries.',
            'challengeLabel' => 'Operational Challenge',
            'architectureLabel' => 'Custom Architecture',
            'items' => [
                [
                    'image' => 'assets/media/logistics.webp',
                    'imageAlt' => 'Container port terminal for UAE logistics and freight forwarding ERP',
                    'logo' => 'assets/media/logistic-logo.webp',
                    'logoAlt' => 'Logistics freight forwarding logo for UAE enterprise ERP',
                    'title' => 'Logistics, Freight Forwarding & Port Operations',
                    'challenge' => 'Fragmented customs declarations, volatile lane rates, and delayed spot-quote confirmations across UAE trade corridors.',
                    'architecture' => 'Automated spot-quote calculation engines, load-matching modules, and bill of lading extraction agents modeled on our verified Turbo Trans Corporation Custom Software.',
                    'linkLabel' => 'Turbo Trans Corporation Custom Software',
                    'linkRoute' => 'turbo-trans-case-study',
                ],
                [
                    'image' => 'assets/media/real-estate.webp',
                    'imageAlt' => 'Real estate team reviewing a commercial property development model',
                    'logo' => 'assets/media/real-estate-logo.webp',
                    'logoAlt' => 'Real estate development logo for UAE enterprise ERP',
                    'title' => 'Real Estate Developers & Commercial Brokerages',
                    'challenge' => 'Managing multi-property inventory releases, off-plan escrow payment milestones, broker commission splits, and DLD/RERA compliance.',
                    'architecture' => 'Real-time unit availability matrix, automated milestone-based payment schedules, electronic tenancy contract management, and broker commission ledger tracking.',
                ],
                [
                    'image' => 'assets/media/trading.webp',
                    'imageAlt' => 'Trading executives reviewing distribution analytics for UAE conglomerates',
                    'logo' => 'assets/media/trading-logo.webp',
                    'logoAlt' => 'General trading and distribution logo for UAE enterprise ERP',
                    'title' => 'General Trading, Distribution & Conglomerates',
                    'challenge' => 'Managing inventory across bonded Free Zone warehouses and mainland retail outlets, with split VAT accounting and supplier lead times.',
                    'architecture' => 'Multi-warehouse batch tracking, automated inter-company transfers, reorder prediction models, and unified supplier scorecards.',
                ],
                [
                    'image' => 'assets/media/healthcare.webp',
                    'imageAlt' => 'Healthcare clinic operations for UAE multi-specialty enterprise software',
                    'logo' => 'assets/icons/healthcare-icon1.svg',
                    'logoAlt' => 'Healthcare clinic software icon for UAE enterprise ERP',
                    'title' => 'Healthcare Groups & Multi-Specialty Clinics',
                    'challenge' => 'Multi-clinic patient scheduling, revenue cycle management, insurance pre-authorization delays, and Department of Health (DOH/DHA) compliance.',
                    'architecture' => 'Secure patient health record (EHR) integrations, automated insurance claim scrubbers, and deposit protection modeled on our Appointment Insurance & Refund Automation Platform.',
                    'linkLabel' => 'Appointment Insurance & Refund Automation Platform',
                    'linkRoute' => 'appointment-insurance-case-study',
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function governance(): array
    {
        return [
            'eyebrow' => 'Regulatory Governance',
            'title' => 'Built for UAE Legal Compliance, Tax Standards & Data Sovereignty',
            'description' => 'We engineer custom software systems that protect your business from compliance fines and data security risks.',
            'items' => [
                [
                    'title' => 'UAE Personal Data Protection Law (Federal Decree-Law No. 45 of 2021)',
                    'copy' => 'Strict adherence to data subject rights, consent management frameworks, and single-tenant hosting models that keep enterprise records within authorized geographic boundaries.',
                ],
                [
                    'title' => 'Federal Tax Authority (FTA) Compliance',
                    'copy' => 'Built-in accounting logic providing automated 5% VAT calculations, standardized audit files (FAF), and e-invoicing architecture aligned with UAE Ministry of Finance mandates.',
                ],
                [
                    'title' => 'Corporate Tax Readiness (Federal Decree-Law No. 47 of 2022)',
                    'copy' => 'Structured financial ledgers that separate exempt free-zone income from mainland taxable operations, ensuring complete audit readiness for corporate tax submissions.',
                ],
                [
                    'title' => 'In-Country Cloud Hosting',
                    'copy' => 'Deployable on AWS Middle East (UAE) Region (me-central-1 in Abu Dhabi & Dubai) or Microsoft Azure UAE North (Dubai) for complete data residency.',
                ],
            ],
        ];
    }

    /**
     * Tech-card icons stay empty until each items[].icon path is set.
     *
     * @return array<string, mixed>
     */
    protected static function stack(): array
    {
        return [
            'backgroundImage' => 'assets/background/enterprise-ai-erp-stack-bg.webp',
            'eyebrow' => 'Architectural Standards',
            'title' => 'Modern Full-Stack Technologies Engineered for Scale',
            'groups' => [
                [
                    'title' => 'Core Backend Frameworks',
                    'subtitle' => 'Robust & Scalable Backend Solutions',
                    'description' => 'Building secure, high-performance backend systems for modern applications.',
                    'items' => [
                        [
                            'icon' => 'assets/icons/tech/laravel-mark-logo.svg',
                            'iconAlt' => 'Laravel logo for enterprise ERP backend engineering',
                            'name' => 'Laravel',
                            'copy' => '(PHP 8.3+) for transactional robustness',
                        ],
                        [
                            'icon' => 'assets/icons/tech/php-logo.webp',
                            'iconAlt' => 'PHP logo for enterprise ERP backend development',
                            'name' => 'PHP',
                            'copy' => 'For server-side enterprise systems',
                        ],
                        [
                            'icon' => 'assets/icons/tech/node-js.webp',
                            'iconAlt' => 'Node.js logo for real-time enterprise microservices',
                            'name' => 'Node.js',
                            'copy' => '(NestJS) for real-time microservices',
                        ],
                        [
                            'icon' => 'assets/icons/tech/nest.webp',
                            'iconAlt' => 'NestJS logo for scalable enterprise backend services',
                            'name' => 'NestJS',
                            'copy' => 'For modular TypeScript APIs',
                        ],
                        [
                            'icon' => 'assets/icons/tech/python.webp',
                            'iconAlt' => 'Python logo for AI agent orchestration in enterprise ERP',
                            'name' => 'Python',
                            'copy' => '(FastAPI & Celery) for AI agent orchestration',
                        ],
                    ],
                ],
                [
                    'title' => 'Frontend & Dashboards',
                    'subtitle' => 'Modern Interfaces & Interactive Dashboards',
                    'description' => 'Delivering seamless user experiences with modern technologies.',
                    'items' => [
                        [
                            'icon' => 'assets/icons/tech/react.svg',
                            'iconAlt' => 'React logo for dynamic enterprise ERP interfaces',
                            'name' => 'ReactJS',
                            'copy' => 'For dynamic UIs',
                        ],
                        [
                            'icon' => 'assets/icons/tech/next-js.webp',
                            'iconAlt' => 'Next.js logo for high-performance enterprise web apps',
                            'name' => 'Next.js',
                            'copy' => 'For high-performance web apps',
                        ],
                        [
                            'icon' => 'assets/icons/tech/tailwind-logo.webp',
                            'iconAlt' => 'Tailwind CSS logo for bilingual enterprise dashboards',
                            'name' => 'Tailwind CSS',
                            'copy' => 'With full bidirectional RTL/LTR support',
                        ],
                        [
                            'icon' => 'assets/icons/tech/web-sockets.webp',
                            'iconAlt' => 'WebSockets logo for live enterprise connectivity',
                            'name' => 'WebSockets',
                            'copy' => 'For live telemetry',
                        ],
                    ],
                ],
                [
                    'title' => 'Databases & Vector Storage',
                    'subtitle' => 'Reliable Data & Intelligence Search',
                    'description' => 'Powering your application with fast, secure and semantic data solutions.',
                    'items' => [
                        [
                            'icon' => 'assets/icons/tech/postgresql-logo.svg',
                            'iconAlt' => 'PostgreSQL logo for semantic search in enterprise ERP',
                            'name' => 'PostgreSQL',
                            'copy' => '(pgvector for semantic search)',
                        ],
                        [
                            'icon' => 'assets/icons/tech/Redis.webp',
                            'iconAlt' => 'Redis logo for in-memory caching in enterprise systems',
                            'name' => 'Redis',
                            'copy' => '(in-memory caching & job queues)',
                        ],
                        [
                            'icon' => 'assets/icons/tech/elasticSearch-logo.webp',
                            'iconAlt' => 'Elasticsearch logo for high-speed enterprise catalog search',
                            'name' => 'Elasticsearch',
                            'copy' => 'For high-speed catalog querying',
                        ],
                        [
                            'icon' => 'assets/media/mysql-logo.png',
                            'iconAlt' => 'MySQL logo for relational enterprise database storage',
                            'name' => 'MySQL',
                            'copy' => 'For relational enterprise data',
                        ],
                        [
                            'icon' => 'assets/media/Mongo-db.webp',
                            'iconAlt' => 'MongoDB logo for flexible enterprise document storage',
                            'name' => 'MongoDB',
                            'copy' => 'For flexible document storage',
                        ],
                    ],
                ],
                [
                    'title' => 'AI Orchestration & LLMs',
                    'subtitle' => 'Smarter AI Integration & Automation',
                    'description' => 'Leveraging advanced AI models and orchestration tools for intelligent and scalable solutions.',
                    'items' => [
                        [
                            'icon' => 'assets/icons/tech/langGraph-logo.webp',
                            'iconAlt' => 'LangGraph logo for enterprise AI workflow orchestration',
                            'name' => 'LangGraph',
                            'copy' => 'Multi-agent workflow orchestration',
                        ],
                        [
                            'icon' => 'assets/icons/tech/autogen-logo.webp',
                            'iconAlt' => 'AutoGen logo for multi-agent enterprise automation',
                            'name' => 'AutoGen',
                            'copy' => 'Multi-agent automation',
                        ],
                        [
                            'icon' => 'assets/icons/tech/private-llma-logo.webp',
                            'iconAlt' => 'Private Llama logo for secure enterprise AI deployments',
                            'name' => 'Private Llama-3',
                            'copy' => 'Mistral deployments in isolated environments',
                        ],
                        [
                            'icon' => 'assets/icons/tech/Azure-logo.webp',
                            'iconAlt' => 'Azure OpenAI logo for isolated enterprise AI hosting',
                            'name' => 'Azure OpenAI',
                            'copy' => 'Secure instances in isolated VPCs',
                        ],
                        [
                            'icon' => 'assets/media/aws-logo.webp',
                            'iconAlt' => 'AWS logo for enterprise cloud AI hosting',
                            'name' => 'AWS',
                            'copy' => 'Cloud infrastructure for AI workloads',
                        ],
                    ],
                ],
                [
                    'title' => 'Cloud & DevOps',
                    'subtitle' => 'Scalable Infrastructure & Continuous Delivery',
                    'description' => 'Containerized, automated and cloud-native infrastructure for maximum efficiency.',
                    'items' => [
                        [
                            'icon' => 'assets/icons/tech/docker-logo.webp',
                            'iconAlt' => 'Docker logo for enterprise containerization',
                            'name' => 'Docker',
                            'copy' => 'Containerization',
                        ],
                        [
                            'icon' => 'assets/icons/tech/kubernetes-logo.webp',
                            'iconAlt' => 'Kubernetes logo for enterprise container clustering',
                            'name' => 'Kubernetes',
                            'copy' => 'Clustering',
                        ],
                        [
                            'icon' => 'assets/icons/tech/cloudfare-logo.webp',
                            'iconAlt' => 'Cloudflare logo for enterprise content delivery',
                            'name' => 'Cloudflare',
                            'copy' => 'Enterprise CDN',
                        ],
                        [
                            'icon' => 'assets/icons/tech/ci-cd-logo.webp',
                            'iconAlt' => 'Automated CI/CD icon for enterprise deployment pipelines',
                            'name' => 'Automated CI/CD',
                            'copy' => 'Deployment pipelines',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Card photos and logos stay empty until assets are added under public/assets/media/.
     *
     * @return array<string, mixed>
     */
    protected static function delivery(): array
    {
        return [
            'eyebrow' => 'The Strategic Delivery Advantage',
            'title' => 'Why UAE Conglomerates Choose Our Cross-Border Model',
            'description' => 'How Suave Creators delivers world-class software engineering with seamless communication and substantial cost savings.',
            'items' => [
                [
                    'image' => 'assets/media/numbered-banner .webp',
                    'imageAlt' => 'Timezone clock showing the 1.5 hour overlap between UAE and India engineering hours',
                    'logo' => 'assets/icons/clock-icon.webp',
                    'logoAlt' => 'Working hours overlap icon for UAE and India software delivery',
                    'title' => '1.5-Hour Working Hours Overlap (GMT+4 vs. GMT+5:30)',
                    'copy' => 'Our primary engineering center in Palampur, India operates just 90 minutes ahead of Gulf Standard Time (GST). Your project team shares a synchronized working day with our senior software architects. Daily standups, live code reviews, and critical sprint milestones occur in real time via Slack, Microsoft Teams, and Google Meet.',
                ],
                [
                    'image' => 'assets/media/discussion-banner.webp',
                    'imageAlt' => 'UAE and India software teams collaborating on an enterprise ERP project',
                    'logo' => 'assets/icons/clock-icon.webp',
                    'logoAlt' => 'Capital savings icon for custom enterprise software versus local UAE agencies',
                    'title' => 'Up to 60% Capital Savings vs. Local UAE IT Agencies',
                    'copy' => 'Traditional domestic agencies in Dubai and the Big 4 consulting firms charge between AED 450 to AED 900+ per developer hour, with significant markups for account management bloat. Suave Creators provides direct collaboration with senior full-stack architects at a fraction of the cost, saving businesses up to 60% in total development capital.',
                ],
                [
                    'image' => 'assets/media/mind-strategy-banner.webp',
                    'imageAlt' => 'Intellectual property ownership visual for custom enterprise software builds',
                    'logo' => 'assets/icons/clock-icon.webp',
                    'logoAlt' => 'Intellectual property sovereignty icon for client-owned enterprise software',
                    'title' => '100% Intellectual Property Sovereignty',
                    'copy' => 'Every repository, database schema, design token, and compiled build belongs exclusively to your company. Master Service Agreements (MSAs) and Non-Disclosure Agreements (NDAs) are backed by international commercial legal frameworks through our US headquarters (Sheridan, WY).',
                ],
            ],
        ];
    }

    /**
     * Stage icons stay empty until assets are added under public/assets/icons/.
     *
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     items: list<array{
     *         step: string,
     *         icon: string,
     *         iconAlt: string,
     *         title: string,
     *         copy: string,
     *         deliverable: string
     *     }>
     * }
     */
    protected static function lifecycle(): array
    {
        return [
            'eyebrow' => 'Systematic Execution',
            'title' => 'The 5-Stage Engineering Lifecycle: From Blueprint to Production',
            'items' => [
                [
                    'step' => '01',
                    'icon' => 'assets/media/discovery.webp',
                    'iconAlt' => 'Discovery and technical architecture modeling icon for enterprise ERP software',
                    'title' => 'Discovery & Technical Architecture Modeling',
                    'copy' => 'On-site or virtual requirements audit: data schemas, tax rules, API endpoints, and user roles.',
                    'deliverable' => 'System Requirements Specification (SRS), Entity Relationship Diagram (ERD), milestone roadmap.',
                ],
                [
                    'step' => '02',
                    'icon' => 'assets/media/ui-ux-logo.webp',
                    'iconAlt' => 'Bilingual Arabic and English UI UX prototyping icon for enterprise software',
                    'title' => 'Bilingual UI/UX Prototyping (Arabic & English)',
                    'copy' => 'High-fidelity Figma prototypes engineered for intuitive RTL/LTR navigation and workflow speed.',
                    'deliverable' => 'Interactive design system signed off by executive stakeholders prior to engineering.',
                ],
                [
                    'step' => '03',
                    'icon' => 'assets/media/full-stack-logo.webp',
                    'iconAlt' => 'Full-stack agile development and AI integration icon for custom ERP software',
                    'title' => 'Full-Stack Agile Development & AI Integration',
                    'copy' => 'Bi-weekly sprint cycles building modular backend microservices, dynamic dashboards, and AI agents.',
                    'deliverable' => 'Continuous integration builds deployed to an isolated staging environment with live sprint demos.',
                ],
                [
                    'step' => '04',
                    'icon' => 'assets/media/qa-logo.webp',
                    'iconAlt' => 'QA security audit and tax compliance icon for UAE enterprise software',
                    'title' => 'Rigorous QA, Security Audits & Tax Compliance Validation',
                    'copy' => 'Automated unit testing, role permission validation, simulated load spikes, and FTA tax calculation audits.',
                    'deliverable' => 'Security penetration report, sub-second query tuning, and verified compliance sign-off.',
                ],
                [
                    'step' => '05',
                    'icon' => 'assets/media/launch-logo.webp',
                    'iconAlt' => 'Zero-downtime launch and legacy migration icon for enterprise ERP software',
                    'title' => 'Zero-Downtime Launch, Legacy Migration & SLA Support',
                    'copy' => 'Relational data migration from legacy spreadsheets or old ERPs, staff training, and production cutover.',
                    'deliverable' => 'Full codebase handover, comprehensive system documentation, and 24/7 maintenance SLA.',
                ],
            ],
        ];
    }

    /**
     * Card logos stay empty until each icon path is set under public/assets/.
     *
     * @return array{
     *     eyebrow: string,
     *     title: string,
     *     items: list<array{icon: string, iconAlt: string, title: string, value: string, label: string, copy: string}>
     * }
     */
    protected static function evidence(): array
    {
        return [
            'eyebrow' => 'Evidence-Based Engineering',
            'title' => 'Real-World Software Systems Powering Commercial Growth',
            'items' => [
                [
                    'icon' => 'assets/media/ttc-logo.webp',
                    'iconAlt' => 'Turbo Trans logistics software icon for custom dispatch systems',
                    'title' => 'Turbo Trans Corporation Custom Logistics Software',
                    'value' => '3.5×',
                    'label' => 'Faster lead response',
                    'copy' => 'Built real-time dispatch and automated spot-quote calculations, resulting in 3.4x faster lead response times and 42% more qualified loads.',
                ],
                [
                    'icon' => 'assets/media/b2b-crm-logo.webp',
                    'iconAlt' => 'B2B sales CRM pipeline icon for outbound automation software',
                    'title' => 'B2B Sales CRM & Outbound Pipeline Automation',
                    'value' => '35%',
                    'label' => 'Admin effort reduction',
                    'copy' => 'Streamlined outbound sales workflows from twelve manual steps down to four automated actions, achieving a 35% reduction in administrative pipeline effort.',
                ],
                [
                    'icon' => 'assets/media/ai-sales-logo.webp',
                    'iconAlt' => 'AI sales coaching platform icon for real-time call coaching',
                    'title' => 'AI Sales Coaching Platform',
                    'value' => '55%',
                    'label' => 'Faster ramp to quota',
                    'copy' => 'Deployed real-time speech-to-text coaching and post-call objection scoring, delivering 55% faster rep ramp time to quota.',
                ],
                [
                    'icon' => 'assets/media/automation.webp',
                    'iconAlt' => 'Appointment insurance refund automation icon for calendar deposit protection',
                    'title' => 'Appointment Insurance & Smart Refund Automation',
                    'value' => '90%',
                    'label' => 'Processing fee waste eliminated',
                    'copy' => 'Automated calendar deposit protection with smart Stripe refunds, eliminating 90% of credit card processing fee waste.',
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
            'eyebrow' => 'Accelerate Your Enterprise Workflows',
            'title' => 'Ready to Build Your Custom AI-Native ERP System?',
            'description' => 'Speak directly with an enterprise software architect today. We will audit your current operational bottlenecks, review your legacy software licensing costs, and deliver an actionable technical roadmap and TCO model tailored to your UAE operations.',
            'ctaLabel' => 'Schedule a Technical Discovery Consultation',
            'secondaryCtaLabel' => 'Explore Our Custom CRM Builder Services →',
            'cardPosition' => 'top',
            'people' => [
                ['src' => 'assets/media/analyst-headset-custom-crm-dashboard.webp', 'alt' => 'Analyst reviewing an enterprise ERP analytics dashboard during a software consultation', 'tone' => 'pink', 'column' => 'left'],
                ['src' => 'assets/media/executive-tablet-crm-hologram.webp', 'alt' => 'Executive holding a tablet with an enterprise software hologram for an ERP consultation', 'tone' => 'orange', 'column' => 'left'],
                ['src' => 'assets/media/floating-analytics-dashboard-laptop.webp', 'alt' => 'Laptop with a floating analytics dashboard for enterprise ERP consultation', 'tone' => 'yellow', 'column' => 'center'],
                ['src' => 'assets/media/analyst-performance-metrics-laptop.webp', 'alt' => 'Analyst reviewing performance metrics for custom enterprise ERP software consulting', 'tone' => 'blue', 'column' => 'center'],
                ['src' => 'assets/media/crm-contact-hologram-keyboard.webp', 'alt' => 'Enterprise contact hologram above a keyboard for ERP product consultation', 'tone' => 'coral', 'column' => 'right'],
                ['src' => 'assets/media/consultant-crm-team-tablet.webp', 'alt' => 'Consultant using an enterprise team interface on a tablet', 'tone' => 'cyan', 'column' => 'right'],
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
            'title' => 'Frequently Asked Questions About Enterprise AI & ERP in the UAE',
            'description' => 'Answers to key technical, commercial, and legal questions regarding custom enterprise software development in the United Arab Emirates.',
            'backgroundImage' => 'assets/background/custom-crm-builder-faq-bg.webp',
            'items' => [
                [
                    'question' => 'What are enterprise AI and ERP solutions in the UAE?',
                    'answer' => 'Enterprise AI and ERP solutions in the UAE are custom-built software architectures that combine core resource planning modules—such as inventory management, procurement, multi-entity accounting, and logistics—with autonomous artificial intelligence agents. Designed specifically for the UAE regulatory landscape, these platforms natively incorporate Federal Tax Authority (FTA) 5% VAT rules, UAE Corporate Tax compliance, bilingual Arabic-English interfaces, and single-tenant data hosting within UAE cloud regions (AWS UAE or Azure UAE).',
                ],
                [
                    'question' => 'How does custom ERP development compare to SAP or Oracle in the UAE?',
                    'answer' => 'Traditional enterprise platforms like SAP or Oracle require significant upfront integration retainers and recurring annual per-user licensing fees that easily exceed AED 500,000 to AED 1,500,000 for mid-market UAE organizations over three years. A bespoke ERP built by Suave Creators requires a one-time development investment (typically AED 150,000 to AED 350,000), delivers 100% source code ownership, eliminates all recurring per-seat fees, and adapts completely to your proprietary business workflows without forcing you to change how your team operates.',
                ],
                [
                    'question' => 'Are your custom ERP solutions compliant with UAE VAT and Corporate Tax regulations?',
                    'answer' => 'Yes. All financial accounting engines built by Suave Creators are engineered to comply with UAE Federal Tax Authority (FTA) regulations, including automated 5% VAT calculations, standardized Tax Invoices, Credit Notes, and compliant audit trails supporting UAE Corporate Tax filing under Federal Decree-Law No. 47 of 2022.',
                ],
                [
                    'question' => 'How does the timezone alignment work between the UAE and your engineering center?',
                    'answer' => 'Our primary engineering center operates on Indian Standard Time (GMT+5:30), providing near-total daily working hours overlap with Dubai and Abu Dhabi business hours (GST is GMT+4, a 1.5-hour difference). This enables real-time Slack/Teams collaboration, immediate sprint demos, and same-day deployment cycles without asynchronous communication delays.',
                ],
                [
                    'question' => 'Can your enterprise AI agents automate UAE customs clearance and logistics documentation?',
                    'answer' => 'Yes. We build autonomous multi-agent AI pipelines that ingest unstructured PDFs, bills of lading, and commercial invoices to automate customs duty calculations, cross-reference HS codes, and synchronize shipment milestones directly into your logistics dispatch portal without manual data entry.',
                ],
                [
                    'question' => 'Who owns the source code and data under your cross-border agreement?',
                    'answer' => 'You own everything. Upon milestone delivery and settlement, 100% of the intellectual property, source code repositories, and database schemas are transferred directly to your organization. Master Service Agreements and NDAs are backed by international commercial legal frameworks via our US corporate headquarters.',
                ],
            ],
        ];
    }

    /**
     * @return array{seoJsonLdGraph: array<int, array<string, mixed>>, seoJsonLdWebpageAbout: string}
     */
    protected static function seoStructuredData(): array
    {
        $pageUrl = rtrim(route('enterprise-ai-erp-uae'), '/');
        $serviceId = $pageUrl.'/#service';
        $baseUrl = rtrim((string) config('app.url', url('/')), '/');

        return [
            'seoJsonLdGraph' => [[
                '@type' => 'Service',
                '@id' => $serviceId,
                'name' => 'Enterprise AI & Custom ERP Software Solutions UAE',
                'serviceType' => 'Enterprise Software & AI Engineering',
                'provider' => [
                    '@id' => $baseUrl.'/#organization',
                ],
                'url' => $pageUrl,
                'description' => 'Bespoke enterprise ERP software and autonomous AI agent systems for UAE enterprises. Features FTA VAT compliance, bilingual Arabic/English interfaces, and zero per-seat licensing fees.',
                'areaServed' => [
                    ['@type' => 'Country', 'name' => 'United Arab Emirates'],
                    ['@type' => 'City', 'name' => 'Dubai'],
                    ['@type' => 'City', 'name' => 'Abu Dhabi'],
                ],
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog',
                    'name' => 'UAE Enterprise Technology Capabilities',
                    'itemListElement' => [
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Custom ERP Development & Architecture']],
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Autonomous Multi-Agent AI Workflow Pipelines']],
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'FTA VAT (5%) & Corporate Tax Compliant Financial Engines']],
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Bilingual (Arabic/English) Enterprise Portal Engineering']],
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Single-Tenant Cloud Hosting (AWS/Azure UAE Regions)']],
                    ],
                ],
            ]],
            'seoJsonLdWebpageAbout' => $serviceId,
        ];
    }
}
