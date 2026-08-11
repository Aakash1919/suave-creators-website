<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Services\BlogDraftGenerationService;
use Illuminate\Console\Command;
use Throwable;

class GenerateTrendBlogDraftsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'blogs:generate-trend-drafts
                            {--count= : Number of draft posts to generate (default from config)}
                            {--force : Run even when BLOG_TREND_DRAFTS_ENABLED is false}';

    /**
     * @var string
     */
    protected $description = 'Generate AI customer-acquisition blog posts and save them as drafts';

    /**
     * Generate one or more lead-focused draft blogs from current trends via Laravel AI.
     */
    public function handle(BlogDraftGenerationService $generator): int
    {
        $enabled = (bool) config('blogs.trend_drafts.enabled', true);
        if (! $enabled && ! $this->option('force')) {
            $this->warn('Trend draft generation is disabled (BLOG_TREND_DRAFTS_ENABLED=false). Use --force to run anyway.');

            return self::SUCCESS;
        }

        if (blank(config('ai.providers.openai.key')) && blank(env('OPENAI_API_KEY'))) {
            $this->error('No AI API key configured. Set OPENAI_API_KEY (or your AI provider key) before generating drafts.');

            return self::FAILURE;
        }

        $count = (int) ($this->option('count') ?: config('blogs.trend_drafts.count', 1));
        $count = max(1, $count);

        $this->info("Generating {$count} customer-acquisition blog draft(s)…");

        $created = [];

        try {
            for ($i = 0; $i < $count; $i++) {
                $blog = $generator->generateDraft();
                $created[] = $blog;
                $this->line(sprintf(
                    '  [%d/%d] draft #%d — %s',
                    $i + 1,
                    $count,
                    $blog->id,
                    $blog->title,
                ));
            }
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            report($e);

            return self::FAILURE;
        }

        $this->info(sprintf(
            'Saved %d draft blog(s). Review them in admin before publishing.',
            count($created),
        ));

        if ($this->output->isVerbose()) {
            /** @var Blog $blog */
            foreach ($created as $blog) {
                $this->line('  slug='.$blog->slug.' status='.$blog->status);
            }
        }

        return self::SUCCESS;
    }
}
