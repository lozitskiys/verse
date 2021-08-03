<?php

namespace Verse\Access\AccessLevel;

use Verse\Access\AccessLevel;
use Verse\User;

class LevelAdmin implements AccessLevel
{
    public function __construct(private string $adminRoleName = 'owner')
    {
    }

    public function check(User $user): bool
    {
        return $this->adminRoleName === $user->info()['role'];
    }
}
