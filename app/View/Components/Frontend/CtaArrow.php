<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CtaArrow extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.frontend.cta-arrow');
    }
}
