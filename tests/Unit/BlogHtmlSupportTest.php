<?php

namespace Tests\Unit;

use App\Support\Blogs\BlogHtmlSupport;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogHtmlSupportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_sanitize_content_extracts_base64_image_to_webp(): void
    {
        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==',
            true
        );
        $this->assertNotFalse($png);

        $html = '<p>Intro</p><img src="data:image/png;base64,'.base64_encode($png).'" alt=""><p></p>';

        $result = BlogHtmlSupport::sanitizeContent($html, 'sample-post', 'Sample Post');

        $this->assertSame(1, $result['images_written']);
        $this->assertSame(1, $result['alts_updated']);
        $this->assertGreaterThan(0, $result['empty_tags_removed']);
        $this->assertStringNotContainsString('data:image', $result['content']);
        $this->assertMatchesRegularExpression('#src="/storage/blogs/content/sample-post-1\.webp"#', $result['content']);
        $this->assertStringContainsString('alt="Sample Post"', $result['content']);
        $this->assertStringContainsString('loading="lazy"', $result['content']);
        $this->assertStringContainsString('width="1"', $result['content']);
        $this->assertStringContainsString('height="1"', $result['content']);
        Storage::disk('public')->assertExists('blogs/content/sample-post-1.webp');
    }

    public function test_sanitize_content_extracts_oversized_inline_svg(): void
    {
        $svg = '<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 10 10">'.str_repeat('<rect width="1" height="1"/>', 600).'</svg>';

        $result = BlogHtmlSupport::sanitizeContent($svg, 'svg-post', 'SVG Post');

        $this->assertSame(1, $result['images_written']);
        $this->assertStringNotContainsString('<svg', $result['content']);
        $this->assertMatchesRegularExpression('#src="/storage/blogs/content/svg-post-1\.svg"#', $result['content']);
        Storage::disk('public')->assertExists('blogs/content/svg-post-1.svg');
    }

    public function test_sanitize_content_replaces_huge_data_uri_src_instead_of_duplicating_it(): void
    {
        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==',
            true
        );
        $this->assertNotFalse($png);
        $html = '<img loading="lazy" src="data:image/png;base64,'.base64_encode($png).'" src="/storage/stale.webp">';

        $result = BlogHtmlSupport::sanitizeContent($html, 'huge-src', 'Huge Src');

        $this->assertSame(1, substr_count($result['content'], 'src='));
        $this->assertStringNotContainsString('data:image', $result['content']);
        $this->assertStringNotContainsString('stale.webp', $result['content']);
        $this->assertMatchesRegularExpression('#src="/storage/blogs/content/huge-src-1\.webp"#', $result['content']);
    }

    public function test_decorate_content_images_adds_lazy_and_alt(): void
    {
        $html = '<img src="/storage/blogs/content/sample-post-1.webp">';

        $out = BlogHtmlSupport::decorateContentImages($html, 'Fallback alt');

        $this->assertStringContainsString('alt="Fallback alt"', $out);
        $this->assertStringContainsString('title="Fallback alt"', $out);
        $this->assertStringContainsString('loading="lazy"', $out);
        $this->assertStringContainsString('decoding="async"', $out);
    }

    public function test_wrap_bare_tables_adds_scroll_wrapper_once(): void
    {
        $html = '<p>Lead</p><table><thead><tr><th>A</th><th>B</th></tr></thead><tbody><tr><td>1</td><td>2</td></tr></tbody></table>'
            .'<div class="blog-table-wrap"><table><thead><tr><th>Kept</th></tr></thead><tbody><tr><td>Yes</td></tr></tbody></table></div>';

        $out = BlogHtmlSupport::wrapBareTables($html);

        $this->assertSame(2, substr_count($out, 'class="blog-table-wrap"'));
        $this->assertStringNotContainsString('<div class="blog-table-wrap"><div class="blog-table-wrap">', $out);
        $this->assertStringContainsString('<div class="blog-table-wrap"><table>', $out);
    }

    public function test_normalize_article_headings_promotes_h3_and_unwraps_nested_blocks(): void
    {
        $html = '<p><span style="font-size: 24px;"><b>Beyond Chatbots: The Architecture of Multi-Agent AI Systems in B2B Workflows</b></span></p>'
            .'<h3>The Structural Failure Points of Single-Prompt AI</h3>'
            .'<h4>1. Context Window Dilution and Instruction Degradation</h4>'
            .'<h4 id="the-legacy-manual-approach"><span>'
            .'<h3>Case in Point: Autonomous B2B Logistics</h3>'
            .'<p>To see the operational impact of multi-agent state graphs, consider a supply chain enterprise.</p>'
            .'</span></h4>'
            .'<p style="font-size: 18px; font-weight: 700;">The Legacy Manual Approach</p>'
            .'<p><span style="font-size: 24px; font-weight: 700;">Phased Enterprise Implementation Roadmap</span></p>'
            .'<p><span style="font-weight: 700;">Python:</span></p>';

        $out = BlogHtmlSupport::normalizeArticleHeadings(
            $html,
            'Beyond Chatbots: How Multi-Agent AI Systems Are Automating B2B Workflows in 2026'
        );

        $this->assertStringNotContainsString('The Architecture of Multi-Agent AI Systems', $out);
        $this->assertSame(0, preg_match_all('/<h4\b/i', $out));
        $this->assertGreaterThanOrEqual(3, preg_match_all('/<h2\b/i', $out));
        $this->assertStringContainsString('<h2>The Structural Failure Points of Single-Prompt AI</h2>', $out);
        $this->assertStringContainsString('<h3>1. Context Window Dilution and Instruction Degradation</h3>', $out);
        $this->assertStringContainsString('<h2', $out);
        $this->assertStringContainsString('Case in Point: Autonomous B2B Logistics', $out);
        $this->assertStringContainsString('To see the operational impact', $out);
        $this->assertDoesNotMatchRegularExpression('/<h[1-6][^>]*>[^<]*To see the operational impact/i', $out);
        $this->assertMatchesRegularExpression('/<h3[^>]*>The Legacy Manual Approach<\/h3>|<h3>.*The Legacy Manual Approach.*<\/h3>/is', $out);
        $this->assertMatchesRegularExpression('/<h2>.*Phased Enterprise Implementation Roadmap.*<\/h2>/is', $out);
        $this->assertStringContainsString('<p><span style="font-weight: 700;">Python:</span></p>', $out);
    }

    public function test_normalize_article_headings_keeps_existing_h2_outline(): void
    {
        $html = '<h2>Keep This Outline</h2><h3>Child Topic</h3>';

        $out = BlogHtmlSupport::normalizeArticleHeadings($html, 'A Different Title Altogether');

        $this->assertStringContainsString('<h2>Keep This Outline</h2>', $out);
        $this->assertStringContainsString('<h3>Child Topic</h3>', $out);
    }
}
