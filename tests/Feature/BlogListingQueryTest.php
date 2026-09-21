<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Support\Frontend\BlogSupport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BlogListingQueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_listing_queries_omit_article_html(): void
    {
        $this->seedPublishedBlogs();

        DB::flushQueryLog();
        DB::enableQueryLog();

        $cards = BlogSupport::posts(limit: 3);
        BlogSupport::articleCards(3);
        BlogSupport::indexData();

        $listingSql = collect(DB::getQueryLog())
            ->pluck('query')
            ->filter(fn (mixed $sql): bool => is_string($sql))
            ->filter(fn (string $sql): bool => (bool) preg_match('/from\s+[`"]blogs[`"]/i', $sql))
            ->filter(fn (string $sql): bool => str_contains(strtolower($sql), 'select') && ! str_contains(strtolower($sql), 'count('));

        $this->assertNotEmpty($listingSql);
        $listingSql->each(function (string $sql): void {
            $this->assertDoesNotMatchRegularExpression('/[`"]content[`"]/', $sql);
            $this->assertDoesNotMatchRegularExpression('/[`"]toc[`"]/', $sql);
            $this->assertDoesNotMatchRegularExpression('/[`"]faqs[`"]/', $sql);
        });

        $this->assertSame('', (string) ($cards->first()['content'] ?? ''));
    }

    public function test_article_page_loads_current_html_without_other_posts_content(): void
    {
        [$hugeSlug] = $this->seedPublishedBlogs();

        $data = BlogSupport::showData($hugeSlug);

        $this->assertStringContainsString('HUGE_ARTICLE_MARKER', (string) $data['post']['content']);
        $this->assertNotEmpty($data['sliderPosts']);
        $this->assertSame('', (string) ($data['sliderPosts'][0]['content'] ?? ''));
        $this->assertSame('', (string) ($data['topPosts'][0]['content'] ?? ''));
    }

    public function test_marketing_pages_survive_oversized_blog_html(): void
    {
        [$hugeSlug] = $this->seedPublishedBlogs();

        $this->get(route('home'))->assertOk();
        $this->get(route('blogs'))->assertOk();
        $this->get(route('industries'))->assertOk();
        $this->get(route('service.show', ['slug' => 'web-development-services']))->assertOk();
        $this->get(route('blog.show', ['slug' => $hugeSlug]))->assertOk();
    }

    /**
     * @return array{0: string}
     */
    private function seedPublishedBlogs(): array
    {
        $author = User::factory()->create();
        $category = BlogCategory::query()->create([
            'name' => 'Software Development',
            'slug' => 'software-development',
            'sort_order' => 1,
        ]);

        $hugeSlug = 'oversized-html-post';

        Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => $hugeSlug,
            'title' => 'Oversized HTML Post',
            'short_description' => 'A listing card excerpt.',
            'content' => '<p>HUGE_ARTICLE_MARKER</p>'.str_repeat('<p>'.str_repeat('x', 800).'</p>', 2500),
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
        ]);

        Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'related-listing-post',
            'title' => 'Related Listing Post',
            'short_description' => 'Another excerpt.',
            'content' => '<p>RELATED_MARKER</p>'.str_repeat('<p>'.str_repeat('y', 800).'</p>', 2500),
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDays(2),
        ]);

        return [$hugeSlug];
    }
}
