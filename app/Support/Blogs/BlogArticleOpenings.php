<?php

namespace App\Support\Blogs;

/**
 * Opening styles for AI trend drafts — rotated independently of layout pattern
 * so consecutive posts do not start the same way.
 */
class BlogArticleOpenings
{
    /**
     * @return array<string, array{label: string, instructions: string}>
     */
    public static function all(): array
    {
        return [
            'scene' => [
                'label' => 'Operational scene',
                'instructions' => <<<'TXT'
Opening — operational scene:
- Start in the middle of a specific working moment (a stalled handoff, a queue that never clears, a weekly meeting that only reconciles spreadsheets).
- 1–2 short paragraphs before the first visual block or <h2>.
- Do not open with a question, a vs-contrast, or a checklist.
TXT,
            ],
            'question' => [
                'label' => 'Buyer question',
                'instructions' => <<<'TXT'
Opening — buyer question:
- Open with one sharp question a founder, CTO, or operator would actually ask (not a rhetorical SEO question).
- Answer it in the next paragraph with a clear stake: what breaks if they guess wrong.
- Do not open with a narrative scene, a vs-contrast sentence, or a checklist block.
TXT,
            ],
            'contrast' => [
                'label' => 'Measured contrast',
                'instructions' => <<<'TXT'
Opening — measured contrast:
- Open by juxtaposing two concrete states (before/after, build/buy, manual/automated, one owner/many tools) in the first paragraph.
- Keep it factual and calm — no hype adjectives.
- Do not open with a scene vignette, a standalone question, or a checklist block.
TXT,
            ],
            'checklist-first' => [
                'label' => 'Checklist-first',
                'instructions' => <<<'TXT'
Opening — checklist-first:
- After at most one short framing sentence, place a .blog-checklist BEFORE the first <h2>.
- The checklist should be 5–7 actions the reader can start this week.
- Then continue with body sections that unpack those actions.
- Do not open with a long scene, a standalone question, or a vs-contrast paragraph before the checklist.
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
     * @return array{label: string, instructions: string}|null
     */
    public static function get(string $key): ?array
    {
        return self::all()[$key] ?? null;
    }

    /**
     * Infer opening style from the start of an HTML body.
     */
    public static function detectFromHtml(string $html): ?string
    {
        $html = trim($html);
        if ($html === '') {
            return null;
        }

        $prefix = substr($html, 0, 1200);

        if (preg_match('/class="[^"]*\bblog-checklist\b/i', $prefix, $m, PREG_OFFSET_CAPTURE)) {
            $checklistPos = (int) $m[0][1];
            $h2Pos = preg_match('/<h2\b/i', $prefix, $h, PREG_OFFSET_CAPTURE)
                ? (int) $h[0][1]
                : PHP_INT_MAX;
            if ($checklistPos < $h2Pos) {
                return 'checklist-first';
            }
        }

        $plain = strtolower(trim(html_entity_decode(strip_tags($prefix), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
        $firstSentence = strtok($plain, ".!?\n") ?: $plain;

        if (str_contains($firstSentence, '?') || preg_match('/^(how|why|what|when|should|can|do)\b/', $firstSentence) === 1) {
            return 'question';
        }

        if (preg_match('/\b(vs\.?|versus|instead of|rather than|before .+ after|build vs|buy vs)\b/', $plain) === 1) {
            return 'contrast';
        }

        return 'scene';
    }

    /**
     * @param  list<string>  $recentOpenings
     * @param  list<string>  $exclude
     */
    public static function chooseNext(array $recentOpenings = [], array $exclude = []): string
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
            $recentOpenings,
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
