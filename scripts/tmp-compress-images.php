<?php

declare(strict_types=1);

$files = [
    'public/assets/case-studies/turbo-trans/ttc_caseStudy.webp',
    'public/assets/product/hero_banner.gif',
    'public/assets/media/it-solutions-banner.webp',
    'public/assets/media/ecommerce-banner.webp',
];

foreach ($files as $f) {
    if (! is_file($f)) {
        echo "MISSING: {$f}\n";
        continue;
    }
    $info = getimagesize($f);
    $size = filesize($f);
    echo basename($f).' | '.$info[0].'x'.$info[1].' | '.round($size / 1024, 1).' KB | '.($info['mime'] ?? '')."\n";
}

echo 'webp support: '.(function_exists('imagewebp') ? 'yes' : 'no')."\n";
echo 'gif support: '.(function_exists('imagecreatefromgif') ? 'yes' : 'no')."\n";
