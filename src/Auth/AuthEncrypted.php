<?php

namespace Verse\Auth;

interface AuthEncrypted
{
    /**
     * @param array[string|int] $secretData
     * @return string
     */
    public function encrypt(array $secretData): string;

    public function decrypt(string $hash): array;
}
