<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;
class Topbar extends Component
{
    public function __construct(
        public string $hrefRoute = 'https://the-suave.app/about-us',
        public string $title = 'Introducing The Suave App',
        public string $subtitle = ' — Discover prospects and run AI-assisted outreach.',
        public string $icon = 'assets/icons/announcement-rocket-icon.svg',
        public string $iconAlt = 'Sales Outreach announcement icon for Suave Creators',
    ) {}

    public function href(): string
    {
        return Str::startsWith($this->hrefRoute, 'http') ? $this->hrefRoute : route($this->hrefRoute ?? 'product');
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.topbar');
    }
}
