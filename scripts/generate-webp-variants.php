<?php

declare(strict_types=1);

/**
 * Generate width-suffixed WebP variants (e.g. image-320.webp) from full-size sources.
 *
 * Usage:
 *   php scripts/generate-webp-variants.php [width ...] [--paths=path1,path2]
 *
 * Defaults: widths 320; all public/assets WebP files without an existing width suffix.
 */

$defaultWidths = [320];
$quality = 80;
$explicitPaths = [];

foreach (array_slice($argv, 1) as $arg) {
    if (str_starts_with($arg, '--paths=')) {
        $explicitPaths = array_filter(array_map('trim', explode(',', substr($arg, 8))));

        continue;
    }

    if (is_numeric($arg)) {
        $defaultWidths[] = (int) $arg;
    }
}

$defaultWidths = array_values(array_unique($defaultWidths));
sort($defaultWidths);

$assetsRoot = realpath(__DIR__.'/../public/assets');
if ($assetsRoot === false) {
    fwrite(STDERR, "Assets root not found.\n");
    exit(1);
}

$sources = $explicitPaths !== []
    ? $explicitPaths
    : collectWebpSources($assetsRoot);

$created = 0;
$skipped = 0;

foreach ($sources as $relativePath) {
    $sourcePath = $assetsRoot.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

    if (! is_file($sourcePath)) {
        fwrite(STDERR, "Skip missing source: {$relativePath}\n");
        $skipped++;

        continue;
    }

    $basePath = preg_replace('/\.webp$/', '', $relativePath);
    $dimensions = @getimagesize($sourcePath);

    if (! is_array($dimensions)) {
        fwrite(STDERR, "Skip unreadable: {$relativePath}\n");
        $skipped++;

        continue;
    }

    [$sourceWidth] = $dimensions;

    foreach ($defaultWidths as $targetWidth) {
        if ($targetWidth >= $sourceWidth) {
            continue;
        }

        $variantRelative = $basePath.'-'.$targetWidth.'.webp';
        $variantPath = $assetsRoot.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $variantRelative);

        if (is_file($variantPath)) {
            continue;
        }

        if (writeResizedWebp($sourcePath, $variantPath, $targetWidth, $quality)) {
            [$w, $h] = getimagesize($variantPath) ?: [0, 0];
            echo "Created {$variantRelative} ({$w}x{$h}, ".filesize($variantPath)." bytes)\n";
            $created++;
        } else {
            fwrite(STDERR, "Failed: {$variantRelative}\n");
            $skipped++;
        }
    }
}

echo "Done. Created {$created}, skipped {$skipped}.\n";

function collectWebpSources(string $assetsRoot): array
{
    $sources = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($assetsRoot, FilesystemIterator::SKIP_DOTS)
    );

    /** @var SplFileInfo $file */
    foreach ($iterator as $file) {
        if (! $file->isFile() || strtolower($file->getExtension()) !== 'webp') {
            continue;
        }

        $name = $file->getFilename();

        if (preg_match('/-\d+\.webp$/', $name)) {
            continue;
        }

        $sources[] = str_replace('\\', '/', substr($file->getPathname(), strlen($assetsRoot) + 1));
    }

    sort($sources);

    return $sources;
}

function writeResizedWebp(string $sourcePath, string $destinationPath, int $targetWidth, int $quality): bool
{
    $image = imagecreatefromwebp($sourcePath);

    if ($image === false) {
        return false;
    }

    $sourceWidth = imagesx($image);
    $sourceHeight = imagesy($image);
    $targetHeight = (int) round($sourceHeight * ($targetWidth / $sourceWidth));

    $output = imagecreatetruecolor($targetWidth, $targetHeight);
    imagealphablending($output, true);
    imagesavealpha($output, true);

    $success = imagecopyresampled(
        $output,
        $image,
        0,
        0,
        0,
        0,
        $targetWidth,
        $targetHeight,
        $sourceWidth,
        $sourceHeight,
    );

    imagedestroy($image);

    if (! $success) {
        imagedestroy($output);

        return false;
    }

    $written = imagewebp($output, $destinationPath, $quality);
    imagedestroy($output);

    return $written;
}
