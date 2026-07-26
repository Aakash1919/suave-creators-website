<?php

/**
 * Add title="..." to every Blade <img> that has alt but no title.
 * title value mirrors the alt attribute value (including Blade expressions).
 */

$root = dirname(__DIR__).'/resources/views';
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
);

$updatedFiles = 0;
$updatedTags = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php' && ! str_ends_with($file->getFilename(), '.blade.php')) {
        continue;
    }
    if (! str_ends_with($file->getFilename(), '.blade.php')) {
        continue;
    }

    $path = $file->getPathname();
    $text = file_get_contents($path);
    $original = $text;

    // Walk <img ...> tags; treat "=>" and "->" as non-terminators
    $offset = 0;
    $result = '';
    while (($start = stripos($text, '<img', $offset)) !== false) {
        $result .= substr($text, $offset, $start - $offset);
        $i = $start + 4;
        $len = strlen($text);
        while ($i < $len) {
            $ch = $text[$i];
            if ($ch === '>' && ! isArrowGreater($text, $i)) {
                $i++;
                break;
            }
            $i++;
        }
        $tag = substr($text, $start, $i - $start);
        $newTag = ensureImgTitle($tag);
        if ($newTag !== $tag) {
            $updatedTags++;
        }
        $result .= $newTag;
        $offset = $i;
    }
    $result .= substr($text, $offset);

    if ($result !== $original) {
        file_put_contents($path, $result);
        $updatedFiles++;
        echo 'Updated '.$path.PHP_EOL;
    }
}

echo "files={$updatedFiles} tags={$updatedTags}".PHP_EOL;

function isArrowGreater(string $text, int $i): bool
{
    // "=>" or "->"
    if ($i <= 0) {
        return false;
    }

    return ($text[$i - 1] === '=' || $text[$i - 1] === '-');
}

function ensureImgTitle(string $tag): string
{
    if (preg_match('/\btitle\s*=/i', $tag)) {
        return $tag;
    }
    if (! preg_match('/\balt\s*=\s*("([^"]*)"|\'([^\']*)\'|\{\{[\s\S]*?\}\})/i', $tag, $m)) {
        return $tag;
    }

    $altAttr = $m[0]; // full alt=...
    $titleAttr = preg_replace('/^alt/i', 'title', $altAttr);

    // Insert title immediately after alt attribute
    return preg_replace('/'.preg_quote($altAttr, '/').'/', $altAttr.' '.$titleAttr, $tag, 1);
}
