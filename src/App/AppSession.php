<?php

namespace Verse\App;

use Verse\Action;
use Verse\App;
use Verse\Env;
use Verse\User;

/**
 * Application with session support.
 *
 * App decorator.
 */
class AppSession implements App
{
    public function __construct(private App $app)
    {
    }

    public function start(Action $action, Env $env, User $user): void
    {
        session_save_path($env->siteRoot() . "/sessions");
        session_start();

        $this->app->start($action, $env, $user);
    }
}
