<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuaveAgent extends Component
{
    /**
     * Floating chat launcher included in the marketing layout.
     */
    public function __construct(
        public string $ariaLabel = 'Chat with Suave Creators',
        public string $alt = 'Chat with Suave Creators for custom software and CRM support',
    ) {
    }

    /**
     * Render the SuaveAgent chat widget Blade view.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.suave-agent');
    }
}
