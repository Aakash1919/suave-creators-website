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

        $this->assertSame('Custom Software Development Company | Suave Creators', $pages['home']['title']);
        $this->assertSame('Hire a custom software development company that builds CRM, ERP and web apps you own. Senior developers, 2-week sprints, US contracts. Get a scoped estimate.', $pages['home']['description']);

        $this->assertSame('Custom Software, CRM & AI Development Services | Suave Creators', $pages['services']['title']);
        $this->assertSame('Enterprise B2B software development services: custom CRM builder, scalable web apps, enterprise software, UI/UX, and AI solutions with 100% code ownership.', $pages['services']['description']);

        $this->assertSame('Contact Suave Creators | Get a Free Software Consultation', $pages['contact-us']['title']);
        $this->assertSame('Have a software, web, CRM, ERP or AI project in mind? Contact Suave Creators for a free consultation and discuss your business requirements with our experts.', $pages['contact-us']['description']);

        $this->assertSame('Custom Enterprise Software Solutions & ERP Systems | Suave Creators', $enterprise['pageTitle']);
        $this->assertSame('Custom enterprise software solutions, bespoke ERP development, and workflow automation. Eliminate per-seat SaaS costs with 100% code and IP ownership.', $enterprise['pageDescription']);

        $this->assertSame('Custom CRM That Turns Leads Into Revenue', $crm['pageTitle']);
        $this->assertSame('Ready for a CRM built around your sales process? See what you get, how it works, and how it can improve follow-ups, visibility, and revenue.', $crm['pageDescription']);
    }
}
