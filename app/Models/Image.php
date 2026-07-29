<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'path',
        'small_thumb_path',
        'medium_thumb_path',
        'alt_text',
        'created_by_id',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Public URL for the original image.
     */
    public function url(): ?string
    {
        return $this->publicStorageUrl($this->path);
    }

    /**
     * Public URL for the small thumb (falls back to original).
     */
    public function smallThumbUrl(): ?string
    {
        return $this->publicStorageUrl($this->small_thumb_path) ?? $this->url();
    }

    /**
     * Public URL for the medium thumb (falls back to original).
     */
    public function mediumThumbUrl(): ?string
    {
        return $this->publicStorageUrl($this->medium_thumb_path) ?? $this->url();
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

        return '/storage/'.$normalized;
    }
}
