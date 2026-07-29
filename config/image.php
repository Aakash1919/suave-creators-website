<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Thumbnail Settings
    |--------------------------------------------------------------------------
    |
    | Used by ImageVariantService when admin uploads produce original + medium.
    |
    */

    'thumbnails' => [
        'medium' => [
            'width' => 480,
            'height' => 280,
            'suffix' => '-medium',
        ],
    ],

    'quality' => 85,
];
