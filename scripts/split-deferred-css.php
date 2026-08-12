<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$source = $root.'/public/css/style.css';
$deferred = $root.'/public/css/style-deferred.css';

$content = file_get_contents($source);

if ($content === false) {
    fwrite(STDERR, "Unable to read {$source}\n");
    exit(1);
}

$deferredMarkers = [
    'ABOUT US',
    'PRODUCT',
    'BLOGS LISTING',
    'CONTACT FORM PANEL',
    'CONTACT REACH SECTION',
    'LEGAL PAGES',
    'INDUSTRY DETAIL SERVICES',
    'INDUSTRY DETAIL AGILE',
    'SERVICES LISTING',
];

$pattern = '/\/\* ===== ('.implode('|', array_map(static fn (string $marker): string => preg_quote($marker, '/'), $deferredMarkers)).') START ===== \*\/.*?\/\* ===== \1 END ===== \*\//s';

preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);

if ($matches[0] === []) {
    fwrite(STDERR, "No deferred CSS sections matched.\n");
    exit(1);
}

$deferredChunks = array_map(static fn (array $match): string => $match[0], $matches[0]);
$deferredCss = "/* Deferred marketing CSS — page-specific sections; load non-blocking on the homepage. */\n\n"
    .implode("\n\n", $deferredChunks)
    ."\n";

$coreCss = preg_replace($pattern, '', $content);
$coreCss = preg_replace("/\n{3,}/", "\n\n", (string) $coreCss);

file_put_contents($deferred, $deferredCss);
file_put_contents($source, $coreCss);

$deferredKb = round(strlen($deferredCss) / 1024, 1);
$coreKb = round(strlen($coreCss) / 1024, 1);

echo "Wrote style-deferred.css ({$deferredKb} KB)\n";
echo "Updated style.css ({$coreKb} KB)\n";
