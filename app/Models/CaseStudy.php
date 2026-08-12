<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseStudy extends Model
{
    use SoftDeletes;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const VISUALS = ['discovery', 'preparation', 'pipeline'];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'created_by_id',
        'slug',
        'title',
        'short_description',
        'listing_subtitle',
        'industry',
        'client',
        'year',
        'featured_image',
        'status',
        'published_at',
        'sort_order',
        'technologies',
        'results',
        'challenge',
        'solution',
        'outcome',
        'sections',
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
            'sort_order' => 'integer',
            'technologies' => 'array',
            'results' => 'array',
            'sections' => 'array',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * @param  Builder<CaseStudy>  $query
     * @return Builder<CaseStudy>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Public URL for the hero / listing image.
     */
    public function featuredImageUrl(): ?string
    {
        return $this->imageUrl($this->featured_image);
    }

    /**
     * Relative public URL for a stored path, public asset, or absolute http(s) URL.
     */
    public function imageUrl(mixed $path): ?string
    {
        if (! is_string($path) || $path === '') {
            return null;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return $normalized;
        }

        if (str_starts_with($normalized, 'assets/')) {
            return '/'.$normalized;
        }

        if (str_starts_with($normalized, 'storage/')) {
            return '/'.$normalized;
        }

        return '/storage/'.$normalized;
    }
}
