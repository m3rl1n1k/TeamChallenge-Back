<?php

namespace App\Core\DB;

use App\Core\Builder\QueryBuilder;
use DiggPHP\Psr11\NotFoundException;
use Exception;

class AbstractModel
{
    protected string $table;
    protected ?array $orderBy;
    protected ?int $limit;
    protected QueryBuilder $db;


    /**
     * @throws Exception
     */
    public function findAll(): false|array|string
    {
        $records = $this->db->select($this->table, ['*'])->limit($this->limit)->orderBy($this->orderBy[0], $this->orderBy[1])->all();
        foreach ($records as $key => $record) {
            $records[$key]['size'] = json_decode($record['size']);
        }
        return $records;

    }

    /**
     * @throws Exception
     */
    public function find($article)
    {
        $result = $this->db->select($this->table, ['*'])->where('article', $article)->get();
        if (!is_bool($result) && in_array($result['size'], $result)) {
            $result['size'] = json_encode($result['size']);
        }
        if (!$result) {
            throw new NotFoundException('Product not found!');
        }
        return $result;
    }

    /**
     * @throws Exception
     */
    public function findBy(array $conditions)
    {
        $select = $this->db->select($this->table, ['*']);
        foreach ($conditions as $key => $condition) {
            $select = $select->where($key, $condition);
        }
        dd($select);

    }

    public function setLimit(int $limit): static
    {

//        if (is_string($limit))
//            $this->limit = null;
//        else
        $this->limit = $limit;
        return $this;
    }

    public function setSort(string $orderBy): static
    {
        $this->orderBy = $this->orderPrepare($orderBy);
        return $this;
    }

    protected function orderPrepare(string $sort): array
    {
        $field = explode('.', $sort);
        if ($field[1] === "up") {
            $field[1] = "ASC";
        } else {
            $field[1] = "DESC";
        }
        return $field;
    }

    public function insert(array $data): bool
    {
        return $this->db->insert($this->table, $data);
    }
}