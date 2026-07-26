<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\Concerns\NormalizesAssetPaths;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TestimonialsSection extends Component
{
    use NormalizesAssetPaths;

    /**
     * @param  array<int, array{quote: string, name: string, role: string, initials: string, avatar: string, avatarAlt?: string}>|null  $items
     */
    public function __construct(
        public ?array $items = null,
        public string $eyebrow = 'Testimonial',
        public string $title = 'Words That Inspire Us',
        public string $subtitle = 'Our clients\' feedback reflects the trust, partnership, and measurable results we deliver—from ambitious startups to established organizations.',
        public string $headingId = 'testimonials-title',
    ) {
        $this->items ??= [
            [
                'quote' => 'Working with this team was one of the best business decisions we made. They understood our vision and delivered a website that performs exceptionally well.',
                'name' => 'Saurabh Singh Shah',
                'role' => 'Founder, NorthRose Technologies',
                'initials' => 'SS',
                'avatar' => 'assets/team/professional-man-navy-blazer-portrait.png',
                'avatarAlt' => 'Saurabh Singh Shah client testimonial for Suave Creators web development',
            ],
            [
                'quote' => 'The communication was clear from the start, and every milestone arrived with thoughtful solutions. Our new platform is faster, easier to use, and ready to scale.',
                'name' => 'Ananya Mehta',
                'role' => 'Operations Director',
                'initials' => 'AM',
                'avatar' => 'assets/team/professional-woman-product-team-portrait.png',
                'avatarAlt' => 'Ananya Mehta client testimonial for Suave Creators software platform',
            ],
            [
                'quote' => 'They combined strong product thinking with excellent engineering. The result has improved our workflow and given our customers a much smoother experience.',
                'name' => 'Daniel Carter',
                'role' => 'Co-founder, Vertex Labs',
                'initials' => 'DC',
                'avatar' => 'assets/team/professional-designer-portrait.png',
                'avatarAlt' => 'Daniel Carter client testimonial for Suave Creators product engineering',
            ],
            [
                'quote' => 'From discovery to launch, the team felt like an extension of our own company. They challenged assumptions and kept the project focused on real business outcomes.',
                'name' => 'Priya Nair',
                'role' => 'Head of Digital',
                'initials' => 'PN',
                'avatar' => 'assets/team/professional-team-lead-portrait.png',
                'avatarAlt' => 'Priya Nair client testimonial for Suave Creators digital delivery',
            ],
        ];

        $this->items = array_values(array_map(function (array $item, int $index): array {
            $name = (string) ($item['name'] ?? '');

            return [
                'quote' => (string) ($item['quote'] ?? ''),
                'name' => $name,
                'role' => (string) ($item['role'] ?? ''),
                'initials' => (string) ($item['initials'] ?? ''),
                'avatar' => $this->normalizeAssetPath((string) ($item['avatar'] ?? '')),
                'avatarAlt' => (string) ($item['avatarAlt'] ?? ($name !== ''
                    ? $name.' client testimonial for Suave Creators software development'
                    : 'Client testimonial for Suave Creators software development')),
                'number' => str((string) ($index + 1))->padLeft(2, '0')->toString(),
            ];
        }, $this->items, array_keys($this->items)));
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.testimonials-section');
    }
}
