<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WhyChooseAccordionSection extends Component
{
    /**
     * @param  array<int, array{title?: string, text?: string, image?: string, tags?: array<int, string>, features?: array<int, string>}>  $cards
     */
    public function __construct(
        public string $eyebrow,
        public string $title,
        public string $description,
        public array $cards,
        public string $buttonHref,
        public string $buttonLabel,
    ) {
        $this->cards = array_values(array_map(static function (array $card): array {
            $card['tags'] = array_values(array_filter($card['tags'] ?? [], static fn ($t) => $t !== null && $t !== ''));
            $card['features'] = array_values(array_filter($card['features'] ?? [], static fn ($f) => $f !== null && $f !== ''));
            $card['imageAlt'] = ($card['title'] ?? 'Service').' benefit visual for Suave Creators software services';

            return $card;
        }, $this->cards));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.why-choose-accordion-section');
    }
}
