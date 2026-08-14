<?php

/**
 * Router for `php artisan serve`.
 * Delegates to public/dev-server.php so static assets get long-lived Cache-Control
 * (Lighthouse "efficient cache lifetimes"). cwd is already public/ when Artisan serves.
 */
require __DIR__.'/public/dev-server.php';
