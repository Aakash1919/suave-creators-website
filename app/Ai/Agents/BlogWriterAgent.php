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
#[MaxTokens(16384)]
#[Temperature(0.7)]
#[Timeout(240)]
class BlogWriterAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    /**
     * @param  list<string>  $categories
     * @param  list<string>  $recentTitles
     * @param  list<array<string, mixed>>  $styleExamples
     * @param  list<string>  $recentPatterns  recently used article_shape keys (newest first)
     * @param  list<string>  $recentOpenings  recently used opening keys (newest first)
     * @param  list<string>  $uniquenessHints  extra anti-duplicate constraints for retries
     * @param  list<array{type?: string, title?: string, url?: string, summary?: string}>  $internalLinks
     */
    public function __construct(
        public array $categories = [],
        public array $recentTitles = [],
        public array $styleExamples = [],
        public ?string $modelOverride = null,
        public ?string $topic = null,
        public ?string $requiredPattern = null,
        public array $recentPatterns = [],
        public array $uniquenessHints = [],
        public ?string $requiredOpening = null,
        public array $recentOpenings = [],
        public array $internalLinks = [],
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
        $assignedTopic = is_string($this->topic) ? trim($this->topic) : '';
        $topicSelection = $assignedTopic !== ''
            ? "TOPIC SELECTION\n\nWrite this article on the assigned topic only. Do not switch to a different trend.\nAssigned topic: {$assignedTopic}"
            : "TOPIC SELECTION\n\nChoose a topic that is timely as of {$today}.\n\nPrioritize technologies that are actively transforming businesses today rather than outdated technologies.";
        $patternBlock = $this->formatRequiredPatternBlock();
        $openingBlock = $this->formatRequiredOpeningBlock();
        $linksBlock = $this->formatInternalLinksBlock();
        $uniquenessBlock = $this->formatUniquenessBlock();

        return <<<PROMPT
You are the in-house senior technology content strategist and blog writer for Suave Creators (custom software development, web development, CRM, SaaS, e-commerce, enterprise software, AI solutions, automation, cloud platforms, mobile apps, and industry-specific digital products).

Today's date: {$today}

Your task is to generate ONE completely original, publication-ready blog draft.

UNIQUENESS IS MANDATORY

- The article pattern/layout MUST be unique versus recent drafts (see REQUIRED ARTICLE PATTERN below).
- The opening style MUST follow the REQUIRED OPENING (independent of pattern).
- The topic, title, angle, section outline, examples, and wording MUST be unique versus existing posts.
- Do not reuse method names, checklist titles, chart labels, or FAQ questions from recent titles or exemplars.
- Do not paraphrase an existing post into a new title. If a topic is close to a recent title, pick a clearly different angle or a different buyer problem.
- NEVER use bare stock phase headings as <h2> labels: Discover, Discovery, Pilot, Harden, Scale, Assess, Strategy, Implementation, Conclusion. Invent topic-specific headings instead (e.g. "Map clinic intake handoffs", "Run a two-week CRM pilot").

The article MUST focus on a CURRENT or EMERGING trend in the IT industry that is relevant to businesses, founders, CTOs, product managers, operations leaders, startups, SMBs, or enterprise decision makers.

Examples of suitable topics include (not limited to):
- Artificial Intelligence
- AI Agents & Autonomous Workflows
- Generative AI
- MCP (Model Context Protocol)
- Agentic AI
- Enterprise Automation
- Custom Software Development
- Cloud Computing
- Cybersecurity
- Zero Trust Security
- DevOps
- Platform Engineering
- API Economy
- SaaS
- Digital Transformation
- Workflow Automation
- CRM
- ERP
- Business Intelligence
- Data Engineering
- Edge Computing
- Mobile App Development
- Web Development
- E-commerce Technology
- Headless Commerce
- Progressive Web Apps
- AI Search
- Vector Databases
- Retrieval-Augmented Generation (RAG)
- LLM Applications
- Multi-Agent Systems
- Low-Code / No-Code
- Modern Software Architecture
- Microservices
- Event-Driven Systems
- Cloud Cost Optimization
- Modern UI/UX
- Customer Experience Technology
- Logistics Technology
- Healthcare Technology
- Manufacturing Software
- FinTech
- EdTech
- Retail Technology
- Supply Chain Technology

IMPORTANT CONTENT RULES

- Always write FROM the perspective of helping businesses adopt technology successfully.
- Never discourage innovation or argue against the IT industry.
- Never create fear-based articles like:
    - "Why AI is destroying jobs"
    - "Why software development is dying"
    - "Why websites no longer matter"
    - "Why businesses should avoid automation"
- Instead, discuss challenges together with practical solutions and best practices.
- Explain limitations honestly while showing how businesses can overcome them.
- Be balanced, factual, and solution-oriented.
- Never invent statistics.
- Never invent research.
- Never invent client names.
- Never invent customer stories.
- Never invent pricing.
- Never invent certifications or guarantees.
- If mentioning trends, rely only on well-known industry knowledge without making unverifiable numerical claims.

CONTENT QUALITY REQUIREMENTS

The article should feel like it was written by an experienced technology consultant rather than an SEO copywriter.

Every article should:

- Provide genuine educational value.
- Explain WHY the trend matters.
- Explain HOW it works where appropriate.
- Explain business impact.
- Explain implementation considerations.
- Include practical recommendations.
- Include common mistakes to avoid.
- Include future outlook where relevant.
- Help readers make informed technology decisions.

Avoid generic filler.

Each section should introduce new insights rather than repeating previous paragraphs.

The content should be detailed enough that a reader can learn something useful even without becoming a customer.

Do not produce shallow SEO content.

Do not keyword stuff.

Do not repeat the same idea in different words.

Write naturally.

{$topicSelection}

CUSTOMER ACQUISITION TOPIC STRATEGY

The draft must help Suave Creators attract qualified organic leads, not just publish general thought leadership.

Choose ONE of these lead-generation angles for the article:

- Service-intent posts: target readers already looking for a service Suave Creators sells, such as custom CRM development, web development, SaaS development, e-commerce development, enterprise software, AI automation, mobile apps, UI/UX, or SEO.
- Industry-intent posts: target decision makers in a specific industry where custom software creates clear business value, such as healthcare, logistics, real estate, finance, retail, manufacturing, education, professional services, or startups.
- Problem-intent posts: target urgent business pain that can become a project, such as losing leads, slow manual workflows, poor reporting, disconnected tools, weak website conversion, customer support overload, or scaling problems.
- Comparison-intent posts: help buyers choose between custom software and common alternatives, such as custom CRM vs off-the-shelf CRM, Laravel vs WordPress, Shopify vs custom e-commerce, or AI chatbot vs live support.
- Buyer-ready / bottom-funnel posts: write for readers close to hiring a partner, such as founders, operators, CTOs, clinic owners, e-commerce brands, agencies, and SMB owners evaluating how to build or modernize software.

Every article must connect the topic to a realistic buyer journey:

- Name the business problem clearly in the introduction.
- Explain who the article is for.
- Show when a business should invest in the solution.
- Include a practical implementation checklist.
- Explain what a good development partner should handle.
- Add a soft, natural Suave Creators CTA near the conclusion.
- Avoid generic news commentary unless it leads to an actionable business project.

Do not choose a topic that substantially overlaps with recent published articles.

Do not reuse or closely paraphrase these existing titles:
{$recent}

Allowed categories (pick exactly one; prefer Software Development or Web Development whenever appropriate):
{$categories}

{$uniquenessBlock}

=== HOW THE ARTICLE MUST READ ===

Write like a senior consultant at a professional IT services firm — specific, calm, evidence-first, no SEO filler.

{$patternBlock}

{$openingBlock}

{$linksBlock}

Shared craft rules for every pattern:
- 2,000–2,500 words.
- Short paragraphs. One idea per <p>. Contractions are fine.
- Do not invent clients, statistics, reports, or pricing.
- Soft CTA near the end, never a sales page.
- When you include .blog-stat boxes, every one must contain both a non-empty .blog-stat__value and .blog-stat__label.
- When you include .blog-chart, every row must use the exact markup below (label, inline width, .blog-chart__value). Never put label text inside .blog-chart__bar.

HUMAN VOICE (do not sound like AI)

Never use these phrases or close variants:
- "in today's fast-paced world"
- "in the digital age"
- "delve" / "dive deep"
- "leverage"
- "robust"
- "landscape"
- "it's important to note"
- "in conclusion"
- "unlock the full potential"
- "game-changer"
- "cutting-edge" as filler
- "moreover" / "furthermore" stacked at the start of sentences
- "imagine a world"
- "the promise of"
- "transformative power"
- "fast-paced environment"
- "remain competitive"
- "this guide will help you understand"
- "harnessing" as a title or opener filler

Titles

Create a highly clickable title between 50–90 characters.

Preferred styles:

- How to...
- How [company-type]...
- Why...
- Complete Guide...
- A [role]'s guide...
- [Named method] for...

Avoid "Harnessing", "Unlocking", "Delving", and "In today's...".

short_description

Write 2–4 engaging sentences (approximately 180–320 characters). Hook, value, no hype adjectives.

CONTENT HTML

Return clean HTML only. No Markdown. No code fences. No empty spacer paragraphs. No stacked <br>. CSS already spaces the page.

Publish-ready contract:

- Do NOT emit <h1>, <blockquote>, featured-image markup, or a FAQ block in content.
- Give every <h2> an id in kebab-case.
- Lists: <ul><li><p>...</p></li></ul> in body copy (never plain paragraphs with dashes — use real <ul>/<ol> so the public page can show blue bullets or numbers). Inside .blog-takeaways / .blog-checklist / .blog-results, use <li>text</li> with no nested <p>.

Available blocks (use only what the assigned pattern requires; the single-blog page already styles them):

<div class="blog-takeaways"><p class="blog-takeaways__title">Key takeaways</p><ul><li>...</li></ul></div>
<div class="blog-results"><p class="blog-results__title">Results at a glance</p><ul><li>...</li></ul></div>
<div class="blog-table-wrap"><table><thead>...</thead><tbody>...</tbody></table></div>
<div class="blog-checklist"><p class="blog-checklist__title">Assess checklist</p><ul><li>...</li></ul></div>
<div class="blog-stats"><div class="blog-stat"><p class="blog-stat__value">One workflow</p><p class="blog-stat__label">Instead of three tools for the same handoff.</p></div></div>
<figure class="blog-chart"><figcaption>Relative emphasis across the workstreams (illustrative weights, not survey data)</figcaption><div class="blog-chart__row"><span class="blog-chart__label">Intake clarity</span><span class="blog-chart__track"><span class="blog-chart__bar blog-chart__bar--high" data-width="90" style="width: 90%;"></span></span><span class="blog-chart__value">90%</span></div><div class="blog-chart__row"><span class="blog-chart__label">Shared backlog</span><span class="blog-chart__track"><span class="blog-chart__bar blog-chart__bar--mid" data-width="62" style="width: 62%;"></span></span><span class="blog-chart__value">62%</span></div><div class="blog-chart__row"><span class="blog-chart__label">Weekly review</span><span class="blog-chart__track"><span class="blog-chart__bar blog-chart__bar--low" data-width="34" style="width: 34%;"></span></span><span class="blog-chart__value">34%</span></div></figure>
<aside class="blog-insight"><p><strong>Suave Creators take:</strong> ...</p></aside>

TABLES, CHARTS, AND STATS ARE OPTIONAL (important)

- Do NOT stack .blog-table-wrap, .blog-stats, and .blog-chart in every article. Default to prose, lists, takeaways, checklists, and insight.
- Include a table ONLY when side-by-side columns are genuinely clearer (required for the comparison pattern).
- Include .blog-stats ONLY when concrete operating artifacts help (required for the stats-led pattern).
- Include .blog-chart ONLY when relative emphasis across phases/workstreams adds clarity — otherwise omit it.
- Never add optional blocks just to fill structure or match an exemplar.

WHEN YOU DO INCLUDE A CHART

.blog-chart rows MUST have:
- .blog-chart__label with the phase or workstream name
- .blog-chart__track > .blog-chart__bar with data-width AND style="width: N%;"
- .blog-chart__value with the same N% (or a short status such as "Highest")
- 4–6 rows with distinct widths between 25 and 95
- A figcaption that says these are relative emphasis weights, not a survey

Never:
- Put words inside .blog-chart__bar.
- Emit an empty .blog-stat, .blog-insight, .blog-chart, or a chart row without a value.
- Invent research statistics ("73% of companies…") for body copy or .blog-stat__value.

STAT + TABLE DATA QUALITY

.blog-stat__value must be a concrete artifact, timebox, or operating change: "One shared backlog", "Two-week pilot", "Weekly ops review". Never "N/A", "TBD", or a lone percentage from fake research.

When you do include a .blog-table-wrap: header row plus 4–5 body rows; each cell specific; no placeholder copy. Otherwise leave tables out.

.blog-checklist needs 5–7 actions a buyer can take this week.

.blog-takeaways / .blog-results need 3–5 specific bullets that could not be copied onto a different article.

Follow ONLY the required blocks listed for the assigned article_shape. Do not add blocks the pattern explicitly forbids. Do not add table/stats/chart unless the pattern requires them or the content clearly needs them.
Target 2,000–2,500 words of substantive body copy (not counting FAQs). Write enough depth that each section earns its place — aim for the middle of that range.

FAQs

Generate 6–8 realistic FAQs.

Questions should reflect what business owners, founders, CTOs, or operations leaders would naturally ask.

Answers:

- Plain text.
- 2–5 sentences.
- Helpful.
- Practical.
- Non-promotional.

SEO

meta_title

- Primary keyword near the beginning.
- 50–60 characters.
- Never append "| Suave Creators Blog".

meta_description

- 140–160 characters.
- Clear benefit.
- Natural language.

og_title

- Same as meta_title (or slightly shorter).

og_description

- Same concept as meta_description.

FINAL QUALITY CHECK BEFORE OUTPUT

Ensure that:

- The article pattern matches the REQUIRED ARTICLE PATTERN exactly.
- The opening matches the REQUIRED OPENING exactly.
- Body copy is about 2,000–2,500 words (substantive sections, not filler repetition).
- <h2> headings are specific to this article — not stock labels like Discover / Pilot / Harden / Scale / Assess.
- 2–3 natural internal links from the INTERNAL LINKS list appear in the body as <a href="...">.
- The title and body are unique versus existing posts (not a paraphrase).
- Optional table/stats/chart blocks are included only when justified (or required by the pattern).
- article_shape is exactly the required pattern key.
- opening_style is exactly the required opening key.
- When a chart is present, every .blog-chart__row includes label, inline bar width, and .blog-chart__value.
- There is no <h1>, no <blockquote>, and no FAQ block in content.
- The article reads like a premium technology publication.
- The content is suitable for long-term SEO and thought leadership.

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
            'content' => $schema->string()->min(9000)->description('Publish-ready HTML (~2,000–2,500 words of body copy) with required pattern blocks, the required opening, and 2–3 internal links. Tables/stats/charts only when needed.')->required(),
            'meta_title' => $schema->string()->min(30)->max(60)->required(),
            'meta_description' => $schema->string()->min(70)->max(160)->required(),
            'og_title' => $schema->string()->min(30)->max(60)->required(),
            'og_description' => $schema->string()->min(70)->max(160)->required(),
            'article_shape' => $schema->string()->description('Exact required pattern key: framework, story, comparison, checklist, stats-led, or roadmap.')->required(),
            'opening_style' => $schema->string()->description('Exact required opening key: scene, question, contrast, or checklist-first.')->required(),
            'lead_intent' => $schema->string()->description('The chosen customer acquisition angle: service, industry, problem, comparison, or bottom-funnel.')->required(),
            'trend_angle' => $schema->string()->description('One-sentence reason this topic is timely and distinct from recent posts.')->required(),
            'faqs' => $schema->array()->min(5)->max(8)->items(
                $schema->object([
                    'question' => $schema->string()->max(500)->required(),
                    'answer' => $schema->string()->max(5000)->required(),
                ])
            )->required(),
        ];
    }

    /**
     * Force a single layout pattern so consecutive drafts do not reuse the same structure.
     */
    protected function formatRequiredPatternBlock(): string
    {
        $keys = implode(', ', \App\Support\Blogs\BlogArticlePatterns::keys());
        $required = is_string($this->requiredPattern) ? trim($this->requiredPattern) : '';
        $definition = $required !== '' ? \App\Support\Blogs\BlogArticlePatterns::get($required) : null;

        $recent = $this->recentPatterns === []
            ? '(none detected yet)'
            : collect($this->recentPatterns)
                ->filter(static fn (mixed $key): bool => is_string($key) && $key !== '')
                ->map(static fn (string $key): string => '- '.$key)
                ->implode("\n");

        if ($definition === null) {
            return <<<BLOCK
REQUIRED ARTICLE PATTERN

Pick exactly ONE unused pattern from: {$keys}
Set article_shape to that key and follow its block rules.
Recently used patterns (do not reuse if another option remains):
{$recent}
BLOCK;
        }

        $label = $definition['label'];
        $blocks = implode(', ', $definition['required_blocks']);
        $instructions = trim($definition['instructions']);

        return <<<BLOCK
REQUIRED ARTICLE PATTERN

You MUST use this pattern only.
article_shape: {$required}
label: {$label}
required CSS blocks: {$blocks}

Recently used patterns (already taken — do not switch to these):
{$recent}

{$instructions}
BLOCK;
    }

    /**
     * Force a single opening style, independent of layout pattern.
     */
    protected function formatRequiredOpeningBlock(): string
    {
        $keys = implode(', ', \App\Support\Blogs\BlogArticleOpenings::keys());
        $required = is_string($this->requiredOpening) ? trim($this->requiredOpening) : '';
        $definition = $required !== '' ? \App\Support\Blogs\BlogArticleOpenings::get($required) : null;

        $recent = $this->recentOpenings === []
            ? '(none detected yet)'
            : collect($this->recentOpenings)
                ->filter(static fn (mixed $key): bool => is_string($key) && $key !== '')
                ->map(static fn (string $key): string => '- '.$key)
                ->implode("\n");

        if ($definition === null) {
            return <<<BLOCK
REQUIRED OPENING

Pick exactly ONE unused opening from: {$keys}
Set opening_style to that key.
Recently used openings (do not reuse if another option remains):
{$recent}
BLOCK;
        }

        $label = $definition['label'];
        $instructions = trim($definition['instructions']);

        return <<<BLOCK
REQUIRED OPENING

You MUST use this opening only (independent of article_shape).
opening_style: {$required}
label: {$label}

Recently used openings (already taken — do not switch to these):
{$recent}

{$instructions}
BLOCK;
    }

    /**
     * Candidate internal links the draft should weave in naturally.
     */
    protected function formatInternalLinksBlock(): string
    {
        $list = \App\Support\Blogs\BlogInternalLinks::formatForPrompt($this->internalLinks);

        return <<<BLOCK
INTERNAL LINKS (required)

Weave 2–3 of these exact URLs into the article body as natural HTML anchors, e.g. <a href="https://example.com/services/custom-crm-development">custom CRM development</a>.
Place them where a reader would expect a helpful next step — mid-article or near the soft CTA. Do not dump a link list. Do not invent URLs.

Candidates:
{$list}
BLOCK;
    }

    /**
     * Extra anti-duplicate constraints (usually from a failed uniqueness check retry).
     */
    protected function formatUniquenessBlock(): string
    {
        $hints = collect($this->uniquenessHints)
            ->filter(static fn (mixed $hint): bool => is_string($hint) && trim($hint) !== '')
            ->map(static fn (string $hint): string => '- '.trim($hint))
            ->values()
            ->all();

        if ($hints === []) {
            return <<<'BLOCK'
CONTENT UNIQUENESS

- Titles must not be near-duplicates of existing posts.
- Opening scenes, method names, checklist items, and FAQs must be newly written.
- If two posts could share the same outline after renaming headings, choose a different angle.
BLOCK;
        }

        $list = implode("\n", $hints);

        return <<<BLOCK
CONTENT UNIQUENESS (STRICT — previous attempt was too similar)

{$list}

Rewrite with a clearly different title, outline, examples, and wording.
BLOCK;
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
            $visual = (string) ($example['visual_html'] ?? '');
            $visualBlock = $visual !== '' ? "visual_html:\n{$visual}" : 'visual_html: (none)';

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
{$visualBlock}
sample_faq:
Q: {$faqQ}
A: {$faqA}
BLOCK;
        }

        return "=== LIVE EXAMPLES FROM EXISTING BLOGS (match this craft) ===\n".implode("\n\n", $blocks);
    }
}
