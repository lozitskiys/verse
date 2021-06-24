<?php

namespace Verse\Auth;

class AuthRemembered implements Authorized
{
    /**
     * @param string $cookieAuthKey
     * @param string $sessionKey
     * @param string $domain
     * @param int $authPeriodSec Year as default value
     */
    public function __construct(
        private string $cookieAuthKey,
        private string $sessionKey,
        private string $domain = '',
        private int $authPeriodSec = 31536000
    ) {
    }

    public function remember(string $sessionValue, string $cookieValue): void
    {
        $_SESSION[$this->sessionKey()] = $sessionValue;

        setcookie(
            $this->cookieKey(),
            $cookieValue,
            time() + $this->authPeriodSec,
            '/',
            $this->domain,
            null,
            true
        );
    }

    public function forget(): void
    {
        unset($_SESSION[$this->sessionKey()]);

        setcookie($this->cookieKey(), '', time() - 3600, '/', $this->domain);
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
