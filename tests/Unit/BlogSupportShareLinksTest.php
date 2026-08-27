<?php

namespace Tests\Unit;

use App\Support\Frontend\BlogSupport;
use Tests\TestCase;

class BlogSupportShareLinksTest extends TestCase
{
    public function test_share_links_include_linkedin_facebook_x_and_whatsapp(): void
    {
        $links = BlogSupport::shareLinks(
            'https://example.test/blog/ai-agents',
            'How to Roll Out AI Agents'
        );

        $labels = array_column($links, 'label');
        $hrefs = array_column($links, 'href');

        $this->assertContains('Share on LinkedIn', $labels);
        $this->assertContains('Share on Facebook', $labels);
        $this->assertContains('Share on X', $labels);
        $this->assertContains('Share on WhatsApp', $labels);
        $this->assertTrue(str_contains(implode(' ', $hrefs), 'linkedin.com'));
        $this->assertTrue(str_contains(implode(' ', $hrefs), 'facebook.com'));
        $this->assertTrue(str_contains(implode(' ', $hrefs), 'twitter.com/intent/tweet'));
        $this->assertTrue(str_contains(implode(' ', $hrefs), 'ai-agents'));
    }

    public function test_normalize_visual_html_moves_chart_labels_out_of_bars(): void
    {
        $html = BlogSupport::normalizeVisualHtml(
            '<figure class="blog-chart"><div class="blog-chart__bar blog-chart__bar--high">Assessment</div><div class="blog-chart__bar blog-chart__bar--low">Monitoring</div></figure>'
        );

        $this->assertStringContainsString('class="blog-chart__row"', $html);
        $this->assertStringContainsString('class="blog-chart__label"', $html);
        $this->assertStringContainsString('Assessment', $html);
        $this->assertStringContainsString('Monitoring', $html);
        $this->assertStringContainsString('blog-chart__bar--high', $html);
        $this->assertDoesNotMatchRegularExpression(
            '/class="[^"]*\bblog-chart__bar\b[^"]*"[^>]*>\s*Assessment/i',
            $html
        );
    }

    public function test_normalize_visual_html_removes_empty_stat_and_insight_boxes(): void
    {
        $html = BlogSupport::normalizeVisualHtml(
            '<div class="blog-stats"><div class="blog-stat"><p class="blog-stat__value">One workflow</p><p class="blog-stat__label">Shared intake.</p></div><div class="blog-stat"><p class="blog-stat__value"></p><p class="blog-stat__label"></p></div></div><aside class="blog-insight"><p></p></aside>'
        );

        $this->assertStringContainsString('One workflow', $html);
        $this->assertSame(1, substr_count($html, 'class="blog-stat"'));
        $this->assertStringNotContainsString('blog-insight', $html);
    }
}
