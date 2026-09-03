<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Support\Admin\BlogCompleteness;
use Tests\TestCase;

class BlogCompletenessTest extends TestCase
{
    public function test_empty_draft_is_not_ready(): void
    {
        $result = BlogCompleteness::evaluate(new Blog([
            'status' => Blog::STATUS_DRAFT,
        ]));

        $this->assertSame(0, $result['percent']);
        $this->assertSame(0, $result['done']);
        $this->assertGreaterThan(0, $result['total']);
    }

    public function test_filled_frontend_blocks_raise_the_score(): void
    {
        $blog = new Blog([
            'title' => 'How Clinics Should Brief A Custom CRM',
            'short_description' => str_repeat('A practical brief for clinic operators choosing software. ', 3),
            'content' => str_repeat('<p>Detail for the public article about clinic software intake. </p>', 160)
                .'<div class="blog-takeaways"><p class="blog-takeaways__title">Key takeaways</p><ul><li>Start with intake.</li></ul></div>'
                .'<aside class="blog-insight"><p>Keep the rollout honest.</p></aside>'
                .'<p>See our <a href="/services/custom-crm-development">custom CRM development</a> and <a href="/industries/healthcare">healthcare</a> pages.</p>',
            'blog_category_id' => 1,
            'featured_image' => 'blogs/demo.webp',
            'meta_title' => 'How Clinics Should Brief A Custom CRM',
            'meta_description' => 'What belongs in a clinic CRM brief before you hire a partner.',
            'faqs' => [
                ['question' => 'Where should we start?', 'answer' => 'With intake and reporting.'],
                ['question' => 'Do we need a custom build?', 'answer' => 'Only if packaged tools cannot hold the workflow.'],
                ['question' => 'How long is a first slice?', 'answer' => 'A two-week pilot on one workflow is enough to learn.'],
                ['question' => 'Who owns the data?', 'answer' => 'The clinic should keep export rights in the contract.'],
            ],
        ]);

        $result = BlogCompleteness::evaluate($blog);

        $this->assertSame($result['total'], $result['done']);
        $this->assertSame(100, $result['percent']);
    }

    public function test_article_body_is_complete_with_a_real_draft_not_an_essay_length_gate(): void
    {
        $short = BlogCompleteness::evaluate(new Blog([
            'content' => '<p>Too short.</p>',
        ]));
        $this->assertFalse(collect($short['items'])->firstWhere('key', 'content')['done']);

        $ready = BlogCompleteness::evaluate(new Blog([
            'content' => '<p>'.str_repeat('Clinic intake needs a shared picture of today. ', 20).'</p>',
        ]));
        $this->assertTrue(collect($ready['items'])->firstWhere('key', 'content')['done']);
    }
}
