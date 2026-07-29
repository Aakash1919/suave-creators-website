<?php

namespace App\Console\Commands\RunOnce;

use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Console\Command;
use Throwable;

class GenerateBlogMediumThumbsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'run-once:generate-blog-medium-thumbs
                            {--dry-run : Report which blogs would get a medium thumb without writing files}
                            {--blog= : Limit to a blog id or slug}
                            {--missing-only : Only blogs that do not already have medium_thumb_image}';

    /**
     * @var string
     */
    protected $description = 'One-time: generate medium featured-image thumbs for existing blogs (and remove legacy small thumbs)';

    /**
     * Generate medium thumbs from stored featured images.
     */
    public function handle(BlogService $blogs): int
    {
        ini_set('memory_limit', '512M');

        $dryRun = (bool) $this->option('dry-run');
        $missingOnly = (bool) $this->option('missing-only');

        $query = Blog::query()
            ->whereNotNull('featured_image')
            ->where('featured_image', '!=', '')
            ->orderBy('id');

        if ($missingOnly) {
            $query->where(function ($q): void {
                $q->whereNull('medium_thumb_image')
                    ->orWhere('medium_thumb_image', '');
            });
        }

        $blogFilter = trim((string) $this->option('blog'));
        if ($blogFilter !== '') {
            $query->where(function ($q) use ($blogFilter): void {
                if (ctype_digit($blogFilter)) {
                    $q->where('id', (int) $blogFilter);
                }
                $q->orWhere('slug', $blogFilter);
            });
        }

        $rows = $query->get(['id', 'slug', 'featured_image', 'medium_thumb_image']);

        if ($rows->isEmpty()) {
            $this->info('No blogs found with a featured image to process.');

            return self::SUCCESS;
        }

        $total = $rows->count();
        $this->info(($dryRun ? '[dry-run] ' : '')."Generating medium thumbs for {$total} blog(s)…");

        $updated = 0;
        $failed = 0;
        $skipped = 0;

        foreach ($rows as $index => $blog) {
            $n = $index + 1;
            $label = "#{$blog->id} {$blog->slug}";
            $featured = (string) $blog->featured_image;

            if (
                str_starts_with($featured, 'http://')
                || str_starts_with($featured, 'https://')
            ) {
                $skipped++;
                $this->warn(sprintf('  [%d/%d] %s — skipped remote featured image', $n, $total, $label));

                continue;
            }

            try {
                if ($dryRun) {
                    $updated++;
                    $this->line(sprintf(
                        '  [%d/%d] %s — would generate medium from %s',
                        $n,
                        $total,
                        $label,
                        $featured,
                    ));

                    continue;
                }

                $medium = $blogs->regenerateMediumThumb($blog);
                $updated++;
                $this->line(sprintf(
                    '  [%d/%d] %s — %s',
                    $n,
                    $total,
                    $label,
                    $medium,
                ));
            } catch (Throwable $e) {
                $failed++;
                $this->error(sprintf('  [%d/%d] %s — %s', $n, $total, $label, $e->getMessage()));
                report($e);
            }
        }

        $this->info(sprintf(
            'Done. %s=%d skipped=%d failed=%d',
            $dryRun ? 'would_update' : 'updated',
            $updated,
            $skipped,
            $failed,
        ));

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
