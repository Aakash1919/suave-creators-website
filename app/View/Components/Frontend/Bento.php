<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use App\Support\Frontend\HomeSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Bento extends Component
{
    use NormalizesAssetPaths;

    /**
     * @var array{
     *     primary: array{value: string, label: string},
     *     secondary: array{value: string, label: string, sublabel: string},
     *     portrait: array{src: string, alt: string, width: int, height: int},
     *     logo: array{src: string, alt: string, width: int, height: int},
     *     chip: array{label: string},
     *     chartBars: list<int>,
     *     caseStudyHref: string
     * }
     */
    public array $bento;

    /**
     * @param  array<string, mixed>  $bento
     */
    public function __construct(array $bento = [])
    {
        $defaults = HomeSupport::heroBento();
        $merged = array_replace_recursive($defaults, $bento);

        $portrait = is_array($merged['portrait'] ?? null) ? $merged['portrait'] : $defaults['portrait'];
        $logo = is_array($merged['logo'] ?? null) ? $merged['logo'] : $defaults['logo'];
        $chartBars = array_values(array_map(
            static fn ($height): int => max(8, min(100, (int) $height)),
            is_array($merged['chartBars'] ?? null) ? $merged['chartBars'] : $defaults['chartBars']
        ));

        $routeName = (string) ($merged['caseStudyRoute'] ?? $defaults['caseStudyRoute']);
        $caseStudyHref = route($routeName);

        $this->bento = [
            'primary' => [
                'value' => (string) ($merged['primary']['value'] ?? $defaults['primary']['value']),
                'label' => (string) ($merged['primary']['label'] ?? $defaults['primary']['label']),
            ],
            'secondary' => [
                'value' => (string) ($merged['secondary']['value'] ?? $defaults['secondary']['value']),
                'label' => (string) ($merged['secondary']['label'] ?? $defaults['secondary']['label']),
                'sublabel' => (string) ($merged['secondary']['sublabel'] ?? $defaults['secondary']['sublabel']),
            ],
            'portrait' => [
                'src' => $this->normalizeImageAssetPath((string) ($portrait['src'] ?? $defaults['portrait']['src'])),
                'alt' => (string) ($portrait['alt'] ?? $defaults['portrait']['alt']),
                'width' => (int) ($portrait['width'] ?? $defaults['portrait']['width']),
                'height' => (int) ($portrait['height'] ?? $defaults['portrait']['height']),
            ],
            'logo' => [
                'src' => $this->normalizeImageAssetPath((string) ($logo['src'] ?? $defaults['logo']['src'])),
                'alt' => (string) ($logo['alt'] ?? $defaults['logo']['alt']),
                'width' => (int) ($logo['width'] ?? $defaults['logo']['width']),
                'height' => (int) ($logo['height'] ?? $defaults['logo']['height']),
            ],
            'chip' => [
                'label' => (string) ($merged['chip']['label'] ?? $defaults['chip']['label']),
            ],
            'chartBars' => $chartBars !== [] ? $chartBars : $defaults['chartBars'],
            'caseStudyHref' => $caseStudyHref,
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.bento');
    }
}
