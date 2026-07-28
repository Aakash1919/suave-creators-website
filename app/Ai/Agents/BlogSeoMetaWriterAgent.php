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
class BlogSeoMetaWriterAgent implements Agent, HasStructuredOutput
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
- meta_title: clear primary keywords + brand; prefer ending with "| Suave Creators Blog" (trim to stay useful within ~50–60 visible characters when possible; hard max 120).
- meta_description: 140–160 characters ideal (hard max 320); benefit-led summary that encourages the click.
- og_title: social-friendly title — usually the post title or a slightly tighter variant (max 120). Do not force the "| Suave Creators Blog" suffix on OG title.
- og_description: similar to meta_description; may be slightly punchier for social (max 300).
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
            'meta_title' => $schema->string()->min(20)->max(120)->required(),
            'meta_description' => $schema->string()->min(80)->max(320)->required(),
            'og_title' => $schema->string()->min(10)->max(120)->required(),
            'og_description' => $schema->string()->min(80)->max(300)->required(),
        ];
    }
}
