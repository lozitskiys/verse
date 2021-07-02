<?php

namespace Verse\App;

use Throwable;
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
    public function __construct(
        private App $app,
        private Authorized $authorized
    ) {
    }

    public function start(Action $action, Env $env, User $user): void
    {
        $this->tryToAuthenticateUser($env->auth(), $user);

        $this->app->start($action, $env, $user);
    }

    private function tryToAuthenticateUser(AuthEncrypted $auth, User $user): void
    {
        if (!isset($_COOKIE[$this->authorized->cookieKey()])) {
            return;
        }

        try {
            $data = $auth->decrypt($_COOKIE[$this->authorized->cookieKey()]);

            $userInfo = $user->info();
        } catch (Throwable) {
            return;
        }

        if (!isset($userInfo['id']) || !isset($data['id'])) {
            return;
        }

        if ($userInfo['id'] === $data['id']) {
            $this->authorized->remember(
                $userInfo['id'],
                $auth->encrypt([
                    'id' => $userInfo['id'],
                    'password' => $userInfo['password'],
                    'code' => $userInfo['code']
                ])
            );
        }
    }
}
