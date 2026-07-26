<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    Illuminate\Http\Request::create('/', 'GET')
);

$html = $response->getContent();
file_put_contents(__DIR__.'/../storage/app/home-render.html', $html);

preg_match_all('/<img\b[^>]*>/i', $html, $matches);
$imgs = $matches[0] ?? [];

$missing = [];
$empty = [];
$noTitle = 0;

foreach ($imgs as $tag) {
    if (! preg_match('/\balt\s*=/i', $tag)) {
        $missing[] = $tag;
    } elseif (preg_match('/\balt\s*=\s*(""|\'\')/', $tag)) {
        $empty[] = $tag;
    }
    if (! preg_match('/\btitle\s*=/i', $tag)) {
        $noTitle++;
    }
}

echo 'img_total='.count($imgs).PHP_EOL;
echo 'missing_alt='.count($missing).PHP_EOL;
echo 'empty_alt='.count($empty).PHP_EOL;
echo 'without_title='.$noTitle.PHP_EOL;

foreach (array_slice($missing, 0, 40) as $tag) {
    echo 'MISSING: '.substr(preg_replace('/\s+/', ' ', $tag), 0, 200).PHP_EOL;
}
foreach (array_slice($empty, 0, 40) as $tag) {
    echo 'EMPTY: '.substr(preg_replace('/\s+/', ' ', $tag), 0, 200).PHP_EOL;
}

preg_match_all('/<a\b[^>]*>/i', $html, $aMatches);
$links = $aMatches[0] ?? [];
echo 'a_total='.count($links).PHP_EOL;
