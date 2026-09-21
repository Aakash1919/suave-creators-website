<?php

namespace App\Support\Blogs;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;

class BlogHtmlSupport
{
    /**
     * Void / self-closing tags that are never treated as empty-content wrappers.
     */
    protected const VOID_TAGS = 'area|base|br|col|embed|hr|img|input|link|meta|param|source|track|wbr';

    /**
     * @var array<string, string>
     */
    protected const MIME_EXTENSIONS = [
        'jpeg' => 'jpg',
        'jpg' => 'jpg',
        'png' => 'png',
        'gif' => 'gif',
        'webp' => 'webp',
        'svg+xml' => 'svg',
        'svg' => 'svg',
        'bmp' => 'bmp',
        'x-icon' => 'ico',
        'vnd.microsoft.icon' => 'ico',
    ];

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

    /**
     * Pixel size of a local public-disk image, when the file exists.
     *
     * @return array{0: int, 1: int}|null
     */
    public static function localImageDimensions(string $src): ?array
    {
        $path = self::publicDiskPathFromSrc($src);
        if ($path === null) {
            return null;
        }

        $absolute = Storage::disk('public')->path($path);
        if (! is_file($absolute)) {
            return null;
        }

        $info = @getimagesize($absolute);
        if (! is_array($info) || (int) ($info[0] ?? 0) < 1 || (int) ($info[1] ?? 0) < 1) {
            return null;
        }

        return [(int) $info[0], (int) $info[1]];
    }

    /**
     * Extract Base64 / data-URI / inline SVG, fill empty alts, drop empty tags,
     * and normalize article headings to H2 → H3 (page H1 stays in the Blade hero).
     *
     * @return array{
     *     content: string,
     *     images_written: int,
     *     alts_updated: int,
     *     empty_tags_removed: int,
     *     failures: int,
     *     messages: list<string>
     * }
     */
    public static function sanitizeContent(
        string $html,
        string $slug,
        string $title,
        bool $dryRun = false,
        ?Filesystem $disk = null,
    ): array {
        $disk ??= Storage::disk('public');
        $messages = [];
        $index = self::nextImageIndex($disk, $slug);

        $imageResult = self::rewriteImages($html, $slug, $title, $disk, $dryRun, $index, $messages);
        $html = $imageResult['content'];
        $index = $imageResult['index'];
        $imagesWritten = $imageResult['images_written'];
        $altsUpdated = $imageResult['alts_updated'];
        $failures = $imageResult['failures'];

        $cssResult = self::rewriteCssDataUris($html, $slug, $disk, $dryRun, $index, $messages);
        $html = $cssResult['content'];
        $index = $cssResult['index'];
        $imagesWritten += $cssResult['images_written'];
        $failures += $cssResult['failures'];

        $svgResult = self::rewriteInlineSvgs($html, $slug, $title, $disk, $dryRun, $index, $messages);
        $html = $svgResult['content'];
        $imagesWritten += $svgResult['images_written'];
        $failures += $svgResult['failures'];

        $html = self::upgradeInsecureHttpUrls($html);
        [$html, $emptyRemoved] = self::removeEmptyTags($html);
        $html = self::wrapBareTables($html);
        $html = self::decorateContentImages($html, $title);
        $html = self::normalizeArticleHeadings($html, $title);
        $html = self::stripInlineFonts($html);

        return [
            'content' => $html,
            'images_written' => $imagesWritten,
            'alts_updated' => $altsUpdated,
            'empty_tags_removed' => $emptyRemoved,
            'failures' => $failures,
            'messages' => $messages,
        ];
    }

    /**
     * Article outline: one page H1 lives in the Blade hero, so body copy uses H2 → H3.
     */
    public static function normalizeArticleHeadings(string $html, string $title = ''): string
    {
        if ($html === '') {
            return $html;
        }

        $html = self::unwrapNestedHeadings($html);
        $html = self::removeDuplicateLeadTitle($html, $title);
        $html = self::demoteArticleH1($html);
        $html = self::promoteHeadingsWhenMissingH2($html);
        $html = self::convertStyledHeadingParagraphs($html);

        return $html;
    }

    /**
     * Drop pasted typefaces so article copy uses the site font (PP Mori / Roboto Flex).
     * Leaves font-size / font-weight so heading promotion can still read them first.
     */
    public static function stripInlineFonts(string $html): string
    {
        if ($html === '') {
            return $html;
        }

        $html = (string) preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $html);
        $html = (string) preg_replace('/<\/?font\b[^>]*>/i', '', $html);
        $html = (string) preg_replace('/\sface\s*=\s*(["\'])[^"\']*\1/i', '', $html);

        $updated = preg_replace_callback(
            '/\sstyle\s*=\s*(["\'])(.*?)\1/is',
            static function (array $matches): string {
                $quote = $matches[1];
                $css = $matches[2];
                $css = (string) preg_replace('/(?:^|;)\s*font-family\s*:[^;]*/i', '', $css);
                $css = trim($css, " \t\n\r;");
                $css = trim((string) preg_replace('/\s*;\s*/', '; ', $css), " \t;");

                if ($css === '') {
                    return '';
                }

                return ' style='.$quote.$css.$quote;
            },
            $html
        );

        return is_string($updated) ? $updated : $html;
    }

    /**
     * Wrap every table in .blog-table-wrap so article tables can scroll horizontally on mobile.
     */
    public static function wrapBareTables(string $html): string
    {
        if ($html === '' || stripos($html, '<table') === false) {
            return $html;
        }

        if (! preg_match_all('/<table\b[^>]*>.*?<\/table>/is', $html, $matches, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        $shift = 0;

        foreach ($matches[0] as [$tableHtml, $pos]) {
            $pos += $shift;
            $prefixLength = min(120, $pos);
            $before = substr($html, $pos - $prefixLength, $prefixLength);

            if (preg_match('/<div\b[^>]*class="[^"]*\bblog-table-wrap\b[^"]*"[^>]*>\s*$/i', $before)) {
                continue;
            }

            $wrapped = '<div class="blog-table-wrap">'.$tableHtml.'</div>';
            $html = substr_replace($html, $wrapped, $pos, strlen($tableHtml));
            $shift += strlen($wrapped) - strlen($tableHtml);
        }

        return $html;
    }

    /**
     * Add missing alt/title/loading/decoding/width/height on article images.
     */
    public static function decorateContentImages(string $html, string $fallbackAlt): string
    {
        if ($html === '' || ! str_contains(strtolower($html), '<img')) {
            return $html;
        }

        $fallbackAlt = $fallbackAlt !== '' ? $fallbackAlt : 'Suave Creators blog article';

        $updated = preg_replace_callback(
            '/<img\b([^>]*)>/i',
            static function (array $matches) use ($fallbackAlt): string {
                $attrs = $matches[1];
                $src = self::attributeValue($attrs, 'src') ?? '';

                $alt = self::attributeValue($attrs, 'alt');
                if ($alt === null || trim($alt) === '') {
                    $attrs = self::setAttribute($attrs, 'alt', $fallbackAlt);
                    $alt = $fallbackAlt;
                }

                $title = self::attributeValue($attrs, 'title');
                if ($title === null || trim($title) === '') {
                    $attrs = self::setAttribute($attrs, 'title', $alt);
                }

                $loading = self::attributeValue($attrs, 'loading');
                if ($loading === null || trim($loading) === '') {
                    $attrs = self::setAttribute($attrs, 'loading', 'lazy');
                }

                $decoding = self::attributeValue($attrs, 'decoding');
                if ($decoding === null || trim($decoding) === '') {
                    $attrs = self::setAttribute($attrs, 'decoding', 'async');
                }

                $hasWidth = self::attributeValue($attrs, 'width') !== null;
                $hasHeight = self::attributeValue($attrs, 'height') !== null;
                if ((! $hasWidth || ! $hasHeight) && $src !== '') {
                    $dims = self::localImageDimensions($src);
                    if ($dims !== null) {
                        if (! $hasWidth) {
                            $attrs = self::setAttribute($attrs, 'width', (string) $dims[0]);
                        }
                        if (! $hasHeight) {
                            $attrs = self::setAttribute($attrs, 'height', (string) $dims[1]);
                        }
                    }
                }

                return '<img'.$attrs.'>';
            },
            $html
        );

        return is_string($updated) ? $updated : $html;
    }

    /**
     * Drop wrapper headings that contain nested headings or block tags.
     */
    protected static function unwrapNestedHeadings(string $html): string
    {
        if ($html === '' || ! preg_match('/<h[1-6]\b/i', $html)) {
            return $html;
        }

        for ($i = 0; $i < 8; $i++) {
            $next = preg_replace_callback(
                '/<(h[1-6])(\b[^>]*)>([\s\S]*?)<\/\1>/i',
                static function (array $matches): string {
                    $tag = $matches[1];
                    $attrs = $matches[2];
                    $inner = $matches[3];

                    if (! preg_match('/<(?:h[1-6]|p|div|table|ul|ol|figure)\b/i', $inner)) {
                        return $matches[0];
                    }

                    if (! preg_match('/^(.*?)(<(?:h[1-6]|p|div|table|ul|ol|figure)\b[\s\S]*)$/is', $inner, $parts)) {
                        return $matches[0];
                    }

                    $lead = $parts[1];
                    $rest = (string) preg_replace('/(?:<br\s*\/?\s*>|\s)*<\/span>\s*$/i', '', $parts[2]);
                    $leadText = trim(html_entity_decode(strip_tags($lead), ENT_QUOTES | ENT_HTML5));

                    if ($leadText === '') {
                        return $rest;
                    }

                    $lead = (string) preg_replace('/<span\b[^>]*>\s*$/i', '', $lead);

                    return '<'.$tag.$attrs.'>'.$lead.'</'.$tag.'>'.$rest;
                },
                $html
            );

            if (! is_string($next) || $next === $html) {
                break;
            }

            $html = $next;
        }

        return $html;
    }

    /**
     * Remove a heading-styled first block that repeats the page title.
     */
    protected static function removeDuplicateLeadTitle(string $html, string $title): string
    {
        $title = trim($title);
        if ($html === '' || $title === '') {
            return $html;
        }

        if (! preg_match('/^\s*(<(?:p|h[1-6])\b[^>]*>.*?<\/(?:p|h[1-6])>)/is', $html, $matches)) {
            return $html;
        }

        $plain = trim((string) preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($matches[1]), ENT_QUOTES | ENT_HTML5)));
        if ($plain === '' || mb_strlen($plain) > 120) {
            return $html;
        }

        $styled = (bool) preg_match(
            '/<h[1-6]\b|font-size:\s*2[0-9]px|<(?:b|strong)\b|font-weight:\s*700/i',
            $matches[1]
        );
        if (! $styled || ! self::isDuplicateLeadTitle($plain, $title)) {
            return $html;
        }

        return ltrim(substr($html, strlen($matches[0])));
    }

    protected static function isDuplicateLeadTitle(string $lead, string $title): bool
    {
        $leadNormalized = self::normalizeHeadingText($lead);
        $titleNormalized = self::normalizeHeadingText($title);

        if ($leadNormalized === '' || $titleNormalized === '') {
            return false;
        }

        if ($leadNormalized === $titleNormalized) {
            return true;
        }

        if (
            (str_starts_with($titleNormalized, $leadNormalized) || str_starts_with($leadNormalized, $titleNormalized))
            && mb_strlen($leadNormalized) >= 24
        ) {
            return true;
        }

        $leadTokens = array_values(array_filter(explode(' ', $leadNormalized)));
        $titleTokens = array_values(array_filter(explode(' ', $titleNormalized)));
        $shared = count(array_intersect($leadTokens, $titleTokens));

        return $shared >= 5 && ($shared / max(count($leadTokens), 1)) >= 0.55;
    }

    protected static function normalizeHeadingText(string $text): string
    {
        $text = mb_strtolower($text);
        $text = (string) preg_replace('/[^a-z0-9\s]+/u', ' ', $text);

        return trim((string) preg_replace('/\s+/u', ' ', $text));
    }

    /**
     * Page hero already renders the H1 — body H1s become H2.
     */
    protected static function demoteArticleH1(string $html): string
    {
        if ($html === '' || ! preg_match('/<h1\b/i', $html)) {
            return $html;
        }

        return self::renameHeadingLevel($html, 1, 2);
    }

    /**
     * Pasted Google Docs posts often start at H3. Promote H3 → H2 when no H2 exists.
     */
    protected static function promoteHeadingsWhenMissingH2(string $html): string
    {
        if ($html === '' || preg_match('/<h2\b/i', $html) || ! preg_match('/<h3\b/i', $html)) {
            return $html;
        }

        $html = self::renameHeadingLevel($html, 3, 2);
        $html = self::renameHeadingLevel($html, 4, 3);
        $html = self::renameHeadingLevel($html, 5, 4);
        $html = self::renameHeadingLevel($html, 6, 5);

        return $html;
    }

    protected static function renameHeadingLevel(string $html, int $from, int $to): string
    {
        $updated = preg_replace_callback(
            '/<\/?h'.$from.'\b/i',
            static function (array $matches) use ($to): string {
                $slash = str_starts_with($matches[0], '</') ? '/' : '';

                return '<'.$slash.'h'.$to;
            },
            $html
        );

        return is_string($updated) ? $updated : $html;
    }

    /**
     * Turn short bold 24px / 18px / numbered paragraphs into headings (outside tables).
     */
    protected static function convertStyledHeadingParagraphs(string $html): string
    {
        if ($html === '' || stripos($html, '<p') === false) {
            return $html;
        }

        $parts = preg_split('/(<table\b.*?<\/table>)/is', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (! is_array($parts)) {
            return $html;
        }

        foreach ($parts as $i => $part) {
            if ($part === '' || preg_match('/^<table\b/i', $part)) {
                continue;
            }

            $parts[$i] = self::convertStyledHeadingParagraphsInFragment($part);
        }

        return implode('', $parts);
    }

    protected static function convertStyledHeadingParagraphsInFragment(string $html): string
    {
        $updated = preg_replace_callback(
            '/<p\b([^>]*)>(.*?)<\/p>/is',
            static function (array $matches): string {
                $inner = $matches[2];
                if (preg_match('/<(?:a|img|h[1-6]|table|ul|ol)\b/i', $inner)) {
                    return $matches[0];
                }

                $plain = trim((string) preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($inner), ENT_QUOTES | ENT_HTML5)));
                $length = mb_strlen($plain);
                if ($length < 12 || $length > 90) {
                    return $matches[0];
                }

                if (preg_match('/^(python|javascript|typescript|php|sql|bash|shell)\s*:?$/i', $plain)) {
                    return $matches[0];
                }

                if (preg_match('/[{}=<>]|::/', $plain)) {
                    return $matches[0];
                }

                $markup = $matches[0];
                $is24 = (bool) preg_match('/font-size:\s*24px/i', $markup);
                $is18 = (bool) preg_match('/font-size:\s*18px/i', $markup);
                $isBold = (bool) preg_match('/<(?:b|strong)\b|font-weight:\s*700/i', $markup);
                $isNumbered = (bool) preg_match('/^\d+\.\s+\S/u', $plain);

                if ($is24 && $isBold) {
                    return '<h2>'.$inner.'</h2>';
                }

                if ($isNumbered && $isBold) {
                    return '<h3>'.$inner.'</h3>';
                }

                if ($is18 && $isBold && ! str_ends_with($plain, '.') && ! str_ends_with($plain, ':')) {
                    return '<h3>'.$inner.'</h3>';
                }

                return $matches[0];
            },
            $html
        );

        return is_string($updated) ? $updated : $html;
    }

    /**
     * @param  list<string>  $messages
     * @return array{content: string, images_written: int, alts_updated: int, failures: int, index: int}
     */
    protected static function rewriteImages(
        string $content,
        string $slug,
        string $title,
        Filesystem $disk,
        bool $dryRun,
        int $index,
        array &$messages,
    ): array {
        $imagesWritten = 0;
        $altsUpdated = 0;
        $failures = 0;
        $altValue = $title !== '' ? $title : $slug;

        $updated = preg_replace_callback(
            '/<img\b([^>]*)>/i',
            static function (array $matches) use (
                $disk,
                $slug,
                $dryRun,
                $altValue,
                &$index,
                &$imagesWritten,
                &$altsUpdated,
                &$failures,
                &$messages,
            ): string {
                $attrs = $matches[1];
                $src = self::attributeValue($attrs, 'src');
                if ($src === null || $src === '') {
                    return $matches[0];
                }

                $newSrc = $src;
                $wroteImage = false;

                $extracted = self::decodeDataUri($src);
                if ($extracted !== null) {
                    $stored = self::storeImageBinary(
                        $extracted['binary'],
                        $extracted['ext'],
                        $slug,
                        $index,
                        $disk,
                        $dryRun,
                        $messages,
                    );

                    if ($stored === null) {
                        $failures++;

                        return $matches[0];
                    }

                    $newSrc = $stored['src'];
                    $index = $stored['index'];
                    $imagesWritten++;
                    $wroteImage = true;
                } elseif (! self::isBlogContentImageSrc($src, $slug)) {
                    return $matches[0];
                }

                $currentAlt = self::attributeValue($attrs, 'alt');
                $needsAlt = $currentAlt === null || trim($currentAlt) === '';

                if (! $wroteImage && ! $needsAlt) {
                    if ($newSrc !== $src) {
                        $attrs = self::setAttribute($attrs, 'src', $newSrc);
                    }

                    return '<img'.$attrs.'>';
                }

                if ($needsAlt) {
                    $altsUpdated++;
                    $attrs = self::setAttribute($attrs, 'alt', $altValue);
                }

                $attrs = self::setAttribute($attrs, 'src', $newSrc);

                return '<img'.$attrs.'>';
            },
            $content
        );

        if (! is_string($updated)) {
            $messages[] = "{$slug}: image rewrite failed";

            return [
                'content' => $content,
                'images_written' => 0,
                'alts_updated' => 0,
                'failures' => $failures + 1,
                'index' => $index,
            ];
        }

        return [
            'content' => $updated,
            'images_written' => $imagesWritten,
            'alts_updated' => $altsUpdated,
            'failures' => $failures,
            'index' => $index,
        ];
    }

    /**
     * @param  list<string>  $messages
     * @return array{content: string, images_written: int, failures: int, index: int}
     */
    protected static function rewriteCssDataUris(
        string $html,
        string $slug,
        Filesystem $disk,
        bool $dryRun,
        int $index,
        array &$messages,
    ): array {
        if ($html === '' || ! str_contains($html, 'data:image')) {
            return [
                'content' => $html,
                'images_written' => 0,
                'failures' => 0,
                'index' => $index,
            ];
        }

        $imagesWritten = 0;
        $failures = 0;

        $updated = preg_replace_callback(
            '/url\(\s*([\'"]?)(data:image\/[a-zA-Z0-9.+-]+;base64,[A-Za-z0-9+\/= \r\n]+)\1\s*\)/i',
            static function (array $matches) use (
                $disk,
                $slug,
                $dryRun,
                &$index,
                &$imagesWritten,
                &$failures,
                &$messages,
            ): string {
                $extracted = self::decodeDataUri($matches[2]);
                if ($extracted === null) {
                    $failures++;

                    return $matches[0];
                }

                $stored = self::storeImageBinary(
                    $extracted['binary'],
                    $extracted['ext'],
                    $slug,
                    $index,
                    $disk,
                    $dryRun,
                    $messages,
                );

                if ($stored === null) {
                    $failures++;

                    return $matches[0];
                }

                $index = $stored['index'];
                $imagesWritten++;

                return 'url(\''.$stored['src'].'\')';
            },
            $html
        );

        return [
            'content' => is_string($updated) ? $updated : $html,
            'images_written' => $imagesWritten,
            'failures' => $failures,
            'index' => $index,
        ];
    }

    /**
     * Extract inline `<svg>` markup to a public-disk file (any size, including embedded data: images).
     *
     * @param  list<string>  $messages
     * @return array{content: string, images_written: int, failures: int}
     */
    protected static function rewriteInlineSvgs(
        string $html,
        string $slug,
        string $title,
        Filesystem $disk,
        bool $dryRun,
        int $index,
        array &$messages,
    ): array {
        if ($html === '' || stripos($html, '<svg') === false) {
            return [
                'content' => $html,
                'images_written' => 0,
                'failures' => 0,
            ];
        }

        $imagesWritten = 0;
        $failures = 0;
        $altValue = $title !== '' ? $title : $slug;

        $updated = preg_replace_callback(
            '/<svg\b[^>]*>.*?<\/svg>/is',
            static function (array $matches) use (
                $disk,
                $slug,
                $dryRun,
                $altValue,
                &$index,
                &$imagesWritten,
                &$failures,
                &$messages,
            ): string {
                $svg = $matches[0];

                $stored = self::storeImageBinary(
                    $svg,
                    'svg',
                    $slug,
                    $index,
                    $disk,
                    $dryRun,
                    $messages,
                    convertToWebp: false,
                );

                if ($stored === null) {
                    $failures++;

                    return $svg;
                }

                $index = $stored['index'];
                $imagesWritten++;

                $attrs = ' src="'.e($stored['src']).'" alt="'.e($altValue).'" title="'.e($altValue).'" loading="lazy" decoding="async"';

                return '<img'.$attrs.'>';
            },
            $html
        );

        return [
            'content' => is_string($updated) ? $updated : $html,
            'images_written' => $imagesWritten,
            'failures' => $failures,
        ];
    }

    /**
     * @return array{binary: string, ext: string}|null
     */
    protected static function decodeDataUri(string $src): ?array
    {
        $src = trim($src);

        if (preg_match('/^data:image\/([a-zA-Z0-9.+-]+);base64,([A-Za-z0-9+\/=\s]+)$/i', $src, $dataUri)) {
            $mimeSubtype = strtolower($dataUri[1]);
            $ext = self::MIME_EXTENSIONS[$mimeSubtype] ?? null;
            if ($ext === null) {
                return null;
            }

            $binary = base64_decode(preg_replace('/\s+/', '', $dataUri[2]) ?? '', true);
            if ($binary === false || $binary === '') {
                return null;
            }

            return ['binary' => $binary, 'ext' => $ext];
        }

        if (preg_match('/^data:image\/svg\+xml(?:;charset=[^;,]+)?(?:;base64)?,(.+)$/i', $src, $svgUri)) {
            $payload = html_entity_decode($svgUri[1], ENT_QUOTES | ENT_HTML5);
            if (str_contains(strtolower($src), ';base64,')) {
                $binary = base64_decode(preg_replace('/\s+/', '', $payload) ?? '', true);
            } else {
                $binary = rawurldecode($payload);
            }

            if (! is_string($binary) || $binary === '') {
                return null;
            }

            return ['binary' => $binary, 'ext' => 'svg'];
        }

        return null;
    }

    /**
     * @param  list<string>  $messages
     * @return array{src: string, index: int, path: string}|null
     */
    protected static function storeImageBinary(
        string $binary,
        string $ext,
        string $slug,
        int $index,
        Filesystem $disk,
        bool $dryRun,
        array &$messages,
        bool $convertToWebp = true,
    ): ?array {
        $finalExt = $ext;
        $finalBinary = $binary;

        if ($convertToWebp && self::canConvertToWebp($ext)) {
            $converted = self::encodeWebp($binary);
            if ($converted !== null) {
                $finalBinary = $converted;
                $finalExt = 'webp';
            }
        }

        $path = "blogs/content/{$slug}-{$index}.{$finalExt}";
        while ($disk->exists($path)) {
            $index++;
            $path = "blogs/content/{$slug}-{$index}.{$finalExt}";
        }

        if (! $dryRun) {
            $disk->makeDirectory('blogs/content');
            if (! $disk->put($path, $finalBinary)) {
                $messages[] = "{$slug}: failed to write {$path}";

                return null;
            }
        }

        $messages[] = ($dryRun ? 'would write' : 'wrote')." {$path} (".strlen($finalBinary).' bytes)';

        return [
            'src' => '/storage/'.ltrim(str_replace('\\', '/', $path), '/'),
            'index' => $index + 1,
            'path' => $path,
        ];
    }

    protected static function canConvertToWebp(string $ext): bool
    {
        return in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'bmp', 'webp'], true);
    }

    protected static function encodeWebp(string $binary): ?string
    {
        try {
            $manager = new ImageManager(new Driver);
            $quality = (int) config('image.quality', 85);
            $encoded = $manager->read($binary)->encodeByExtension('webp', quality: $quality);
            $bytes = (string) $encoded;

            return $bytes !== '' ? $bytes : null;
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @return array{0: string, 1: int}
     */
    public static function removeEmptyTags(string $html): array
    {
        $removed = 0;
        $previous = null;
        $pattern = '/<([a-zA-Z][a-zA-Z0-9]*)\b[^>]*>(?:\s|&nbsp;|&#160;|&#xA0;|<br\s*\/?\s*>)*<\/\1\s*>/iu';

        while ($previous !== $html) {
            $previous = $html;
            $next = preg_replace_callback(
                $pattern,
                static function (array $matches) use (&$removed): string {
                    $tag = strtolower($matches[1]);
                    if (preg_match('/^(?:'.self::VOID_TAGS.')$/i', $tag)) {
                        return $matches[0];
                    }

                    if (preg_match('/\b(?:blog-chart__bar|blog-chart__track|data-width\s*=)/i', $matches[0])) {
                        return $matches[0];
                    }

                    $removed++;

                    return '';
                },
                $html
            );

            if (! is_string($next)) {
                break;
            }

            $html = $next;
        }

        $html = (string) preg_replace("/[ \t]+\n/", "\n", $html);
        $html = (string) preg_replace("/\n{3,}/", "\n\n", $html);

        return [$html, $removed];
    }

    protected static function isBlogContentImageSrc(string $src, string $slug): bool
    {
        $path = parse_url($src, PHP_URL_PATH);
        if (! is_string($path) || $path === '') {
            $path = $src;
        }

        $path = str_replace('\\', '/', $path);

        return (bool) preg_match(
            '#/storage/blogs/content/'.preg_quote($slug, '#').'-\d+\.[a-z0-9]+$#i',
            $path
        );
    }

    protected static function attributeValue(string $attrs, string $name): ?string
    {
        if (! preg_match('/\b'.preg_quote($name, '/').'\s*=\s*(["\'])/i', $attrs, $m, PREG_OFFSET_CAPTURE)) {
            return null;
        }

        $quote = $m[1][0];
        $valueStart = $m[1][1] + strlen($quote);
        $valueEnd = strpos($attrs, $quote, $valueStart);
        if ($valueEnd === false) {
            return null;
        }

        return html_entity_decode(substr($attrs, $valueStart, $valueEnd - $valueStart), ENT_QUOTES | ENT_HTML5);
    }

    protected static function setAttribute(string $attrs, string $name, string $value): string
    {
        $encoded = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $pattern = '/\b'.preg_quote($name, '/').'\s*=\s*(["\'])/i';

        if (preg_match($pattern, $attrs, $m, PREG_OFFSET_CAPTURE)) {
            $quote = $m[1][0];
            $nameStart = $m[0][1];
            $valueStart = $m[1][1] + strlen($quote);
            $valueEnd = strpos($attrs, $quote, $valueStart);
            if ($valueEnd !== false) {
                $attrs = substr($attrs, 0, $nameStart).$name.'="'.$encoded.'"'.substr($attrs, $valueEnd + strlen($quote));
            } else {
                $attrs = rtrim($attrs).' '.$name.'="'.$encoded.'"';
            }
        } else {
            $attrs = rtrim($attrs).' '.$name.'="'.$encoded.'"';
        }

        $attrs = self::removeDuplicateAttribute($attrs, $name);

        if ($attrs !== '' && ! str_starts_with($attrs, ' ')) {
            $attrs = ' '.$attrs;
        }

        return $attrs;
    }

    /**
     * Keep the first attribute occurrence; drop later duplicates (e.g. a failed src rewrite).
     */
    protected static function removeDuplicateAttribute(string $attrs, string $name): string
    {
        $pattern = '/\s+'.preg_quote($name, '/').'\s*=\s*(["\'])/i';
        $seen = false;
        $offset = 0;

        while (preg_match($pattern, $attrs, $m, PREG_OFFSET_CAPTURE, $offset)) {
            $quote = $m[1][0];
            $start = $m[0][1];
            $valueStart = $m[1][1] + strlen($quote);
            $valueEnd = strpos($attrs, $quote, $valueStart);
            if ($valueEnd === false) {
                break;
            }

            if (! $seen) {
                $seen = true;
                $offset = $valueEnd + strlen($quote);

                continue;
            }

            $attrs = substr($attrs, 0, $start).substr($attrs, $valueEnd + strlen($quote));
        }

        return $attrs;
    }

    protected static function nextImageIndex(Filesystem $disk, string $slug): int
    {
        if (! $disk->exists('blogs/content')) {
            return 1;
        }

        $max = 0;

        foreach ($disk->files('blogs/content') as $file) {
            $base = basename(str_replace('\\', '/', $file));
            if (! str_starts_with($base, $slug.'-')) {
                continue;
            }

            if (preg_match('/^'.preg_quote($slug, '/').'-(\d+)\.[a-z0-9]+$/i', $base, $m)) {
                $max = max($max, (int) $m[1]);
            }
        }

        return $max + 1;
    }
}
