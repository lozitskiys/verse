<?php

namespace Verse\User;

use Exception;
use PDO;
use Verse\User;

/**
 * User by users.login field
 */
class UserByLogin implements User
{
    public function __construct(private string $login, private PDO $db)
    {
    }

    public function info(): array
    {
        $info = $this->db->query("SELECT * FROM `user` WHERE login=" . $this->db->quote($this->login))->fetch();

        if (false === $info) {
            throw new Exception("User with login=$this->login not found");
        }

        return $info;
    }
}
