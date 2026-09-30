<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProcessStepsSection extends Component
{
    /**
     * @param  array<int, array{step: string, icon: string, title: string, desc: string}>  $steps
     */
    public function __construct(
        public string $eyebrow,
        public string $title,
        public string $description,
        public array $steps,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.process-steps-section');
    }
}
