<?php

namespace Verse\Auth;

class AuthRemembered implements Authorized
{
    private $cookieAuthKey;
    private $sessionKey;
    private $authPeriodSec;

    /**
     * @param string $cookieAuthKey
     * @param string $sessionKey
     * @param int $authPeriodSec Year as default value
     */
    public function __construct(
        string $cookieAuthKey,
        string $sessionKey,
        int $authPeriodSec = 31536000
    ) {
        $this->cookieAuthKey = $cookieAuthKey;
        $this->sessionKey = $sessionKey;
        $this->authPeriodSec = $authPeriodSec;
    }

    public function remember(string $sessionValue, string $cookieValue): void
    {
        $_SESSION[$this->sessionKey()] = $sessionValue;

        setcookie(
            $this->cookieKey(),
            $cookieValue,
            time() + $this->authPeriodSec,
            '/',
            null,
            null,
            true
        );
    }

    public function forget(): void
    {
        unset($_SESSION[$this->sessionKey()]);

        setcookie($this->cookieKey(), '', time() - 3600, '/');
    }

    public function cookieKey(): string
    {
        return $this->cookieAuthKey;
    }

    public function sessionKey(): string
    {
        return $this->sessionKey;
    }
}
