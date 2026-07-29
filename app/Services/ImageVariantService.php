<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use RuntimeException;

class ImageVariantService
{
    /**
     * Store the original on the public disk and generate a medium thumb.
     *
     * @return array{original: string, medium: string}
     */
    public function storeWithVariants(UploadedFile $file, string $directory, string $basename): array
    {
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $originalPath = $file->storeAs($directory, $basename.'.'.$ext, 'public');
        $thumbs = $this->generateThumbnails(
            $file->getRealPath() ?: $file->path(),
            $originalPath
        );

        return [
            'original' => $originalPath,
            'medium' => $thumbs['medium'],
        ];
    }

    /**
     * Generate a medium thumbnail from an already-stored public-disk original.
     *
     * @throws RuntimeException
     */
    public function generateMediumFromStored(string $originalPath): string
    {
        $normalized = ltrim(str_replace('\\', '/', $originalPath), '/');

        if (
            $normalized === ''
            || str_starts_with($normalized, 'http://')
            || str_starts_with($normalized, 'https://')
        ) {
            throw new RuntimeException('Cannot generate a medium thumb from a remote or empty image path.');
        }

        $absolute = storage_path('app/public/'.$normalized);

        if (! is_file($absolute)) {
            throw new RuntimeException("Original image not found on disk: {$normalized}");
        }

        $thumbs = $this->generateThumbnails($absolute, $normalized);

        return $thumbs['medium'];
    }

    /**
     * Generate medium thumbnail beside the original path.
     *
     * @return array{medium: string}
     */
    public function generateThumbnails(string $sourceAbsolutePath, string $originalPath): array
    {
        $pathInfo = pathinfo($originalPath);
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'] ?? 'jpg';
        $directory = $pathInfo['dirname'];

        $manager = new ImageManager(new Driver());
        $thumbnailPaths = [];
        $thumbnailConfig = config('image.thumbnails', []);
        $quality = (int) config('image.quality', 85);

        foreach ($thumbnailConfig as $size => $config) {
            // Re-read per size so we never keep multiple full-resolution clones in memory.
            $thumb = $manager->read($sourceAbsolutePath);
            $thumb->cover((int) $config['width'], (int) $config['height']);
            $thumbPath = $directory.'/'.$filename.$config['suffix'].'.'.$extension;
            $thumb->save(storage_path('app/public/'.$thumbPath), $quality);
            $thumbnailPaths[$size] = $thumbPath;
            unset($thumb);
        }

        if (! isset($thumbnailPaths['medium'])) {
            throw new RuntimeException('Medium thumbnail config is missing (config/image.php).');
        }

        return [
            'medium' => $thumbnailPaths['medium'],
        ];
    }

    /**
     * Delete stored image paths; skip empty, remote URLs, and public asset paths.
     */
    public function deletePaths(?string ...$paths): void
    {
        $disk = Storage::disk('public');

        foreach ($paths as $path) {
            if (! is_string($path) || $path === '') {
                continue;
            }

            $normalized = ltrim(str_replace('\\', '/', $path), '/');

            if (
                str_starts_with($normalized, 'http://')
                || str_starts_with($normalized, 'https://')
                || str_starts_with($normalized, 'assets/')
                || str_starts_with($normalized, 'storage/')
            ) {
                continue;
            }

            $disk->delete($normalized);
        }
    }

    /**
     * Guess a legacy `_small` sibling path for a stored original (if any).
     */
    public function legacySmallThumbPath(?string $originalPath): ?string
    {
        return $this->legacySiblingPath($originalPath, '_small');
    }

    /**
     * Guess a legacy `_medium` sibling path for a stored original (if any).
     */
    public function legacyMediumThumbPath(?string $originalPath): ?string
    {
        return $this->legacySiblingPath($originalPath, '_medium');
    }

    /**
     * Build a sibling path with the given suffix before the extension.
     */
    protected function legacySiblingPath(?string $originalPath, string $suffix): ?string
    {
        if (! is_string($originalPath) || $originalPath === '') {
            return null;
        }

        $normalized = ltrim(str_replace('\\', '/', $originalPath), '/');

        if (
            str_starts_with($normalized, 'http://')
            || str_starts_with($normalized, 'https://')
        ) {
            return null;
        }

        $pathInfo = pathinfo($normalized);
        $directory = $pathInfo['dirname'] ?? '';
        $filename = $pathInfo['filename'] ?? '';
        $extension = $pathInfo['extension'] ?? '';

        if ($filename === '' || $extension === '') {
            return null;
        }

        $prefix = ($directory === '.' || $directory === '') ? '' : $directory.'/';

        return $prefix.$filename.$suffix.'.'.$extension;
    }
}
