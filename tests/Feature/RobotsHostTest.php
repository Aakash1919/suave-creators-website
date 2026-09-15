<?php

namespace Tests\Feature;

use Tests\TestCase;

class RobotsHostTest extends TestCase
{
    public function test_www_requests_use_primary_non_www_discovery_urls(): void
    {
        config(['app.url' => 'https://suavecreators.com']);

        $response = $this
            ->withServerVariables([
                'HTTPS' => 'on',
                'HTTP_HOST' => 'www.suavecreators.com',
                'SERVER_NAME' => 'www.suavecreators.com',
                'SERVER_PORT' => '443',
            ])
            ->get('/robots.txt');

        $response->assertOk();
        $response->assertSee('# robots.txt for https://suavecreators.com/', false);
        $response->assertSee('# Canonical Host: https://suavecreators.com', false);
        $response->assertSee('# LLM Context: https://suavecreators.com/llms.txt', false);
        $response->assertSee('Sitemap: https://suavecreators.com/sitemap.xml', false);
        $response->assertSee('Allow: /blog/', false);
        $response->assertSee('Allow: /llms.txt', false);
        $response->assertSee('Disallow: /admin/', false);
        $response->assertSee('Disallow: /contact-us/draft*', false);
        $response->assertSee('Disallow: /consultation-request*', false);
        $response->assertSee('Disallow: /wp-admin/', false);
        $response->assertSee('Disallow: /*?s=*', false);
        $response->assertSee('User-agent: GPTBot', false);
        $response->assertSee('Allow: /llms-full.txt', false);
        $response->assertDontSee('https://www.suavecreators.com', false);
    }
}
