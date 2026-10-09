<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\BlogSeoDetail;
use Illuminate\Support\Str;

class BlogSeoService
{
    public const AUTHOR_JOB_TITLE = 'Founder & Solution Architect';

    public function __construct(
        private readonly SeoGenerateService $seo,
    ) {}

    /**
     * Meta tags and JSON-LD for the saved post.
     *
     * @return array{html: string, schema: array<string, mixed>}
     */
    public function preview(Blog $blog): array
    {
        $articleSeo = $this->payload($blog);
        $title = trim((string) ($blog->meta_title ?? ''));
        if ($title === '') {
            $title = trim((string) $blog->title);
        }
        $description = trim((string) ($blog->meta_description ?? ''));
        if ($description === '') {
            $description = trim((string) ($blog->short_description ?? ''));
        }
        $faqs = is_array($blog->faqs) ? array_values(array_filter(
            $blog->faqs,
            static fn (mixed $faq): bool => is_array($faq)
                && trim((string) ($faq['question'] ?? '')) !== ''
                && trim((string) ($faq['answer'] ?? '')) !== ''
        )) : [];

        $seo = $this->seo->generate(array_filter([
            'title' => $title,
            'description' => $description !== '' ? $description : null,
            'author' => $articleSeo['author_name'],
            'type' => 'article',
            'og_title' => trim((string) ($blog->og_title ?? '')) ?: null,
            'og_description' => trim((string) ($blog->og_description ?? '')) ?: null,
            'image' => $articleSeo['image'],
            'og_image_alt' => $articleSeo['image_alt'],
            'canonical' => $blog->slug !== '' ? route('blog.show', ['slug' => $blog->slug]) : null,
            'faqs' => $faqs !== [] ? $faqs : null,
            'robots' => $blog->status === Blog::STATUS_DRAFT ? 'noindex, nofollow' : null,
            'article' => $articleSeo['article'],
            'json_ld_breadcrumb_name' => trim((string) $blog->title) ?: null,
        ], static fn (mixed $value): bool => $value !== null && $value !== ''), 'blog.show');

        $schema = is_array($seo['jsonLd'] ?? null) ? $seo['jsonLd'] : [];

        return [
            'html' => $this->previewHtml($seo, $schema),
            'schema' => $schema,
        ];
    }

    /**
     * Persist article tags, keywords, about, and mentions for a post.
     *
     * @param  array<string, mixed>  $validated
     */
    public function sync(Blog $blog, array $validated): BlogSeoDetail
    {
        return $blog->seoDetail()->updateOrCreate(
            ['blog_id' => $blog->id],
            [
                'tags' => $this->listFromInput($validated['tags'] ?? null),
                'keywords' => $this->listFromInput($validated['keywords'] ?? null),
                'about' => $this->normalizeAbout($validated['about'] ?? null),
                'mentions' => $this->normalizeMentions($validated['mentions'] ?? null),
            ],
        );
    }

    /**
     * Derived article SEO plus the stored tags, keywords, about, and mentions.
     *
     * @return array{
     *     author_name: string,
     *     image: ?string,
     *     image_alt: string,
     *     article: array<string, mixed>
     * }
     */
    public function payload(Blog $blog): array
    {
        $blog->loadMissing(['seoDetail', 'category:id,name,slug', 'createdBy:id,name']);

        $detail = $blog->seoDetail;
        $authorName = trim((string) ($blog->createdBy?->name ?? ''));
        if ($authorName === '') {
            $authorName = 'Suave Creators';
        }

        $section = trim((string) ($blog->category?->name ?? ''));
        $headline = trim((string) $blog->title);
        $linkedin = $this->companyLinkedinUrl();

        return [
            'author_name' => $authorName,
            'image' => $blog->featuredImageUrl(),
            'image_alt' => $headline !== '' ? $headline : $authorName,
            'article' => [
                'published_time' => $blog->published_at?->toAtomString(),
                'modified_time' => $blog->updated_at?->toAtomString(),
                'author' => $linkedin,
                'section' => $section,
                'tags' => $this->stringList($detail?->tags),
                'headline' => $headline,
                'author_name' => $authorName,
                'author_job_title' => self::AUTHOR_JOB_TITLE,
                'author_slug' => Str::slug($authorName) ?: 'suave-creators',
                'author_profile_url' => route('about-us'),
                'keywords' => $this->stringList($detail?->keywords),
                'about' => $this->storedAbout($detail?->about),
                'mentions' => $this->storedMentions($detail?->mentions),
            ],
        ];
    }

    /**
     * Head markup matching the public article tags, plus the JSON-LD script.
     *
     * @param  array<string, mixed>  $seo
     * @param  array<string, mixed>  $schema
     */
    protected function previewHtml(array $seo, array $schema): string
    {
        $lines = [];
        $attr = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $metaName = static function (string $name, mixed $content) use (&$lines, $attr): void {
            if (! is_string($content) || $content === '') {
                return;
            }
            $lines[] = '<meta name="'.$attr($name).'" content="'.$attr($content).'">';
        };
        $metaProperty = static function (string $property, mixed $content) use (&$lines, $attr): void {
            if (! is_string($content) && ! is_numeric($content)) {
                return;
            }
            $value = trim((string) $content);
            if ($value === '') {
                return;
            }
            $lines[] = '<meta property="'.$attr($property).'" content="'.$attr($value).'">';
        };

        $og = is_array($seo['og'] ?? null) ? $seo['og'] : [];
        $twitter = is_array($seo['twitter'] ?? null) ? $seo['twitter'] : [];
        $article = is_array($seo['article'] ?? null) ? $seo['article'] : [];

        $title = trim((string) ($seo['title'] ?? ''));
        if ($title !== '') {
            $lines[] = '<title>'.$attr($title).'</title>';
        }
        $metaName('description', $seo['description'] ?? null);
        $metaName('author', $seo['author'] ?? null);
        $canonical = trim((string) ($seo['canonical'] ?? ''));
        if ($canonical !== '') {
            $lines[] = '<link rel="canonical" href="'.$attr($canonical).'">';
        }
        $metaName('robots', $seo['robots'] ?? null);
        $metaProperty('og:type', $og['type'] ?? null);
        $metaProperty('og:site_name', $og['site_name'] ?? null);
        $metaProperty('og:url', $og['url'] ?? null);
        $metaProperty('og:title', $og['title'] ?? null);
        $metaProperty('og:description', $og['description'] ?? null);
        if (is_string($og['image'] ?? null) && $og['image'] !== '') {
            $metaProperty('og:image', $og['image']);
            $metaProperty('og:image:secure_url', $og['image_secure_url'] ?? $og['image']);
            $metaProperty('og:image:type', $og['image_type'] ?? null);
            $metaProperty('og:image:width', isset($og['image_width']) ? (string) $og['image_width'] : null);
            $metaProperty('og:image:height', isset($og['image_height']) ? (string) $og['image_height'] : null);
            $metaProperty('og:image:alt', $og['image_alt'] ?? null);
        }
        $metaProperty('og:locale', $og['locale'] ?? null);
        $metaProperty('article:published_time', $article['published_time'] ?? null);
        $metaProperty('article:modified_time', $article['modified_time'] ?? null);
        $metaProperty('article:author', $article['author'] ?? null);
        $metaProperty('article:section', $article['section'] ?? null);
        foreach ((array) ($article['tags'] ?? []) as $tag) {
            $metaProperty('article:tag', $tag);
        }
        $metaName('twitter:card', $twitter['card'] ?? null);
        $metaName('twitter:site', $twitter['site'] ?? null);
        $metaName('twitter:creator', $twitter['creator'] ?? null);
        $metaName('twitter:title', $twitter['title'] ?? null);
        $metaName('twitter:description', $twitter['description'] ?? null);
        $metaName('twitter:image', $twitter['image'] ?? null);
        $metaName('twitter:image:alt', $twitter['image_alt'] ?? null);

        $json = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if (is_string($json) && $json !== '' && $json !== '[]') {
            $lines[] = '';
            $lines[] = '<script type="application/ld+json">';
            $lines[] = $json;
            $lines[] = '</script>';
        }

        return implode("\n", $lines);
    }

    /**
     * @return list<string>
     */
    public function listFromInput(mixed $value): array
    {
        if (is_array($value)) {
            $parts = $value;
        } else {
            $parts = preg_split('/[\r\n,]+/', (string) $value) ?: [];
        }

        $items = [];
        foreach ($parts as $part) {
            if (! is_string($part) && ! is_numeric($part)) {
                continue;
            }

            $label = trim((string) $part);
            if ($label === '' || in_array($label, $items, true)) {
                continue;
            }

            $items[] = $label;
        }

        return $items;
    }

    /**
     * @return list<array{name: string, same_as: string}>
     */
    public function normalizeAbout(mixed $rows): array
    {
        if (! is_array($rows)) {
            return [];
        }

        $items = [];
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $items[] = [
                'name' => $name,
                'same_as' => trim((string) ($row['same_as'] ?? '')),
            ];
        }

        return $items;
    }

    /**
     * @return list<array{type: string, name: string, url: string, same_as: string}>
     */
    public function normalizeMentions(mixed $rows): array
    {
        if (! is_array($rows)) {
            return [];
        }

        $items = [];
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $type = (string) ($row['type'] ?? 'Organization');
            if (! in_array($type, ['Organization', 'Service'], true)) {
                $type = 'Organization';
            }

            $items[] = [
                'type' => $type,
                'name' => $name,
                'url' => trim((string) ($row['url'] ?? '')),
                'same_as' => trim((string) ($row['same_as'] ?? '')),
            ];
        }

        return $items;
    }

    public function companyLinkedinUrl(): string
    {
        $profiles = (array) config('seo.site.organization.sameAs', []);
        foreach ($profiles as $profile) {
            if (is_string($profile) && str_contains($profile, 'linkedin.com/company/')) {
                return $profile;
            }
        }

        return 'https://www.linkedin.com/company/suave-creators/';
    }

    /**
     * @return list<string>
     */
    protected function stringList(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter(
            $value,
            static fn (mixed $item): bool => is_string($item) && $item !== ''
        ));
    }

    /**
     * @return list<array{name: string, same_as: string}>
     */
    protected function storedAbout(mixed $rows): array
    {
        return $this->normalizeAbout($rows);
    }

    /**
     * @return list<array{type: string, name: string, url: string, same_as: string}>
     */
    protected function storedMentions(mixed $rows): array
    {
        return $this->normalizeMentions($rows);
    }
}
