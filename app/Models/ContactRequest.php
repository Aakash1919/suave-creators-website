<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    public const STATUS_DRAFT = 'draft';

    public const STATUS_NEW = 'new';

    public const STATUS_READ = 'read';

    public const STATUS_ARCHIVED = 'archived';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'draft_token',
        'name',
        'email',
        'phone',
        'service',
        'message',
        'status',
        'ip_address',
        'user_agent',
    ];

    /**
     * @param  Builder<ContactRequest>  $query
     * @return Builder<ContactRequest>
     */
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function displayName(): string
    {
        $name = trim((string) $this->name);

        return $name !== '' ? $name : 'Incomplete lead';
    }

    public function markRead(): void
    {
        if ($this->status === self::STATUS_NEW) {
            $this->forceFill(['status' => self::STATUS_READ])->save();
        }
    }

    public function markArchived(): void
    {
        $this->forceFill(['status' => self::STATUS_ARCHIVED])->save();
    }

    public function serviceLabel(): string
    {
        $labels = [
            'web-development' => 'Web Development',
            'ai-solutions' => 'AI Solutions',
            'ui-ux-design' => 'UI/UX Design',
            'ecommerce' => 'E-commerce Development',
            'custom-crm' => 'Custom CRM Development',
            'enterprise-software' => 'Enterprise Software',
            'other' => 'Other',
        ];

        $service = trim((string) $this->service);

        if ($service === '') {
            return '—';
        }

        return $labels[$service] ?? $service;
    }
}
