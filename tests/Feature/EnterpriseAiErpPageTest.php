<?php

namespace Tests\Feature;

use Tests\TestCase;

class EnterpriseAiErpPageTest extends TestCase
{
    public function test_enterprise_ai_erp_page_renders_hero_and_is_not_in_the_nav(): void
    {
        $response = $this->get(route('enterprise-ai-erp-uae', absolute: false));

        $response->assertOk();
        $response->assertSee('Enterprise AI &amp;', false);
        $response->assertSee('Custom ERP Solutions', false);
        $response->assertSee('in the UAE', false);
        $response->assertSee('FTA VAT &amp; Corporate Tax', false);
        $response->assertSee('Schedule a Technical Discovery Session', false);
        $response->assertSee('Let&#039;s Connect', false);
        $response->assertSee('crm-builder-trust-band', false);
        $response->assertSee('Trusted at UAE Enterprise Scale', false);
        $response->assertSee('AED 450K+', false);
        $response->assertSee('1.5 Hour', false);
        $response->assertSee('Code Sovereignty', false);
        $response->assertSee('Per-Seat Licensing Tax', false);
        $response->assertSee('What are enterprise AI and ERP solutions in the UAE?', false);
        $response->assertSee('Discuss Your Enterprise Architecture Blueprint', false);
        $response->assertSee('zero per-user licensing fees.', false);
        $response->assertSee('Strategic Capital Allocation', false);
        $response->assertSee('Break Free from Rigid Legacy ERPs &amp; Escalating SaaS Licensing', false);
        $response->assertSee('legacy ERP systems are taxing commercial growth.', false);
        $response->assertSee('enterprise-ai-erp-allocation__tile--center', false);
        $response->assertSee('assets/media/cloud-platform-hologram.webp', false);
        $response->assertSee('assets/media/saas-database-workflow-diagram.webp', false);
        $response->assertSee('The 3-Year TCO Advantage: Commercial ERP SaaS vs. Suave Creators Custom Build', false);
        $response->assertSee('crm-builder-tco__table', false);
        $response->assertSee('AED 480,000', false);
        $response->assertSee('Commercial Tier-1 ERP', false);
        $response->assertSee('Enterprise Modules Engineered for High-Concurrency UAE Operations', false);
        $response->assertSee('Architectural Practice Areas', false);
        $response->assertSee('FTA VAT &amp; UAE Corporate Tax Compliant Financial Engines', false);
        $response->assertDontSee('enterprise-ai-erp-modules__icon-placeholder', false);
        $response->assertSee('assets/media/module-icon1.webp', false);
        $response->assertSee('enterpriseModulesSwiper', false);
        $response->assertSee('Tailored ERP &amp; AI Architecture for UAE Commercial Sectors', false);
        $response->assertSee('Vertical Industry Specialization', false);
        $response->assertSee('Logistics, Freight Forwarding &amp; Port Operations', false);
        $response->assertSee('Real Estate Developers &amp; Commercial Brokerages', false);
        $response->assertSee('General Trading, Distribution &amp; Conglomerates', false);
        $response->assertSee('enterprise-ai-erp-verticals__image-placeholder', false);
        $response->assertSee('enterprise-ai-erp-verticals__logo-placeholder', false);
        $response->assertSee('Built for UAE Legal Compliance, Tax Standards &amp; Data Sovereignty', false);
        $response->assertSee('Regulatory Governance', false);
        $response->assertSee('Federal Tax Authority (FTA) Compliance', false);
        $response->assertSee('In-Country Cloud Hosting', false);
        $response->assertSee('Modern Full-Stack Technologies Engineered for Scale', false);
        $response->assertSee('Architectural Standards', false);
        $response->assertSee('Core Backend', false);
        $response->assertSee('Laravel', false);
        $response->assertSee('enterprise-ai-erp-stack__icon-placeholder', false);
        $response->assertSee('Why UAE Conglomerates Choose Our Cross-Border Model', false);
        $response->assertSee('The Strategic Delivery Advantage', false);
        $response->assertSee('1.5-Hour Working Hours Overlap (GMT+4 vs. GMT+5:30)', false);
        $response->assertSee('Up to 60% Capital Savings vs. Local UAE IT Agencies', false);
        $response->assertSee('100% Intellectual Property Sovereignty', false);
        $response->assertSee('enterprise-ai-erp-delivery__image-placeholder', false);
        $response->assertSee('enterprise-ai-erp-delivery__logo-placeholder', false);
        $response->assertDontSee('enterprise-ai-erp-modules__grid', false);
        $response->assertSee('Cloud platform hologram for custom enterprise ERP software', false);
        $response->assertSee('assets/media/erp-banner-bg.webp', false);
        $response->assertSee('enterprise-ai-erp-circuit-pattern.webp', false);
        $response->assertSee('enterprise-ai-erp-hero__visual', false);
        $response->assertSee('style-deferred.css', false);
        $response->assertSee('Enterprise command center', false);
        $response->assertDontSee('href="'.route('enterprise-ai-erp-uae', absolute: false).'"', false);
    }
}
