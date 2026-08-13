<?php

namespace App\Models;

use App\Models\Concerns\HasRoles;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Blog posts authored by this user.
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'created_by_id');
    }

    /**
     * Case studies authored by this user.
     */
    public function caseStudies(): HasMany
    {
        return $this->hasMany(CaseStudy::class, 'created_by_id');
    }

    /**
     * Whether the user may enter the admin panel (roles gate features inside).
     */
    public function canAccessAdmin(): bool
    {
        return true;
    }
}
