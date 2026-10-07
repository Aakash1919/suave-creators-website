<?php

namespace Tests\Feature;

use Tests\TestCase;

class EnterpriseAiErpPageTest extends TestCase
{
    public function test_enterprise_ai_erp_page_renders_hero_and_is_not_in_the_nav(): void
    {
        $response = $this->get(route('enterprise-ai-erp-uae', absolute: false));

        $response->assertOk();
        $response->assertSee('<meta name="theme-color" content="#0F172A">', false);
        $this->assertSame(1, substr_count($response->getContent(), 'name="theme-color"'));
        $this->assertSame('/uae/services/enterprise-ai-erp-solutions', route('enterprise-ai-erp-uae', absolute: false));
        $response->assertSee('Enterprise AI &amp;', false);
        $response->assertSee('Custom ERP Solutions', false);
        $response->assertSee('in the UAE', false);
        $response->assertSee('FTA VAT &amp; Corporate Tax', false);
        $response->assertSee('Schedule a Technical Discovery Session', false);
        $response->assertSee('Let&#039;s Connect', false);
        $response->assertSee('assets/media/soft-white-right-arrow.png', false);
        $response->assertSee('crm-builder-trust-band', false);
        $response->assertSee('Trust &amp; Credibility Metrics Bar (UAE Enterprise Scale)', false);
        $response->assertDontSee('crm-builder-trust__eyebrow', false);
        $response->assertDontSee('crm-builder-trust__desc', false);
        $response->assertSee('AED 450K+', false);
        $response->assertSee('1.5 Hour', false);
        $response->assertSee('Timezone Overlap', false);
        $response->assertSee('100% Code', false);
        $response->assertSee('Licensing Tax', false);
        $response->assertSee('Enterprise AI in Action:', false);
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
        $response->assertSee('AED 320,000', false);
        $response->assertSee('AED 856,000 – 911,000', false);
        $response->assertSee('Commercial Tier-1 ERP', false);
        $response->assertDontSee('Year 1 Capital Investment', false);
        $response->assertSee('Enterprise Modules Engineered for High-Concurrency UAE Operations', false);
        $response->assertSee('assets/background/enterprise-ai-erp-modules-bg.webp', false);
        $response->assertSee('Architectural Practice Areas', false);
        $response->assertSee('FTA VAT &amp; UAE Corporate Tax Compliant Financial Engines', false);
        $response->assertDontSee('enterprise-ai-erp-modules__icon-placeholder', false);
        $response->assertSee('assets/media/module-icon1.webp', false);
        $response->assertSee('enterpriseModulesSwiper', false);
        $response->assertSee('Tailored ERP &amp; AI Architecture for UAE Commercial Sectors', false);
        $response->assertSee('enterpriseVerticalsSwiper', false);
        $response->assertDontSee('enterprise-ai-erp-verticals__grid', false);
        $response->assertSee('Vertical Industry Specialization', false);
        $response->assertSee('Logistics, Freight Forwarding &amp; Port Operations', false);
        $response->assertSee('Real Estate Developers &amp; Commercial Brokerages', false);
        $response->assertSee('General Trading, Distribution &amp; Conglomerates', false);
        $response->assertSee('Healthcare Groups &amp; Multi-Specialty Clinics', false);
        $response->assertSee('load-matching modules', false);
        $response->assertSee('assets/media/healthcare.webp', false);
        $response->assertSee('RAG Pipelines', false);
        $response->assertSee(route('custom-crm-builder', absolute: false), false);
        $response->assertSee(route('turbo-trans-case-study', absolute: false), false);
        $response->assertSee('assets/media/logistics.webp', false);
        $response->assertSee('assets/media/logistic-logo.webp', false);
        $response->assertDontSee('enterprise-ai-erp-verticals__image-placeholder', false);
        $response->assertDontSee('enterprise-ai-erp-verticals__logo-placeholder', false);
        $response->assertSee('Built for UAE Legal Compliance, Tax Standards &amp; Data Sovereignty', false);
        $response->assertSee('Regulatory Governance', false);
        $response->assertSee('Federal Tax Authority (FTA) Compliance', false);
        $response->assertSee('In-Country Cloud Hosting', false);
        $response->assertSee('Modern Full-Stack Technologies Engineered for Scale', false);
        $response->assertSee('assets/background/enterprise-ai-erp-stack-bg.webp', false);
        $response->assertSee('Architectural Standards', false);
        $response->assertSee('Core Backend', false);
        $response->assertSee('Laravel', false);
        $response->assertSee('assets/icons/tech/laravel-mark-logo.svg', false);
        $response->assertSee('assets/icons/tech/php-logo.webp', false);
        $response->assertSee('PHP logo for enterprise ERP backend development', false);
        $response->assertSee('assets/icons/tech/nest.webp', false);
        $response->assertSee('NestJS logo for scalable enterprise backend services', false);
        $response->assertDontSee('enterprise-ai-erp-stack__name">TypeScript', false);
        $response->assertDontSee('enterprise-ai-erp-stack__name">Vue', false);
        $response->assertSee('MySQL', false);
        $response->assertSee('MongoDB', false);
        $response->assertSee('AWS', false);
        $response->assertDontSee('enterprise-ai-erp-stack__icon-placeholder', false);
        $response->assertSee('Why UAE Conglomerates Choose Our Cross-Border Model', false);
        $response->assertSee('The Strategic Delivery Advantage', false);
        $response->assertSee('1.5-Hour Working Hours Overlap (GMT+4 vs. GMT+5:30)', false);
        $response->assertSee('Up to 60% Capital Savings vs. Local UAE IT Agencies', false);
        $response->assertSee('100% Intellectual Property Sovereignty', false);
        $response->assertSee('assets/media/numbered-banner .webp', false);
        $response->assertSee('assets/icons/clock-icon.webp', false);
        $response->assertDontSee('enterprise-ai-erp-delivery__image-placeholder', false);
        $response->assertDontSee('enterprise-ai-erp-delivery__logo-placeholder', false);
        $response->assertSee('Systematic Execution', false);
        $response->assertSee('The 5-Stage Engineering Lifecycle: From Blueprint to Production', false);
        $response->assertSee('Discovery &amp; Technical Architecture Modeling', false);
        $response->assertDontSee('enterprise-ai-erp-lifecycle__icon-placeholder', false);
        $response->assertSee('assets/media/discovery.webp', false);
        $response->assertSee('Interactive design system signed off by executive stakeholders prior to engineering.', false);
        $response->assertDontSee('enterprise-ai-erp-modules__grid', false);
        $response->assertSee('Cloud platform hologram for custom enterprise ERP software', false);
        $response->assertSee('assets/media/erp-banner-bg.webp', false);
        $response->assertSee('property="og:image" content="'.rtrim((string) config('app.url'), '/').'/assets/media/enterprise-ai-erp-og-banner.webp"', false);
        $response->assertDontSee('og:image" content="'.rtrim((string) config('app.url'), '/').'/assets/media/erp-banner-bg.webp"', false);
        $response->assertSee('enterprise-ai-erp-circuit-pattern.webp', false);
        $response->assertSee('enterprise-ai-erp-hero__visual', false);
        $response->assertSee('Bilingual Arabic-English', false);
        $response->assertSee('Custom ERP Platforms', false);
        $response->assertSee('AI-Powered Automation', false);
        $response->assertSee('UAE Regulatory Compliance', false);
        $response->assertSee('enterprise-ai-erp-hero__feature--bilingual', false);
        $response->assertSee('enterprise-ai-erp-hero__feature--platforms', false);
        $response->assertSee('enterprise-ai-erp-hero__feature--automation', false);
        $response->assertSee('enterprise-ai-erp-hero__feature--compliance', false);
        $response->assertSee('assets/media/laptop-image.webp', false);
        $response->assertSee('assets/media/arabic-english-logo.webp', false);
        $response->assertSee('assets/media/custom-erp-logo.png', false);
        $response->assertSee('assets/media/ai-logo.webp', false);
        $response->assertSee('assets/media/compliance-logo.webp', false);
        $response->assertDontSee('enterprise-ai-erp-hero__icon-placeholder', false);
        $response->assertDontSee('enterprise-ai-erp-hero__image-placeholder', false);
        $response->assertDontSee('assets/media/enterprise-erp-banner.webp', false);
        $response->assertSee('style-deferred.css', false);
        $response->assertSee('Enterprise ERP dashboard laptop for UAE custom software', false);
        $response->assertDontSee('href="'.route('enterprise-ai-erp-uae', absolute: false).'"', false);
    }

    public function test_enterprise_ai_erp_page_renders_faq_cta_and_partnerships_after_delivery(): void
    {
        $html = $this->get(route('enterprise-ai-erp-uae', absolute: false))->assertOk()->getContent();

        $deliveryPosition = strpos($html, 'enterprise-ai-erp-delivery');
        $lifecyclePosition = strpos($html, 'enterprise-ai-erp-lifecycle');
        $faqPosition = strpos($html, 'faq-section--crm-builder');
        $evidencePosition = strpos($html, 'enterprise-ai-erp-evidence');
        $consultationPosition = strpos($html, 'id="consultation"');
        $partnersPosition = strpos($html, 'crm-builder-partners');

        $this->assertNotFalse($deliveryPosition);
        $this->assertNotFalse($lifecyclePosition);
        $this->assertNotFalse($faqPosition);
        $this->assertNotFalse($evidencePosition);
        $this->assertNotFalse($consultationPosition);
        $this->assertNotFalse($partnersPosition);
        $this->assertGreaterThan($deliveryPosition, $lifecyclePosition);
        $this->assertGreaterThan($lifecyclePosition, $faqPosition);
        $this->assertGreaterThan($faqPosition, $evidencePosition);
        $this->assertGreaterThan($evidencePosition, $consultationPosition);
        $this->assertGreaterThan($consultationPosition, $partnersPosition);
        $this->assertStringContainsString('Evidence-Based Engineering', $html);
        $this->assertStringContainsString('Real-World Software Systems Powering Commercial Growth', $html);
        $this->assertStringContainsString('Turbo Trans Corporation Custom Logistics Software', $html);
        $this->assertStringContainsString('3.5×', $html);
        $this->assertStringContainsString('Faster lead response', $html);
        $this->assertStringContainsString('B2B Sales CRM &amp; Outbound Pipeline Automation', $html);
        $this->assertStringContainsString('Admin effort reduction', $html);
        $this->assertStringContainsString('AI Sales Coaching Platform', $html);
        $this->assertStringContainsString('Faster ramp to quota', $html);
        $this->assertStringContainsString('enterpriseEvidenceSwiper', $html);
        $this->assertStringNotContainsString('enterprise-ai-erp-evidence__icon-placeholder', $html);
        $this->assertStringContainsString('assets/media/ttc-logo.webp', $html);
        $this->assertStringContainsString('assets/media/b2b-crm-logo.webp', $html);
        $this->assertStringContainsString('assets/media/ai-sales-logo.webp', $html);
        $this->assertStringContainsString('assets/media/automation.webp', $html);
        $this->assertStringContainsString('Frequently Asked Questions About Enterprise AI &amp; ERP in the UAE', $html);
        $this->assertStringContainsString('How does custom ERP development compare to SAP or Oracle in the UAE?', $html);
        $this->assertStringContainsString('Appointment Insurance &amp; Smart Refund Automation', $html);
        $this->assertStringContainsString('Ready to Build Your Custom AI-Native ERP System?', $html);
        $this->assertStringContainsString('Explore Our Custom CRM Builder Services', $html);
        $this->assertStringContainsString('enterprise-ai-erp-faq-heading', $html);
        $this->assertStringContainsString('consultation-card bg-cover bg-no-repeat bg-top', $html);
        $this->assertStringContainsString('Schedule a Technical Discovery Session', $html);
        $this->assertStringContainsString('Our Partnerships &amp; Growth Stack', $html);
        $this->assertStringNotContainsString('articles-insights', $html);
        $this->assertStringContainsString('Enterprise AI &amp; Custom ERP Solutions UAE | Suave Creators', $html);
        $this->assertStringContainsString('hreflang="en-ae"', $html);
        $this->assertStringContainsString('og:locale" content="en_AE"', $html);
        $this->assertStringContainsString('enterprise ai and erp solutions uae', $html);
    }

    public function test_unpublished_enterprise_ai_erp_paths_are_not_redirected(): void
    {
        $this->get('/enterprise-ai-erp-uae')->assertNotFound();

        $this->get('/services/uae/enterprise-ai-erp-solutions')->assertNotFound();
    }
}
