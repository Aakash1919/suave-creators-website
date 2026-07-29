<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'quote',
        'name',
        'role',
        'avatar',
        'small_thumb_avatar',
        'medium_thumb_avatar',
        'sort_order',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @param  Builder<Testimonial>  $query
     * @return Builder<Testimonial>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Avatar path suitable for frontend `asset()` (assets/… or storage/…).
     */
    public function frontendAvatarPath(): string
    {
        return $this->frontendStoragePath($this->avatar);
    }

    /**
     * Small thumb path for frontend cards; falls back to original when missing.
     */
    public function frontendSmallAvatarPath(): string
    {
        $small = $this->frontendStoragePath($this->small_thumb_avatar);

        return $small !== '' ? $small : $this->frontendAvatarPath();
    }

    /**
     * Medium thumb path for frontend; falls back to original when missing.
     */
    public function frontendMediumAvatarPath(): string
    {
        $medium = $this->frontendStoragePath($this->medium_thumb_avatar);

        return $medium !== '' ? $medium : $this->frontendAvatarPath();
    }

    /**
     * Admin preview URL for the avatar (prefers small thumb).
     */
    public function avatarUrl(): ?string
    {
        $path = $this->frontendSmallAvatarPath();

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return '/'.ltrim($path, '/');
    }

    /**
     * Shape expected by the marketing testimonials section.
     *
     * @return array{quote: string, name: string, role: string, initials: string, avatar: string, avatarAlt: string}
     */
    public function toFrontendArray(): array
    {
        $name = (string) $this->name;

        return [
            'quote' => (string) $this->quote,
            'name' => $name,
            'role' => (string) $this->role,
            'initials' => self::initialsFromName($name),
            'avatar' => $this->frontendSmallAvatarPath(),
            'avatarAlt' => self::avatarAltFromName($name),
        ];
    }

    /**
     * Initials derived from the client name (first letters of up to two words).
     */
    public function displayInitials(): string
    {
        return self::initialsFromName((string) $this->name);
    }

    public static function avatarAltFromName(string $name): string
    {
        $name = trim($name);

        return $name !== ''
            ? $name.' client testimonial for Suave Creators software development'
            : 'Client testimonial for Suave Creators software development';
    }

    public static function initialsFromName(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name)) ?: [];

        $initials = collect($parts)
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr((string) $part, 0, 1)))
            ->implode('');

        return $initials !== '' ? $initials : 'SC';
    }

    /**
     * Normalize a stored path for frontend asset()/URLs.
     */
    protected function frontendStoragePath(mixed $path): string
    {
        if (! is_string($path) || $path === '') {
            return '';
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        if (
            str_starts_with($normalized, 'http://')
            || str_starts_with($normalized, 'https://')
            || str_starts_with($normalized, 'assets/')
            || str_starts_with($normalized, 'storage/')
        ) {
            return $normalized;
        }

        return 'storage/'.$normalized;
    }
}
