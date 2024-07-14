<?php

namespace App\Repository;

use Core\DB\Model\AbstractModel;
use Core\DB\QueryBuilder\QueryBuilder;
use Exception;

class UserRepository extends AbstractModel
{
    protected mixed $user;

    public function __construct(protected QueryBuilder $qb)
    {
        $this->table = 'users';
    }

    /**
     * @throws Exception
     */
    public function getUser(string $email): array
    {
        return $this->findBy(['email' => $email]);
    }

    /**
     * @throws Exception
     */
    function getUserId(string $email): int
    {
        return $this->findBy(['email' => $email])['id'] ?? throw new Exception('User not found');
    }
}