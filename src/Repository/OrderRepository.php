<?php

namespace App\Repository;

use Core\DB\Model\AbstractModel;
use Core\DB\QueryBuilder\QueryBuilder;
use Exception;

class OrderRepository extends AbstractModel
{

    public function __construct(protected QueryBuilder $qb)
    {
        $this->table = 'orders';
    }

    /**
     * @throws Exception
     */
    public function save($product): void
    {
        $this->insert($product);
    }

    public function getLastInsertId(): int
    {
        return $this->qb()->pdo()->lastInsertId();
    }
}