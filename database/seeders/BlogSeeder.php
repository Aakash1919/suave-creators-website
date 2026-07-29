<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\ImageVariantService;
use App\Support\SiteAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Seed blogs from database/data/blogs (blogs.json + slug-named images).
     */
    public function run(): void
    {
        $package = database_path('data'.DIRECTORY_SEPARATOR.'blogs');
        $jsonPath = $package.DIRECTORY_SEPARATOR.'blogs.json';
        $imagesRoot = $package.DIRECTORY_SEPARATOR.'images';

        if (! is_file($jsonPath)) {
            $this->command?->warn("Skipping BlogSeeder — missing {$jsonPath}");

            return;
        }

        $raw = json_decode((string) file_get_contents($jsonPath), true);
        if (! is_array($raw)) {
            $this->command?->error('blogs.json is invalid JSON.');

            return;
        }

        $admin = SiteAdmin::ensure();
        Storage::disk('public')->makeDirectory('blogs');
        Storage::disk('public')->makeDirectory('blogs/content');

        $imported = 0;
        $updated = 0;
        $imageFailures = 0;

        $this->command?->info('Seeding '.count($raw).' blog(s) from database/data/blogs…');

        foreach ($raw as $payload) {
            if (! is_array($payload)) {
                continue;
            }

            $slug = (string) ($payload['slug'] ?? '');
            if ($slug === '') {
                continue;
            }

            $category = $this->upsertCategory((string) ($payload['category'] ?? 'Insights'));

            $featuredPath = null;
            $mediumThumbPath = null;
            $featuredRel = ltrim(str_replace('\\', '/', (string) ($payload['featured_image'] ?? '')), '/');
            if ($featuredRel !== '') {
                $source = $imagesRoot.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $featuredRel);
                $ext = strtolower(pathinfo($featuredRel, PATHINFO_EXTENSION) ?: 'jpg');
                $dest = 'blogs/'.$slug.'.'.$ext;
                $stored = $this->copySeedImage($source, $dest);
                if ($stored === null) {
                    $imageFailures++;
                    $this->command?->warn("  featured image missing: {$slug} → {$featuredRel}");
                } else {
                    $featuredPath = $stored;
                    $thumbs = app(ImageVariantService::class)->generateThumbnails($source, $stored);
                    $mediumThumbPath = $thumbs['medium'];
                }
            }

            $content = $this->sanitizeHtml((string) ($payload['content'] ?? ''));
            $content = $this->materializeContentImages($content, $imagesRoot, $imageFailures);

            $wasExisting = Blog::withTrashed()->where('slug', $slug)->exists();
            $this->upsertBlog([
                'slug' => $slug,
                'title' => (string) ($payload['title'] ?? $slug),
                'short_description' => (string) ($payload['short_description'] ?? ''),
                'content' => $content,
                'featured_image' => $featuredPath,
                'medium_thumb_image' => $mediumThumbPath,
                'blog_category_id' => $category->id,
                'created_by_id' => $admin->id,
                'status' => (string) ($payload['status'] ?? Blog::STATUS_PUBLISHED),
                'published_at' => $payload['published_at'] ?? now(),
                'toc' => $this->normalizeToc($payload['toc'] ?? []),
                'faqs' => $this->normalizeFaqs($payload['faqs'] ?? null),
                'meta_title' => $payload['meta_title'] ?? null,
                'meta_description' => $payload['meta_description'] ?? null,
                'og_title' => $payload['og_title'] ?? null,
                'og_description' => $payload['og_description'] ?? null,
            ]);

            $wasExisting ? $updated++ : $imported++;
        }

        $this->command?->info("Blogs seeded. created={$imported} updated={$updated} image_failures={$imageFailures}");
    }

    protected function upsertCategory(string $name): BlogCategory
    {
        $name = trim($name) !== '' ? trim($name) : 'Insights';
        $slug = Str::slug($name) ?: 'insights';

        return BlogCategory::query()->firstOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'sort_order' => (int) BlogCategory::query()->max('sort_order') + 1,
            ]
        );
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
            unset($data['featured_image'], $data['medium_thumb_image']);
        }

        $blog->fill($data);
        $blog->save();

        return $blog;
    }

    protected function copySeedImage(string $sourceAbsolute, string $destPath): ?string
    {
        if (! is_file($sourceAbsolute)) {
            return null;
        }

        Storage::disk('public')->put($destPath, (string) file_get_contents($sourceAbsolute));

        return $destPath;
    }

    protected function materializeContentImages(string $html, string $imagesRoot, int &$imageFailures): string
    {
        return (string) preg_replace_callback(
            '/(<img\b[^>]*\bsrc=["\'])([^"\']+)(["\'][^>]*>)/i',
            function (array $m) use ($imagesRoot, &$imageFailures): string {
                $src = html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5);

                if (str_starts_with($src, '/storage/blogs/')) {
                    return $m[0];
                }

                $rel = null;
                if (str_starts_with($src, 'images/')) {
                    $rel = substr($src, strlen('images/'));
                } elseif (str_starts_with($src, 'content/')) {
                    $rel = $src;
                }

                if ($rel === null) {
                    return $m[0];
                }

                $rel = ltrim(str_replace('\\', '/', $rel), '/');
                $source = $imagesRoot.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $rel);
                $dest = str_starts_with($rel, 'content/')
                    ? 'blogs/'.$rel
                    : 'blogs/content/'.basename($rel);

                $stored = $this->copySeedImage($source, $dest);
                if ($stored === null) {
                    $imageFailures++;

                    return $m[0];
                }

                $url = '/storage/'.ltrim(str_replace('\\', '/', $stored), '/');

                return $m[1].$url.$m[3];
            },
            $html
        );
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
     * Keep exact FAQ pairs from blogs.json (no generated fallbacks).
     *
     * @param  mixed  $faqs
     * @return list<array{question: string, answer: string}>
     */
    protected function normalizeFaqs(mixed $faqs): array
    {
        if (! is_array($faqs)) {
            return [];
        }

        $out = [];
        foreach ($faqs as $item) {
            if (! is_array($item)) {
                continue;
            }
            $question = trim((string) ($item['question'] ?? ''));
            $answer = trim((string) ($item['answer'] ?? ''));
            if ($question === '' || $answer === '') {
                continue;
            }
            $out[] = [
                'question' => $question,
                'answer' => $answer,
            ];
        }

        return $out;
    }

    protected function sanitizeHtml(string $html): string
    {
        $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html) ?? $html;
        $html = preg_replace('/<iframe\b[^>]*>.*?<\/iframe>/is', '', $html) ?? $html;
        $html = preg_replace('/\son\w+\s*=\s*("|\').*?\1/i', '', $html) ?? $html;

        return trim($html);
    }
}
