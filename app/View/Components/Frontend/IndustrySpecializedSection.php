<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IndustrySpecializedSection extends Component
{
    /**
     * @param  array<int, array{title?: string, desc?: string, icon?: string}>  $items
     */
    public function __construct(
        public string $eyebrow,
        public string $title,
        public string $description,
        public array $items,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.industry-specialized-section');
    }
}
