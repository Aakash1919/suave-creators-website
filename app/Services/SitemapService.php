<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Support\Frontend\CaseStudySupport;
use App\Support\Frontend\IndustryDetailSupport;
use App\Support\Frontend\ServiceSupport;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

class SitemapService
{
    /**
     * Build every public indexable URL for sitemap / llm.txt.
     *
     * @return list<array{loc: string, lastmod: ?string, changefreq: string, priority: string, title: string, group: string}>
     */
    public function entries(): array
    {
        if (config('seo.noindex')) {
            return [];
        }

        $entries = [];

        foreach ($this->staticPages() as $page) {
            logger($page);
            $entries[] = $this->entry(
                route($page['route']),
                $page['title'],
                $page['group'],
                $page['changefreq'],
                $page['priority'],
                null
            );
        }

        foreach (ServiceSupport::SLUGS as $slug) {
            $service = ServiceSupport::service($slug);
            $entries[] = $this->entry(
                route('service.show', ['slug' => $slug]),
                $this->pageLabel($service, $slug),
                'Services',
                'weekly',
                '0.8',
                null
            );
        }

        foreach (array_keys(IndustryDetailSupport::SLUG_FILES) as $slug) {
            $industry = IndustryDetailSupport::industry($slug);
            $entries[] = $this->entry(
                route('industry.show', ['slug' => $slug]),
                $this->pageLabel($industry, $slug),
                'Industries',
                'weekly',
                '0.8',
                null
            );
        }

        BlogCategory::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['name', 'slug', 'updated_at'])
            ->each(function (BlogCategory $category) use (&$entries): void {
                $entries[] = $this->entry(
                    route('blogs.category', ['slug' => $category->slug]),
                    'Blog category: '.$category->name,
                    'Blog',
                    'weekly',
                    '0.6',
                    $category->updated_at
                );
            });

        Blog::query()
            ->published()
            ->orderByDesc('published_at')
            ->get(['slug', 'title', 'updated_at', 'published_at'])
            ->each(function (Blog $blog) use (&$entries): void {
                $entries[] = $this->entry(
                    route('blog.show', ['slug' => $blog->slug]),
                    (string) $blog->title,
                    'Blog',
                    'monthly',
                    '0.7',
                    $blog->updated_at ?? $blog->published_at
                );
            });

        foreach (CaseStudySupport::cases() as $caseStudy) {
            $entries[] = $this->entry(
                (string) ($caseStudy['url'] ?? CaseStudySupport::urlForSlug((string) ($caseStudy['slug'] ?? ''))),
                (string) ($caseStudy['title'] ?? ''),
                'Case Studies',
                'monthly',
                '0.7',
                null
            );
        }

        return $entries;
    }

    public function toXml(): string
    {
        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($this->entries() as $entry) {
            $lines[] = '  <url>';
            $lines[] = '    <loc>'.$this->xml($entry['loc']).'</loc>';
            if ($entry['lastmod'] !== null) {
                $lines[] = '    <lastmod>'.$this->xml($entry['lastmod']).'</lastmod>';
            }
            $lines[] = '    <changefreq>'.$this->xml($entry['changefreq']).'</changefreq>';
            $lines[] = '    <priority>'.$this->xml($entry['priority']).'</priority>';
            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines)."\n";
    }

    /**
     * Human / LLM-oriented site map (Markdown).
     */
    public function toLlmText(): string
    {
        $site = config('seo.site', []);
        $org = is_array($site['organization'] ?? null) ? $site['organization'] : [];
        $name = (string) ($site['name'] ?? 'Suave Creators');
        $tagline = (string) ($site['tagline'] ?? '');
        $description = (string) ($site['default_description'] ?? '');

        $grouped = [];
        foreach ($this->entries() as $entry) {
            $grouped[$entry['group']][] = $entry;
        }

        $lines = [
            '# '.$name,
            '',
            '> '.($tagline !== '' ? $tagline : $description),
            '',
            $description,
            '',
            '## About',
            '',
            $name.' builds custom software, CRM systems, e-commerce platforms, enterprise applications, and digital growth solutions for startups and enterprises worldwide.',
            '',
            '## Primary pages',
            '',
        ];

        foreach ($grouped['Primary'] ?? [] as $entry) {
            $lines[] = '- ['.$entry['title'].']('.$entry['loc'].')';
        }

        if (! empty($grouped['Services'])) {
            $lines[] = '';
            $lines[] = '## Services';
            $lines[] = '';
            foreach ($grouped['Services'] as $entry) {
                $lines[] = '- ['.$entry['title'].']('.$entry['loc'].')';
            }
        }

        if (! empty($grouped['Industries'])) {
            $lines[] = '';
            $lines[] = '## Industries';
            $lines[] = '';
            foreach ($grouped['Industries'] as $entry) {
                $lines[] = '- ['.$entry['title'].']('.$entry['loc'].')';
            }
        }

        if (! empty($grouped['Blog'])) {
            $lines[] = '';
            $lines[] = '## Blog';
            $lines[] = '';
            foreach ($grouped['Blog'] as $entry) {
                $lines[] = '- ['.$entry['title'].']('.$entry['loc'].')';
            }
        }

        if (! empty($grouped['Legal'])) {
            $lines[] = '';
            $lines[] = '## Legal';
            $lines[] = '';
            foreach ($grouped['Legal'] as $entry) {
                $lines[] = '- ['.$entry['title'].']('.$entry['loc'].')';
            }
        }

        $email = (string) ($org['email'] ?? 'Info@suavecreators.com');
        $phone = (string) ($org['telephone'] ?? '');
        $lines[] = '';
        $lines[] = '## Contact';
        $lines[] = '';
        $lines[] = '- Website: '.rtrim((string) config('app.url'), '/');
        $lines[] = '- Contact page: '.route('contact-us');
        $lines[] = '- Email: '.$email;
        if ($phone !== '') {
            $lines[] = '- Phone: '.$phone;
        }
        $lines[] = '';
        $lines[] = '## Machine-readable sitemap';
        $lines[] = '';
        $lines[] = '- XML sitemap: '.$this->siteUrl('/sitemap.xml');
        $lines[] = '- This file: '.$this->siteUrl('/llm.txt');
        $lines[] = '';

        return implode("\n", $lines);
    }

    public function robotsTxt(): string
    {
        if (config('seo.noindex')) {
            return implode("\n", [
                'User-agent: *',
                'Disallow: /',
                '',
            ]);
        }

        return implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /suave-agent',
            '',
            'Sitemap: '.$this->siteUrl('/sitemap.xml'),
            '# LLM discovery: '.$this->siteUrl('/llm.txt'),
            '',
        ]);
    }

    /**
     * @return list<array{route: string, title: string, group: string, changefreq: string, priority: string}>
     */
    protected function staticPages(): array
    {
        return [
            ['route' => 'home', 'title' => 'Home', 'group' => 'Primary', 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['route' => 'about-us', 'title' => 'About us', 'group' => 'Primary', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['route' => 'services', 'title' => 'Services', 'group' => 'Primary', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['route' => 'industries', 'title' => 'Industries', 'group' => 'Primary', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['route' => 'product', 'title' => 'Product', 'group' => 'Primary', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['route' => 'case-studies', 'title' => 'Case studies', 'group' => 'Primary', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['route' => 'blogs', 'title' => 'Blog', 'group' => 'Primary', 'changefreq' => 'daily', 'priority' => '0.8'],
            ['route' => 'contact-us', 'title' => 'Contact us', 'group' => 'Primary', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['route' => 'privacy-policy', 'title' => 'Privacy policy', 'group' => 'Legal', 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['route' => 'terms-and-conditions', 'title' => 'Terms & conditions', 'group' => 'Legal', 'changefreq' => 'yearly', 'priority' => '0.3'],
        ];
    }

    /**
     * @return array{loc: string, lastmod: ?string, changefreq: string, priority: string, title: string, group: string}
     */
    protected function entry(
        string $loc,
        string $title,
        string $group,
        string $changefreq,
        string $priority,
        CarbonInterface|Carbon|null $lastmod
    ): array {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod?->toAtomString(),
            'changefreq' => $changefreq,
            'priority' => $priority,
            'title' => $title,
            'group' => $group,
        ];
    }

    protected function xml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    protected function siteUrl(string $path = '/'): string
    {
        return rtrim((string) config('app.url', url('/')), '/').'/'.ltrim($path, '/');
    }

    /**
     * @param  array<string, mixed>|null  $page
     */
    protected function pageLabel(?array $page, string $fallback): string
    {
        if ($page === null) {
            return $fallback;
        }

        foreach (['pageTitle', 'ogTitle', 'title', 'name', 'introTitle'] as $key) {
            $value = $page[$key] ?? null;
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
            if (is_array($value)) {
                $joined = trim(implode(' ', array_map(static fn ($part): string => (string) $part, $value)));
                if ($joined !== '') {
                    return $joined;
                }
            }
        }

        return $fallback;
    }
}
