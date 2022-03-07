<?php

namespace Verse\Access\AccessLevel;

use Verse\Access\AccessLevel;
use Verse\Access\Role;
use Verse\User;

class LevelAdmin implements AccessLevel
{
    public function check(User $user): bool
    {
        return in_array($user->info()['role'], [Role::ADMIN, Role::DEVELOPER]);
    }
}
