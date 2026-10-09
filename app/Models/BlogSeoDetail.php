<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogSeoDetail extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'blog_id',
        'tags',
        'keywords',
        'about',
        'mentions',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'keywords' => 'array',
            'about' => 'array',
            'mentions' => 'array',
        ];
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
