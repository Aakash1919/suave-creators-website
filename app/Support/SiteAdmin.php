<?php

namespace App\Support;

use App\Models\User;
use RuntimeException;

class SiteAdmin
{
    public const EMAIL = 'admin@suavecreators.com';

    public const NAME = 'Suave Creators';

    public static function ensure(): User
    {
        return User::query()->firstOrCreate(
            ['email' => self::EMAIL],
            [
                'name' => self::NAME,
                'password' => 'password',
            ]
        );
    }

    public static function resolve(): User
    {
        $admin = User::query()->where('email', self::EMAIL)->first();

        if ($admin !== null) {
            return $admin;
        }

        $fallback = User::query()->orderBy('id')->first();

        if ($fallback === null) {
            throw new RuntimeException('No admin user available. Run database seeders first.');
        }

        return $fallback;
    }

    public static function isAdmin(User $user): bool
    {
        return strcasecmp((string) $user->email, self::EMAIL) === 0;
    }
}
