<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrawlBudgetCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_retired_turbo_host_returns_gone(): void
    {
        config([
            'app.url' => 'https://suavecreators.com',
            'seo.retired_hosts' => ['turbo.suavecreators.com'],
        ]);

        $response = $this->get('https://turbo.suavecreators.com/?i=56543850635');

        $response->assertStatus(410);
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_spam_query_params_permanently_redirect_to_clean_path(): void
    {
        config(['app.url' => 'https://suavecreators.com']);

        $response = $this->get('https://suavecreators.com/?i=56543850635&k=59645099160');

        $response->assertStatus(301);
        $response->assertRedirect('https://suavecreators.com');
    }

    public function test_allowed_query_params_are_kept_when_stripping_junk(): void
    {
        config(['app.url' => 'https://suavecreators.com']);

        $response = $this->get('https://suavecreators.com/blogs?q=laravel&i=123&utm_source=newsletter');

        $response->assertStatus(301);
        $location = (string) $response->headers->get('Location');
        $this->assertStringContainsString('/blogs?', $location);
        $this->assertStringContainsString('q=laravel', $location);
        $this->assertStringContainsString('utm_source=newsletter', $location);
        $this->assertStringNotContainsString('i=123', $location);
    }

    public function test_allowed_only_query_string_is_not_redirected(): void
    {
        config(['app.url' => 'https://suavecreators.com']);

        $response = $this->get('https://suavecreators.com/blogs?q=laravel&utm_source=newsletter');

        $response->assertOk();
    }
}
