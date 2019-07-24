<?php

namespace Verse\Auth;

interface Authorized
{
    public function remember(string $sessionValue, string $cookieValue): void;

    public function forget(): void;

    public function cookieKey(): string;

    public function sessionKey(): string;
}
