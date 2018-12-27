<?php

namespace Verse\Auth;

interface AuthEncrypted
{
    function encrypt(int $uniqueNumber, string $password): string;

    function decrypt(string $hash): string;
}
