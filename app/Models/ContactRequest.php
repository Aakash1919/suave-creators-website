<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    public const STATUS_NEW = 'new';

    public const STATUS_READ = 'read';

    public const STATUS_ARCHIVED = 'archived';

    /**
     * @var list<string>
     */
    protected $fillable = [
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

        return $labels[$this->service] ?? $this->service;
    }
}
