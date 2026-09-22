<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogFeaturedImagePlacementTest extends TestCase
{
    use RefreshDatabase;

    protected function createSampleBlog(array $attributes = []): Blog
    {
        $author = User::factory()->create();

        $category = BlogCategory::query()->firstOrCreate(
            ['slug' => 'artificial-intelligence'],
            ['name' => 'Artificial Intelligence', 'sort_order' => 1]
        );

        return Blog::query()->create(array_merge([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'test-featured-image-placement-'.uniqid(),
            'title' => 'Test Featured Image Placement',
            'short_description' => 'A short summary for testing.',
            'content' => '<p>Paragraph 1 lead content.</p><p>Paragraph 2 follow-up content.</p><p>Paragraph 3 conclusion content.</p>',
            'featured_image' => 'blogs/sample-featured.webp',
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
        ], $attributes));
    }

    public function test_default_placement_renders_after_first_paragraph(): void
    {
        $blog = $this->createSampleBlog([
            'featured_image_position' => 'after_first_p',
        ]);

        $response = $this->get(route('blog.show', ['slug' => $blog->slug]));

        $response->assertOk();
        $html = $response->getContent();

        $this->assertStringContainsString('single-blog-main__image--inline', $html);

        $posP1 = strpos($html, 'Paragraph 1 lead content.');
        $posImage = strpos($html, 'single-blog-main__image--inline');
        $posP2 = strpos($html, 'Paragraph 2 follow-up content.');

        $this->assertNotFalse($posP1);
        $this->assertNotFalse($posImage);
        $this->assertNotFalse($posP2);

        $this->assertTrue($posP1 < $posImage, 'Featured image should appear after paragraph 1');
        $this->assertTrue($posImage < $posP2, 'Featured image should appear before paragraph 2');
    }

    public function test_top_placement_renders_before_first_paragraph(): void
    {
        $blog = $this->createSampleBlog([
            'featured_image_position' => 'top',
        ]);

        $response = $this->get(route('blog.show', ['slug' => $blog->slug]));

        $response->assertOk();
        $html = $response->getContent();

        $posP1 = strpos($html, 'Paragraph 1 lead content.');
        $posImage = strpos($html, 'single-blog-main__image--inline');

        $this->assertNotFalse($posP1);
        $this->assertNotFalse($posImage);

        $this->assertTrue($posImage < $posP1, 'Featured image should appear before paragraph 1 when position is top');
    }

    public function test_bottom_placement_renders_after_all_paragraphs(): void
    {
        $blog = $this->createSampleBlog([
            'featured_image_position' => 'bottom',
        ]);

        $response = $this->get(route('blog.show', ['slug' => $blog->slug]));

        $response->assertOk();
        $html = $response->getContent();

        $posP3 = strpos($html, 'Paragraph 3 conclusion content.');
        $posImage = strpos($html, 'single-blog-main__image--inline');

        $this->assertNotFalse($posP3);
        $this->assertNotFalse($posImage);

        $this->assertTrue($posP3 < $posImage, 'Featured image should appear after paragraph 3 when position is bottom');
    }

    public function test_hide_placement_omits_image_from_body_but_keeps_on_cards(): void
    {
        $blog = $this->createSampleBlog([
            'featured_image_position' => 'hide',
        ]);

        $response = $this->get(route('blog.show', ['slug' => $blog->slug]));

        $response->assertOk();
        $response->assertDontSee('single-blog-main__image--inline', false);

        // Verify it still appears on listing card
        $indexResponse = $this->get(route('blogs'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('sample-featured', false);
    }

    public function test_manual_placeholder_in_content_is_replaced_at_exact_position(): void
    {
        $contentWithPlaceholder = '<p>Section A start.</p>'
            .'<figure class="single-blog-main__image single-blog-main__image--inline" data-featured-image="true">'
            .'<div class="blog-featured-image-box"><p class="blog-featured-image-box__title">Post Featured Image</p></div>'
            .'</figure>'
            .'<p>Section B end.</p>';

        $blog = $this->createSampleBlog([
            'content' => $contentWithPlaceholder,
            'featured_image_position' => 'manual',
        ]);

        $response = $this->get(route('blog.show', ['slug' => $blog->slug]));

        $response->assertOk();
        $html = $response->getContent();

        $posA = strpos($html, 'Section A start.');
        $posImage = strpos($html, 'single-blog-main__image--inline');
        $posB = strpos($html, 'Section B end.');

        $this->assertNotFalse($posA);
        $this->assertNotFalse($posImage);
        $this->assertNotFalse($posB);

        $this->assertTrue($posA < $posImage && $posImage < $posB, 'Featured image should replace placeholder between Section A and Section B');
        $this->assertStringNotContainsString('Post Featured Image', $html);
    }

    public function test_complex_nested_featured_image_placeholder_with_preview_is_completely_replaced(): void
    {
        $complexPlaceholder = '<p>Intro paragraph.</p>'
            .'<p><figure class="single-blog-main__image single-blog-main__image--inline" data-featured-image="true" contenteditable="false">'
            .'<div class="blog-featured-image-box">'
            .'<div style="margin-bottom:12px"><img src="https://127.0.0.1:8000/storage/blogs/preview.jpg" alt="Featured image preview"></div>'
            .'<span class="blog-featured-image-box__badge">FEATURED IMAGE</span>'
            .'<p class="blog-featured-image-box__title">Post Featured Image</p>'
            .'<p class="blog-featured-image-box__hint">The featured image set in the sidebar will appear here on the published page.</p>'
            .'</div>'
            .'</figure></p>'
            .'<p>Conclusion paragraph.</p>';

        $blog = $this->createSampleBlog([
            'content' => $complexPlaceholder,
            'featured_image_position' => 'manual',
        ]);

        $response = $this->get(route('blog.show', ['slug' => $blog->slug]));

        $response->assertOk();
        $html = $response->getContent();

        $this->assertStringContainsString('single-blog-main__image--inline', $html);
        $this->assertStringNotContainsString('FEATURED IMAGE</span>', $html);
        $this->assertStringNotContainsString('Post Featured Image', $html);
        $this->assertStringNotContainsString('The featured image set in the sidebar will appear here on the published page.', $html);
    }

    public function test_shortcode_placeholder_in_content_is_replaced(): void
    {
        $contentWithShortcode = '<p>Intro paragraph.</p><p>[featured_image]</p><p>Outro paragraph.</p>';

        $blog = $this->createSampleBlog([
            'content' => $contentWithShortcode,
            'featured_image_position' => 'manual',
        ]);

        $response = $this->get(route('blog.show', ['slug' => $blog->slug]));

        $response->assertOk();
        $html = $response->getContent();

        $this->assertStringNotContainsString('[featured_image]', $html);
        $this->assertStringContainsString('single-blog-main__image--inline', $html);
    }

    public function test_admin_blog_store_and_update_persists_featured_image_position(): void
    {
        (new RolesAndPermissionsSeeder)->run();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $category = BlogCategory::query()->firstOrCreate(
            ['slug' => 'artificial-intelligence'],
            ['name' => 'Artificial Intelligence', 'sort_order' => 1]
        );

        $blog = $this->createSampleBlog([
            'featured_image_position' => 'after_first_p',
        ]);

        $response = $this->put(route('admin.blogs.update', $blog), [
            'title' => $blog->title,
            'slug' => $blog->slug,
            'short_description' => $blog->short_description,
            'content' => $blog->content,
            'status' => 'published',
            'blog_category_id' => $category->id,
            'featured_image_position' => 'top',
        ]);

        $response->assertSessionHasNoErrors();
        $blog->refresh();

        $this->assertSame('top', $blog->featured_image_position);
    }

    public function test_admin_blog_edit_page_renders_featured_image_controls(): void
    {
        (new RolesAndPermissionsSeeder)->run();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $blog = $this->createSampleBlog([
            'featured_image_position' => 'manual',
        ]);

        $response = $this->get(route('admin.blogs.edit', $blog));

        $response->assertOk();
        $response->assertSee('data-blog-block="insertfeaturedimage"', false);
        $response->assertSee('id="blog-featured-image-position"', false);
        $response->assertSee('value="manual" selected', false);
        $response->assertSee('Insert featured image into editor', false);
    }
}
