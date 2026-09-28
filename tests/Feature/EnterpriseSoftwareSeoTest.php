<?php

namespace Tests\Feature;

use App\Support\Frontend\ServiceSupport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnterpriseSoftwareSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_enterprise_software_page_targets_definition_examples_and_management_intent(): void
    {
        $service = ServiceSupport::service('enterprise-software-solutions');
        $faqs = array_column($service['faqs'] ?? [], 'question');
        $pageText = implode(' ', [
            $service['pageTitle'] ?? '',
            $service['pageDescription'] ?? '',
            $service['ogTitle'] ?? '',
            $service['ogDescription'] ?? '',
            ...($service['bodyParagraphs'] ?? []),
            ...array_column($service['faqs'] ?? [], 'answer'),
        ]);

        $this->assertSame(
            'Custom Enterprise Software Solutions & ERP Systems | Suave Creators',
            $service['pageTitle'] ?? '',
        );
        $this->assertStringContainsString(
            'Custom enterprise software solutions, bespoke ERP development, and workflow automation. Eliminate per-seat SaaS costs with 100% code and IP ownership.',
            $service['pageDescription'] ?? '',
        );
        $this->assertContains('What is enterprise software?', $faqs);
        $this->assertContains('What are examples of enterprise software?', $faqs);
        $this->assertContains('How does enterprise software management help operations?', $faqs);
        $this->assertStringContainsString(
            'Enterprise Resource Planning (ERP) platforms, supply chain management systems, automated billing portals, human resource platforms (HRMS)',
            $pageText,
        );
        $this->assertNotSame('Ready to Build Your Website? Let’s Get Started!', $service['ctaTitle'] ?? '');
        $this->assertStringNotContainsString('your website should do more than just exist online', $service['finalDescription'] ?? '');
    }

    public function test_enterprise_software_page_renders_with_meta_and_all_content_sections(): void
    {
        $response = $this->get(route('service.show', ['slug' => 'enterprise-software-solutions']));

        $response->assertOk();

        // Meta tags
        $response->assertSee('<title>Custom Enterprise Software Solutions &amp; ERP Systems | Suave Creators</title>', false);
        $response->assertSee('name="description" content="Custom enterprise software solutions, bespoke ERP development, and workflow automation. Eliminate per-seat SaaS costs with 100% code and IP ownership."', false);
        $response->assertSee('assets/media/enterprise-software-og.jpg', false);
        $response->assertSee('property="og:title" content="Custom Enterprise Software Solutions &amp; ERP Systems | Suave Creators"', false);
        $response->assertSee('name="twitter:title" content="Custom Enterprise Software Solutions &amp; ERP Systems | Suave Creators"', false);

        // Section 1: Hero
        $response->assertSee('OUR TAILOR-MADE SERVICES', false);
        $response->assertSee('Smart Enterprise Software', false);
        $response->assertSee('Solutions to Run Your Entire Business.', false);
        $response->assertSee('Replace fragmented tools, manual spreadsheets, and escalating SaaS fees with custom enterprise software.', false);
        $response->assertSee('Let’s Connect to Discuss', false);
        $response->assertSee('Drop Your Vision', false);

        // Section 2: Trust & Authority Strip + Stats
        $response->assertSee('Enterprise Software Engineering', false);
        $response->assertSee('Direct Access to Senior Solutions Architects', false);
        $response->assertSee('We partner with mid-market businesses, logistics operators, and growing companies to build reliable operational software.', false);
        $response->assertSee('Explore Services', false);
        $response->assertSee('Projects Delivered', false);
        $response->assertSee('Years Systems Experience', false);
        $response->assertSee('Client Retention Rate', false);
        $response->assertSee('Senior Engineers &amp; Architects', false);

        // Section 3: Architecture Discovery Callout Card
        $response->assertSee('Have a Complex Enterprise Architecture or Custom ERP Requirement?', false);
        $response->assertSee('Looking to replace rigid third-party software, eliminate per-seat licensing fees, or integrate legacy databases with modern APIs?', false);
        $response->assertSee('Book a Discovery Session', false);
        $response->assertSee('Explore Our Custom CRM Builder Services', false);

        // Section 4: Overview / Core Definition
        $response->assertSee('Enterprise Software Solutions for Operations, Management, and Long-Term Growth', false);
        $response->assertSee('Enterprise software is the central nervous system of a business.', false);
        $response->assertSee('Whether you need a bespoke ERP, cross-departmental inventory and order management', false);
        $response->assertSee('Let’s Build Together', false);

        // Section 5: Capabilities Grid
        $response->assertSee('Technologies &amp; Capabilities for Enterprise Software Solutions', false);
        $response->assertSee('We build custom software around your operational bottlenecks using modern, maintainable stacks.', false);
        $response->assertSee('Custom ERP Development', false);
        $response->assertSee('Commercial SaaS Engineering', false);
        $response->assertSee('Cloud Modernization &amp; Microservices', false);
        $response->assertSee('Custom Business Software &amp; API Integration', false);

        // Section 6: Projects Teaser Banner
        $response->assertSee('Explore What We Engineer', false);
        $response->assertSee('Real production platforms where our software architecture solved major operational bottlenecks.', false);

        // Section 7: Industries We Serve
        $response->assertSee('We build software for industries where operational reliability, data security, and transaction accuracy are non-negotiable.', false);
        $response->assertSee('Healthcare', false);
        $response->assertSee('Finance &amp; Banking', false);
        $response->assertSee('Retail &amp; E-commerce', false);
        $response->assertSee('Manufacturing &amp; Supply Chain', false);
        $response->assertSee('Education &amp; E-learning', false);
        $response->assertSee('Logistics &amp; Fleet Management', false);

        // Section 9: Why Choose
        $response->assertSee('Why Choose Suave Creators for Your Enterprise Software Needs?', false);
        $response->assertSee('Software Built Around Your Rules', false);
        $response->assertSee('Senior Engineering from Day One', false);
        $response->assertSee('100% Code &amp; IP Ownership', false);

        // Section 10: Development Process (no duplicate text)
        $response->assertSee('Our Enterprise Software Development Process', false);
        $response->assertSee('Discovery &amp; Architecture', false);
        $response->assertSee('Interactive UX &amp; Prototyping', false);
        $response->assertSee('Sprint-Based Development', false);
        $response->assertSee('Testing &amp; Security QA', false);
        $response->assertSee('Deployment &amp; Smooth Cutover', false);
        $response->assertSee('We handle cloud server provisioning, data migration, and parallel-run testing to transition your team off legacy systems with zero operational downtime.', false);

        // Section 11: Standout Cards
        $response->assertSee('Domain-Specific Technical Depth', false);
        $response->assertSee('Clean System Integration', false);
        $response->assertSee('Long-Term SLA Support', false);

        // Section 12: FAQs (all 8)
        $response->assertSee('What is enterprise software?', false);
        $response->assertSee('What are examples of enterprise software?', false);
        $response->assertSee('How does enterprise software management help operations?', false);
        $response->assertSee('What are custom enterprise software solutions?', false);
        $response->assertSee('How long does it take to develop custom enterprise software?', false);
        $response->assertSee('What industries benefit from custom enterprise software solutions?', false);
        $response->assertSee('What is the difference between SaaS and custom enterprise software?', false);
        $response->assertSee('How do you ensure the security of enterprise software solutions?', false);

        // Section 13: Bottom CTA
        $response->assertSee('Let’s Build Enterprise Software Tailored to Your Business', false);
        $response->assertSee('At Suave Creators, we believe enterprise software should make everyday operations clearer, faster, and easier to scale.', false);
        $response->assertSee('Get a Free Quote', false);
        $response->assertSee('Contact Us Today', false);

        // JSON-LD Structured Data
        $response->assertSee('"@type":"Service"', false);
        $response->assertSee('"name":"Custom Enterprise Software Solutions"', false);
        $response->assertSee('"serviceType":"Enterprise Software Development"', false);
        $response->assertSee('"name":"Enterprise Software Services"', false);
        $response->assertSee('Bespoke ERP', false);
        $response->assertSee('Operations Management Platforms', false);
        $response->assertSee('Legacy Code Modernization', false);
        $response->assertSee('Database Migration', false);
        $response->assertSee('API Middleware', false);
        $response->assertSee('Automated Sync Pipelines', false);
        $response->assertSee('Commercial Multi-Tenant SaaS Systems', false);
        $response->assertSee('"@type":"FAQPage"', false);
        $response->assertSee('"@type":"BreadcrumbList"', false);
    }
}
