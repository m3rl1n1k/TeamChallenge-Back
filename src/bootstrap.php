<?php

use App\Core\Config;

require_once ROOT . "vendor/autoload.php";

Config::instance(
	array_merge([
			'database' => require_once ROOT . "config/database.php",
			'route' => require_once ROOT . 'src/Route/route.php'
		]
	)
);