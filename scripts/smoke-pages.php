<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$uris = [
    route('home', absolute: false),
    route('about-us', absolute: false),
    route('contact-us', absolute: false),
    route('services', absolute: false),
    '/service/web-development-services',
    route('industries', absolute: false),
    route('industry.show', ['slug' => 'healthcare-software-development'], false),
    route('product', absolute: false),
    route('blogs', absolute: false),
    route('privacy-policy', absolute: false),
    route('terms-and-conditions', absolute: false),
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
