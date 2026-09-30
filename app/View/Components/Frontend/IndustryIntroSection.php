<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IndustryIntroSection extends Component
{
    /**
     * @param  array<int, array{0: string, 1: string, 2: string, 3: string, 4: string}>  $stats
     */
    public function __construct(
        public string $eyebrow,
        public string $title,
        public string $description,
        public array $stats,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.industry-intro-section');
    }
}
