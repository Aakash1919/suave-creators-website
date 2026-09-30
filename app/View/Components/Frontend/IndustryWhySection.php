<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IndustryWhySection extends Component
{
    /**
     * @param  array<int, array{title?: string, text?: string, icon?: string}>  $cards
     */
    public function __construct(
        public string $eyebrow,
        public string $title,
        public string $description,
        public array $cards,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.industry-why-section');
    }
}
