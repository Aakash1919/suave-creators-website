<?php

namespace App\Support\Frontend;

use App\Models\Blog;
use App\Models\BlogCategory;
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

        if ($pullQuote !== '' && stripos($content, '<blockquote') === false) {
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
