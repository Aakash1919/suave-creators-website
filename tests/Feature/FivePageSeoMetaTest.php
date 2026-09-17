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

        $this->assertSame('Web & Software Development Company | Suave Creators', $pages['home']['title']);
        $this->assertSame('Suave Creators builds custom web applications, software, CRM, ERP, AI and digital solutions that help businesses improve efficiency, scale faster and grow.', $pages['home']['description']);

        $this->assertSame('Software Development Services for B2B & SaaS Businesses', $pages['services']['title']);
        $this->assertSame('Explore custom B2B & SaaS software development services from Suave Creators, including web applications, enterprise software, CRM, UI/UX, AI solutions, & more.', $pages['services']['description']);

        $this->assertSame('Contact Suave Creators | Get a Free Software Consultation', $pages['contact-us']['title']);
        $this->assertSame('Have a software, web, CRM, ERP or AI project in mind? Contact Suave Creators for a free consultation and discuss your business requirements with our experts.', $pages['contact-us']['description']);

        $this->assertSame('Enterprise Software That Improves Operations', $enterprise['pageTitle']);
        $this->assertSame('Planning enterprise software? Understand what it takes, what you get, and how the right system can improve teams, workflows, and growth.', $enterprise['pageDescription']);

        $this->assertSame('Custom CRM That Turns Leads Into Revenue', $crm['pageTitle']);
        $this->assertSame('Ready for a CRM built around your sales process? See what you get, how it works, and how it can improve follow-ups, visibility, and revenue.', $crm['pageDescription']);
    }
}
