<?php

namespace App\Observers;

use App\Models\Blog;
use App\Models\User;
use App\Support\SiteAdmin;
use RuntimeException;

class UserObserver
{
    public function deleting(User $user): void
    {
        $admin = SiteAdmin::resolve();

        if ($admin->is($user)) {
            $otherUsers = User::query()->whereKeyNot($user->id)->exists();

            if (! $otherUsers) {
                throw new RuntimeException('Cannot delete the only admin user while blogs require an author.');
            }

            $fallback = User::query()->whereKeyNot($user->id)->orderBy('id')->first();

            if ($fallback === null) {
                throw new RuntimeException('Cannot delete the admin user without a fallback author.');
            }

            Blog::withTrashed()
                ->where('created_by_id', $user->id)
                ->update(['created_by_id' => $fallback->id]);

            return;
        }

        Blog::withTrashed()
            ->where('created_by_id', $user->id)
            ->update(['created_by_id' => $admin->id]);
    }
}
