<?php

namespace App\Core\DB;

use App\Core\Builder\QueryBuilder;
use App\Core\Interface\ModelInterface;
use DiggPHP\Psr11\NotFoundException;
use Exception;
use Override;

abstract class AbstractModel implements ModelInterface
{
    protected string $table;
    protected ?array $orderBy;
    protected ?int $limit;
    protected QueryBuilder $qb;
    protected ?int $page;


    /**
     * @throws Exception
     */
    public function findAll(): false|array|string
    {
        $records = $this->qb->select($this->table, ['*'])->limit($this->limit, $this->page)->orderBy($this->orderBy[0], $this->orderBy[1])->all();
        foreach ($records as $key => $record) {
            $records[$key]['size'] = json_decode($record['size']);
        }
        return $records;

    }

    public function find($id)
    {
        return $this->qb->select($this->table, ['*'])->where('article', $id)->get();
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
        if ($field[0] === "up") {
            $field[1] = "DESC";
        } else {
            $field[1] = "ASC";
        }
        return $field;
    }

    public function insert(array $data): bool
    {
        return $this->qb->insert($this->table, $data)->save();
    }

    /**
     * @throws Exception
     */
    public function update($data, $id): bool
    {
        return $this->qb->update($this->table, $data)->where('article', $id)->save();
    }

    public function findBy(array $criteria)
    {
        return "Method not realized";
    }

    /**
     * @throws Exception
     */
    public function delete($id)
    {
        return $this->qb->delete($this->table)->where('article', $id)->get();
    }

    public function recordNotFound($record): void
    {
        if (!$record) {
            throw new NotFoundException('Record Not found!');
        }
    }
}