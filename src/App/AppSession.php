<?php

namespace Verse\App;

use Verse\Action;
use Verse\App;
use Verse\Env;

class AppSession implements App
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function start(Action $action, Env $env): void
    {
        session_save_path($env->siteRoot() . "/sessions");
        session_start();

        $this->app->start($action, $env);
    }
}