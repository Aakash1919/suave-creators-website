<?php

namespace App\Http\Requests\Admin\Concerns;

use App\Models\CaseStudy;
use Illuminate\Validation\Rule;

trait ValidatesCaseStudyFields
{
    /**
     * @return array<string, mixed>
     */
    protected function caseStudyRules(?CaseStudy $caseStudy = null): array
    {
        $requiredText = static function (string $message): \Closure {
            return static function (string $attribute, mixed $value, \Closure $fail) use ($message): void {
                if (trim((string) $value) === '') {
                    $fail($message);
                }
            };
        };

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:160', Rule::unique('case_studies', 'slug')->ignore($caseStudy?->id)],
            'short_description' => ['nullable', 'string'],
            'listing_subtitle' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:160'],
            'client' => ['nullable', 'string', 'max:160'],
            'year' => ['nullable', 'string', 'max:20'],
            'status' => ['required', Rule::in([CaseStudy::STATUS_DRAFT, CaseStudy::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'technologies' => ['nullable', 'string', 'max:500'],
            'challenge' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'outcome' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'og_title' => ['nullable', 'string', 'max:60'],
            'og_description' => ['nullable', 'string', 'max:160'],
            'results' => ['nullable', 'array', 'max:8'],
            'results.*.value' => ['required', 'string', 'max:40', $requiredText('Each metric needs a value.')],
            'results.*.label' => ['required', 'string', 'max:255', $requiredText('Each metric needs a label.')],
            'sections' => ['nullable', 'array', 'max:2'],
            'sections.*.eyebrow' => ['nullable', 'string', 'max:80'],
            'sections.*.title' => ['nullable', 'string', 'max:255'],
            'sections.*.body' => ['nullable', 'string'],
            'sections.*.visual' => ['nullable', Rule::in(CaseStudy::VISUALS)],
            'sections.*.image_side' => ['nullable', Rule::in(['left', 'right'])],
            'sections.*.image' => ['nullable', 'image', 'max:5120'],
            'sections.*.existing_image' => ['nullable', 'string', 'max:255'],
            'sections.*.remove_image' => ['nullable', 'boolean'],
            'sections.*.points' => ['nullable', 'array', 'max:20'],
            'sections.*.points.*' => ['required', 'string', 'max:255', $requiredText('Each point needs text.')],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function caseStudyMessages(): array
    {
        return [
            'results.*.value.required' => 'Each metric needs a value.',
            'results.*.label.required' => 'Each metric needs a label.',
            'sections.*.points.*.required' => 'Each point needs text.',
        ];
    }
}
