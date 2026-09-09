<?php

namespace App\Support\Blogs;

use App\Models\Blog;
use App\Support\Frontend\SuaveAgentKnowledge;
use Illuminate\Support\Str;

/**
 * Suggest internal marketing links (services, industries, related blogs)
 * for AI drafts and the admin edit form.
 */
class BlogInternalLinks
{
    /**
     * Full catalog of linkable destinations.
     *
     * @return list<array{type: string, title: string, url: string, summary: string, tokens: list<string>}>
     */
    public static function catalog(?int $excludeBlogId = null): array
    {
        $items = [];

        foreach (SuaveAgentKnowledge::servicesCatalog() as $service) {
            $url = trim((string) ($service['url'] ?? ''));
            $title = trim((string) ($service['title'] ?? ''));
            if ($url === '' || $title === '') {
                continue;
            }

            $summary = trim((string) ($service['summary'] ?? ''));
            $items[] = self::entry('service', $title, $url, $summary);
        }

        foreach (SuaveAgentKnowledge::industriesCatalog() as $industry) {
            $url = trim((string) ($industry['url'] ?? ''));
            $title = trim((string) ($industry['title'] ?? ''));
            if ($url === '' || $title === '') {
                continue;
            }

            $summary = trim((string) ($industry['summary'] ?? ''));
            $items[] = self::entry('industry', $title, $url, $summary);
        }

        $blogQuery = Blog::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(40);

        if ($excludeBlogId !== null) {
            $blogQuery->where('id', '!=', $excludeBlogId);
        }

        foreach ($blogQuery->get(['id', 'title', 'slug', 'short_description']) as $blog) {
            $title = trim((string) $blog->title);
            $slug = trim((string) $blog->slug);
            if ($title === '' || $slug === '') {
                continue;
            }

            $items[] = self::entry(
                'blog',
                $title,
                route('blog.show', $slug),
                trim((string) $blog->short_description)
            );
        }

        // Hub pages as light fallbacks.
        $items[] = self::entry('hub', 'Our services', route('services'), 'Custom software, web, CRM, ecommerce, UI/UX, and AI solutions.');
        $items[] = self::entry('hub', 'Industries we serve', route('industries'), 'Healthcare, logistics, retail, education, startups, and more.');

        return $items;
    }

    /**
     * Rank 2–3 internal links that best match the draft topic/content.
     *
     * @return list<array{type: string, title: string, url: string, summary: string, score: int}>
     */
    public static function suggest(
        string $title,
        string $content = '',
        ?string $topic = null,
        ?int $excludeBlogId = null,
        int $limit = 3,
    ): array {
        $limit = max(2, min(3, $limit));
        $haystack = self::tokenize(implode(' ', array_filter([
            $title,
            $topic ?? '',
            Str::limit(html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5, 'UTF-8'), 1200, ''),
        ])));

        if ($haystack === []) {
            $haystack = self::tokenize($title.' '.$topic);
        }

        $scored = [];
        foreach (self::catalog($excludeBlogId) as $item) {
            $score = self::score($haystack, $item['tokens']);
            if ($score <= 0 && ! in_array($item['type'], ['hub'], true)) {
                // Keep a small baseline for services/industries so suggestions never go empty.
                if (in_array($item['type'], ['service', 'industry'], true)) {
                    $score = 1;
                } else {
                    continue;
                }
            }

            // Prefer a mix: boost services/industries slightly over related blogs when tied.
            if ($item['type'] === 'service') {
                $score += 2;
            } elseif ($item['type'] === 'industry') {
                $score += 2;
            } elseif ($item['type'] === 'hub') {
                $score += 0;
            }

            $scored[] = [
                'type' => $item['type'],
                'title' => $item['title'],
                'url' => $item['url'],
                'summary' => $item['summary'],
                'score' => $score,
            ];
        }

        usort($scored, static function (array $a, array $b): int {
            return $b['score'] <=> $a['score'] ?: strcmp($a['title'], $b['title']);
        });

        // Prefer diversity across types when possible.
        $picked = [];
        $seenTypes = [];
        foreach ($scored as $row) {
            if (count($picked) >= $limit) {
                break;
            }
            if (isset($seenTypes[$row['type']]) && count($seenTypes) < $limit) {
                continue;
            }
            $picked[] = $row;
            $seenTypes[$row['type']] = true;
        }

        if (count($picked) < $limit) {
            foreach ($scored as $row) {
                if (count($picked) >= $limit) {
                    break;
                }
                $already = false;
                foreach ($picked as $existing) {
                    if ($existing['url'] === $row['url']) {
                        $already = true;
                        break;
                    }
                }
                if (! $already) {
                    $picked[] = $row;
                }
            }
        }

        return array_values($picked);
    }

    /**
     * Prompt-friendly bullet list for the writer agent.
     *
     * @param  list<array{type: string, title: string, url: string, summary?: string}>  $links
     */
    public static function formatForPrompt(array $links): string
    {
        if ($links === []) {
            return '(no internal link candidates loaded)';
        }

        return collect($links)
            ->map(static function (array $link): string {
                $type = (string) ($link['type'] ?? 'page');
                $title = (string) ($link['title'] ?? '');
                $url = (string) ($link['url'] ?? '');
                $summary = trim((string) ($link['summary'] ?? ''));
                $extra = $summary !== '' ? " — {$summary}" : '';

                return "- [{$type}] {$title} → {$url}{$extra}";
            })
            ->implode("\n");
    }

    /**
     * @return array{type: string, title: string, url: string, summary: string, tokens: list<string>}
     */
    protected static function entry(string $type, string $title, string $url, string $summary): array
    {
        return [
            'type' => $type,
            'title' => $title,
            'url' => $url,
            'summary' => Str::limit($summary, 180, ''),
            'tokens' => self::tokenize($title.' '.$summary.' '.$type),
        ];
    }

    /**
     * @return list<string>
     */
    protected static function tokenize(string $text): array
    {
        $text = strtolower(trim($text));
        $text = (string) preg_replace('/[^a-z0-9\s]+/u', ' ', $text);
        $words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $stop = [
            'a' => true, 'an' => true, 'the' => true, 'and' => true, 'or' => true, 'for' => true,
            'to' => true, 'of' => true, 'in' => true, 'on' => true, 'with' => true, 'our' => true,
            'your' => true, 'you' => true, 'we' => true, 'is' => true, 'are' => true, 'from' => true,
            'that' => true, 'this' => true, 'into' => true, 'as' => true, 'by' => true, 'at' => true,
            'best' => true, 'more' => true, 'how' => true, 'why' => true, 'what' => true,
        ];

        $tokens = [];
        foreach ($words as $word) {
            if (isset($stop[$word]) || strlen($word) < 3) {
                continue;
            }
            $tokens[$word] = true;
        }

        return array_keys($tokens);
    }

    /**
     * @param  list<string>  $haystack
     * @param  list<string>  $needle
     */
    protected static function score(array $haystack, array $needle): int
    {
        if ($haystack === [] || $needle === []) {
            return 0;
        }

        $hay = array_fill_keys($haystack, true);
        $score = 0;
        foreach ($needle as $token) {
            if (isset($hay[$token])) {
                $score += strlen($token) >= 6 ? 3 : 2;
            }
        }

        return $score;
    }
}
