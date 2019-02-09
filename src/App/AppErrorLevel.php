<?php

namespace Verse\App;

use Verse\Action;
use Verse\App;
use Verse\Env;
use Verse\User;

/**
 * App decorator.
 */
class AppErrorLevel implements App
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function start(Action $action, Env $env, User $user): void
    {
        ini_set('display_errors', (int)$env->devMode());

        $this->app->start($action, $env, $user);
    }
}