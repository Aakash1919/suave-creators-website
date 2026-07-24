<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TestimonialsSection extends Component
{
    /**
     * @param  array<int, array{quote: string, name: string, role: string, initials: string, avatar: string}>|null  $items
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
                'avatar' => '/images/team-2.png',
            ],
            [
                'quote' => 'The communication was clear from the start, and every milestone arrived with thoughtful solutions. Our new platform is faster, easier to use, and ready to scale.',
                'name' => 'Ananya Mehta',
                'role' => 'Operations Director',
                'initials' => 'AM',
                'avatar' => '/images/team-5.png',
            ],
            [
                'quote' => 'They combined strong product thinking with excellent engineering. The result has improved our workflow and given our customers a much smoother experience.',
                'name' => 'Daniel Carter',
                'role' => 'Co-founder, Vertex Labs',
                'initials' => 'DC',
                'avatar' => '/images/team-3.png',
            ],
            [
                'quote' => 'From discovery to launch, the team felt like an extension of our own company. They challenged assumptions and kept the project focused on real business outcomes.',
                'name' => 'Priya Nair',
                'role' => 'Head of Digital',
                'initials' => 'PN',
                'avatar' => '/images/team-6.png',
            ],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.testimonials-section');
    }
}
