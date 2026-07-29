<?php

namespace App\View\Components\Frontend;

use App\Models\Testimonial;
use App\Services\TestimonialService;
use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TestimonialsSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{quote: string, name: string, role: string, initials?: string, avatar: string, avatarAlt?: string}>|null  $items
     */
    public function __construct(
        public ?array $items = null,
        public string $eyebrow = 'Testimonial',
        public string $title = 'Words That Inspire Us',
        public string $subtitle = 'Our clients\' feedback reflects the trust, partnership, and measurable results we deliver—from ambitious startups to established organizations.',
        public string $headingId = 'testimonials-title',
    ) {
        $this->items ??= app(TestimonialService::class)->cachedForFrontend();

        $this->items = array_values(array_map(function (array $item, int $index): array {
            $name = (string) ($item['name'] ?? '');

            return [
                'quote' => (string) ($item['quote'] ?? ''),
                'name' => $name,
                'role' => (string) ($item['role'] ?? ''),
                'initials' => Testimonial::initialsFromName($name),
                'avatar' => $this->normalizeAssetPath((string) ($item['avatar'] ?? '')),
                'avatarAlt' => Testimonial::avatarAltFromName($name),
                'number' => str((string) ($index + 1))->padLeft(2, '0')->toString(),
            ];
        }, $this->items, array_keys($this->items)));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.testimonials-section');
    }
}
