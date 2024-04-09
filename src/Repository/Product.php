<?php

namespace App\Repository;

use App\Core\Database;

class Product
{
    public function __construct(protected Database $db)
    {
    }

    public function getProductFrom(string $type)
    {
        $sql = "select * from $type";
        $products = $this->db->query($sql);

        return !empty($products) ? $products : "Not found any product!";
    }
}