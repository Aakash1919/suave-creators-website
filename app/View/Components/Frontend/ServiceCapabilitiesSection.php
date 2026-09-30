<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ServiceCapabilitiesSection extends Component
{
    /**
     * @param  array<int, array{title?: string, desc?: string, image?: string, tags?: array<int, string>}>  $items
     */
    public function __construct(
        public string $eyebrow,
        public string $title,
        public string $description,
        public array $items,
        public int $columns = 3,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.service-capabilities-section');
    }
}
