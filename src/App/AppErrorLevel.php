<?php

namespace Verse\App;

use Verse\Action;
use Verse\App;
use Verse\Env;

class AppErrorLevel implements App
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function start(Action $action, Env $env): void
    {
        ini_set('display_errors', (int)$env->debug());

        $this->app->start($action, $env);
    }
}