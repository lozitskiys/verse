<?php

namespace Verse\User;

use Exception;
use PDO;
use Verse\User;

/**
 * User by users.code field
 */
class UserByCode implements User
{
    public function __construct(private string $code, private PDO $db)
    {
    }

    public function info(): array
    {
        $info = $this->db->query("SELECT * FROM `user` WHERE `code`=" . $this->db->quote($this->code))->fetch();

        if (false === $info) {
            throw new Exception("User with code=$this->code not found");
        }

        return $info;
    }
}
