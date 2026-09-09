<?php

namespace Tests\Feature;

use App\Support\Frontend\ServiceSupport;
use Tests\TestCase;

class FivePageSeoMetaTest extends TestCase
{
    public function test_priority_pages_use_results_focused_titles_and_descriptions(): void
    {
        $pages = config('seo.pages');
        $enterprise = ServiceSupport::service('enterprise-software-solutions');
        $crm = ServiceSupport::service('custom-crm-development');

        $this->assertSame('Custom Software, CRM & Web App Development | Suave Creators', $pages['home']['title']);
        $this->assertSame('Engineer custom software, bespoke CRM systems, and AI-driven web applications. Explore verified engineering case studies, tech stack, and ROI blueprints.', $pages['home']['description']);

        $this->assertSame('Software Development Services for Serious Growth | Suave Creators', $pages['services']['title']);
        $this->assertSame('Explore web, CRM, e-commerce, AI, and enterprise software services for businesses ready to invest in measurable digital growth.', $pages['services']['description']);

        $this->assertSame('Ready to Build? Get a Free Project Consultation | Suave Creators', $pages['contact-us']['title']);
        $this->assertSame('Tell us what you want to build. We’ll help clarify what it takes, what you’ll get, and the next steps to create real business results.', $pages['contact-us']['description']);

        $this->assertSame('Enterprise Software That Improves Operations', $enterprise['pageTitle']);
        $this->assertSame('Planning enterprise software? Understand what it takes, what you get, and how the right system can improve teams, workflows, and growth.', $enterprise['pageDescription']);

        $this->assertSame('Custom CRM That Turns Leads Into Revenue', $crm['pageTitle']);
        $this->assertSame('Ready for a CRM built around your sales process? See what you get, how it works, and how it can improve follow-ups, visibility, and revenue.', $crm['pageDescription']);
    }
}
