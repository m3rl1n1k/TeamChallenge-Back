<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use Exception;

class Product
{
    public function __construct(protected QueryBuilder $db)
    {
    }

    public function getProductBy(string $table, array $filters = [])
    {
        $limit = $filters['limit'];
        $field = explode('.', $filters['sort']);
        if ($field[1] === "up") {
            $field[1] = "ASC";
        } else {
            $field[1] = "DESC";
        }
        $records = $this->db->select($table, ['*'])->limit($limit)->sort($field[0], $field[1])->getResult();
        foreach ($records as $key => $record) {
            $records[$key]['size'] = json_decode($record['size']);
        }
        return $records;
    }

    public function record(array $data, string $table): int
    {
        return $this->db->insert($table, $data);
    }

    /**
     * @throws Exception
     */
    public function getSingle($article)
    {
        return $this->db->select('shoes', ['*'])->where('article', $article)->getResult();
    }


}