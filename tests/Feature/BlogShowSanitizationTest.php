<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Support\Blogs\BlogHtmlSupport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogShowSanitizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_blog_html_does_not_embed_data_images(): void
    {
        Storage::fake('public');

        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==',
            true
        );
        $this->assertNotFalse($png);

        $sanitized = BlogHtmlSupport::sanitizeContent(
            '<p><span style="font-size: 24px;"><b>Beyond Chatbots: The Architecture of Multi-Agent AI Systems in B2B Workflows</b></span></p>'
            .'<p>Lead paragraph about multi-agent systems.</p>'
            .'<h3>The Structural Failure Points of Single-Prompt AI</h3>'
            .'<h4>1. Context Window Dilution and Instruction Degradation</h4>'
            .'<img src="data:image/png;base64,'.base64_encode($png).'">',
            'beyond-chatbots-how-multi-agent-ai-systems-are-automating-b2b-workflows-in-2026',
            'Beyond Chatbots: How Multi-Agent AI Systems Are Automating B2B Workflows in 2026'
        )['content'];

        $author = User::factory()->create();

        $category = BlogCategory::query()->create([
            'name' => 'Artificial Intelligence',
            'slug' => 'artificial-intelligence',
            'sort_order' => 1,
        ]);

        Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'beyond-chatbots-how-multi-agent-ai-systems-are-automating-b2b-workflows-in-2026',
            'title' => 'Beyond Chatbots: How Multi-Agent AI Systems Are Automating B2B Workflows in 2026',
            'short_description' => 'Multi-agent systems automate B2B workflows.',
            'content' => $sanitized,
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
            'faqs' => [
                [
                    'question' => 'Why do chatbots fail at B2B workflow execution?',
                    'answer' => 'They lack persistent transactional state and validated API payloads.',
                ],
            ],
        ]);

        $response = $this->get(route('blog.show', [
            'slug' => 'beyond-chatbots-how-multi-agent-ai-systems-are-automating-b2b-workflows-in-2026',
        ]));

        $response->assertOk();
        $this->assertStringNotContainsString('data:image', $response->getContent());
        $response->assertDontSee('More Articles', false);
        $response->assertSee('Frequently Asked Questions', false);
        $response->assertDontSee('Frequently Asked Questions: Delivery, Pricing & Code Ownership', false);
        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
        $this->assertStringNotContainsString('The Architecture of Multi-Agent AI Systems', $response->getContent());
        $this->assertMatchesRegularExpression(
            '/<h2[^>]*>The Structural Failure Points of Single-Prompt AI<\/h2>/',
            $response->getContent()
        );
        $this->assertMatchesRegularExpression(
            '/<h3[^>]*>1\. Context Window Dilution and Instruction Degradation<\/h3>/',
            $response->getContent()
        );
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Content-Security-Policy-Report-Only');
    }

    public function test_published_blog_tables_are_wrapped_for_horizontal_scroll(): void
    {
        $author = User::factory()->create();

        $category = BlogCategory::query()->create([
            'name' => 'Artificial Intelligence',
            'slug' => 'artificial-intelligence',
            'sort_order' => 1,
        ]);

        Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'comparison-tables-on-mobile',
            'title' => 'Comparison Tables On Mobile',
            'short_description' => 'Wide comparison tables should scroll sideways on phones.',
            'content' => '<p>Lead paragraph about the comparison.</p><table><thead><tr><th>Factor</th><th>Build</th><th>Buy</th></tr></thead><tbody><tr><td>Fit</td><td>High</td><td>Medium</td></tr></tbody></table>',
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('blog.show', [
            'slug' => 'comparison-tables-on-mobile',
        ]));

        $response->assertOk();
        $this->assertSame(1, substr_count($response->getContent(), 'class="blog-table-wrap"'));
        $this->assertStringContainsString('<div class="blog-table-wrap"><table>', $response->getContent());
    }

    public function test_marketing_pages_send_security_headers(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Content-Security-Policy-Report-Only');
        $this->assertFalse($response->headers->has('Strict-Transport-Security'));
    }
}
