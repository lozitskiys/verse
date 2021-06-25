<?php

namespace Verse\User;

use Exception;
use PDO;
use Verse\User;

/**
 * User by users.id field
 */
class UserById implements User
{
    public function __construct(private int $id, private PDO $db)
    {
    }

    public function info(): array
    {
        $info = $this->db->query("SELECT * FROM `user` WHERE id=$this->id")->fetch();

        if (false === $info) {
            throw new Exception("User with id=$this->id not found");
        }

        return $info;
    }
}
