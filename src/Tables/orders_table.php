<?php


use App\Core\StupidAR\Table;
use App\Core\StupidAR\TableTrait;

class orders_table extends Table
{
	protected string $table = "orders";
	protected array $fields = [
		'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
		'created_at' => 'DATETIME',
		'updated_at' => 'DATETIME'
	];

	use TableTrait;
}