<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$uris = [
    '/',
    '/about-us',
    '/contact-us',
    '/services',
    '/service/web-development-services',
    '/industries',
    '/industries/healthcare',
    '/product',
    '/blogs',
    '/blog/digital-strategy-that-creates-value',
];

foreach ($uris as $uri) {
    $request = Illuminate\Http\Request::create($uri, 'GET');
    try {
        $response = $kernel->handle($request);
        $status = $response->getStatusCode();
        echo str_pad($uri, 50).$status.PHP_EOL;
        $kernel->terminate($request, $response);
    } catch (Throwable $e) {
        echo str_pad($uri, 50).'ERR '.$e->getMessage().PHP_EOL;
    }
}
