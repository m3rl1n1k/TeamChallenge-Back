<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use App\Core\DB\AbstractModel;

class User extends AbstractModel
{
    public function __construct(protected QueryBuilder $qb)
    {
        $this->table = 'user';
    }

    public function getUser(string $email)
    {
        return $this->findBy(['email' => $email]);
    }
}