<?php

namespace App\Jobs;

use App\Services\CrmLeadSyncService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class SyncWebsiteLeadToCrmJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 30;

    public int $backoff = 30;

    /**
     * Capture the website source key for a best-effort CRM upsert.
     */
    public function __construct(
        public readonly string $source,
        public readonly string $sourceId,
        public readonly ?string $firstInboundBody = null,
    ) {}

    /**
     * POST the lead payload to the CRM webhook.
     */
    public function handle(CrmLeadSyncService $crmLeadSyncService): void
    {
        $crmLeadSyncService->sync($this->source, $this->sourceId, $this->firstInboundBody);
    }

    /**
     * Log permanent failure without affecting the visitor.
     */
    public function failed(?Throwable $exception): void
    {
        report($exception);
    }
}
