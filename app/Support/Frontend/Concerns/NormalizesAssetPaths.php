<?php

namespace App\Support\Frontend\Concerns;

use Illuminate\Support\Str;

trait NormalizesAssetPaths
{
    protected function normalizeAssetPath(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        $path = (string) Str::of($path)->ltrim('/');

        // Legacy flat images/ paths are no longer used; leave assets/ paths intact.
        return $path;
    }

    /**
     * Normalize a media path. Callers should pass full categorized paths
     * (e.g. assets/icons/web-development-icon.svg). Bare filenames are left unchanged.
     */
    protected function normalizeImageAssetPath(?string $path): string
    {
        return $this->normalizeAssetPath($path);
    }
}
