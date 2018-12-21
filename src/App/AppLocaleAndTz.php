<?php

namespace Verse\App;

use Verse\Action;
use Verse\App;
use Verse\Env;

/**
 * Application with timezone configured.
 *
 * AppStd decorator.
 */
class AppLocaleAndTz implements App
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function start(Action $action, Env $env): void
    {
        setlocale(LC_NUMERIC, 'C');

        ini_set('date.timezone', 'Etc/GMT-3');

        umask(0002);

        $this->app->start($action, $env);
    }
}