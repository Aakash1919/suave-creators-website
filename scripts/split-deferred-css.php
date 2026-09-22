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
    'SINGLE BLOG',
    'INDUSTRY DETAIL SERVICES',
    'INDUSTRY DETAIL AGILE',
    'SERVICES LISTING',
];

$sectionPattern = '/\/\* ===== (.+?) START ===== \*\/.*?\/\* ===== \1 END ===== \*\//s';

/**
 * @return array<string, string>
 */
$extractSections = static function (string $css) use ($sectionPattern): array {
    if ($css === '' || ! preg_match_all($sectionPattern, $css, $matches)) {
        return [];
    }

    $sections = [];
    foreach ($matches[1] as $i => $name) {
        $sections[$name] = $matches[0][$i];
    }

    return $sections;
};

$fromSource = $extractSections($content);
$existingDeferred = is_readable($deferred) ? (string) file_get_contents($deferred) : '';
$fromDeferred = $extractSections($existingDeferred);

$extractedFromSource = [];
foreach ($deferredMarkers as $marker) {
    if (isset($fromSource[$marker])) {
        $extractedFromSource[$marker] = $fromSource[$marker];
    }
}

$merged = $fromDeferred;
foreach ($extractedFromSource as $name => $chunk) {
    $merged[$name] = $chunk;
}

if ($merged === []) {
    fwrite(STDERR, "No deferred CSS sections matched in style.css or style-deferred.css.\n");
    exit(1);
}

$ordered = [];
foreach ($deferredMarkers as $marker) {
    if (isset($merged[$marker])) {
        $ordered[] = $merged[$marker];
        unset($merged[$marker]);
    }
}
foreach ($merged as $chunk) {
    $ordered[] = $chunk;
}

$deferredCss = "/* Deferred marketing CSS — page-specific sections; load non-blocking on the homepage. */\n\n"
    .implode("\n\n", $ordered)
    ."\n";

$extractPattern = '/\/\* ===== ('.implode('|', array_map(static fn (string $marker): string => preg_quote($marker, '/'), $deferredMarkers)).') START ===== \*\/.*?\/\* ===== \1 END ===== \*\//s';
$coreCss = preg_replace($extractPattern, '', $content);
$coreCss = preg_replace("/\n{3,}/", "\n\n", (string) $coreCss);

file_put_contents($deferred, $deferredCss);
file_put_contents($source, $coreCss);

$deferredKb = round(strlen($deferredCss) / 1024, 1);
$coreKb = round(strlen($coreCss) / 1024, 1);

echo "Wrote style-deferred.css ({$deferredKb} KB)\n";
echo "Updated style.css ({$coreKb} KB)\n";
