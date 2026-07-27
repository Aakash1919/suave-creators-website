<?php

namespace App\View\Components\Layouts;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuaveAgent extends Component
{
    use NormalizesAssetPaths;

    public function __construct(
        public string $ariaLabel = 'Chat with Suave Creators',
        public string $icon = 'assets/brand/chat-widget-icon.svg',
        public string $alt = 'Chat with Suave Creators for custom software and CRM support',
    ) {
        $this->icon = $this->normalizeAssetPath($this->icon);
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.suave-agent');
    }
}
