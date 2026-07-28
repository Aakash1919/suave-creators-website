<?php

namespace App\Console\Commands;

use App\Services\SeoAuditReportService;
use Illuminate\Console\Command;
use Throwable;

class SeoAuditReportCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'seo:audit-report
                            {--dry-run : Crawl and print a summary without sending email}
                            {--force : Run even when SEO_AUDIT_REPORT_ENABLED is false}';

    /**
     * @var string
     */
    protected $description = 'Crawl all public sitemap pages for SEO issues and email a report';

    /**
     * Crawl sitemap URLs, build an SEO report, and email it.
     */
    public function handle(SeoAuditReportService $auditor): int
    {
        $enabled = (bool) config('seo.audit_report.enabled', true);
        if (! $enabled && ! $this->option('force')) {
            $this->warn('SEO audit report is disabled (SEO_AUDIT_REPORT_ENABLED=false). Use --force to run anyway.');

            return self::SUCCESS;
        }

        $to = (string) config('seo.audit_report.to', 'info@suavecreators.com');
        if ($to === '' && ! $this->option('dry-run')) {
            $this->error('No recipient configured. Set SEO_AUDIT_REPORT_TO.');

            return self::FAILURE;
        }

        $this->info('Crawling sitemap URLs for SEO audit…');

        try {
            $report = $auditor->generate();
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            report($e);

            return self::FAILURE;
        }

        $this->line(sprintf(
            '  Pages: %d | OK: %d | With issues: %d | Errors: %d | Warnings: %d',
            $report['page_count'],
            $report['ok_count'],
            $report['issue_page_count'],
            $report['error_count'],
            $report['warning_count'],
        ));

        if ($this->output->isVerbose()) {
            foreach ($report['pages'] as $page) {
                if ($page['ok']) {
                    continue;
                }
                $this->newLine();
                $this->line('  '.$page['url']);
                foreach ($page['issues'] as $issue) {
                    $this->line(sprintf(
                        '    [%s] %s — %s',
                        strtoupper($issue['severity']),
                        $issue['check'],
                        $issue['message'],
                    ));
                    if (! empty($issue['suggestion'])) {
                        $this->line('      Fix: '.$issue['suggestion']);
                    }
                }
            }
        }

        if ($this->option('dry-run')) {
            $this->info('Dry run complete — email not sent.');

            return self::SUCCESS;
        }

        $mailer = (string) config('seo.audit_report.mailer', 'log');

        try {
            $auditor->deliver($report);
        } catch (Throwable $e) {
            $this->error('Failed to send report: '.$e->getMessage());
            report($e);

            return self::FAILURE;
        }

        if ($mailer === 'log') {
            $this->info("Report logged (mailer=log) for {$to}. Check storage/logs.");
        } else {
            $this->info("Report emailed to {$to} via {$mailer}.");
        }

        return self::SUCCESS;
    }
}
