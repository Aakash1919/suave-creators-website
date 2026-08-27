<?php

namespace App\Support\Frontend;

use App\Models\Blog;
use App\Models\BlogCategory;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BlogSupport
{
    public const PER_PAGE = 9;

    public const TABLET_PER_PAGE = 10;

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public static function posts(?string $categorySlug = null): Collection
    {
        return self::publishedQuery($categorySlug)
            ->with(['category', 'createdBy'])
            ->orderByDesc('published_at')
            ->get()
            ->map(fn (Blog $blog): array => self::mapBlog($blog));
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function post(string $slug): ?array
    {
        $query = Blog::query()
            ->with(['category', 'createdBy'])
            ->where('slug', $slug);

        if (auth()->check()) {
            // Logged-in users may preview drafts on the single-blog page.
            $query->where(function ($q): void {
                $q->published()
                    ->orWhere('status', Blog::STATUS_DRAFT);
            });
        } else {
            $query->published();
        }

        $blog = $query->first();

        return $blog !== null ? self::mapBlog($blog, 'original') : null;
    }

    /**
     * @return int
     */
    public static function perPage(?int $requested = null): int
    {
        return $requested === self::TABLET_PER_PAGE
            ? self::TABLET_PER_PAGE
            : self::PER_PAGE;
    }

    /**
     * @return array<string, mixed>
     */
    public static function indexData(?string $categorySlug = null, int $page = 1, ?string $search = null, ?int $perPage = null): array
    {
        $category = null;
        $search = trim((string) $search);
        $perPage = self::perPage($perPage);

        if ($categorySlug !== null && $categorySlug !== '') {
            $category = BlogCategory::query()->where('slug', $categorySlug)->first();

            if ($category === null) {
                abort(404);
            }
        }

        /** @var LengthAwarePaginator<int, Blog> $paginator */
        $paginator = self::publishedQuery($category?->slug, $search !== '' ? $search : null)
            ->with(['category', 'createdBy'])
            ->orderByDesc('published_at')
            ->paginate($perPage, ['*'], 'page', max(1, $page))
            ->withQueryString();

        $posts = $paginator->getCollection()
            ->map(fn (Blog $blog): array => self::mapBlog($blog))
            ->values()
            ->all();

        $categories = self::categoryNavItems($category?->slug);

        return [
            'posts' => $posts,
            'paginator' => $paginator,
            'heroImages' => self::heroImages(),
            'categories' => $categories,
            'search' => $search,
            'activeCategory' => $category !== null ? [
                'name' => $category->name,
                'slug' => $category->slug,
            ] : null,
            'seoTitle' => $category !== null
                ? $category->name.' - Blog Insights | Suave Creators'
                : null,
            'seoDescription' => $category !== null
                ? 'Read Suave Creators articles in '.$category->name.' — practical insights on software, product, and digital growth.'
                : null,
        ];
    }

    /**
     * @return array<int, array{src: string, alt: string, size: string}>
     */
    public static function heroImages(): array
    {
        return [
            ['src' => asset('assets/blog/blogs-hero/01-team.jpg'), 'alt' => 'Suave Creators team workspace for software development blogs', 'size' => 'sm'],
            ['src' => asset('assets/blog/blogs-hero/02-laptop.jpg'), 'alt' => 'Laptop with code for web development insights blog', 'size' => 'md'],
            ['src' => asset('assets/blog/blogs-hero/03-creative.jpg'), 'alt' => 'Creative team collaboration for digital strategy blog articles', 'size' => 'lg'],
            ['src' => asset('assets/blog/blogs-hero/04-desk.jpg'), 'alt' => 'Modern desk setup for Suave Creators engineering insights', 'size' => 'md'],
            ['src' => asset('assets/blog/blogs-hero/05-notebook.jpg'), 'alt' => 'Notebook and workspace for software engineering blog posts', 'size' => 'sm'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function showData(string $slug): array
    {
        $post = self::post($slug);

        if ($post === null) {
            abort(404);
        }

        $allPosts = self::posts()->all();
        $categories = self::topCategories(5, $post['category_slug'] ?? null);

        $sliderPosts = [];

        foreach ($allPosts as $candidate) {
            if (($candidate['slug'] ?? '') === $slug) {
                continue;
            }

            $sliderPosts[] = $candidate;
        }

        if (count($sliderPosts) < 2) {
            $sliderPosts = $allPosts;
        }

        $sliderPosts = array_slice($sliderPosts, 0, 6);

        $articleContent = self::prepareArticleContent($post);

        $titleWords = preg_split('/\s+/', trim((string) ($post['title'] ?? '')), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $titleWordCount = count($titleWords);

        if ($titleWordCount <= 2) {
            $titleLead = '';
            $titleAccent = implode(' ', $titleWords);
        } else {
            $accentCount = (int) ceil(($titleWordCount + 1) / 2);
            $accentCount = max(2, min($accentCount, $titleWordCount - 2));
            $titleLead = implode(' ', array_slice($titleWords, 0, -$accentCount));
            $titleAccent = implode(' ', array_slice($titleWords, -$accentCount));
        }

        $seoTitle = trim((string) ($post['meta_title'] ?? ''));
        if ($seoTitle === '') {
            $seoTitle = Str::limit((string) ($post['title'] ?? 'Blog'), 60, '');
        }

        $seoDescription = trim((string) ($post['meta_description'] ?? ''));
        if ($seoDescription === '') {
            $seoDescription = Str::limit(
                (string) ($post['short_description'] ?? 'Suave Creators blog article.'),
                160,
                ''
            );
        }

        return [
            'post' => $post,
            'posts' => $allPosts,
            'categories' => $categories,
            'topPosts' => array_slice($allPosts, 0, 5),
            'sliderPosts' => $sliderPosts,
            'articleContent' => $articleContent,
            'shareLinks' => self::shareLinks(
                (string) ($post['url'] ?? ''),
                (string) ($post['title'] ?? '')
            ),
            'tags' => array_values(array_filter([
                $post['category'] ?? '',
                'Insights',
            ])),
            'titleLead' => $titleLead,
            'titleAccent' => $titleAccent,
            'faqs' => ! empty($post['faqs']) && is_array($post['faqs']) ? $post['faqs'] : [],
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
            'seoOgTitle' => trim((string) ($post['og_title'] ?? '')) ?: null,
            'seoOgDescription' => trim((string) ($post['og_description'] ?? '')) ?: null,
            'seoRobots' => ! empty($post['is_draft']) ? 'noindex, nofollow' : null,
            'isDraft' => ! empty($post['is_draft']),
        ];
    }

    /**
     * Social share destinations for a public blog URL.
     *
     * @return list<array{label: string, href: string, icon: string}>
     */
    public static function shareLinks(string $url, string $title): array
    {
        $encodedUrl = rawurlencode($url);
        $encodedTitle = rawurlencode($title);
        $encodedText = rawurlencode($title.' '.$url);

        return [
            [
                'label' => 'Share on LinkedIn',
                'href' => 'https://www.linkedin.com/sharing/share-offsite/?url='.$encodedUrl,
                'icon' => '<svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5C4.98 4.88 3.88 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.5 8.5h4V23h-4zM8.5 8.5h3.8v2h.05c.53-1 1.84-2.05 3.79-2.05 4.05 0 4.8 2.67 4.8 6.15V23h-4v-6.6c0-1.57-.03-3.6-2.2-3.6-2.2 0-2.54 1.72-2.54 3.48V23h-4z"/></svg>',
            ],
            [
                'label' => 'Share on Facebook',
                'href' => 'https://www.facebook.com/sharer/sharer.php?u='.$encodedUrl,
                'icon' => '<svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12.07C22 6.48 17.52 2 11.93 2S1.86 6.48 1.86 12.07c0 5.02 3.66 9.18 8.44 9.93v-7.02H7.9v-2.91h2.4V9.84c0-2.38 1.42-3.69 3.58-3.69 1.04 0 2.12.18 2.12.18v2.34h-1.2c-1.18 0-1.54.73-1.54 1.48v1.78h2.63l-.42 2.91h-2.21V22c4.78-.75 8.44-4.91 8.44-9.93z"/></svg>',
            ],
            [
                'label' => 'Share on X',
                'href' => 'https://twitter.com/intent/tweet?url='.$encodedUrl.'&text='.$encodedTitle,
                'icon' => '<svg xmlns="https://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 1.5h3.28l-7.17 8.2L24 22.5h-7.41l-5.8-7.58L4.2 22.5H.9l7.67-8.77L0 1.5h7.6l5.24 6.93zm-1.15 18.9h1.82L6.37 3.38H4.42z"/></svg>',
            ],
            [
                'label' => 'Share on WhatsApp',
                'href' => 'https://api.whatsapp.com/send?text='.$encodedText,
                'icon' => '<svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 3.5A11 11 0 0 0 2.1 17.4L1 23l5.7-1.1A11 11 0 0 0 20.5 3.5zm-8.5 17a9.1 9.1 0 0 1-4.64-1.27l-.33-.2-3.38.65.66-3.3-.21-.34A9.1 9.1 0 1 1 12 20.5zm5-6.82c-.27-.14-1.6-.79-1.85-.88s-.43-.14-.61.14-.7.88-.86 1.06-.32.2-.59.07a7.4 7.4 0 0 1-2.18-1.35 8.2 8.2 0 0 1-1.5-1.87c-.16-.27 0-.42.12-.55.13-.13.27-.32.41-.48s.18-.27.27-.45.05-.34-.02-.48-.61-1.47-.84-2.01c-.22-.53-.45-.46-.61-.47h-.52c-.18 0-.48.07-.73.34s-.96.94-.96 2.3.98 2.67 1.12 2.85 1.93 2.95 4.67 4.14c.65.28 1.16.45 1.56.58.65.21 1.25.18 1.72.11.52-.08 1.6-.65 1.83-1.28.22-.63.22-1.17.16-1.28s-.25-.18-.52-.32z"/></svg>',
            ],
        ];
    }

    /**
     * Latest posts shaped for articles/insights cards across the site.
     *
     * @return array<int, array{title: string, excerpt: string, image: string, alt: string, date: string, datetime: string, author: string, url: string}>
     */
    public static function articleCards(int $limit = 4): array
    {
        return self::posts()
            ->take($limit)
            ->map(static function (array $post): array {
                return [
                    'title' => (string) ($post['title'] ?? ''),
                    'excerpt' => (string) ($post['short_description'] ?? ''),
                    'image' => (string) ($post['image'] ?? ''),
                    'alt' => (string) ($post['title'] ?? 'Suave Creators blog article'),
                    'date' => (string) ($post['published_label'] ?? ''),
                    'datetime' => (string) ($post['published_date'] ?? ''),
                    'author' => (string) ($post['author_name'] ?? 'Suave Creators'),
                    'url' => (string) ($post['url'] ?? route('blogs')),
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder<Blog>
     */
    protected static function publishedQuery(?string $categorySlug = null, ?string $search = null)
    {
        $query = Blog::query()->published();

        if ($categorySlug !== null && $categorySlug !== '') {
            $query->whereHas('category', static function ($categoryQuery) use ($categorySlug): void {
                $categoryQuery->where('slug', $categorySlug);
            });
        }

        if ($search !== null && $search !== '') {
            $query->where('title', 'like', '%'.$search.'%');
        }

        return $query;
    }

    /**
     * @return array<int, array{name: string, slug: string, url: string, active: bool, count: int}>
     */
    public static function categoryNavItems(?string $activeSlug = null): array
    {
        return BlogCategory::query()
            ->whereHas('blogs', static function ($query): void {
                $query->published();
            })
            ->withCount(['blogs as published_blogs_count' => static function ($query): void {
                $query->published();
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(static function (BlogCategory $category) use ($activeSlug): array {
                return self::mapCategoryNavItem($category, $activeSlug);
            })
            ->values()
            ->all();
    }

    /**
     * Categories with the most published blogs (for single-blog sidebar).
     *
     * @return array<int, array{name: string, slug: string, url: string, active: bool, count: int}>
     */
    public static function topCategories(int $limit = 5, ?string $activeSlug = null): array
    {
        return BlogCategory::query()
            ->whereHas('blogs', static function ($query): void {
                $query->published();
            })
            ->withCount(['blogs as published_blogs_count' => static function ($query): void {
                $query->published();
            }])
            ->orderByDesc('published_blogs_count')
            ->orderBy('name')
            ->limit(max(1, $limit))
            ->get()
            ->map(static function (BlogCategory $category) use ($activeSlug): array {
                return self::mapCategoryNavItem($category, $activeSlug);
            })
            ->values()
            ->all();
    }

    /**
     * @return array{name: string, slug: string, url: string, active: bool, count: int}
     */
    protected static function mapCategoryNavItem(BlogCategory $category, ?string $activeSlug = null): array
    {
        return [
            'name' => (string) $category->name,
            'slug' => (string) $category->slug,
            'url' => route('blogs.category', ['slug' => $category->slug]),
            'active' => $activeSlug !== null && $activeSlug === $category->slug,
            'count' => (int) ($category->published_blogs_count ?? 0),
        ];
    }

    /**
     * @param  'original'|'medium'  $imageVariant
     * @return array<string, mixed>
     */
    protected static function mapBlog(Blog $blog, string $imageVariant = 'medium'): array
    {
        $publishedAt = $blog->published_at instanceof Carbon
            ? $blog->published_at
            : ($blog->published_at !== null ? Carbon::parse($blog->published_at) : null);

        $slug = (string) $blog->slug;
        $categoryName = (string) ($blog->category?->name ?? '');
        $categorySlug = (string) ($blog->category?->slug ?? '');

        $image = match ($imageVariant) {
            'original' => $blog->featuredImageUrl() ?? '',
            default => $blog->mediumThumbImageUrl() ?? '',
        };

        return [
            'id' => $blog->id,
            'slug' => $slug,
            'title' => (string) $blog->title,
            'status' => (string) $blog->status,
            'is_draft' => $blog->status === Blog::STATUS_DRAFT,
            'image' => $image,
            'short_description' => (string) ($blog->short_description ?? ''),
            'content' => self::normalizeStorageUrls((string) ($blog->content ?? '')),
            'author_name' => (string) ($blog->createdBy?->name ?? 'Suave Creators'),
            'category' => $categoryName,
            'category_slug' => $categorySlug,
            'category_url' => $categorySlug !== '' ? route('blogs.category', ['slug' => $categorySlug]) : route('blogs'),
            'published_date' => $publishedAt?->toDateString() ?? '',
            'published_label' => $publishedAt?->format('M j, Y') ?? ($blog->status === Blog::STATUS_DRAFT ? 'Draft' : ''),
            'updated_date' => $blog->updated_at?->toDateString() ?? '',
            'toc' => is_array($blog->toc) ? $blog->toc : [],
            'faqs' => is_array($blog->faqs) ? $blog->faqs : [],
            'meta_title' => (string) ($blog->meta_title ?? ''),
            'meta_description' => (string) ($blog->meta_description ?? ''),
            'og_title' => (string) ($blog->og_title ?? ''),
            'og_description' => (string) ($blog->og_description ?? ''),
            'route' => 'blog.show',
            'url' => $slug !== '' ? route('blog.show', ['slug' => $slug]) : '',
        ];
    }

    /**
     * @param  array<string, mixed>  $post
     */
    protected static function prepareArticleContent(array $post): string
    {
        $content = (string) ($post['content'] ?? '');
        $title = (string) ($post['title'] ?? 'Blog article');
        $image = (string) ($post['image'] ?? '');
        $pullQuote = trim((string) ($post['short_description'] ?? ''));

        $content = self::normalizeArticleMarkup($content, $title);

        $featureImageHtml = $image !== ''
            ? '<figure class="single-blog-main__image single-blog-main__image--inline">'
                .'<img src="'.e($image).'" alt="'.e($title).'" title="'.e($title).'" width="1200" height="640" loading="eager">'
                .'</figure>'
            : '';

        $hasStructuredCallout = (bool) preg_match(
            '/class="[^"]*\b(?:blog-insight|blog-takeaways)\b/i',
            $content
        );

        if ($pullQuote !== '' && ! $hasStructuredCallout && stripos($content, '<blockquote') === false) {
            $quoteHtml = '<blockquote><p>'.e($pullQuote).'</p></blockquote>';
            $closePos = strpos($content, '</p>');

            if ($closePos !== false) {
                return substr_replace($content, '</p>'.$quoteHtml.$featureImageHtml, $closePos, 4);
            }

            return $featureImageHtml.$content;
        }

        if (preg_match('/<\/blockquote>/i', $content)) {
            return (string) preg_replace('/<\/blockquote>/i', '</blockquote>'.$featureImageHtml, $content, 1);
        }

        $closePos = strpos($content, '</p>');

        if ($closePos !== false) {
            return substr_replace($content, '</p>'.$featureImageHtml, $closePos, 4);
        }

        return $featureImageHtml.$content;
    }

    /**
     * Keep a single page H1 and ensure article images expose alt text for SEO audits.
     */
    protected static function normalizeArticleMarkup(string $content, string $title): string
    {
        if ($content === '') {
            return $content;
        }

        $content = (string) preg_replace('/<h1(\b[^>]*)>/i', '<h2$1>', $content);
        $content = (string) preg_replace('/<\/h1>/i', '</h2>', $content);
        $content = self::normalizeVisualHtml($content);

        $fallbackAlt = $title !== '' ? $title : 'Suave Creators blog article';

        return (string) preg_replace_callback('/<img\b([^>]*)>/i', static function (array $matches) use ($fallbackAlt): string {
            $attrs = $matches[1];

            if (preg_match('/\balt\s*=/i', $attrs)) {
                return $matches[0];
            }

            return '<img alt="'.e($fallbackAlt).'"'.$attrs.'>';
        }, $content);
    }

    /**
     * Rewrite AI chart bars into labelled rows and drop empty stat / insight boxes.
     */
    public static function normalizeVisualHtml(string $html): string
    {
        if ($html === '' || ! preg_match('/\bblog-(?:chart|stat|insight|stats)\b/i', $html)) {
            return $html;
        }

        $dom = new DOMDocument;
        $previous = libxml_use_internal_errors(true);

        try {
            $loaded = $dom->loadHTML(
                '<?xml encoding="UTF-8"><div id="__blog_root__">'.$html.'</div>',
                LIBXML_HTML_NODEFDTD | LIBXML_NOWARNING | LIBXML_NOERROR
            );
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        if (! $loaded) {
            return $html;
        }

        $xpath = new DOMXPath($dom);
        $root = $xpath->query('//*[@id="__blog_root__"]')->item(0);

        if (! $root instanceof DOMElement) {
            return $html;
        }

        self::rewriteChartMarkup($xpath, $dom, $root);
        self::removeEmptyVisualBlocks($xpath, $root);

        $normalized = '';
        foreach ($root->childNodes as $child) {
            $normalized .= $dom->saveHTML($child);
        }

        return $normalized !== '' ? $normalized : $html;
    }

    protected static function rewriteChartMarkup(DOMXPath $xpath, DOMDocument $dom, DOMElement $root): void
    {
        foreach (self::elementsWithClass($xpath, $root, 'blog-chart') as $chart) {
            $rows = self::elementsWithClass($xpath, $chart, 'blog-chart__row');

            if ($rows !== []) {
                foreach ($rows as $row) {
                    self::enrichChartRow($dom, $xpath, $row);
                }

                continue;
            }

            $bars = self::elementsWithClass($xpath, $chart, 'blog-chart__bar');

            if ($bars === []) {
                continue;
            }

            $caption = null;
            foreach (iterator_to_array($chart->childNodes) as $child) {
                if ($child instanceof DOMElement && strtolower($child->nodeName) === 'figcaption') {
                    $caption = $child;
                    break;
                }
            }

            $rowData = [];
            foreach ($bars as $bar) {
                $label = trim(html_entity_decode($bar->textContent, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($label === '') {
                    continue;
                }

                $rowData[] = [
                    'label' => $label,
                    'level' => self::chartBarLevel($bar->getAttribute('class')),
                ];
            }

            foreach (iterator_to_array($chart->childNodes) as $child) {
                if ($caption !== null && $child === $caption) {
                    continue;
                }

                $chart->removeChild($child);
            }

            foreach ($rowData as $row) {
                $chart->appendChild(self::makeChartRow(
                    $dom,
                    $row['label'],
                    $row['level'],
                    self::chartWidthFromLevel($row['level']).'%'
                ));
            }
        }
    }

    /**
     * @return list<DOMElement>
     */
    protected static function elementsWithClass(DOMXPath $xpath, DOMElement $context, string $class): array
    {
        $nodes = $xpath->query(
            './/*[contains(concat(" ", normalize-space(@class), " "), " '.$class.' ")]',
            $context
        );

        if ($nodes === false) {
            return [];
        }

        $elements = [];
        foreach ($nodes as $node) {
            if ($node instanceof DOMElement) {
                $elements[] = $node;
            }
        }

        return $elements;
    }

    protected static function ensureChartTrack(DOMDocument $dom, DOMXPath $xpath, DOMElement $row): void
    {
        $bars = self::elementsWithClass($xpath, $row, 'blog-chart__bar');
        $tracks = self::elementsWithClass($xpath, $row, 'blog-chart__track');

        if ($bars === [] || $tracks !== []) {
            return;
        }

        $bar = $bars[0];
        $track = $dom->createElement('span');
        $track->setAttribute('class', 'blog-chart__track');
        $bar->parentNode?->insertBefore($track, $bar);
        $track->appendChild($bar);
    }

    /**
     * Make a chart row match the public single-blog markup: label, track, bar, value.
     */
    protected static function enrichChartRow(DOMDocument $dom, DOMXPath $xpath, DOMElement $row): void
    {
        self::ensureChartTrack($dom, $xpath, $row);

        $bars = self::elementsWithClass($xpath, $row, 'blog-chart__bar');
        if ($bars === []) {
            return;
        }

        $bar = $bars[0];
        $level = self::chartBarLevel($bar->getAttribute('class'));
        $width = self::chartBarWidth($bar, $level);
        $level = self::chartLevelFromWidth($width);
        $class = trim((string) preg_replace('/\bblog-chart__bar--(?:high|mid|low)\b/', '', $bar->getAttribute('class')));
        $bar->setAttribute('class', trim($class.' blog-chart__bar blog-chart__bar--'.$level));
        self::applyChartBarWidth($bar, $width);
        self::ensureChartValue($dom, $xpath, $row, $width);
    }

    protected static function makeChartRow(DOMDocument $dom, string $label, string $level, ?string $value = null): DOMElement
    {
        $width = self::chartWidthFromLevel($level);
        $row = $dom->createElement('div');
        $row->setAttribute('class', 'blog-chart__row');

        $labelEl = $dom->createElement('span');
        $labelEl->setAttribute('class', 'blog-chart__label');
        $labelEl->appendChild($dom->createTextNode($label));

        $track = $dom->createElement('span');
        $track->setAttribute('class', 'blog-chart__track');

        $bar = $dom->createElement('span');
        $bar->setAttribute('class', 'blog-chart__bar blog-chart__bar--'.$level);
        self::applyChartBarWidth($bar, $width);

        $valueEl = $dom->createElement('span');
        $valueEl->setAttribute('class', 'blog-chart__value');
        $valueEl->appendChild($dom->createTextNode($value ?: $width.'%'));

        $track->appendChild($bar);
        $row->appendChild($labelEl);
        $row->appendChild($track);
        $row->appendChild($valueEl);

        return $row;
    }

    protected static function ensureChartValue(DOMDocument $dom, DOMXPath $xpath, DOMElement $row, int $width): void
    {
        $values = self::elementsWithClass($xpath, $row, 'blog-chart__value');
        $text = $width.'%';

        if ($values === []) {
            $valueEl = $dom->createElement('span');
            $valueEl->setAttribute('class', 'blog-chart__value');
            $valueEl->appendChild($dom->createTextNode($text));
            $row->appendChild($valueEl);

            return;
        }

        if (trim($values[0]->textContent) === '') {
            $values[0]->appendChild($dom->createTextNode($text));
        }
    }

    protected static function applyChartBarWidth(DOMElement $bar, int $width): void
    {
        $width = max(8, min(100, $width));
        $bar->setAttribute('data-width', (string) $width);

        $style = trim((string) $bar->getAttribute('style'));
        $style = trim((string) preg_replace('/(?:^|;)\s*width\s*:[^;]*/i', '', $style), "; \t\n\r\0\x0B");
        $bar->setAttribute('style', ($style !== '' ? $style.'; ' : '').'width: '.$width.'%;');
    }

    protected static function chartBarWidth(DOMElement $bar, string $level): int
    {
        $data = trim($bar->getAttribute('data-width'));
        if ($data !== '' && is_numeric($data)) {
            return max(8, min(100, (int) $data));
        }

        if (preg_match('/width\s*:\s*(\d+)\s*%/i', $bar->getAttribute('style'), $match)) {
            return max(8, min(100, (int) $match[1]));
        }

        return self::chartWidthFromLevel($level);
    }

    protected static function chartWidthFromLevel(string $level): int
    {
        return match ($level) {
            'high' => 90,
            'low' => 28,
            default => 58,
        };
    }

    protected static function chartLevelFromWidth(int $width): string
    {
        if ($width >= 75) {
            return 'high';
        }

        if ($width <= 40) {
            return 'low';
        }

        return 'mid';
    }

    protected static function chartBarLevel(string $class): string
    {
        if (str_contains($class, 'blog-chart__bar--high')) {
            return 'high';
        }

        if (str_contains($class, 'blog-chart__bar--low')) {
            return 'low';
        }

        return 'mid';
    }

    protected static function removeEmptyVisualBlocks(DOMXPath $xpath, DOMElement $root): void
    {
        foreach (self::elementsWithClass($xpath, $root, 'blog-stat') as $stat) {
            $value = self::elementsWithClass($xpath, $stat, 'blog-stat__value')[0] ?? null;
            $label = self::elementsWithClass($xpath, $stat, 'blog-stat__label')[0] ?? null;
            $valueText = $value ? trim($value->textContent) : '';
            $labelText = $label ? trim($label->textContent) : '';

            if ($valueText === '' && $labelText === '') {
                $stat->parentNode?->removeChild($stat);
            }
        }

        foreach (['blog-insight', 'blog-chart', 'blog-takeaways', 'blog-results', 'blog-checklist', 'blog-stats'] as $class) {
            foreach (self::elementsWithClass($xpath, $root, $class) as $block) {
                if (trim(html_entity_decode($block->textContent, ENT_QUOTES | ENT_HTML5, 'UTF-8')) !== '') {
                    continue;
                }

                $block->parentNode?->removeChild($block);
            }
        }
    }

    /**
     * Rewrite absolute APP_URL storage links to root-relative paths so images
     * keep working when the app is served on a different host or port.
     */
    protected static function normalizeStorageUrls(string $html): string
    {
        if ($html === '' || ! str_contains($html, '/storage/')) {
            return $html;
        }

        return (string) preg_replace(
            '#https?://[^/"\'\s]+(/storage/[^"\'\s]+)#i',
            '$1',
            $html
        );
    }
}
