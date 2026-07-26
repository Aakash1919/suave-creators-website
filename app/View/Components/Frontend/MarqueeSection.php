<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use InvalidArgumentException;

class MarqueeSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array<string, mixed>|array<int, mixed>>  $items
     */
    public function __construct(
        public string $type = 'text',
        public array $items = [],
        public string $direction = 'left',
        public string $position = 'full',
        public string $ariaLabel = '',
        public int $speed = 30,
        public int $repeat = 2,
    ) {
        $this->type = Str::lower($this->type);
        $this->direction = Str::lower($this->direction) === 'right' ? 'right' : 'left';
        $this->position = Str::lower($this->position) === 'contained' ? 'contained' : 'full';

        if (! in_array($this->type, ['text', 'image'], true)) {
            throw new InvalidArgumentException('Marquee type must be "text" or "image".');
        }

        $this->items = array_values(array_map(
            fn (array $item): array => $this->normalizeItem($item),
            $this->items
        ));

        if ($this->ariaLabel === '' && $this->type === 'text') {
            $this->ariaLabel = collect($this->items)->pluck('label')->implode(', ');
        }

        if ($this->type === 'image' && $this->speed === 30) {
            $this->speed = 28;
        }
    }

    /**
     * @param  array<string, mixed>|array<int, mixed>  $item
     * @return array<string, string>
     */
    protected function normalizeItem(array $item): array
    {
        if ($this->type === 'image') {
            $alt = (string) ($item['alt'] ?? $item['label'] ?? $item[1] ?? '');
            if ($alt !== '' && ! Str::contains(Str::lower($alt), 'logo')) {
                $alt .= ' logo';
            }

            return [
                'src' => $this->normalizeAssetPath((string) ($item['src'] ?? $item['image'] ?? $item[0] ?? '')),
                'alt' => $alt,
                'logoAlt' => $alt,
            ];
        }

        return [
            'label' => (string) ($item['label'] ?? $item['text'] ?? $item[0] ?? ''),
            'style' => (string) ($item['style'] ?? $item['variant'] ?? $item[1] ?? 'outlined'),
            'separator' => (string) ($item['separator'] ?? $item[2] ?? 'filled'),
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.marquee-section');
    }
}
