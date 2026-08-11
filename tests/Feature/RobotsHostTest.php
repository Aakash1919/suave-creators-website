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
        $response->assertSee('Sitemap: https://suavecreators.com/sitemap.xml', false);
        $response->assertSee('# LLM discovery: https://suavecreators.com/llm.txt', false);
        $response->assertDontSee('https://www.suavecreators.com', false);
    }
}
