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
    public function getAll(array $params = []): false|array|string
    {
        $this->setLimit($params['limit']);
        $this->setSort($params['sort']);
        return $this->findAll();
    }

    /**
     * @throws Exception
     */
    public function oneRecord(int $record)
    {
        return $this->find($record);
    }

    /**
     * @throws Exception
     */
    public function save(array $data): bool
    {
        if ($this->find($data['article'])) {
            throw new Exception("Can't duplicate article {$data['article']}");
        }
        return $this->insert($data);
    }
}