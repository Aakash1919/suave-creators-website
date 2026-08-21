<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeroCaseStudiesVisual extends Component
{
    /** @var list<array<string, mixed>> */
    public array $scenes = [];

    /** @var array<string, mixed>|null */
    public ?array $scene = null;

    /**
     * @param  list<array<string, mixed>>  $items  Scene list from CaseStudySupport::heroVisualScenes()
     */
    public function __construct(array $items = [])
    {
        $scenes = [];

        foreach ($items as $item) {
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
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.hero-case-studies-visual');
    }
}
