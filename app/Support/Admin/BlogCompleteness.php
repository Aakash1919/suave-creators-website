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
            ['key' => 'insight', 'label' => 'Insight callout', 'done' => str_contains($content, 'blog-insight')],
            ['key' => 'internal_links', 'label' => 'Internal links (2+)', 'done' => self::internalLinkCount($content) >= 2],
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

    /**
     * Count same-site anchors in the article body (services, industries, blogs, hubs).
     */
    public static function internalLinkCount(string $html): int
    {
        if ($html === '' || ! preg_match_all('/<a\b[^>]*href=(["\'])(.*?)\1[^>]*>/i', $html, $matches)) {
            return 0;
        }

        $count = 0;
        foreach ($matches[2] as $href) {
            $href = trim((string) $href);
            if ($href === '' || str_starts_with($href, '#') || str_starts_with($href, 'mailto:')) {
                continue;
            }
            if (preg_match('#^https?://#i', $href) === 1) {
                $host = parse_url($href, PHP_URL_HOST);
                $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);
                if (is_string($host) && is_string($appHost) && strcasecmp($host, $appHost) === 0) {
                    $count++;
                } elseif (is_string($host) && str_contains(strtolower($host), 'suavecreators')) {
                    $count++;
                }

                continue;
            }

            // Root-relative marketing paths.
            if (preg_match('#^/(services|industries|blogs?|blog)(/|$)#i', $href) === 1) {
                $count++;
            }
        }

        return $count;
    }
}
