<?php

namespace Verse\Access;

use Verse\User;

interface AccessLevel
{
    function check(User $user): bool;
}
