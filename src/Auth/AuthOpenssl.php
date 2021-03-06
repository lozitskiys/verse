<?php

namespace Verse\Auth;

use Exception;

class AuthOpenssl implements AuthEncrypted
{
    public function __construct(private string $seed, private string $method = 'bf-ecb')
    {
    }

    public function encrypt(array $secretData): string
    {
        $binHash = openssl_encrypt(
            json_encode($secretData),
            $this->method,
            $this->seed,
            true
        );

        return bin2hex($binHash);
    }

    /**
     * @param string $hash
     * @return array
     * @throws Exception
     */
    public function decrypt(string $hash): array
    {
        $str = openssl_decrypt(
            pack("H*", $hash),
            $this->method,
            $this->seed,
            true
        );

        return json_decode($str, true) ?? [];
    }
}
