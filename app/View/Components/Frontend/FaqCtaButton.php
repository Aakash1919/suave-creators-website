<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FaqCtaButton extends Component
{
    public function __construct(
        public string $href = '/contact-us/#contact-id',
        public string $label = 'Start your Project',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.frontend.faq-cta-button');
    }
}
