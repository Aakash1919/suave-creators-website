<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoSitelinksCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_service_urls_permanently_redirect_to_current_service_urls(): void
    {
        $response = $this->get('/service/enterprise-software-solutions');

        $response->assertStatus(301);
        $response->assertRedirect('/services/enterprise-software-solutions');
    }

    public function test_legacy_industry_hub_permanently_redirects_to_industries_hub(): void
    {
        $response = $this->get('/industry');

        $response->assertStatus(301);
        $response->assertRedirect('/industries');
    }

    public function test_leaked_main_public_urls_permanently_redirect_to_clean_paths(): void
    {
        $response = $this->get('/main/public/about-us');

        $response->assertStatus(301);
        $response->assertRedirect('/about-us');
    }

    public function test_www_requests_permanently_redirect_to_primary_non_www_host(): void
    {
        config(['app.url' => 'https://suavecreators.com']);

        $response = $this->get('https://www.suavecreators.com/contact-us?from=google');

        $response->assertStatus(301);
        $response->assertRedirect('https://suavecreators.com/contact-us?from=google');
    }

    public function test_homepage_exposes_clear_primary_sitelink_candidates(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('>About<', false);
        $response->assertSee('>AI Outreach CRM<', false);
        $response->assertSee('>Services<', false);
        $response->assertSee('>Industries<', false);
        $response->assertSee('>Case Studies<', false);
        $response->assertSee('>Contact<', false);
        $response->assertSee('>Contact Us<', false);
        $response->assertSee('/services/enterprise-software-solutions', false);
        $response->assertDontSee('>Our Product<', false);
    }
}
