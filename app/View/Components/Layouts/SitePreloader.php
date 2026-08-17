<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SitePreloader extends Component
{
    /**
     * Brand overlay shown by default and removed after the document is ready.
     *
     * @param  int  $minDisplayTime  Minimum duration in ms to show the loader (default: 1500ms).
     * @param  int  $timeout  Hard cap in ms after which the overlay is removed even if ready never fires.
     */
    public function __construct(
        public int $minDisplayTime = 500,
        public int $timeout = 5000,
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
