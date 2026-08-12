<?php

namespace Tests\Feature;

use Tests\TestCase;

class CanonicalHostTest extends TestCase
{
    public function test_www_requests_use_primary_non_www_canonical_host(): void
    {
        config(['app.url' => 'https://suavecreators.com']);

        $response = $this
            ->withServerVariables([
                'HTTPS' => 'on',
                'HTTP_HOST' => 'www.suavecreators.com',
                'SERVER_NAME' => 'www.suavecreators.com',
                'SERVER_PORT' => '443',
            ])
            ->get('/contact-us');

        $response->assertOk();
        $response->assertSee('<link rel="canonical" href="https://suavecreators.com/contact-us">', false);
        $response->assertSee('<meta property="og:url" content="https://suavecreators.com/contact-us">', false);
        $response->assertSee('<meta property="og:image" content="https://suavecreators.com/assets/brand/og-default.png">', false);
        $response->assertSee('<meta name="twitter:image" content="https://suavecreators.com/assets/brand/og-default.png">', false);
        $response->assertSee('<link rel="alternate" href="https://suavecreators.com/contact-us" hreflang="x-default">', false);
        $response->assertSee('"url":"https://suavecreators.com/contact-us"', false);
        $response->assertDontSee('<link rel="canonical" href="https://www.suavecreators.com/contact-us">', false);
        $response->assertDontSee('<meta property="og:image" content="https://www.suavecreators.com/assets/brand/og-default.png">', false);
    }
}
