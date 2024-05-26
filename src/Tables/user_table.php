<?php

namespace App\Tables;

use App\Core\StupidAR\AbstractTable;
use App\Core\StupidAR\TableTrait;

class user_table extends AbstractTable
{
    protected string $table = "user";
    protected array $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'first name' => 'VARCHAR(255)',
        'last name' => 'VARCHAR(255)',
        'address' => 'VARCHAR(255)',
        'city' => 'VARCHAR(255)',
        'state' => 'VARCHAR(255)',
        'zip code' => 'VARCHAR(10)',
        'phone' => 'VARCHAR(20)'
    ];
    
    use TableTrait;
}