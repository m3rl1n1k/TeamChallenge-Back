<?php

namespace App\Core;

use PDO;

class ConnectionDB
{

    private static ?PDO $dbInstance = null;

    // Prevent from creating instance
    private function __construct()
    {

    }

    // Prevent cloning the object
    private function __clone()
    {

    }

    public static function getInstance(): ?PDO
    {
        // Check if database is null
        if (self::$dbInstance === null) {
            // Create a new PDO connection
            $port = Config::getValue('database.port');
            $host = Config::getValue('database.host');
            $db = Config::getValue('database.db_name');
            $user = Config::getValue('database.user');
            $password = Config::getValue('database.password');
            $dsn = "mysql:host=$host;dbname=$db;port=$port";

            self::$dbInstance = new PDO($dsn, $user, $password,);
        }
        return self::$dbInstance;
    }
}