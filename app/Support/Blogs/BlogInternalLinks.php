<?php

namespace App\Support\Blogs;

use App\Models\Blog;
use App\Support\Frontend\CaseStudySupport;
use App\Support\Frontend\SuaveAgentKnowledge;
use Illuminate\Support\Str;

/**
 * Suggest internal marketing links (services, industries, case studies, related blogs)
 * for AI drafts and legacy blog rewrites.
 */
class BlogInternalLinks
{
    /**
     * Legacy inbound paths that still 301 to a current page.
     *
     * @var array<string, string>
     */
    public const LEGACY_PATHS = [
        '/industries/healthcare' => '/industries/healthcare-software-development',
        '/industry' => '/industries',
        '/blog' => '/blogs',
        '/services/custom-crm-builder' => '/services/custom-crm-development',
        '/turbo-trans-case-study' => '/case-studies/turbo-trans-case-study',
        '/case-studies/cabvi-case-study' => '/case-studies/ai-product-matching-case-study',
    ];

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
                $extra = $summary !== '' ? ": {$summary}" : '';
                $words = (array) ($link['anchor_words'] ?? []);
                if ($words !== []) {
                    $extra .= ' (anchor text must include one of: '.implode(', ', array_slice($words, 0, 8)).')';
                }

                return "- [{$type}] {$title} → {$url}{$extra}";
            })
            ->implode("\n");
    }

    /**
     * Rank 4–7 relative-path site-page links for rewriting an existing post: best service,
     * matching industry / case study when they genuinely fit (never other blog posts),
     * and always the contact page for the closing CTA.
     *
     * @return list<array{type: string, title: string, url: string, summary: string, score: int, anchor_words?: list<string>}>
     */
    public static function suggestForRewrite(Blog $blog, int $limit = 6): array
    {
        $limit = max(4, min(7, $limit));
        $haystack = self::tokenize(implode(' ', [
            (string) $blog->title,
            (string) $blog->short_description,
            Str::limit(html_entity_decode(strip_tags((string) $blog->content), ENT_QUOTES | ENT_HTML5, 'UTF-8'), 3000, ''),
        ]));

        $byType = [];
        foreach (self::rewriteCatalog((int) $blog->id) as $item) {
            if ($item['type'] === 'contact') {
                continue;
            }

            $byType[$item['type']][] = [
                'type' => $item['type'],
                'title' => $item['title'],
                'url' => $item['url'],
                'summary' => $item['summary'],
                // Slug words (e.g. "logistics", "healthcare") name the page topic, so they outweigh generic overlap.
                'score' => self::score($haystack, $item['tokens'])
                    + 5 * count(array_intersect($item['key_tokens'] ?? [], $haystack)),
                'placements' => $item['placements'] ?? [],
            ];
        }

        foreach ($byType as $type => $rows) {
            usort($rows, static fn (array $a, array $b): int => $b['score'] <=> $a['score'] ?: strcmp($a['title'], $b['title']));
            $byType[$type] = $rows;
        }

        $picked = [];
        $take = static function (string $type, int $minScore, int $count) use (&$byType, &$picked): void {
            foreach ($byType[$type] ?? [] as $index => $row) {
                if ($count <= 0 || $row['score'] < $minScore) {
                    break;
                }
                $picked[] = $row;
                unset($byType[$type][$index]);
                $count--;
            }
        };

        // Always one service, even on a weak match, so every post links to a hub.
        $take('service', 0, 1);
        $take('industry', 15, 1);

        // Case studies only when their catalog placement matches the chosen service / industry.
        $placements = [];
        foreach ($picked as $row) {
            $placements[] = basename($row['url']);
        }
        $keywords = self::anchorKeywordMap();
        $weak = ['ai', 'b2b', 'suave', 'sales', 'crm', 'management', 'product'];
        $cases = [];
        foreach ($byType['case-study'] ?? [] as $row) {
            $matches = count(array_intersect($row['placements'] ?? [], $placements));
            $topical = count(array_intersect(array_diff($keywords[$row['url']] ?? [], $weak), $haystack));
            if ($matches > 0 && $topical >= 2) {
                $row['score'] += $matches * 6;
                $cases[] = $row;
            }
        }
        usort($cases, static fn (array $a, array $b): int => $b['score'] <=> $a['score']);
        $byType['case-study'] = $cases;
        $take('case-study', 0, 1);

        $take('service', 8, 1);

        $leftovers = array_merge($byType['industry'] ?? [], $byType['service'] ?? []);
        usort($leftovers, static fn (array $a, array $b): int => $b['score'] <=> $a['score']);
        foreach ($leftovers as $index => $row) {
            if (count($picked) >= $limit - 1 || $row['score'] < 4) {
                break;
            }
            $picked[] = $row;
            unset($leftovers[$index]);
        }

        // Rewrites need at least three site pages besides contact; top up with the best remaining pages.
        $minPages = max(1, (int) config('blogs.rewrite.min_links', 3));
        if (count($picked) < $minPages) {
            $fill = array_merge(array_values($leftovers), $byType['product'] ?? [], $byType['hub'] ?? []);
            usort($fill, static fn (array $a, array $b): int => $b['score'] <=> $a['score']);
            foreach ($fill as $row) {
                if (count($picked) >= $minPages) {
                    break;
                }
                $picked[] = $row;
            }
        }

        $picked = array_slice($picked, 0, $limit - 1);
        $picked[] = [
            'type' => 'contact',
            'title' => 'Contact Suave Creators',
            'url' => self::relativePath(route('contact-us')),
            'summary' => 'Book a consultation. Use for the closing CTA.',
            'score' => 0,
        ];

        return array_values(array_map(static function (array $row) use ($keywords): array {
            unset($row['placements']);
            if (($keywords[$row['url']] ?? []) !== []) {
                $row['anchor_words'] = $keywords[$row['url']];
            }

            return $row;
        }, $picked));
    }

    /**
     * Every internal path a rewritten post may link to.
     *
     * @return list<string>
     */
    public static function allowedPaths(): array
    {
        $paths = ['/'];

        foreach (self::rewriteCatalog() as $item) {
            $paths[] = $item['url'];
        }

        return array_values(array_unique($paths));
    }

    /**
     * Whether a relative path points at the blog listing or a blog post (rewrites link site pages only).
     */
    public static function isBlogPath(string $path): bool
    {
        return preg_match('#^/blogs?(?:/|$)#i', $path) === 1;
    }

    /**
     * Topic words per rewrite page path; a link's anchor text must contain one of them
     * so "custom CRM" links the CRM page and a vague phrase like "connecting your tools" does not.
     * Contact has no entry (any natural sentence may link it).
     *
     * @return array<string, list<string>>
     */
    public static function anchorKeywordMap(): array
    {
        $generic = [
            'services', 'service', 'solutions', 'solution', 'development', 'software', 'apps', 'platforms',
            'platform', 'custom', 'powered', 'aipowered', 'company', 'companies', 'study', 'studies', 'case',
            'systems', 'system', 'multi', 'app', 'creators', 'serve', 'complex', 'process', 'clear', 'makes', 'showing',
            'default', 'success', 'story', 'workspace', 'practices', 'whispers', 'scores', 'automated',
        ];
        $extra = [
            self::relativePath(route('case-studies')) => ['case', 'studies', 'study', 'projects', 'clients', 'portfolio'],
            self::relativePath(route('about-us')) => ['about', 'team', 'who', 'company', 'suave'],
        ];

        $map = [];
        foreach (self::rewriteCatalog() as $item) {
            if ($item['type'] === 'contact') {
                continue;
            }

            $words = array_diff(
                self::anchorTokens($item['title'].' '.str_replace('-', ' ', basename($item['url']))),
                $generic,
            );
            $map[$item['url']] = array_values(array_unique(array_merge($words, $extra[$item['url']] ?? [])));
        }

        return $map;
    }

    /**
     * Whether anchor text names the linked page's topic (shares a word or word stem with its keywords).
     *
     * @param  list<string>  $keywords
     */
    public static function anchorFits(string $anchor, array $keywords): bool
    {
        if ($keywords === []) {
            return true;
        }

        foreach (self::anchorTokens(html_entity_decode(strip_tags($anchor), ENT_QUOTES | ENT_HTML5, 'UTF-8')) as $word) {
            foreach ($keywords as $key) {
                if ($word === $key) {
                    return true;
                }
                if ((strlen($key) >= 3 && str_starts_with($word, $key)) || (strlen($word) >= 4 && str_starts_with($key, $word))) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Tokens with hyphenated words both joined and split ("e-commerce" → ecommerce, commerce).
     *
     * @return list<string>
     */
    protected static function anchorTokens(string $text): array
    {
        preg_match_all('/\b(?:ai|ui|ux)\b/i', $text, $short);

        return array_values(array_unique(array_merge(
            self::tokenize(str_replace('-', '', $text)),
            self::tokenize($text),
            array_map('strtolower', $short[0]),
        )));
    }

    /**
     * Normalize an internal href to a relative path on the current route map, or null for external URLs.
     */
    public static function normalizeInternalHref(string $href): ?string
    {
        $href = trim(html_entity_decode($href, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($href === '' || str_starts_with($href, '#') || str_starts_with($href, 'mailto:') || str_starts_with($href, 'tel:')) {
            return null;
        }

        if (preg_match('#^(?:https?:)?//([^/]+)#i', $href, $match) === 1) {
            $host = strtolower(preg_replace('/^www\./', '', $match[1]) ?? $match[1]);
            $appHost = strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST));
            $appHost = (string) preg_replace('/^www\./', '', $appHost);

            if ($host !== 'suavecreators.com' && $host !== $appHost) {
                return null;
            }
        } elseif (! str_starts_with($href, '/')) {
            return null;
        }

        $path = self::relativePath($href);
        $path = (string) preg_replace('#^/service/#', '/services/', $path);

        return self::LEGACY_PATHS[$path] ?? $path;
    }

    /**
     * Path (with query/fragment dropped) for an absolute or relative URL; no trailing slash except root.
     */
    public static function relativePath(string $url): string
    {
        $path = (string) (parse_url($url, PHP_URL_PATH) ?? '/');
        $path = '/'.trim($path, '/');

        return $path === '/' ? '/' : rtrim($path, '/');
    }

    /**
     * Services, industries, published case studies, product and hub pages as relative paths (no blog posts).
     * Case studies carry `placements` (their catalog service + industry slugs).
     *
     * @return list<array{type: string, title: string, url: string, summary: string, tokens: list<string>, key_tokens?: list<string>, placements?: list<string>}>
     */
    protected static function rewriteCatalog(?int $excludeBlogId = null): array
    {
        $items = [];

        foreach (self::catalog($excludeBlogId) as $item) {
            if ($item['type'] === 'blog') {
                continue;
            }

            $item['url'] = self::relativePath($item['url']);
            if (in_array($item['type'], ['service', 'industry'], true)) {
                $item['key_tokens'] = array_values(array_diff(
                    self::tokenize(str_replace('-', ' ', basename($item['url']))),
                    ['services', 'solutions', 'development', 'software', 'apps', 'platforms'],
                ));
            }
            $items[] = $item;
        }

        foreach (CaseStudySupport::cases() as $case) {
            $title = trim((string) ($case['title'] ?? ''));
            $url = trim((string) ($case['url'] ?? ''));
            if ($title === '' || $url === '') {
                continue;
            }

            $summary = trim(implode(' ', [
                (string) ($case['listing_subtitle'] ?? ''),
                (string) ($case['industry'] ?? ''),
                (string) ($case['short_description'] ?? ''),
            ]));
            $entry = self::entry('case-study', $title, self::relativePath($url), $summary);
            $entry['tokens'] = self::tokenize($title.' '.$summary);
            $entry['placements'] = array_values(array_merge(
                (array) ($case['service_slugs'] ?? []),
                (array) ($case['industry_slugs'] ?? []),
            ));
            $items[] = $entry;
        }

        // Activate later: $items[] = self::entry('product', 'The Suave App: AI-Powered Outreach CRM', self::relativePath(route('product')), 'Our AI outreach CRM product for B2B sales teams: prospecting, cold email automation, pipeline.');
        $items[] = self::entry('hub', 'Client case studies', self::relativePath(route('case-studies')), 'Real delivery stories and measured outcomes.');
        $items[] = self::entry('hub', 'About Suave Creators', self::relativePath(route('about-us')), 'Who we are and how we work with clients.');
        $items[] = self::entry('contact', 'Contact Suave Creators', self::relativePath(route('contact-us')), 'Book a consultation.');

        return $items;
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
