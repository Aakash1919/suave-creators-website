<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPaginationCanonicalTest extends TestCase
{
    use RefreshDatabase;

    public function test_blogs_page_query_redirects_to_clean_listing_url(): void
    {
        $response = $this->get('/blogs?page=2');

        $response->assertRedirect('/blogs');
        $this->assertSame(301, $response->status());
    }

    public function test_blogs_page_query_preserves_safe_filters_when_redirecting(): void
    {
        $response = $this->get('/blogs?page=3&q=crm&category=ai');

        $response->assertRedirect('/blogs?q=crm&category=ai');
        $this->assertSame(301, $response->status());
    }

    public function test_blogs_listing_canonical_excludes_pagination_parameter(): void
    {
        config(['app.url' => 'https://suavecreators.com']);

        $response = $this->get('/blogs');

        $response->assertOk();
        $response->assertSee('<link rel="canonical" href="https://suavecreators.com/blogs">', false);
        $response->assertDontSee('href="https://suavecreators.com/blogs?page=', false);
        $response->assertDontSee('href="/blogs?page=', false);
    }

    public function test_filter_endpoint_still_accepts_page_for_ajax_pagination(): void
    {
        $response = $this->getJson('/blogs/filter?page=2');

        $response->assertOk();
        $response->assertJsonStructure(['html', 'meta' => ['page', 'last_page', 'total']]);
        $this->assertFalse($response->isRedirect());
    }
}
