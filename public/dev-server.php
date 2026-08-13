<?php

/**
 * PHP built-in server router (local dev only).
 * Adds long-lived cache headers for static assets so Lighthouse cache audits pass on 127.0.0.1.
 *
 * Usage: php -S 127.0.0.1:8000 -t public public/dev-server.php
 * Or:    composer serve
 */

$publicPath = __DIR__;

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$file = $publicPath.$uri;

if ($uri !== '/' && is_file($file)) {
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    $cacheableExtensions = [
        'avif', 'bmp', 'css', 'eot', 'gif', 'ico', 'jpeg', 'jpg', 'js', 'mjs', 'map',
        'mp3', 'mp4', 'ogg', 'otf', 'pdf', 'png', 'svg', 'ttf', 'wav', 'webm', 'webp', 'woff', 'woff2',
    ];

    $mimeTypes = [
        'css' => 'text/css; charset=UTF-8',
        'js' => 'application/javascript; charset=UTF-8',
        'mjs' => 'application/javascript; charset=UTF-8',
        'map' => 'application/json; charset=UTF-8',
        'json' => 'application/json; charset=UTF-8',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'avif' => 'image/avif',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'otf' => 'font/otf',
        'eot' => 'application/vnd.ms-fontobject',
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'pdf' => 'application/pdf',
    ];

    if (isset($mimeTypes[$extension])) {
        header('Content-Type: '.$mimeTypes[$extension]);
    }

    if (in_array($extension, $cacheableExtensions, true)) {
        // Lighthouse "efficient cache lifetimes" — 1 year; URLs are versioned (?v=mtime / Vite hash).
        header('Cache-Control: public, max-age=31536000, immutable');
        header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
    }

    header('Content-Length: '.(string) filesize($file));
    header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT');

    // Built-in server serves HEAD poorly if body is emitted; skip body for HEAD.
    if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'HEAD') {
        readfile($file);
    }

    return true;
}

require_once $publicPath.'/index.php';
