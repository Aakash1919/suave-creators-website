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
            'metricsTitle' => 'Trust & Credibility Metrics Bar (UAE Enterprise Scale)',
            'metrics' => self::metrics(),
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
        ];
    }

    /**
     * @return list<array{value: string, detail: string}>
     */
    protected static function metrics(): array
    {
        return [
            [
                'value' => 'AED 450K+',
                'detail' => 'Average 3-Yr TCO Capital Savings vs. Legacy ERP Vendors (SAP / Oracle)',
            ],
            [
                'value' => '1.5 Hour',
                'detail' => 'Time Zone Overlap. Direct real-time collaboration with UAE business hours',
            ],
            [
                'value' => '100%',
                'detail' => 'Code Sovereignty. Complete source code transfer to your private repo',
            ],
            [
                'value' => 'Zero',
                'detail' => 'Per-Seat Licensing Tax. Add unlimited employees, reps & external partners',
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
                    'icon' => '',
                    'iconAlt' => 'FTA VAT and corporate tax icon for UAE enterprise ERP modules',
                    'title' => 'FTA VAT & UAE Corporate Tax Compliant Financial Engines',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => '',
                    'iconAlt' => 'Multi-agent AI workflow icon for UAE enterprise ERP modules',
                    'title' => 'Autonomous Multi-Agent AI Workflow Orchestration',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => '',
                    'iconAlt' => 'Supply chain and free zone logistics icon for UAE enterprise ERP',
                    'title' => 'Supply Chain, Fleet & Free Zone Logistics Management',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => '',
                    'iconAlt' => 'B2B CRM pipeline icon for UAE enterprise ERP modules',
                    'title' => 'Unified B2B CRM & Multi-Channel Pipeline Automation',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => '',
                    'iconAlt' => 'Bilingual Arabic English interface icon for UAE enterprise ERP',
                    'title' => 'Bilingual (Arabic & English) Enterprise User Interfaces',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
                [
                    'icon' => '',
                    'iconAlt' => 'Single-tenant cloud security icon for UAE enterprise ERP',
                    'title' => 'Single-Tenant Cloud Security & UAE Data Sovereignty',
                    'tags' => $tags,
                    'copy' => $copy,
                ],
            ],
        ];
    }
}
