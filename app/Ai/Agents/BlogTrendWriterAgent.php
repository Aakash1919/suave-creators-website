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
#[MaxTokens(8192)]
#[Temperature(0.7)]
#[Timeout(180)]
class BlogTrendWriterAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    /**
     * @param  list<string>  $categories
     * @param  list<string>  $recentTitles
     * @param  list<array<string, mixed>>  $styleExamples
     */
    public function __construct(
        public array $categories = [],
        public array $recentTitles = [],
        public array $styleExamples = [],
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
     * Instructions mirrored from existing Suave Creators blog posts.
     */
    public function instructions(): Stringable|string
    {
        $today = now()->toDateString();
        $categories = $this->categories === []
            ? 'Software Development, Web Development, Uncategorized'
            : implode(', ', $this->categories);
        $recent = $this->recentTitles === []
            ? '(none yet)'
            : collect($this->recentTitles)
                ->map(static fn (string $title): string => '- '.$title)
                ->implode("\n");
        $examples = $this->formatStyleExamples();

        return <<<PROMPT
You are the in-house blog writer for Suave Creators (custom software, web development, CRM, e-commerce, enterprise software, AI solutions, and industry-specific digital products).

Today's date: {$today}

Your job is to write ONE new draft that reads like it belongs on the existing Suave Creators blog — same voice, title style, HTML structure, FAQ style, and SEO habits as the examples below. Ground the topic in a current / emerging industry trend relevant to business owners, founders, and ops/product leaders. Do not invent fake statistics, client names, pricing, or SLAs.

Do not reuse or closely paraphrase these existing titles:
{$recent}

Allowed categories (pick exactly one; prefer Software Development or Web Development when the topic fits):
{$categories}

=== STYLE GUIDE FROM EXISTING POSTS ===
Voice:
- Second person ("you" / "your business"), direct, practical, conversational — not academic.
- Short punchy paragraphs mixed with numbered sections and bullet lists.
- Benefit-led framing: growth, revenue, friction, scale, systems, UX, e-commerce, custom software.
- Soft brand mention is OK near the end (e.g. how Suave Creators helps) — never hard-sell.

Titles:
- Long, specific, benefit-driven (about 50–90 characters).
- Common patterns: "Why…", "How to…", "Top N…", "Your…", "Fix…", "The ROI of…", "… in 2026".

short_description:
- 2–4 sentences (~180–320 characters) that hook the reader and preview the payoff.
- May mention Suave Creators when natural.

content HTML (required patterns):
- Clean HTML only — no Markdown, no code fences.
- Start with an optional <h1> matching the title OR jump straight into short <p> hooks.
- Use 4–7 <h2> sections; nest numbered <h3> items when listing signs/steps/features.
- Prefer lists as <ul><li><p>…</p></li></ul> (this matches existing posts).
- Include a closing section such as "The Bottom Line", "How Suave Creators Helps…", or a practical checklist CTA.
- Target roughly 1000–1600 words (~4500–7000 characters of visible text).

faqs:
- 5–8 Q&A pairs that a business owner would actually ask after reading.
- Answers: plain text, concrete, 2–5 sentences.

SEO:
- meta_title: "{title} | Suave Creators Blog" (trim if needed; keep useful keywords).
- meta_description: usually mirrors / tightens the short_description.
- og_title: same as the post title (or a slightly shorter variant).
- og_description: same idea as meta_description.

{$examples}
PROMPT;
    }

    /**
     * Structured draft fields persisted by BlogDraftGenerationService.
     *
     * @return array<string, mixed>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->min(30)->max(120)->required(),
            'short_description' => $schema->string()->min(120)->max(450)->required(),
            'category' => $schema->string()->required(),
            'content' => $schema->string()->min(2000)->required(),
            'meta_title' => $schema->string()->max(120)->required(),
            'meta_description' => $schema->string()->max(320)->required(),
            'og_title' => $schema->string()->max(120)->required(),
            'og_description' => $schema->string()->max(300)->required(),
            'trend_angle' => $schema->string()->description('One-sentence reason this topic is timely.')->required(),
            'faqs' => $schema->array()->min(5)->max(8)->items(
                $schema->object([
                    'question' => $schema->string()->max(500)->required(),
                    'answer' => $schema->string()->max(5000)->required(),
                ])
            )->required(),
        ];
    }

    /**
     * Render exemplar posts for the system prompt.
     */
    protected function formatStyleExamples(): string
    {
        if ($this->styleExamples === []) {
            return <<<'FALLBACK'
=== EXAMPLE PATTERNS (no live exemplars loaded) ===
Title: Fix Your Systems, Unlock Your Growth: Why Your Business Software Is Silently Killing Your Scale
short_description: Your business is growing, but your software isn't keeping up. Slow tools, broken integrations, and manual processes are quietly eating your revenue…
Sections: The Business That Almost Broke… → 5 Signs… → What the Right Enterprise Solution Changes → How Suave Creators Helps → The Bottom Line
FALLBACK;
        }

        $blocks = [];
        foreach ($this->styleExamples as $index => $example) {
            $n = $index + 1;
            $title = (string) ($example['title'] ?? '');
            $category = (string) ($example['category'] ?? '');
            $short = (string) ($example['short_description'] ?? '');
            $headings = (string) ($example['headings'] ?? '');
            $opening = (string) ($example['opening_html'] ?? '');
            $faqQ = (string) ($example['sample_faq_question'] ?? '');
            $faqA = (string) ($example['sample_faq_answer'] ?? '');
            $metaTitle = (string) ($example['meta_title'] ?? '');

            $blocks[] = <<<BLOCK
--- Example {$n} ---
title: {$title}
category: {$category}
meta_title: {$metaTitle}
short_description: {$short}
heading_outline:
{$headings}
opening_html:
{$opening}
sample_faq:
Q: {$faqQ}
A: {$faqA}
BLOCK;
        }

        return "=== LIVE EXAMPLES FROM EXISTING BLOGS (match this craft) ===\n".implode("\n\n", $blocks);
    }
}
