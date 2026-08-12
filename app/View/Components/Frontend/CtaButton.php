<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\ContactSupport;
use App\Support\Frontend\UiHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CtaButton extends Component
{
    public string $resolvedHref;

    public string $btnClass;

    /**
     * @param  'default'|'compact'  $variant
     */
    public function __construct(
        public string $href = '',
        public string $variant = 'default',
        public bool $showArrow = true,
    ) {
        $this->resolvedHref = $this->href !== ''
            ? $this->href
            : ContactSupport::demoHref();

        $this->btnClass = UiHelper::btnPrimary($this->variant);
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.cta-button');
    }
}
