<?php

use App\Services\TestimonialService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('testimonials')) {
            return;
        }

        DB::table('testimonials')
            ->where('name', 'Amit Rana')
            ->update([
                'quote' => 'Aakash and his team was fantastic to work with. They understood the project requirements clearly, communicated well throughout the process, and delivered high-quality work on time. I would definitely recommend them for any web development project.',
            ]);

        Cache::forget(TestimonialService::CACHE_KEY);
    }

    public function down(): void
    {
        if (! Schema::hasTable('testimonials')) {
            return;
        }

        DB::table('testimonials')
            ->where('name', 'Amit Rana')
            ->update([
                'quote' => 'Aakash and his team were fantastic to work with. They understood the project requirements clearly, communicated well throughout the process, and delivered high-quality work on time. I would definitely recommend them for any custom software project.',
            ]);

        Cache::forget(TestimonialService::CACHE_KEY);
    }
};
