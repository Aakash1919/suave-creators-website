<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$uris = [
    '/',
    '/about-us',
    '/contact-us',
    '/services',
    '/service/web-development-services',
    '/industries',
    '/industries/healthcare',
    '/ai-powered-outreach-crm',
    '/blogs',
    '/blog/digital-strategy-that-creates-value',
    '/privacy-policy',
    '/terms-and-conditions',
];

foreach ($uris as $uri) {
    $request = Request::create($uri, 'GET');
    try {
        $response = $kernel->handle($request);
        $status = $response->getStatusCode();
        echo str_pad($uri, 50).$status.PHP_EOL;
        $kernel->terminate($request, $response);
    } catch (Throwable $e) {
        echo str_pad($uri, 50).'ERR '.$e->getMessage().PHP_EOL;
    }
}
