<?php

namespace App\Core;

use PDO;
use PDOStatement;

class Database
{

    private ?PDO $db;

    public function __construct()
    {
        $this->db = ConnectionDB::getInstance();
    }

    public function query(string $sql)
    {
        $data = $this->db->prepare($sql);
        $data->execute();
        return $data->columnCount() > 1 ? $data->fetchAll(PDO::FETCH_ASSOC) : $data->fetch(PDO::FETCH_ASSOC);
    }

    public function prepare(string $sql): false|PDOStatement
    {
        return $this->db->prepare($sql);
    }

}