<?php

namespace Verse\Access\AccessLevel;

use Verse\Access\AccessLevel;
use Verse\User;

class LevelAuthorized implements AccessLevel {

    public function check(User $user): bool
    {
        return !empty($user->info());
    }
}
