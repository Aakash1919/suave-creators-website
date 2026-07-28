<?php

namespace App\Services;

use App\Mail\SeoAuditReportMail;
use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMXPath;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Throwable;

class SeoAuditReportService
{
    public function __construct(
        protected SitemapService $sitemap,
    ) {}

    /**
     * Crawl every public sitemap URL and build an SEO audit report payload.
     *
     * @return array{
     *     generated_at: string,
     *     base_url: string,
     *     page_count: int,
     *     ok_count: int,
     *     issue_page_count: int,
     *     error_count: int,
     *     warning_count: int,
     *     pages: list<array{
     *         url: string,
     *         title: string,
     *         group: string,
     *         status: int|null,
     *         ok: bool,
     *         issues: list<array{severity: string, check: string, message: string, suggestion: string}>
     *     }>
     * }
     */
    public function generate(): array
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $timeout = max(5, (int) config('seo.audit_report.timeout', 15));
        $delayMs = max(0, (int) config('seo.audit_report.delay_ms', 150));
        $expectedHost = strtolower((string) (parse_url($baseUrl, PHP_URL_HOST) ?: ''));

        $pages = [];
        $errorCount = 0;
        $warningCount = 0;

        foreach ($this->sitemap->entries() as $index => $entry) {
            if ($index > 0 && $delayMs > 0) {
                usleep($delayMs * 1000);
            }

            $url = $this->rewriteToBaseUrl((string) $entry['loc'], $baseUrl);
            $page = $this->auditUrl(
                $url,
                (string) $entry['title'],
                (string) $entry['group'],
                $expectedHost,
                $timeout,
            );

            foreach ($page['issues'] as $issue) {
                if ($issue['severity'] === 'error') {
                    $errorCount++;
                } else {
                    $warningCount++;
                }
            }

            $pages[] = $page;
        }

        $issuePageCount = count(array_filter($pages, static fn (array $page): bool => ! $page['ok']));

        return [
            'generated_at' => Carbon::now()->toIso8601String(),
            'base_url' => $baseUrl,
            'page_count' => count($pages),
            'ok_count' => count($pages) - $issuePageCount,
            'issue_page_count' => $issuePageCount,
            'error_count' => $errorCount,
            'warning_count' => $warningCount,
            'pages' => $pages,
        ];
    }

    /**
     * @return array{
     *     url: string,
     *     title: string,
     *     group: string,
     *     status: int|null,
     *     ok: bool,
     *     issues: list<array{severity: string, check: string, message: string, suggestion: string}>
     * }
     */
    protected function auditUrl(
        string $url,
        string $title,
        string $group,
        string $expectedHost,
        int $timeout,
    ): array {
        $issues = [];
        $status = null;

        try {
            $fetched = $this->fetchPage($url, $timeout);
            $status = $fetched['status'];
            $html = $fetched['body'];

            if ($status !== 200) {
                $issues[] = $this->issue(
                    'error',
                    'status',
                    "HTTP {$status} (expected 200)",
                    'Confirm the route still exists, fix broken redirects, and ensure the page returns 200 for crawlers. Remove the URL from the sitemap if it should not be indexed.'
                );

                return $this->pageResult($url, $title, $group, $status, $issues);
            }

            $issues = array_merge($issues, $this->analyzeHtml($html, $url, $expectedHost));
        } catch (ConnectionException $e) {
            $issues[] = $this->issue(
                'error',
                'status',
                'Connection failed: '.$e->getMessage(),
                'Ensure APP_URL is correct and the site is reachable from this server (web server running, DNS, firewall, and SSL). On local `php artisan serve`, the auditor uses in-process requests automatically — re-run after updating.'
            );
        } catch (Throwable $e) {
            $issues[] = $this->issue(
                'error',
                'status',
                'Request failed: '.$e->getMessage(),
                'Retry the crawl after fixing network/server errors. Check application logs for the failing URL.'
            );
        }

        return $this->pageResult($url, $title, $group, $status, $issues);
    }

    /**
     * Fetch page HTML via HTTP, or in-process for localhost (avoids artisan serve deadlock).
     *
     * @return array{status: int, body: string}
     *
     * @throws ConnectionException
     */
    protected function fetchPage(string $url, int $timeout): array
    {
        if ($this->shouldFetchInternally($url)) {
            return $this->fetchInternally($url);
        }

        $response = Http::withHeaders([
            'User-Agent' => 'SuaveCreatorsSeoAudit/1.0',
            'Accept' => 'text/html,application/xhtml+xml',
        ])
            ->timeout($timeout)
            ->withOptions(['allow_redirects' => true])
            ->get($url);

        return [
            'status' => $response->status(),
            'body' => $response->body(),
        ];
    }

    /**
     * Local APP_URL hosts cannot be crawled over HTTP from the same single-threaded PHP server.
     */
    protected function shouldFetchInternally(string $url): bool
    {
        $host = strtolower((string) (parse_url($url, PHP_URL_HOST) ?: ''));

        return in_array($host, ['127.0.0.1', 'localhost', '::1'], true);
    }

    /**
     * Render the page through the HTTP kernel (no outbound socket).
     *
     * @return array{status: int, body: string}
     *
     * @throws ConnectionException
     */
    protected function fetchInternally(string $url): array
    {
        /** @var HttpKernel $kernel */
        $kernel = app(HttpKernel::class);
        $current = $url;
        $maxRedirects = 5;

        for ($i = 0; $i <= $maxRedirects; $i++) {
            $parts = parse_url($current);
            if ($parts === false || empty($parts['host'])) {
                throw new ConnectionException("Invalid audit URL: {$current}");
            }

            $path = $parts['path'] ?? '/';
            $query = isset($parts['query']) ? '?'.$parts['query'] : '';
            $uri = $path.$query;
            $port = isset($parts['port']) ? (string) $parts['port'] : '';
            $hostHeader = $parts['host'].($port !== '' ? ':'.$port : '');

            $request = Request::create($uri, 'GET', [], [], [], [
                'HTTP_HOST' => $hostHeader,
                'HTTP_USER_AGENT' => 'SuaveCreatorsSeoAudit/1.0',
                'HTTP_ACCEPT' => 'text/html,application/xhtml+xml',
                'SERVER_NAME' => $parts['host'],
                'SERVER_PORT' => $port !== '' ? $port : (($parts['scheme'] ?? 'http') === 'https' ? '443' : '80'),
                'HTTPS' => ($parts['scheme'] ?? 'http') === 'https' ? 'on' : 'off',
            ]);

            $response = $kernel->handle($request);
            $status = $response->getStatusCode();

            if (in_array($status, [301, 302, 303, 307, 308], true) && $response->headers->has('Location')) {
                $location = (string) $response->headers->get('Location');
                $kernel->terminate($request, $response);
                $current = $this->resolveRedirectUrl($current, $location);
                continue;
            }

            $body = $response->getContent();
            $kernel->terminate($request, $response);

            return [
                'status' => $status,
                'body' => is_string($body) ? $body : '',
            ];
        }

        throw new ConnectionException("Too many redirects while auditing {$url}");
    }

    /**
     * Resolve a redirect Location against the current absolute URL.
     */
    protected function resolveRedirectUrl(string $current, string $location): string
    {
        $location = trim($location);
        if ($location === '') {
            return $current;
        }

        if (preg_match('#^https?://#i', $location) === 1) {
            return $location;
        }

        $base = parse_url($current);
        $scheme = $base['scheme'] ?? 'http';
        $host = $base['host'] ?? '127.0.0.1';
        $port = isset($base['port']) ? ':'.$base['port'] : '';
        $origin = "{$scheme}://{$host}{$port}";

        if (str_starts_with($location, '/')) {
            return $origin.$location;
        }

        $path = $base['path'] ?? '/';
        $dir = str_contains($path, '/') ? substr($path, 0, (int) strrpos($path, '/') + 1) : '/';

        return $origin.$dir.$location;
    }

    /**
     * @return list<array{severity: string, check: string, message: string, suggestion: string}>
     */
    protected function analyzeHtml(string $html, string $pageUrl, string $expectedHost): array
    {
        $issues = [];
        $dom = $this->loadDom($html);

        if ($dom === null) {
            $issues[] = $this->issue(
                'error',
                'html',
                'Could not parse HTML',
                'Ensure the page returns valid HTML (not an empty body or binary response). Fix render errors on this route before re-running the audit.'
            );

            return $issues;
        }

        $xpath = new DOMXPath($dom);

        $title = $this->firstText($xpath, '//title');
        if ($title === '') {
            $issues[] = $this->issue(
                'error',
                'title',
                'Missing <title>',
                'Add a unique page title via config/seo.php (pages.{route}) or the page’s seoTitle / Blog SEO fields so layouts/seo.blade.php outputs <title>.'
            );
        } else {
            $len = mb_strlen($title);
            if ($len < 30 || $len > 60) {
                $issues[] = $this->issue(
                    'warning',
                    'title',
                    "Title length {$len} (recommended 30–60)",
                    $len < 30
                        ? 'Lengthen the title with a clear primary keyword and brand (aim for about 50–60 characters) in config/seo.php or the page SEO fields.'
                        : 'Shorten the title to roughly 50–60 characters so it is not truncated in search results; keep the primary keyword near the front.'
                );
            }
        }

        $description = $this->metaContent($xpath, 'name', 'description');
        if ($description === '') {
            $issues[] = $this->issue(
                'error',
                'meta_description',
                'Missing meta description',
                'Set a meta description in config/seo.php, SeoGenerateService overrides, or the Blog “meta description” field so <meta name="description"> is rendered.'
            );
        } else {
            $len = mb_strlen($description);
            if ($len < 70 || $len > 160) {
                $issues[] = $this->issue(
                    'warning',
                    'meta_description',
                    "Meta description length {$len} (recommended 70–160)",
                    $len < 70
                        ? 'Expand the meta description into a compelling 1–2 sentence summary (about 120–155 characters) that includes the main keyword and a call to action.'
                        : 'Trim the meta description to about 155 characters so Google does not truncate it; keep the value proposition in the first line.'
                );
            }
        }

        $canonical = $this->linkHref($xpath, 'canonical');
        if ($canonical === '') {
            $issues[] = $this->issue(
                'error',
                'canonical',
                'Missing canonical link',
                'Ensure SeoGenerateService / layouts/seo.blade.php always outputs <link rel="canonical" href="..."> pointing at the preferred absolute URL for this page.'
            );
        } else {
            $canonicalHost = strtolower((string) (parse_url($canonical, PHP_URL_HOST) ?: ''));
            if ($expectedHost !== '' && $canonicalHost !== '' && $canonicalHost !== $expectedHost) {
                $issues[] = $this->issue(
                    'error',
                    'canonical',
                    "Canonical host \"{$canonicalHost}\" does not match APP_URL host \"{$expectedHost}\"",
                    'Generate the canonical from APP_URL / url() / route() so the host matches production. Fix hardcoded absolute URLs or a wrong APP_URL in .env.'
                );
            }
        }

        $h1Count = $xpath->query('//h1')?->length ?? 0;
        if ($h1Count === 0) {
            $issues[] = $this->issue(
                'error',
                'h1',
                'Missing H1',
                'Add one clear H1 in the page Blade template (usually the main headline) that matches the page topic and primary keyword.'
            );
        } elseif ($h1Count > 1) {
            $issues[] = $this->issue(
                'warning',
                'h1',
                "Found {$h1Count} H1 tags (expected 1)",
                'Keep a single H1 for the main heading and demote extra headings to H2/H3 in the Blade/section components.'
            );
        }

        foreach (['og:title', 'og:description', 'og:image'] as $property) {
            if ($this->metaContent($xpath, 'property', $property) === '') {
                $issues[] = $this->issue(
                    'error',
                    'open_graph',
                    "Missing {$property}",
                    match ($property) {
                        'og:title' => 'Set og_title / seoTitle so SeoGenerateService fills og:title (falls back to the page title).',
                        'og:description' => 'Set og_description / meta description so og:description is populated in layouts/seo.blade.php.',
                        default => 'Provide an OG image via config/seo.php default_og_image or the page/blog featured image so og:image is output.',
                    }
                );
            }
        }

        foreach (['twitter:card', 'twitter:title', 'twitter:description'] as $name) {
            if ($this->metaContent($xpath, 'name', $name) === '') {
                $issues[] = $this->issue(
                    'warning',
                    'twitter',
                    "Missing {$name}",
                    match ($name) {
                        'twitter:card' => 'Ensure layouts/seo.blade.php always outputs twitter:card (e.g. summary_large_image).',
                        'twitter:title' => 'Populate twitter title from the page title / og:title via SeoGenerateService.',
                        default => 'Populate twitter:description from the meta/OG description so social previews are complete.',
                    }
                );
            }
        }

        $robots = strtolower($this->metaContent($xpath, 'name', 'robots'));
        if ($robots !== '' && str_contains($robots, 'noindex')) {
            $issues[] = $this->issue(
                'error',
                'robots',
                "Sitemap URL is noindex ({$robots})",
                'Change robots to "index, follow" in config/seo.php (or the page override) if this URL should rank, or remove it from SitemapService so it is not listed in sitemap.xml.'
            );
        }

        $jsonLd = $xpath->query('//script[@type="application/ld+json"]');
        if ($jsonLd === null || $jsonLd->length === 0) {
            $issues[] = $this->issue(
                'warning',
                'json_ld',
                'Missing JSON-LD structured data',
                'Ensure SeoGenerateService builds jsonLd for this route and layouts/seo.blade.php prints the application/ld+json script (Organization, WebPage, FAQ, Article, etc.).'
            );
        }

        $missingAlt = $this->imagesMissingAlt($xpath);
        if ($missingAlt > 0) {
            $issues[] = $this->issue(
                'warning',
                'images',
                "{$missingAlt} image(s) missing alt attribute on {$pageUrl}",
                'Add descriptive, keyword-aware alt text on every <img> (or decorative alt="") in the Blade/components for this page. Prefer SEO-friendly filenames and alts per the frontend skill.'
            );
        }

        return $issues;
    }

    protected function loadDom(string $html): ?DOMDocument
    {
        if (trim($html) === '') {
            return null;
        }

        $dom = new DOMDocument;
        $previous = libxml_use_internal_errors(true);

        try {
            $loaded = $dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_NOWARNING | LIBXML_NOERROR);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        return $loaded ? $dom : null;
    }

    protected function rewriteToBaseUrl(string $loc, string $baseUrl): string
    {
        $path = parse_url($loc, PHP_URL_PATH) ?: '/';
        $query = parse_url($loc, PHP_URL_QUERY);
        $url = $baseUrl.$path;

        if (is_string($query) && $query !== '') {
            $url .= '?'.$query;
        }

        return $url;
    }

    /**
     * @param  list<array{severity: string, check: string, message: string, suggestion: string}>  $issues
     * @return array{
     *     url: string,
     *     title: string,
     *     group: string,
     *     status: int|null,
     *     ok: bool,
     *     issues: list<array{severity: string, check: string, message: string, suggestion: string}>
     * }
     */
    protected function pageResult(
        string $url,
        string $title,
        string $group,
        ?int $status,
        array $issues,
    ): array {
        return [
            'url' => $url,
            'title' => $title,
            'group' => $group,
            'status' => $status,
            'ok' => $issues === [],
            'issues' => $issues,
        ];
    }

    /**
     * @return array{severity: string, check: string, message: string, suggestion: string}
     */
    protected function issue(string $severity, string $check, string $message, string $suggestion): array
    {
        return [
            'severity' => $severity,
            'check' => $check,
            'message' => $message,
            'suggestion' => $suggestion,
        ];
    }

    protected function firstText(DOMXPath $xpath, string $query): string
    {
        $nodes = $xpath->query($query);
        if (! $nodes instanceof DOMNodeList || $nodes->length === 0) {
            return '';
        }

        $node = $nodes->item(0);
        if (! $node instanceof DOMElement) {
            return '';
        }

        return trim($node->textContent ?? '');
    }

    protected function metaContent(DOMXPath $xpath, string $attr, string $value): string
    {
        $query = sprintf(
            '//meta[translate(@%s, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")=%s]/@content',
            $attr,
            $this->xpathLiteral(strtolower($value)),
        );
        $nodes = $xpath->query($query);
        if (! $nodes instanceof DOMNodeList || $nodes->length === 0) {
            return '';
        }

        return trim((string) $nodes->item(0)?->nodeValue);
    }

    protected function linkHref(DOMXPath $xpath, string $rel): string
    {
        $query = sprintf(
            '//link[translate(@rel, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")=%s]/@href',
            $this->xpathLiteral(strtolower($rel)),
        );
        $nodes = $xpath->query($query);
        if (! $nodes instanceof DOMNodeList || $nodes->length === 0) {
            return '';
        }

        return trim((string) $nodes->item(0)?->nodeValue);
    }

    protected function imagesMissingAlt(DOMXPath $xpath): int
    {
        $images = $xpath->query('//img');
        if (! $images instanceof DOMNodeList) {
            return 0;
        }

        $missing = 0;
        foreach ($images as $img) {
            if (! $img instanceof DOMElement) {
                continue;
            }
            if (! $img->hasAttribute('alt')) {
                $missing++;
            }
        }

        return $missing;
    }

    protected function xpathLiteral(string $value): string
    {
        if (! str_contains($value, "'")) {
            return "'{$value}'";
        }

        if (! str_contains($value, '"')) {
            return '"'.$value.'"';
        }

        $parts = explode("'", $value);
        $concat = [];
        foreach ($parts as $i => $part) {
            if ($part !== '') {
                $concat[] = "'{$part}'";
            }
            if ($i < count($parts) - 1) {
                $concat[] = '"\'"';
            }
        }

        return 'concat('.implode(', ', $concat).')';
    }

    /**
     * Crawl, then deliver the report via the configured mailer.
     *
     * @return array<string, mixed>
     */
    public function generateAndDeliver(): array
    {
        $report = $this->generate();
        $this->deliver($report);

        return $report;
    }

    /**
     * Email (or log) an audit report payload.
     *
     * @param  array<string, mixed>  $report
     */
    public function deliver(array $report): void
    {
        $to = (string) config('seo.audit_report.to', 'info@suavecreators.com');
        if ($to === '') {
            throw new InvalidArgumentException('No recipient configured. Set SEO_AUDIT_REPORT_TO.');
        }

        $mailer = (string) config('seo.audit_report.mailer', 'log');

        Mail::mailer($mailer)->to($to)->send(new SeoAuditReportMail(
            $report,
            $this->toMarkdown($report),
        ));
    }

    /**
     * Build a plain-text / Markdown full report for email attachment.
     *
     * @param  array<string, mixed>  $report
     */
    public function toMarkdown(array $report): string
    {
        $lines = [
            '# SEO Audit Report',
            '',
            '- Generated: '.($report['generated_at'] ?? ''),
            '- Base URL: '.($report['base_url'] ?? ''),
            '- Pages crawled: '.($report['page_count'] ?? 0),
            '- Pages OK: '.($report['ok_count'] ?? 0),
            '- Pages with issues: '.($report['issue_page_count'] ?? 0),
            '- Errors: '.($report['error_count'] ?? 0),
            '- Warnings: '.($report['warning_count'] ?? 0),
            '',
        ];

        /** @var list<array<string, mixed>> $pages */
        $pages = $report['pages'] ?? [];

        foreach ($pages as $page) {
            if (! empty($page['ok'])) {
                continue;
            }

            $status = $page['status'] ?? 'n/a';
            $lines[] = '## '.($page['title'] ?? 'Untitled');
            $lines[] = '';
            $lines[] = '- URL: '.($page['url'] ?? '');
            $lines[] = '- Group: '.($page['group'] ?? '');
            $lines[] = '- HTTP: '.$status;
            $lines[] = '';

            /** @var list<array{severity: string, check: string, message: string, suggestion: string}> $issues */
            $issues = $page['issues'] ?? [];
            foreach ($issues as $issue) {
                $lines[] = sprintf(
                    '- **%s** [%s] %s',
                    strtoupper((string) $issue['severity']),
                    $issue['check'],
                    $issue['message'],
                );
                if (! empty($issue['suggestion'])) {
                    $lines[] = '  - **How to fix:** '.$issue['suggestion'];
                }
            }
            $lines[] = '';
        }

        if ((int) ($report['issue_page_count'] ?? 0) === 0) {
            $lines[] = 'All crawled pages passed the SEO checks.';
            $lines[] = '';
        }

        return implode("\n", $lines);
    }
}
