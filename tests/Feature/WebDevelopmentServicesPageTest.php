<?php

namespace Tests\Feature;

use App\Support\Frontend\ContactSupport;
use Tests\TestCase;

class WebDevelopmentServicesPageTest extends TestCase
{
    public function test_web_development_services_page_loads_and_contains_all_updated_content(): void
    {
        $response = $this->get(route('service.show', ['slug' => 'web-development-services']));
        $response->assertOk();

        $demoHref = ContactSupport::demoHref();

        // 1. Title & Meta
        $response->assertSee('<title>Custom Web Development Services | Suave Creators</title>', false);
        $response->assertSee('Custom web application development services for B2B enterprises and startups. Full-stack Laravel, React, Node.js, and cloud platforms with 100% code ownership.', false);
        $response->assertSee('assets/media/web-development-services-og.jpg', false);

        // 2. Hero Section
        $response->assertSee('OUR TAILOR-MADE SERVICES');
        $response->assertSee('Custom Web Development Services for');
        $response->assertSee('High-Growth Businesses');
        $response->assertSee('We engineer responsive, high-performance web applications, cloud customer portals, and enterprise software platforms.');
        $response->assertSee('Get Free Consultation');
        $response->assertSee("Schedule a Discovery Call \u{2192}");

        // 3. Service Scope & Overview
        $response->assertSee('Service Scope &amp; Inclusions', false);
        $response->assertSee("What do Suave Creators' custom web development services include?");
        $response->assertSee("Suave Creators' custom web development services encompass full-stack web application engineering");
        $response->assertSee('Full-Stack Web &amp; SaaS Engineering', false);
        $response->assertSee('Modern Tech Stacks (Laravel, React, Node.js, Python)', false);
        $response->assertSee('SOC 2 &amp; HIPAA Compliant Architecture', false);
        $response->assertSee('US Legal Governance &amp; Up to 60% TCO Savings', false);

        // 3.1 Intro & Stats
        $response->assertSee('Trusted by High-Growth Startups &amp; Established Enterprises', false);
        $response->assertSee('Explore All Services');
        $response->assertSee('50+');
        $response->assertSee('Projects Delivered');
        $response->assertSee('10+');
        $response->assertSee('Years Experience');
        $response->assertSee('98%');
        $response->assertSee('Client Satisfaction');
        $response->assertSee('15+');
        $response->assertSee('Senior Engineers');

        // 4. Strategic In-Page Cross-Sell Banner
        $response->assertSee('Have a Complex Web Application or Custom CRM Architecture Requirement?');
        $response->assertSee('Book a Discovery Session');
        $response->assertSee("Explore Our Custom CRM Builder Services \u{2192}");
        $response->assertSee($demoHref, false);

        // 5. Executive Overview
        $response->assertSee('Tailored Web Solutions to Enhance Your Digital Operations');
        $response->assertSee("Let's Connect to Discuss Your Project");
        $response->assertSee("Let's Build Your Digital Future Together \u{2192}");

        // 6. Core Capabilities (01-06)
        $response->assertSee('Laravel Development');
        $response->assertSee('Enterprise WordPress &amp; Headless CMS', false);
        $response->assertSee('ReactJS &amp; Next.js Development', false);
        $response->assertSee('Angular Enterprise Development');
        $response->assertSee('PHP &amp; Modern Full-Stack API Engineering', false);
        $response->assertSee('Node.js High-Concurrency Microservices');

        // 7. Portfolio Showcase
        $response->assertSee('Real-World Software Systems That Deliver Measurable Business ROI');
        $response->assertSee("Explore Our Case Studies \u{2192}");

        // 8. Industries
        $response->assertSee('Specialized Industry Web &amp; Software Development Solutions', false);
        $response->assertSee('Healthcare &amp; Clinics', false);
        $response->assertSee('B2B &amp; High-Volume E-Commerce', false);
        $response->assertSee('B2B SaaS, IT &amp; High-Growth Startups', false);
        $response->assertSee('Financial Services &amp; FinTech', false);
        $response->assertSee('Real Estate &amp; Property Development', false);
        $response->assertSee('Education &amp; E-Learning Organizations', false);

        // 9. Tech ticker (doc stack)
        $response->assertSee('FastAPI');
        $response->assertSee('Shopify Plus');
        $response->assertSee('PostgreSQL');

        // 10. Why Choose Us
        $response->assertSee('Why Choose Us for Your Web &amp; Software Development Needs?', false);
        $response->assertSee('Tailored Solutions for Startups &amp; Mid-Market Enterprises', false);
        $response->assertSee('Scalable, High-Performance &amp; Responsive Architecture', false);
        $response->assertSee('Growth-Focused SEO &amp; Technical Optimization', false);
        $response->assertSee("Let\u{2019}s Discuss Your Technical Roadmap");

        // 11. 5-Stage Process
        $response->assertSee('A Disciplined Engineering Lifecycle That Ensures Predictable Delivery');
        $response->assertSee('Discovery &amp; Strategy', false);
        $response->assertSee('Design &amp; Interactive Prototyping', false);
        $response->assertSee('Agile Development &amp; Integration', false);
        $response->assertSee('Testing &amp; Rigorous Quality Assurance', false);
        $response->assertSee('Production Launch &amp; Ongoing Support', false);

        // 12. Why Suave Creators Stands Out
        $response->assertSee('Why Suave Creators Stands Out');
        $response->assertSee('Proven Experience &amp; B2B Engineering Expertise', false);
        $response->assertSee('Fast Delivery, Fixed Sprints &amp; Predictable Roadmaps', false);
        $response->assertSee('Direct Technical Leadership Without Account-Manager Friction', false);

        // 13. FAQ Section
        $response->assertSee('HAVE QUESTIONS ABOUT OUR SERVICES?');
        $response->assertSee('Frequently Asked Questions: Delivery, Pricing &amp; Code Ownership', false);
        $response->assertSee('What is the cost of your web development services?');
        $response->assertSee('How long does it take to develop a custom web application?');
        $response->assertSee('Do you offer post-launch support and maintenance?');
        $response->assertSee('Is your web development SEO-friendly?');
        $response->assertSee('Can you help me with a website redesign or legacy migration?');
        $response->assertSee('Who owns the source code and intellectual property once developed?');

        // 14. Pre-Footer Call to Action
        $response->assertSee("Let\u{2019}s Build Your Business Web Application Together");
        $response->assertSee('Get a Free Quote');
        $response->assertSee("Contact Us Today \u{2192}");

        // 15. Featured Case Study
        $response->assertSee('Appointment Insurance That Makes Showing Up the Default');
        $response->assertSee('Explore the Case Study');

        // 16. Blogs and Insights
        $response->assertSee('Explore Our Technical Insights');
        $response->assertSee('Explore our latest articles on custom CRM architectures');
        $response->assertSee('Why US Mid-Market Companies Are Replacing Salesforce with Custom CRMs in 2026');
        $response->assertSee('Why the India Market Is the Strategic Choice for US Web Development in 2026');
        $response->assertSee('Beyond Chatbots: How Multi-Agent AI Systems Are Automating B2B Workflows in 2026');

        // 17. Schema.org JSON-LD Graph (short FAQ schema answers)
        $content = (string) $response->getContent();
        $this->assertStringContainsString('"@type":"Service"', $content);
        $this->assertStringContainsString('"serviceType":"Custom Web Application Engineering"', $content);
        $this->assertStringContainsString('"name":"Custom Web Development Services"', $content);
        $this->assertStringContainsString('"hasOfferCatalog"', $content);
        $this->assertStringContainsString('"@type":"FAQPage"', $content);
        $this->assertStringContainsString('clients save up to 60% compared to typical US onshore agency rates', $content);
        $this->assertStringNotContainsString('US legal governance with an engineering center in Palampur, India', $this->extractJsonLdFaqBlock($content));
    }

    public function test_custom_crm_builder_and_legacy_routes_redirect(): void
    {
        $response = $this->get('/services/custom-crm-builder');
        $response->assertStatus(301);
        $response->assertRedirect(route('service.show', ['slug' => 'custom-crm-development']));

        $responseBlog = $this->get('/blog');
        $responseBlog->assertStatus(301);
        $responseBlog->assertRedirect(route('blogs'));
    }

    private function extractJsonLdFaqBlock(string $content): string
    {
        if (! preg_match('/"@type"\s*:\s*"FAQPage".*?"mainEntity"\s*:\s*\[(.*?)\]\s*\}/s', $content, $matches)) {
            return '';
        }

        return $matches[1];
    }
}
