<?php

namespace Verse\Access;

use Verse\User;

interface AccessLevel
{
    public function check(User $user): bool;
}
