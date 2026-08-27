<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Services\BlogDraftGenerationService;
use Illuminate\Console\Command;
use Throwable;

class GenerateBlog extends Command
{
    /**
     * @var string
     */
    protected $signature = 'generate:blog
                            {--count= : Number of draft posts to generate (default from config)}
                            {--topic= : Topic to write about; omit to let the writer pick a timely IT topic}
                            {--force : Run even when BLOG_TREND_DRAFTS_ENABLED is false}';

    /**
     * @var string
     */
    protected $description = 'Generate an AI blog draft (assigned --topic, or a timely customer-acquisition topic)';

    /**
     * Generate one or more lead-focused draft blogs via Laravel AI.
     */
    public function handle(BlogDraftGenerationService $generator): int
    {
        $enabled = (bool) config('blogs.trend_drafts.enabled', true);
        if (! $enabled && ! $this->option('force')) {
            $this->warn('Blog generation is disabled (BLOG_TREND_DRAFTS_ENABLED=false). Use --force to run anyway.');

            return self::SUCCESS;
        }

        if (blank(config('ai.providers.openai.key')) && blank(env('OPENAI_API_KEY'))) {
            $this->error('No AI API key configured. Set OPENAI_API_KEY (or your AI provider key) before generating drafts.');

            return self::FAILURE;
        }

        $count = (int) ($this->option('count') ?: config('blogs.trend_drafts.count', 1));
        $count = max(1, $count);
        $topic = trim((string) $this->option('topic'));
        $topic = $topic !== '' ? $topic : null;

        if ($topic !== null) {
            $this->info("Using assigned topic: {$topic}");
        } else {
            $this->info('No --topic given. The writer will pick one timely IT topic that:');
            $this->line('  • matches a lead angle (service, industry, problem, comparison, or buyer-ready)');
            $this->line('  • prefers Software Development or Web Development');
            $this->line('  • does not overlap recent blog titles');
        }

        $this->info("Generating {$count} blog draft(s)…");

        $created = [];

        try {
            for ($i = 0; $i < $count; $i++) {
                $blog = $generator->generateDraft($topic);
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
