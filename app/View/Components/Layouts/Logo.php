<?php

namespace App\View\Components\Layouts;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use InvalidArgumentException;

class Logo extends Component
{
    use NormalizesAssetPaths;

    public string $resolvedSrc;

    public string $imgClass;

    public function __construct(
        public string $variant = 'header',
        public ?string $src = null,
        public string $alt = 'Suave Creators logo web and software development company',
    ) {
        $this->variant = Str::lower($this->variant);

        if (! in_array($this->variant, ['header', 'footer'], true)) {
            throw new InvalidArgumentException('Logo variant must be "header" or "footer".');
        }

        $this->resolvedSrc = $this->normalizeAssetPath(
            $this->src ?? 'assets/brand/logo-white.png'
        );

        $this->imgClass = $this->variant === 'footer'
            ? 'h-9 w-auto max-w-full object-contain sm:h-12'
            : 'block h-9 w-auto object-contain sm:h-10';
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.logo');
    }
}
