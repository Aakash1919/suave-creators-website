<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AgileProcessTabsSection extends Component
{
    /**
     * @param  array<string, array<int, array{title?: string, desc?: string, icon?: string}>>  $phases  Tab label => cards
     */
    public function __construct(
        public string $title,
        public string $subtitle,
        public array $phases,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.agile-process-tabs-section');
    }
}
