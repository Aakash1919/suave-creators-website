<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SanitizeBlogCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_sanitizes_posts_in_id_chunks(): void
    {
        Storage::fake('public');

        $this->seedSanitizePosts();

        $this->artisan('run-once:sanitize-blog', ['--chunk' => 2])->assertSuccessful();

        $first = (string) Blog::query()->where('slug', 'first-sanitize-post')->value('content');
        $second = (string) Blog::query()->where('slug', 'second-sanitize-post')->value('content');

        $this->assertStringContainsString('<p>Keep me</p>', $first);
        $this->assertStringNotContainsString('<p></p>', $first);
        $this->assertStringContainsString('<p>Also keep me</p>', $second);
        $this->assertStringNotContainsString('<h2><br></h2>', $second);
    }

    public function test_command_default_chunk_is_one_blog_per_query(): void
    {
        Storage::fake('public');

        $this->seedSanitizePosts();

        $this->artisan('run-once:sanitize-blog')
            ->expectsOutputToContain('in chunks of 1')
            ->assertSuccessful();
    }

    private function seedSanitizePosts(): void
    {
        $author = User::factory()->create();
        $category = BlogCategory::query()->create([
            'name' => 'Software Development',
            'slug' => 'software-development',
            'sort_order' => 1,
        ]);

        Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'first-sanitize-post',
            'title' => 'First Sanitize Post',
            'short_description' => 'First excerpt.',
            'content' => '<p>Keep me</p><p></p>',
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
        ]);

        Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'second-sanitize-post',
            'title' => 'Second Sanitize Post',
            'short_description' => 'Second excerpt.',
            'content' => '<p>Also keep me</p><h2><br></h2>',
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDays(2),
        ]);
    }
}
