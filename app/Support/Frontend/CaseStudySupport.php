<?php

namespace App\Support\Frontend;

use App\Models\CaseStudy;
use Illuminate\Support\Facades\Auth;

class CaseStudySupport
{
    /**
     * Published case studies for the listing page, ordered for the grid.
     *
     * @return list<array<string, mixed>>
     */
    public static function cases(): array
    {
        return CaseStudy::query()
            ->published()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (CaseStudy $caseStudy): array => self::mapCase($caseStudy))
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function case(string $slug): ?array
    {
        $query = CaseStudy::query()->where('slug', $slug);

        if (Auth::check()) {
            $query->where(function ($q): void {
                $q->published()
                    ->orWhere('status', CaseStudy::STATUS_DRAFT);
            });
        } else {
            $query->published();
        }

        $caseStudy = $query->first();

        return $caseStudy !== null ? self::mapCase($caseStudy) : null;
    }

    /**
     * @return array<string, mixed>
     */
    public static function indexData(): array
    {
        return [
            'cases' => self::cases(),
            'seoTitle' => 'Case Studies | Suave Creators',
            'seoDescription' => 'See how Suave Creators designs and ships real products — stories from the software we build for clients.',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function showData(string $slug): array
    {
        $case = self::case($slug);

        if ($case === null) {
            abort(404);
        }

        $seoTitle = trim((string) ($case['meta_title'] ?? ''));
        if ($seoTitle === '') {
            $seoTitle = $case['title'].' | Case Study | Suave Creators';
        }

        $seoDescription = trim((string) ($case['meta_description'] ?? ''));
        if ($seoDescription === '') {
            $seoDescription = (string) ($case['short_description'] ?? '');
        }

        return [
            'case' => $case,
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
            'seoOgTitle' => trim((string) ($case['og_title'] ?? '')) ?: null,
            'seoOgDescription' => trim((string) ($case['og_description'] ?? '')) ?: null,
            'seoImage' => $case['image'] ?? null,
            'seoRobots' => ! empty($case['is_draft']) ? 'noindex, nofollow' : null,
            'isDraft' => ! empty($case['is_draft']),
        ];
    }

    public static function visualForSection(array $section, int $index): string
    {
        if (! empty($section['visual'])) {
            return (string) $section['visual'];
        }

        $eyebrow = strtolower((string) ($section['eyebrow'] ?? ''));

        if (str_contains($eyebrow, 'discover')) {
            return 'discovery';
        }

        if (str_contains($eyebrow, 'prepar') || str_contains($eyebrow, 'intel')) {
            return 'preparation';
        }

        if (str_contains($eyebrow, 'pipeline') || str_contains($eyebrow, 'lead')) {
            return 'pipeline';
        }

        return CaseStudy::VISUALS[$index % count(CaseStudy::VISUALS)];
    }

    /**
     * @return array<string, mixed>
     */
    protected static function mapCase(CaseStudy $caseStudy): array
    {
        $image = $caseStudy->featuredImageUrl() ?? '';

        return [
            'id' => $caseStudy->id,
            'slug' => (string) $caseStudy->slug,
            'title' => (string) $caseStudy->title,
            'status' => (string) $caseStudy->status,
            'is_draft' => $caseStudy->status === CaseStudy::STATUS_DRAFT,
            'image' => $image,
            'short_description' => (string) ($caseStudy->short_description ?? ''),
            'listing_subtitle' => (string) ($caseStudy->listing_subtitle ?? ''),
            'industry' => (string) ($caseStudy->industry ?? ''),
            'client' => (string) ($caseStudy->client ?? ''),
            'year' => (string) ($caseStudy->year ?? ''),
            'technologies' => is_array($caseStudy->technologies) ? $caseStudy->technologies : [],
            'results' => is_array($caseStudy->results) ? $caseStudy->results : [],
            'challenge' => (string) ($caseStudy->challenge ?? ''),
            'solution' => (string) ($caseStudy->solution ?? ''),
            'outcome' => (string) ($caseStudy->outcome ?? ''),
            'sections' => self::mapSections($caseStudy),
            'meta_title' => (string) ($caseStudy->meta_title ?? ''),
            'meta_description' => (string) ($caseStudy->meta_description ?? ''),
            'og_title' => (string) ($caseStudy->og_title ?? ''),
            'og_description' => (string) ($caseStudy->og_description ?? ''),
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected static function mapSections(CaseStudy $caseStudy): array
    {
        $sections = is_array($caseStudy->sections) ? array_values($caseStudy->sections) : [];
        $mapped = [];

        foreach (array_slice($sections, 0, 2) as $section) {
            if (! is_array($section)) {
                continue;
            }

            $imagePath = $section['image'] ?? null;
            $section['image'] = $caseStudy->imageUrl($imagePath) ?? '';
            $mapped[] = $section;
        }

        return $mapped;
    }
}
