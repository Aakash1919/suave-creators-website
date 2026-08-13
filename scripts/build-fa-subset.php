<?php

/**
 * Build a marketing-only Font Awesome 6.7.2 CSS subset.
 * One file replaces fontawesome.min.css + solid + brands + regular CDN sheets.
 */

$root = dirname(__DIR__);
$out = $root.'/public/css/fontawesome-subset.css';

$scanDirs = [
    $root.'/resources/views/frontend',
    $root.'/resources/views/components/frontend',
    $root.'/resources/views/components/layouts',
    $root.'/app/View/Components/Frontend',
    $root.'/app/View/Components/Layouts',
    $root.'/app/Support/Frontend',
];

$icons = [];

foreach ($scanDirs as $dir) {
    if (! is_dir($dir)) {
        continue;
    }
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if (! $file->isFile()) {
            continue;
        }
        $name = $file->getFilename();
        if (! str_ends_with($name, '.php') && ! str_ends_with($name, '.blade.php')) {
            continue;
        }
        $text = file_get_contents($file->getPathname());
        if ($text === false) {
            continue;
        }
        if (preg_match_all('/\bfa-(?:solid|regular|brands|fas|far|fab)\s+fa-([a-z0-9-]+)/i', $text, $m)) {
            foreach ($m[1] as $icon) {
                $icons[$icon] = true;
            }
        }
        if (preg_match_all("/'icon'\\s*=>\\s*'fa-([a-z0-9-]+)'/", $text, $m)) {
            foreach ($m[1] as $icon) {
                if (! in_array($icon, ['solid', 'regular', 'brands'], true)) {
                    $icons[$icon] = true;
                }
            }
        }
    }
}

// Dynamic brand icons from FourCardSection defaults
foreach (['laravel', 'react', 'angular', 'node-js', 'vuejs', 'wordpress', 'shopify', 'magento'] as $icon) {
    $icons[$icon] = true;
}
// Footer socials
foreach (['facebook-f', 'linkedin-in', 'instagram'] as $icon) {
    $icons[$icon] = true;
}

$iconList = array_keys($icons);
sort($iconList);

function fetchCss(string $url): string
{
    $ctx = stream_context_create([
        'http' => [
            'timeout' => 30,
            'header' => "User-Agent: SuaveFASubsetBuilder\r\n",
        ],
    ]);
    $css = @file_get_contents($url, false, $ctx);
    if ($css === false) {
        throw new RuntimeException("Failed to download {$url}");
    }

    return $css;
}

function absoluteWebfonts(string $css): string
{
    return preg_replace(
        '#url\((\.\./webfonts/([^)]+))\)#',
        'url(https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/webfonts/$2)',
        $css
    ) ?? $css;
}

function sheetPrelude(string $css): string
{
    // Keep :root vars, @font-face, and weight helpers — stop before icon catalog.
    if (preg_match('/^(.*?\.(?:fa-solid|fa-brands|fa-regular|fas|fab|far)\{font-weight:\d+\})/s', $css, $m)) {
        return absoluteWebfonts($m[1]);
    }

    // Fallback: everything before first .fa-<name>{--fa:
    if (preg_match('/^(.*?)(?=\.fa-[a-z0-9-]+\{\-\-fa:)/s', $css, $m)) {
        return absoluteWebfonts(rtrim($m[1]));
    }

    return absoluteWebfonts($css);
}

function extractIconVars(string $css, array $iconList): string
{
    $kept = [];
    foreach ($iconList as $name) {
        $pattern = '/(?:^|})((?:[^}{]*?)\.fa-'.preg_quote($name, '/').'(?![a-z0-9-])(?:\s*,\s*[^,{]+)*\{--fa:[^}]+\})/';
        if (preg_match_all($pattern, $css, $matches)) {
            foreach ($matches[1] as $rule) {
                $kept[trim($rule)] = true;
            }
        }
    }

    return implode('', array_keys($kept));
}

$core = fetchCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css');
$solid = fetchCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css');
$brands = fetchCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css');
$regular = fetchCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/regular.min.css');

// Minimal core (shorthand + only rules icons need). Avoids FA size/animation utility bloat.
$minimalCore = <<<'CSS'
:host,:root{--fa-style-family-brands:"Font Awesome 6 Brands";--fa-style-family-classic:"Font Awesome 6 Free";--fa-font-solid:normal 900 1em/1 "Font Awesome 6 Free";--fa-font-regular:normal 400 1em/1 "Font Awesome 6 Free";--fa-font-brands:normal 400 1em/1 "Font Awesome 6 Brands"}
.fa,.fa-brands,.fa-regular,.fa-solid,.fab,.far,.fas{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:var(--fa-display,inline-block);font-style:normal;font-variant:normal;line-height:1;text-rendering:auto}
.fa-brands:before,.fa-regular:before,.fa-solid:before,.fa:before,.fab:before,.far:before,.fas:before{content:var(--fa)}
.fa-classic,.fa-regular,.fa-solid,.far,.fas{font-family:"Font Awesome 6 Free"}
.fa-brands,.fab{font-family:"Font Awesome 6 Brands"}
.fa-solid,.fas{font-weight:900}
.fa-regular,.far{font-weight:400}
.fa-brands,.fab{font-weight:400}
CSS;

$iconCss = extractIconVars($core, $iconList).extractIconVars($brands, $iconList).extractIconVars($regular, $iconList);

$css = '/*! Font Awesome Free 6.7.2 subset — Suave Creators marketing (scripts/build-fa-subset.php) */'."\n"
    .$minimalCore."\n"
    .$iconCss."\n"
    .sheetPrelude($solid)."\n"
    .sheetPrelude($brands)."\n"
    .sheetPrelude($regular)."\n";

file_put_contents($out, $css);

$missing = [];
foreach ($iconList as $name) {
    if (! str_contains($css, '.fa-'.$name.'{') && ! str_contains($css, '.fa-'.$name.',')) {
        $missing[] = $name;
    }
}

echo "Wrote {$out}\n";
echo 'Size: '.strlen($css).' bytes (~'.round(strlen($css) / 1024, 1)." KiB)\n";
echo 'Icons: '.count($iconList).' ('.implode(', ', $iconList).")\n";
if ($missing) {
    echo 'MISSING glyph rules: '.implode(', ', $missing)."\n";
    exit(1);
}
echo "All icon glyph rules present.\n";
