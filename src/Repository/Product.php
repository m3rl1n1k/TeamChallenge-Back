<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use Exception;

class Product
{
    public function __construct()
    {
    }

    public function getProductBy(string $table, array $filters = [])
    {
        $limit = $filters['limit'];
        $field = $this->orderPrepare($filters['sort']);
        $records = $this->db->select($table, ['*'])->limit($limit)->sort($field[0], $field[1])->getResult();
        foreach ($records as $key => $record) {
            $records[$key]['size'] = json_decode($record['size']);
        }
        return $records;
    }

    public function record(array $data, string $table): int
    {
        if (in_array($data['size'], $data)) {
            $data['size'] = json_encode($data['size']);
        }
        return $this->db->insert($table, $data);
    }

    /**
     * @throws Exception
     */
    public function getSingle($article)
    {
        $result = $this->db->select('shoes', ['*'])->where('article', $article)->getResult();
        if (in_array($result['size'], $result)) {
            $result['size'] = json_encode($result['size']);
        }
        return $result;
    }


}