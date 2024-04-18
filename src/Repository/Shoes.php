<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use App\Core\DB\AbstractModel;
use Exception;

class Shoes extends AbstractModel
{


    public function __construct(protected QueryBuilder $db)
    {
        $this->table = "shoes";
    }

    /**
     * @throws Exception
     */
    public function getAll(): false|array|string
    {
        return $this->findAll();
    }

    public function oneRecord(int $record)
    {
        return $this->find($record);
    }

    public function save($request): bool
    {
        return $this->insert($request);
    }
}