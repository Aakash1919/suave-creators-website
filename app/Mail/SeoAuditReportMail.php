<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SeoAuditReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{
     *     generated_at: string,
     *     base_url: string,
     *     page_count: int,
     *     ok_count: int,
     *     issue_page_count: int,
     *     error_count: int,
     *     warning_count: int,
     *     pages: list<array<string, mixed>>
     * }  $report
     */
    public function __construct(
        public array $report,
        public string $markdownReport,
    ) {}

    public function envelope(): Envelope
    {
        $issues = (int) ($this->report['issue_page_count'] ?? 0);
        $pages = (int) ($this->report['page_count'] ?? 0);
        $subject = $issues === 0
            ? sprintf('SEO Audit Report — all clear (%d pages)', $pages)
            : sprintf('SEO Audit Report — %d page(s) with issues', $issues);

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.seo-audit-report',
            with: [
                'report' => $this->report,
            ],
        );
    }

    /**
     * @return list<Attachment>
     */
    public function attachments(): array
    {
        $date = now()->format('Y-m-d');

        return [
            Attachment::fromData(
                fn (): string => $this->markdownReport,
                "seo-audit-report-{$date}.md",
            )->withMime('text/markdown'),
        ];
    }
}
