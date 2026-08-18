<?php

return [

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
        'model' => env('CASE_STUDY_SEO_META_MODEL', env('AI_DEFAULT_MODEL', 'gpt-4o-mini')),
    ],

];
