<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use App\Core\DB\AbstractModel;
use App\Core\Exceptions\DuplicateRecordsException;

class User extends AbstractModel
{
    public function __construct(protected QueryBuilder $qb)
    {
        $this->table = 'user';
    }

    public function getUser(string $email)
    {
        $user = $this->findBy(['email' => $email]);
        unset($user['password']);
        return $user;
    }

    public function newUser(array $userData): bool
    {
        if ($this->findBy(['email' => $userData['email']])) {
            throw new DuplicateRecordsException("This email is taken!");
        }
        $userData['role'] = json_encode(['USER_ROLE']);
        return $this->insert($userData);
    }
}