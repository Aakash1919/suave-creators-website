<?php

namespace App\Support\Frontend;

class IndustrySupport
{
    /**
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        return [
            'latestPosts' => array_slice(BlogSupport::posts(), 0, 3),
            'articles' => array_map(static function (array $post): array {
                return [
                    'title' => $post['title'],
                    'excerpt' => $post['short_description'],
                    'image' => $post['image'],
                    'alt' => $post['title'],
                    'date' => $post['published_label'],
                    'datetime' => $post['published_date'],
                    'author' => $post['author_name'],
                    'url' => $post['url'] ?? route('blogs'),
                ];
            }, array_slice(BlogSupport::posts(), 0, 3)),
            'btnPrimary' => ServiceSupport::btnPrimary(),
            'ctaArrow' => ServiceSupport::ctaArrow(),
            'techStack' => AboutSupport::techStack(),
        ];
    }
}
