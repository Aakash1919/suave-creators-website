<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SitePreloader extends Component
{
    /**
     * Brand overlay shown until the non-blocking stylesheets have applied.
     *
     * @param  int  $timeout  Hard cap in ms after which the overlay is removed even if a sheet never loads.
     */
    public function __construct(
        public int $timeout = 2500,
        public string $label = 'Loading Suave Creators',
    ) {}

    /**
     * Render the site preloader Blade view.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.site-preloader');
    }
}
