<?php

namespace App\Repository;

use App\Core\Builder\QueryBuilder;
use Exception;

class Product
{
    public function __construct(protected QueryBuilder $db)
    {
    }

    public function getProductByType(string $type)
    {
        return $this->db->select($type, ['*'])->getResult();
    }

    public function record(array $data, string $table): int
    {
        return 0;
    }

    /**
     * @throws Exception
     */
    public function getSingle($article)
    {
        return $this->db->select('shoes', ['*'])->where('article', $article)->getResult();
    }


}