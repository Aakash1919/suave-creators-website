<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageVariantService
{
    /**
     * Store the original on the public disk and generate small + medium thumbs.
     *
     * @return array{original: string, small: string, medium: string}
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
            'small' => $thumbs['small'],
            'medium' => $thumbs['medium'],
        ];
    }

    /**
     * Generate small and medium thumbnails beside the original path.
     *
     * @return array{small: string, medium: string}
     */
    public function generateThumbnails(string $sourceAbsolutePath, string $originalPath): array
    {
        $pathInfo = pathinfo($originalPath);
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'] ?? 'jpg';
        $directory = $pathInfo['dirname'];

        $manager = new ImageManager(new Driver());
        $image = $manager->read($sourceAbsolutePath);
        $thumbnailPaths = [];
        $thumbnailConfig = config('image.thumbnails', []);
        $quality = (int) config('image.quality', 85);

        foreach ($thumbnailConfig as $size => $config) {
            $thumb = clone $image;
            $thumb->cover((int) $config['width'], (int) $config['height']);
            $thumbPath = $directory.'/'.$filename.$config['suffix'].'.'.$extension;
            $thumb->save(storage_path('app/public/'.$thumbPath), $quality);
            $thumbnailPaths[$size] = $thumbPath;
        }

        return [
            'small' => $thumbnailPaths['small'],
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
}
