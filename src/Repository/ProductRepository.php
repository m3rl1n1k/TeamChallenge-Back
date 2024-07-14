<?php

namespace App\Repository;

use Core\DB\Model\AbstractModel;
use Core\DB\QueryBuilder\QueryBuilder;
use Core\Exceptions\DuplicateRecordsException;
use Exception;

class ProductRepository extends AbstractModel
{
    public function __construct(protected QueryBuilder $qb)
    {
        $this->table = "products";
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
        $this->setSort($params['sort']);
        $this->setFilter($params['filter']);
        return $this->getChunked();
    }

    public function update($data, $article): bool
    {
        $record = $this->findBy(['article' => $article]);
        $this->recordNotFound($record);
        return $this->qb->update($this->table, $data)->where('article', $article)->save();
    }

    /**
     * @throws DuplicateRecordsException
     * @throws Exception
     */
    public function save(array $data): bool
    {
        if ($this->findBy(['article' => $data['article']])) {
            throw new DuplicateRecordsException("Can't duplicate article {$data['article']}");
        }
        return $this->insert($data);
    }
}