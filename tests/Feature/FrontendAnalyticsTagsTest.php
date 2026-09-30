<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendAnalyticsTagsTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_tags_are_omitted_outside_production(): void
    {
        $html = $this->get(route('home'))->assertOk()->getContent();

        $this->assertStringNotContainsString('google-site-verification', $html);
        $this->assertStringNotContainsString((string) config('seo.site.google_analytics_id'), $html);
        $this->assertStringNotContainsString((string) config('seo.site.google_tag_manager_id'), $html);
    }

    public function test_google_tags_render_in_production(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');

        $html = $this->get(route('home'))->assertOk()->getContent();

        $this->assertStringContainsString('<meta name="google-site-verification"', $html);
        $this->assertStringContainsString("gtag('config', \"".config('seo.site.google_analytics_id').'")', $html);
        $this->assertStringContainsString('googletagmanager.com/ns.html?id='.config('seo.site.google_tag_manager_id'), $html);
    }
}
