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
    protected ?int $page;


    /**
     * @throws Exception
     */
    public function findAll(): false|array|string
    {
        $records = $this->db->select($this->table, ['*'])->limit($this->limit, $this->page)->orderBy($this->orderBy[0], $this->orderBy[1])->all();
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
        return $this->db->select($this->table, ['*'])->where('article', $article)->get();
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
        $this->limit = $limit;
        return $this;
    }

    public function setPage(int $page): static
    {
        $this->page = $page;
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

    /**
     * @throws Exception
     */
    public function update($data, $article): bool
    {
        return $this->db->update($this->table, $data)->where('article', $article)->save();
    }
}