<?php

namespace App\Support\Admin;

use App\Models\Blog;

class BlogCompleteness
{
    /** Words of body copy that count as an article, not a long-essay gate. */
    public const BODY_WORD_MINIMUM = 120;

    /**
     * Score how ready a blog is to match the public single-blog page.
     *
     * @return array{percent: int, done: int, total: int, items: list<array{key: string, label: string, done: bool}>}
     */
    public static function evaluate(Blog $blog): array
    {
        $content = (string) $blog->content;
        $plain = trim(html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $words = $plain === '' ? 0 : count(preg_split('/\s+/u', $plain, -1, PREG_SPLIT_NO_EMPTY) ?: []);

        $items = [
            ['key' => 'title', 'label' => 'Title', 'done' => mb_strlen(trim((string) $blog->title)) >= 8],
            ['key' => 'short_description', 'label' => 'Short description', 'done' => mb_strlen(trim((string) $blog->short_description)) >= 80],
            ['key' => 'content', 'label' => 'Article body', 'done' => $words >= self::BODY_WORD_MINIMUM],
            ['key' => 'category', 'label' => 'Category', 'done' => filled($blog->blog_category_id)],
            ['key' => 'featured_image', 'label' => 'Featured image', 'done' => filled($blog->featured_image)],
            ['key' => 'seo', 'label' => 'SEO meta', 'done' => trim((string) $blog->meta_title) !== '' && trim((string) $blog->meta_description) !== ''],
            ['key' => 'faqs', 'label' => 'FAQs (4+)', 'done' => self::filledFaqCount($blog->faqs) >= 4],
            ['key' => 'takeaways', 'label' => 'Key takeaways', 'done' => str_contains($content, 'blog-takeaways')],
            ['key' => 'table', 'label' => 'Comparison table', 'done' => str_contains($content, 'blog-table-wrap') || str_contains($content, '<table')],
            ['key' => 'chart', 'label' => 'Completion bars', 'done' => str_contains($content, 'blog-chart__row') && str_contains($content, 'blog-chart__value')],
            ['key' => 'stats', 'label' => 'Stat boxes', 'done' => str_contains($content, 'blog-stat__value')],
            ['key' => 'insight', 'label' => 'Insight callout', 'done' => str_contains($content, 'blog-insight')],
        ];

        $done = count(array_filter($items, static fn (array $item): bool => $item['done']));
        $total = count($items);

        return [
            'percent' => $total === 0 ? 0 : (int) round(($done / $total) * 100),
            'done' => $done,
            'total' => $total,
            'items' => $items,
        ];
    }

    /**
     * @param  mixed  $faqs
     */
    public static function filledFaqCount(mixed $faqs): int
    {
        if (! is_array($faqs)) {
            return 0;
        }

        $count = 0;

        foreach ($faqs as $faq) {
            if (! is_array($faq)) {
                continue;
            }

            if (trim((string) ($faq['question'] ?? '')) !== '' && trim((string) ($faq['answer'] ?? '')) !== '') {
                $count++;
            }
        }

        return $count;
    }
}
