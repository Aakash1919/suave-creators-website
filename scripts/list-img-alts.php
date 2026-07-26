<?php

$html = file_get_contents(__DIR__.'/../storage/app/home-render.html');
preg_match_all('/<img\b[^>]*\balt="([^"]*)"[^>]*>/i', $html, $matches);

foreach ($matches[1] as $i => $alt) {
    echo ($i + 1).'. '.$alt.PHP_EOL;
}
