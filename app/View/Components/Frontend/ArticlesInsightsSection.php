<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\BlogSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Component;

class ArticlesInsightsSection extends Component
{
    /**
     * @var array<int, array{title: string, excerpt: string, image: string, alt: string, date: string, datetime: string, author: string, url: string}>
     */
    public array $items;

    /**
     * Latest three published posts. Pass a blog category slug to limit the list; null loads the latest posts from any category.
     */
    public function __construct(
        public ?string $category = null,
        public string $eyebrow = 'Blogs and Insights',
        public string $title = 'Latest Insights from Our Experts',
        public string $subtitle = 'We build digital experiences that help brands grow through design, development, branding, and marketing.',
        public string $headingId = 'articles-insights-title',
        public string $moreHref = '',
        public string $moreLabel = 'View all blog articles',
        public string $sectionClass = 'py-6 lg:py-18',
        public bool $initSwiper = true,
        public bool $showTitle = true,
    ) {
        $categorySlug = filled($this->category) ? $this->category : null;

        if ($this->moreHref === '') {
            $this->moreHref = $categorySlug !== null
                ? route('blogs.category', ['slug' => $categorySlug])
                : route('blogs');
        }

        $this->items = Schema::hasTable('blogs')
            ? BlogSupport::articleCards(3, $categorySlug)
            : [];
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.articles-insights-section');
    }
}
