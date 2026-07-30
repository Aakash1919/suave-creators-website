<?php

namespace App\Support\Blogs;

class BlogHtmlSupport
{
    /**
     * Upgrade static http:// links in href/src attributes to https://.
     * Does not touch SVG namespaces or embedded SVG data URIs.
     */
    public static function upgradeInsecureHttpUrls(string $html): string
    {
        return (string) preg_replace(
            '/\b(href|src)=(["\'])http:\/\//i',
            '$1=$2https://',
            $html
        );
    }

    /**
     * Collect public-disk image paths referenced by <img src> under blogs/.
     *
     * @return list<string>
     */
    public static function extractStorageImagePaths(string $html): array
    {
        if ($html === '' || ! preg_match_all('/<img\b[^>]*\bsrc=(["\'])([^"\']+)\1/i', $html, $matches)) {
            return [];
        }

        $paths = [];

        foreach ($matches[2] as $src) {
            $path = self::publicDiskPathFromSrc(html_entity_decode($src, ENT_QUOTES | ENT_HTML5));
            if ($path !== null && str_starts_with($path, 'blogs/')) {
                $paths[] = $path;
            }
        }

        return array_values(array_unique($paths));
    }

    /**
     * Resolve a public-disk relative path from an img src value.
     */
    public static function publicDiskPathFromSrc(string $src): ?string
    {
        $src = trim(str_replace('\\', '/', $src));
        if ($src === '' || str_starts_with($src, 'data:')) {
            return null;
        }

        if (str_starts_with($src, '/storage/')) {
            return ltrim(substr($src, strlen('/storage/')), '/');
        }

        if (str_starts_with($src, 'storage/')) {
            return ltrim(substr($src, strlen('storage/')), '/');
        }

        if (str_starts_with($src, 'blogs/')) {
            return $src;
        }

        $path = parse_url($src, PHP_URL_PATH);
        if (! is_string($path) || $path === '') {
            return null;
        }

        $marker = '/storage/';
        $pos = strpos($path, $marker);
        if ($pos === false) {
            return null;
        }

        return ltrim(substr($path, $pos + strlen($marker)), '/');
    }
}
