<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI trend draft generation
    |--------------------------------------------------------------------------
    |
    | Artisan command generate:blog writes draft posts from an optional
    | --topic, or a customer-acquisition angle and current industry trend.
    | The Tue/Fri schedule in routes/console.php is commented out by default;
    | run manually or uncomment the schedule. Requires a configured AI
    | provider (OPENAI_API_KEY / AI_DEFAULT_*).
    |
    */

    'trend_drafts' => [
        'enabled' => (bool) env('BLOG_TREND_DRAFTS_ENABLED', true),
        'time' => env('BLOG_TREND_DRAFTS_TIME', '09:00'),
        'count' => (int) env('BLOG_TREND_DRAFTS_COUNT', 1),
        'model' => env('BLOG_TREND_DRAFTS_MODEL', env('AI_DEFAULT_MODEL', 'gpt-4o-mini')),
        'recent_title_limit' => (int) env('BLOG_TREND_DRAFTS_RECENT_TITLE_LIMIT', 40),
        'style_example_limit' => (int) env('BLOG_TREND_DRAFTS_STYLE_EXAMPLE_LIMIT', 3),
        // Rotate layout patterns so consecutive drafts are structurally distinct.
        'recent_pattern_limit' => (int) env('BLOG_TREND_DRAFTS_RECENT_PATTERN_LIMIT', 12),
        'recent_opening_limit' => (int) env('BLOG_TREND_DRAFTS_RECENT_OPENING_LIMIT', 12),
        // Reject near-duplicate titles/content and retry generation.
        'uniqueness_max_attempts' => (int) env('BLOG_TREND_DRAFTS_UNIQUENESS_MAX_ATTEMPTS', 3),
        'uniqueness_compare_limit' => (int) env('BLOG_TREND_DRAFTS_UNIQUENESS_COMPARE_LIMIT', 80),
        'title_similarity_threshold' => (float) env('BLOG_TREND_DRAFTS_TITLE_SIMILARITY_THRESHOLD', 72),
        'content_similarity_threshold' => (float) env('BLOG_TREND_DRAFTS_CONTENT_SIMILARITY_THRESHOLD', 0.42),
    ],

    /*
    |--------------------------------------------------------------------------
    | AI SEO meta generation (edit form)
    |--------------------------------------------------------------------------
    |
    | Admin “Generate SEO meta” fills meta/OG fields in the browser only;
    | the editor must review and save. Does not write to the database.
    |
    */

    'seo_meta' => [
        'model' => env('BLOG_SEO_META_MODEL', env('AI_DEFAULT_MODEL', 'gpt-4o-mini')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Legacy blog rewrite (run-once:rewrite-legacy-blogs)
    |--------------------------------------------------------------------------
    |
    | Rewrites posts with id below `below_id` in the voice of the
    | human-written posts at or above it. Word-count target is the average
    | of those published posts ± `length_tolerance`. Images are never changed.
    |
    */

    'rewrite' => [
        'model' => env('BLOG_REWRITE_MODEL', 'gpt-4.1'),
        'below_id' => (int) env('BLOG_REWRITE_BELOW_ID', 70),
        'length_tolerance' => (float) env('BLOG_REWRITE_LENGTH_TOLERANCE', 0.15),
        'max_attempts' => (int) env('BLOG_REWRITE_MAX_ATTEMPTS', 4),
        'min_links' => (int) env('BLOG_REWRITE_MIN_LINKS', 3),
        'max_links' => (int) env('BLOG_REWRITE_MAX_LINKS', 7),
        'style_example_limit' => (int) env('BLOG_REWRITE_STYLE_EXAMPLE_LIMIT', 3),
        'banned_phrases' => [
            "in today's fast-paced",
            'in today’s fast-paced',
            "whether you're",
            'whether you’re',
            'digital landscape',
            'delve',
            'unlock',
            'revolutionize',
            'revolutionise',
            'game-changer',
            'game changer',
            'in conclusion',
            'harness the power',
            'seamless',
            'robust',
            "it's important to note",
            'it’s important to note',
            'elevate',
            'navigate the complexities',
            'leverage',
            'left on the table',
            'sweet spot',
            'non-negotiable',
            'cutting-edge',
            'empower',
            'the result?',
            'absolutely.',
            'look no further',
            'competitive edge',
            'secret sauce',
            'ever-evolving',
            'tapestry',
            // Interchangeable business filler.
            'drive growth',
            'drives growth',
            'driving growth',
            'drive revenue',
            'drives revenue',
            'move faster',
            'sell smarter',
            'work smarter',
            'on your own terms',
            'strategic investment',
            'continuous improvement',
            'grows with you',
            'grow with your business',
            'scale with you',
            'next level',
            'future-proof',
            'streamline',
            'competitive advantage',
            'stay ahead',
            'take control',
            'peace of mind',
            'digital presence',
            'in the long run',
            // Unbacked authority claims.
            'see it constantly',
            'see this constantly',
            'we routinely',
            'we often hear',
            'we frequently hear',
            'we hear from',
            'time and again',
            'time after time',
            'all too often',
            'in our experience',
            'more often than not',
            // Stock CTA labels.
            'scope your project',
            'explore our engineering',
            'ready to take',
        ],
        // Max times any two-word content phrase may repeat in the body (floor; grows by 1 per 250 words over 1,250).
        'max_phrase_repeats' => (int) env('BLOG_REWRITE_MAX_PHRASE_REPEATS', 5),
        // Single words with an unambiguous plain equivalent, swapped after each attempt (longer forms first).
        'plain_word_swaps' => [
            'seamlessly' => 'smoothly',
            'seamless' => 'smooth',
            'robustly' => 'reliably',
            'robust' => 'reliable',
            'empowering' => 'helping',
            'empowers' => 'helps',
            'empowered' => 'helped',
            'empower' => 'help',
            'elevates' => 'improves',
            'elevated' => 'improved',
            'elevating' => 'improving',
            'elevate' => 'improve',
            'cutting-edge' => 'modern',
            'ever-evolving' => 'changing',
            'non-negotiable' => 'essential',
            'revolutionizes' => 'changes',
            'revolutionized' => 'changed',
            'revolutionizing' => 'changing',
            'revolutionize' => 'change',
        ],
        // Max em dashes per 100 body words. 0 = none: em dashes read as machine-written, so the cleanup converts every one.
        'em_dash_per_100_words' => (float) env('BLOG_REWRITE_EM_DASH_PER_100_WORDS', 0),
    ],

];
