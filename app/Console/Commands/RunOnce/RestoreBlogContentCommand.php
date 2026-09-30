<?php

namespace App\Console\Commands\RunOnce;

use App\Services\BlogRewriteService;
use Illuminate\Console\Command;
use InvalidArgumentException;

class RestoreBlogContentCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'run-once:restore-blog-content
                            {--blog= : Blog id or slug to restore}
                            {--all : Restore every post in the backup table}';

    /**
     * @var string
     */
    protected $description = 'One-time: copy the original blog content and FAQs back from the blogs_backup table';

    /**
     * Restore pre-rewrite content + FAQs from blogs_backup.
     */
    public function handle(BlogRewriteService $rewriter): int
    {
        $blog = trim((string) $this->option('blog'));
        if ($blog === '' && ! $this->option('all')) {
            $this->error('Pass --blog={id} (or --all to restore every backed-up post).');

            return self::FAILURE;
        }

        try {
            $restored = $rewriter->restoreFromBackup($blog !== '' ? $blog : null);
        } catch (InvalidArgumentException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        if ($restored === 0) {
            $this->warn('No matching post found in '.BlogRewriteService::BACKUP_TABLE.'.');

            return self::FAILURE;
        }

        $this->info("Restored content and FAQs for {$restored} blog(s) from ".BlogRewriteService::BACKUP_TABLE.'.');

        return self::SUCCESS;
    }
}
