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
        $this->assertStringContainsString('UNIQUENESS IS MANDATORY', $instructions);
        $this->assertStringContainsString('REQUIRED ARTICLE PATTERN', $instructions);
        $this->assertStringContainsString('REQUIRED OPENING', $instructions);
        $this->assertStringContainsString('INTERNAL LINKS', $instructions);
        $this->assertStringContainsString('TABLES, CHARTS, AND STATS ARE OPTIONAL', $instructions);
        $this->assertStringContainsString('blog-results', $instructions);
        $this->assertStringContainsString('blog-checklist', $instructions);
        $this->assertStringContainsString('blog-stats', $instructions);
        $this->assertStringContainsString('imagine a world', $instructions);
        $this->assertStringContainsString('HUMAN VOICE', $instructions);
        $this->assertStringContainsString("in today's fast-paced world", $instructions);
        $this->assertStringContainsString('blog-chart__row', $instructions);
        $this->assertStringContainsString('blog-chart__value', $instructions);
        $this->assertStringContainsString('WHEN YOU DO INCLUDE A CHART', $instructions);
        $this->assertStringContainsString('Never put label text inside .blog-chart__bar', $instructions);
        $this->assertStringContainsString('Do NOT emit <h1>', $instructions);
    }

    public function test_blog_writer_prompt_forces_required_pattern(): void
    {
        $agent = new BlogWriterAgent(
            categories: ['Software Development'],
            requiredPattern: 'checklist',
            recentPatterns: ['framework', 'story'],
            requiredOpening: 'question',
            recentOpenings: ['scene'],
            internalLinks: [
                [
                    'type' => 'service',
                    'title' => 'Custom CRM Development',
                    'url' => 'https://example.com/services/custom-crm-development',
                    'summary' => 'Tailored CRM builds.',
                ],
            ],
        );

        $instructions = (string) $agent->instructions();

        $this->assertStringContainsString('article_shape: checklist', $instructions);
        $this->assertStringContainsString('Action checklist deep-dive', $instructions);
        $this->assertStringContainsString('opening_style: question', $instructions);
        $this->assertStringContainsString('Buyer question', $instructions);
        $this->assertStringContainsString('custom-crm-development', $instructions);
        $this->assertStringContainsString('- framework', $instructions);
        $this->assertStringContainsString('- story', $instructions);
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

    public function test_assert_unique_draft_rejects_similar_title(): void
    {
        User::factory()->create([
            'email' => SiteAdmin::EMAIL,
            'name' => SiteAdmin::NAME,
        ]);

        $authorId = (int) User::query()->first()->id;
        $category = BlogCategory::query()->create([
            'name' => 'Software Development',
            'slug' => 'software-development',
            'sort_order' => 1,
        ]);

        Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $authorId,
            'slug' => 'how-clinics-should-brief-a-custom-crm',
            'title' => 'How Clinics Should Brief A Custom CRM',
            'short_description' => 'A practical brief for clinic operators choosing a custom CRM partner.',
            'content' => '<p>'.str_repeat('Clinic teams lose leads when handoffs stall between desks and tools. ', 40).'</p>',
            'status' => Blog::STATUS_DRAFT,
            'published_at' => null,
        ]);

        /** @var BlogDraftGenerationService $service */
        $service = $this->app->make(BlogDraftGenerationService::class);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('too similar');

        $service->assertUniqueDraft([
            'title' => 'How Clinics Should Brief a Custom CRM System',
            'article_shape' => 'framework',
            'opening_style' => 'scene',
            'content' => '<div class="blog-takeaways"><p class="blog-takeaways__title">Key takeaways</p><ul><li>One</li></ul></div>'
                .'<div class="blog-checklist"><p class="blog-checklist__title">List</p><ul><li>Do</li></ul></div>'
                .'<aside class="blog-insight"><p>Take</p></aside>'
                .'<p>'.str_repeat('Completely different body about warehouse routing software and carrier APIs. ', 40).'</p>',
        ], 'framework', 'scene');
    }

    public function test_framework_pattern_does_not_require_table_chart_or_stats(): void
    {
        $frameworkHtml = '<div class="blog-takeaways"><p class="blog-takeaways__title">Key takeaways</p><ul><li>One</li></ul></div>'
            .'<div class="blog-checklist"><p class="blog-checklist__title">List</p><ul><li>Do</li></ul></div>'
            .'<aside class="blog-insight"><p>Take</p></aside>';

        $this->assertTrue(\App\Support\Blogs\BlogArticlePatterns::htmlMatches('framework', $frameworkHtml));

        $comparisonWithoutTable = '<div class="blog-takeaways"><p class="blog-takeaways__title">Key takeaways</p><ul><li>One</li></ul></div>'
            .'<aside class="blog-insight"><p>Take</p></aside>';

        $this->assertFalse(\App\Support\Blogs\BlogArticlePatterns::htmlMatches('comparison', $comparisonWithoutTable));
    }

    public function test_opening_rotation_avoids_recent_usage(): void
    {
        $next = \App\Support\Blogs\BlogArticleOpenings::chooseNext(
            ['scene', 'question'],
            []
        );

        $this->assertContains($next, ['contrast', 'checklist-first']);
        $this->assertNotContains($next, ['scene', 'question']);
    }

    public function test_internal_links_suggest_service_or_industry_matches(): void
    {
        $links = \App\Support\Blogs\BlogInternalLinks::suggest(
            title: 'How clinics should brief a custom CRM before hiring a partner',
            content: '<p>Healthcare operators need intake, reporting, and a shared CRM workflow.</p>',
            limit: 3,
        );

        $this->assertGreaterThanOrEqual(2, count($links));
        $this->assertLessThanOrEqual(3, count($links));
        $types = array_column($links, 'type');
        $this->assertTrue(
            in_array('service', $types, true) || in_array('industry', $types, true) || in_array('hub', $types, true)
        );
        foreach ($links as $link) {
            $this->assertNotEmpty($link['url']);
            $this->assertNotEmpty($link['title']);
        }
    }

    public function test_assert_unique_draft_rejects_wrong_pattern_blocks(): void
    {
        /** @var BlogDraftGenerationService $service */
        $service = $this->app->make(BlogDraftGenerationService::class);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('missing required visual blocks');

        $service->assertUniqueDraft([
            'title' => 'A Completely Unique Title About Warehouse Routing Software Partners',
            'article_shape' => 'story',
            'content' => '<div class="blog-takeaways"><p class="blog-takeaways__title">Key takeaways</p><ul><li>One</li></ul></div><p>Missing results block for story pattern.</p>',
        ], 'story');
    }

    public function test_choose_next_pattern_avoids_recent_usage(): void
    {
        $next = \App\Support\Blogs\BlogArticlePatterns::chooseNext(
            ['framework', 'story', 'comparison'],
            []
        );

        $this->assertContains($next, ['checklist', 'stats-led', 'roadmap']);
        $this->assertNotContains($next, ['framework', 'story', 'comparison']);
    }

    public function test_assert_unique_draft_rejects_stock_phase_headings(): void
    {
        /** @var BlogDraftGenerationService $service */
        $service = $this->app->make(BlogDraftGenerationService::class);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('stock phase headings');

        $service->assertUniqueDraft([
            'title' => 'A Completely Unique Title About Warehouse Routing Partners In 2026',
            'article_shape' => 'roadmap',
            'opening_style' => 'scene',
            'content' => '<div class="blog-takeaways"><p class="blog-takeaways__title">Key takeaways</p><ul><li>One</li></ul></div>'
                .'<h2>Discover</h2><p>'.str_repeat('Warehouse teams need clearer routing ownership before software work starts. ', 20).'</p>'
                .'<h2>Pilot</h2><p>'.str_repeat('A short pilot on one lane beats a full rebuild. ', 20).'</p>'
                .'<h2>Harden</h2><p>'.str_repeat('Lock the handoff rules before you scale the workflow. ', 20).'</p>'
                .'<div class="blog-checklist"><p class="blog-checklist__title">List</p><ul><li>Do</li></ul></div>'
                .'<aside class="blog-insight"><p>Take</p></aside>',
        ], 'roadmap', 'scene');
    }
}
