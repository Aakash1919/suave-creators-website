<?php

declare(strict_types=1);

$source = __DIR__.'/../public/assets/product/product-hero-banner.webp';
$destination = __DIR__.'/../public/assets/product/product-og-banner.webp';
$targetWidth = 1200;
$targetHeight = 630;
$targetRatio = $targetWidth / $targetHeight;

if (! is_file($source)) {
    fwrite(STDERR, "Source not found: {$source}\n");
    exit(1);
}

$image = imagecreatefromwebp($source);
if ($image === false) {
    fwrite(STDERR, "Failed to load source image.\n");
    exit(1);
}

$sourceWidth = imagesx($image);
$sourceHeight = imagesy($image);
$sourceRatio = $sourceWidth / $sourceHeight;

if ($sourceRatio > $targetRatio) {
    $cropHeight = $sourceHeight;
    $cropWidth = (int) round($sourceHeight * $targetRatio);
    $cropX = (int) round(($sourceWidth - $cropWidth) / 2);
    $cropY = 0;
} else {
    $cropWidth = $sourceWidth;
    $cropHeight = (int) round($sourceWidth / $targetRatio);
    $cropX = 0;
    $cropY = (int) round(($sourceHeight - $cropHeight) / 2);
}

$output = imagecreatetruecolor($targetWidth, $targetHeight);
imagealphablending($output, true);
imagesavealpha($output, true);

$success = imagecopyresampled(
    $output,
    $image,
    0,
    0,
    $cropX,
    $cropY,
    $targetWidth,
    $targetHeight,
    $cropWidth,
    $cropHeight,
);

if (! $success) {
    fwrite(STDERR, "Failed to resize image.\n");
    exit(1);
}

if (! imagewebp($output, $destination, 85)) {
    fwrite(STDERR, "Failed to write destination image.\n");
    exit(1);
}

[$width, $height] = getimagesize($destination) ?: [0, 0];

echo "Created {$destination} ({$width}x{$height})\n";

imagedestroy($image);
imagedestroy($output);
