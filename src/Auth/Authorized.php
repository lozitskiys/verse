<?php

namespace Verse\Auth;

interface Authorized
{
    function remember(string $sessionValue, string $cookieValue): void;

    function forget(): void;

    function cookieKey(): string;

    function sessionKey(): string;
}
