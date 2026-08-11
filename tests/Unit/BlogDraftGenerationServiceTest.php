<?php

namespace Tests\Unit;

use App\Ai\Agents\BlogWriterAgent;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Services\BlogDraftGenerationService;
use App\Support\SiteAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogDraftGenerationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_persist_draft_saves_status_draft_without_published_at(): void
    {
        User::factory()->create([
            'email' => SiteAdmin::EMAIL,
            'name' => SiteAdmin::NAME,
        ]);

        BlogCategory::query()->create([
            'name' => 'Artificial Intelligence',
            'slug' => 'artificial-intelligence',
            'sort_order' => 1,
        ]);

        /** @var BlogDraftGenerationService $service */
        $service = $this->app->make(BlogDraftGenerationService::class);

        $blog = $service->persistDraft([
            'title' => 'How AI Agents Are Changing Product Roadmaps in 2026',
            'short_description' => 'A practical look at where AI agents fit in shipping software.',
            'category' => 'Artificial Intelligence',
            'content' => '<h2>Introduction</h2><p>AI agents are reshaping how teams plan and ship software.</p><h2>Takeaways</h2><ul><li><p>Start small.</p></li></ul>',
            'meta_title' => 'AI Agents and Product Roadmaps',
            'meta_description' => 'How AI agents change product roadmaps for software teams.',
            'og_title' => 'AI Agents and Product Roadmaps',
            'og_description' => 'How AI agents change product roadmaps for software teams.',
            'faqs' => [
                [
                    'question' => 'What is an AI agent?',
                    'answer' => 'Software that can plan and act toward a goal with tools.',
                ],
            ],
        ]);

        $this->assertSame(Blog::STATUS_DRAFT, $blog->status);
        $this->assertNull($blog->published_at);
        $this->assertNotEmpty($blog->slug);
        $this->assertSame('Artificial Intelligence', $blog->category?->name);
        $this->assertIsArray($blog->faqs);
        $this->assertCount(1, $blog->faqs);
        $this->assertSame('AI Agents and Product Roadmaps', (string) $blog->meta_title);
    }

    public function test_style_examples_are_built_from_existing_blogs(): void
    {
        User::factory()->create([
            'email' => SiteAdmin::EMAIL,
            'name' => SiteAdmin::NAME,
        ]);

        $authorId = (int) User::query()->first()->id;

        $software = BlogCategory::query()->create([
            'name' => 'Software Development',
            'slug' => 'software-development',
            'sort_order' => 1,
        ]);
        $web = BlogCategory::query()->create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'sort_order' => 2,
        ]);

        $longBody = '<h1>Why Your Systems Stall Growth</h1>'
            .'<p>'.str_repeat('Your software should unlock scale, not create friction. ', 80).'</p>'
            .'<h2>Five Signs</h2><h3>1. Manual Work</h3><ul><li><p>Teams copy data between tools.</p></li></ul>'
            .'<h2>The Bottom Line</h2><p>Fix the foundation before you spend more on ads.</p>';

        Blog::query()->create([
            'blog_category_id' => $software->id,
            'created_by_id' => $authorId,
            'slug' => 'why-your-systems-stall-growth',
            'title' => 'Why Your Systems Stall Growth Before You Notice',
            'short_description' => 'Growing teams often hit invisible software ceilings. Here is how to spot them early and fix the foundation.',
            'content' => $longBody,
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
            'faqs' => [
                [
                    'question' => 'How do I know my software is holding me back?',
                    'answer' => 'Look for manual workarounds, delayed reporting, and tools that do not talk to each other.',
                ],
            ],
            'meta_title' => 'Why Your Systems Stall Growth | Suave Creators Blog',
        ]);

        Blog::query()->create([
            'blog_category_id' => $software->id,
            'created_by_id' => $authorId,
            'slug' => 'another-software-post',
            'title' => 'How to Build Systems That Keep Up With Demand',
            'short_description' => 'A second software post for category ranking.',
            'content' => $longBody,
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDays(2),
        ]);

        Blog::query()->create([
            'blog_category_id' => $web->id,
            'created_by_id' => $authorId,
            'slug' => 'web-post',
            'title' => 'Why Your Website Is Your Most Important Salesperson',
            'short_description' => 'A web post.',
            'content' => $longBody,
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDays(3),
        ]);

        /** @var BlogDraftGenerationService $service */
        $service = $this->app->make(BlogDraftGenerationService::class);

        $examples = $service->styleExamples();
        $this->assertNotEmpty($examples);
        $this->assertArrayHasKey('title', $examples[0]);
        $this->assertArrayHasKey('headings', $examples[0]);
        $this->assertArrayHasKey('opening_html', $examples[0]);
        $this->assertStringContainsString('h2', (string) $examples[0]['headings']);

        $preferred = $service->preferredCategoryNames();
        $this->assertSame('Software Development', $preferred[0]);
    }

    public function test_blog_writer_prompt_prioritizes_customer_acquisition_topic_angles(): void
    {
        $agent = new BlogWriterAgent(
            categories: ['Software Development', 'Web Development'],
            recentTitles: ['Why Your Website Is Your Most Important Salesperson'],
        );

        $instructions = (string) $agent->instructions();

        $this->assertStringContainsString('CUSTOMER ACQUISITION TOPIC STRATEGY', $instructions);
        $this->assertStringContainsString('Service-intent posts', $instructions);
        $this->assertStringContainsString('Industry-intent posts', $instructions);
        $this->assertStringContainsString('Problem-intent posts', $instructions);
        $this->assertStringContainsString('Comparison-intent posts', $instructions);
        $this->assertStringContainsString('Buyer-ready / bottom-funnel posts', $instructions);
        $this->assertStringContainsString('The draft must help Suave Creators attract qualified organic leads', $instructions);
    }
}
