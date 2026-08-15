<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArticlesInsightsSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{title?: string, excerpt?: string, image?: string, alt?: string, date?: string, datetime?: string, author?: string, url?: string}>  $items
     */
    public function __construct(
        public array $items = [],
        public string $eyebrow = 'Blogs and Insights',
        public string $title = 'Latest Insights from Our Experts',
        public string $subtitle = 'We build digital experiences that help brands grow through design, development, branding, and marketing.',
        public string $headingId = 'articles-insights-title',
        public string $moreHref = '',
        public string $moreLabel = 'View all blog articles',
        public string $sectionClass = 'py-6 lg:py-18',
        public bool $initSwiper = true,
    ) {
        if ($this->moreHref === '') {
            $this->moreHref = route('blogs');
        }

        $this->items = array_values(array_map(function (array $article): array {
            $title = (string) ($article['title'] ?? '');

            return [
                'title' => $title,
                'excerpt' => (string) ($article['excerpt'] ?? ''),
                'image' => $this->normalizeAssetPath((string) ($article['image'] ?? 'assets/blog/digital-strategy-collaboration.png')),
                'alt' => (string) ($article['alt'] ?? $title),
                'date' => (string) ($article['date'] ?? ''),
                'datetime' => (string) ($article['datetime'] ?? ''),
                'author' => (string) ($article['author'] ?? 'Suave Creators'),
                'url' => (string) ($article['url'] ?? route('blogs')),
            ];
        }, $this->items));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.articles-insights-section');
    }
}
