<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomCrmBuilderPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_custom_crm_builder_page_renders_hero_and_is_not_a_service_detail(): void
    {
        $response = $this->get(route('custom-crm-builder', absolute: false));

        $response->assertOk();
        $response->assertSee('Custom CRM Builder', false);
        $response->assertSee('Bespoke', false);
        $response->assertSee('CRM Software', false);
        $response->assertSee('Get Free Consultation', false);
        $response->assertDontSee('Calculate Your 3-Year ROI', false);
        $response->assertSee('What is a custom CRM builder?', false);
        $response->assertSee('proprietary customer relationship management system', false);
        $response->assertSee('Trusted by High-Growth Startups', false);
        $response->assertSee('crm-builder-hero', false);
        $response->assertSee('custom-crm-builder-hero-bg.webp', false);
        $response->assertSee('Why Build a Custom CRM in 2026', false);
        $response->assertSee('The TCO Advantage', false);
        $response->assertSee('Evaluation Metric / Cost Layer', false);
        $response->assertSee('Year 2 Operational Cost', false);
        $response->assertSee('3-Year Cumulative Spend', false);
        $response->assertSee('$ 285,000', false);
        $response->assertSee('crm-builder-tco', false);
        $response->assertSee('evaluated-metric-icon.webp', false);
        $response->assertSee('salesforce-logo.webp', false);
        $response->assertSee('custom-crm-icon.webp', false);
        $response->assertSee('calendar-metric-icon.webp', false);
        $response->assertSee('Enterprise-Grade Functional Modules Engineered for High Velocity', false);
        $response->assertSee('Our Technical Capabilities', false);
        $response->assertSee('Lead Ingestion &amp; Unified Pipeline Architecture', false);
        $response->assertSee('AI-Assisted Outreach &amp; Automated Follow-Up', false);
        $response->assertSee('Role-Based Access Control (RBAC)', false);
        $response->assertDontSee('Opportunity Management &amp; Deal Velocity', false);
        $response->assertSee('crm-builder-modules', false);
        $response->assertSee('technical_capabilites1.webp', false);
        $response->assertSee('Industries We Serve', false);
        $response->assertSee('Tailored Architecture for High-Complexity Verticals', false);
        $response->assertSee('Logistics, Freight &amp; Supply Chain Management', false);
        $response->assertSee('Turbo Trans Corporation Custom Logistics Software', false);
        $response->assertSee('crm-builder-verticals', false);
        $response->assertSee('custom-crm-builder-industries-bg.webp', false);
        $response->assertSee('Modern Engineering Practices', false);
        $response->assertSee('Built with Modern, Scalable, Enterprise-Grade Technologies', false);
        $response->assertSee('crm-builder-stack', false);
        $response->assertSee('crm-builder-stack-marquee', false);
        $response->assertSee('Value Pillars', false);
        $response->assertSee('Engineered for Speed, Total Data Autonomy, and Business Growth', false);
        $response->assertSee('100% Intellectual Property', false);
        $response->assertSee('crm-builder-pillars', false);
        $response->assertSee('Why Suave Creators Stands Out', false);
        $response->assertSee('Proven Experience', false);
        $response->assertSee('crm-builder-stands-out', false);
        $response->assertSee('custom-crm-builder-stands-out-bg.webp', false);
        $response->assertSee('Systematic Execution', false);
        $response->assertSee('From Workflow Blueprint to Production Deployment', false);
        $response->assertSee('Discovery &amp; Architecture Modeling', false);
        $response->assertSee('ERD, and project roadmap', false);
        $response->assertSee('crm-builder-execution', false);
        $response->assertSee('crm-builder-execution__icon-placeholder', false);
        $response->assertDontSee('crm-deliverable-check-icon.webp', false);
        $response->assertDontSee('ui-ux-workflow-design-illustration.webp', false);
        $response->assertSee('custom-crm-builder-execution-bg.webp', false);
        $response->assertSee('Verified Results', false);
        $response->assertSee('Proven Delivery: How We Engineered a Modern Sales', false);
        $response->assertSee('B2B CRM Outbound Sales Workflow', false);
        $response->assertSee('Read the Full Case Study', false);
        $response->assertSee('crm-builder-results', false);
        $response->assertSee('custom-crm-builder-results-bg.webp', false);
        $response->assertSee('Frequently Asked Questions', false);
        $response->assertSee('Everything You Need to Know About Custom CRM Development', false);
        $response->assertSee('$20,000 to $60,000', false);
        $response->assertSee('faq-section--crm-builder', false);
        $response->assertSee('custom-crm-builder-faq-bg.webp', false);
        $response->assertDontSee('faq-section__image', false);
        $response->assertSee('FAQPage', false);
        $response->assertSee('Custom CRM Software Engineering', false);
        $response->assertSee('docker-logo.svg', false);
        $response->assertSee('PostgreSQL', false);
        $response->assertSee('Kubernetes', false);
        $response->assertSee('Ready to Stop Paying Per-User Fees', false);
        $response->assertSee('Schedule a Free CRM Discovery Consultation', false);
        $response->assertSee('consultation-card', false);
        $response->assertSee('consultation-card bg-cover bg-no-repeat bg-top', false);
        $response->assertSee('id="consultation"', false);
        $response->assertSee('consultation-people', false);
        $response->assertSee('analyst-headset-custom-crm-dashboard.webp', false);
        $response->assertSee('executive-tablet-crm-hologram.webp', false);
        $response->assertSee('floating-analytics-dashboard-laptop.webp', false);
        $response->assertSee('analyst-performance-metrics-laptop.webp', false);
        $response->assertSee('crm-contact-hologram-keyboard.webp', false);
        $response->assertSee('consultant-crm-team-tablet.webp', false);
        $response->assertDontSee('consultation-person__placeholder', false);
        $response->assertDontSee('crm-builder-discovery', false);
        $response->assertSee('Our Partnerships &amp; Growth Stack', false);
        $response->assertSee('crm-builder-partners', false);
        $response->assertSee('verysoul-logo.png', false);
        $response->assertSee('redsixity-logo.svg', false);
        $response->assertSee('dajj-logistics-logo.png', false);
        $response->assertSee('ematrics-logo.png', false);
        $response->assertSee('bioassay-systems-logo.png', false);
        $response->assertDontSee('service-banner', false);
        $response->assertDontSee('class="full-bleed service-banner', false);
    }

    public function test_custom_crm_builder_page_uses_named_route_and_seo_title(): void
    {
        $this->assertSame('/custom-crm-builder', route('custom-crm-builder', absolute: false));

        $pages = config('seo.pages');
        $this->assertSame(
            'Custom CRM Builder & Software Development Company | Suave Creators',
            $pages['custom-crm-builder']['title'] ?? ''
        );
        $this->assertSame(
            'Build a custom CRM tailored to your sales workflows. Eliminate per-seat licensing fees with scalable, secure, AI-powered custom CRM development from Suave Creators.',
            $pages['custom-crm-builder']['description'] ?? ''
        );

        $response = $this->get(route('custom-crm-builder', absolute: false));
        $response->assertSee('<title>Custom CRM Builder &amp; Software Development Company | Suave Creators</title>', false);
        $response->assertSee('Custom CRM Builder Architecture and Dashboard Interface', false);
        $response->assertSee('"name":"Services"', false);
        $response->assertSee('"name":"Custom CRM Builder"', false);
        $response->assertSee('Custom CRM Engineering Modules', false);
        $response->assertSee('Custom CRM Software Engineering', false);
    }

    public function test_custom_crm_builder_page_renders_blogs_and_insights_after_faq(): void
    {
        $this->seedPublishedBlog();

        $html = $this->get(route('custom-crm-builder', absolute: false))->assertOk()->getContent();
        $faqPosition = strpos($html, 'faq-section--crm-builder');
        $insightsPosition = strpos($html, 'crm-builder-insights-title');

        $this->assertNotFalse($faqPosition);
        $this->assertNotFalse($insightsPosition);
        $this->assertGreaterThan($faqPosition, $insightsPosition);
        $this->assertStringContainsString('Blogs and Insights', $html);
        $this->assertStringContainsString('Explore Technical Insights on Custom Software Architecture', $html);
        $this->assertStringContainsString('Custom CRM Insights Post', $html);
        $this->assertStringContainsString('View all blog articles', $html);
        $this->assertStringContainsString('articles-insights', $html);

        $consultationPosition = strpos($html, 'id="consultation"');
        $partnersPosition = strpos($html, 'crm-builder-partners');
        $this->assertNotFalse($consultationPosition);
        $this->assertNotFalse($partnersPosition);
        $this->assertGreaterThan($insightsPosition, $consultationPosition);
        $this->assertGreaterThan($consultationPosition, $partnersPosition);
        $this->assertStringContainsString('consultation-card bg-cover bg-no-repeat bg-top', $html);
    }

    private function seedPublishedBlog(): void
    {
        $author = User::factory()->create();
        $category = BlogCategory::query()->create([
            'name' => 'Software Development',
            'slug' => 'software-development',
            'sort_order' => 1,
        ]);

        Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'custom-crm-insights-post',
            'title' => 'Custom CRM Insights Post',
            'short_description' => 'A listing card excerpt for the CRM builder insights section.',
            'content' => '<p>CRM insights excerpt.</p>',
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
        ]);
    }
}
