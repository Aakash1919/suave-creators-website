<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\ContactSupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ServiceOverviewSection extends Component
{
    public string $resolvedPrimaryHref;

    public string $resolvedSecondaryHref;

    /**
     * @param  array<int, string>  $paragraphs
     */
    public function __construct(
        public string $eyebrow,
        public string $title,
        public array $paragraphs,
        public string $backgroundImage,
        public string $primaryLabel,
        public string $secondaryLabel,
        public ?string $primaryHref = null,
        public ?string $secondaryHref = null,
    ) {
        $this->resolvedPrimaryHref = filled($this->primaryHref) ? $this->primaryHref : ContactSupport::demoHref();
        $this->resolvedSecondaryHref = filled($this->secondaryHref) ? $this->secondaryHref : ContactSupport::demoHref();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.service-overview-section');
    }
}
