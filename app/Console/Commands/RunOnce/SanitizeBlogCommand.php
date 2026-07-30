<?php

namespace App\Console\Commands\RunOnce;

use App\Models\Blog;
use App\Support\Blogs\BlogHtmlSupport;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SanitizeBlogCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'run-once:sanitize-blog
                            {--dry-run : Scan and report without writing files or updating blogs}
                            {--blog= : Limit to a blog id or slug}';

    /**
     * @var string
     */
    protected $description = 'One-time: sanitize blog HTML — extract base64 images, set image alt from title, remove empty tags';

    /**
     * Void / self-closing tags that are never treated as “empty content” wrappers.
     */
    protected string $voidTags = 'area|base|br|col|embed|hr|img|input|link|meta|param|source|track|wbr';

    /**
     * @var array<string, string>
     */
    protected array $mimeExtensions = [
        'jpeg' => 'jpg',
        'jpg' => 'jpg',
        'png' => 'png',
        'gif' => 'gif',
        'webp' => 'webp',
        'svg+xml' => 'svg',
        'svg' => 'svg',
        'bmp' => 'bmp',
        'x-icon' => 'ico',
        'vnd.microsoft.icon' => 'ico',
    ];

    /**
     * Sanitize blog content HTML across posts.
     */
    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $disk = Storage::disk('public');

        $query = Blog::query()
            ->withTrashed()
            ->whereNotNull('content')
            ->where('content', '!=', '')
            ->orderBy('id');

        $blogFilter = trim((string) $this->option('blog'));
        if ($blogFilter !== '') {
            $query->where(function ($q) use ($blogFilter): void {
                if (ctype_digit($blogFilter)) {
                    $q->where('id', (int) $blogFilter);
                }
                $q->orWhere('slug', $blogFilter);
            });
        }

        $blogs = $query->get(['id', 'slug', 'title', 'content']);

        if ($blogs->isEmpty()) {
            $this->info('No blogs found to sanitize.');

            return self::SUCCESS;
        }

        $scanned = $blogs->count();
        $this->info(($dryRun ? '[dry-run] ' : '')."Sanitizing {$scanned} blog(s)…");

        $blogsUpdated = 0;
        $imagesWritten = 0;
        $altsUpdated = 0;
        $emptyTagsRemoved = 0;
        $failures = 0;
        /** @var list<array{title: string, url: string, images: int, alts: int, empty_tags: int}> */
        $fixedBlogs = [];

        foreach ($blogs as $blog) {
            $slug = trim((string) $blog->slug);
            if ($slug === '') {
                $this->warn("Blog #{$blog->id} has no slug — skipped.");
                $failures++;

                continue;
            }

            $title = trim((string) $blog->title);
            if ($title === '') {
                $title = $slug;
            }

            $result = $this->sanitizeBlogContent(
                content: (string) $blog->content,
                blog: $blog,
                slug: $slug,
                title: $title,
                disk: $disk,
                dryRun: $dryRun,
            );

            $failures += $result['failures'];

            $changed = $result['images_written'] > 0
                || $result['alts_updated'] > 0
                || $result['empty_tags_removed'] > 0
                || $result['content'] !== (string) $blog->content;

            if (! $changed) {
                continue;
            }

            $imagesWritten += $result['images_written'];
            $altsUpdated += $result['alts_updated'];
            $emptyTagsRemoved += $result['empty_tags_removed'];

            $blogUrl = $this->blogPublicUrl($slug);

            if ($dryRun) {
                $blogsUpdated++;
                $fixedBlogs[] = [
                    'title' => $title,
                    'url' => $blogUrl,
                    'images' => $result['images_written'],
                    'alts' => $result['alts_updated'],
                    'empty_tags' => $result['empty_tags_removed'],
                ];
                $this->info(sprintf(
                    '  %s: would update (%d image(s), %d alt(s), %d empty tag(s))',
                    $slug,
                    $result['images_written'],
                    $result['alts_updated'],
                    $result['empty_tags_removed'],
                ));
                $this->line("    URL: {$blogUrl}");

                continue;
            }

            try {
                $blog->content = $result['content'];
                $blog->save();
                $blogsUpdated++;
                $fixedBlogs[] = [
                    'title' => $title,
                    'url' => $blogUrl,
                    'images' => $result['images_written'],
                    'alts' => $result['alts_updated'],
                    'empty_tags' => $result['empty_tags_removed'],
                ];
                $this->info(sprintf(
                    '  %s: updated (%d image(s), %d alt(s), %d empty tag(s))',
                    $slug,
                    $result['images_written'],
                    $result['alts_updated'],
                    $result['empty_tags_removed'],
                ));
                $this->line("    URL: {$blogUrl}");
            } catch (Throwable $e) {
                $this->error("  Blog #{$blog->id} ({$slug}): save failed — {$e->getMessage()}");
                $failures++;
            }
        }

        $this->newLine();
        $this->info(sprintf(
            'Done%s. Scanned: %d · Changed: %d · Images: %d · Alts: %d · Empty tags removed: %d · Failures: %d',
            $dryRun ? ' (dry-run)' : '',
            $scanned,
            $blogsUpdated,
            $imagesWritten,
            $altsUpdated,
            $emptyTagsRemoved,
            $failures,
        ));

        if ($fixedBlogs !== []) {
            $this->newLine();
            $this->info('Sanitized blog URLs:');
            $this->table(
                ['Title', 'URL', 'Images', 'Alts', 'Empty tags'],
                array_map(
                    static fn (array $row): array => [
                        $row['title'],
                        $row['url'],
                        (string) $row['images'],
                        (string) $row['alts'],
                        (string) $row['empty_tags'],
                    ],
                    $fixedBlogs,
                ),
            );
        } else {
            $this->info('No blogs needed changes.');
        }

        return $failures > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * @return array{
     *     content: string,
     *     images_written: int,
     *     alts_updated: int,
     *     empty_tags_removed: int,
     *     failures: int
     * }
     */
    protected function sanitizeBlogContent(
        string $content,
        Blog $blog,
        string $slug,
        string $title,
        Filesystem $disk,
        bool $dryRun,
    ): array {
        $imageResult = $this->rewriteImages($content, $blog, $slug, $title, $disk, $dryRun);
        $html = BlogHtmlSupport::upgradeInsecureHttpUrls($imageResult['content']);

        [$html, $emptyRemoved] = $this->removeEmptyTags($html);

        return [
            'content' => $html,
            'images_written' => $imageResult['images_written'],
            'alts_updated' => $imageResult['alts_updated'],
            'empty_tags_removed' => $emptyRemoved,
            'failures' => $imageResult['failures'],
        ];
    }

    /**
     * @return array{content: string, images_written: int, alts_updated: int, failures: int}
     */
    protected function rewriteImages(
        string $content,
        Blog $blog,
        string $slug,
        string $title,
        Filesystem $disk,
        bool $dryRun,
    ): array {
        $index = $this->nextImageIndex($disk, $slug);
        $imagesWritten = 0;
        $altsUpdated = 0;
        $failures = 0;
        $altValue = $title;

        $updated = preg_replace_callback(
            '/<img\b([^>]*)>/i',
            function (array $matches) use (
                $disk,
                $slug,
                $dryRun,
                $blog,
                $altValue,
                &$index,
                &$imagesWritten,
                &$altsUpdated,
                &$failures,
            ): string {
                $attrs = $matches[1];
                $src = $this->attributeValue($attrs, 'src');
                if ($src === null || $src === '') {
                    return $matches[0];
                }

                $newSrc = $src;
                $wroteImage = false;

                if (preg_match('/^data:image\/([a-zA-Z0-9.+-]+);base64,([A-Za-z0-9+\/=\r\n]+)$/i', $src, $dataUri)) {
                    $mimeSubtype = strtolower($dataUri[1]);
                    $ext = $this->mimeExtensions[$mimeSubtype] ?? null;
                    if ($ext === null) {
                        $this->warn("  Blog #{$blog->id} ({$slug}): unsupported mime image/{$mimeSubtype}");
                        $failures++;

                        return $matches[0];
                    }

                    $binary = base64_decode(preg_replace('/\s+/', '', $dataUri[2]) ?? '', true);
                    if ($binary === false || $binary === '') {
                        $this->warn("  Blog #{$blog->id} ({$slug}): invalid base64 payload");
                        $failures++;

                        return $matches[0];
                    }

                    $path = "blogs/content/{$slug}-{$index}.{$ext}";
                    while ($disk->exists($path)) {
                        $index++;
                        $path = "blogs/content/{$slug}-{$index}.{$ext}";
                    }

                    if (! $dryRun) {
                        $disk->makeDirectory('blogs/content');
                        if (! $disk->put($path, $binary)) {
                            $this->warn("  Blog #{$blog->id} ({$slug}): failed to write {$path}");
                            $failures++;

                            return $matches[0];
                        }
                    }

                    $newSrc = '/storage/'.ltrim(str_replace('\\', '/', $path), '/');
                    $this->line('  '.$slug.': '.($dryRun ? 'would write' : 'wrote')." {$path} (".strlen($binary).' bytes)');
                    $index++;
                    $imagesWritten++;
                    $wroteImage = true;
                } elseif (! $this->isBlogContentImageSrc($src, $slug)) {
                    return $matches[0];
                }

                $currentAlt = $this->attributeValue($attrs, 'alt');
                $needsAlt = $currentAlt === null || trim($currentAlt) === '' || $currentAlt !== $altValue;

                if (! $wroteImage && ! $needsAlt) {
                    return $matches[0];
                }

                if ($needsAlt) {
                    $altsUpdated++;
                }

                $attrs = $this->setAttribute($attrs, 'src', $newSrc);
                $attrs = $this->setAttribute($attrs, 'alt', $altValue);

                return '<img'.$attrs.'>';
            },
            $content
        );

        if (! is_string($updated)) {
            $this->error("  Blog #{$blog->id} ({$slug}): image rewrite failed");

            return [
                'content' => $content,
                'images_written' => 0,
                'alts_updated' => 0,
                'failures' => $failures + 1,
            ];
        }

        return [
            'content' => $updated,
            'images_written' => $imagesWritten,
            'alts_updated' => $altsUpdated,
            'failures' => $failures,
        ];
    }

    /**
     * Remove tags that contain only whitespace / &nbsp; / &lt;br&gt; (nested empties too).
     *
     * @return array{0: string, 1: int}
     */
    protected function removeEmptyTags(string $html): array
    {
        $removed = 0;
        $previous = null;
        $pattern = '/<([a-zA-Z][a-zA-Z0-9]*)\b[^>]*>(?:\s|&nbsp;|&#160;|&#xA0;|<br\s*\/?\s*>)*<\/\1\s*>/iu';

        while ($previous !== $html) {
            $previous = $html;
            $next = preg_replace_callback(
                $pattern,
                function (array $matches) use (&$removed): string {
                    $tag = strtolower($matches[1]);
                    if (preg_match('/^(?:'.$this->voidTags.')$/i', $tag)) {
                        return $matches[0];
                    }

                    // Keep structural tags that intentionally may be empty in some editors? No — user asked to remove empty tags.
                    $removed++;

                    return '';
                },
                $html
            );

            if (! is_string($next)) {
                break;
            }

            $html = $next;
        }

        // Collapse leftover excessive blank lines from removals.
        $html = (string) preg_replace("/[ \t]+\n/", "\n", $html);
        $html = (string) preg_replace("/\n{3,}/", "\n\n", $html);

        return [$html, $removed];
    }

    /**
     * Public frontend URL for a blog post.
     */
    protected function blogPublicUrl(string $slug): string
    {
        return route('blog.show', ['slug' => $slug], absolute: true);
    }

    /**
     * Whether the src points at a content image file for this blog slug.
     */
    protected function isBlogContentImageSrc(string $src, string $slug): bool
    {
        $path = parse_url($src, PHP_URL_PATH);
        if (! is_string($path) || $path === '') {
            $path = $src;
        }

        $path = str_replace('\\', '/', $path);

        return (bool) preg_match(
            '#/storage/blogs/content/'.preg_quote($slug, '#').'-\d+\.[a-z0-9]+$#i',
            $path
        );
    }

    /**
     * Read an HTML attribute value from an attribute string.
     */
    protected function attributeValue(string $attrs, string $name): ?string
    {
        if (preg_match('/\b'.preg_quote($name, '/').'\s*=\s*"([^"]*)"/i', $attrs, $m)) {
            return html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5);
        }

        if (preg_match('/\b'.preg_quote($name, '/')."\s*=\s*'([^']*)'/i", $attrs, $m)) {
            return html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5);
        }

        return null;
    }

    /**
     * Set or replace an HTML attribute (double-quoted).
     */
    protected function setAttribute(string $attrs, string $name, string $value): string
    {
        $encoded = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $pattern = '/\b'.preg_quote($name, '/').'\s*=\s*(["\'])(.*?)\1/i';

        if (preg_match($pattern, $attrs)) {
            $attrs = (string) preg_replace($pattern, $name.'="'.$encoded.'"', $attrs, 1);
        } else {
            $attrs = rtrim($attrs).' '.$name.'="'.$encoded.'"';
        }

        if ($attrs !== '' && ! str_starts_with($attrs, ' ')) {
            $attrs = ' '.$attrs;
        }

        return $attrs;
    }

    /**
     * Next free numeric suffix for blogs/content/{slug}-N.ext.
     */
    protected function nextImageIndex(Filesystem $disk, string $slug): int
    {
        if (! $disk->exists('blogs/content')) {
            return 1;
        }

        $max = 0;

        foreach ($disk->files('blogs/content') as $file) {
            $base = basename(str_replace('\\', '/', $file));
            if (! str_starts_with($base, $slug.'-')) {
                continue;
            }

            if (preg_match('/^'.preg_quote($slug, '/').'-(\d+)\.[a-z0-9]+$/i', $base, $m)) {
                $max = max($max, (int) $m[1]);
            }
        }

        return $max + 1;
    }
}
