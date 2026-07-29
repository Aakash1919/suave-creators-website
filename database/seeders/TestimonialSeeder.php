<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class TestimonialSeeder extends Seeder
{
    /**
     * Replace marketing testimonials with the current client set.
     */
    public function run(): void
    {
        Testimonial::query()->delete();

        $items = [
            [
                'quote' => 'Aakash and his team was fantastic to work with. They understood the project requirements clearly, communicated well throughout the process, and delivered high-quality work on time. I would definitely recommend them for any web development project.',
                'name' => 'Amit Rana',
                'role' => 'Founder - Turbo Trans Corp',
                'sort_order' => 1,
            ],
            [
                'quote' => 'Aakash and his team were quick to address our frontend tasks. They understood our needs clearly, were transparent with communication, and completed the tasks on time.',
                'name' => 'Rajesh',
                'role' => 'Director - ZiveAI',
                'sort_order' => 2,
            ],
            [
                'quote' => 'The Suave Creator team has been a pleasure to work with. Aakash is an exceptionally talented programmer who consistently brings a positive attitude, writes clean and reliable code, and communicates clearly throughout the project. We’ve truly valued the opportunity to collaborate with him and appreciate the quality he brings to every engagement.',
                'name' => 'Mark Shelton',
                'role' => 'DBS Interactive',
                'sort_order' => 3,
            ],
            [
                'quote' => 'Great Working with Suave Creators, very well executed projects. Keep up the good work',
                'name' => 'Adnyesh',
                'role' => 'CTO Ergode Inc',
                'sort_order' => 4,
            ],
        ];

        foreach ($items as $item) {
            Testimonial::query()->create([
                ...$item,
                'avatar' => null,
                'is_published' => true,
            ]);
        }

        Cache::forget(TestimonialService::CACHE_KEY);
    }
}
