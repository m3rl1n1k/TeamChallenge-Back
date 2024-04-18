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

    public function query(string $sql): false|PDOStatement
    {
        $data = $this->db->prepare($sql);
        $data->execute();
        return $data;
    }

    public function prepare(string $sql): false|PDOStatement
    {
        return $this->db->prepare($sql);
    }

}