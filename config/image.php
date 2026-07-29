<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Thumbnail Settings
    |--------------------------------------------------------------------------
    |
    | Used by ImageVariantService when admin uploads produce original + thumbs.
    |
    */

    'thumbnails' => [
        'small' => [
            'width' => 150,
            'height' => 150,
            'suffix' => '_small',
        ],
        'medium' => [
            'width' => 480,
            'height' => 280,
            'suffix' => '_medium',
        ],
    ],

    'quality' => 85,
];
