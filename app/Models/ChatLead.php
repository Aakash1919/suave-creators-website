<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Ai\Concerns\HasConversations;

class ChatLead extends Model
{
    use HasConversations;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'session_token',
        'escalated_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'escalated_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ChatLead $lead): void {
            if (blank($lead->uuid)) {
                $lead->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function markEscalated(): void
    {
        if ($this->escalated_at === null) {
            $this->forceFill(['escalated_at' => now()])->save();
        }
    }

    public function plainSessionTokenMatches(string $plainToken): bool
    {
        return hash_equals($this->session_token, hash('sha256', $plainToken));
    }

    public static function hashSessionToken(string $plainToken): string
    {
        return hash('sha256', $plainToken);
    }
}
