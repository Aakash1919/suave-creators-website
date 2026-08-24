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
        $this->assertStringNotContainsString('/main/public/', (string) $response->headers->get('Location'));
    }

    public function test_leaked_main_public_urls_with_trailing_slash_redirect_once_to_clean_paths(): void
    {
        $response = $this->get('/main/public/about-us/');

        $response->assertStatus(301);
        $response->assertRedirect('/about-us');
        $this->assertStringNotContainsString('/main/public/', (string) $response->headers->get('Location'));
    }

    public function test_leaked_nested_main_public_urls_with_trailing_slash_redirect_to_clean_paths(): void
    {
        $response = $this->get('/main/public/services/web-development-services/');

        $response->assertStatus(301);
        $response->assertRedirect('/services/web-development-services');
        $this->assertStringNotContainsString('/main/public/', (string) $response->headers->get('Location'));
    }

    public function test_trailing_slash_marketing_urls_do_not_redirect_to_main_public(): void
    {
        $response = $this->get('/about-us/');

        $this->assertStringNotContainsString('/main/public/', (string) $response->headers->get('Location'));
    }

    /**
     * Hostinger Apache uses public/.htaccess (not PHP) for trailing-slash redirects.
     * phpunit cannot reproduce the /main/public leak; this locks the THE_REQUEST rules.
     * After deploy, curl -I https://suavecreators.com/about-us/ and
     * https://suavecreators.com/services/web-development-services/ must 301 once
     * to the clean URL, never to /main/public/...
     */
    public function test_htaccess_trailing_slash_redirect_uses_the_request_not_request_uri(): void
    {
        $htaccess = (string) file_get_contents(public_path('.htaccess'));

        $this->assertNotSame('', $htaccess);
        $this->assertStringContainsString('RewriteCond %{THE_REQUEST} \\s/+(.+?)/+(?:\\?|\\s)', $htaccess);
        $this->assertStringContainsString('RewriteRule ^ /%1 [R=301,L,NE,QSA]', $htaccess);
        $this->assertStringContainsString('RewriteCond %{THE_REQUEST} \\s/+main/public/+', $htaccess);
        $this->assertStringNotContainsString('RewriteCond %{REQUEST_URI} (.+)/$', $htaccess);
        $this->assertStringNotContainsString('RewriteRule ^ %1 [L,R=301]', $htaccess);
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
