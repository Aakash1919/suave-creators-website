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
                'quote' => 'Aakash and the Suave Creators engineering team delivered exceptional work on our global dispatch platform. They grasped our complex logistics workflows immediately, maintained transparent daily communication, and launched the portal on schedule. I highly recommend them for mission-critical web software builds.',
                'name' => 'Amit Rana',
                'role' => 'Founder & CEO, Turbo Trans Corp',
                'sort_order' => 1,
            ],
            [
                'quote' => 'The Suave Creators team resolved our complex frontend architecture tasks with impressive speed. They were transparent throughout every sprint, proactive in solving edge cases, and delivered reliable, clean code under tight deadlines.',
                'name' => 'Rajesh',
                'role' => 'Director of Product, ZiveAI',
                'sort_order' => 2,
            ],
            [
                'quote' => 'Collaborating with Suave Creators has been a tremendous asset to our agency. Aakash is an exceptionally skilled programmer who consistently brings clean architecture, reliable problem-solving, and crystal-clear communication to every engagement.',
                'name' => 'Mark Shelton',
                'role' => 'Managing Director, DBS Interactive',
                'sort_order' => 3,
            ],
            [
                'quote' => 'Working with Suave Creators has been an outstanding experience. Their team executed our technical roadmap with remarkable precision and care. They are our trusted engineering partners.',
                'name' => 'Adnyesh',
                'role' => 'Chief Technology Officer, Ergode Inc',
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
