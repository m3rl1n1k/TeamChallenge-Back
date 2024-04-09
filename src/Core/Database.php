<?php

namespace App\Core;

use PDO;

class Database
{

    private ?PDO $db;

    public function __construct()
    {
        $this->db = ConnectionDB::getInstance();
    }

    public function query(string $sql, array $placeholder = [])
    {
        $data = $this->db->prepare($sql);
        $data->execute($placeholder);
        return $data->columnCount() > 1 ? $data->fetchAll(PDO::FETCH_ASSOC) : $data->fetch(PDO::FETCH_ASSOC);
    }

}