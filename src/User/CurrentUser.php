<?php

namespace Verse\User;

use Verse\Env;
use Verse\User;

class CurrentUser implements User
{
    public function __construct(private string $cookieKey, private string $sessionKey, private Env $env)
    {
    }

    public function info(): array
    {
        $uidHash = $_COOKIE[$this->cookieKey] ?? '';
        $sessVal = $_SESSION[$this->sessionKey] ?? '';

        if ($sessVal && is_numeric($sessVal)) {
            $user = new UserById($sessVal, $this->env->pdo());
        } elseif ($uidHash) {
            $data = $this->env->auth()->decrypt($uidHash);

            if (isset($data['id'])) {
                $user = new UserById($data['id'], $this->env->pdo());
            } else {
                $user = new Guest();
            }
        } else {
            $user = new Guest();
        }

        return $user->info();
    }
}
