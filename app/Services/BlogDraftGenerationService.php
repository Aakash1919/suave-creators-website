<?php

namespace App\Services;

use App\Ai\Agents\BlogWriterAgent;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Support\Blogs\BlogArticleOpenings;
use App\Support\Blogs\BlogArticlePatterns;
use App\Support\Blogs\BlogInternalLinks;
use App\Support\Frontend\BlogSupport;
use App\Support\SiteAdmin;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class BlogDraftGenerationService
{
    /**
     * Patterns already assigned during the current multi-draft run.
     *
     * @var list<string>
     */
    protected array $patternsUsedThisRun = [];

    /**
     * Openings already assigned during the current multi-draft run.
     *
     * @var list<string>
     */
    protected array $openingsUsedThisRun = [];

    public function __construct(
        protected BlogService $blogs,
    ) {}

    /**
     * Generate and persist one AI trend blog as a draft, styled like existing posts.
     *
     * Enforces a unique article layout pattern + opening style versus recent posts,
     * weaves suggested internal links, and rejects near-duplicate titles/content.
     *
     * @throws RuntimeException
     */
    public function generateDraft(?string $topic = null): Blog
    {
        $topic = is_string($topic) ? trim($topic) : '';
        $topic = $topic !== '' ? $topic : null;
        $categories = $this->preferredCategoryNames();
        $recentTitles = $this->recentTitles();
        $styleExamples = $this->styleExamples();
        $recentPatterns = $this->recentPatterns();
        $recentOpenings = $this->recentOpenings();
        $requiredPattern = BlogArticlePatterns::chooseNext($recentPatterns, $this->patternsUsedThisRun);
        $requiredOpening = BlogArticleOpenings::chooseNext($recentOpenings, $this->openingsUsedThisRun);
        $internalLinks = BlogInternalLinks::suggest(
            title: $topic ?? 'custom software web development CRM AI',
            content: '',
            topic: $topic,
            limit: 3,
        );
        $model = (string) config('blogs.trend_drafts.model', 'gpt-4o-mini');
        $maxAttempts = max(1, (int) config('blogs.trend_drafts.uniqueness_max_attempts', 3));
        $uniquenessHints = [];
        $lastError = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                $response = (new BlogWriterAgent(
                    categories: $categories,
                    recentTitles: $recentTitles,
                    styleExamples: $styleExamples,
                    modelOverride: $model,
                    topic: $topic,
                    requiredPattern: $requiredPattern,
                    recentPatterns: $recentPatterns,
                    uniquenessHints: $uniquenessHints,
                    requiredOpening: $requiredOpening,
                    recentOpenings: $recentOpenings,
                    internalLinks: $internalLinks,
                ))->prompt(
                    $this->userPrompt($styleExamples, $topic, $requiredPattern, $requiredOpening, $uniquenessHints),
                    model: $model !== '' ? $model : null,
                    timeout: 240,
                );

                $payload = $this->structuredPayload($response);
                $this->assertUniqueDraft($payload, $requiredPattern, $requiredOpening);

                $blog = $this->persistDraft($payload);
                $this->patternsUsedThisRun[] = $requiredPattern;
                $this->openingsUsedThisRun[] = $requiredOpening;

                return $blog;
            } catch (Throwable $e) {
                $lastError = $e instanceof RuntimeException
                    ? $e
                    : new RuntimeException('AI blog draft generation failed: '.$e->getMessage(), 0, $e);

                if ($attempt >= $maxAttempts || ! $this->isRetryableUniquenessFailure($lastError)) {
                    throw $lastError;
                }

                $uniquenessHints[] = $lastError->getMessage();
            }
        }

        throw $lastError ?? new RuntimeException('AI blog draft generation failed after uniqueness retries.');
    }

    /**
     * Generate multiple drafts sequentially (each gets a different layout pattern + opening).
     *
     * @return list<Blog>
     *
     * @throws RuntimeException
     */
    public function generateDrafts(int $count = 1, ?string $topic = null): array
    {
        $count = max(1, $count);
        $created = [];
        $this->patternsUsedThisRun = [];
        $this->openingsUsedThisRun = [];

        for ($i = 0; $i < $count; $i++) {
            $created[] = $this->generateDraft($topic);
        }

        return $created;
    }

    /**
     * Category names ordered by how often they appear on existing posts.
     *
     * @return list<string>
     */
    public function preferredCategoryNames(): array
    {
        $fromPosts = Blog::query()
            ->whereNotNull('blog_category_id')
            ->selectRaw('blog_category_id, COUNT(*) as aggregate')
            ->groupBy('blog_category_id')
            ->orderByDesc('aggregate')
            ->pluck('aggregate', 'blog_category_id');

        if ($fromPosts->isNotEmpty()) {
            $names = BlogCategory::query()
                ->whereIn('id', $fromPosts->keys())
                ->get()
                ->sortByDesc(static fn (BlogCategory $category): int => (int) ($fromPosts[$category->id] ?? 0))
                ->pluck('name')
                ->filter(static fn (mixed $name): bool => is_string($name) && trim($name) !== '')
                ->values()
                ->all();

            if ($names !== []) {
                return $names;
            }
        }

        return $this->blogs->categories()
            ->pluck('name')
            ->filter(static fn (mixed $name): bool => is_string($name) && trim($name) !== '')
            ->values()
            ->all();
    }

    /**
     * Recent titles so the model avoids duplicates.
     *
     * @return list<string>
     */
    public function recentTitles(): array
    {
        return Blog::query()
            ->orderByDesc('id')
            ->limit((int) config('blogs.trend_drafts.recent_title_limit', 40))
            ->pluck('title')
            ->filter(static fn (mixed $title): bool => is_string($title) && trim($title) !== '')
            ->values()
            ->all();
    }

    /**
     * Detected layout patterns from the newest posts (newest first).
     *
     * @return list<string>
     */
    public function recentPatterns(): array
    {
        $limit = max(1, (int) config('blogs.trend_drafts.recent_pattern_limit', 12));

        return Blog::query()
            ->orderByDesc('id')
            ->limit($limit)
            ->get(['content'])
            ->map(static function (Blog $blog): ?string {
                return BlogArticlePatterns::detectFromHtml((string) $blog->content);
            })
            ->filter(static fn (mixed $pattern): bool => is_string($pattern) && $pattern !== '')
            ->values()
            ->all();
    }

    /**
     * Detected opening styles from the newest posts (newest first).
     *
     * @return list<string>
     */
    public function recentOpenings(): array
    {
        $limit = max(1, (int) config('blogs.trend_drafts.recent_opening_limit', 12));

        return Blog::query()
            ->orderByDesc('id')
            ->limit($limit)
            ->get(['content'])
            ->map(static function (Blog $blog): ?string {
                return BlogArticleOpenings::detectFromHtml((string) $blog->content);
            })
            ->filter(static fn (mixed $opening): bool => is_string($opening) && $opening !== '')
            ->values()
            ->all();
    }

    /**
     * Pull rich existing posts as style exemplars for the writer agent.
     *
     * @return list<array<string, mixed>>
     */
    public function styleExamples(): array
    {
        $limit = max(1, (int) config('blogs.trend_drafts.style_example_limit', 3));

        $candidates = Blog::query()
            ->with('category')
            ->whereNotNull('content')
            ->where('content', '!=', '')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(40)
            ->get()
            ->filter(static function (Blog $blog): bool {
                return strlen(strip_tags((string) $blog->content)) >= 2500;
            })
            ->values();

        if ($candidates->isEmpty()) {
            return [];
        }

        // Prefer posts that also have FAQs and a short description.
        $ranked = $candidates->sortByDesc(static function (Blog $blog): int {
            $score = strlen(strip_tags((string) $blog->content));
            $score += is_array($blog->faqs) ? count($blog->faqs) * 400 : 0;
            $score += trim((string) $blog->short_description) !== '' ? 800 : 0;
            $score += trim((string) $blog->meta_title) !== '' ? 200 : 0;

            return $score;
        })->values();

        return $ranked
            ->take($limit)
            ->map(fn (Blog $blog): array => $this->summarizeBlogForStyle($blog))
            ->values()
            ->all();
    }

    /**
     * Compact style summary for one existing blog.
     *
     * @return array<string, mixed>
     */
    public function summarizeBlogForStyle(Blog $blog): array
    {
        $content = (string) $blog->content;
        $headings = $this->extractHeadingOutline($content);
        $opening = $this->extractOpeningHtml($content);
        $faqs = is_array($blog->faqs) ? $blog->faqs : [];
        $firstFaq = is_array($faqs[0] ?? null) ? $faqs[0] : [];

        return [
            'title' => (string) $blog->title,
            'category' => (string) ($blog->category?->name ?? 'Uncategorized'),
            'short_description' => Str::limit(trim((string) $blog->short_description), 420, ''),
            'meta_title' => Str::limit(trim((string) $blog->meta_title), 60, ''),
            'headings' => $headings,
            'opening_html' => $opening,
            'visual_html' => $this->extractVisualHtml($content),
            'sample_faq_question' => Str::limit(trim((string) ($firstFaq['question'] ?? '')), 500, ''),
            'sample_faq_answer' => Str::limit(trim((string) ($firstFaq['answer'] ?? '')), 500, ''),
        ];
    }

    /**
     * Reject drafts that miss required pattern/opening blocks or closely duplicate existing content.
     *
     * @param  array<string, mixed>  $payload
     *
     * @throws RuntimeException
     */
    public function assertUniqueDraft(
        array $payload,
        ?string $requiredPattern = null,
        ?string $requiredOpening = null,
    ): void {
        $title = trim((string) ($payload['title'] ?? ''));
        $content = trim((string) ($payload['content'] ?? ''));
        $shape = trim((string) ($payload['article_shape'] ?? ''));
        $opening = trim((string) ($payload['opening_style'] ?? ''));

        if ($title === '' || $content === '') {
            throw new RuntimeException('AI returned an incomplete blog draft (missing title or content).');
        }

        if ($requiredPattern !== null && $requiredPattern !== '') {
            if ($shape !== '' && $shape !== $requiredPattern) {
                throw new RuntimeException(
                    "Draft used article_shape \"{$shape}\" but must use required pattern \"{$requiredPattern}\"."
                );
            }

            if (! BlogArticlePatterns::htmlMatches($requiredPattern, $content)) {
                throw new RuntimeException(
                    "Draft HTML is missing required visual blocks for pattern \"{$requiredPattern}\"."
                );
            }
        }

        if ($requiredOpening !== null && $requiredOpening !== '') {
            if ($opening !== '' && $opening !== $requiredOpening) {
                throw new RuntimeException(
                    "Draft used opening_style \"{$opening}\" but must use required opening \"{$requiredOpening}\"."
                );
            }

            if ($requiredOpening === 'checklist-first'
                && ! preg_match('/class="[^"]*\bblog-checklist\b/i', substr($content, 0, 1500))) {
                throw new RuntimeException(
                    'Draft HTML is missing an early checklist for opening "checklist-first".'
                );
            }
        }

        $stockHeadings = $this->stockPhaseHeadings($content);
        if ($stockHeadings !== []) {
            throw new RuntimeException(
                'Draft uses stock phase headings ('.implode(', ', $stockHeadings).'). Replace them with topic-specific <h2> titles.'
            );
        }

        $titleThreshold = (float) config('blogs.trend_drafts.title_similarity_threshold', 72);
        $contentThreshold = (float) config('blogs.trend_drafts.content_similarity_threshold', 0.42);
        $compareLimit = max(20, (int) config('blogs.trend_drafts.uniqueness_compare_limit', 80));

        $existing = Blog::query()
            ->orderByDesc('id')
            ->limit($compareLimit)
            ->get(['id', 'title', 'content']);

        $normalizedTitle = $this->normalizeForSimilarity($title);

        foreach ($existing as $blog) {
            $existingTitle = trim((string) $blog->title);
            if ($existingTitle === '') {
                continue;
            }

            similar_text($normalizedTitle, $this->normalizeForSimilarity($existingTitle), $percent);
            if ($percent >= $titleThreshold) {
                throw new RuntimeException(
                    "Draft title is too similar to existing blog \"{$existingTitle}\" ({$percent}% match). Choose a clearly different title and angle."
                );
            }
        }

        $draftTokens = $this->contentTokenSet($content);
        if ($draftTokens === []) {
            return;
        }

        foreach ($existing as $blog) {
            $existingContent = trim((string) $blog->content);
            if ($existingContent === '') {
                continue;
            }

            $overlap = $this->tokenOverlapRatio($draftTokens, $this->contentTokenSet($existingContent));
            if ($overlap >= $contentThreshold) {
                $existingTitle = trim((string) $blog->title) ?: ('#'.$blog->id);
                $pct = (int) round($overlap * 100);
                throw new RuntimeException(
                    "Draft content overlaps too much with existing blog \"{$existingTitle}\" (~{$pct}% token overlap). Rewrite with a unique outline and examples."
                );
            }
        }
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

        throw new RuntimeException('AI returned an unexpected response type for structured blog output.');
    }

    /**
     * Map structured AI output into a draft Blog row.
     *
     * @param  array<string, mixed>  $payload
     *
     * @throws RuntimeException
     */
    public function persistDraft(array $payload): Blog
    {
        $title = trim((string) ($payload['title'] ?? ''));
        $content = trim((string) ($payload['content'] ?? ''));

        if ($title === '' || $content === '') {
            throw new RuntimeException('AI returned an incomplete blog draft (missing title or content).');
        }

        $categoryName = trim((string) ($payload['category'] ?? 'Software Development'));
        $category = $this->resolveCategory($categoryName);
        $author = SiteAdmin::resolve();

        $faqs = $this->blogs->normalizeFaqItems($payload['faqs'] ?? null);
        $short = trim((string) ($payload['short_description'] ?? ''));
        $metaDescription = trim((string) ($payload['meta_description'] ?? ''));
        if ($metaDescription === '' && $short !== '') {
            $metaDescription = $short;
        }

        $metaTitle = trim((string) ($payload['meta_title'] ?? ''));
        if ($metaTitle === '') {
            $metaTitle = $title;
        }

        $ogTitle = trim((string) ($payload['og_title'] ?? ''));
        if ($ogTitle === '') {
            $ogTitle = $metaTitle !== '' ? $metaTitle : $title;
        }

        $ogDescription = trim((string) ($payload['og_description'] ?? ''));
        if ($ogDescription === '') {
            $ogDescription = $metaDescription !== '' ? $metaDescription : $short;
        }

        return $this->blogs->createDraft([
            'title' => Str::limit($title, 255, ''),
            'slug' => $this->blogs->uniqueSlug($title),
            'short_description' => Str::limit($short, 1000, ''),
            'content' => $this->normalizeHtmlContent($content),
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'status' => Blog::STATUS_DRAFT,
            'published_at' => null,
            'faqs' => $faqs,
            'meta_title' => $this->nullableLimit($metaTitle, 60),
            'meta_description' => $this->nullableLimit($metaDescription, 160),
            'og_title' => $this->nullableLimit($ogTitle, 60),
            'og_description' => $this->nullableLimit($ogDescription, 160),
        ]);
    }

    /**
     * Match an existing category by name (case-insensitive); avoid inventing rare niches when possible.
     */
    protected function resolveCategory(string $name): BlogCategory
    {
        $name = trim($name) !== '' ? trim($name) : 'Software Development';

        $existing = BlogCategory::query()
            ->get()
            ->first(static fn (BlogCategory $category): bool => strcasecmp($category->name, $name) === 0);

        if ($existing !== null) {
            return $existing;
        }

        // Prefer falling back to the most-used category instead of creating many one-off niches.
        $preferred = $this->preferredCategoryNames()[0] ?? null;
        if (is_string($preferred) && $preferred !== '') {
            $fallback = BlogCategory::query()
                ->get()
                ->first(static fn (BlogCategory $category): bool => strcasecmp($category->name, $preferred) === 0);
            if ($fallback !== null) {
                return $fallback;
            }
        }

        $slugBase = Str::slug($name) ?: 'software-development';
        $slug = $slugBase;
        $i = 2;
        while (BlogCategory::query()->where('slug', $slug)->exists()) {
            $slug = $slugBase.'-'.$i;
            $i++;
        }

        $maxSort = (int) BlogCategory::query()->max('sort_order');

        return BlogCategory::query()->create([
            'name' => $name,
            'slug' => $slug,
            'sort_order' => $maxSort + 1,
        ]);
    }

    /**
     * Strip fences / scripts and make HTML safe to drop into .single-blog-content.
     */
    protected function normalizeHtmlContent(string $html): string
    {
        $html = trim($html);
        $html = (string) preg_replace('/^```(?:html)?\s*/i', '', $html);
        $html = (string) preg_replace('/\s*```$/', '', $html);
        $html = (string) preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html);
        $html = $this->demoteHeadingOnes($html);
        $html = $this->stripEmptySpacerParagraphs($html);
        $html = $this->stripTrailingFaqHtml($html);
        $html = $this->wrapBareTables($html);
        $html = BlogSupport::normalizeVisualHtml($html);

        return trim($html);
    }

    /**
     * Page title is the only H1; leftover model headings become H2.
     */
    protected function demoteHeadingOnes(string $html): string
    {
        $html = (string) preg_replace('/<h1(\b[^>]*)>/i', '<h2$1>', $html);

        return (string) preg_replace('/<\/h1>/i', '</h2>', $html);
    }

    /**
     * Remove empty paragraphs used as fake vertical spacing.
     */
    protected function stripEmptySpacerParagraphs(string $html): string
    {
        $html = (string) preg_replace('/<p>\s*(?:&nbsp;|<br\s*\/?>)*\s*<\/p>/i', '', $html);
        $html = (string) preg_replace('/(?:<br\s*\/?>\s*){2,}/i', '', $html);

        return $html;
    }

    /**
     * FAQs belong in the faqs field; drop a trailing FAQ heading and its body.
     */
    protected function stripTrailingFaqHtml(string $html): string
    {
        if (! preg_match('/<h2\b[^>]*>\s*(?:frequently asked questions|faqs?)\s*<\/h2>/i', $html, $match, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        $heading = $match[0][0];
        $pos = (int) $match[0][1];
        $afterHeading = substr($html, $pos + strlen($heading));

        if (preg_match('/<h2\b/i', $afterHeading)) {
            return $html;
        }

        return trim(substr($html, 0, $pos));
    }

    /**
     * Ensure every table is wrapped for horizontal scroll styling.
     */
    protected function wrapBareTables(string $html): string
    {
        if (! preg_match_all('/<table\b[^>]*>.*?<\/table>/is', $html, $matches, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        $shift = 0;

        foreach ($matches[0] as [$tableHtml, $pos]) {
            $pos += $shift;
            $prefixLength = min(120, $pos);
            $before = substr($html, $pos - $prefixLength, $prefixLength);

            if (preg_match('/<div\b[^>]*class="[^"]*\bblog-table-wrap\b[^"]*"[^>]*>\s*$/i', $before)) {
                continue;
            }

            $wrapped = '<div class="blog-table-wrap">'.$tableHtml.'</div>';
            $html = substr_replace($html, $wrapped, $pos, strlen($tableHtml));
            $shift += strlen($wrapped) - strlen($tableHtml);
        }

        return $html;
    }

    protected function nullableLimit(mixed $value, int $limit): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : Str::limit($trimmed, $limit, '');
    }

    /**
     * @param  list<array<string, mixed>>  $styleExamples
     * @param  list<string>  $uniquenessHints
     */
    protected function userPrompt(
        array $styleExamples,
        ?string $topic = null,
        ?string $requiredPattern = null,
        ?string $requiredOpening = null,
        array $uniquenessHints = [],
    ): string {
        $exampleTitles = collect($styleExamples)
            ->pluck('title')
            ->filter()
            ->map(static fn (mixed $title): string => '- '.(string) $title)
            ->implode("\n");

        $hint = $exampleTitles === ''
            ? 'Match the Suave Creators blog voice described in your instructions.'
            : "Study these live exemplars for craft only — do NOT copy their topic, outline, or wording:\n{$exampleTitles}";

        $topicLine = $topic !== null
            ? "Write this draft on this exact topic (do not switch subjects): {$topic}"
            : 'Pick one timely topic yourself using the TOPIC SELECTION and CUSTOMER ACQUISITION rules. Do not overlap recent titles.';

        $pattern = is_string($requiredPattern) && $requiredPattern !== ''
            ? $requiredPattern
            : 'one unused pattern from the catalog';
        $opening = is_string($requiredOpening) && $requiredOpening !== ''
            ? $requiredOpening
            : 'one unused opening from the catalog';

        $retry = $uniquenessHints === []
            ? ''
            : "\nPrevious attempt failed uniqueness checks. Produce a clearly different title, outline, and body.";

        return <<<PROMPT
Write one new draft blog post for Suave Creators now.
{$topicLine}
{$hint}
REQUIRED: set article_shape to "{$pattern}" and opening_style to "{$opening}". Follow both exactly. Include 2–3 internal links from the provided candidate list. Tables, stats, and charts are optional unless the pattern requires them. Target 2,000–2,500 words of body copy.{$retry}
Return only the structured fields. No h1, no FAQ block, no blockquote. Write like a premium IT services article — specific scenes, calm professional voice, no invented survey statistics.
PROMPT;
    }

    /**
     * Build a compact heading outline from HTML content.
     */
    protected function extractHeadingOutline(string $html): string
    {
        if (! preg_match_all('/<h([1-3])[^>]*>(.*?)<\/h\1>/is', $html, $matches, PREG_SET_ORDER)) {
            return '(no headings found)';
        }

        $lines = [];
        foreach (array_slice($matches, 0, 12) as $match) {
            $level = (string) $match[1];
            $text = trim(html_entity_decode(strip_tags($match[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($text === '') {
                continue;
            }
            $indent = str_repeat('  ', max(0, ((int) $level) - 1));
            $lines[] = $indent.'h'.$level.' '.$text;
        }

        return $lines === [] ? '(no headings found)' : implode("\n", $lines);
    }

    /**
     * First ~900 characters of HTML after stripping scripts — enough to show opening rhythm.
     */
    protected function extractOpeningHtml(string $html): string
    {
        $html = trim((string) preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html));
        $slice = Str::limit($html, 900, '');

        return $slice === '' ? '(empty)' : $slice;
    }

    /**
     * First filled visual block so the model copies real chart / table / stats markup.
     */
    protected function extractVisualHtml(string $html): string
    {
        $pattern = '/<(?:figure|div|aside)\b[^>]*class="[^"]*\b(?:blog-chart|blog-table-wrap|blog-stats|blog-takeaways|blog-results|blog-checklist|blog-insight)\b[^"]*"[^>]*>.*?<\/(?:figure|div|aside)>/is';

        if (! preg_match($pattern, $html, $match)) {
            return '';
        }

        return Str::limit(trim($match[0]), 1600, '');
    }

    protected function isRetryableUniquenessFailure(RuntimeException $error): bool
    {
        $message = strtolower($error->getMessage());

        return str_contains($message, 'too similar')
            || str_contains($message, 'overlaps too much')
            || str_contains($message, 'missing required visual blocks')
            || str_contains($message, 'must use required pattern')
            || str_contains($message, 'must use required opening')
            || str_contains($message, 'missing an early checklist')
            || str_contains($message, 'stock phase headings');
    }

    /**
     * Bare generic phase titles that make consecutive roadmaps look identical.
     *
     * @return list<string>
     */
    protected function stockPhaseHeadings(string $html): array
    {
        if (! preg_match_all('/<h2\b[^>]*>(.*?)<\/h2>/is', $html, $matches)) {
            return [];
        }

        $banned = [
            'discover', 'discovery', 'pilot', 'harden', 'scale', 'assess',
            'strategy', 'implementation', 'conclusion', 'introduction', 'overview',
        ];

        $found = [];
        foreach ($matches[1] as $raw) {
            $text = strtolower(trim(html_entity_decode(strip_tags($raw), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
            $text = (string) preg_replace('/[^a-z0-9\s]+/u', '', $text);
            $text = trim((string) preg_replace('/\s+/u', ' ', $text));
            if ($text !== '' && in_array($text, $banned, true)) {
                $found[$text] = ucfirst($text);
            }
        }

        return array_values($found);
    }

    protected function normalizeForSimilarity(string $value): string
    {
        $value = strtolower(trim($value));
        $value = (string) preg_replace('/[^a-z0-9\s]+/u', ' ', $value);
        $value = (string) preg_replace('/\s+/u', ' ', $value);

        return trim($value);
    }

    /**
     * Significant content tokens for overlap checks (first ~220 words of body copy).
     *
     * @return list<string>
     */
    protected function contentTokenSet(string $html): array
    {
        $plain = strtolower(trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
        if ($plain === '') {
            return [];
        }

        $words = preg_split('/\s+/u', $plain, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $words = array_slice($words, 0, 220);

        $stop = [
            'a' => true, 'an' => true, 'the' => true, 'and' => true, 'or' => true, 'but' => true,
            'in' => true, 'on' => true, 'at' => true, 'to' => true, 'for' => true, 'of' => true,
            'with' => true, 'by' => true, 'from' => true, 'as' => true, 'is' => true, 'are' => true,
            'was' => true, 'were' => true, 'be' => true, 'been' => true, 'being' => true, 'it' => true,
            'this' => true, 'that' => true, 'these' => true, 'those' => true, 'you' => true, 'your' => true,
            'we' => true, 'our' => true, 'they' => true, 'their' => true, 'can' => true, 'will' => true,
            'not' => true, 'if' => true, 'then' => true, 'than' => true, 'into' => true, 'about' => true,
        ];

        $tokens = [];
        foreach ($words as $word) {
            $word = (string) preg_replace('/[^a-z0-9]+/u', '', $word);
            if ($word === '' || isset($stop[$word]) || strlen($word) < 4) {
                continue;
            }
            $tokens[$word] = true;
        }

        return array_keys($tokens);
    }

    /**
     * @param  list<string>  $a
     * @param  list<string>  $b
     */
    protected function tokenOverlapRatio(array $a, array $b): float
    {
        if ($a === [] || $b === []) {
            return 0.0;
        }

        $setA = array_fill_keys($a, true);
        $setB = array_fill_keys($b, true);
        $intersection = count(array_intersect_key($setA, $setB));
        $union = count($setA + $setB);

        return $union === 0 ? 0.0 : $intersection / $union;
    }
}
