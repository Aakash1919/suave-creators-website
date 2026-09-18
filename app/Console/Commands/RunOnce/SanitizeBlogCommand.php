<?php

namespace App\Console\Commands\RunOnce;

use App\Models\Blog;
use App\Support\Blogs\BlogHtmlSupport;
use Illuminate\Console\Command;
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
    protected $description = 'Sanitize blog HTML — extract base64/inline SVG images, fill empty alts, remove empty tags, normalize H2→H3 headings';

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

            $result = BlogHtmlSupport::sanitizeContent(
                html: (string) $blog->content,
                slug: $slug,
                title: $title,
                dryRun: $dryRun,
                disk: $disk,
            );

            foreach ($result['messages'] as $message) {
                $this->line('  '.$slug.': '.$message);
            }

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

            $blogUrl = route('blog.show', ['slug' => $slug], absolute: true);

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
                Blog::query()->whereKey($blog->id)->update([
                    'content' => $result['content'],
                ]);
                $blog->content = $result['content'];
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
}
