<?php

namespace App\Tables;


use App\Core\StupidAR\Table;
use App\Core\StupidAR\TableTrait;

class shirt_table extends Table
{
	protected string $table = "shirt";
	protected array $fields = [
		'article' => 'BIGINT AUTO_INCREMENT PRIMARY KEY',
		'name' => 'VARCHAR(255) NOT NULL',
		'size' => 'JSON NOT NULL',
		'color' => 'VARCHAR(50) NOT NULL',
		'brand' => 'VARCHAR(100) NOT NULL',
		'model' => 'VARCHAR(100) NOT NULL',
		'price' => 'DECIMAL(10, 2) NOT NULL',
		'genre' => 'VARCHAR(50) NOT NULL',
		'description' => 'TEXT NOT NULL',
		'created_at' => 'DATETIME',
		'updated_at' => 'DATETIME'
	];

	use TableTrait;
}