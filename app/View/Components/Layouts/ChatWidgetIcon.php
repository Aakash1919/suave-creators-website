<?php

namespace App\View\Components\Layouts;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChatWidgetIcon extends Component
{
    use NormalizesAssetPaths;

    public string $resolvedSrc;

    /**
     * Classic circular Suave chat mark (dark disc + gradient ring).
     */
    public function __construct(
        public string $alt = 'Chat with Suave Creators for custom software and CRM support',
        public int $width = 56,
        public int $height = 56,
        ?string $src = null,
    ) {
        $this->resolvedSrc = $this->normalizeAssetPath(
            $src ?? 'assets/brand/chat-widget-icon.svg'
        );
    }

    /**
     * Render the chat widget icon Blade view.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.chat-widget-icon');
    }
}
