<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\CaseStudySupport;
use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class CaseStudiesCarouselSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array<string, mixed>>  $items
     */
    public function __construct(
        public array $items = [],
        public string $eyebrow = 'Case Study',
        public string $title = 'Case studies from our services',
        public string $subtitle = 'Selected delivery stories that show how we design and ship software across our practice areas.',
        public string $headingId = 'case-studies-carousel-title',
        public string $ctaLabel = 'Explore the Case Study',
        public string $sectionClass = '',
        public bool $initSwiper = true,
    ) {
        $this->items = array_values(array_map(function (array $item): array {
            $title = (string) ($item['title'] ?? '');
            $slug = (string) ($item['slug'] ?? '');
            $image = $this->normalizeAssetPath((string) ($item['image'] ?? ''));
            $results = is_array($item['results'] ?? null) ? array_slice($item['results'], 0, 4) : [];

            return [
                'slug' => $slug,
                'title' => $title,
                'category' => (string) ($item['industry'] ?? ''),
                'description' => (string) ($item['short_description'] ?? ''),
                'image' => $this->resolveImageSrc($image),
                'imageAlt' => $title !== ''
                    ? $title.' case study visual for Suave Creators software development'
                    : 'Case study visual for Suave Creators software development',
                'url' => $slug !== '' ? CaseStudySupport::urlForSlug($slug) : route('case-studies'),
                'stats' => array_values(array_map(function (array $stat): array {
                    $value = trim((string) ($stat['value'] ?? ''));

                    if (preg_match('/^\d{1,2}$/', $value) === 1) {
                        $value = str_pad($value, 2, '0', STR_PAD_LEFT);
                    }

                    return [
                        'value' => $value,
                        'label' => (string) ($stat['label'] ?? ''),
                    ];
                }, $results)),
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.case-studies-carousel-section');
    }

    protected function resolveImageSrc(string $image): string
    {
        if ($image === '') {
            return '';
        }

        if (Str::startsWith($image, ['http://', 'https://', '//', '/', 'data:'])) {
            return $image;
        }

        return asset($image);
    }
}
