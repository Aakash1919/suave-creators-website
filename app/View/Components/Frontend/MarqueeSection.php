<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use InvalidArgumentException;

class MarqueeSection extends Component
{
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
        $this->type = strtolower($this->type);
        $this->direction = strtolower($this->direction) === 'right' ? 'right' : 'left';
        $this->position = strtolower($this->position) === 'contained' ? 'contained' : 'full';

        if (! in_array($this->type, ['text', 'image'], true)) {
            throw new InvalidArgumentException('Marquee type must be "text" or "image".');
        }

        $this->items = array_values(array_map(
            fn (array $item): array => $this->normalizeItem($item),
            $this->items
        ));

        if ($this->ariaLabel === '' && $this->type === 'text') {
            $this->ariaLabel = implode(', ', array_column($this->items, 'label'));
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
            return [
                'src' => (string) ($item['src'] ?? $item['image'] ?? $item[0] ?? ''),
                'alt' => (string) ($item['alt'] ?? $item['label'] ?? $item[1] ?? ''),
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
