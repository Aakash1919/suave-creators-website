<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBlogListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_title_links_to_edit_and_menu_offers_view_live_for_published_posts_only(): void
    {
        (new RolesAndPermissionsSeeder)->run();
        $user = User::factory()->createOne();
        $user->assignRole('admin');

        $category = BlogCategory::query()->create(['name' => 'Engineering', 'slug' => 'engineering', 'sort_order' => 1]);
        $published = $this->blog($user, $category, 'live-post', Blog::STATUS_PUBLISHED);
        $draft = $this->blog($user, $category, 'draft-post', Blog::STATUS_DRAFT);

        $rows = collect($this->actingAs($user)->getJson(route('admin.blogs.index', [
            'draw' => 1,
            'start' => 0,
            'length' => 10,
            'search' => ['value' => '', 'regex' => false],
            'order' => [['column' => 4, 'dir' => 'desc']],
            'columns' => collect(['title', 'category_name', 'status', 'published_at', 'updated_at', 'actions'])
                ->map(fn (string $c): array => ['data' => $c, 'name' => $c, 'searchable' => 'false', 'orderable' => $c === 'updated_at' ? 'true' : 'false', 'search' => ['value' => '', 'regex' => 'false']])
                ->all(),
        ]))->assertOk()->json('data'))->keyBy(fn (array $row): string => strip_tags((string) $row['title']) === 'Live postlive-post' ? 'live' : 'draft');

        $this->assertStringContainsString('href="'.route('admin.blogs.edit', $published).'"', $rows['live']['title']);
        $this->assertStringNotContainsString('target="_blank"', $rows['live']['title']);
        $this->assertStringContainsString('href="'.route('blog.show', ['slug' => 'live-post']).'" target="_blank"', $rows['live']['actions']);
        $this->assertStringContainsString('View live', $rows['live']['actions']);

        $this->assertStringContainsString('href="'.route('admin.blogs.edit', $draft).'"', $rows['draft']['title']);
        $this->assertStringNotContainsString('View live', $rows['draft']['actions']);
    }

    private function blog(User $user, BlogCategory $category, string $slug, string $status): Blog
    {
        return Blog::query()->forceCreate([
            'blog_category_id' => $category->id,
            'created_by_id' => $user->id,
            'slug' => $slug,
            'title' => ucfirst(str_replace('-', ' ', $slug)),
            'short_description' => 'Excerpt.',
            'content' => '<p>Body.</p>',
            'status' => $status,
            'published_at' => $status === Blog::STATUS_PUBLISHED ? now()->subDay() : null,
        ]);
    }
}
