<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Seo extends Component
{
    public function __construct(
        public string $title = 'Suave Creators',
        public string $description = 'Suave Creators',
        public ?string $ogTitle = null,
        public ?string $ogDescription = null,
        public string $ogType = 'website',
        public ?string $ogUrl = null,
        public ?string $canonical = null,
    ) {
        $this->ogTitle ??= $this->title;
        $this->ogDescription ??= $this->description;
        $this->ogUrl ??= url()->current();
        $this->canonical ??= url()->current();
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.seo');
    }
}
