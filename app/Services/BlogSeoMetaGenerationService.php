<?php

namespace App\Services;

use App\Ai\Agents\BlogSeoMetaWriterAgent;
use App\Models\Blog;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class BlogSeoMetaGenerationService
{
    /**
     * Generate SEO / OG field values from the current post (and optional form overrides).
     * Does not persist — the editor reviews and saves manually.
     *
     * @param  array{title?: string|null, short_description?: string|null, content?: string|null}  $overrides
     * @return array{meta_title: string, meta_description: string, og_title: string, og_description: string}
     *
     * @throws RuntimeException
     */
    public function generate(Blog $blog, array $overrides = []): array
    {
        $title = $this->resolveText($overrides['title'] ?? null, (string) $blog->title);
        $short = $this->resolveText($overrides['short_description'] ?? null, (string) $blog->short_description);
        $content = $this->resolveText($overrides['content'] ?? null, (string) $blog->content);

        if ($title === '') {
            throw new RuntimeException('Add a blog title before generating SEO meta.');
        }

        $model = (string) config('blogs.seo_meta.model', config('blogs.trend_drafts.model', 'gpt-4o-mini'));
        $excerpt = $this->contentExcerpt($content);

        try {
            $response = (new BlogSeoMetaWriterAgent(
                modelOverride: $model,
            ))->prompt(
                $this->userPrompt($title, $short, $excerpt, $blog),
                model: $model !== '' ? $model : null,
                timeout: 60,
            );
        } catch (Throwable $e) {
            throw new RuntimeException('AI SEO meta generation failed: '.$e->getMessage(), 0, $e);
        }

        return $this->normalizeFields($this->structuredPayload($response), $title, $short);
    }

    /**
     * Build the user prompt from the post context.
     */
    protected function userPrompt(string $title, string $short, string $excerpt, Blog $blog): string
    {
        $category = trim((string) ($blog->category?->name ?? ''));
        $categoryLine = $category !== '' ? "Category: {$category}\n" : '';
        $shortBlock = $short !== '' ? $short : '(none)';
        $excerptBlock = $excerpt !== '' ? $excerpt : '(no content yet)';

        return <<<PROMPT
Generate meta_title, meta_description, og_title, and og_description for this Suave Creators blog post.

Title: {$title}
{$categoryLine}Short description:
{$shortBlock}

Content excerpt (plain text):
{$excerptBlock}
PROMPT;
    }

    /**
     * Prefer non-empty override text; otherwise fall back to the saved value.
     */
    protected function resolveText(mixed $override, string $fallback): string
    {
        if (is_string($override) && trim($override) !== '') {
            return trim($override);
        }

        return trim($fallback);
    }

    /**
     * Strip HTML and truncate content for the prompt.
     */
    protected function contentExcerpt(string $html): string
    {
        $text = trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return Str::limit($text, 2500, '');
    }

    /**
     * Normalize StructuredAgentResponse / array-like AI output.
     *
     * @return array<string, mixed>
     */
    protected function structuredPayload(mixed $response): array
    {
        if (is_array($response)) {
            return $response;
        }

        if (is_object($response) && method_exists($response, 'toArray')) {
            /** @var array<string, mixed> $array */
            $array = $response->toArray();

            return $array;
        }

        throw new RuntimeException('AI returned an unexpected response type for SEO meta output.');
    }

    /**
     * Clamp and backfill SEO fields for the form.
     *
     * @param  array<string, mixed>  $payload
     * @return array{meta_title: string, meta_description: string, og_title: string, og_description: string}
     */
    protected function normalizeFields(array $payload, string $title, string $short): array
    {
        $metaTitle = trim((string) ($payload['meta_title'] ?? ''));
        if ($metaTitle === '') {
            $metaTitle = $title.' | Suave Creators Blog';
        } elseif (! str_contains(Str::lower($metaTitle), 'suave creators')) {
            $metaTitle = rtrim($metaTitle, " \t|-").' | Suave Creators Blog';
        }

        $metaDescription = trim((string) ($payload['meta_description'] ?? ''));
        if ($metaDescription === '' && $short !== '') {
            $metaDescription = $short;
        }

        $ogTitle = trim((string) ($payload['og_title'] ?? ''));
        if ($ogTitle === '') {
            $ogTitle = $title;
        }

        $ogDescription = trim((string) ($payload['og_description'] ?? ''));
        if ($ogDescription === '') {
            $ogDescription = $metaDescription !== '' ? $metaDescription : $short;
        }

        if ($metaDescription === '' || $ogDescription === '') {
            throw new RuntimeException('AI returned incomplete SEO meta. Try again after adding a short description or more content.');
        }

        return [
            'meta_title' => Str::limit($metaTitle, 120, ''),
            'meta_description' => Str::limit($metaDescription, 320, ''),
            'og_title' => Str::limit($ogTitle, 120, ''),
            'og_description' => Str::limit($ogDescription, 300, ''),
        ];
    }
}
