<?php

namespace App\Console\Commands\RunOnce;

use App\Models\Blog;
use App\Services\BlogSeoMetaGenerationService;
use Illuminate\Console\Command;
use Throwable;

class RegenerateBlogSeoMetaCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'run-once:regenerate-blog-seo-meta
                            {--dry-run : Generate and print fields without saving}
                            {--blog= : Limit to a blog id or slug}';

    /**
     * @var string
     */
    protected $description = 'One-time: regenerate meta_title, meta_description, og_title, and og_description for all blogs via AI';

    /**
     * Regenerate and (unless dry-run) persist SEO / OG meta for blogs.
     */
    public function handle(BlogSeoMetaGenerationService $seoMeta): int
    {
        if (blank(config('ai.providers.openai.key')) && blank(env('OPENAI_API_KEY'))) {
            $this->error('No AI API key configured. Set OPENAI_API_KEY (or your AI provider key) before regenerating SEO meta.');

            return self::FAILURE;
        }

        $dryRun = (bool) $this->option('dry-run');

        $query = Blog::query()
            ->with('category')
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

        $blogs = $query->get();

        if ($blogs->isEmpty()) {
            $this->info('No blogs found to regenerate SEO meta for.');

            return self::SUCCESS;
        }

        $total = $blogs->count();
        $this->info(($dryRun ? '[dry-run] ' : '')."Regenerating SEO meta for {$total} blog(s)…");

        $updated = 0;
        $failed = 0;

        foreach ($blogs as $index => $blog) {
            $n = $index + 1;
            $label = "#{$blog->id} {$blog->slug}";

            try {
                if ($dryRun) {
                    $seo = $seoMeta->generate($blog);
                } else {
                    $seo = $seoMeta->regenerateAndSave($blog);
                }

                $updated++;
                $this->line(sprintf(
                    '  [%d/%d] %s — meta_title: %s',
                    $n,
                    $total,
                    $label,
                    $seo['meta_title'],
                ));

                if ($this->output->isVerbose()) {
                    $this->line('    meta_description: '.$seo['meta_description']);
                    $this->line('    og_title: '.$seo['og_title']);
                    $this->line('    og_description: '.$seo['og_description']);
                }
            } catch (Throwable $e) {
                $failed++;
                $this->error(sprintf('  [%d/%d] %s — %s', $n, $total, $label, $e->getMessage()));
                report($e);
            }
        }

        $this->info(sprintf(
            'Done. %s=%d failed=%d',
            $dryRun ? 'generated' : 'updated',
            $updated,
            $failed,
        ));

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
