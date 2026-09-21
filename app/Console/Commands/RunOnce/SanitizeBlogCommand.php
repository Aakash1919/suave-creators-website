<?php

namespace App\Console\Commands\RunOnce;

use App\Models\Blog;
use App\Support\Blogs\BlogHtmlSupport;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SanitizeBlogCommand extends Command
{
    /**
     * Default blogs loaded per query. Keep this at 1 — article HTML can be tens of MB.
     */
    public const CHUNK_SIZE = 1;

    /**
     * @var string
     */
    protected $signature = 'run-once:sanitize-blog
                            {--dry-run : Scan and report without writing files or updating blogs}
                            {--blog= : Limit to a blog id or slug}
                            {--chunk=1 : Number of blogs to load per query}';

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
        $requestedChunk = (int) $this->option('chunk');
        $chunkSize = $requestedChunk > 0 ? $requestedChunk : self::CHUNK_SIZE;
        $disk = Storage::disk('public');

        $query = Blog::query()
            ->withTrashed()
            ->whereNotNull('content')
            ->where('content', '!=', '');

        $blogFilter = trim((string) $this->option('blog'));
        if ($blogFilter !== '') {
            $query->where(function ($q) use ($blogFilter): void {
                if (ctype_digit($blogFilter)) {
                    $q->where('id', (int) $blogFilter);
                }
                $q->orWhere('slug', $blogFilter);
            });
        }

        $scanned = (clone $query)->count();

        if ($scanned === 0) {
            $this->info('No blogs found to sanitize.');

            return self::SUCCESS;
        }

        $this->info(($dryRun ? '[dry-run] ' : '')."Sanitizing {$scanned} blog(s) in chunks of {$chunkSize}…");

        $blogsUpdated = 0;
        $imagesWritten = 0;
        $altsUpdated = 0;
        $emptyTagsRemoved = 0;
        $failures = 0;
        /** @var list<array{title: string, url: string, images: int, alts: int, empty_tags: int}> */
        $fixedBlogs = [];

        $query->select(['id', 'slug', 'title', 'content'])
            ->chunkById($chunkSize, function (Collection $blogs) use (
                $dryRun,
                $disk,
                &$blogsUpdated,
                &$imagesWritten,
                &$altsUpdated,
                &$emptyTagsRemoved,
                &$failures,
                &$fixedBlogs,
            ): void {
                foreach ($blogs as $blog) {
                    if (! $blog instanceof Blog) {
                        continue;
                    }

                    $this->processBlog(
                        blog: $blog,
                        dryRun: $dryRun,
                        disk: $disk,
                        blogsUpdated: $blogsUpdated,
                        imagesWritten: $imagesWritten,
                        altsUpdated: $altsUpdated,
                        emptyTagsRemoved: $emptyTagsRemoved,
                        failures: $failures,
                        fixedBlogs: $fixedBlogs,
                    );
                }
            });

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
     * @param  list<array{title: string, url: string, images: int, alts: int, empty_tags: int}>  $fixedBlogs
     */
    protected function processBlog(
        Blog $blog,
        bool $dryRun,
        Filesystem $disk,
        int &$blogsUpdated,
        int &$imagesWritten,
        int &$altsUpdated,
        int &$emptyTagsRemoved,
        int &$failures,
        array &$fixedBlogs,
    ): void {
        $slug = trim((string) $blog->slug);
        if ($slug === '') {
            $this->warn("Blog #{$blog->id} has no slug — skipped.");
            $failures++;

            return;
        }

        $title = trim((string) $blog->title);
        if ($title === '') {
            $title = $slug;
        }

        $original = (string) $blog->content;
        $result = BlogHtmlSupport::sanitizeContent(
            html: $original,
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
            || $result['content'] !== $original;

        unset($original);

        if (! $changed) {
            return;
        }

        $imagesWritten += $result['images_written'];
        $altsUpdated += $result['alts_updated'];
        $emptyTagsRemoved += $result['empty_tags_removed'];

        $blogUrl = route('blog.show', ['slug' => $slug], absolute: true);
        $fixedBlogs[] = [
            'title' => $title,
            'url' => $blogUrl,
            'images' => $result['images_written'],
            'alts' => $result['alts_updated'],
            'empty_tags' => $result['empty_tags_removed'],
        ];

        if ($dryRun) {
            $blogsUpdated++;
            $this->info(sprintf(
                '  %s: would update (%d image(s), %d alt(s), %d empty tag(s))',
                $slug,
                $result['images_written'],
                $result['alts_updated'],
                $result['empty_tags_removed'],
            ));
            $this->line("    URL: {$blogUrl}");

            return;
        }

        try {
            Blog::query()->whereKey($blog->id)->update([
                'content' => $result['content'],
            ]);
            $blogsUpdated++;
            $this->info(sprintf(
                '  %s: updated (%d image(s), %d alt(s), %d empty tag(s))',
                $slug,
                $result['images_written'],
                $result['alts_updated'],
                $result['empty_tags_removed'],
            ));
            $this->line("    URL: {$blogUrl}");
        } catch (Throwable $e) {
            array_pop($fixedBlogs);
            $this->error("  Blog #{$blog->id} ({$slug}): save failed — {$e->getMessage()}");
            $failures++;
        }
    }
}
