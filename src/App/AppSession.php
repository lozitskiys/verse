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
    public function __construct(
        private App $app,
        private string $sessSavePath = '',
        private string $domain = ''
    ) {
    }

    public function start(Action $action, Env $env, User $user): void
    {
        if (!empty($this->domain)) {
            ini_set('session.cookie_domain', $this->domain);
        }

        session_save_path($this->sessSavePath);
        session_start();

        $this->app->start($action, $env, $user);
    }
}
