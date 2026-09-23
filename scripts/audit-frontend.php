<?php

use App\Support\Frontend\BlogSupport;
use App\Support\Frontend\ServiceSupport;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();
$app->instance('request', Request::create('/', 'GET'));

$serviceSlugs = (new ReflectionClass(ServiceSupport::class))->getConstant('SLUGS') ?: [];
$industrySlugs = [];
$industryDir = base_path('app/Support/Frontend/Data/industries');
if (is_dir($industryDir)) {
    foreach (glob($industryDir.DIRECTORY_SEPARATOR.'*.php') ?: [] as $file) {
        $industrySlugs[] = basename($file, '.php');
    }
}

$uris = [
    route('home', absolute: false),
    route('about-us', absolute: false),
    route('contact-us', absolute: false),
    route('services', absolute: false),
    route('industries', absolute: false),
    route('product', absolute: false),
    route('custom-crm-builder', absolute: false),
    route('blogs', absolute: false),
    route('case-studies', absolute: false),
    route('privacy-policy', absolute: false),
    route('terms-and-conditions', absolute: false),
    route('sitemap', absolute: false),
    route('llms.txt', absolute: false),
    route('robots', absolute: false),
    route('turbo-trans-case-study', absolute: false),
    route('ai-sales-coaching-case-study', absolute: false),
    route('outreach-case-study', absolute: false),
    route('tasks-case-study', absolute: false),
    route('teerrath-case-study', absolute: false),
    route('appointment-insurance-case-study', absolute: false),
    route('ai-product-matching-case-study', absolute: false),
];

foreach ($serviceSlugs as $slug) {
    $uris[] = route('service.show', ['slug' => $slug], false);
}
foreach ($industrySlugs as $slug) {
    $uris[] = route('industry.show', ['slug' => $slug], false);
}

try {
    foreach (BlogSupport::posts(limit: 20) as $post) {
        if (! empty($post['slug'])) {
            $uris[] = route('blog.show', ['slug' => $post['slug']], false);
        }
    }
} catch (Throwable $e) {
    echo 'Blog slugs skip: '.$e->getMessage().PHP_EOL;
}

$uris = array_values(array_unique($uris));
$statusFail = [];
$redirects = [];
$assetFail = [];
$linkFail = [];
$public = realpath(__DIR__.'/../public');
$linkCache = [];

foreach ($uris as $uri) {
    $request = Request::create($uri, 'GET');
    try {
        $response = $kernel->handle($request);
        $status = $response->getStatusCode();
        $content = $response->getContent() ?: '';
        $contentType = (string) $response->headers->get('Content-Type');
        $location = $response->headers->get('Location');
        $kernel->terminate($request, $response);
    } catch (Throwable $e) {
        $statusFail[] = "{$uri} ERR ".$e->getMessage();

        continue;
    }

    if (in_array($status, [301, 302, 303, 307, 308], true)) {
        $redirects[] = "{$uri} {$status} -> {$location}";

        continue;
    }

    if ($status >= 400) {
        $statusFail[] = "{$uri} {$status}";

        continue;
    }

    $isHtml = str_contains($contentType, 'text/html') || str_starts_with(ltrim($content), '<');
    if (! $isHtml) {
        continue;
    }

    preg_match_all('/(?:src|href)=["\']([^"\']+)["\']/i', $content, $m1);
    preg_match_all('/url\(["\']?([^)"\']+)["\']?\)/i', $content, $m2);
    preg_match_all('/srcset=["\']([^"\']+)["\']/i', $content, $m3);

    $candidates = array_merge($m1[1] ?? [], $m2[1] ?? []);
    foreach ($m3[1] ?? [] as $srcset) {
        foreach (preg_split('/\s*,\s*/', $srcset) as $part) {
            $candidates[] = trim(explode(' ', trim($part))[0]);
        }
    }

    foreach ($candidates as $url) {
        if ($url === '' || str_starts_with($url, '#') || str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:') || str_starts_with($url, 'javascript:') || str_starts_with($url, 'data:')) {
            continue;
        }

        $pathInUrl = parse_url($url, PHP_URL_PATH) ?: $url;

        if (str_contains($pathInUrl, '/build/assets/')) {
            continue;
        }

        if (preg_match('#(?:^|/)assets/#', $pathInUrl)) {
            $path = preg_replace('#^.*?/assets/#', 'assets/', $pathInUrl);
            if ($path === '&' || strlen($path) < 8) {
                continue;
            }
            if (! preg_match('/\.(webp|png|jpe?g|gif|svg|ico|css|js|woff2?|mp4|webm)$/i', $path)) {
                continue;
            }
            $disk = $public.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, ltrim($path, '/'));
            if (! is_file($disk)) {
                $assetFail[$path] = $assetFail[$path] ?? $uri;
            }

            continue;
        }

        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            $pathOnly = $pathInUrl;

            if (preg_match('#\.(css|js|map|ico|xml|txt|webp|png|jpg|jpeg|gif|svg|woff2?)$#i', $pathOnly)) {
                if (str_starts_with($pathOnly, '/build/')) {
                    continue;
                }
                $disk = $public.DIRECTORY_SEPARATOR.ltrim(str_replace('/', DIRECTORY_SEPARATOR, $pathOnly), DIRECTORY_SEPARATOR);
                if (! is_file($disk)) {
                    $assetFail[$pathOnly] = $assetFail[$pathOnly] ?? $uri;
                }

                continue;
            }

            if (! array_key_exists($pathOnly, $linkCache)) {
                $lr = Request::create($pathOnly, 'GET');
                try {
                    $lres = $kernel->handle($lr);
                    $linkCache[$pathOnly] = $lres->getStatusCode();
                    $kernel->terminate($lr, $lres);
                } catch (Throwable $e) {
                    $linkCache[$pathOnly] = 0;
                }
            }

            $st = $linkCache[$pathOnly];
            if ($st === 0 || $st >= 400) {
                $key = "{$pathOnly} ({$st})";
                $linkFail[$key] = $linkFail[$key] ?? $uri;
            }
        }
    }
}

$sourceMissing = [];
foreach ([base_path('app'), base_path('resources'), base_path('config')] as $root) {
    if (! is_dir($root)) {
        continue;
    }
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
    foreach ($it as $file) {
        if (! $file->isFile()) {
            continue;
        }
        $name = $file->getFilename();
        $ext = strtolower($file->getExtension());
        if (! in_array($ext, ['php', 'js', 'css'], true) && ! str_ends_with($name, '.blade.php')) {
            continue;
        }
        $text = file_get_contents($file->getPathname());
        if (! preg_match_all("/['\"](\\/?assets\\/[^'\"\\s?#]+)['\"]/", $text, $matches)) {
            continue;
        }
        foreach ($matches[1] as $path) {
            if (str_contains($path, '$') || str_contains($path, '{')) {
                continue;
            }
            $path = ltrim(str_replace('\\', '/', $path), '/');
            if (! preg_match('/\.(webp|png|jpe?g|gif|svg|ico|css|js|woff2?|mp4|webm)$/i', $path)) {
                continue;
            }
            $disk = $public.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $path);
            if (! is_file($disk)) {
                $sourceMissing[$path] = $sourceMissing[$path] ?? str_replace(base_path().DIRECTORY_SEPARATOR, '', $file->getPathname());
            }
        }
    }
}

echo 'Pages smoked: '.count($uris).PHP_EOL;
echo 'Expected redirects (OK): '.count($redirects).PHP_EOL;
foreach ($redirects as $line) {
    echo "  {$line}".PHP_EOL;
}
echo 'Status failures (404/5xx): '.count($statusFail).PHP_EOL;
foreach ($statusFail as $line) {
    echo "  {$line}".PHP_EOL;
}
echo 'Missing assets from HTML: '.count($assetFail).PHP_EOL;
foreach ($assetFail as $asset => $from) {
    echo "  {$asset}  (from {$from})".PHP_EOL;
}
echo 'Broken internal hrefs (404+): '.count($linkFail).PHP_EOL;
foreach ($linkFail as $link => $from) {
    echo "  {$link}  (from {$from})".PHP_EOL;
}
echo 'Missing assets in source strings: '.count($sourceMissing).PHP_EOL;
foreach ($sourceMissing as $asset => $from) {
    echo "  {$asset}  (from {$from})".PHP_EOL;
}

$failCount = count($statusFail) + count($assetFail) + count($linkFail) + count($sourceMissing);
echo PHP_EOL.($failCount === 0 ? 'PASS: no broken images or 404 links.' : "FAIL: {$failCount} issue(s).").PHP_EOL;

exit($failCount > 0 ? 1 : 0);
