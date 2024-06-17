<?php

namespace App\Tables;


use Core\StupidAR\Table;
use Core\StupidAR\TableTrait;

class Product_table extends Table
{
	protected string $table = "product";
	protected array $fields = [
		'article' => 'BIGINT AUTO_INCREMENT PRIMARY KEY',
		'quantity' => 'INT',
		'type' => 'VARCHAR(100) NOT NULL',
		'name' => 'VARCHAR(255) NOT NULL',
		'size' => 'JSON NOT NULL',
		'color' => 'VARCHAR(50) NOT NULL',
		'brand' => 'VARCHAR(100) NOT NULL',
		'model' => 'VARCHAR(100) NOT NULL',
		'price' => 'DECIMAL(10, 2) NOT NULL',
		'genre' => 'VARCHAR(50) NOT NULL',
		'description' => 'TEXT NOT NULL',
		'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
		'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
	];

	use TableTrait;
}