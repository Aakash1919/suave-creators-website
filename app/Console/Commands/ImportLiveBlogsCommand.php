<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Support\SiteAdmin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportLiveBlogsCommand extends Command
{
    protected $signature = 'blogs:import-live
                            {--base-url=https://www.suavecreators.com : Live site base URL}
                            {--skip-live : Skip live scrape and only seed local posts.php samples}
                            {--timeout=60 : HTTP timeout seconds}';

    protected $description = 'Import blog posts from suavecreators.com into the blogs tables (images on public disk)';

    public function handle(): int
    {
        $admin = SiteAdmin::ensure();
        Storage::disk('public')->makeDirectory('blogs');
        Storage::disk('public')->makeDirectory('blogs/content');

        $baseUrl = rtrim((string) $this->option('base-url'), '/');
        $timeout = max(15, (int) $this->option('timeout'));
        $imported = 0;
        $updated = 0;
        $imageFailures = 0;
        $categoriesCreated = 0;

        if (! $this->option('skip-live')) {
            $this->info("Fetching paginated blogs from {$baseUrl}/blogs …");
            $livePosts = $this->collectLivePosts($baseUrl, $timeout);
            $this->info('Found '.count($livePosts).' live blog(s).');

            foreach ($livePosts as $payload) {
                $slug = (string) ($payload['slug'] ?? '');
                if ($slug === '') {
                    continue;
                }

                $this->line("Importing live: {$slug}");

                [$category, $created] = $this->upsertCategory((string) ($payload['category'] ?? 'Insights'));
                if ($created) {
                    $categoriesCreated++;
                }

                $imagePath = null;
                $imageUrl = (string) ($payload['image_url'] ?? '');
                if ($imageUrl !== '') {
                    $basename = pathinfo(parse_url($imageUrl, PHP_URL_PATH) ?? '', PATHINFO_BASENAME);
                    $basename = $basename !== '' ? $basename : ($slug.'.webp');
                    $dest = 'blogs/'.$basename;
                    $stored = $this->storeRemoteImage($imageUrl, $dest, $timeout);
                    if ($stored === null) {
                        $imageFailures++;
                        $this->warn('  featured image download failed');
                    } else {
                        $imagePath = $stored;
                    }
                }

                $content = $this->sanitizeHtml((string) ($payload['content'] ?? ''));
                $content = $this->rewriteInlineImages($content, $slug, $timeout, $imageFailures);

                $wasExisting = Blog::withTrashed()->where('slug', $slug)->exists();
                $this->upsertBlog([
                    'slug' => $slug,
                    'title' => (string) $payload['title'],
                    'short_description' => (string) ($payload['short_description'] ?? ''),
                    'content' => $content,
                    'featured_image' => $imagePath,
                    'blog_category_id' => $category->id,
                    'created_by_id' => $admin->id,
                    'status' => Blog::STATUS_PUBLISHED,
                    'published_at' => $payload['published_at'] ?? now(),
                    'toc' => $this->tocFromContent($content),
                    'faqs' => [],
                    'meta_title' => $payload['meta_title'] ?? null,
                    'meta_description' => $payload['meta_description'] ?? null,
                    'og_title' => $payload['og_title'] ?? null,
                    'og_description' => $payload['og_description'] ?? null,
                ]);

                $wasExisting ? $updated++ : $imported++;
            }
        }

        $this->info('Seeding any missing local sample posts…');
        [$localImported, , $localCats, $localImageFailures] = $this->seedLocalSamples($admin->id);
        $imported += $localImported;
        $categoriesCreated += $localCats;
        $imageFailures += $localImageFailures;

        $this->newLine();
        $this->info("Done. created={$imported} updated={$updated} categories_created={$categoriesCreated} image_failures={$imageFailures}");

        return self::SUCCESS;
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function collectLivePosts(string $baseUrl, int $timeout): array
    {
        $page = 1;
        $lastPage = 1;
        $posts = [];

        do {
            $url = $baseUrl.'/blogs'.($page > 1 ? '?page='.$page : '');
            $this->line("  page {$page}…");
            $html = $this->fetchHtml($url, $timeout);
            if ($html === null) {
                $this->warn("  failed to fetch {$url}");
                break;
            }

            $props = $this->parseInertiaProps($html);
            $paginator = is_array($props) ? ($props['blogs'] ?? null) : null;
            if (! is_array($paginator) || ! isset($paginator['data']) || ! is_array($paginator['data'])) {
                $this->warn('  could not parse Inertia blogs payload');
                break;
            }

            $lastPage = max(1, (int) ($paginator['last_page'] ?? 1));

            foreach ($paginator['data'] as $item) {
                if (! is_array($item)) {
                    continue;
                }

                $slug = (string) ($item['slug'] ?? '');
                if ($slug === '') {
                    continue;
                }

                $category = $item['category'] ?? 'Insights';
                if (is_array($category)) {
                    $category = (string) ($category['name'] ?? 'Insights');
                }

                $imageUrl = (string) ($item['imagePath'] ?? '');
                if ($imageUrl === '' && ! empty($item['image'])) {
                    $imageUrl = $baseUrl.'/storage/'.ltrim((string) $item['image'], '/');
                }

                $published = (string) ($item['created_at'] ?? $item['published_at'] ?? '');
                $publishedAt = $published !== ''
                    ? date('Y-m-d H:i:s', strtotime($published) ?: time())
                    : now()->toDateTimeString();

                $title = (string) ($item['title'] ?? $slug);
                $short = (string) ($item['short_description'] ?? '');

                $posts[$slug] = [
                    'slug' => $slug,
                    'title' => $title,
                    'short_description' => $short,
                    'content' => (string) ($item['content'] ?? ''),
                    'image_url' => $imageUrl,
                    'category' => (string) $category,
                    'published_at' => $publishedAt,
                    'meta_title' => $title.' | Suave Creators Blog',
                    'meta_description' => $short !== '' ? $short : null,
                    'og_title' => $title,
                    'og_description' => $short !== '' ? $short : null,
                ];
            }

            $page++;
        } while ($page <= $lastPage);

        return array_values($posts);
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function parseInertiaProps(string $html): ?array
    {
        if (! preg_match('/data-page="([^"]+)"/', $html, $m)) {
            return null;
        }

        $json = html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5);
        $data = json_decode($json, true);

        return is_array($data) ? ($data['props'] ?? null) : null;
    }

    /**
     * @return array{0: BlogCategory, 1: bool}
     */
    protected function upsertCategory(string $name): array
    {
        $name = trim($name) !== '' ? trim($name) : 'Insights';
        $slug = Str::slug($name) ?: 'insights';
        $existing = BlogCategory::query()->where('slug', $slug)->first();

        if ($existing !== null) {
            return [$existing, false];
        }

        $category = BlogCategory::query()->create([
            'name' => $name,
            'slug' => $slug,
            'sort_order' => (int) BlogCategory::query()->max('sort_order') + 1,
        ]);

        return [$category, true];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function upsertBlog(array $data): Blog
    {
        $slug = (string) $data['slug'];
        $blog = Blog::withTrashed()->where('slug', $slug)->first();

        if ($blog === null) {
            return Blog::query()->create($data);
        }

        if ($blog->trashed()) {
            $blog->restore();
        }

        if (empty($data['featured_image']) && filled($blog->featured_image)) {
            unset($data['featured_image']);
        }

        $blog->fill($data);
        $blog->save();

        return $blog;
    }

    protected function storeRemoteImage(string $url, string $destPath, int $timeout): ?string
    {
        $url = html_entity_decode(trim($url), ENT_QUOTES | ENT_HTML5);
        if ($url === '' || ! str_starts_with($url, 'http')) {
            return null;
        }

        $tmp = tempnam(sys_get_temp_dir(), 'blogimg_');
        if ($tmp === false) {
            return null;
        }

        $ok = $this->curlToFile($url, $tmp, $timeout);
        if (! $ok || ! is_file($tmp) || filesize($tmp) < 32) {
            @unlink($tmp);

            return null;
        }

        Storage::disk('public')->put($destPath, (string) file_get_contents($tmp));
        @unlink($tmp);

        return $destPath;
    }

    protected function storeLocalPublicAsset(string $relativePublicPath, string $destPath): ?string
    {
        $relativePublicPath = ltrim(str_replace('\\', '/', $relativePublicPath), '/');
        $source = public_path($relativePublicPath);

        if (! is_file($source)) {
            return null;
        }

        Storage::disk('public')->put($destPath, (string) file_get_contents($source));

        return $destPath;
    }

    /**
     * @return array{0: int, 1: int, 2: int, 3: int}
     */
    protected function seedLocalSamples(int $adminId): array
    {
        $path = app_path('Support/Frontend/Data/blogs/posts.php');
        if (! is_file($path)) {
            return [0, 0, 0, 0];
        }

        /** @var array<int, array<string, mixed>> $raw */
        $raw = include $path;
        $imported = 0;
        $cats = 0;
        $imageFailures = 0;

        foreach ($raw as $post) {
            $slug = (string) ($post['slug'] ?? '');
            if ($slug === '' || Blog::withTrashed()->where('slug', $slug)->exists()) {
                continue;
            }

            [$category, $created] = $this->upsertCategory((string) ($post['category'] ?? 'Insights'));
            if ($created) {
                $cats++;
            }

            $imagePath = null;
            $sourceImage = ltrim((string) ($post['image'] ?? ''), '/');
            if ($sourceImage !== '') {
                $ext = pathinfo($sourceImage, PATHINFO_EXTENSION) ?: 'png';
                $dest = 'blogs/'.$slug.'.'.$ext;
                $imagePath = $this->storeLocalPublicAsset($sourceImage, $dest);
                if ($imagePath === null) {
                    $imageFailures++;
                }
            }

            $published = (string) ($post['published_date'] ?? now()->toDateString());
            $content = $this->sanitizeHtml((string) ($post['content'] ?? ''));

            $this->upsertBlog([
                'slug' => $slug,
                'title' => (string) ($post['title'] ?? $slug),
                'short_description' => (string) ($post['short_description'] ?? ''),
                'content' => $content,
                'featured_image' => $imagePath,
                'blog_category_id' => $category->id,
                'created_by_id' => $adminId,
                'status' => Blog::STATUS_PUBLISHED,
                'published_at' => $published.' 12:00:00',
                'toc' => $this->normalizeToc($post['toc'] ?? []),
                'faqs' => is_array($post['faqs'] ?? null) ? $post['faqs'] : [],
                'meta_title' => null,
                'meta_description' => (string) ($post['short_description'] ?? ''),
                'og_title' => null,
                'og_description' => null,
            ]);

            $imported++;
        }

        return [$imported, 0, $cats, $imageFailures];
    }

    /**
     * @param  mixed  $toc
     * @return list<array{anchor_id: string, label: string}>
     */
    protected function normalizeToc(mixed $toc): array
    {
        if (! is_array($toc)) {
            return [];
        }

        $out = [];
        foreach ($toc as $item) {
            if (! is_array($item)) {
                continue;
            }
            $out[] = [
                'anchor_id' => (string) ($item['anchor_id'] ?? $item['id'] ?? ''),
                'label' => (string) ($item['label'] ?? ''),
            ];
        }

        return $out;
    }

    /**
     * @return list<array{anchor_id: string, label: string}>
     */
    protected function tocFromContent(string $content): array
    {
        $toc = [];
        if (preg_match_all('/<h2[^>]*\bid=["\']([^"\']+)["\'][^>]*>(.*?)<\/h2>/is', $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $toc[] = [
                    'anchor_id' => (string) $match[1],
                    'label' => trim(html_entity_decode(strip_tags($match[2]), ENT_QUOTES | ENT_HTML5)),
                ];
            }
        }

        return $toc;
    }

    protected function sanitizeHtml(string $html): string
    {
        $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html) ?? $html;
        $html = preg_replace('/<iframe\b[^>]*>.*?<\/iframe>/is', '', $html) ?? $html;
        $html = preg_replace('/\son\w+\s*=\s*("|\').*?\1/i', '', $html) ?? $html;

        return trim($html);
    }

    protected function rewriteInlineImages(string $html, string $slug, int $timeout, int &$imageFailures): string
    {
        return (string) preg_replace_callback(
            '/<img\b[^>]*\bsrc=["\']([^"\']+)["\'][^>]*>/i',
            function (array $m) use ($slug, $timeout, &$imageFailures): string {
                $src = html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5);
                if (! str_starts_with($src, 'http')) {
                    return $m[0];
                }

                // Skip already-local storage URLs
                if (str_contains($src, '/storage/blogs/')) {
                    return $m[0];
                }

                $hash = substr(sha1($src), 0, 12);
                $ext = strtolower(pathinfo(parse_url($src, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION) ?: 'jpg');
                if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'], true)) {
                    $ext = 'jpg';
                }
                $dest = 'blogs/content/'.$slug.'-'.$hash.'.'.$ext;
                $path = $this->storeRemoteImage($src, $dest, $timeout);
                if ($path === null) {
                    $imageFailures++;

                    return $m[0];
                }

                $url = '/storage/'.ltrim(str_replace('\\', '/', $path), '/');

                return (string) preg_replace('/src=["\'][^"\']+["\']/', 'src="'.e($url).'"', $m[0], 1);
            },
            $html
        );
    }

    protected function fetchHtml(string $url, int $timeout): ?string
    {
        $tmp = tempnam(sys_get_temp_dir(), 'bloghtml_');
        if ($tmp === false) {
            return null;
        }

        $ok = $this->curlToFile($url, $tmp, $timeout);
        if (! $ok || ! is_file($tmp)) {
            @unlink($tmp);

            return null;
        }

        $body = (string) file_get_contents($tmp);
        @unlink($tmp);

        if ($body === '' || (str_contains($body, 'Checking your browser') && ! str_contains($body, 'data-page='))) {
            return null;
        }

        return $body;
    }

    protected function curlToFile(string $url, string $dest, int $timeout): bool
    {
        $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36';

        if (PHP_OS_FAMILY === 'Windows') {
            $cmd = sprintf(
                'curl.exe -sL -A %s --max-time %d %s -o %s',
                escapeshellarg($ua),
                $timeout,
                escapeshellarg($url),
                escapeshellarg($dest)
            );
        } else {
            $cmd = sprintf(
                'curl -sL -A %s --max-time %d %s -o %s',
                escapeshellarg($ua),
                $timeout,
                escapeshellarg($url),
                escapeshellarg($dest)
            );
        }

        exec($cmd, $output, $code);

        return $code === 0 && is_file($dest) && filesize($dest) > 0;
    }
}
