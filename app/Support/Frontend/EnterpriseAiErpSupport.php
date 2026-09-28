<?php

namespace App\Support\Frontend;

class EnterpriseAiErpSupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return [
            'bodyClass' => 'min-h-screen bg-white font-sans text-slate-900',
            'mainClass' => 'site-main site-main--enterprise-ai-erp',
            'demoHref' => ContactSupport::demoHref(),
            'eyebrow' => 'Bespoke software engineering for SME & GCC enterprises',
            'heroLead' => 'Enterprise AI &',
            'heroMid' => 'Custom ERP Solutions',
            'heroAccent' => 'in the UAE',
            'heroDescription' => 'Build resilient, AI-native ERP platforms and autonomous workflow agents tailored to your company\'s operational hierarchy. Eliminate recurring per-seat software taxes with 100% code ownership, bilingual Arabic-English interfaces, and complete UAE regulatory compliance (FTA VAT & Corporate Tax).',
            'primaryCta' => 'Schedule a Technical Discovery Session',
            'secondaryCta' => 'Let\'s Connect',
            'visualLabel' => 'Enterprise command center',
            'bannerBackgroundImage' => 'assets/media/erp-banner-bg.webp',
            'trustBackgroundImage' => 'assets/background/crm-trust-triangle-pattern.webp',
            'trustEyebrow' => 'TRUST & CREDIBILITY',
            'trustTitle' => 'Trusted at UAE Enterprise Scale',
            'trustDescription' => 'These operating metrics reflect how Suave Creators builds client-owned ERP platforms for Dubai, Abu Dhabi, and the wider GCC: lower three-year cost, real-time overlap with UAE business hours, full source-code handover, and no per-seat license tax.',
            'trustLinkText' => 'Explore All Services',
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
                'label' => 'Average 3-Yr TCO Capital Savings',
                'detail' => 'Versus legacy ERP vendors (SAP / Oracle)',
            ],
            [
                'value' => '1.5 Hour',
                'label' => 'Time Zone Overlap',
                'detail' => 'Direct real-time collaboration with UAE business hours',
            ],
            [
                'value' => '100%',
                'label' => 'Code Sovereignty',
                'detail' => 'Complete source code transfer to your private repo',
            ],
            [
                'value' => 'Zero',
                'label' => 'Per-Seat Licensing Tax',
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
        $capitalRow = [
            'metric' => 'Year 1 Capital Investment',
            'saasValue' => '$90,000',
            'saasDetail' => '$150/user/mo + mandatory onboarding & tier-1 add-ons',
            'customValue' => '$45,000–$65,000',
            'customDetail' => 'Full-cycle architecture, UI/UX, and production build',
        ];

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
                $capitalRow,
                $capitalRow,
                $capitalRow,
                $capitalRow,
                $capitalRow,
                $capitalRow,
                $capitalRow,
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
        $tags = ['Automated 5% VAT', 'Corporate Tax Audits', 'Multi-Currency', 'E-Invoicing 5% VAT'];
        $copy = 'Multi-entity accounting engines built strictly to UAE Federal Tax Authority (FTA) standards. Automates VAT return preparation, compliant tax invoices, credit notes, and multi-currency ledgers (AED, USD, EUR, SAR, GBP) with automated daily central bank exchange rate updates.';

        return [
            'eyebrow' => 'Architectural Practice Areas',
            'title' => 'Enterprise Modules Engineered for High-Concurrency UAE Operations',
            'description' => 'We do not deploy one-size-fits-all software. Every module is purpose-built to automate manual steps, eliminate data silos, and provide real-time operational visibility across your regional entities.',
            'items' => [
                [
                    'icon' => 'assets/media/module-icon1.webp',
                    'iconAlt' => 'FTA VAT and corporate tax icon for UAE enterprise ERP modules',
                    'title' => 'FTA VAT & UAE Corporate Tax Compliant Financial Engines',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => 'assets/media/module-icon2.webp',
                    'iconAlt' => 'Multi-agent AI workflow icon for UAE enterprise ERP modules',
                    'title' => 'Autonomous Multi-Agent AI Workflow Orchestration',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => 'assets/media/module-icon3.webp',
                    'iconAlt' => 'Supply chain and free zone logistics icon for UAE enterprise ERP',
                    'title' => 'Supply Chain, Fleet & Free Zone Logistics Management',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => 'assets/media/module-icon4.webp',
                    'iconAlt' => 'B2B CRM pipeline icon for UAE enterprise ERP modules',
                    'title' => 'Unified B2B CRM & Multi-Channel Pipeline Automation',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => 'assets/media/module-icon5.webp',
                    'iconAlt' => 'Bilingual Arabic English interface icon for UAE enterprise ERP',
                    'title' => 'Bilingual (Arabic & English) Enterprise User Interfaces',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => 'assets/media/module-icon6.webp',
                    'iconAlt' => 'Single-tenant cloud security icon for UAE enterprise ERP',
                    'title' => 'Single-Tenant Cloud Security & UAE Data Sovereignty',
                    'tags' => $tags,
                    'copy' => $copy,
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
        $challenge = 'Fragmented customs declarations, volatile lane rates, and delayed spot-quote confirmations across UAE trade corridors.';
        $architecture = 'Automated spot-quote calculation engines, lead-matching modules, and bill-of-lading extraction agents modeled on our verified Turbo Trans Corporation Custom Software.';

        return [
            'eyebrow' => 'Vertical Industry Specialization',
            'title' => 'Tailored ERP & AI Architecture for UAE Commercial Sectors',
            'description' => 'Generic enterprise software breaks when applied to the multi-jurisdictional realities of the UAE. We engineer systems around the exact operational models of key regional industries.',
            'challengeLabel' => 'Operational Challenge',
            'architectureLabel' => 'Custom Architecture',
            'items' => [
                [
                    'image' => '',
                    'imageAlt' => 'Container port terminal for UAE logistics and freight forwarding ERP',
                    'logo' => '',
                    'logoAlt' => 'Logistics freight forwarding logo for UAE enterprise ERP',
                    'title' => 'Logistics, Freight Forwarding & Port Operations',
                    'challenge' => $challenge,
                    'architecture' => $architecture,
                ],
                [
                    'image' => '',
                    'imageAlt' => 'Real estate team reviewing a commercial property development model',
                    'logo' => '',
                    'logoAlt' => 'Real estate development logo for UAE enterprise ERP',
                    'title' => 'Real Estate Developers & Commercial Brokerages',
                    'challenge' => $challenge,
                    'architecture' => $architecture,
                ],
                [
                    'image' => '',
                    'imageAlt' => 'Trading executives reviewing distribution analytics for UAE conglomerates',
                    'logo' => '',
                    'logoAlt' => 'General trading and distribution logo for UAE enterprise ERP',
                    'title' => 'General Trading, Distribution & Conglomerates',
                    'challenge' => $challenge,
                    'architecture' => $architecture,
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
            'description' => 'We engineer custom software systems that protect your business from compliance fines and data security risks specific to the UAE regulatory environment.',
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
            'eyebrow' => 'Architectural Standards',
            'title' => 'Modern Full-Stack Technologies Engineered for Scale',
            'groups' => [
                [
                    'title' => 'Core Backend',
                    'subtitle' => 'Robust & Scalable Backend Solutions',
                    'description' => 'Building secure, high-performance backend systems for modern applications.',
                    'items' => [
                        [
                            'icon' => '',
                            'iconAlt' => 'Laravel logo for enterprise ERP backend engineering',
                            'name' => 'Laravel',
                            'copy' => '(PHP 8.3+) for transactional robustness',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'PHP logo for scalable enterprise web applications',
                            'name' => 'PHP',
                            'copy' => 'for scalable web applications',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Node.js logo for real-time enterprise environments',
                            'name' => 'Node.js',
                            'copy' => 'for real-time microservices',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Nest logo for production enterprise API development',
                            'name' => 'Nest',
                            'copy' => '(PHP 8.3+) for structured & scalable APIs',
                        ],
                        [
                            'icon' => '',
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
                            'icon' => '',
                            'iconAlt' => 'React logo for dynamic enterprise ERP interfaces',
                            'name' => 'ReactJS',
                            'copy' => 'for dynamic UIs',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Next.js logo for high-performance enterprise web apps',
                            'name' => 'Next.js',
                            'copy' => 'for high-performance web apps',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Tailwind CSS logo for bilingual enterprise dashboards',
                            'name' => 'Tailwind CSS',
                            'copy' => 'with optimized RTL/LTR support',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'TypeScript logo for type-safe enterprise application code',
                            'name' => 'TypeScript',
                            'copy' => 'for type-safe code',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'WebSockets logo for live enterprise connectivity',
                            'name' => 'Web Sockets',
                            'copy' => 'for live connectivity',
                        ],
                    ],
                ],
                [
                    'title' => 'Databases & Vector Storage',
                    'subtitle' => 'Reliable Data & Intelligence Search',
                    'description' => 'Powering your application with fast, secure and semantic data solutions.',
                    'items' => [
                        [
                            'icon' => '',
                            'iconAlt' => 'PostgreSQL logo for semantic search in enterprise ERP',
                            'name' => 'PostgreSQL',
                            'copy' => 'SQL engine for semantic search',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Redis logo for in-memory caching in enterprise systems',
                            'name' => 'Redis',
                            'copy' => 'In-memory caching & persistent',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Elasticsearch logo for high-speed enterprise catalog search',
                            'name' => 'Elasticsearch',
                            'copy' => 'for high-speed catalog querying',
                        ],
                    ],
                ],
                [
                    'title' => 'AI Orchestration & LLMs',
                    'subtitle' => 'Smarter AI Integration & Automation',
                    'description' => 'Leveraging advanced AI models and orchestration tools for intelligent and scalable solutions.',
                    'items' => [
                        [
                            'icon' => '',
                            'iconAlt' => 'LangGraph logo for enterprise AI workflow orchestration',
                            'name' => 'LangGraph',
                            'copy' => 'Lang Graph',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'AutoGen logo for multi-agent enterprise automation',
                            'name' => 'AutoGen',
                            'copy' => 'Auto Gen',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Private Llama logo for secure enterprise AI deployments',
                            'name' => 'Private Llama-3',
                            'copy' => 'for secure deployments on internal enterprise',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Azure OpenAI logo for isolated enterprise AI hosting',
                            'name' => 'Azure',
                            'copy' => 'Azure Open AI for hosted & isolated VPCs',
                        ],
                    ],
                ],
                [
                    'title' => 'Cloud & DevOps',
                    'subtitle' => 'Scalable Infrastructure & Continuous Delivery',
                    'description' => 'Containerized, automated and cloud-native infrastructure for maximum efficiency.',
                    'items' => [
                        [
                            'icon' => '',
                            'iconAlt' => 'Docker logo for enterprise containerization',
                            'name' => 'Docker',
                            'copy' => 'Docker Containerization',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Kubernetes logo for enterprise container clustering',
                            'name' => 'Kubernetes',
                            'copy' => 'Kubernetes clustering',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Cloudflare logo for enterprise content delivery',
                            'name' => 'Cloudflare',
                            'copy' => 'Enterprise CDN',
                        ],
                        [
                            'icon' => '',
                            'iconAlt' => 'Automated CI/CD icon for enterprise deployment pipelines',
                            'name' => 'Automated CI/CD',
                            'copy' => 'deployment pipelines',
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
                    'image' => '',
                    'imageAlt' => 'Timezone clock showing the 1.5 hour overlap between UAE and India engineering hours',
                    'logo' => '',
                    'logoAlt' => 'Working hours overlap icon for UAE and India software delivery',
                    'title' => '1.5-Hour Working Hours Overlap (GMT+4 vs. GMT+5:30)',
                    'copy' => 'Our primary engineering center in Palampur, India operates just 90 minutes ahead of Gulf Standard Time (GST). Your project team shares a synchronized working day with our senior software architects. Daily standups, live code reviews, and critical sprint milestones occur in real time via Slack, Microsoft Teams, and Google Meet.',
                ],
                [
                    'image' => '',
                    'imageAlt' => 'UAE and India software teams collaborating on an enterprise ERP project',
                    'logo' => '',
                    'logoAlt' => 'Capital savings icon for custom enterprise software versus local UAE agencies',
                    'title' => 'Up to 60% Capital Savings vs. Local UAE IT Agencies',
                    'copy' => 'Traditional domestic agencies in Dubai and the Big 4 consulting firms charge between AED 450 to AED 900+ per developer hour, with significant markups for account management bloat. Suave Creators provides direct collaboration with senior full-stack architects at a fraction of the cost, saving businesses up to 60% in total development capital.',
                ],
                [
                    'image' => '',
                    'imageAlt' => 'Intellectual property ownership visual for custom enterprise software builds',
                    'logo' => '',
                    'logoAlt' => 'Intellectual property sovereignty icon for client-owned enterprise software',
                    'title' => '100% Intellectual Property Sovereignty',
                    'copy' => 'Every repository, database schema, design token, and compiled build belongs exclusively to your company. Master Service Agreements (MSAs) and Non-Disclosure Agreements (NDAs) are backed by international commercial legal frameworks through our US headquarters (Sheridan, WY).',
                ],
            ],
        ];
    }
}
