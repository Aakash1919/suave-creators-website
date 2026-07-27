<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Topbar extends Component
{
    public function __construct(
        public string $hrefRoute = 'product',
        public string $title = 'Introducing SUAVE CRM',
        public string $subtitle = ' — The Smarter Way to Manage Your Business.',
        public string $icon = 'assets/icons/announcement-rocket-icon.svg',
        public string $iconAlt = 'Suave CRM product announcement icon',
    ) {}

    public function href(): string
    {
        return route($this->hrefRoute);
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.topbar');
    }
}
