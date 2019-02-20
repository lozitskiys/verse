<?php

namespace Verse\App;

use Verse\Action;
use Verse\App;
use Verse\Auth\AuthEncrypted;
use Verse\Auth\Authorized;
use Verse\Env;
use Verse\User;

/**
 * Application with authenticated user.
 *
 * App decorator.
 */
class AppAuthBySessionCookie implements App
{
    private $app;
    private $authorized;

    public function __construct(
        App $app,
        Authorized $authorized
    ) {
        $this->app = $app;
        $this->authorized = $authorized;
    }

    public function start(Action $action, Env $env, User $user): void
    {
        $this->tryToAuthenticateUser($env->auth(), $user);

        $this->app->start($action, $env, $user);
    }

    private function tryToAuthenticateUser(AuthEncrypted $auth, User $user): void
    {
        if (isset($_SESSION[$this->authorized->sessionKey()])) {
            return;
        }

        if (!isset($_COOKIE[$this->authorized->cookieKey()])) {
            return;
        }

        try {
            $password = $auth->decrypt($_COOKIE[$this->authorized->cookieKey()]);

            $userInfo = $user->info();
        } catch (\Throwable $e) {
            return;
        }

        if (!isset($userInfo['password'])) {
            return;
        }

        if ($userInfo['password'] === $password) {
            $this->authorized->remember(
                $userInfo['login'],
                $auth->encrypt($userInfo['id'], $userInfo['password'])
            );
        }
    }
}