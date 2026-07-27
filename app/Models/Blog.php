<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
        if (! is_string($this->featured_image) || $this->featured_image === '') {
            return null;
        }

        return Storage::disk('public')->url($this->featured_image);
    }
}
