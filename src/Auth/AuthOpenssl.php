<?php

namespace Verse\Auth;

use Exception;

class AuthOpenssl implements AuthEncrypted
{
    public function __construct(private string $seed, private string $algo, private string $iv)
    {
    }

    public function encrypt(array $secretData): string
    {
        $binHash = openssl_encrypt(
            json_encode($secretData),
            $this->algo,
            $this->seed,
            0,
            $this->iv
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
            $this->algo,
            $this->seed,
            0,
            $this->iv
        );

        return json_decode($str, true) ?? [];
    }
}
