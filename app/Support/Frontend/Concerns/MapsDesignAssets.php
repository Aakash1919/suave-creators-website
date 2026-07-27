<?php

namespace App\Support\Frontend\Concerns;

trait MapsDesignAssets
{
    use NormalizesAssetPaths;

    /**
     * @return array<string, string>
     */
    protected static function designAssetMap(): array
    {
        static $map = null;

        if ($map !== null) {
            return $map;
        }

        $path = base_path('scripts/asset-path-map.json');

        if (! is_file($path)) {
            return $map = [];
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        if (! is_array($decoded)) {
            return $map = [];
        }

        $map = [];

        foreach ($decoded as $key => $value) {
            if (! is_string($key) || ! is_string($value)) {
                continue;
            }

            $normalizedKey = (string) str($key)->ltrim('/');

            if (str_starts_with($normalizedKey, '/')) {
                continue;
            }

            $map[$normalizedKey] = $value;
        }

        return $map;
    }

    protected static function mapDesignPath(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//') || str_starts_with($path, 'data:')) {
            return $path;
        }

        $imagePrefix = 'im'.'ages/';
        $trimmed = (string) str($path)->trim('/');
        $candidates = [
            $trimmed,
            $imagePrefix.$trimmed,
        ];

        if (str_starts_with($trimmed, $imagePrefix)) {
            $candidates[] = $trimmed;
        } else {
            $candidates[] = $imagePrefix.$trimmed;
        }

        $map = self::designAssetMap();

        foreach ($candidates as $candidate) {
            if (isset($map[$candidate])) {
                return $map[$candidate];
            }
        }

        if (str_starts_with($trimmed, 'assets/')) {
            return $trimmed;
        }

        if (str_starts_with($trimmed, 'im'.'ages/')) {
            return 'assets/media/'.(string) str($trimmed)->after('im'.'ages/');
        }

        return 'assets/media/'.$trimmed;
    }

    protected static function mapDesignData(mixed $data): mixed
    {
        $imageSegment = 'im'.'ages';

        if (is_string($data)) {
            if (str_contains($data, '/'.$imageSegment.'/') || str_starts_with($data, $imageSegment.'/')) {
                return self::mapDesignPath($data);
            }

            return $data;
        }

        if (! is_array($data)) {
            return $data;
        }

        $mapped = [];

        foreach ($data as $key => $value) {
            if (is_string($key) && in_array($key, ['url', 'href', 'introLinkUrl'], true) && is_string($value)) {
                $mapped[$key] = $value;

                continue;
            }

            $mapped[$key] = self::mapDesignData($value);
        }

        return $mapped;
    }

    protected static function containsLegacyImagePath(string $data): bool
    {
        $legacyPrefix = 'im'.'ages/';

        return str_contains($data, '/'.$legacyPrefix) || str_starts_with($data, $legacyPrefix);
    }

    protected static function dataPath(string $relative): string
    {
        return app_path('Support/Frontend/Data/'.$relative);
    }

    protected static function assetizeDesignData(mixed $data, ?string $key = null): mixed
    {
        $imageSegment = 'im'.'ages';

        if (is_string($data)) {
            if ($key !== null && in_array($key, ['url', 'href', 'introLinkUrl', 'content', 'quote', 'desc', 'description', 'text', 'title', 'label', 'name', 'role', 'slug', 'category', 'eyebrow', 'pageTitle', 'pageDescription', 'primaryCta', 'secondaryCta'], true)) {
                return $data;
            }

            if (str_starts_with($data, 'http://') || str_starts_with($data, 'https://') || str_starts_with($data, '//') || str_starts_with($data, 'data:')) {
                return $data;
            }

            $trimmed = (string) str($data)->ltrim('/');

            if (str_starts_with($trimmed, 'assets/')) {
                return asset($trimmed);
            }

            if (str_starts_with($trimmed, 'assetsicons/')) {
                return asset('assets/icons/'.(string) str($trimmed)->after('assetsicons/'));
            }

            if (str_contains($data, '/'.$imageSegment.'/') || str_starts_with($data, $imageSegment.'/')) {
                return asset(self::mapDesignPath($data));
            }

            return $data;
        }

        if (! is_array($data)) {
            return $data;
        }

        $assetized = [];

        foreach ($data as $childKey => $value) {
            $assetized[$childKey] = self::assetizeDesignData($value, is_string($childKey) ? $childKey : null);
        }

        return $assetized;
    }

}
