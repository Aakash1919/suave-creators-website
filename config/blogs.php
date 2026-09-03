<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI trend draft generation
    |--------------------------------------------------------------------------
    |
    | Scheduled artisan command generate:blog writes draft posts from an
    | optional --topic, or a customer-acquisition angle and current industry
    | trend (Tuesday + Friday by default). Requires a configured AI provider
    | (OPENAI_API_KEY / AI_DEFAULT_*).
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

];
