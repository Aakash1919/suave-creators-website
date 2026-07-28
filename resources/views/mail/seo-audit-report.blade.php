<x-mail::message>
# SEO Audit Report

Crawled **{{ $report['base_url'] }}** on {{ \Illuminate\Support\Carbon::parse($report['generated_at'])->toDayDateTimeString() }}.

| Metric | Count |
|:-------|------:|
| Pages crawled | {{ $report['page_count'] }} |
| Pages OK | {{ $report['ok_count'] }} |
| Pages with issues | {{ $report['issue_page_count'] }} |
| Errors | {{ $report['error_count'] }} |
| Warnings | {{ $report['warning_count'] }} |

@if ($report['issue_page_count'] === 0)
All crawled pages passed the on-page SEO checks.
@else
## Pages with issues

@foreach ($report['pages'] as $page)
@continue($page['ok'])
### {{ $page['title'] }}

- **URL:** {{ $page['url'] }}
- **Group:** {{ $page['group'] }}
- **HTTP:** {{ $page['status'] ?? 'n/a' }}

@foreach ($page['issues'] as $issue)
- **{{ strtoupper($issue['severity']) }}** `[{{ $issue['check'] }}]` {{ $issue['message'] }}
@if (! empty($issue['suggestion']))
  - **How to fix:** {{ $issue['suggestion'] }}
@endif
@endforeach

@endforeach
@endif

A full Markdown report is attached.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
