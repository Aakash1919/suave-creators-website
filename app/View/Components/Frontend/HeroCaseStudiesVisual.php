<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\CaseStudySupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Animated case-study mosaic (metric + photo + chart tiles + cursor).
 *
 * Drop-in on any marketing page — defaults to published catalog scenes:
 *
 *   <x-frontend.hero-case-studies-visual />
 *   <x-frontend.hero-case-studies-visual :limit="3" />
 *   <x-frontend.hero-case-studies-visual :slugs="['ai-sales-coaching-platform-case-study']" />
 *   <x-frontend.hero-case-studies-visual :items="$scenes" class="max-w-[360px]" />
 */
class HeroCaseStudiesVisual extends Component
{
    /** @var list<array<string, mixed>> */
    public array $scenes = [];

    /** @var array<string, mixed>|null */
    public ?array $scene = null;

    public string $wrapperClass;

    public bool $animate;

    /**
     * @param  list<array<string, mixed>>  $items  Optional scenes; empty loads from CaseStudySupport
     * @param  list<string>  $slugs  Optional catalog slug filter (ignored when $items is non-empty)
     * @param  string  $class  Extra classes on the root `.hero-cs-visual` element
     */
    public function __construct(
        array $items = [],
        int $limit = 10,
        array $slugs = [],
        string $class = '',
        bool $animate = true,
    ) {
        $source = $items !== []
            ? $items
            : CaseStudySupport::heroVisualScenes($limit, $slugs !== [] ? $slugs : null);

        $scenes = [];

        foreach ($source as $item) {
            if (! is_array($item)) {
                continue;
            }

            $title = trim((string) ($item['title'] ?? ''));
            $photo = trim((string) ($item['photo_image'] ?? $item['brand_image'] ?? ''));
            $brand = trim((string) ($item['brand_image'] ?? $photo));
            $alt = trim((string) ($item['alt'] ?? ''));

            if ($title === '' || $photo === '') {
                continue;
            }

            if ($alt === '') {
                $alt = $title.' case study by Suave Creators';
            }

            $primary = is_array($item['primary'] ?? null) ? $item['primary'] : [];
            $secondary = is_array($item['secondary'] ?? null) ? $item['secondary'] : [];
            $bars = is_array($item['bars'] ?? null) ? array_values($item['bars']) : [42, 68, 92, 58, 76];
            $chartImage = trim((string) ($item['chart_image'] ?? ''));

            $scenes[] = [
                'slug' => (string) ($item['slug'] ?? ''),
                'title' => $title,
                'url' => (string) ($item['url'] ?? ''),
                'alt' => $alt,
                'tag' => trim((string) ($item['tag'] ?? 'Case Study')),
                'primary' => [
                    'value' => trim((string) ($primary['value'] ?? '')),
                    'label_short' => trim((string) ($primary['label_short'] ?? $primary['label'] ?? '')),
                ],
                'secondary' => [
                    'value' => trim((string) ($secondary['value'] ?? '')),
                    'label_short' => trim((string) ($secondary['label_short'] ?? $secondary['label'] ?? '')),
                ],
                'brand_image' => $brand !== '' ? $brand : $photo,
                'photo_image' => $photo,
                'chart_image' => $chartImage !== '' ? $chartImage : null,
                'bars' => array_map(static fn ($h): int => (int) $h, array_slice(array_pad($bars, 5, 55), 0, 5)),
            ];
        }

        $this->scenes = $scenes;
        $this->scene = $scenes[0] ?? null;
        $this->wrapperClass = trim($class);
        $this->animate = $animate;
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.hero-case-studies-visual');
    }
}
