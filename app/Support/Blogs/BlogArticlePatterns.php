<?php

namespace App\Support\Blogs;

/**
 * Distinct article layout patterns for AI trend drafts.
 *
 * Tables, charts, and stats are optional filler — required only when the
 * pattern’s identity depends on them (comparison → table, stats-led → stats).
 */
class BlogArticlePatterns
{
    /**
     * @return array<string, array{label: string, required_blocks: list<string>, instructions: string}>
     */
    public static function all(): array
    {
        return [
            'framework' => [
                'label' => 'Named-method framework guide',
                'required_blocks' => ['blog-takeaways', 'blog-checklist', 'blog-insight'],
                'instructions' => <<<'TXT'
Shape — framework guide:
- Name a 4–5 step method (invent a short memorable name, not "Our Process"). Explain each step in prose under its own <h2>.
- Include .blog-takeaways early and a .blog-checklist on at least one step.
- Close with .blog-insight plus roadmap implications and a soft Suave Creators line.
- Do NOT use .blog-results on this shape.
- Optional visuals (default OFF): .blog-table-wrap, .blog-stats, .blog-chart — add only when they clarify the method more than prose.
TXT,
            ],
            'story' => [
                'label' => 'Transformation narrative',
                'required_blocks' => ['blog-results', 'blog-takeaways', 'blog-insight'],
                'instructions' => <<<'TXT'
Shape — transformation story:
- Add .blog-results ("Results at a glance") with 3 qualitative outcomes — no fake numbers.
- Narrative <h2>s: the business, what outgrew the systems, the choice, how it was built, what changed, why a partner matters.
- Include .blog-takeaways and .blog-insight.
- Do NOT invent a client name. Speak in composite scenes or second person.
- Prefer omitting .blog-checklist and .blog-stats.
- Optional visuals (default OFF): .blog-table-wrap (before/after only if columns help), .blog-chart.
TXT,
            ],
            'comparison' => [
                'label' => 'Buyer comparison',
                'required_blocks' => ['blog-takeaways', 'blog-table-wrap', 'blog-insight'],
                'instructions' => <<<'TXT'
Shape — buyer comparison (table IS required here):
- Center the article on a detailed .blog-table-wrap comparing Option A vs Option B across 5–7 concrete factors.
- Follow with sections that unpack the table rows — not a named step method.
- Include .blog-takeaways and .blog-insight.
- Do NOT use .blog-results, .blog-checklist, or a named framework brand.
- Optional visuals (default OFF): .blog-stats, .blog-chart — only if they clarify the decision.
TXT,
            ],
            'checklist' => [
                'label' => 'Action checklist deep-dive',
                'required_blocks' => ['blog-takeaways', 'blog-checklist', 'blog-insight'],
                'instructions' => <<<'TXT'
Shape — action checklist deep-dive:
- Structure most <h2>s around practical readiness work.
- Include at least two .blog-checklist blocks (different titles) with 5–7 actions each.
- Include .blog-takeaways and .blog-insight.
- Do NOT use .blog-results or .blog-stats.
- Optional visuals (default OFF): .blog-table-wrap, .blog-chart. Prefer checklist items over tables.
TXT,
            ],
            'stats-led' => [
                'label' => 'Operating-metrics opener',
                'required_blocks' => ['blog-stats', 'blog-takeaways', 'blog-insight'],
                'instructions' => <<<'TXT'
Shape — stats-led operating brief (stats ARE required here):
- Open with .blog-stats (3–4 concrete operating changes) BEFORE the first <h2>.
- Then .blog-takeaways and body sections that explain how to achieve those operating changes.
- Close with .blog-insight.
- Do NOT use .blog-results or .blog-checklist.
- Never invent survey percentages for .blog-stat__value — use artifacts and timeboxes only.
- Optional visuals (default OFF): .blog-chart, .blog-table-wrap.
TXT,
            ],
            'roadmap' => [
                'label' => 'Phased delivery roadmap',
                'required_blocks' => ['blog-takeaways', 'blog-checklist', 'blog-insight'],
                'instructions' => <<<'TXT'
Shape — phased delivery roadmap:
- Structure the article as 4–5 sequenced phases, with one <h2> per phase.
- Invent phase headings that fit THIS topic (e.g. "Map the intake handoff", "Pilot one clinic workflow"). Never reuse stock labels like Discover, Pilot, Harden, Scale, Assess, or Strategy as bare <h2> titles.
- Cover duration cues and exit criteria inside each phase section in prose.
- Include .blog-takeaways, one .blog-checklist for the first release gate, and .blog-insight.
- Do NOT use .blog-results or .blog-stats.
- Do NOT brand the path as a catchy acronym method unless the article_shape is framework.
- Optional visuals (default OFF): .blog-table-wrap, .blog-chart. If you include a chart, invent topic-specific row labels — never default to Assess / Pilot / Harden.
TXT,
            ],
        ];
    }

    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        return array_keys(self::all());
    }

    public static function isValid(string $key): bool
    {
        return array_key_exists($key, self::all());
    }

    /**
     * @return array{label: string, required_blocks: list<string>, instructions: string}|null
     */
    public static function get(string $key): ?array
    {
        return self::all()[$key] ?? null;
    }

    /**
     * Infer which pattern an existing HTML body most closely matches.
     */
    public static function detectFromHtml(string $html): ?string
    {
        $html = trim($html);
        if ($html === '') {
            return null;
        }

        $has = static fn (string $needle): bool => str_contains($html, $needle);
        $hasResults = $has('blog-results');
        $hasTakeaways = $has('blog-takeaways');
        $hasChecklist = $has('blog-checklist');
        $hasStats = $has('blog-stat');
        $hasChart = $has('blog-chart');
        $hasTable = $has('blog-table-wrap') || $has('<table');
        $hasInsight = $has('blog-insight');

        if (! $hasTakeaways && ! $hasResults && ! $hasTable && ! $hasChart && ! $hasInsight) {
            return null;
        }

        if ($hasResults) {
            return 'story';
        }

        if ($hasStats && ! $hasChecklist) {
            if (preg_match('/class="[^"]*\bblog-stats\b/i', $html, $m, PREG_OFFSET_CAPTURE)
                && preg_match('/<h2\b/i', $html, $h, PREG_OFFSET_CAPTURE)
                && (int) $m[0][1] < (int) $h[0][1]) {
                return 'stats-led';
            }

            if ($hasTable) {
                return 'comparison';
            }

            return 'stats-led';
        }

        if ($hasTable && ! $hasChecklist) {
            return 'comparison';
        }

        if ($hasChecklist && ! $hasStats) {
            $checklistCount = substr_count($html, 'blog-checklist');
            if ($checklistCount >= 2) {
                return 'checklist';
            }

            return 'roadmap';
        }

        if ($hasChecklist && $hasStats) {
            return 'framework';
        }

        if ($hasChecklist) {
            return 'roadmap';
        }

        return $hasInsight || $hasTakeaways ? 'framework' : null;
    }

    /**
     * Whether HTML contains the blocks required for a given pattern.
     */
    public static function htmlMatches(string $pattern, string $html): bool
    {
        $definition = self::get($pattern);
        if ($definition === null) {
            return false;
        }

        foreach ($definition['required_blocks'] as $block) {
            if ($block === 'blog-stats') {
                if (! str_contains($html, 'blog-stat')) {
                    return false;
                }

                continue;
            }

            if ($block === 'blog-chart') {
                if (! str_contains($html, 'blog-chart')) {
                    return false;
                }

                continue;
            }

            if (! str_contains($html, $block)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Pick the next pattern that is least represented in recent usage.
     *
     * @param  list<string>  $recentPatterns  newest-first detected pattern keys
     * @param  list<string>  $exclude         patterns already chosen in this run
     */
    public static function chooseNext(array $recentPatterns = [], array $exclude = []): string
    {
        $keys = self::keys();
        $excludeLookup = array_fill_keys(array_values(array_filter($exclude, static fn (mixed $key): bool => is_string($key) && self::isValid($key))), true);
        $candidates = array_values(array_filter(
            $keys,
            static fn (string $key): bool => ! isset($excludeLookup[$key])
        ));

        if ($candidates === []) {
            $candidates = $keys;
        }

        $recentValid = array_values(array_filter(
            $recentPatterns,
            static fn (mixed $key): bool => is_string($key) && self::isValid($key)
        ));

        $unseen = array_values(array_diff($candidates, $recentValid));
        if ($unseen !== []) {
            return $unseen[0];
        }

        $counts = array_fill_keys($candidates, 0);
        foreach ($recentValid as $key) {
            if (isset($counts[$key])) {
                $counts[$key]++;
            }
        }

        asort($counts);

        return (string) array_key_first($counts);
    }
}
