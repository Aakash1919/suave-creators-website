<?php

namespace App\Support;

use App\Models\User;
use RuntimeException;

class SiteAdmin
{
    public const EMAIL = 'admin@suavecreators.com';

    public const NAME = 'Suave Creators';

    /**
     * Ensure the seeded site admin user exists and has the admin role when possible.
     */
    public static function ensure(): User
    {
        $user = User::query()->firstOrCreate(
            ['email' => self::EMAIL],
            [
                'name' => self::NAME,
                'password' => 'password',
            ]
        );

        if (method_exists($user, 'assignRole') && ! $user->hasRole('admin')) {
            try {
                $user->assignRole('admin');
            } catch (\Throwable) {
                // Roles may not be seeded yet.
            }
        }

        return $user->fresh(['roles']) ?? $user;
    }

    /**
     * Resolve the site admin user, or the first user as a fallback.
     *
     * @throws RuntimeException When no users exist yet.
     */
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

    /**
     * Whether the user is the site admin by role or canonical email.
     */
    public static function isAdmin(User $user): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return strcasecmp((string) $user->email, self::EMAIL) === 0;
    }
}
