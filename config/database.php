<?php
return [
	'data_mapper' => [
		"db_connection" => [
			'dbname' => 'team',
			'user' => 'm3rl1n1k',
			'password' => 'm3rl1n1k',
			'driver' => 'pdo_mysql',
			'host' => 'mysql',
			'port' => 3306
		],
		'dev_mode' => true,
		"entity_path" => [
			ROOT . "src/Entity"
		]
	]
];