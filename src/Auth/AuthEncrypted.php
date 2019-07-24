<?php

namespace Verse\Auth;

interface AuthEncrypted
{
    public function encrypt(int $uniqueNumber, string $password): string;

    public function decrypt(string $hash): string;
}
