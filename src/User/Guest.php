<?php

namespace Verse\User;

use Verse\User;

class Guest implements User
{
    public function info(): array
    {
        return [];
    }
}