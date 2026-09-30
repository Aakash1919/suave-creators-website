<?php

namespace App\Console\Commands\RunOnce;

use App\Models\Blog;
use App\Services\BlogRewriteService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class RewriteLegacyBlogsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'run-once:rewrite-legacy-blogs
                            {blog : Id or slug of the legacy blog to rewrite (id must be below blogs.rewrite.below_id)}
                            {--dry-run : Write an HTML preview to storage/app/blog-rewrites without saving}
                            {--skip-backup : Do not back up the blog row before saving}';

    /**
     * @var string
     */
    protected $description = 'One-time: rewrite one legacy blog post in the human-written voice with internal links (images untouched)';

    /**
     * Rewrite a single legacy post, backing up its row first.
     */
    public function handle(BlogRewriteService $rewriter): int
    {
        if (blank(config('ai.providers.openai.key')) && blank(env('OPENAI_API_KEY'))) {
            $this->error('No AI API key configured. Set OPENAI_API_KEY (or your AI provider key) before rewriting blogs.');

            return self::FAILURE;
        }

        $dryRun = (bool) $this->option('dry-run');
        $below = $rewriter->belowId();
        $filter = trim((string) $this->argument('blog'));

        $blog = Blog::query()
            ->where(function ($q) use ($filter): void {
                if (ctype_digit($filter)) {
                    $q->where('id', (int) $filter);
                }
                $q->orWhere('slug', $filter);
            })
            ->first();

        if ($blog === null) {
            $this->error("No blog found for \"{$filter}\".");

            return self::FAILURE;
        }

        if ((int) $blog->id >= $below) {
            $this->error("Blog #{$blog->id} is at or above id {$below} (human-written) and is never rewritten.");

            return self::FAILURE;
        }

        if (trim((string) $blog->content) === '') {
            $this->error("Blog #{$blog->id} has no content to rewrite.");

            return self::FAILURE;
        }

        try {
            $target = $rewriter->targetWordCount();
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->info(sprintf(
            '%sRewriting #%d %s with %s. Target length %d words (%d–%d, from %d published post(s) at or above id %d).',
            $dryRun ? '[dry-run] ' : '',
            $blog->id,
            $blog->slug,
            (string) config('blogs.rewrite.model'),
            $target['average'],
            $target['min'],
            $target['max'],
            $target['sample'],
            $below,
        ));

        try {
            $result = $rewriter->rewrite($blog, save: false);
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            report($e);

            return self::FAILURE;
        }

        if ($dryRun) {
            $previewDir = storage_path('app/blog-rewrites');
            File::ensureDirectoryExists($previewDir);
            $path = $previewDir.DIRECTORY_SEPARATOR."{$blog->id}-{$blog->slug}.html";
            File::put($path, $this->previewHtml($blog, $result));
        } else {
            if (! $this->option('skip-backup')) {
                $this->info($rewriter->backupBlog($blog)
                    ? 'Original saved to '.BlogRewriteService::BACKUP_TABLE.'.'
                    : 'Original already in '.BlogRewriteService::BACKUP_TABLE.' (kept unchanged).');
                $this->info("Undo with: php artisan run-once:restore-blog-content --blog={$blog->id}");
            }

            $rewriter->saveRewrite($blog, $result);
        }

        $this->table(['ID', 'Slug', 'Words', 'Links', 'Optional sections', 'Images kept', 'Attempts', 'Result'], [[
            $blog->id,
            $blog->slug,
            $result['words_before'].' → '.$result['words_after'],
            count($result['links']),
            collect($result['sections_used'])->pluck('section')->implode(', ') ?: '(none)',
            $result['images'],
            $result['attempts'],
            $dryRun ? 'previewed' : 'saved',
        ]]);

        if ($dryRun) {
            $this->info("Preview written to {$path}");
        }

        return self::SUCCESS;
    }

    /**
     * Standalone review page for one dry-run rewrite.
     *
     * @param  array<string, mixed>  $result
     */
    protected function previewHtml(Blog $blog, array $result): string
    {
        $title = e((string) $blog->title);
        $links = collect($result['links'])->map(static fn (string $l): string => '<li>'.e($l).'</li>')->implode('');
        $sections = collect($result['sections_used'])
            ->map(static fn (array $s): string => '<li><strong>'.e($s['section']).'</strong>: '.e($s['reason']).'</li>')
            ->implode('') ?: '<li>(none)</li>';
        $faqs = collect($result['faqs'])
            ->map(static fn (array $f): string => '<dt>'.e($f['question']).'</dt><dd>'.e($f['answer']).'</dd>')
            ->implode('');

        return <<<HTML
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Rewrite preview: {$title}</title>
<style>body{font:16px/1.6 system-ui,sans-serif;max-width:820px;margin:40px auto;padding:0 20px;color:#1a1a1a}
.meta{background:#f7f8f9;border:1px solid #e5e7eb;border-radius:8px;padding:16px;margin-bottom:32px;font-size:14px}
img{max-width:100%;height:auto}table{border-collapse:collapse;width:100%}td,th{border:1px solid #ddd;padding:8px}
dt{font-weight:600;margin-top:12px}</style></head><body>
<div class="meta">
<p><strong>#{$blog->id}</strong> {$blog->slug} | words {$result['words_before']} → {$result['words_after']}, images kept {$result['images']}, attempts {$result['attempts']}</p>
<p><strong>Internal links</strong></p><ul>{$links}</ul>
<p><strong>Optional sections used</strong></p><ul>{$sections}</ul>
</div>
<h1>{$title}</h1>
{$result['content']}
<h2>FAQs</h2><dl>{$faqs}</dl>
</body></html>
HTML;
    }
}
