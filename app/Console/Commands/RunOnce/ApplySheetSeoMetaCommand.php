<?php

namespace App\Console\Commands\RunOnce;

use App\Models\Blog;
use Illuminate\Console\Command;

class ApplySheetSeoMetaCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'run-once:apply-sheet-seo-meta
                            {--dry-run : Print planned updates without saving}';

    /**
     * @var string
     */
    protected $description = 'One-time: apply revised meta/OG title and description from the SEO spreadsheet to matching blogs';

    /**
     * @return array<string, array{meta_title: string, meta_description: string, og_title: string, og_description: string}>
     */
    private function blogUpdates(): array
    {
        return [
            'embracing-edge-computing-the-future-of-business-technology-in-2026' => [
                'meta_title' => 'Edge Computing for Business: Benefits, Use Cases & Future',
                'meta_description' => 'Learn how edge computing helps businesses process data faster, reduce latency, and improve efficiency, with key use cases and implementation insights.',
                'og_title' => 'Edge Computing for Business: Benefits, Use Cases & Future',
                'og_description' => 'Learn how edge computing helps businesses process data faster, reduce latency, and improve efficiency, with key use cases and implementation insights.',
            ],
            'harnessing-ai-powered-business-intelligence-for-strategic-growth-in-2026' => [
                'meta_title' => 'AI-Powered Business Intelligence: Benefits & Business Growth',
                'meta_description' => 'Learn how AI-powered business intelligence can improve data-driven decision-making, uncover insights, and help businesses identify new growth opportunities.',
                'og_title' => 'AI-Powered Business Intelligence: Benefits & Business Growth',
                'og_description' => 'Learn how AI-powered business intelligence can improve data-driven decision-making, uncover insights, and help businesses identify new growth opportunities.',
            ],
            'the-rise-of-generative-ai-transforming-business-operations-in-2026' => [
                'meta_title' => 'Generative AI in Business Operations: Benefits & Use Cases',
                'meta_description' => 'Learn how generative AI is transforming business operations through automation, productivity, personalization, and smarter workflows.',
                'og_title' => 'Generative AI in Business Operations: Benefits & Use Cases',
                'og_description' => 'Learn how generative AI is transforming business operations through automation, productivity, personalization, and smarter workflows.',
            ],
            'how-enterprise-automation-is-revolutionizing-business-operations-in-2026' => [
                'meta_title' => 'Enterprise Automation: Benefits, Use Cases & Strategies',
                'meta_description' => 'Learn how enterprise automation improves operational efficiency, reduces repetitive work, lowers costs, and supports better business decision-making.',
                'og_title' => 'Enterprise Automation: Benefits, Use Cases & Strategies',
                'og_description' => 'Learn how enterprise automation improves operational efficiency, reduces repetitive work, lowers costs, and supports better business decision-making.',
            ],
            'the-rise-of-api-first-development-why-your-business-needs-to-adapt' => [
                'meta_title' => 'API-First Development: Benefits, Strategy & Business Impact',
                'meta_description' => 'Learn how API-first development improves software scalability, integration, flexibility, and collaboration, with practical strategies for implementation.',
                'og_title' => 'API-First Development: Benefits, Strategy & Business Impact',
                'og_description' => 'Learn how API-first development improves software scalability, integration, flexibility, and collaboration, with practical strategies for implementation.',
            ],
        ];
    }

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $updated = 0;
        $missing = 0;

        foreach ($this->blogUpdates() as $slug => $seo) {
            $blog = Blog::query()->where('slug', $slug)->first();

            if ($blog === null) {
                $this->warn("Missing blog slug: {$slug}");
                $missing++;

                continue;
            }

            $this->line(($dryRun ? '[dry-run] ' : '')."Updating blog #{$blog->id} ({$slug})");

            if (! $dryRun) {
                $blog->forceFill($seo)->save();
            }

            $updated++;
        }

        $this->info("Done. Updated: {$updated}. Missing: {$missing}.");

        return $missing > 0 && $updated === 0 ? self::FAILURE : self::SUCCESS;
    }
}
