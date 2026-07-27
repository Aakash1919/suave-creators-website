<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Seo extends Component
{
    /**
     * @param  array<string, mixed>  $seo
     */
    public function __construct(
        public array $seo = [],
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.layouts.seo');
    }
}
