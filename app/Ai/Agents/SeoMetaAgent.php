<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

#[Model('gpt-4o-mini')]
#[MaxTokens(1024)]
#[Temperature(0.4)]
#[Timeout(60)]
class SeoMetaAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function __construct(
        public ?string $modelOverride = null,
    ) {}

    /**
     * Prefer config/env model when set.
     */
    public function model(): ?string
    {
        $override = is_string($this->modelOverride) ? trim($this->modelOverride) : '';

        return $override !== '' ? $override : null;
    }

    /**
     * Instructions for blog SEO / Open Graph copy only.
     */
    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
You write SEO and Open Graph fields for Suave Creators blog posts (custom software, web development, CRM, e-commerce, enterprise software, AI solutions).

Rules:
- Output ONLY the four SEO fields requested — no blog body, no FAQs.
- Match the post’s topic and tone; second person when natural.
- Do not invent fake statistics, client names, pricing, or SLAs.
- meta_title: clear primary keywords; 50–60 characters (hard max 60). Do not append "| Suave Creators Blog".
- meta_description: 140–160 characters ideal (hard max 160); benefit-led summary that encourages the click.
- og_title: social-friendly title — usually match meta_title or a slightly tighter variant (max 60).
- og_description: similar to meta_description; may be slightly punchier for social (max 160).
- Avoid keyword stuffing and duplicate filler.
PROMPT;
    }

    /**
     * Structured SEO fields for the admin form (not persisted by the agent).
     *
     * @return array<string, mixed>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'meta_title' => $schema->string()->min(30)->max(60)->required(),
            'meta_description' => $schema->string()->min(70)->max(160)->required(),
            'og_title' => $schema->string()->min(30)->max(60)->required(),
            'og_description' => $schema->string()->min(70)->max(160)->required(),
        ];
    }
}
