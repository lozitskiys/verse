<?php

namespace Verse\Auth;

class AuthOpenssl implements AuthEncrypted
{
    private $seed;
    private $method;
    private $credentialsSeparator;

    public function __construct(
        string $seed,
        string $method = 'bf-ecb',
        string $credentialsSeparator = '|'
    ) {
        $this->seed = $seed;
        $this->method = $method;
        $this->credentialsSeparator = $credentialsSeparator;
    }

    public function encrypt(int $uniqueNumber, string $password): string
    {
        $binHash = openssl_encrypt(
            $uniqueNumber . $this->credentialsSeparator . $password,
            $this->method,
            $this->seed,
            true
        );

        return bin2hex($binHash);
    }

    /**
     * @param string $hash
     * @return string
     * @throws \Exception
     */
    public function decrypt(string $hash): string
    {
        $str = openssl_decrypt(
            pack("H*", $hash),
            $this->method,
            $this->seed,
            true
        );

        $credentials = explode($this->credentialsSeparator, $str);
        if (empty($credentials) || count($credentials) != 2) {
            throw new \Exception("Error decrypting auth information");
        }

        return $credentials[1];
    }
}
