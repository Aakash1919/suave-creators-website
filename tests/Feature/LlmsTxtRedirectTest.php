<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LlmsTxtRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_llm_txt_redirects_to_llms_txt(): void
    {
        $response = $this->get('/llm.txt');

        $response->assertRedirect('/llms.txt');
        $this->assertSame(301, $response->getStatusCode());
    }

    public function test_llms_txt_is_served_and_self_references_canonical_url(): void
    {
        config(['app.url' => 'https://suavecreators.com']);

        $response = $this->get('/llms.txt');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('This file: https://suavecreators.com/llms.txt', false);
        $response->assertDontSee('This file: https://suavecreators.com/llm.txt', false);
    }
}
