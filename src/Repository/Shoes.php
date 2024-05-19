<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use App\Core\DB\AbstractModel;
use App\Core\Exceptions\BadParameter;
use App\Core\Exceptions\DuplicateRecordsException;
use App\Core\Request;
use DiggPHP\Psr11\NotFoundException;
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
        if ($page)
            $begin = ($page * $limit) - $limit;
        $this->setLimit($limit);
        $this->setPage($begin);
        $this->setSort($params['sort']);
        return $this->findAll();
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

    public function update($data, $id): bool
    {
        $record = $this->findBy(['article' => $id]);
        $this->recordNotFound($record);
        return $this->qb->update($this->table, $data)->where('article', $id)->save();
    }

    public function delete($id)
    {
        $record = $this->findBy(['article' => $id]);
        $this->recordNotFound($record);
        return $this->qb->delete($this->table)->where('article', $id)->get();
    }
}