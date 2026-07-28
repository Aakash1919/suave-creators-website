<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI trend draft generation
    |--------------------------------------------------------------------------
    |
    | Scheduled artisan command blogs:generate-trend-drafts writes draft posts
    | from current industry trends (Tuesday + Friday by default). Requires a
    | configured AI provider (OPENAI_API_KEY / AI_DEFAULT_*).
    |
    */

    'trend_drafts' => [
        'enabled' => (bool) env('BLOG_TREND_DRAFTS_ENABLED', true),
        'time' => env('BLOG_TREND_DRAFTS_TIME', '09:00'),
        'count' => (int) env('BLOG_TREND_DRAFTS_COUNT', 1),
        'model' => env('BLOG_TREND_DRAFTS_MODEL', env('AI_DEFAULT_MODEL', 'gpt-4o-mini')),
        'recent_title_limit' => (int) env('BLOG_TREND_DRAFTS_RECENT_TITLE_LIMIT', 40),
        'style_example_limit' => (int) env('BLOG_TREND_DRAFTS_STYLE_EXAMPLE_LIMIT', 3),
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
