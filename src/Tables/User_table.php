<?php

namespace App\Tables;


use Core\StupidAR\Table;
use Core\StupidAR\TableTrait;

class User_table extends Table
{
	protected string $table = "user";
	protected array $fields = [
		'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
		'email' => 'VARCHAR(255) NOT NULL',
		'password' => 'VARCHAR(255) NOT NULL',
		'first name' => 'VARCHAR(255)',
		'last name' => 'VARCHAR(255)',
		'address' => 'VARCHAR(255)',
		'city' => 'VARCHAR(255)',
		'state' => 'VARCHAR(255)',
		'zip code' => 'VARCHAR(10)',
		'phone' => 'VARCHAR(20)',
		'role' => 'JSON'
	];

	use TableTrait;
}