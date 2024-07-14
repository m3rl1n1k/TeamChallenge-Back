<?php

namespace App\Tables;

use Core\StupidAR\Table;
use Core\StupidAR\TableTrait;

class Orders_table extends Table
{
    protected string $table = "orders";
    protected array $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'user_id' => 'INT NOT NULL',
        'total_price' => 'INT NOT NULL',
        'status' => 'INT NOT NULL DEFAULT 0',
        'payment_method' => 'int not null',
        'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
        'CONSTRAINT FK_UserID FOREIGN KEY (user_id) REFERENCES users(id)'
    ];

    use TableTrait;
}