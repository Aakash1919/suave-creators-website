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
        $response->assertRedirect(route('service.show', ['slug' => 'enterprise-software-solutions']));
    }

    public function test_legacy_industry_hub_permanently_redirects_to_industries_hub(): void
    {
        $response = $this->get('/industry');

        $response->assertStatus(301);
        $response->assertRedirect(route('industries'));
    }

    public function test_legacy_healthcare_industry_url_permanently_redirects_to_software_development_slug(): void
    {
        $healthcareUrl = route('industry.show', ['slug' => 'healthcare-software-development']);

        $response = $this->get('/industries/healthcare');

        $response->assertStatus(301);
        $response->assertRedirect($healthcareUrl);

        $this->get($healthcareUrl)->assertOk();
    }

    public function test_leaked_main_public_urls_permanently_redirect_to_clean_paths(): void
    {
        $response = $this->get('/main/public/about-us');

        $response->assertStatus(301);
        $response->assertRedirect(route('about-us'));
        $this->assertStringNotContainsString('/main/public/', (string) $response->headers->get('Location'));
    }

    public function test_leaked_main_public_urls_with_trailing_slash_redirect_once_to_clean_paths(): void
    {
        $response = $this->get('/main/public/about-us/');

        $response->assertStatus(301);
        $response->assertRedirect(route('about-us'));
        $this->assertStringNotContainsString('/main/public/', (string) $response->headers->get('Location'));
    }

    public function test_leaked_nested_main_public_urls_with_trailing_slash_redirect_to_clean_paths(): void
    {
        $response = $this->get('/main/public/services/web-development-services/');

        $response->assertStatus(301);
        $response->assertRedirect(route('service.show', ['slug' => 'web-development-services']));
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
        $response->assertRedirect('https://suavecreators.com'.route('contact-us', absolute: false).'?from=google');
    }

    public function test_homepage_exposes_clear_primary_sitelink_candidates(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('>About<', false);
        $response->assertDontSee('>AI Outreach CRM<', false);
        $response->assertSee('>Services<', false);
        $response->assertSee('>Industries<', false);
        $response->assertSee('>Case Studies<', false);
        $response->assertSee('>Contact<', false);
        $response->assertSee('>Contact Us<', false);
        $response->assertSee(parse_url(route('service.show', ['slug' => 'enterprise-software-solutions']), PHP_URL_PATH), false);
        $response->assertDontSee('>Our Product<', false);
    }

    public function test_outreach_crm_page_stays_unpublished(): void
    {
        $this->get('/ai-powered-outreach-crm')->assertNotFound();
    }

    public function test_homepage_json_ld_uses_the_homepage_graph(): void
    {
        config([
            'app.url' => 'https://suavecreators.com',
            'seo.noindex' => false,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('<title>Custom Software Development Company | Suave Creators</title>', false);
        $response->assertSee('<meta name="description" content="Hire a custom software development company that builds CRM, ERP and web apps you own. Senior developers, 2-week sprints, US contracts. Get a scoped estimate.">', false);
        $response->assertSee('<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">', false);
        $response->assertSee('<meta name="author" content="Suave Creators">', false);
        $response->assertSee('<meta name="theme-color" content="#0B3D91">', false);
        $response->assertSee('<link rel="canonical" href="https://suavecreators.com/">', false);
        $response->assertSee('<meta property="og:title" content="Custom Software Development Company | Software You Own">', false);
        $response->assertSee('<meta property="og:description" content="Custom CRM, ERP and web applications built by senior developers in 2-week sprints. 100% code ownership. Hire a team or get a scoped estimate.">', false);
        $response->assertSee('<meta property="og:image" content="https://suavecreators.com/assets/brand/og-default.png">', false);
        $response->assertSee('<meta property="og:image:width" content="1200">', false);
        $response->assertSee('<meta property="og:image:height" content="630">', false);
        $response->assertSee('<meta property="og:image:alt" content="Suave Creators custom software development team and product dashboard">', false);
        $response->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
        $response->assertSee('<meta name="twitter:description" content="Custom CRM, ERP and web apps by senior developers. 100% code ownership, 2-week sprints.">', false);
        $response->assertSee('<link rel="icon" href="'.asset('favicon.ico').'?v=3" sizes="any">', false);
        $response->assertSee('<link rel="manifest" href="'.asset('site.webmanifest').'">', false);
        $response->assertDontSee('favicon.svg', false);
        $response->assertDontSee('/images/og/', false);
        $response->assertDontSee('[FOUNDER', false);
        $graph = $this->jsonLdGraph($response->getContent());
        $types = array_map(static fn (array $node): string => (string) ($node['@type'] ?? ''), $graph);

        $this->assertSame([
            'Organization',
            'ProfessionalService',
            'OfferCatalog',
            'WebSite',
            'WebPage',
            'FAQPage',
        ], $types);

        $organization = $graph[0];
        $this->assertSame('https://suavecreators.com/#organization', $organization['@id']);
        $this->assertSame('Custom software you own.', $organization['slogan']);
        $this->assertSame('2021', $organization['foundingDate']);
        $this->assertSame('US', $organization['address']['addressCountry']);
        $this->assertArrayNotHasKey('aggregateRating', $organization);
        $this->assertSame('QuantitativeValue', $organization['numberOfEmployees']['@type']);
        $this->assertSame(10, $organization['numberOfEmployees']['minValue']);
        $this->assertSame('Person', $organization['founder']['@type']);
        $this->assertSame('https://suavecreators.com/#founder', $organization['founder']['@id']);
        $this->assertSame('Aakash Choudhary', $organization['founder']['name']);
        $this->assertSame('Founder & Solution Architect', $organization['founder']['jobTitle']);
        $this->assertSame(
            ['https://www.linkedin.com/in/aakash-choudhary-b821b3191/'],
            $organization['founder']['sameAs']
        );
        $this->assertSame('sales', $organization['contactPoint'][0]['contactType']);
        $this->assertSame(['English'], $organization['contactPoint'][0]['availableLanguage']);
        $this->assertSame('technical support', $organization['contactPoint'][1]['contactType']);
        $this->assertSame(['English', 'Hindi'], $organization['contactPoint'][1]['availableLanguage']);
        $this->assertSame('https://suavecreators.com/#india-engineering-center', $organization['department']['@id']);

        $this->assertSame('IN', $graph[1]['address']['addressCountry']);
        $this->assertSame('GeoCoordinates', $graph[1]['geo']['@type']);
        $this->assertSame(32.0841192, $graph[1]['geo']['latitude']);
        $this->assertSame(76.5132446, $graph[1]['geo']['longitude']);
        $this->assertSame('https://suavecreators.com/#organization', $graph[1]['parentOrganization']['@id']);

        $this->assertCount(6, $graph[2]['itemListElement']);
        $offerUrls = array_map(
            static fn (array $offer): string => (string) ($offer['itemOffered']['url'] ?? ''),
            $graph[2]['itemListElement']
        );
        $this->assertContains(route('service.show', ['slug' => 'custom-crm-development']), $offerUrls);
        $this->assertNotContains('https://suavecreators.com/hire-dedicated-developers', $offerUrls);

        $this->assertArrayNotHasKey('potentialAction', $graph[3]);
        $this->assertSame(
            [
                'https://www.linkedin.com/company/suave-creators/',
                'https://www.instagram.com/suavecreators/',
                'https://www.facebook.com/suavecreators/',
                'https://www.crunchbase.com/organization/suave-creators',
            ],
            $organization['sameAs']
        );
        $this->assertSame('https://suavecreators.com/#webpage', $graph[4]['@id']);
        $this->assertSame('2021-01-01', $graph[4]['datePublished']);
        $this->assertSame('2026-10-07', $graph[4]['dateModified']);
        $this->assertSame('Get a Scoped Estimate', $graph[4]['potentialAction']['name']);
        $this->assertSame(route('contact-us'), $graph[4]['potentialAction']['target']);
        $this->assertSame('https://suavecreators.com/#webpage', $graph[5]['isPartOf']['@id']);
        $this->assertCount(8, $graph[5]['mainEntity']);
        $this->assertSame('How much does custom software development cost?', $graph[5]['mainEntity'][0]['name']);
        $this->assertStringNotContainsString('[', (string) $graph[5]['mainEntity'][0]['acceptedAnswer']['text']);
        $this->assertSame(
            'Do you provide support after launch?',
            $graph[5]['mainEntity'][7]['name']
        );
        $this->assertStringContainsString(
            '4 business hours for critical issues',
            (string) $graph[5]['mainEntity'][7]['acceptedAnswer']['text']
        );

        $encoded = $response->getContent();
        $this->assertStringNotContainsString('"@type":"BreadcrumbList"', $encoded);
        $this->assertStringNotContainsString('"@type":"SearchAction"', $encoded);
        $this->assertStringNotContainsString('AggregateRating', $encoded);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function jsonLdGraph(string $html): array
    {
        $this->assertSame(1, preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches));

        $decoded = json_decode(html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5), true);
        $this->assertIsArray($decoded);

        $graph = $decoded['@graph'] ?? null;
        $this->assertIsArray($graph);

        return array_values($graph);
    }
}
