<?php

namespace App\Services;

use App\Ai\Agents\BlogRewriteAgent;
use App\Models\Blog;
use App\Support\Blogs\BlogInternalLinks;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class BlogRewriteService
{
    public const BACKUP_TABLE = 'blogs_backup';

    /**
     * @var array{average: int, min: int, max: int, sample: int}|null
     */
    protected ?array $targetCache = null;

    /**
     * @var list<array<string, mixed>>|null
     */
    protected ?array $exemplarCache = null;

    /**
     * @var list<string>|null
     */
    protected ?array $allowedPathsCache = null;

    /**
     * @var array<string, list<string>>|null
     */
    protected ?array $anchorKeywordsCache = null;

    public function __construct(
        protected BlogService $blogs,
        protected BlogDraftGenerationService $drafts,
    ) {}

    /**
     * Posts with an id below this are legacy and eligible for rewriting.
     */
    public function belowId(): int
    {
        return max(1, (int) config('blogs.rewrite.below_id', 70));
    }

    /**
     * Average visible word count of published human-written posts (id >= below_id) and its accepted band.
     *
     * @return array{average: int, min: int, max: int, sample: int}
     *
     * @throws RuntimeException
     */
    public function targetWordCount(): array
    {
        if ($this->targetCache !== null) {
            return $this->targetCache;
        }

        $counts = [];
        Blog::query()
            ->published()
            ->where('id', '>=', $this->belowId())
            ->select(['id', 'content'])
            ->chunkById(1, function ($chunk) use (&$counts): void {
                foreach ($chunk as $blog) {
                    $counts[] = $this->wordCount((string) $blog->content);
                }
            });

        if ($counts === []) {
            throw new RuntimeException('No published posts with id >= '.$this->belowId().' to calculate the target length from.');
        }

        $average = (int) round(array_sum($counts) / count($counts));
        $tolerance = min(0.5, max(0.0, (float) config('blogs.rewrite.length_tolerance', 0.15)));

        return $this->targetCache = [
            'average' => $average,
            'min' => (int) floor($average * (1 - $tolerance)),
            'max' => (int) ceil($average * (1 + $tolerance)),
            'sample' => count($counts),
        ];
    }

    /**
     * Heading outline, opening, and closing CTA from the human-written posts.
     *
     * @return list<array<string, mixed>>
     */
    public function styleExemplars(): array
    {
        if ($this->exemplarCache !== null) {
            return $this->exemplarCache;
        }

        $limit = max(1, (int) config('blogs.rewrite.style_example_limit', 3));

        return $this->exemplarCache = Blog::query()
            ->published()
            ->where('id', '>=', $this->belowId())
            ->with('category:id,name')
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get(['id', 'blog_category_id', 'title', 'short_description', 'meta_title', 'content', 'faqs'])
            ->map(function (Blog $blog): array {
                $summary = $this->drafts->summarizeBlogForStyle($blog);
                $summary['opening_html'] = $this->stripInlineStyles((string) $summary['opening_html']);

                return $summary;
            })
            ->values()
            ->all();
    }

    /**
     * Replace each image (with a wrapping figure or image-only paragraph) by an [[IMG_n]] token.
     *
     * @return array{html: string, tokens: array<string, string>}
     */
    public function tokenizeImages(string $html): array
    {
        $tokens = [];
        $store = static function (string $markup) use (&$tokens): string {
            $token = '[[IMG_'.(count($tokens) + 1).']]';
            $tokens[$token] = $markup;

            return $token;
        };

        $html = (string) preg_replace_callback(
            '#<figure\b[^>]*>.*?</figure>#is',
            static fn (array $m): string => stripos($m[0], '<img') !== false ? $store($m[0]) : $m[0],
            $html
        );

        $html = (string) preg_replace_callback(
            '#<p\b[^>]*>(?:(?!</p>).)*?<img\b(?:(?!</p>).)*?</p>#is',
            static function (array $m) use ($store): string {
                $text = trim(html_entity_decode(strip_tags($m[0]), ENT_QUOTES | ENT_HTML5, 'UTF-8'), " \t\n\r\0\x0B\u{A0}");

                return $text === '' ? $store($m[0]) : $m[0];
            },
            $html
        );

        $html = (string) preg_replace_callback(
            '#<img\b[^>]*>#i',
            static fn (array $m): string => $store($m[0]),
            $html
        );

        return ['html' => $html, 'tokens' => $tokens];
    }

    /**
     * Put the original <img> markup back byte-for-byte in place of each token, each image in its
     * own block with a trailing <br> (the spacing human-written posts use between image and text).
     *
     * @param  array<string, string>  $tokens
     */
    public function restoreImages(string $html, array $tokens): string
    {
        $html = $this->isolateImageTokens($html, array_keys($tokens));

        foreach ($tokens as $token => $markup) {
            $replacement = $this->imageBlock($markup);

            $count = 0;
            $html = (string) preg_replace_callback(
                '#<p\b[^>]*>\s*(?:<br\s*/?>\s*)*'.preg_quote($token, '#').'\s*(?:<br\s*/?>\s*)*</p>#i',
                static fn (): string => $replacement,
                $html,
                1,
                $count
            );

            if ($count === 0) {
                $html = str_replace($token, $replacement, $html);
            }
        }

        return $html;
    }

    /**
     * Move any image token the model left inside a sentence, heading or list out to its own
     * paragraph right after the top-level block that contained it.
     *
     * @param  list<string>  $tokens
     */
    protected function isolateImageTokens(string $html, array $tokens): string
    {
        foreach ($tokens as $token) {
            $quoted = preg_quote($token, '#');
            if (preg_match('#<p\b[^>]*>\s*(?:<br\s*/?>\s*)*'.$quoted.'\s*(?:<br\s*/?>\s*)*</p>#i', $html) === 1) {
                continue;
            }

            if (preg_match('#(?:<br\s*/?>\s*)*'.$quoted.'(?:\s*<br\s*/?>)*#i', $html, $match, PREG_OFFSET_CAPTURE) !== 1) {
                continue;
            }

            $start = (int) $match[0][1];
            if ($this->topLevelBlockEnd($html, $start) === $start) {
                continue;
            }

            $html = substr_replace($html, '', $start, strlen($match[0][0]));
            if ($start > 0 && ($html[$start - 1] ?? '') === ' ' && ($html[$start] ?? '') === ' ') {
                $html = substr_replace($html, '', $start, 1);
            }
            $insertAt = $this->topLevelBlockEnd($html, $start);
            $html = substr_replace($html, "\n<p>{$token}</p>\n", $insertAt, 0);
        }

        return (string) preg_replace('#<(p|h[1-6])\b[^>]*>\s*</\1>#i', '', $html);
    }

    /**
     * Offset just after the top-level block element enclosing $offset (or $offset itself when it is between blocks).
     */
    protected function topLevelBlockEnd(string $html, int $offset): int
    {
        preg_match_all('#<(/?)(p|h[1-6]|ul|ol|li|table|blockquote|div|figure|section)\b[^>]*>#i', $html, $tags, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

        $depth = 0;
        foreach ($tags as $tag) {
            $position = (int) $tag[0][1];
            if ($position >= $offset && $depth === 0) {
                return $offset;
            }

            $depth = max(0, $depth + ($tag[1][0] === '/' ? -1 : 1));
            if ($position >= $offset && $depth === 0) {
                return $position + strlen($tag[0][0]);
            }
        }

        return $depth === 0 ? $offset : strlen($html);
    }

    /**
     * The bare <img> tag(s) as a top-level block with the human posts' 20px spacing. Paragraph /
     * span / bold wrappers and trailing <br> are dropped because they add extra space below the
     * image (only the style attribute changes; src, alt, title and size stay as they were).
     */
    protected function imageBlock(string $markup): string
    {
        $markup = trim($markup);

        if (preg_match('#^<figure\b#i', $markup) === 1) {
            return $markup;
        }

        preg_match_all('#<img\b[^>]*>#i', $markup, $images);

        return $this->spaceImages(implode("\n", $images[0] !== [] ? $images[0] : [$markup]));
    }

    /**
     * Give every <img> the full-width, 20px top/bottom spacing the human-written posts use.
     */
    public function spaceImages(string $html): string
    {
        $spacing = 'width: 100%; margin-top: 20px; margin-bottom: 20px';

        return (string) preg_replace_callback('#<img\b[^>]*>#i', static function (array $m) use ($spacing): string {
            $tag = $m[0];

            if (preg_match('#\sstyle=(["\'])(.*?)\1#is', $tag, $style) === 1) {
                $kept = collect(explode(';', $style[2]))
                    ->map(static fn (string $rule): string => trim($rule))
                    ->filter(static fn (string $rule): bool => $rule !== '' && preg_match('#^(width|margin(-top|-bottom)?)\s*:#i', $rule) !== 1)
                    ->implode('; ');

                return str_replace($style[0], ' style="'.$spacing.($kept !== '' ? '; '.$kept : '').'"', $tag);
            }

            return (string) preg_replace('#^<img\b#i', '<img style="'.$spacing.'"', $tag);
        }, $html);
    }

    /**
     * Turn off the blog stylesheet's link underline on every anchor, as the human-written posts do.
     */
    public function unUnderlineLinks(string $html): string
    {
        return (string) preg_replace_callback('#<a\b[^>]*>#i', static function (array $m): string {
            $tag = $m[0];

            if (preg_match('#\sstyle=(["\'])(.*?)\1#is', $tag, $style) === 1) {
                if (stripos($style[2], 'text-decoration') !== false) {
                    return $tag;
                }

                return str_replace($style[0], ' style="text-decoration: none; '.trim($style[2]).'"', $tag);
            }

            return (string) preg_replace('#^<a\b#i', '<a style="text-decoration: none"', $tag);
        }, $html);
    }

    /**
     * Rewrite legacy / absolute internal hrefs to current relative paths, and unwrap links to
     * blog posts (rewrites link site pages only) leaving the anchor text in place.
     */
    public function normalizeLinks(string $html): string
    {
        $html = (string) preg_replace_callback(
            '#<a\b[^>]*\bhref=(["\'])(.*?)\1[^>]*>(.*?)</a>#is',
            static function (array $m): string {
                $path = BlogInternalLinks::normalizeInternalHref($m[2]);

                return $path !== null && BlogInternalLinks::isBlogPath($path) ? $m[3] : $m[0];
            },
            $html
        );

        return (string) preg_replace_callback(
            '#(<a\b[^>]*\bhref=)(["\'])(.*?)\2#is',
            static function (array $m): string {
                $path = BlogInternalLinks::normalizeInternalHref($m[3]);

                return $path === null ? $m[0] : $m[1].$m[2].$path.$m[2];
            },
            $html
        );
    }

    /**
     * Problems that make a rewrite attempt unacceptable (empty list = valid).
     *
     * @param  array<string, string>  $tokens
     * @param  list<array{question?: string, answer?: string}>  $faqs
     * @return list<string>
     */
    public function validate(string $html, array $tokens, string $originalHtml, bool $hasFeaturedShortcode = false, array $faqs = [], string $title = ''): array
    {
        $errors = [];

        foreach (array_keys($tokens) as $token) {
            $found = substr_count($html, $token);
            if ($found !== 1) {
                $errors[] = "Image token {$token} must appear exactly once (found {$found}).";
            }
        }

        if (preg_match_all('/\[\[IMG_\d+\]\]/', $html, $extra) && count(array_diff(array_unique($extra[0]), array_keys($tokens))) > 0) {
            $errors[] = 'Do not invent new image tokens: '.implode(', ', array_diff(array_unique($extra[0]), array_keys($tokens))).'.';
        }

        if (stripos($html, '<img') !== false) {
            $errors[] = 'Do not write <img> tags; keep only the [[IMG_n]] tokens.';
        }

        if ($hasFeaturedShortcode && substr_count($html, '[featured_image]') !== 1) {
            $errors[] = 'Keep the [featured_image] shortcode exactly once.';
        }

        $allowed = array_fill_keys($this->allowedPaths(), true);
        $originalExternal = $this->externalHrefs($originalHtml);
        $internal = [];

        preg_match_all('#<a\b[^>]*\bhref=(["\'])(.*?)\1#is', $html, $anchors);
        foreach ($anchors[2] as $href) {
            $path = BlogInternalLinks::normalizeInternalHref($href);
            if ($path === null) {
                if (! in_array(trim($href), $originalExternal, true)) {
                    $errors[] = "Remove the external link {$href}; use only the INTERNAL LINKS list.";
                }

                continue;
            }

            if (! isset($allowed[$path])) {
                $errors[] = "Link {$path} is not on the INTERNAL LINKS list; use only the listed URLs.";

                continue;
            }

            $internal[] = $path;
        }

        $contactPath = BlogInternalLinks::relativePath(route('contact-us'));
        $distinct = array_unique($internal);
        $minLinks = max(1, (int) config('blogs.rewrite.min_links', 3));
        $maxLinks = max($minLinks, (int) config('blogs.rewrite.max_links', 7));

        if (count(array_diff($distinct, [$contactPath])) < $minLinks) {
            $errors[] = "Use at least {$minLinks} different internal links in the body besides {$contactPath}.";
        }

        foreach (array_count_values($internal) as $path => $count) {
            if ($count > 1) {
                $errors[] = "{$path} is linked {$count} times; link each page once, at the sentence where it fits best.";
            }
        }

        if (count($distinct) > $maxLinks + 1) {
            $errors[] = 'Too many internal links ('.count($distinct)."); keep it to {$maxLinks} or fewer so each one is meaningful.";
        }

        if (! in_array($contactPath, $internal, true)) {
            $errors[] = "The closing section must link to {$contactPath}.";
        }

        array_push($errors, ...$this->linkPlacementProblems($html, $contactPath, $minLinks));
        array_push($errors, ...$this->anchorProblems($html));

        $text = $this->visibleText($html);
        $faqText = collect($faqs)
            ->map(static fn (mixed $f): string => is_array($f) ? trim((string) ($f['question'] ?? '')).' '.trim((string) ($f['answer'] ?? '')) : '')
            ->implode(' ');
        $allText = mb_strtolower($text.' '.$faqText);

        foreach ($this->bannedPhrases() as $phrase) {
            if (preg_match('/\b'.preg_quote(mb_strtolower($phrase), '/').'/u', $allText) === 1) {
                $errors[] = "Remove the banned phrase \"{$phrase}\" (body or FAQs) and rephrase in plain language.";
            }
        }

        $sentenceText = $this->visibleText((string) preg_replace('#</(?:h[1-6]|p|li|td|th|blockquote)>#i', '$0. ', $html)).' '.$faqText;
        $notJust = $this->notJustSentences($sentenceText);
        if ($notJust !== []) {
            $errors[] = 'Drop the "not just X, it\'s Y" construction; say the point directly. Rewrite these sentences without "not just": "'.implode('" | "', $notJust).'"';
        }

        $originalText = $this->visibleText($originalHtml);
        preg_match_all('/\d+(?:\.\d+)?\s?%/u', $text.' '.$faqText, $percents);
        foreach (array_unique($percents[0]) as $percent) {
            $number = rtrim(str_replace(' ', '', $percent), '%');
            if (preg_match('/(?<![\d.])'.preg_quote($number, '/').'\s?%/u', $originalText) !== 1) {
                $errors[] = "The figure {$percent} is not in the original post; remove it or describe the effect without a number.";
            }
        }

        $words = $this->wordCount($html);
        $emDashLimit = (int) ceil($words / 100 * max(0.0, (float) config('blogs.rewrite.em_dash_per_100_words', 0)));
        $emDashes = substr_count($text.' '.$faqText, '—');
        if ($emDashes > $emDashLimit) {
            $errors[] = $emDashLimit === 0
                ? "Remove all {$emDashes} em dashes (body and FAQs); use full stops, commas or parentheses instead."
                : "Too many em dashes ({$emDashes}); use at most {$emDashLimit}. Prefer full stops, commas or parentheses.";
        }

        if (preg_match_all('/<h2\b[^>]*>(.*?)<\/h2>/is', $html, $headings)) {
            foreach ($headings[1] as $heading) {
                $label = strtolower(trim(html_entity_decode(strip_tags($heading), ENT_QUOTES | ENT_HTML5, 'UTF-8'), " \t\n\r\0\x0B:."));
                if (in_array($label, ['conclusion', 'introduction', 'overview', 'summary', 'final thoughts', 'benefits', 'faq', 'faqs', 'frequently asked questions'], true)) {
                    $errors[] = "Replace the generic heading \"{$label}\" with a specific one (FAQs belong in the faqs field).";
                }
                if (preg_match('/case stud|real[- ]world|in action|success stor/i', $label) === 1) {
                    $errors[] = "Remove the \"{$label}\" section; mention a case study only as a link inside an ordinary sentence, without describing its results.";
                }
            }
        }

        array_push(
            $errors,
            ...$this->headingProblems($html, $title),
            ...$this->unsupportedClaims($text.' '.$faqText, $originalText),
            ...$this->contrastProblems($sentenceText),
            ...$this->repeatedPhrases($text, $words),
        );

        $target = $this->targetWordCount();
        if ($words < $target['min'] || $words > $target['max']) {
            $direction = $words < $target['min'] ? 'too short' : 'too long';
            $errors[] = "Body is {$direction} at {$words} words; it must be {$target['min']}–{$target['max']} words.";
        }

        return array_values(array_unique($errors));
    }

    /**
     * Rewrite one legacy post and (optionally) save content + FAQs on the existing row.
     *
     * @return array{blog_id: int, slug: string, saved: bool, attempts: int, words_before: int, words_after: int, links: list<string>, images: int, sections_used: list<array{section: string, reason: string}>, content: string, faqs: list<array{question: string, answer: string}>}
     *
     * @throws RuntimeException
     */
    public function rewrite(Blog $blog, bool $save = true): array
    {
        if ((int) $blog->id >= $this->belowId()) {
            throw new InvalidArgumentException("Blog #{$blog->id} is at or above id {$this->belowId()} and is never rewritten.");
        }

        $original = (string) $blog->content;
        $originalWithFaqs = $original.' '.collect(is_array($blog->faqs) ? $blog->faqs : [])
            ->map(static fn (mixed $f): string => is_array($f) ? '<p>'.e((string) ($f['question'] ?? '')).' '.e((string) ($f['answer'] ?? '')).'</p>' : '')
            ->implode('');
        $tokenized = $this->tokenizeImages($original);
        $hasFeatured = str_contains($original, '[featured_image]');
        $target = $this->targetWordCount();
        $links = BlogInternalLinks::suggestForRewrite($blog, (int) config('blogs.rewrite.max_links', 7) - 1);
        $model = (string) config('blogs.rewrite.model', 'gpt-4o-mini');
        $maxAttempts = max(1, (int) config('blogs.rewrite.max_attempts', 3));

        $agent = new BlogRewriteAgent(
            styleExamples: $this->styleExemplars(),
            internalLinks: $links,
            targetWords: $target,
            bannedPhrases: $this->bannedPhrases(),
            minLinks: max(1, (int) config('blogs.rewrite.min_links', 3)),
            modelOverride: $model,
        );

        $errors = [];
        $previous = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            $prompt = $previous === null
                ? $this->userPrompt($blog, $tokenized['html'], array_keys($tokenized['tokens']), $hasFeatured)
                : $this->revisionPrompt($blog, $previous['html'], $previous['faqs'], array_keys($tokenized['tokens']), $errors);

            $payload = $this->requestRewrite($agent, $prompt, $model);

            $html = $this->swapPlainWords($this->cleanModelHtml((string) ($payload['content'] ?? '')));
            $html = $this->stripTitleHeadings($html, (string) $blog->title);
            $html = $this->reduceEmDashes($html);
            $html = $this->normalizeLinks($html);
            $payload['faqs'] = collect(is_array($payload['faqs'] ?? null) ? $payload['faqs'] : [])
                ->filter(static fn (mixed $f): bool => is_array($f))
                ->map(fn (array $f): array => [
                    'question' => $this->reduceEmDashes($this->swapPlainWords((string) ($f['question'] ?? ''))),
                    'answer' => $this->reduceEmDashes($this->swapPlainWords((string) ($f['answer'] ?? ''))),
                ])
                ->values()
                ->all();
            $errors = $this->validate(
                $html,
                $tokenized['tokens'],
                $originalWithFaqs,
                $hasFeatured,
                is_array($payload['faqs'] ?? null) ? $payload['faqs'] : [],
                (string) $blog->title
            );

            if ($errors === []) {
                $restored = $this->unUnderlineLinks($this->restoreImages($html, $tokenized['tokens']));
                $content = $this->blogs->sanitizeHtmlContent($restored, (string) $blog->slug, (string) $blog->title);
                $faqs = $this->blogs->normalizeFaqItems($payload['faqs'] ?? null) ?? [];

                if ($save) {
                    $this->saveRewrite($blog, ['content' => $content, 'faqs' => $faqs]);
                }

                return [
                    'blog_id' => (int) $blog->id,
                    'slug' => (string) $blog->slug,
                    'saved' => $save,
                    'attempts' => $attempt,
                    'words_before' => $this->wordCount($original),
                    'words_after' => $this->wordCount($content),
                    'links' => $this->internalPaths($content),
                    'images' => count($tokenized['tokens']),
                    'sections_used' => $this->normalizeSections($payload['sections_used'] ?? []),
                    'content' => $content,
                    'faqs' => $faqs,
                ];
            }

            $previous = [
                'html' => $html,
                'faqs' => is_array($payload['faqs'] ?? null) ? $payload['faqs'] : [],
            ];
        }

        throw new RuntimeException('Rewrite failed validation after '.$maxAttempts.' attempt(s): '.implode(' ', $errors));
    }

    /**
     * Store the blog's current content + FAQs in blogs_backup before its first rewrite.
     * An existing backup row is never overwritten, so it always holds the pre-rewrite original.
     *
     * @return bool True when a new backup row was written, false when the post was already backed up.
     */
    public function backupBlog(Blog $blog): bool
    {
        $this->ensureBackupTable();

        if (DB::table(self::BACKUP_TABLE)->where('blog_id', $blog->id)->exists()) {
            return false;
        }

        DB::table(self::BACKUP_TABLE)->insert([
            'blog_id' => (int) $blog->id,
            'slug' => (string) $blog->slug,
            'content' => (string) $blog->getRawOriginal('content'),
            'faqs' => $blog->getRawOriginal('faqs'),
            'backed_up_at' => now(),
        ]);

        return true;
    }

    protected function ensureBackupTable(): void
    {
        if (Schema::hasTable(self::BACKUP_TABLE)) {
            return;
        }

        Schema::create(self::BACKUP_TABLE, static function (Blueprint $table): void {
            $table->unsignedBigInteger('blog_id')->primary();
            $table->string('slug')->nullable();
            $table->longText('content')->nullable();
            $table->longText('faqs')->nullable();
            $table->timestamp('backed_up_at')->nullable();
        });
    }

    /**
     * Persist a validated rewrite result (content + FAQs only) on the existing row; created_at,
     * updated_at and published_at are left exactly as they were.
     *
     * @param  array{content: string, faqs: list<array{question: string, answer: string}>}  $result
     */
    public function saveRewrite(Blog $blog, array $result): Blog
    {
        Blog::withoutTimestamps(static fn () => $blog->forceFill(['content' => $result['content'], 'faqs' => $result['faqs']])->save());

        return $blog;
    }

    /**
     * Copy content + FAQs back from blogs_backup (optionally one blog id/slug). Returns rows restored.
     *
     * @throws InvalidArgumentException
     */
    public function restoreFromBackup(?string $blogFilter = null): int
    {
        if (! Schema::hasTable(self::BACKUP_TABLE)) {
            throw new InvalidArgumentException('Backup table '.self::BACKUP_TABLE.' does not exist yet (no post has been rewritten).');
        }

        $query = DB::table(self::BACKUP_TABLE)->select(['blog_id', 'content', 'faqs']);
        $blogFilter = trim((string) $blogFilter);
        if ($blogFilter !== '') {
            $query->where(static function ($q) use ($blogFilter): void {
                if (ctype_digit($blogFilter)) {
                    $q->where('blog_id', (int) $blogFilter);
                }
                $q->orWhere('slug', $blogFilter);
            });
        }

        $restored = 0;
        $blogsTable = (new Blog)->getTable();

        $query->orderBy('blog_id')->chunk(1, function ($rows) use (&$restored, $blogsTable): void {
            foreach ($rows as $row) {
                $restored += DB::table($blogsTable)
                    ->where('id', $row->blog_id)
                    ->update(['content' => $row->content, 'faqs' => $row->faqs]);
            }
        });

        return $restored;
    }

    /**
     * Visible word count (tags and image tokens removed).
     */
    public function wordCount(string $html): int
    {
        return str_word_count($this->visibleText($html));
    }

    /**
     * Distinct internal link paths in saved HTML.
     *
     * @return list<string>
     */
    public function internalPaths(string $html): array
    {
        preg_match_all('#<a\b[^>]*\bhref=(["\'])(.*?)\1#is', $html, $anchors);

        return array_values(array_unique(array_filter(array_map(
            static fn (string $href): ?string => BlogInternalLinks::normalizeInternalHref($href),
            $anchors[2]
        ))));
    }

    /**
     * Send one rewrite request to the agent. Separate so tests can substitute the model call.
     *
     * @return array<string, mixed>
     *
     * @throws RuntimeException
     */
    protected function requestRewrite(BlogRewriteAgent $agent, string $prompt, string $model): array
    {
        $networkRetries = 4;

        for ($try = 1; ; $try++) {
            try {
                $response = $agent->prompt($prompt, model: $model !== '' ? $model : null, timeout: 300);

                break;
            } catch (Throwable $e) {
                $transient = str_contains($e->getMessage(), 'cURL error')
                    || $e instanceof ConnectionException;

                if (! $transient || $try >= $networkRetries) {
                    throw new RuntimeException('AI blog rewrite failed: '.$e->getMessage(), 0, $e);
                }

                sleep(10 * $try);
            }
        }

        if (is_array($response)) {
            return $response;
        }

        if (is_object($response) && method_exists($response, 'toArray')) {
            /** @var array<string, mixed> $array */
            $array = $response->toArray();

            return $array;
        }

        throw new RuntimeException('AI returned an unexpected response type for the blog rewrite.');
    }

    /**
     * @param  list<string>  $imageTokens
     */
    protected function userPrompt(Blog $blog, string $tokenizedHtml, array $imageTokens, bool $hasFeatured): string
    {
        $target = $this->targetWordCount();
        $wordsBefore = $this->wordCount($tokenizedHtml);
        $faqs = collect(is_array($blog->faqs) ? $blog->faqs : [])
            ->filter(static fn (mixed $f): bool => is_array($f) && trim((string) ($f['question'] ?? '')) !== '')
            ->map(static fn (array $f): string => 'Q: '.trim((string) $f['question'])."\nA: ".trim((string) ($f['answer'] ?? '')))
            ->implode("\n\n");
        $faqBlock = $faqs !== '' ? $faqs : '(none: write 3–6 new FAQs)';
        $tokensLine = $imageTokens === [] ? '(this post has no images)' : implode(', ', $imageTokens);
        $featuredLine = $hasFeatured ? "\nKeep the [featured_image] shortcode exactly once." : '';
        $direction = match (true) {
            $wordsBefore < $target['min'] => "The original is {$wordsBefore} words. Expand it with substance to about {$target['average']} words (allowed {$target['min']}–{$target['max']}).",
            $wordsBefore > $target['max'] => "The original is {$wordsBefore} words. Tighten it to about {$target['average']} words (allowed {$target['min']}–{$target['max']}) by cutting repetition and generic sections.",
            default => "The original is {$wordsBefore} words. Aim for about {$target['average']} words (allowed {$target['min']}–{$target['max']}).",
        };
        $body = $this->stripInlineStyles($tokenizedHtml);

        return <<<PROMPT
Rewrite this Suave Creators blog post following your instructions.

Title (unchanged): {$blog->title}
Short description: {$blog->short_description}
{$direction}
Image tokens to keep exactly once each: {$tokensLine}{$featuredLine}

EXISTING FAQS:
{$faqBlock}

ORIGINAL ARTICLE HTML:
{$body}
PROMPT;
    }

    /**
     * Ask the model to fix only the listed problems in its previous draft.
     *
     * @param  list<array{question?: string, answer?: string}>  $faqs
     * @param  list<string>  $imageTokens
     * @param  list<string>  $problems
     */
    protected function revisionPrompt(Blog $blog, string $draftHtml, array $faqs, array $imageTokens, array $problems): string
    {
        $target = $this->targetWordCount();
        $words = $this->wordCount($draftHtml);
        $tokensLine = $imageTokens === [] ? '(this post has no images)' : implode(', ', $imageTokens);
        $faqBlock = collect($faqs)
            ->filter(static fn (mixed $f): bool => is_array($f))
            ->map(static fn (array $f): string => 'Q: '.trim((string) ($f['question'] ?? ''))."\nA: ".trim((string) ($f['answer'] ?? '')))
            ->implode("\n\n");
        $list = '- '.implode("\n- ", $problems);
        $delta = $target['average'] - $words;
        $lengthLine = match (true) {
            $words < $target['min'] => "The draft is {$words} words. Add roughly {$delta} words of substance (a concrete example, a trade-off, a practical step) so it lands near {$target['average']}.",
            $words > $target['max'] => 'The draft is '.$words.' words. Cut roughly '.abs($delta)." words (repetition, generic sentences) so it lands near {$target['average']}.",
            default => "The draft is {$words} words; keep it between {$target['min']} and {$target['max']} (near {$target['average']}).",
        };

        return <<<PROMPT
Your draft of "{$blog->title}" was rejected by our editor. Revise the draft below. Fix EVERY problem in this list, and keep everything else (structure, links, arguments) as close to the draft as possible:
{$list}

Before returning, re-read the whole draft and the FAQ answers once more for any banned phrase, em dash, "not just X, it's Y" construction or new percentage, and fix those too.
{$lengthLine}
Image tokens to keep exactly once each: {$tokensLine}

DRAFT HTML:
{$draftHtml}

DRAFT FAQS:
{$faqBlock}
PROMPT;
    }

    /**
     * Swap configured jargon words for plain equivalents in text nodes only (keeps case of the first letter).
     */
    public function swapPlainWords(string $html): string
    {
        $swaps = (array) config('blogs.rewrite.plain_word_swaps', []);
        if ($swaps === []) {
            return $html;
        }

        $parts = preg_split('/(<[^>]+>)/', $html, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [$html];

        foreach ($parts as $index => $part) {
            if ($part === '' || $part[0] === '<') {
                continue;
            }

            foreach ($swaps as $from => $to) {
                $part = (string) preg_replace_callback(
                    '/\b'.preg_quote((string) $from, '/').'\b/iu',
                    static function (array $m) use ($to): string {
                        $to = (string) $to;

                        return ctype_upper(mb_substr($m[0], 0, 1)) ? ucfirst($to) : $to;
                    },
                    $part
                );
            }

            $parts[$index] = $part;
        }

        return implode('', $parts);
    }

    /**
     * Bring em dashes under the configured limit (default none): spaced en dashes / hyphens used
     * as asides become commas, paired em dashes in one sentence become parentheses, then any
     * still over the limit (from the end) become commas.
     */
    public function reduceEmDashes(string $html): string
    {
        $limit = (int) ceil($this->wordCount($html) / 100 * max(0.0, (float) config('blogs.rewrite.em_dash_per_100_words', 0)));
        $count = static fn (string $value): int => substr_count(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'), '—');

        $html = str_replace(['&mdash;', '&#8212;', '&#x2014;'], '—', $html);

        $parts = preg_split('/(<[^>]+>)/', $html, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [$html];
        foreach ($parts as $index => $part) {
            if ($part === '' || $part[0] === '<') {
                continue;
            }
            // A spaced en dash or hyphen between words is the same aside in disguise; ranges like "$45,000 – $85,000" stay.
            $parts[$index] = (string) preg_replace('/(?<=[\p{L}\)])\s+[–-]\s+(?=[\p{L}(])/u', ', ', $part);
        }
        $html = implode('', $parts);

        if ($count($html) <= $limit) {
            return $html;
        }

        $parts = preg_split('/(<[^>]+>)/', $html, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [$html];
        foreach ($parts as $index => $part) {
            if ($part === '' || $part[0] === '<') {
                continue;
            }
            $parts[$index] = (string) preg_replace('/\s*—\s*([^—.!?]{1,80}?)\s*—\s*/u', ' ($1) ', $part);
        }
        $html = implode('', $parts);

        $excess = $count($html) - $limit;
        for ($i = count($parts) - 1; $i >= 0 && $excess > 0; $i--) {
            $parts = preg_split('/(<[^>]+>)/', $html, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [$html];
            $part = $parts[$i] ?? '';
            if ($part === '' || $part[0] === '<') {
                continue;
            }
            while ($excess > 0 && ($pos = mb_strrpos($part, '—')) !== false) {
                $before = rtrim(mb_substr($part, 0, $pos));
                $after = ltrim(mb_substr($part, $pos + 1));
                $part = $before.', '.$after;
                $excess--;
            }
            $parts[$i] = $part;
            $html = implode('', $parts);
        }

        return $html;
    }

    /**
     * Strip code fences, scripts, H1s, inline styles, and spans the model may emit.
     */
    protected function cleanModelHtml(string $html): string
    {
        $html = trim($html);
        $html = (string) preg_replace('/^```(?:html)?\s*/i', '', $html);
        $html = (string) preg_replace('/\s*```$/', '', $html);
        $html = (string) preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html);
        $html = (string) preg_replace('/<h1(\b[^>]*)>/i', '<h2$1>', $html);
        $html = (string) preg_replace('/<\/h1>/i', '</h2>', $html);
        $html = $this->stripInlineStyles($html);
        $html = (string) preg_replace('#</?span\b[^>]*>#i', '', $html);

        return trim($html);
    }

    /**
     * Remove style / dir attributes so pasted Google Docs styling never reaches the model or the page.
     */
    protected function stripInlineStyles(string $html): string
    {
        return (string) preg_replace('/\s(?:style|dir)=(["\']).*?\1/is', '', $html);
    }

    /**
     * Page links (everything except the contact CTA) must sit in the body sections, spread through
     * the article, not bunched in the closing section.
     *
     * @return list<string>
     */
    protected function linkPlacementProblems(string $html, string $contactPath, int $minLinks): array
    {
        $closingAt = strripos($html, '<h2');
        $body = $closingAt !== false && $closingAt > 0 ? substr($html, 0, $closingAt) : $html;
        $closing = $closingAt !== false && $closingAt > 0 ? substr($html, $closingAt) : '';
        $bodyLength = max(1, mb_strlen($this->visibleText($body)));

        $pageLinks = static function (string $fragment) use ($contactPath): array {
            preg_match_all('#<a\b[^>]*\bhref=(["\'])(.*?)\1#is', $fragment, $m, PREG_OFFSET_CAPTURE);
            $found = [];
            foreach ($m[2] as $index => [$href]) {
                $path = BlogInternalLinks::normalizeInternalHref((string) $href);
                if ($path !== null && $path !== $contactPath) {
                    $found[] = ['path' => $path, 'offset' => (int) $m[0][$index][1]];
                }
            }

            return $found;
        };

        $errors = [];
        $inBody = $pageLinks($body);
        $needed = min($minLinks, max(1, count(array_unique(array_column(array_merge($inBody, $pageLinks($closing)), 'path')))));

        if (count(array_unique(array_column($inBody, 'path'))) < $needed) {
            $errors[] = "Place at least {$needed} of the page links inside the body sections where they are relevant, not in the closing section. The closing section should carry only the /contact-us link.";
        }

        $positions = array_map(
            fn (array $link): float => mb_strlen($this->visibleText(substr($body, 0, $link['offset']))) / $bodyLength,
            $inBody
        );

        if ($positions !== [] && min($positions) > 0.4) {
            $errors[] = 'The first page link comes too late; put at least one relevant link in the first third of the article (the opening or first section).';
        }

        if (count($positions) >= 2 && array_filter($positions, static fn (float $p): bool => $p >= 0.3 && $p <= 0.8) === []) {
            $errors[] = 'Spread the page links through the middle sections too; right now none sit in the middle of the article.';
        }

        return $errors;
    }

    /**
     * Anchor text must name what the linked page is about (e.g. "custom CRM" → the CRM service page).
     *
     * @return list<string>
     */
    protected function anchorProblems(string $html): array
    {
        $keywords = $this->anchorKeywordsCache ??= BlogInternalLinks::anchorKeywordMap();
        preg_match_all('#<a\b[^>]*\bhref=(["\'])(.*?)\1[^>]*>(.*?)</a>#is', $html, $links, PREG_SET_ORDER);

        $errors = [];
        foreach ($links as [, , $href, $anchor]) {
            $path = BlogInternalLinks::normalizeInternalHref((string) $href);
            $words = $path !== null ? ($keywords[$path] ?? []) : [];
            if ($words === [] || BlogInternalLinks::anchorFits((string) $anchor, $words)) {
                continue;
            }

            $label = trim(html_entity_decode(strip_tags((string) $anchor), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $errors[] = "The link to {$path} uses the anchor \"{$label}\", which does not say what that page is about. "
                .'Link a phrase that names its subject (one of: '.implode(', ', array_slice($words, 0, 6)).') in a sentence that is actually about it, or remove this link and use a better-fitting page.';
        }

        return $errors;
    }

    /**
     * Drop headings that repeat the post title (the page already renders it as the H1).
     */
    public function stripTitleHeadings(string $html, string $title): string
    {
        if (trim($title) === '') {
            return $html;
        }

        return (string) preg_replace_callback(
            '#<h([1-6])\b[^>]*>(.*?)</h\1>\s*#is',
            fn (array $m): string => $this->sameHeading($m[2], $title) ? '' : $m[0],
            $html
        );
    }

    /**
     * Stock heading shapes, a heading that repeats the title, and duplicate headings.
     *
     * @return list<string>
     */
    protected function headingProblems(string $html, string $title): array
    {
        if (preg_match_all('#<h([23])\b[^>]*>(.*?)</h\1>#is', $html, $matches) === 0) {
            return [];
        }

        $patterns = [
            '/\bthat\s+(?:drives?|eliminates?|transforms?|boosts?|unlocks?|powers?|converts?|delivers?|matters?|works?|pays?|sells?|scales?)\b/i' => '"X That Drives Y"',
            '/\b(?:actually|really|truly)\b/i' => '"Why X Actually Y"',
            '/\bshould\s+be\s+as\b/i' => '"Your X Should Be as Y as Z"',
            '/\bthe\s+(?:hidden|real|true)\s+(?:cost|price|value|power)\b/i' => '"The Hidden Cost of X"',
            '/\b(?:matters?|outperforms?|wins?)\s*$/i' => '"Why X Matters / Wins"',
            '/\bfrom\s+[a-z]+(?:er|or|ion|ity)\s+to\s+[a-z]+(?:er|or|ion|ity)\b/i' => '"From Enabler to Restrictor"',
            '/\b(?:ultimate|definitive|complete)\s+guide\b|\bsecret\s+to\b|\bkey\s+to\b/i' => '"The Key to X"',
        ];

        $errors = [];
        $seen = [];
        $whyHow = 0;
        foreach ($matches[2] as $raw) {
            $heading = trim(html_entity_decode(strip_tags($raw), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($heading === '') {
                continue;
            }

            if ($title !== '' && $this->sameHeading($heading, $title)) {
                $errors[] = "Remove the heading \"{$heading}\"; it repeats the post title, which the page already shows.";
            }

            $key = $this->headingKey($heading);
            if (isset($seen[$key])) {
                $errors[] = "The heading \"{$heading}\" appears twice; every heading must be different.";
            }
            $seen[$key] = true;

            foreach ($patterns as $pattern => $shape) {
                if (preg_match($pattern, $heading) === 1) {
                    $errors[] = "The heading \"{$heading}\" uses the stock {$shape} shape. Write a plain, specific label a practitioner would use (e.g. \"Checkout on Shopify Plus\", \"When the app count passes 20\", \"What a rebuild costs\").";
                    break;
                }
            }

            if (preg_match('/^(?:why|how)\b/i', $heading) === 1) {
                $whyHow++;
            }
        }

        if ($whyHow >= 3) {
            $errors[] = "{$whyHow} headings start with \"Why\" or \"How\"; vary them (plain noun phrases, a question a buyer asks, a specific situation).";
        }

        return $errors;
    }

    protected function sameHeading(string $heading, string $title): bool
    {
        $a = $this->headingKey(html_entity_decode(strip_tags($heading), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $b = $this->headingKey($title);
        if ($a === '' || $b === '') {
            return false;
        }

        similar_text($a, $b, $percent);

        return $a === $b || $percent >= 85.0;
    }

    protected function headingKey(string $heading): string
    {
        return trim((string) preg_replace('/[^a-z0-9]+/', ' ', mb_strtolower($heading)));
    }

    /**
     * Behaviour, speed, payback and research claims the original post never made.
     *
     * @return list<string>
     */
    protected function unsupportedClaims(string $text, string $originalText): array
    {
        $patterns = [
            '/\b(?:\d+(?:\.\d+)?|one|two|three|four|five|six|seven|eight|nine|ten)(?:\s*(?:-|–|to)\s*(?:\d+(?:\.\d+)?|[a-z]+))?\s+seconds?\b/iu',
            '/\b(?:most|the majority of|nearly all|almost all)\s+(?:of\s+)?(?:your\s+)?(?:visitors|users|customers|shoppers|buyers|consumers)\b/iu',
            '/\b(?:pays?\s+(?:for\s+)?itself|pay\s+back|payback|break[- ]even|justif(?:y|ies)\s+(?:the\s+|its\s+|your\s+)?(?:investment|cost|spend)|roi)\b[^.]{0,80}?\b(?:years?|months?|weeks?|quarters?)\b/iu',
            '/\b(?:studies|research|surveys?|statistics|the data)\s+(?:show|shows|suggest|suggests|prove|proves|indicate|indicates|found)\b/iu',
            '/\b(?:\d+|two|three|four|five|ten)x\b|\b(?:twice|double|triple|three times|ten times)\s+(?:as|the|more)\b/iu',
            '/\b(?:in half|halved|doubled|tripled|quadrupled)\b/iu',
        ];

        $errors = [];
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $match) === 1 && preg_match($pattern, $originalText) !== 1) {
                $errors[] = "The claim \"{$match[0]}\" is not in the original post; remove it or say it without a number, statistic or guarantee.";
            }
        }

        $stories = [
            '/\b(?:one|a|an|another)\s+(?:[a-z-]+\s+){0,3}(?:clients?|customers?|distributors?|retailers?|manufacturers?|compan(?:y|ies)|brands?|business(?:es)?|firms?|startups?|agenc(?:y|ies)|clinics?|stores?|teams?|wholesalers?|suppliers?)\s+(?:that\s+)?we\s+(?:worked|partnered|helped|built|supported|onboarded)\b/iu',
            '/\bone of our (?:clients|customers)\b|\ba client of ours\b|\bwe recently (?:worked|helped|partnered)\b/iu',
        ];
        foreach ($stories as $pattern) {
            if (preg_match($pattern, $text, $match) === 1 && preg_match($pattern, $originalText) !== 1) {
                $errors[] = "Remove the invented client story \"{$match[0]}…\"; the original does not describe this project. Explain the point with a general example instead.";
            }
        }

        return $errors;
    }

    /**
     * More than one "not X, but Y" / "isn't about X, it's about Y" contrast reads as templated.
     *
     * @return list<string>
     */
    protected function contrastProblems(string $text): array
    {
        preg_match_all('/\bnot\s+(?:just\s+|only\s+)?[^.,;:!?]{1,50}?,?\s+but\s+[^.!?]{0,40}/iu', $text, $notBut);
        preg_match_all('/\b(?:isn[\'’]t|is not|wasn[\'’]t)\s+about\b[^.!?]{1,60}?\b(?:it[\'’]s|but)\s+about\b/iu', $text, $aboutAbout);
        $found = array_merge($notBut[0], $aboutAbout[0]);

        if (count($found) <= 1) {
            return [];
        }

        $examples = implode('" | "', array_map(static fn (string $s): string => Str::limit(trim($s), 80), array_slice($found, 0, 3)));

        return ['Too many "not X, but Y" contrasts ('.count($found)."): \"{$examples}\". Keep at most one; state the other points directly."];
    }

    /**
     * Two-word content phrases repeated like SEO keywords.
     *
     * @return list<string>
     */
    protected function repeatedPhrases(string $text, int $words): array
    {
        $limit = max(
            (int) config('blogs.rewrite.max_phrase_repeats', 5),
            5 + intdiv(max(0, $words - 1250), 250)
        );
        $stop = array_flip(['a', 'an', 'the', 'and', 'or', 'but', 'of', 'to', 'in', 'on', 'for', 'with', 'at', 'by', 'from', 'as', 'is', 'are', 'was', 'were', 'be', 'been', 'it', 'its', 'it’s', "it's", 'this', 'that', 'these', 'those', 'you', 'your', 'we', 'our', 'they', 'their', 'can', 'will', 'not', 'if', 'so', 'do', 'does', 'more', 'most', 'than', 'what', 'when', 'how', 'why', 'which', 'who', 'into', 'out', 'up', 'one', 'all', 'any', 'each', 'every', 'has', 'have', 'had', 'more', 'also', 'just', 'about', 'there', 'then', 'them', 'he', 'she', 'i', 'my', 'me', 'us', 'no', 'yes', 'too', 'very']);

        preg_match_all("/[\p{L}\p{N}][\p{L}\p{N}'’-]*/u", mb_strtolower($text), $tokens);
        $counts = [];
        $list = $tokens[0];
        for ($i = 0, $n = count($list) - 1; $i < $n; $i++) {
            if (isset($stop[$list[$i]]) || isset($stop[$list[$i + 1]]) || mb_strlen($list[$i]) < 3 || mb_strlen($list[$i + 1]) < 3) {
                continue;
            }
            $phrase = $list[$i].' '.$list[$i + 1];
            $counts[$phrase] = ($counts[$phrase] ?? 0) + 1;
        }

        arsort($counts);
        $errors = [];
        foreach (array_slice($counts, 0, 3, true) as $phrase => $count) {
            if ($count > $limit) {
                $errors[] = "The phrase \"{$phrase}\" appears {$count} times; use it at most {$limit} times and vary the wording (\"it\", \"your store\", \"the platform\", or a specific name) so it does not read as keyword stuffing.";
            }
        }

        return $errors;
    }

    /**
     * @return list<string>
     */
    protected function notJustSentences(string $text): array
    {
        $sentences = preg_split('/(?<=[.!?])\s+/u', $text) ?: [];

        return collect($sentences)
            ->filter(static fn (string $s): bool => preg_match('/\b(?:not|isn[\'’]t|aren[\'’]t|wasn[\'’]t|weren[\'’]t|more than)\s+just\b[^.]{0,120}?(?:—|–|;|,|:)\s*(?:it[\'’]?s|it is|they[\'’]re|they are|but|rather|instead)\b/iu', $s) === 1
                || preg_match('/^(?:(?:it[\'’]s|it is|this is|that[\'’]s)\s+not|(?:it|this|that)\s+isn[\'’]t)\s+just\s+[^.!?]{1,40}[.!?]$/iu', trim($s)) === 1)
            ->map(static fn (string $s): string => Str::limit(trim($s), 200))
            ->values()
            ->all();
    }

    protected function visibleText(string $html): string
    {
        $html = (string) preg_replace('/\[\[IMG_\d+\]\]|\[featured_image\]/', ' ', $html);
        $html = (string) preg_replace('/<\/(p|h[1-6]|li|td|th)>/i', '$0 ', $html);
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim((string) preg_replace('/\s+/u', ' ', $text));
    }

    /**
     * @return list<string>
     */
    protected function bannedPhrases(): array
    {
        return array_values(array_filter(
            array_map('strval', (array) config('blogs.rewrite.banned_phrases', [])),
            static fn (string $p): bool => trim($p) !== ''
        ));
    }

    /**
     * @return list<string>
     */
    protected function allowedPaths(): array
    {
        return $this->allowedPathsCache ??= BlogInternalLinks::allowedPaths();
    }

    /**
     * @return list<string>
     */
    protected function externalHrefs(string $html): array
    {
        preg_match_all('#<a\b[^>]*\bhref=(["\'])(.*?)\1#is', $html, $anchors);

        return array_values(array_filter(
            array_map('trim', $anchors[2]),
            static fn (string $href): bool => BlogInternalLinks::normalizeInternalHref($href) === null
        ));
    }

    /**
     * @return list<array{section: string, reason: string}>
     */
    protected function normalizeSections(mixed $sections): array
    {
        if (! is_array($sections)) {
            return [];
        }

        $out = [];
        foreach ($sections as $row) {
            if (! is_array($row) || trim((string) ($row['section'] ?? '')) === '') {
                continue;
            }
            $out[] = [
                'section' => trim((string) $row['section']),
                'reason' => trim((string) ($row['reason'] ?? '')),
            ];
        }

        return $out;
    }
}
