<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Services\BlogSeoService;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogArticleSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_single_blog_emits_article_meta_and_blog_posting_schema(): void
    {
        $author = User::factory()->create(['name' => 'Aakash Choudhary']);
        $category = BlogCategory::query()->create([
            'name' => 'CRM',
            'slug' => 'crm',
            'sort_order' => 1,
        ]);

        $blog = Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'replace-hubspot-with-custom-crm-tco',
            'title' => 'Replace HubSpot With a Custom CRM',
            'short_description' => 'A three-year cost comparison.',
            'content' => '<p>HubSpot seat costs add up.</p>',
            'featured_image' => 'blogs/replace-hubspot-with-custom-crm-tco.webp',
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
            'meta_title' => 'Replace HubSpot With a Custom CRM: 3-Year TCO | Suave Creators',
            'meta_description' => 'HubSpot per-seat costs versus a custom CRM over three years.',
            'og_title' => 'HubSpot vs Custom CRM: The Real 3-Year Cost',
            'og_description' => 'Three seat scenarios and when keeping HubSpot is the smarter call.',
            'faqs' => [
                [
                    'question' => 'Is a custom CRM cheaper than HubSpot?',
                    'answer' => 'It depends on seat count and tier.',
                ],
            ],
        ]);

        app(BlogSeoService::class)->sync($blog, [
            'tags' => 'HubSpot, Custom CRM',
            'keywords' => "replace HubSpot with custom CRM\nHubSpot alternative",
            'about' => [
                ['name' => 'Customer relationship management', 'same_as' => 'https://en.wikipedia.org/wiki/Customer_relationship_management'],
            ],
            'mentions' => [
                ['type' => 'Organization', 'name' => 'HubSpot', 'url' => '', 'same_as' => 'https://en.wikipedia.org/wiki/HubSpot'],
                ['type' => 'Service', 'name' => 'Custom CRM development', 'url' => route('service.show', ['slug' => 'custom-crm-development']), 'same_as' => ''],
            ],
        ]);

        $response = $this->get(route('blog.show', ['slug' => $blog->slug]));

        $response->assertOk();
        $response->assertSee('<meta property="og:type" content="article">', false);
        $response->assertSee('<meta name="author" content="Aakash Choudhary">', false);
        $response->assertSee('property="og:image"', false);
        $response->assertSee('/storage/blogs/replace-hubspot-with-custom-crm-tco.webp', false);
        $response->assertSee('content="1200"', false);
        $response->assertSee('content="630"', false);
        $response->assertSee('<meta property="og:image:alt" content="Replace HubSpot With a Custom CRM">', false);
        $response->assertSee('<meta name="twitter:image:alt" content="Replace HubSpot With a Custom CRM">', false);
        $response->assertSee('<meta property="article:author" content="https://www.linkedin.com/company/suave-creators/">', false);
        $response->assertSee('<meta property="article:section" content="CRM">', false);
        $response->assertSee('<meta property="article:tag" content="HubSpot">', false);
        $response->assertSee('<meta property="article:tag" content="Custom CRM">', false);
        $response->assertSee('<meta property="article:published_time"', false);
        $response->assertSee('<meta property="article:modified_time"', false);
        $response->assertSee('"@type":"BlogPosting"', false);
        $response->assertSee('"headline":"Replace HubSpot With a Custom CRM"', false);
        $response->assertSee('jobTitle":"Founder \u0026 Solution Architect"', false);
        $response->assertSee('#author-aakash-choudhary', false);
        $response->assertSee('"articleSection":"CRM"', false);
        $response->assertSee('"@type":"FAQPage"', false);
        $response->assertSee('Is a custom CRM cheaper than HubSpot?', false);
        $response->assertSee('"name":"Blog"', false);
        $response->assertSee(route('blogs'), false);
        $response->assertSee('Customer relationship management', false);
        $response->assertSee('Custom CRM development', false);
    }

    public function test_blog_edit_preview_schema_uses_the_saved_post(): void
    {
        (new RolesAndPermissionsSeeder)->run();

        $editor = User::factory()->create();
        $editor->assignRole('admin');
        $author = User::factory()->create(['name' => 'Aakash Choudhary']);
        $category = BlogCategory::query()->create([
            'name' => 'CRM',
            'slug' => 'crm',
            'sort_order' => 1,
        ]);

        $blog = Blog::query()->create([
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'replace-hubspot-with-custom-crm-tco',
            'title' => 'Replace HubSpot With a Custom CRM',
            'short_description' => 'Saved summary.',
            'content' => '<p>Saved body.</p>',
            'featured_image' => 'blogs/replace-hubspot.webp',
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
            'meta_title' => 'Replace HubSpot With a Custom CRM: 3-Year TCO',
            'meta_description' => 'HubSpot per-seat costs versus a custom CRM over three years.',
            'og_title' => 'HubSpot vs Custom CRM: The Real 3-Year Cost',
            'og_description' => 'Three seat scenarios.',
            'faqs' => [
                ['question' => 'Is a custom CRM cheaper than HubSpot?', 'answer' => 'It depends on seat count.'],
            ],
        ]);

        app(BlogSeoService::class)->sync($blog, [
            'tags' => 'HubSpot, Custom CRM',
            'keywords' => 'replace HubSpot with custom CRM',
            'about' => [
                ['name' => 'Customer relationship management', 'same_as' => 'https://en.wikipedia.org/wiki/Customer_relationship_management'],
            ],
            'mentions' => [
                ['type' => 'Organization', 'name' => 'HubSpot', 'url' => '', 'same_as' => 'https://en.wikipedia.org/wiki/HubSpot'],
            ],
        ]);

        $response = $this->actingAs($editor)->getJson(route('admin.blogs.preview-schema', $blog).'?title=Unsaved+draft+title');

        $response->assertOk();
        $html = $response->json('html');
        $this->assertIsString($html);
        $this->assertStringContainsString('<title>Replace HubSpot With a Custom CRM: 3-Year TCO</title>', $html);
        $this->assertStringContainsString('<meta name="description" content="HubSpot per-seat costs versus a custom CRM over three years.">', $html);
        $this->assertStringContainsString('<meta property="og:type" content="article">', $html);
        $this->assertStringContainsString('<meta property="article:tag" content="HubSpot">', $html);
        $this->assertStringContainsString('<script type="application/ld+json">', $html);
        $this->assertStringNotContainsString('Unsaved draft title', $html);
        $response->assertJsonPath('schema.@graph.0.@type', 'Organization');
        $schema = json_encode($response->json('schema'));
        $this->assertIsString($schema);
        $this->assertStringContainsString('BlogPosting', $schema);
        $this->assertStringContainsString('FAQPage', $schema);
    }
}
