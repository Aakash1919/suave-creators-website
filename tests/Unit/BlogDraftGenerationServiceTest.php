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
        $this->assertArrayHasKey('visual_html', $examples[0]);
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
        $this->assertStringContainsString('Shape A — framework guide', $instructions);
        $this->assertStringContainsString('Shape B — transformation story', $instructions);
        $this->assertStringContainsString('blog-results', $instructions);
        $this->assertStringContainsString('blog-checklist', $instructions);
        $this->assertStringContainsString('blog-stats', $instructions);
        $this->assertStringContainsString('imagine a world', $instructions);
        $this->assertStringContainsString('HUMAN VOICE', $instructions);
        $this->assertStringContainsString("in today's fast-paced world", $instructions);
        $this->assertStringContainsString('blog-chart__row', $instructions);
        $this->assertStringContainsString('blog-chart__value', $instructions);
        $this->assertStringContainsString('COMPLETION BARS', $instructions);
        $this->assertStringContainsString('Never put label text inside .blog-chart__bar', $instructions);
        $this->assertStringContainsString('Do NOT emit <h1>', $instructions);
    }

    public function test_blog_writer_prompt_uses_assigned_topic_when_provided(): void
    {
        $agent = new BlogWriterAgent(
            categories: ['Software Development'],
            topic: 'How clinics should brief a custom CRM',
        );

        $instructions = (string) $agent->instructions();

        $this->assertStringContainsString('Assigned topic: How clinics should brief a custom CRM', $instructions);
        $this->assertStringContainsString('Write this article on the assigned topic only', $instructions);
    }

    public function test_persist_draft_wraps_bare_tables_and_demotes_h1(): void
    {
        User::factory()->create([
            'email' => SiteAdmin::EMAIL,
            'name' => SiteAdmin::NAME,
        ]);

        BlogCategory::query()->create([
            'name' => 'Software Development',
            'slug' => 'software-development',
            'sort_order' => 1,
        ]);

        /** @var BlogDraftGenerationService $service */
        $service = $this->app->make(BlogDraftGenerationService::class);

        $blog = $service->persistDraft([
            'title' => 'Custom CRM Versus Off The Shelf Tools For Growing Teams',
            'short_description' => 'A practical comparison of when custom software beats a packaged CRM, and when it does not.',
            'category' => 'Software Development',
            'content' => '<h1>Intro</h1><p>Start with the buying question.</p><table><thead><tr><th>Factor</th><th>Custom</th></tr></thead><tbody><tr><td>Fit</td><td>High</td></tr></tbody></table><div class="blog-table-wrap"><table><thead><tr><th>Kept</th></tr></thead><tbody><tr><td>Yes</td></tr></tbody></table></div>',
            'meta_title' => 'Custom CRM Versus Packaged Tools',
            'meta_description' => 'When custom CRM work is worth it for growing teams.',
            'og_title' => 'Custom CRM Versus Packaged Tools',
            'og_description' => 'When custom CRM work is worth it for growing teams.',
            'faqs' => [
                [
                    'question' => 'Should we start custom?',
                    'answer' => 'Only if the packaged tools cannot hold your workflow.',
                ],
            ],
        ]);

        $this->assertStringNotContainsString('<h1', (string) $blog->content);
        $this->assertStringContainsString('<h2>Intro</h2>', (string) $blog->content);
        $this->assertSame(2, substr_count((string) $blog->content, 'class="blog-table-wrap"'));
        $this->assertStringNotContainsString(
            '<div class="blog-table-wrap"><div class="blog-table-wrap">',
            (string) $blog->content
        );
    }

    public function test_persist_draft_strips_trailing_faq_html_from_content(): void
    {
        User::factory()->create([
            'email' => SiteAdmin::EMAIL,
            'name' => SiteAdmin::NAME,
        ]);

        BlogCategory::query()->create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'sort_order' => 1,
        ]);

        /** @var BlogDraftGenerationService $service */
        $service = $this->app->make(BlogDraftGenerationService::class);

        $blog = $service->persistDraft([
            'title' => 'How To Brief A Web Development Partner Without Wasting A Month',
            'short_description' => 'A straightforward brief that gets a web project moving without a month of back and forth.',
            'category' => 'Web Development',
            'content' => '<h2>The Bottom Line</h2><p>Ship the first slice, then decide what to rebuild.</p><h2>FAQs</h2><ul><li><p>What belongs in the brief?</p></li></ul>',
            'meta_title' => 'Brief A Web Development Partner',
            'meta_description' => 'What to put in a web development brief so work can start.',
            'og_title' => 'Brief A Web Development Partner',
            'og_description' => 'What to put in a web development brief so work can start.',
            'faqs' => [
                [
                    'question' => 'What belongs in the brief?',
                    'answer' => 'Outcomes, users, constraints, and the first release.',
                ],
            ],
        ]);

        $this->assertStringContainsString('The Bottom Line', (string) $blog->content);
        $this->assertStringNotContainsString('<h2>FAQs</h2>', (string) $blog->content);
        $this->assertIsArray($blog->faqs);
        $this->assertCount(1, $blog->faqs);
    }

    public function test_persist_draft_rewrites_chart_bars_and_drops_empty_stat_boxes(): void
    {
        User::factory()->create([
            'email' => SiteAdmin::EMAIL,
            'name' => SiteAdmin::NAME,
        ]);

        BlogCategory::query()->create([
            'name' => 'Software Development',
            'slug' => 'software-development',
            'sort_order' => 1,
        ]);

        /** @var BlogDraftGenerationService $service */
        $service = $this->app->make(BlogDraftGenerationService::class);

        $blog = $service->persistDraft([
            'title' => 'How To Sequence An Api First Migration Without Inventing Metrics',
            'short_description' => 'A practical sequence for moving a product to API-first delivery without dressing the plan in fake percentages.',
            'category' => 'Software Development',
            'content' => '<h2>Chart</h2><figure class="blog-chart"><div class="blog-chart__bar blog-chart__bar--high">Assessment</div><div class="blog-chart__bar blog-chart__bar--mid">Strategy</div></figure><div class="blog-stats"><div class="blog-stat"><p class="blog-stat__value">One contract</p><p class="blog-stat__label">Shared by product and ops.</p></div><div class="blog-stat"><p class="blog-stat__value"></p><p class="blog-stat__label"></p></div></div><aside class="blog-insight"><p></p></aside><p>Keep the rollout honest.</p>',
            'meta_title' => 'Sequence An Api First Migration',
            'meta_description' => 'How to sequence an API-first migration without fake metrics.',
            'og_title' => 'Sequence An Api First Migration',
            'og_description' => 'How to sequence an API-first migration without fake metrics.',
            'faqs' => [
                [
                    'question' => 'Where should an API-first migration start?',
                    'answer' => 'With the workflow that currently needs the most handoffs.',
                ],
            ],
        ]);

        $content = (string) $blog->content;
        $this->assertStringContainsString('blog-chart__row', $content);
        $this->assertStringContainsString('blog-chart__label', $content);
        $this->assertStringContainsString('blog-chart__value', $content);
        $this->assertStringContainsString('data-width="90"', $content);
        $this->assertStringContainsString('Assessment', $content);
        $this->assertStringContainsString('blog-chart__track', $content);
        $this->assertDoesNotMatchRegularExpression(
            '/class="[^"]*\bblog-chart__bar\b[^"]*"[^>]*>\s*Assessment/i',
            $content
        );
        $this->assertStringContainsString('One contract', $content);
        $this->assertSame(1, substr_count($content, 'class="blog-stat"'));
        $this->assertStringNotContainsString('blog-insight', $content);
    }
}
