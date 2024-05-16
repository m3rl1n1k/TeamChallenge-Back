<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use App\Core\DB\AbstractModel;
use App\Core\Exceptions\BadParameter;
use App\Core\Request;
use Exception;

class Shoes extends AbstractModel
{
    public function __construct(protected QueryBuilder $qb)
    {
        $this->table = "shoes";
    }

    /**
     * @throws Exception
     */
    public function getAll(array $params = []): false|array|string
    {
        $page = $params['page'] ?? 1;
        $limit = $params['limit'];
        $begin = ($page * $limit) - $limit;
        $this->setLimit($limit);
        $this->setPage($begin);
        $this->setSort($params['sort']);
        return $this->findAll();
    }

    public function save(array $data): bool
    {
        if ($this->find($data['article'])) {
            throw new Exception("Can't duplicate article {$data['article']}");
        }
        return $this->insert($data);
    }
}