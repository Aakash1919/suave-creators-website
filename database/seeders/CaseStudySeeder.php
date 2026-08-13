<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Support\SiteAdmin;
use Illuminate\Database\Seeder;

class CaseStudySeeder extends Seeder
{
    /**
     * Seed case studies from database/data/case-studies/cases.php.
     */
    public function run(): void
    {
        $path = database_path('data'.DIRECTORY_SEPARATOR.'case-studies'.DIRECTORY_SEPARATOR.'cases.php');

        if (! is_file($path)) {
            $this->command?->warn("Skipping CaseStudySeeder — missing {$path}");

            return;
        }

        /** @var list<array<string, mixed>> $raw */
        $raw = require $path;
        if (! is_array($raw)) {
            $this->command?->error('cases.php did not return an array.');

            return;
        }

        $admin = SiteAdmin::ensure();
        $imported = 0;
        $updated = 0;

        $this->command?->info('Seeding '.count($raw).' case study(ies) from database/data/case-studies…');

        foreach ($raw as $index => $payload) {
            if (! is_array($payload)) {
                continue;
            }

            $slug = (string) ($payload['slug'] ?? '');
            if ($slug === '') {
                continue;
            }

            $wasExisting = CaseStudy::withTrashed()->where('slug', $slug)->exists();

            $this->upsertCaseStudy([
                'slug' => $slug,
                'title' => (string) ($payload['title'] ?? $slug),
                'short_description' => (string) ($payload['short_description'] ?? ''),
                'listing_subtitle' => $payload['listing_subtitle'] ?? null,
                'industry' => $payload['industry'] ?? null,
                'service_slugs' => $this->stringList($payload['service_slugs'] ?? null) ?? [],
                'industry_slugs' => $this->stringList($payload['industry_slugs'] ?? null) ?? [],
                'client' => $payload['client'] ?? null,
                'year' => $payload['year'] ?? null,
                'featured_image' => $this->normalizeImagePath($payload['image'] ?? null),
                'created_by_id' => $admin->id,
                'status' => CaseStudy::STATUS_PUBLISHED,
                'published_at' => now(),
                'sort_order' => $index + 1,
                'technologies' => $this->stringList($payload['technologies'] ?? null),
                'results' => $this->results($payload['results'] ?? null),
                'challenge' => $payload['challenge'] ?? null,
                'solution' => $payload['solution'] ?? null,
                'outcome' => $payload['outcome'] ?? null,
                'sections' => $this->sections($payload['sections'] ?? null),
            ]);

            $wasExisting ? $updated++ : $imported++;
        }

        $this->command?->info("Case studies seeded. created={$imported} updated={$updated}");
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function upsertCaseStudy(array $data): CaseStudy
    {
        $slug = (string) $data['slug'];
        $caseStudy = CaseStudy::withTrashed()->where('slug', $slug)->first();

        if ($caseStudy === null) {
            return CaseStudy::query()->create($data);
        }

        if ($caseStudy->trashed()) {
            $caseStudy->restore();
        }

        if (empty($data['featured_image']) && filled($caseStudy->featured_image)) {
            unset($data['featured_image']);
        }

        $caseStudy->fill($data);
        $caseStudy->save();

        return $caseStudy;
    }

    protected function normalizeImagePath(mixed $path): ?string
    {
        if (! is_string($path) || trim($path) === '') {
            return null;
        }

        return ltrim(str_replace('\\', '/', $path), '/');
    }

    /**
     * @return list<string>|null
     */
    protected function stringList(mixed $items): ?array
    {
        if (! is_array($items) || $items === []) {
            return null;
        }

        $out = [];
        foreach ($items as $item) {
            $value = trim((string) $item);
            if ($value !== '') {
                $out[] = $value;
            }
        }

        return $out === [] ? null : array_values($out);
    }

    /**
     * @return list<array{value: string, label: string}>|null
     */
    protected function results(mixed $items): ?array
    {
        if (! is_array($items) || $items === []) {
            return null;
        }

        $out = [];
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $value = trim((string) ($item['value'] ?? ''));
            $label = trim((string) ($item['label'] ?? ''));
            if ($value === '' && $label === '') {
                continue;
            }

            $out[] = [
                'value' => $value,
                'label' => $label,
            ];
        }

        return $out === [] ? null : array_values($out);
    }

    /**
     * @return list<array<string, mixed>>|null
     */
    protected function sections(mixed $items): ?array
    {
        if (! is_array($items) || $items === []) {
            return null;
        }

        $out = [];
        foreach (array_slice(array_values($items), 0, 2) as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $points = [];
            foreach (array_values((array) ($item['points'] ?? [])) as $point) {
                $text = trim((string) $point);
                if ($text !== '') {
                    $points[] = $text;
                }
            }

            $visual = (string) ($item['visual'] ?? '');
            if (! in_array($visual, CaseStudy::VISUALS, true)) {
                $visual = CaseStudy::VISUALS[$index % count(CaseStudy::VISUALS)];
            }

            $out[] = [
                'type' => 'split',
                'visual' => $visual,
                'image_side' => ($item['image_side'] ?? ($index === 0 ? 'right' : 'left')) === 'left' ? 'left' : 'right',
                'eyebrow' => trim((string) ($item['eyebrow'] ?? '')),
                'title' => trim((string) ($item['title'] ?? '')),
                'body' => trim((string) ($item['body'] ?? '')),
                'points' => $points,
            ];
        }

        return $out === [] ? null : $out;
    }
}
