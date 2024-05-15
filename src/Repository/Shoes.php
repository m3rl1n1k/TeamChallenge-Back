<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use App\Core\DB\AbstractModel;
use App\Core\Request;
use Exception;

class Shoes extends AbstractModel
{


    public function __construct(protected QueryBuilder $db,
                                protected Request      $request)
    {
        $this->table = "shoes";
    }

    /**
     * @throws Exception
     */
    public function getAll(array $params = []): false|array|string
    {
        $page = $params['page'];
        $limit = $params['limit'];
        $begin = ($page * $limit) - $limit;
        $this->setLimit($limit);
        $this->setPage($begin);
        $this->setSort($params['sort'] ?? "ASC");
        return $this->findAll();
    }

    /**
     * @throws Exception
     */
    public function oneRecord(int $record)
    {
        return $this->find($record);
    }

    public function save(array $data): bool
    {
        if ($this->find($data['article'])) {
            throw new Exception("Can't duplicate article {$data['article']}");
        }
        return $this->insert($data);
    }

    /**
     * @throws Exception
     */
    public function saveUpdate($data, $article): bool
    {
        return $this->update($data, $article);
    }
}