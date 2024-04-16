<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use Exception;

class Shoes
{

    protected ?array $orderBy;
    protected ?int $limit;

    public function __construct(protected QueryBuilder $db)
    {
    }

    /**
     * @throws Exception
     */
    public function getAll()
    {
        $records = $this->db->select("shoes", ['*'])->limit($this->limit)->sort($this->orderBy[0], $this->orderBy[1])->getResult();
        foreach ($records as $key => $record) {
            $records[$key]['size'] = json_decode($record['size']);
        }
        return $records;

    }

    /**
     * @throws Exception
     */
    public function find($id)
    {
        $result = $this->db->select('shoes', ['*'])->where('article', $id)->getResult();
        if (in_array($result['size'], $result)) {
            $result['size'] = json_encode($result['size']);
        }
        return $result;
    }

    public function findBy()
    {

    }

    public function setLimit(mixed $limit): static
    {

        if (is_string($limit))
            $this->limit = null;
        else
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
}