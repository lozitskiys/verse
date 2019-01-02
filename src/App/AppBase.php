<?php

namespace Verse\App;

use Verse\Action;
use Verse\App;
use Verse\Env;
use Verse\User;

/**
 * Base application.
 *
 * Project entry point.
 */
class AppBase implements App
{
    public function start(Action $action, Env $env, User $user): void
    {
        $resp = $action->run($env, $user);

        foreach ($resp->headers() as $h) {
            header($h);
        }

        echo $resp->body();
    }
}