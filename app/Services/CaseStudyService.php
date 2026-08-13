<?php

namespace App\Services;

use App\Http\Requests\Admin\CaseStudyStoreRequest;
use App\Http\Requests\Admin\CaseStudyUpdateRequest;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CaseStudyService
{
    public function __construct(
        protected ImageVariantService $images,
    ) {}

    /**
     * Empty draft model for the create form (two story slots matching the public layout).
     */
    public function newDraft(): CaseStudy
    {
        return new CaseStudy([
            'status' => CaseStudy::STATUS_DRAFT,
            'sort_order' => ((int) CaseStudy::query()->max('sort_order')) + 1,
            'sections' => $this->defaultSections(),
            'results' => [],
        ]);
    }

    /**
     * Create a case study from an admin form request.
     */
    public function create(CaseStudyStoreRequest $request): CaseStudy
    {
        $data = $this->attributesFromValidated($request->validated());
        $data['created_by_id'] = $request->user()?->id;
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title']);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->storeFeaturedImage($request, $data['slug']);
        }

        $data['sections'] = $this->storeSectionImages($request, $data['sections'] ?? [], $data['slug']);

        return CaseStudy::query()->create($data);
    }

    /**
     * Update a case study from an admin form request.
     */
    public function update(CaseStudyUpdateRequest $request, CaseStudy $caseStudy): CaseStudy
    {
        $data = $this->attributesFromValidated($request->validated());
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title'], $caseStudy->id);

        if ($request->hasFile('featured_image')) {
            $this->deleteFeaturedImage($caseStudy);
            $data['featured_image'] = $this->storeFeaturedImage($request, $data['slug']);
        }

        $data['sections'] = $this->storeSectionImages(
            $request,
            $data['sections'] ?? [],
            $data['slug'],
            is_array($caseStudy->sections) ? $caseStudy->sections : []
        );

        $caseStudy->update($data);

        return $caseStudy->refresh();
    }

    /**
     * Soft-delete a case study and remove an owned storage image.
     */
    public function delete(CaseStudy $caseStudy): void
    {
        $this->deleteFeaturedImage($caseStudy);
        $this->deleteSectionImages(is_array($caseStudy->sections) ? $caseStudy->sections : []);
        $caseStudy->delete();
    }

    /**
     * Normalize validated form data for persistence.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function attributesFromValidated(array $data): array
    {
        $data['technologies'] = $this->normalizeTechnologies($data['technologies'] ?? null);
        $data['results'] = $this->normalizeResults($data['results'] ?? null);
        $data['sections'] = $this->normalizeSections($data['sections'] ?? null);
        $data['service_slugs'] = $this->normalizePlacementSlugs(
            $data['service_slugs'] ?? null,
            array_keys($this->servicePlacementOptions())
        );
        $data['industry_slugs'] = $this->normalizePlacementSlugs(
            $data['industry_slugs'] ?? null,
            array_keys($this->industryPlacementOptions())
        );
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        unset($data['featured_image']);
        $data['client'] = null;

        if (($data['status'] ?? null) === CaseStudy::STATUS_PUBLISHED && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }

    /**
     * Service detail pages where a case study may appear (slug => label).
     *
     * @return array<string, string>
     */
    public function servicePlacementOptions(): array
    {
        return [
            'web-development-services' => 'Web Development Services',
            'custom-crm-development' => 'Custom CRM Development',
            'enterprise-software-solutions' => 'Enterprise Software Solutions',
            'e-commerce-development' => 'E-commerce Development',
        ];
    }

    /**
     * Industry detail pages where a case study may appear (slug => label).
     *
     * @return array<string, string>
     */
    public function industryPlacementOptions(): array
    {
        return [
            'healthcare' => 'Healthcare',
            'it-software-solutions-for-startups' => 'IT & Software for Startups',
            'finance-banking-software-development' => 'Finance & Banking',
            'retail-ecommerce-solutions' => 'Retail & E-commerce',
            'logistics-supply-chain-apps' => 'Logistics & Supply Chain',
            'education-elearning-platforms' => 'Education & E-learning',
        ];
    }

    /**
     * Keep only allowed placement slugs in a stable unique list.
     *
     * @param  list<string>  $allowed
     * @return list<string>
     */
    public function normalizePlacementSlugs(mixed $items, array $allowed): array
    {
        if (! is_array($items) || $items === []) {
            return [];
        }

        $allowedLookup = array_fill_keys($allowed, true);
        $out = [];

        foreach ($items as $item) {
            $slug = trim((string) $item);
            if ($slug === '' || ! isset($allowedLookup[$slug]) || isset($out[$slug])) {
                continue;
            }
            $out[$slug] = $slug;
        }

        return array_values($out);
    }

    /**
     * Build a unique kebab-case slug, appending -2, -3, … when needed.
     */
    public function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug(Str::limit($value, 140, '')) ?: 'case-study';
        $slug = $base;
        $i = 2;

        while (
            CaseStudy::query()
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function defaultSections(): array
    {
        return [
            [
                'type' => 'split',
                'visual' => 'discovery',
                'image_side' => 'right',
                'eyebrow' => '',
                'title' => '',
                'body' => '',
                'points' => [],
                'image' => null,
            ],
            [
                'type' => 'split',
                'visual' => 'preparation',
                'image_side' => 'left',
                'eyebrow' => '',
                'title' => '',
                'body' => '',
                'points' => [],
                'image' => null,
            ],
        ];
    }

    /**
     * Store the hero image under case-studies/{slug}.{ext}.
     */
    protected function storeFeaturedImage(Request $request, string $slug): string
    {
        $file = $request->file('featured_image');
        $ext = $file->getClientOriginalExtension() ?: 'jpg';

        return $file->storeAs('case-studies', $slug.'.'.$ext, 'public');
    }

    /**
     * Delete an owned storage image; leave public/assets paths in place.
     */
    protected function deleteFeaturedImage(CaseStudy $caseStudy): void
    {
        $this->images->deletePaths($caseStudy->featured_image);
    }

    /**
     * @return list<string>|null
     */
    public function normalizeTechnologies(mixed $value): ?array
    {
        if (is_array($value)) {
            $items = $value;
        } else {
            $items = preg_split('/\s*,\s*/', trim((string) $value)) ?: [];
        }

        $out = [];
        foreach ($items as $item) {
            $tag = trim((string) $item);
            if ($tag !== '') {
                $out[] = $tag;
            }
        }

        return $out === [] ? null : array_values(array_unique($out));
    }

    /**
     * @return list<array{value: string, label: string}>|null
     */
    public function normalizeResults(mixed $items): ?array
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
     * Keep at most two split sections for the public detail layout.
     *
     * @return list<array<string, mixed>>|null
     */
    public function normalizeSections(mixed $items): ?array
    {
        if (! is_array($items) || $items === []) {
            return null;
        }

        $out = [];
        for ($index = 0; $index < 2; $index++) {
            $item = is_array($items[$index] ?? null) ? $items[$index] : [];

            $points = [];
            foreach (array_slice(array_values((array) ($item['points'] ?? [])), 0, 20) as $point) {
                $text = trim((string) $point);
                if ($text !== '') {
                    $points[] = $text;
                }
            }

            $title = trim((string) ($item['title'] ?? ''));
            $body = trim((string) ($item['body'] ?? ''));
            $eyebrow = trim((string) ($item['eyebrow'] ?? ''));
            $hasUpload = ($item['image'] ?? null) instanceof UploadedFile;
            $existingImage = trim((string) ($item['existing_image'] ?? ''));
            if ($existingImage === '' && is_string($item['image'] ?? null)) {
                $existingImage = trim((string) $item['image']);
            }
            $removing = filter_var($item['remove_image'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $keepImage = $hasUpload || ($existingImage !== '' && ! $removing);

            if ($title === '' && $body === '' && $eyebrow === '' && $points === [] && ! $keepImage) {
                $out[] = [
                    'type' => 'split',
                    'visual' => CaseStudy::VISUALS[$index % count(CaseStudy::VISUALS)],
                    'image_side' => $index === 0 ? 'right' : 'left',
                    'image' => null,
                    'eyebrow' => '',
                    'title' => '',
                    'body' => '',
                    'points' => [],
                ];

                continue;
            }

            $visual = (string) ($item['visual'] ?? '');
            if (! in_array($visual, CaseStudy::VISUALS, true)) {
                $visual = CaseStudy::VISUALS[$index % count(CaseStudy::VISUALS)];
            }

            $side = ($item['image_side'] ?? ($index === 0 ? 'right' : 'left')) === 'left' ? 'left' : 'right';

            $out[] = [
                'type' => 'split',
                'visual' => $visual,
                'image_side' => $side,
                'image' => $removing ? null : ($existingImage !== '' ? $existingImage : null),
                'eyebrow' => $eyebrow,
                'title' => $title,
                'body' => $body,
                'points' => $points,
            ];
        }

        return $out === [] ? null : $out;
    }

    /**
     * Store uploaded split-section images and delete replaced files.
     *
     * @param  list<array<string, mixed>>|null  $sections
     * @param  list<array<string, mixed>>  $previous
     * @return list<array<string, mixed>>|null
     */
    protected function storeSectionImages(Request $request, ?array $sections, string $slug, array $previous = []): ?array
    {
        if (! is_array($sections) || $sections === []) {
            $this->deleteSectionImages($previous);

            return $sections;
        }

        $previous = array_values($previous);

        foreach ($sections as $index => &$section) {
            if (! is_array($section)) {
                continue;
            }

            $oldPath = is_string($previous[$index]['image'] ?? null) ? (string) $previous[$index]['image'] : null;
            $current = is_string($section['image'] ?? null) ? (string) $section['image'] : $oldPath;

            if ($request->boolean('sections.'.$index.'.remove_image')) {
                $this->images->deletePaths($oldPath, $current);
                $current = null;
            }

            $file = $request->file('sections.'.$index.'.image');
            if ($file instanceof UploadedFile) {
                $this->images->deletePaths($oldPath, $current);
                $ext = $file->getClientOriginalExtension() ?: 'jpg';
                $current = $file->storeAs('case-studies/'.$slug, 'section-'.($index + 1).'.'.$ext, 'public');
            }

            $section['image'] = $current ?: null;
        }
        unset($section);

        foreach ($previous as $index => $oldSection) {
            if (isset($sections[$index])) {
                continue;
            }
            $this->images->deletePaths(is_string($oldSection['image'] ?? null) ? (string) $oldSection['image'] : null);
        }

        return $sections;
    }

    /**
     * @param  list<array<string, mixed>>  $sections
     */
    protected function deleteSectionImages(array $sections): void
    {
        foreach ($sections as $section) {
            if (! is_array($section)) {
                continue;
            }
            $this->images->deletePaths(is_string($section['image'] ?? null) ? (string) $section['image'] : null);
        }
    }
}
