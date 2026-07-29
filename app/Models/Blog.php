<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'blog_category_id',
        'created_by_id',
        'slug',
        'title',
        'short_description',
        'content',
        'featured_image',
        'small_thumb_image',
        'medium_thumb_image',
        'status',
        'published_at',
        'toc',
        'faqs',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'toc' => 'array',
            'faqs' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function author(): BelongsTo
    {
        return $this->createdBy();
    }

    /**
     * @param  Builder<Blog>  $query
     * @return Builder<Blog>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function featuredImageUrl(): ?string
    {
        return $this->publicStorageUrl($this->featured_image);
    }

    /**
     * Small thumbnail URL; falls back to the original when missing (legacy rows).
     */
    public function smallThumbImageUrl(): ?string
    {
        return $this->publicStorageUrl($this->small_thumb_image) ?? $this->featuredImageUrl();
    }

    /**
     * Medium thumbnail URL; falls back to the original when missing (legacy rows).
     */
    public function mediumThumbImageUrl(): ?string
    {
        return $this->publicStorageUrl($this->medium_thumb_image) ?? $this->featuredImageUrl();
    }

    /**
     * Relative public URL for a stored path (or absolute http(s) URL).
     */
    protected function publicStorageUrl(mixed $path): ?string
    {
        if (! is_string($path) || $path === '') {
            return null;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return $normalized;
        }

        // Relative public URL so images work regardless of APP_URL host/port.
        return '/storage/'.$normalized;
    }
}
