<?php

$root = dirname(__DIR__);
$viewsDir = $root.'/resources/views/frontend';

$consultationAlts = [
    'consultation-team-member-1.png' => 'Suave Creators UI UX designer for custom software projects',
    'consultation-team-member-2.png' => 'Suave Creators software engineer for web development services',
    'consultation-team-leader.png' => 'Suave Creators project lead for enterprise software solutions',
    'consultation-designer.png' => 'Suave Creators product designer for CRM development',
    'consultation-team-lead.png' => 'Suave Creators team lead for digital product delivery',
    'consultation-team-collaborating.png' => 'Suave Creators team collaborating on software development',
];

foreach (glob($viewsDir.'/*.blade.php') as $file) {
    $text = file_get_contents($file);
    $original = $text;

    $text = str_replace('og-:title=', ':og-title=', $text);
    $text = str_replace('og-:description=', ':og-description=', $text);

    foreach ($consultationAlts as $fileName => $alt) {
        $text = preg_replace(
            '/src="\{\{ asset\(\'assets\/team\/'.preg_quote($fileName, '/').'\'\) \}\}" alt=""/',
            'src="{{ asset(\'assets/team/'.$fileName.'\') }}" alt="'.$alt.'" title="'.$alt.'"',
            $text
        );
    }

    $text = preg_replace_callback('/<img\b([^>]*?)alt=""([^>]*?)>/i', function (array $m): string {
        $attrs = $m[1].$m[2];
        if (str_contains($attrs, 'aria-hidden="true"')) {
            $alt = 'Decorative graphic for Suave Creators website section';

            return '<img'.$m[1].'alt="'.$alt.'" title="'.$alt.'"'.$m[2].'>';
        }

        if (preg_match('/src="\{\{ \$([^}]+)\}\}"/', $attrs, $srcMatch)) {
            $alt = '{{ $'.($srcMatch[1] ?? 'alt').' }}';
        } elseif (preg_match('/src="\{\{ asset\(\'([^\']+)\'\) \}\}"/', $attrs, $assetMatch)) {
            $path = $assetMatch[1];
            $basename = basename($path, '.'.pathinfo($path, PATHINFO_EXTENSION));
            $alt = ucwords(str_replace(['-', '_'], ' ', $basename)).' for Suave Creators software development';
        } elseif (preg_match('/src="\{\{ \$(?:service|industry|logo|item|card|feature|tech|stat)\[[\'"]([^\'"]+)[\'"]\]/', $attrs, $varMatch)) {
            $alt = '{{ $'.explode('[', $varMatch[0])[0].' ?? \'\' }} service visual';
            $alt = '{{ ($'.trim(str_replace(['src="{{ ', '}}'], '', explode('[', $varMatch[0])[0]), '$').'[\'alt\'] ?? \'Suave Creators service icon\') }}';
        } else {
            $alt = 'Suave Creators software development visual';
        }

        if (str_contains($alt, '{{')) {
            return '<img'.$m[1].'alt="'.$alt.'" title="'.$alt.'"'.$m[2].'>';
        }

        return '<img'.$m[1].'alt="'.$alt.'" title="'.$alt.'"'.$m[2].'>';
    }, $text);

    $text = preg_replace('/(<img\b(?![^>]*\btitle=)[^>]*\balt="([^"]+)")/i', '$1 title="$2"', $text);

    if ($text !== $original) {
        file_put_contents($file, $text);
        echo 'Fixed '.basename($file).PHP_EOL;
    }
}

echo "Done.\n";
