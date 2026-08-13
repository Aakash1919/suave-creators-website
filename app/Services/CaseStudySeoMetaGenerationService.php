<?php

namespace App\Services;

use App\Ai\Agents\CaseStudySeoMetaAgent;
use App\Models\CaseStudy;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class CaseStudySeoMetaGenerationService
{
    /**
     * Generate SEO / OG field values from the current case study (and optional form overrides).
     * Does not persist — the editor reviews and saves manually.
     *
     * @param  array{
     *     title?: string|null,
     *     short_description?: string|null,
     *     client?: string|null,
     *     industry?: string|null,
     *     challenge?: string|null,
     *     solution?: string|null,
     *     outcome?: string|null
     * }  $overrides
     * @return array{meta_title: string, meta_description: string, og_title: string, og_description: string}
     *
     * @throws RuntimeException
     */
    public function generate(CaseStudy $caseStudy, array $overrides = []): array
    {
        $title = $this->resolveText($overrides['title'] ?? null, (string) $caseStudy->title);
        $short = $this->resolveText($overrides['short_description'] ?? null, (string) $caseStudy->short_description);
        $client = $this->resolveText($overrides['client'] ?? null, (string) $caseStudy->client);
        $industry = $this->resolveText($overrides['industry'] ?? null, (string) $caseStudy->industry);
        $challenge = $this->resolveText($overrides['challenge'] ?? null, (string) $caseStudy->challenge);
        $solution = $this->resolveText($overrides['solution'] ?? null, (string) $caseStudy->solution);
        $outcome = $this->resolveText($overrides['outcome'] ?? null, (string) $caseStudy->outcome);

        if ($title === '') {
            throw new RuntimeException('Add a case study title before generating SEO meta.');
        }

        $model = (string) config('case-studies.seo_meta.model', 'gpt-4o-mini');
        $excerpt = $this->contentExcerpt($challenge, $solution, $outcome);

        try {
            $response = (new CaseStudySeoMetaAgent(
                modelOverride: $model,
            ))->prompt(
                $this->userPrompt($title, $short, $client, $industry, $excerpt),
                model: $model !== '' ? $model : null,
                timeout: 60,
            );
        } catch (Throwable $e) {
            throw new RuntimeException('AI SEO meta generation failed: '.$e->getMessage(), 0, $e);
        }

        return $this->normalizeFields($this->structuredPayload($response), $title, $short);
    }

    /**
     * Generate SEO / OG fields and persist them on the case study.
     *
     * @param  array{
     *     title?: string|null,
     *     short_description?: string|null,
     *     client?: string|null,
     *     industry?: string|null,
     *     challenge?: string|null,
     *     solution?: string|null,
     *     outcome?: string|null
     * }  $overrides
     * @return array{meta_title: string, meta_description: string, og_title: string, og_description: string}
     *
     * @throws RuntimeException
     */
    public function regenerateAndSave(CaseStudy $caseStudy, array $overrides = []): array
    {
        $seo = $this->generate($caseStudy, $overrides);
        $caseStudy->forceFill($seo)->save();

        return $seo;
    }

    /**
     * Build the user prompt from the case study context.
     */
    protected function userPrompt(
        string $title,
        string $short,
        string $client,
        string $industry,
        string $excerpt,
    ): string {
        $metaLines = [];
        if ($client !== '') {
            $metaLines[] = "Client: {$client}";
        }
        if ($industry !== '') {
            $metaLines[] = "Industry: {$industry}";
        }
        $metaBlock = $metaLines !== [] ? implode("\n", $metaLines)."\n" : '';
        $shortBlock = $short !== '' ? $short : '(none)';
        $excerptBlock = $excerpt !== '' ? $excerpt : '(no overview yet)';

        return <<<PROMPT
Generate meta_title, meta_description, og_title, and og_description for this Suave Creators case study.

Title: {$title}
{$metaBlock}Short description:
{$shortBlock}

Overview excerpt (challenge / solution / outcome):
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
     * Flatten overview fields into a plain-text excerpt for the prompt.
     */
    protected function contentExcerpt(string $challenge, string $solution, string $outcome): string
    {
        $parts = [];
        if ($challenge !== '') {
            $parts[] = 'Challenge: '.$challenge;
        }
        if ($solution !== '') {
            $parts[] = 'Solution: '.$solution;
        }
        if ($outcome !== '') {
            $parts[] = 'Outcome: '.$outcome;
        }

        $text = trim(implode("\n\n", $parts));
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
            $metaTitle = $title;
        }

        $metaDescription = trim((string) ($payload['meta_description'] ?? ''));
        if ($metaDescription === '' && $short !== '') {
            $metaDescription = $short;
        }

        $ogTitle = trim((string) ($payload['og_title'] ?? ''));
        if ($ogTitle === '') {
            $ogTitle = $metaTitle !== '' ? $metaTitle : $title;
        }

        $ogDescription = trim((string) ($payload['og_description'] ?? ''));
        if ($ogDescription === '') {
            $ogDescription = $metaDescription !== '' ? $metaDescription : $short;
        }

        if ($metaDescription === '' || $ogDescription === '') {
            throw new RuntimeException('AI returned incomplete SEO meta. Try again after adding a short description or more overview content.');
        }

        return [
            'meta_title' => Str::limit($metaTitle, 60, ''),
            'meta_description' => Str::limit($metaDescription, 160, ''),
            'og_title' => Str::limit($ogTitle, 60, ''),
            'og_description' => Str::limit($ogDescription, 160, ''),
        ];
    }
}
