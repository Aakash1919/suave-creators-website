<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SitePreloader extends Component
{
    /**
     * Brand overlay shown by default and removed once the data-suave-css stylesheets apply.
     *
     * @param  int  $minDisplayTime  Minimum duration in ms to show the loader.
     * @param  int  $timeout  Hard cap in ms after which the overlay is removed even if the sheets never apply.
     */
    public function __construct(
        public int $minDisplayTime = 500,
        public int $timeout = 3000,
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
