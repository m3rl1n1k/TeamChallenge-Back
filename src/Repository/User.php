<?php

namespace App\Repository;

use App\Core\DB\AbstractModel;

class User extends AbstractModel
{
    public function getUser(string $email)
    {
        return $this->findBy(['email' => $email])->get();
    }
}