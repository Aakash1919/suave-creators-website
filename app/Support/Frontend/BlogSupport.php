<?php

namespace App\Support\Frontend;

use App\Support\Frontend\Concerns\MapsDesignAssets;

class BlogSupport
{
    use MapsDesignAssets;

    /** @var array<string, string> */
    public const SLUG_ROUTE_NAMES = [
        'digital-strategy-that-creates-value' => 'blog.digital-strategy-that-creates-value',
        'product-data-customer-experiences' => 'blog.product-data-customer-experiences',
        'digital-workflows-teams-use' => 'blog.digital-workflows-teams-use',
        'ai-powered-software-development-2026' => 'blog.ai-powered-software-development-2026',
        'choosing-the-right-tech-stack' => 'blog.choosing-the-right-tech-stack',
        'ux-principles-that-drive-conversions' => 'blog.ux-principles-that-drive-conversions',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function posts(): array
    {
        static $posts = null;

        if ($posts !== null) {
            return $posts;
        }

        $path = self::dataPath('blogs/posts.php');

        if (! is_file($path)) {
            return $posts = [];
        }

        /** @var array<int, array<string, mixed>> $raw */
        $raw = include $path;
        $posts = [];

        foreach ($raw as $post) {
            $mapped = self::mapDesignData($post);
            $slug = (string) ($mapped['slug'] ?? '');

            if (isset(self::SLUG_ROUTE_NAMES[$slug])) {
                $mapped['route'] = self::SLUG_ROUTE_NAMES[$slug];
                $mapped['url'] = route(self::SLUG_ROUTE_NAMES[$slug]);
            }

            $mapped['image'] = asset((string) ($mapped['image'] ?? ''));
            $posts[] = $mapped;
        }

        return $posts;
    }

    public static function routeNameForSlug(string $slug): string
    {
        return self::SLUG_ROUTE_NAMES[$slug] ?? 'blogs';
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function post(string $slug): ?array
    {
        foreach (self::posts() as $post) {
            if (($post['slug'] ?? '') === $slug) {
                return $post;
            }
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    public static function indexData(): array
    {
        return [
            'posts' => self::posts(),
            'heroImages' => self::heroImages(),
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
            ['src' => asset('assets/blog/blogs-hero/03-meeting.jpg'), 'alt' => 'Team meeting for digital strategy blog articles', 'size' => 'lg'],
            ['src' => asset('assets/blog/blogs-hero/04-office.jpg'), 'alt' => 'Modern office for Suave Creators engineering insights', 'size' => 'md'],
            ['src' => asset('assets/blog/blogs-hero/05-desk.jpg'), 'alt' => 'Developer desk for software engineering blog posts', 'size' => 'sm'],
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

        $posts = self::posts();
        $categories = [];

        foreach ($posts as $candidate) {
            $cat = trim((string) ($candidate['category'] ?? ''));

            if ($cat !== '' && ! in_array($cat, $categories, true)) {
                $categories[] = $cat;
            }
        }

        $sliderPosts = [];

        foreach ($posts as $candidate) {
            if (($candidate['slug'] ?? '') === $slug) {
                continue;
            }

            $sliderPosts[] = $candidate;
        }

        if (count($sliderPosts) < 2) {
            $sliderPosts = $posts;
        }

        $sliderPosts = array_slice($sliderPosts, 0, 6);

        $articleContent = self::prepareArticleContent($post);

        $titleWords = preg_split('/\s+/', trim((string) ($post['title'] ?? '')), -1, PREG_SPLIT_NO_EMPTY);
        $titleWordCount = count($titleWords);
        $accentStart = max(0, (int) floor($titleWordCount * 0.55));
        $titleLead = implode(' ', array_slice($titleWords, 0, $accentStart));
        $titleAccent = implode(' ', array_slice($titleWords, $accentStart));

        return [
            'post' => $post,
            'posts' => $posts,
            'categories' => $categories,
            'topPosts' => array_slice($posts, 0, 5),
            'sliderPosts' => $sliderPosts,
            'articleContent' => $articleContent,
            'tags' => array_values(array_filter([
                $post['category'] ?? '',
                'Insights',
            ])),
            'titleLead' => $titleLead,
            'titleAccent' => $titleAccent,
            'faqs' => ! empty($post['faqs']) && is_array($post['faqs']) ? $post['faqs'] : self::defaultFaqs(),
            'seoTitle' => ($post['title'] ?? 'Blog').' | Suave Creators',
            'seoDescription' => (string) ($post['short_description'] ?? 'Suave Creators blog article.'),
        ];
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    public static function defaultFaqs(): array
    {
        return [
            [
                'question' => 'How can Suave Creators help after reading this article?',
                'answer' => 'Share your goals with our team and we will map a practical next step — from strategy and design through to build and launch.',
            ],
            [
                'question' => 'Do you work with startups and established businesses?',
                'answer' => 'Yes. We partner with early-stage teams and growing organisations that need reliable product, design, and engineering support.',
            ],
            [
                'question' => 'How soon can we start a discovery conversation?',
                'answer' => 'Most teams hear back within one business day. Book a free consultation and we will align on scope, timeline, and the best way to begin.',
            ],
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

        $featureImageHtml = '<figure class="single-blog-main__image single-blog-main__image--inline">'
            .'<img src="'.e($image).'" alt="'.e($title).'" title="'.e($title).'" width="1200" height="640" loading="eager">'
            .'</figure>';

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
}
