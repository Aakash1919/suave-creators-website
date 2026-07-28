<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class TestimonialSeeder extends Seeder
{
    /**
     * Seed the marketing testimonials used on home/services (idempotent by name).
     */
    public function run(): void
    {
        $items = [
            [
                'quote' => 'Working with this team was one of the best business decisions we made. They understood our vision and delivered a website that performs exceptionally well.',
                'name' => 'Saurabh Singh Shah',
                'role' => 'Founder, NorthRose Technologies',
                'avatar' => 'assets/team/professional-man-navy-blazer-portrait.png',
                'sort_order' => 1,
            ],
            [
                'quote' => 'The communication was clear from the start, and every milestone arrived with thoughtful solutions. Our new platform is faster, easier to use, and ready to scale.',
                'name' => 'Ananya Mehta',
                'role' => 'Operations Director',
                'avatar' => 'assets/team/professional-woman-product-team-portrait.png',
                'sort_order' => 2,
            ],
            [
                'quote' => 'They combined strong product thinking with excellent engineering. The result has improved our workflow and given our customers a much smoother experience.',
                'name' => 'Daniel Carter',
                'role' => 'Co-founder, Vertex Labs',
                'avatar' => 'assets/team/professional-designer-portrait.png',
                'sort_order' => 3,
            ],
            [
                'quote' => 'From discovery to launch, the team felt like an extension of our own company. They challenged assumptions and kept the project focused on real business outcomes.',
                'name' => 'Priya Nair',
                'role' => 'Head of Digital',
                'avatar' => 'assets/team/professional-team-lead-portrait.png',
                'sort_order' => 4,
            ],
        ];

        foreach ($items as $item) {
            Testimonial::query()->updateOrCreate(
                ['name' => $item['name']],
                [
                    ...$item,
                    'is_published' => true,
                ]
            );
        }

        Cache::forget(TestimonialService::CACHE_KEY);
    }
}
