<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Topbar extends Component
{
    public function __construct(
        public string $href = '/product',
        public string $title = 'Introducing SUAVE CRM',
        public string $subtitle = ' — The Smarter Way to Manage Your Business.',
        public string $icon = '/images/rocket_icon.svg',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.layouts.topbar');
    }
}
